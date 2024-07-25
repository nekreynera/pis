<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Laboratory extends Model
{
    protected $table = "laboratories";

    protected $fillable = [
        'users_id', 'patients_id', 'item_id', 'qty', 'modifier'
    ];
}
