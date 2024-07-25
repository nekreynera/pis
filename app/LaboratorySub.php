<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LaboratorySub extends Model
{
    protected $table = "laboratory_sub";

    protected $fillable = [
        'laboratory_id', 'name'
    ];
    public $timestamps = false;
}
