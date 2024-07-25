<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cashidsale extends Model
{
	protected $table = "cashidsale";

    protected $fillable = [
        'users_id', 'patients_id', 'price', 'or_no', 'activated', 'void', 'cash'
    ];


}
