<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mssbatch extends Model
{
	protected $table = "mssbatch";

    protected $fillable = [
        'patient_id', 
        'users_id', 
        'mss_id',
        'referral', 
        'sectorial',
        'fourpis',
        'batch_no',
        'created_at'
    ];
     public $timestamps = false;
}
