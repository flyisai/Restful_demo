<?php namespace App\Models;

interface RatableEntity {

    /**
     * @return \App\Models\Rating
     */
    public function ratings();
}