<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class RegPatient extends Model
{
	protected $table = "reg_patients";

    protected $fillable = [
        'users_id', 'total'
    ];


    public static function patientCensus()
    {
        $uid = Auth::user()->id;
        $regpatient = RegPatient::where('users_id', '=', $uid)
                                    ->whereDate('created_at', '=', Carbon::now()->toDateString())
                                    ->latest()->first();
        if ($regpatient){
            //RegPatient::find($regpatient->id)->update(['total' => $regpatient->total + 1]);
            RegPatient::find($regpatient->id)->increment('total');
        }else{
            $insertCensus = new RegPatient();
            $insertCensus->users_id = $uid;
            $insertCensus->total = 1;
            $insertCensus->save();
        }
        return false;
    }

}
