<?php

namespace App\Http\Controllers\OPDMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Assignation;
use Illuminate\Support\Facades\Session;



class AssignationController extends Controller
{

    public function assign_to_doctor()
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


    public function store(Request $request)
    {
        Assignation::create([
           'patients_id' => $request->pid,
           'doctors_id' => $request->doctors_id,
           'users_id' => Auth::user()->id,
           'clinic_code' => Auth::user()->clinic,
           'status' => 'P',
        ]);
        return;
    }


}


















