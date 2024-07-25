<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForDelete extends Model
{
	protected $table = "fordelete";

    protected $fillable = [
        'user_id',
        'patient_id',
        'remark',
        'created_at',
    ];
    public $timestamps = false;

}
