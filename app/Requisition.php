<?php

namespace App;

use http\Env\Request;
use Illuminate\Database\Eloquent\Model;
use Auth;

class Requisition extends Model
{
	protected $table = "requisition";

    protected $fillable = [
        'users_id', 'patients_id', 'item_id', 'qty', 'modifier'
    ];


    public static function storeMeds($request, $modifier, $i)
    {
        $meds = new Requisition();
        $meds->users_id = Auth::user()->id;
        $meds->patients_id = $request->session()->get('pid');
        $meds->item_id = $request->input('item.'.$i);
        $meds->qty = $request->input('qty.'.$i);
        $meds->modifier = $modifier;
        $meds->save();
        return $meds;
    }

}
