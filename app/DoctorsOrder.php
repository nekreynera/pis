<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DoctorsOrder extends Model
{
    protected $table = "doctors_order";

    protected $fillable = [
        'patients_id', 'users_id', 'reason', 'disposition'
    ];
}
