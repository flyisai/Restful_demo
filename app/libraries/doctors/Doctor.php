<?php namespace doctors;

/**
* This is the class for getting and changing information about doctors
*/

class Doctor {

    /**
    * Returns a list of doctors based on criterion in query. If no query is provided, then all doctors are returned.
    * @param array $query
    * @return array of doctors
    */
    public function getDoctors(array $queryParams=array()) {
        $doctors = \App::make('\App\Models\Doctor');
        if (!empty($queryParams['name'])) {
            $namePieces = explode(' ', $queryParams['name']);
            if (in_array(strtolower($namePieces[0]), array('dr', 'dr.'))) { // People and doctors may put this in their name -- including it in search would be silly
                array_shift($namePieces);
            }
            $hasWhere = false;
            foreach ($namePieces as $piece) {
                if (!$hasWhere) {
                    $doctors = $doctors->where('name', 'LIKE', "%{$piece}%");
                    $hasWhere = true;
                } else {
                    $doctors = $doctors->orWhere('name', 'LIKE', "%{$piece}%");
                }
            }
        }
        if (!empty($queryParams['speciality'])) {
            $doctors = $doctors->where('speciality', $queryParams['speciality']);
        }

        return $doctors->get();
    }

    /**
    * Returns list of all specialities and their display names 
    * @return array in format 'specality_in_db' => 'speciality_display_name'
    */
    public function getAllSpecialities() {
        return array( // @TODO get full list of these from Lenard. Probably store them in external file for cleanliness
            'internist' => 'Internist',
            'dentist' => 'Dentist'
        );
    }

}