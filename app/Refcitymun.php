<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Refcitymun extends Model
{
	protected $table = "refcitymun";

    protected $fillable = [
        'psgcCode', 'citymunDesc', 'regDesc', 'provCode', 'citymunCode'
    ];

}
