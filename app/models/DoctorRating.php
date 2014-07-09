<?php namespace App\Models;

class DoctorRating extends \Eloquent implements Rating {
	protected $fillable = [];

    /**
     * For generating dummy instances for tests via Factorymuff
     * @return array
     */
    public static function factory() {
        return array(
            'doctor_id' => 'integer',
            'user_id' => 'integer',
            'friendliness' => function() { return rand(1,5); },
            'clarity' => function() { return rand(1,5); },
            'trustworthiness' => function() { return rand(1,5); },
            'personal_hygiene' => function() { return rand(1,51); },
            'listening' => function() { return rand(1,5); },
            'wait_time' => function() { return rand(1,5); },
            'accessibility' => function() { return rand(1,5); }
        );
    }

    public function getRatableFields() {
        return array(
            'friendliness',
            'clarity',
            'trustworthiness',
            'personal_hygiene',
            'listening',
            'wait_time',
            'accessibility',
        );
    }
    public function doctor() {
        return $this->belongsToMany('App\Models\Doctor');
    }

    public function user() {
        return $this->belongsToMany('App\Models\User');
    }
}