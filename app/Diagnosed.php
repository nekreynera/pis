<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diagnosed extends Model
{
    protected $table = "diagnosis";

    protected $fillable = [
        'patients_id', 'users_id', 'diagnosis'
    ];

}
