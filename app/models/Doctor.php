<?php namespace App\Models;

class Doctor extends \Eloquent {
	protected $fillable = [];

    public static function factory() {
        return array(
            'name' => 'string',
            'speciality' => 'string',
            'street_address' => 'string',
            'city' => 'string',
            'postcode' => 'string',
            'province' => 'string',
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

}