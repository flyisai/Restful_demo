<?php namespace App\Models;

class User extends \Cartalyst\Sentry\Users\Eloquent\User 
{
    public function doctors() {
        return $this->hasOne('Doctor','user_id');
    }

    public function doctorRatings() {
        return $this->hasMany('\App\Models\DoctorRating');
    }
}
