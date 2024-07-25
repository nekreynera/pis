<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LaboratoryPrintedRequest extends Model
{
    //
    protected $table = "laboratory_printed_request";

    protected $fillable = [
        'user_id', 
        'laboratory_request_id',
    ];
}
