<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
	protected $table = "queues";

    protected $fillable = [
        'patients_id', 'users_id', 'clinic_code', 'queue_status'
    ];

}
