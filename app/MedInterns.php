<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class MedInterns extends Model
{
	 protected $table = "med_interns";

    protected $fillable = [
        'interns_id'
    ];

    public static function checkIfIntern()
    {
        $check = MedInterns::where('interns_id', '=', Auth::user()->id)->first();
        return $check;
    }

}
