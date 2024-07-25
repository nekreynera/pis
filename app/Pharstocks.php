<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pharstocks extends Model
{
	protected $table = "pharstocks";

    protected $fillable = [
        'items_id', 'stock'
    ];
    public $timestamps = false;

}
