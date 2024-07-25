<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Smoke extends Model
{
	protected $table = "smokes";

    protected $fillable = [
        'user_id', 'patient_id'
    ];
}
