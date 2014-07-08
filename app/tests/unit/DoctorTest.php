<?php

require_once __DIR__ . '/TestHelper.php';
use Doctors\Doctor;
/**
* Tests for Doctors\Doctor
*/

class DoctorTest extends TestCase {

    public function setUp() {
        parent::setUp();
    }   

    public function tearDown() {

    }

    private function migrateDB() {
        Artisan::call('migrate:install');
        Artisan::call('migrate', array('--package' => 'cartalyst/sentry'));        
        Artisan::call('migrate');
    }

    /**
    * Case with no search critereon
    */
    public function testGetDoctorsAll() {
        $this->migrateDB();
        $doctorNames = array(
            array('name' => 'Cool guy'),
            array('name' => 'Bad guy'),
            array('name' => 'Sour Portent')
        );
        TestHelper::seedDB('\App\Models\Doctor', 3, $doctorNames);
        $doctor = new Doctor();
        $doctorList = $doctor->getDoctors();
        $this->assertCount(3, $doctorList);
    }

    /**
    * Case where we're getting doctor by name
    */
    public function testGetDoctorsByName() {
        $this->migrateDB();
        $doctorNames = array(
            array('name' => 'Cool guy'),
            array('name' => 'Bad guy'),
            array('name' => 'Sour Portent')
        );
        TestHelper::seedDB('\App\Models\Doctor', 3, $doctorNames);
        $queryParams = array('name' => 'guy');
        $doctor = new Doctor();
        $doctorList = $doctor->getDoctors($queryParams);
        $this->assertCount(2, $doctorList);    
    }

    /**
    * Case where we're getting doctor by speciality
    */
    public function testGetDoctorsBySpeciality() {
        $this->migrateDB();
        $doctorNames = array(
            array(
                'name' => 'Cool guy',
                'speciality' => 'internist'
            ),
            array( 
                'name' => 'Bad guy',
                'speciality' => 'internist'                
            ),
            array(
                'name' => 'Sour Portent',
                'speciality' => 'dentist'                
            )
        );
        TestHelper::seedDB('\App\Models\Doctor', 3, $doctorNames);
        $queryParams = array('speciality' => 'dentist');
        $doctor = new Doctor();
        $doctorList = $doctor->getDoctors($queryParams);
        $this->assertCount(1, $doctorList);      
    }

    /** 
    * Case where we're using multiple critereon to search for business
    */
    public function testGetDoctorsByMultipleCritereon() {
        $this->migrateDB();
        $doctorNames = array(
            array(
                'name' => 'Cool guy',
                'speciality' => 'internist'
            ),
            array( 
                'name' => 'Bad guy',
                'speciality' => 'internist'                
            ),
            array(
                'name' => 'Sour Portent',
                'speciality' => 'dentist'                
            )
        );
        TestHelper::seedDB('\App\Models\Doctor', 3, $doctorNames);
        $queryParams = array(
            'name' => 'cool',
            'speciality' => 'internist'
        );
        $doctor = new Doctor();
        $doctorList = $doctor->getDoctors($queryParams);
        $this->assertCount(1, $doctorList);     
    }

    /**
    * getAllSpecialities success
    */
    public function testGetAllSpecialitiesSuccess() {
        $doctor = new Doctor();
        $specialities = $doctor->getAllSpecialities();
        $this->assertInternalType('array', $specialities);      
    }
}