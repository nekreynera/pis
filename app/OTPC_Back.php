<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OTPC_Back extends Model
{
    protected $table = "otpc_back";

    protected $primaryKey = 'otpc_id';

    protected $fillable = [
        'otpc_id',
        'registrationNumber',
        'date',
        'weightKG',
        'weightLoss',
        'muac',
        'edemaBack',
        'length_height',
        'whz',
        'diarrheaDays',
        'vomiting_days',
        'fever_days',
        'cough_days',
        'temperatureDays',
        'respirationRate',
        'dehydrated',
        'anemia',
        'skin_infection',
        'appetite_test_day',
        'action_needed',
        'appetite_test_pass_fail',
        'other_medication',
        'rutf',
        'examiner',
        'outcome'
    ];
}
