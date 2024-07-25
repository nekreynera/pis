<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pharchargeless extends Model
{
	protected $table = "pharchargeless";

    protected $fillable = [
        'pharmanagerequest_id', 'users_id', 'status', 'mss_id', 'price', 'void'
    ];

}
