<?php namespace App\Models;

class Doctor extends \Eloquent implements RatableEntity {
	protected $fillable = [];

    /**
     * For generating dummy instances for tests via Factorymuff
     * @return array
     */
    public static function factory() {
        return array(
            'user_id' => 'integer',
            'name' => 'string',
            'speciality' => 'string',
            'street_address' => 'string',
            'city_id' => 'integer',
            'postcode' => 'string',
            'province_id' => 'integer',
            'country' => 'string',
            'phone' => 'string',
            'email' => 'email',
            'license_number' => 'string',
            'created_at' => 'date|Y-m-d H:i:s'
        );
    }

    public function users() {

        $this->belongsToMany('\App\Models\User');

    }

    public function educationRecords() {
        return $this->hasMany('\App\Models\EducationRecord');
    }

    public function ratings() {
        return $this->hasMany('App\Models\DoctorRating');
    }
}