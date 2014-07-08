<?php namespace App\Models;

interface Rating {

    /**
     * @return array of fields that users can insert ratings for in the model
     */
    public function getRatableFields();
}