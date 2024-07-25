<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pharinventory extends Model
{
	protected $table = "pharinventory";

    protected $fillable = [
        'users_id', 'item_id', 'qty'
    ];
    

}
