<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LaboratoryModel extends Model
{
    protected $table = "laboratory";

    protected $fillable = [
        'name'
    ];
    public $timestamps = false;
}
