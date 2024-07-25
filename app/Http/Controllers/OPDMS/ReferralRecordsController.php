<?php

namespace App\Http\Controllers\OPDMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Support\Jsonable;

class ReferralRecordsController extends Controller
{
    public function get_all_referral_records(Request $request)
    {
        $refferals = DB::table('refferals')
                        ->select('*', 'refferals.status', 'refferals.created_at')
                        ->where('refferals.patients_id', $request->pid)
                        ->leftJoin('users', 'users.id', 'refferals.users_id')
                        ->leftJoin('clinics', 'clinics.id', 'refferals.from_clinic')
                        ->leftJoin(DB::raw("
                            (SELECT refferals.id as rid, clinics.name as rt_clinic
                            FROM refferals
                            LEFT JOIN clinics ON clinics.id = refferals.to_clinic
                            WHERE refferals.patients_id = ".$request->pid.") referred_to_clinic
                        "), 'referred_to_clinic.rid', 'refferals.id')
                        ->leftJoin(DB::raw("
                            (SELECT refferals.id as rid, users.last_name as rt_last_name,
                            users.first_name as rt_first_name, users.middle_name as rt_middle_name
                            FROM refferals
                            LEFT JOIN users ON users.id = refferals.assignedTo
                            WHERE refferals.patients_id = ".$request->pid.") referred_to_doctor
                        "), 'referred_to_doctor.rid', 'refferals.id')
                        ->get();
        return $refferals->toJson();

    }
}
