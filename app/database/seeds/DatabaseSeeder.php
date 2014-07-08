<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		Eloquent::unguard();
        $this->call('UsersTableSeeder');        
        $this->call('DoctorTableSeeder');
        $this->call('EducationRecordTableSeeder');
        $this->command->info('Doctor table seeded!');
	}

}



class DoctorTableSeeder extends Seeder {

    public function run() {
        DB::table('doctors')->delete();
        $file=storage_path()."/csv/doctors1.csv";        
        $rownumber = 1;
        if (($handle = fopen($file, "r")) !== FALSE) 
        {
            while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) 
            {                              
                $name=$row[1];    
                $speciality=$row[8];
                $street_address=$row[2];
                $city=$row[3];                
                $postcode=$row[1];//doesn't exist
                $province_id=$row[4];
                $country=$row[1];//doesn't exist
                $phone=$row[5];
                $email=$row[6];
                $license_number=$row[7]; 
                
                if($rownumber>1)
                {                                            
                    /*Doctor::create(array(
                        'name' => $name,
                        'speciality' => $speciality,
                        'street_address' => $street_address,
                        'city' => $city,
                        'postcode' => $postcode,
                        'province_id' => $province_id,
                        'country' => $country,
                        'phone' => $phone,
                        'email' => $email,
                        'license_number' => $license_number
                    ));*/                  
                }
                $rownumber++;
            }
            fclose($handle);
        }
		
		\App\Models\Doctor::create(array(
            'id' => 1,
            'user_id' => 1,
			'name' => 'Maggie Seaver',
			'street_address' => '15 Robin Hood Lane in Huntington, Long Island, New York',
			'country' => 'America',
			'city_id' => 'New York',
			'province_id' => 'New York',
			'phone' => '110',
			'email' => 'maggie@mail.com',
			'license_number' => '120',
			'speciality' => 'internist',
			'postcode' => '20090',
		));

        \App\Models\Doctor::create(array(
            'id' => 2,
            'name' => 'Mike Seaver',
			'street_address' => '15 Robin Hood Lane in Huntington, Long Island, New York',
			'country' => 'America',
			'city_id' => 'New York',
			'province_id' => 'New York',
			'phone' => '12345',
			'email' => 'maggie+1@mail.com',
			'license_number' => '54321',
			'speciality' => 'dentist',
			'postcode' => '20092',
		));

        \App\Models\Doctor::create(array(
            'id' => 3,
			'name' => 'Carol Seaver',
			'street_address' => '15 Robin Hood Lane in Huntington, Long Island, New York',
			'country' => 'America',
			'city_id' => 'New York',
			'province_id' => 'New York',
			'phone' => '9527',
			'email' => 'maggie+2@mail.com',
			'license_number' => '7259',
			'speciality' => 'dentist',
			'postcode' => '20093',
		));

    }
}


class UsersTableSeeder extends Seeder {
    public function run() {
        //DB::table('users')->delete();
    }
}

class EducationRecordTableSeeder extends Seeder {
    public function run()
    {
        DB::table('education_records')->delete();

        \App\Models\EducationRecord::create(array(
            'doctor_id' => 1,
            'organization_name' => 'Harvard School of Medicine',
            'type' => 'Medical School',
            'graduation_year' => '1908'
        ));
    }
}
