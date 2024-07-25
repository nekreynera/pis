<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cashrecieptno extends Model
{
	protected $table = "cashrecieptno";

    protected $fillable = [
        'requistion_type', 'user_id', 'reciept_no'
    ];


}
