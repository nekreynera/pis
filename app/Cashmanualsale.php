<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cashmanualsale extends Model
{
	protected $table = "cashmanualsale";

    protected $fillable = [
        'users_id', 'patients_id', 'mss_id', 'item', 'price', 'qty', 'or_no', 'void', 'cash'
    ];


}
