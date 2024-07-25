<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LaboratoryDoneReferences extends Model
{
    //
    protected $table = "laboratory_done_references";

    protected $fillable = [
        'number',
    ];
    
    public $timestamps = false;
}
