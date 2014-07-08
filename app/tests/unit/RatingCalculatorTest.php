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
        $mockEntity->shouldReceive('ratings->first->getRatableFields')
            ->andReturn(array('field_1', 'field_2'));
        $mockEntity->shouldReceive('ratings->get->toArray')
            ->andReturn(array());
        $rating = new RatingCalculator($mockEntity);
        $actual = $rating->getCombinedAverage();
        $this->assertNull($actual);
    }
    public function testGetCombinedAverageWithPartialRatings() {
        $mockEntity = Mockery::mock('\App\Models\Doctor');
        $mockEntity->shouldReceive('ratings->first->getRatableFields')
            ->andReturn(array('field_1', 'field_2'));
        $mockEntity->shouldReceive('ratings->get->toArray')
            ->andReturn(array(
                array('field_1' => 3, 'field_2' => 5),
                array('field_1' => null, 'field_2' => 1)
            ));
        $rating = new RatingCalculator($mockEntity);
        $actual = $rating->getCombinedAverage();
        $this->assertEquals(3, $actual);
    }

    public function testGetCombinedAverageSuccess() {
        $mockEntity = Mockery::mock('\App\Models\Doctor');
        $mockEntity->shouldReceive('ratings->first->getRatableFields')
            ->andReturn(array('field_1', 'field_2'));
        $mockEntity->shouldReceive('ratings->get->toArray')
            ->andReturn(array(
                array('field_1' => 3, 'field_2' => 5),
                array('field_1' => 4, 'field_2' => 1)
            ));
        $rating = new RatingCalculator($mockEntity);
        $actual = $rating->getCombinedAverage();
        $this->assertEquals(3, $actual);
    }

    /**
     * Case where one of the ratings fields only has null values
     */
    public function testGetRatingsByFieldFieldNoValues() {
        $mockEntity = Mockery::mock('\App\Models\Doctor');
        $mockEntity->shouldReceive('ratings->first->getRatableFields')
            ->andReturn(array('field_1', 'field_2'));
        $mockEntity->shouldReceive('ratings->get->avg')
            ->twice()
            ->andReturn(null, 3);
        $expected = array(
            'field_1' => null,
            'field_2' => 3
        );
        $rating = new RatingCalculator($mockEntity);
        $actual = $rating->getAverageRatingByField();
        $this->assertEquals($expected, $actual);
    }

    public function testGetRatingsByFieldSuccess() {
        $mockEntity = Mockery::mock('\App\Models\Doctor');
        $mockEntity->shouldReceive('ratings->first->getRatableFields')
            ->andReturn(array('field_1', 'field_2'));
        $mockEntity->shouldReceive('ratings->get->avg')
            ->twice()
            ->andReturn(4, 3);
        $expected = array(
            'field_1' => 4,
            'field_2' => 3
        );
        $rating = new RatingCalculator($mockEntity);
        $actual = $rating->getAverageRatingByField();
        $this->assertEquals($expected, $actual);
    }

    public function testGetRatingsCountSuccess() {
        $mockEntity = Mockery::mock('\App\Models\Doctor');
        $mockEntity->shouldReceive('ratings->get->count')
            ->once()
            ->andReturn(100);
        $rating = new RatingCalculator($mockEntity);
        $actual = $rating->getRatingCount();
        $this->assertEquals(100, $actual);
    }
}