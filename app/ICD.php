<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ICD extends Model
{
    protected $table = "icd_codes";

    protected $fillable = [
        'code', 'decsription', 'case_type'
    ];

}
