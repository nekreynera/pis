<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChildhoodCare extends Model
{
    protected $table = 'childhood_care';

    protected $fillable = [
        'patient_id',
        'user_id',
        'clinic_name',
        'child_no',
        'brgy',
        'family',
        'childs_name',
        'sex',
        'mother',
        'education',
        'occupation',
        'date_first_seen',
        'birth_date',
        'birth_weight',
        'place_of_delivery',
        'birth_registered',
        'complete_address',
        'bro_sis',
        'gender',
        'date_birth',
        'newborn_screening',
        'bcg',
        'pv',
        'opv',
        'hepatitis',
        'mmr_one',
        'mmr_two',
        'ipv',
        'pcv',
    ];
}
