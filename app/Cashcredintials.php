<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cashcredintials extends Model
{
	protected $table = "cashcredintials";

    protected $fillable = [
        'users_id', 'credintials', 'role', 'created_at', 'updated_at'
    ];


}
