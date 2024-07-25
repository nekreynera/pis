<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pharmanagerequest extends Model
{
	protected $table = "pharmanagerequest";

    protected $fillable = [
        'requisition_id', 'users_id', 'qty', 'modifier'
    ];
}
