<?php

require_once __DIR__ . '/TestHelper.php';
use Ratings\RatingCalculator;

/**
 * Tests for classes that implement ratings/RatingCalculator
 */

class RatingCalculatorTest extends TestCase {

    public function setUp() {
        parent::setUp();
    }

    public function tearDown() {
        Mockery::close();
    }

    private function migrateDB() {
        Artisan::call('migrate:install');
        Artisan::call('migrate', array('--package' => 'cartalyst/sentry'));
        Artisan::call('migrate');
    }

    public function testGetCombinedAverageDoctorHasNoRatings() {
        $mockEntity = Mockery::mock('\App\Models\Doctor');
        $mockRating = Mockery::mock('\App\Models\DoctorRating');
        $mockEntity->shouldReceive('ratings->get->toArray')
            ->andReturn(array());
        $rating = new RatingCalculator($mockEntity, $mockRating);
        $actual = $rating->getCombinedAverage();
        $this->assertNull($actual);
    }
    public function testGetCombinedAverageWithPartialRatings() {
        $mockEntity = Mockery::mock('\App\Models\Doctor');
        $mockRating = Mockery::mock('\App\Models\DoctorRating');
        $mockEntity->shouldReceive('ratings->get->toArray')
            ->andReturn(array(
                array('field_1' => 3, 'field_2' => 5),
                array('field_1' => null, 'field_2' => 1)
            ));
        $mockRating->shouldReceive('getRatableFields')
            ->andReturn(array('field_1', 'field_2'));
        $rating = new RatingCalculator($mockEntity, $mockRating);
        $actual = $rating->getCombinedAverage();
        $this->assertEquals(3, $actual);
    }

    public function testGetCombinedAverageSuccess() {
        $mockEntity = Mockery::mock('\App\Models\Doctor');
        $mockRating = Mockery::mock('\App\Models\DoctorRating');
        $mockEntity->shouldReceive('ratings->get->toArray')
            ->andReturn(array(
                array('field_1' => 3, 'field_2' => 5),
                array('field_1' => 4, 'field_2' => 1)
            ));
        $mockRating->shouldReceive('getRatableFields')
            ->andReturn(array('field_1', 'field_2'));
        $rating = new RatingCalculator($mockEntity, $mockRating);
        $actual = $rating->getCombinedAverage();
        $this->assertEquals(3, $actual);
    }

    /**
     * Case where one of the ratings fields only has null values
     */
    public function testGetRatingsByFieldFieldNoValues() {
        $mockEntity = Mockery::mock('\App\Models\Doctor');
        $mockRating = Mockery::mock('\App\Models\DoctorRating');
        $mockRating->shouldReceive('getRatableFields')
            ->andReturn(array('field_1', 'field_2'));
        $mockEntity->shouldReceive('ratings->get->toArray')
            ->andReturn(array(
                array('field_1' => null, 'field_2' => 4),
                array('field_1' => null, 'field_2' => 2)
            ));

        $expected = array(
            'field_1' => null,
            'field_2' => 3
        );
        $rating = new RatingCalculator($mockEntity, $mockRating);
        $actual = $rating->getAverageRatingByField();
        $this->assertEquals($expected, $actual);
    }

    /**
     * Case where a doctor has no ratings
     */
    public function testGetRatingsByFieldNoRatings() {
        $mockEntity = Mockery::mock('\App\Models\Doctor');
        $mockRating = Mockery::mock('\App\Models\DoctorRating');
        $mockRating->shouldReceive('getRatableFields')
            ->andReturn(array('field_1', 'field_2'));
        $mockEntity->shouldReceive('ratings->get->toArray')
            ->andReturn(array());

        $expected = array(
            'field_1' => null,
            'field_2' => null
        );
        $rating = new RatingCalculator($mockEntity, $mockRating);
        $actual = $rating->getAverageRatingByField();
        $this->assertEquals($expected, $actual);
    }
    public function testGetRatingsByFieldSuccess() {
        $mockEntity = Mockery::mock('\App\Models\Doctor');
        $mockRating = Mockery::mock('\App\Models\DoctorRating');
        $mockRating->shouldReceive('getRatableFields')
            ->andReturn(array('field_1', 'field_2'));
        $mockEntity->shouldReceive('ratings->get->toArray')
            ->andReturn(array(
                array('field_1' => 5, 'field_2' => 4),
                array('field_1' => 2, 'field_2' => 2)
            ));

        $expected = array(
            'field_1' => 4,
            'field_2' => 3
        );
        $rating = new RatingCalculator($mockEntity, $mockRating);
        $actual = $rating->getAverageRatingByField();
        $this->assertEquals($expected, $actual);
    }

    public function testGetRatingsCountSuccess() {
        $mockEntity = Mockery::mock('\App\Models\Doctor');
        $mockRating = Mockery::mock('\App\Models\DoctorRating');
        $mockEntity->shouldReceive('ratings->get->count')
            ->once()
            ->andReturn(100);
        $rating = new RatingCalculator($mockEntity, $mockRating);
        $actual = $rating->getRatingCount();
        $this->assertEquals(100, $actual);
    }
}