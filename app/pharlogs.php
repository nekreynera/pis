<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pharlogs extends Model
{
	protected $table = "pharlogs";

    protected $fillable = [
        'users_id', 'items_id', 'action', 'remarks'
    ];
}
