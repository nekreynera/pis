<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KMC extends Model
{

    protected $table = 'kmc';

    protected $fillable = [
        'patient_id',
        'user_id',
        'kmc_no',
        'mother',
        'aog',
        'birth_weight',
        'discharge_weight',
        'contact_no',
        'date_ff',
        'head_circumference',
        'temperature',
        'month',
        'week',
        'days',
        'corrected_age',
        'weight',
        'body_length_height',
        'feeding',
        'way_of_administration',
        'condition_of_baby',
        'not_well',
        'not_well_others',
        'neuro',
        'chronic_pathology',
        'prescription',
    ];


}
