<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LaboratoryUndone extends Model
{
    protected $table = "laboratory_undone";

    protected $fillable = [
        'laboratory_request_id',
        'user_id',
        'remark',
        'created_at'
    ];
    public $timestamps = false;
}
