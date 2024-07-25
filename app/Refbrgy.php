<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Refbrgy extends Model
{
	protected $table = "refbrgy";

    protected $fillable = [
        'brgyCode', 'brgyDesc', 'regCode', 'provCode', 'citymunCode'
    ];

}
