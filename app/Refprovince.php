<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Refprovince extends Model
{
	protected $table = "refprovince";

    protected $fillable = [
        'psgcCode', 'provDesc', 'regCode', 'provCode',
    ];

}
