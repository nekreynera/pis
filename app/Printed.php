<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Printed extends Model
{
	protected $table = "printed";

    protected $fillable = [
        'users_id', 'user_id', 'created_at'
    ];
    public $timestamps = false;

}
