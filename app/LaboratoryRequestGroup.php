<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LaboratoryRequestGroup extends Model
{
    protected $table = "laboratory_request_groups";

    protected $fillable = [
        'user_id',
        'clinic_id',
        'patient_id',
        'created_at',
    ];
    
    public $timestamps = false;
}
