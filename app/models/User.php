<?php namespace App\Models;

class User extends \Cartalyst\Sentry\Users\Eloquent\User 
{
    public function doctors() 
    {
        $this->hasOne('Doctor','user_id');
    }
}
