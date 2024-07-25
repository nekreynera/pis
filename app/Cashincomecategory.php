<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cashincomecategory extends Model
{
	protected $table = "cashincomecategory";

    protected $fillable = [
        'clinic_id', 'category'
    ];
    public $timestamps = false;


}
