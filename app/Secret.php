<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Secret extends Model
{
	protected $table = "secret";

    protected $fillable = [
        'users_id', 'secret'
    ];


}
