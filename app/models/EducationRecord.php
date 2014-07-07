<?php namespace App\Models;

class EducationRecord extends \Eloquent {
    protected $fillable = ['doctor_id', 'type', 'organization_name', 'graduation_year'];

    public static function factory() {
        return array(
            'doctor_id' => 'integer',
            'organization_name' => 'string',
            'type' => 'string',
            'graduation_year' => 'string',
            'created_at' => 'date|Y-m-d H:i:s'
        );
    }

    public function doctor() {
        $this->belongsTo('\App\Models\Doctor');
    }

}