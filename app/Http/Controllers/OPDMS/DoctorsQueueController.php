<?php

namespace App\Http\Controllers\OPDMS;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;

class DoctorsQueueController extends Controller
{
    public function doctors_queue()
    {
        $doctors = DB::select("
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
                            AND assignations.status = 'F'
                            GROUP BY assignations.doctors_id
                        ) F ON F.doctors_id = users.id
                        LEFT JOIN
                        (
                            SELECT assignations.doctors_id AS doctors_id, COUNT(*) AS paused
                            FROM assignations
                            WHERE clinic_code = ".Auth::user()->clinic."
                            AND DATE(assignations.created_at) = CURDATE()
                            AND assignations.status = 'H'
                            GROUP BY assignations.doctors_id
                        ) H ON H.doctors_id = users.id

                        WHERE users.clinic = ".Auth::user()->clinic."
                        AND users.role = 7
                        GROUP BY users.id
                        ORDER BY users.last_name");

        return view('OPDMS.reception.doctors.queue', compact('doctors'));
    }



    public function status_filtering($doctors_id, $status)
    {
        /* check if status is not equal to all or not false*/
        $filter_by = ($status != 'A')? $status : false;

        /*-- find the selected doctor to see queue status*/
        $doctor = User::find($doctors_id);

        $patients = DB::table('assignations')
                    ->where([
                        ['assignations.doctors_id', $doctors_id],
                        [DB::raw('DATE(assignations.created_at)'), DB::raw('CURDATE()')],
                        [DB::raw('assignations.clinic_code'), Auth::user()->clinic]
                    ])
                    ->when($filter_by, function($query, $filter_by){ /* when status is not equal to all */
                        return $query->where('assignations.status', $filter_by);
                    })
                    ->leftJoin('patients', function($join){
                        $join->on('patients.id', 'assignations.patients_id');
                    })
                    /*-- Last Consultations Query --*/
                    /*->leftJoin(DB::raw("
                                (SELECT consultations.id, consultations.patients_id as ls_pid, 
                                consultations.created_at as ls_date,
                                users.last_name as ls_last_name, users.first_name as ls_first_name
                                FROM consultations
                                LEFT JOIN users ON users.id = consultations.users_id
                                WHERE consultations.clinic_code = ".Auth::user()->clinic."
                                AND consultations.id IN
                                (
                                    SELECT MAX(id) 
                                    FROM consultations
                                    WHERE clinic_code = ".Auth::user()->clinic."
                                    AND patients_id = 5701
                                    GROUP BY patients_id
                                )
                                AND consultations.patients_id IN (
                                    SELECT queues.patients_id FROM queues
                                    WHERE DATE(created_at) = CURDATE()
                                    AND clinic_code = ".Auth::user()->clinic."
                                )
                                ORDER BY consultations.created_at DESC) last_consultation
                            "), function ($join){
                        $join->on('last_consultation.ls_pid', 'assignations.patients_id');
                    })*/
                    /*-- Followup Query --*/
                    /*->leftJoin(DB::raw("
                                (SELECT followup.patients_id as ff_pid,
                                followup.followupdate, users.last_name as ff_last_name,
                                users.first_name as ff_first_name
                                FROM followup
                                LEFT JOIN users ON users.id = 
                                (CASE
                                    WHEN followup.assignedTo IS NOT NULL
                                    THEN followup.assignedTo
                                    ELSE followup.users_id
                                END)
                                WHERE followup.clinic_code = ".Auth::user()->clinic."
                                AND DATE(followup.followupdate) = CURDATE()
                                AND status = 'P') followup
                            "), function ($join){
                        $join->on('followup.ff_pid', 'assignations.patients_id');
                    })*/
                    /*-- Referrals Query --*/
                    /*->leftJoin(DB::raw("
                                (SELECT refferals.patients_id as rpid, clinics.name as rf_clinic, 
                                users.last_name as rb_last_name,
                                users.first_name as rb_first_name, Ref.rt_last_name, Ref.rt_first_name
                                FROM refferals
                                LEFT JOIN clinics
                                ON clinics.id = from_clinic
                                LEFT JOIN users
                                ON users.id = refferals.users_id
                                    LEFT JOIN 
                                    (
                                        SELECT refferals.id as ref_id,
                                        users.last_name as rt_last_name,
                                        users.first_name as rt_first_name
                                        FROM refferals
                                        LEFT JOIN users ON users.id = refferals.assignedTo
                                    ) Ref ON Ref.ref_id = refferals.id
                                WHERE refferals.to_clinic = ".Auth::user()->clinic."
                                AND refferals.status = 'P'
                                GROUP BY refferals.patients_id) refferal
                            "), function ($join){
                        $join->on('refferal.rpid', 'assignations.patients_id');
                    })*/
                    /*--- Requests and Cash_income Query ---*/
                    /*->leftJoin(DB::raw("
                        (SELECT
                        COUNT(ancillaryrequist.patients_id) AS request_total,
                        ancillaryrequist.patients_id AS request_pid
                        FROM ancillaryrequist
                        LEFT JOIN cashincome
                        ON cashincome.ancillaryrequist_id = ancillaryrequist.id
                        LEFT JOIN users
                        ON users.id = ancillaryrequist.users_id
                        WHERE users.clinic = ".Auth::user()->clinic."
                        AND (cashincome.get IS NULL OR cashincome.get = 'N')
                        GROUP BY ancillaryrequist.patients_id) service_request
                    "), function ($join){
                        $join->on('service_request.request_pid', 'assignations.patients_id');
                    })
                    ->leftJoin(DB::raw("
                        (SELECT COUNT(cashincome.patients_id) AS paid_total,
                        cashincome.patients_id AS c_pid
                        FROM ancillaryrequist
                        LEFT JOIN cashincome
                        ON cashincome.ancillaryrequist_id = ancillaryrequist.id
                        LEFT JOIN users
                        ON users.id = ancillaryrequist.users_id
                        WHERE cashincome.get = 'N'
                        AND users.clinic = ".Auth::user()->clinic."
                        GROUP BY cashincome.patients_id) paid_request
                    "), function ($join){
                        $join->on('paid_request.c_pid', 'assignations.patients_id');
                    })*/
                    ->select('*', 'assignations.patients_id as pid', 'assignations.created_at as assigned_time')
                    ->orderBy('assignations.created_at')
                    ->paginate(20);

                    /*-- count all the queue status of this doctor --*/
        $queue_count = DB::table('assignations')
                        ->where([
                            ['doctors_id', $doctors_id],
                            ['clinic_code', Auth::user()->clinic],
                            [DB::raw('DATE(assignations.created_at)'), DB::raw('CURDATE()')]
                        ])
                        ->groupBy('status')
                        ->select(DB::raw("COUNT(*) as total"), 'status')
                        ->get();

        return view('OPDMS.reception.doctors.status_filtering', compact('patients', 'queue_count', 'doctor'));

    }

}
