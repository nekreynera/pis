<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LaboratoryDone extends Model
{
    //
    protected $table = "laboratory_done";

    protected $fillable = [
        'laboratory_request_id',
        'user_id',
        'created_at',
        'done_no',
    ];
    public $timestamps = false;
}
