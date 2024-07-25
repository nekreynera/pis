<?php

namespace App\Http\Controllers\OPDMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;

class SearchQueuedPatientController extends Controller
{


    public function search(Request $request)
    {
        $queues = DB::table('queues')
            ->where([
                [DB::raw('DATE(queues.created_at)'), DB::raw('CURDATE()')],
                [DB::raw('queues.clinic_code'), Auth::user()->clinic]
            ])
            ->where(DB::raw("CONCAT(patients.last_name,' ',patients.first_name)"),
                'LIKE', '%'.$request->search.'%')
            /*->orWhere(DB::raw("SOUNDEX(CONCAT(patients.last_name,' ',patients.first_name))"),
                DB::raw('SOUNDEX("'.$request->search.'")'))*/
            ->orWhere([
                'patients.hospital_no' => "$request->search",
                'patients.barcode' => "$request->search"
            ])
            /*-- check if patient is currently queue --*/
            ->whereRaw("patients.id IN (
                    SELECT queues.patients_id 
                    FROM queues
                    WHERE DATE(queues.created_at) = CURDATE()
                    AND queues.clinic_code = ".Auth::user()->clinic.")")
            ->leftJoin('assignations', function($join){
                $join->on('assignations.patients_id', 'queues.patients_id')
                    ->where([
                        [DB::raw('DATE(assignations.created_at)'), DB::raw('CURDATE()')],
                        [DB::raw('assignations.clinic_code'), Auth::user()->clinic]
                    ]);
            })
            /*-- Last Consultations Query --*/
            /*->leftJoin(DB::raw("
                        (SELECT 
                        consultations.id, consultations.patients_id as ls_pid, consultations.created_at as ls_date,
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
                $join->on('last_consultation.ls_pid', 'queues.patients_id');
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
                $join->on('followup.ff_pid', 'queues.patients_id');
            })*/
            /*-- Referrals Query --*/
            /*->leftJoin(DB::raw("
                        (SELECT refferals.patients_id as rpid, clinics.name as rf_clinic, users.last_name as rb_last_name,
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
                $join->on('refferal.rpid', 'queues.patients_id');
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
                $join->on('service_request.request_pid', 'queues.patients_id');
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
                $join->on('paid_request.c_pid', 'queues.patients_id');
            })*/
            ->leftJoin('users', function($join){
                $join->on('users.id', 'assignations.doctors_id');
            })
            ->leftJoin('patients', function($join){
                $join->on('patients.id', 'queues.patients_id');
            })
            ->select('*', 'queues.patients_id as pid', 'users.last_name as dr_last_name', 'users.first_name as dr_first_name',
                'users.middle_name as dr_middle_name', 'queues.created_at as queue_time',
                'assignations.created_at as assigned_time', 'assignations.updated_at as assigned_uptime')
            ->orderBy('queues.created_at')
            ->groupBy('queues.patients_id')
            ->paginate(20);

        return view('OPDMS.reception.queue', compact('queues'));
    }

}
