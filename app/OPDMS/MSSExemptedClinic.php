<?php

namespace App\OPDMS;

use Illuminate\Database\Eloquent\Model;

class MSSExemptedClinic extends Model
{

    protected $table = 'mss_exempted_clinics';

    protected $fillable = ['clinic_id'];

    public $timestamps = false;

}
