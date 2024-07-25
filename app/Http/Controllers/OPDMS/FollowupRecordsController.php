<?php

namespace App\Http\Controllers\OPDMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Support\Jsonable;

class FollowupRecordsController extends Controller
{

    public function get_all_followup_records(Request $request)
    {
        $followups = DB::table('followup')
                        ->select('*', 'followup.created_at', 'followup.status')
                        ->where('followup.patients_id', $request->pid)
                        ->leftJoin('users', 'users.id', 'followup.users_id')
                        ->leftJoin('clinics', 'clinics.id', 'followup.clinic_code')
                        ->leftJoin(DB::raw("
                            (SELECT followup.id as fid, users.last_name as ft_last_name,
                            users.first_name as ft_first_name, users.middle_name as ft_middle_name
                            FROM followup
                            LEFT JOIN users ON users.id = followup.assignedTo
                            WHERE followup.patients_id = ".$request->pid.") ff
                        "), 'ff.fid', 'followup.id')
                        ->get();
        return $followups->toJson();
    }

}
