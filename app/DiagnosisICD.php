<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiagnosisICD extends Model
{
    protected $table = "diagnosis_icd";

    protected $fillable = [
        'patients_id', 'users_id', 'diagnosis_id', 'icd'
    ];
}
