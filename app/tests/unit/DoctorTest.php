<?php

use Doctors\Doctor;
use Zizaco\FactoryMuff\FactoryMuff;
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
    * This function uses factory muff to put entries in the DB. 
    * @param string $modelName name of model class you'd like to insert
    * @param int $num number of records to seed in DB
    * @param array $fixedAttributes array of associative arrays of attribtues to manually set for DB entries.
    */
    private function seedDB($modelName, $num, array $fixedAttributes = array()) {
        $factory = new FactoryMuff();
        for ($i = 0; $i < $num; $i++) {
            if (isset($fixedAttributes[$i])) {
                $factory->create($modelName, $fixedAttributes[$i]);
            } else {
                $factory->create($modelName);
            }
        }
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
        $this->seedDB('\App\Models\Doctor', 3, $doctorNames);
        $doctor = new Doctor();
        $doctorList = $doctor->getDoctors();
        $this->assertCount(3, $doctorList);        }

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
        $this->seedDB('\App\Models\Doctor', 3, $doctorNames);
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
        $this->seedDB('\App\Models\Doctor', 3, $doctorNames);
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
        $this->seedDB('\App\Models\Doctor', 3, $doctorNames);
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