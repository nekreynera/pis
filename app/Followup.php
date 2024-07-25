<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;

class Followup extends Model
{
    protected $table = "followup";

    protected $fillable = [
        'patients_id', 'users_id', 'clinic_code', 'reason', 'assignedTo', 'followupdate', 'status'
    ];

    public static function checkFollowup($id)
    {
        $followup = Followup::where('patients_id', '=', $id)
                                ->where('clinic_code', '=', Auth::user()->clinic)
                                ->where('status', '=', 'P')
                                ->whereDate('followupdate', '=', DB::raw('CURDATE()'))
                                ->oldest()->first();
        return $followup;
    }

    public static function updateFollowup()
    {
        $pid = session('pid');
        $followup = Followup::where('patients_id', '=', $pid)
                                ->where('clinic_code', '=', Auth::user()->clinic)
                                ->where('status', '=', 'P')
                                ->whereDate('followupdate', '=', DB::raw('CURDATE()'))
                                ->oldest()->first();
        if (!empty($followup)){
            Followup::find($followup->id)->update(['status'=>'F']);
        }else{
            $followups = Followup::where('patients_id', '=', $pid)
                        ->where('clinic_code', '=', Auth::user()->clinic)
                        ->where('status', '=', 'P')
                        ->where('followupdate', '<', DB::raw('CURDATE()'))
                        ->oldest()->first();
            if (!empty($followups)){
                Followup::find($followups->id)->update(['status'=>'F']);
            }
        }
        return false;
    }


    public static function countAllFollowup($pid)
    {
        $followup = Followup::where('patients_id', '=', $pid)
                            ->where('clinic_code', '=', Auth::user()->clinic)
                            ->where('status', '=', 'P')
                            ->count();
        return $followup;
    }

}
