<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TblDiagnosis extends Model
{
    protected $table = "tbl_diagnoses";

    protected $fillable = [
        'patient_id', 'user_id', 'clinic_code', 'diagnose_description'
    ];

    public $timestamps = false;
}
