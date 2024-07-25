<?php

namespace App\Http\Controllers\OPDMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Assignation;
use Illuminate\Support\Facades\Session;

class ReAssignationController extends Controller
{
    public function re_assign_patient(Request $request)
    {
        $assignations = DB::select("
                        SELECT users.id, users.last_name, users.first_name, users.middle_name,
                        P.pending, H.paused, C.nawc, S.serving, F.finished
                        FROM users
                        LEFT JOIN
                        (
                            SELECT assignations.doctors_id AS doctors_id, COUNT(*) AS pending
                            FROM assignations
                            WHERE clinic_code = ".Auth::user()->clinic."
                            AND DATE(assignations.created_at) = CURDATE()
                            AND assignations.status = 'P'
                            GROUP BY assignations.doctors_id
                        ) P ON P.doctors_id = users.id
                        LEFT JOIN
                        (
                            SELECT assignations.doctors_id AS doctors_id, COUNT(*) AS serving
                            FROM assignations
                            WHERE clinic_code = ".Auth::user()->clinic."
                            AND DATE(assignations.created_at) = CURDATE()
                            AND assignations.status = 'S'
                            GROUP BY assignations.doctors_id
                        ) S ON S.doctors_id = users.id
                        LEFT JOIN
                        (
                            SELECT assignations.doctors_id AS doctors_id, COUNT(*) AS nawc
                            FROM assignations
                            WHERE clinic_code = ".Auth::user()->clinic."
                            AND DATE(assignations.created_at) = CURDATE()
                            AND assignations.status = 'C'
                            GROUP BY assignations.doctors_id
                        ) C ON C.doctors_id = users.id
                        LEFT JOIN
                        (
                            SELECT assignations.doctors_id AS doctors_id, COUNT(*) AS finished
                            FROM assignations
                            WHERE clinic_code = ".Auth::user()->clinic."
                            AND DATE(assignations.created_at) = CURDATE()
                            AND assignations.status = 'C'
                            GROUP BY assignations.doctors_id
                        ) F ON F.doctors_id = users.id
                        LEFT JOIN
                        (
                            SELECT assignations.doctors_id AS doctors_id, COUNT(*) AS paused
                            FROM assignations
                            WHERE clinic_code = ".Auth::user()->clinic."
                            AND DATE(assignations.created_at) = CURDATE()
                            AND assignations.status = 'C'
                            GROUP BY assignations.doctors_id
                        ) H ON H.doctors_id = users.id

                        WHERE users.clinic = ".Auth::user()->clinic."
                        AND users.role = 7
                       	AND NOT users.id = 
                        (
                        	SELECT assignations.doctors_id FROM assignations WHERE
                            patients_id = $request->pid
                            AND DATE(assignations.created_at) = CURDATE()
                            AND clinic_code = ".Auth::user()->clinic."
                        )
                        GROUP BY users.id
                        ORDER BY users.last_name");

        $data = array();

        foreach($assignations as $row){
            if(Cache::has('active_'.$row->id)){
                array_push($data, $row);
            }
        }

        echo json_encode($data);
        return;

    }



    public function re_assign_now(Request $request)
    {
        Assignation::where([
            ['patients_id', $request->pid],
            [DB::raw('DATE(assignations.created_at)'), DB::raw('CURDATE()')],
            [DB::raw('assignations.clinic_code'), Auth::user()->clinic]
        ])->update(['status' => 'P', 'doctors_id' => $request->doctors_id]);
    }



}
