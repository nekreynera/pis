<?php

namespace App;

use Carbon\Carbon;
use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Followup;
use DB;

class Refferal extends Model
{
    protected $table = "refferals";

    protected $fillable = [
        'patients_id', 'users_id', 'reason', 'from_clinic', 'to_clinic', 'assignedTo', 'status'
    ];

    public static function checkRefferal($id)
    {
        $refferal = Refferal::where('patients_id', '=', $id)
                                ->where('to_clinic', '=', Auth::user()->clinic)
                                ->where('status', '=', 'P')
                                ->oldest()->first();
        return $refferal;
    }

    public static function updateRefferal()
    {
        $pid = session('pid');
        $refferal = Refferal::where('patients_id', '=', $pid)
                                    ->where('to_clinic', '=', Auth::user()->clinic)
                                    ->where('status', '=', 'P')
                                    ->oldest()->first();
        if (!empty($refferal)){
            Refferal::find($refferal->id)->update(['status'=>'F']);
        }
        return false;
    }

    public static function countAllRefferals($pid)
    {
        $refferal = Refferal::where('patients_id', '=', $pid)
                        ->where('to_clinic', '=', Auth::user()->clinic)
                        ->where('status', '=', 'P')
                        ->count();
        return $refferal;
    }



    public static function countAllNotifications($pid)
    {
        $followup = Followup::where('patients_id', '=', $pid)
                                ->where('clinic_code', '=', Auth::user()->clinic)
                                ->where('status', '=', 'P')
                                ->groupBy('users_id', 'assignedTo')
                                ->pluck('users_id');

        $refferal = Refferal::where('patients_id', '=', $pid)
                                ->where('status', '=', 'P')
                                ->where('to_clinic', '=', Auth::user()->clinic)
                                ->where('assignedTo', '!=', null)
                                ->groupBy('assignedTo')
                                ->pluck('assignedTo');

        $assignedDoctor = array_merge($followup->toArray(), $refferal->toArray());

        return $assignedDoctor;
    }


    public static function checkIfForRefferal($pid)
    {
        $checkIfForRefferal = Refferal::where('patients_id', '=', $pid)
                                        ->whereDate('created_at', Carbon::now()->toDateString())
                                        ->where('status', '=', 'P')
                                        ->where('from_clinic', '=', Auth::user()->clinic)
                                        ->count();
        return $checkIfForRefferal;
    }




}
