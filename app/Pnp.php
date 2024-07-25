<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Pnp extends Model
{
	protected $table = "pnp";

    protected $fillable = [
        'patients_id', 'users_id'
    ];

    public static function storePNP($pnpID)
    {

    	$pnp = new Pnp();
    	$pnp->patients_id = $pnpID;
    	$pnp->users_id = Auth::user()->id;
    	$pnp->save();
    	
    }

}
