<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdoptedhostpitalNumbers extends Model
{
	protected $table = "adopted_hostpital_numbers";

    protected $fillable = [
        'hospital_no',
    ];
    public $timestamps = false;

}
