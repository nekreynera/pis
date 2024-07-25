<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pharitemstatus extends Model
{
	protected $table = "pharitemstatus";

    protected $fillable = [
        'items_id', 'status'
    ];
    public $timestamps = false;

}
