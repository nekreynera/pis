<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Contracts\Support\JsonableInterface;
use App\Patient;
use App\Consultation;
use App\MedInterns;
use App\Requisition;
use App\User;
use App\Approval;
use DB;
use Session;
use Carbon;
use Validator;
use Auth;

class AjaxController extends Controller
{

    public function getAuth()
    {
        echo json_encode(Auth::user()->id);
        return;
    }


    public function approval($pid, $did)
    {
        $approval = new Approval();
        $approval->patients_id = $pid;
        $approval->interns_id = Auth::user()->id;
        $approval->approved_by = $did;
        $approval->save();
        return redirect()->back()->with('toaster', array('success', 'Request for approval has been submited.'));
    }

    public function forApprovals()
    {
        $approvals = Approval::where('approved_by', '=', Auth::user()->id)
                                ->whereDate('approvals.created_at', '=', Carbon::now()->toDateString())
                                ->leftJoin('patients as pt', 'pt.id', '=', 'approvals.patients_id')
                                ->leftJoin('users as us', 'us.id', '=', 'approvals.interns_id')
                                ->select('approvals.id as approvalid', 'approvals.approved', 'pt.id as pid', 'pt.birthday', DB::raw("CONCAT(pt.last_name,' ',pt.first_name,' ',CASE WHEN pt.suffix IS NOT NULL THEN pt.suffix ELSE '' END,' ',CASE WHEN pt.middle_name IS NOT NULL THEN pt.middle_name ELSE '' END) as name"), DB::raw("CONCAT(CASE WHEN us.first_name IS NOT NULL THEN us.first_name ELSE '' END,' ',CASE WHEN us.middle_name IS NOT NULL THEN LEFT(us.middle_name, 1) ELSE '' END,'.',' ',CASE WHEN us.last_name IS NOT NULL THEN us.last_name ELSE '' END) as doctorsname"))
                                ->groupBy('approvals.patients_id')
                                ->get();
        return view('doctors.forApproval', compact('approvals'));
    }


    public function markAsApproved($approvalID)
    {
        Approval::find($approvalID)->update(['approved'=>'Y']);
        return redirect()->back()->with('toaster', array('success', 'Patient has been approved'));
    }

    public function markAsUnApproved($approvalID)
    {
        Approval::find($approvalID)->update(['approved'=>'N']);
        return redirect()->back()->with('toaster', array('error', 'Patient has been declined'));
    }

    public function approvalMedicalRecords(Request $request)
    {
        $history = DB::select("
                    SELECT pt.id, 
                            CONCAT(pt.last_name,', ',pt.first_name,' ',
                                CASE 
                                    WHEN pt.suffix IS NOT NULL 
                                    THEN pt.suffix ELSE '' 
                                END,' ',
                                CASE 
                                    WHEN pt.middle_name IS NOT NULL
                                     THEN LEFT(pt.middle_name, 1) ELSE '' 
                                END) as name, 
                            C.consultations, 
                            R.refferals, 
                            F.followups, 
                            COUNT(RQ.requisitions) as requisitions, 
                            U.ultra as ultrasound, 
                            X.xray as xray, 
                            L.labs as lab,
                            D.dental as dental 
                    FROM patients pt
                    LEFT JOIN (SELECT 
                                        x.patient_id as patients_id,
                                        count(patient_id) as consultations
                                    FROM (
                                        SELECT 
                                            id,
                                            patient_id  
                                        FROM childhood_care
                                        UNION
                                        SELECT 
                                            id,
                                            patient_id 
                                        FROM otpc_front
                                        UNION 
                                        SELECT
                                            id,
                                            patient_id 
                                        FROM kmc
                                        UNION
                                        SELECT
                                            id,
                                            patients_id as patient_id
                                        FROM consultations
                                        UNION
                                        SELECT
                                            id,
                                            patient_id
                                        FROM industrial_forms
                                        ) as x
                                        GROUP BY patient_id)
                    as C ON pt.id = C.patients_id
                    LEFT JOIN (SELECT refferals.patients_id, COUNT(*) AS refferals FROM refferals GROUP BY refferals.patients_id)
                    as R ON pt.id = R.patients_id
                    LEFT JOIN (SELECT followup.patients_id, COUNT(*) AS followups FROM followup GROUP BY followup.patients_id)
                    as F ON pt.id = F.patients_id
                    LEFT JOIN (SELECT requisition.patients_id, COUNT(*) AS requisitions FROM requisition GROUP BY requisition.patients_id, requisition.modifier, DATE(requisition.created_at))
                    as RQ ON pt.id = RQ.patients_id
                    LEFT JOIN (SELECT an.patients_id, COUNT(*) AS ultra FROM ancillaryrequist as an LEFT JOIN cashincomesubcategory cs ON an.cashincomesubcategory_id = cs.id WHERE cs.cashincomecategory_id = 6 AND patients_id = $request->patient) as U ON U.patients_id = pt.id
                    LEFT JOIN (SELECT an.patients_id, COUNT(*) AS xray FROM ancillaryrequist as an LEFT JOIN cashincomesubcategory cs ON an.cashincomesubcategory_id = cs.id WHERE cs.cashincomecategory_id = 11 AND patients_id = $request->patient) as X ON X.patients_id = pt.id
                    LEFT JOIN (SELECT an.patients_id, COUNT(*) AS labs FROM ancillaryrequist as an LEFT JOIN cashincomesubcategory cs ON an.cashincomesubcategory_id = cs.id WHERE cs.cashincomecategory_id = 10 AND patients_id = $request->patient) as L ON L.patients_id = pt.id
                    LEFT JOIN (SELECT an.patients_id, COUNT(*) AS dental FROM ancillaryrequist as an LEFT JOIN cashincomesubcategory cs ON an.cashincomesubcategory_id = cs.id WHERE cs.cashincomecategory_id = 5 AND patients_id = $request->patient) as D ON D.patients_id = pt.id
                    WHERE pt.id = $request->patient");
        $laboratory = DB::select("SELECT 
                                    a.id
                                FROM laboratory_requests a 
                                LEFT JOIN laboratory_request_groups b ON a.laboratory_request_group_id = b.id
                                WHERE b.patient_id = ?
                                UNION 
                                SELECT c.id
                                FROM ancillaryrequist c
                                LEFT JOIN cashincome d ON c.id = d.ancillaryrequist_id
                                LEFT JOIN cashincomesubcategory e ON c.cashincomesubcategory_id = e.id
                                LEFT JOIN cashincomecategory f ON e.cashincomecategory_id = f.id
                                WHERE c.patients_id = ?
                                AND f.id IN(10)
                                AND d.id IS NOT NULL
                                ", [$request->patient, $request->patient]);

        echo json_encode(['history' => $history, 'laboratory' => $laboratory]);
        return;
    }

    public function approvalConsultationList(Request $request)
    {
        $consultations = DB::select("SELECT 
                                        x.id, 
                                        x.type,
                                        x.created_at,
                                        b.last_name as uslast_name,
                                        b.first_name as usfirst_name, 
                                        b.middle_name as usmiddle_name,
                                        c.name as clinic,
                                        d.description as role,
                                        x.patient_id,
                                        e.last_name,
                                        e.first_name,
                                        e.middle_name
                                    FROM (
                                        SELECT
                                            id, 
                                            user_id, 
                                            created_at,
                                            patient_id,
                                            ('childhood_care') as type
                                        FROM childhood_care
                                        UNION
                                        SELECT
                                            id, 
                                            user_id, 
                                            created_at,
                                            patient_id,
                                            ('otpc_front') as type
                                        FROM otpc_front
                                        UNION 
                                        SELECT
                                            id,
                                            user_id,
                                            created_at,
                                            patient_id,
                                            ('kmc')  as type
                                        FROM kmc
                                        UNION
                                        SELECT
                                            id,
                                            users_id as user_id,
                                            created_at,
                                            patients_id as patient_id,
                                            ('consultations') as type
                                        FROM consultations
                                        UNION
                                        SELECT
                                            id,
                                            user_id,
                                            created_at,
                                            patient_id,
                                            ('industrial_forms') as type
                                        FROM industrial_forms
                                        ) as x 
                                    LEFT JOIN users b ON x.user_id = b.id
                                    LEFT JOIN clinics c ON b.clinic = c.id
                                    LEFT JOIN roles d ON b.role = d.id
                                    LEFT JOIN patients e ON x.patient_id = e.id
                                    WHERE x.patient_id = ?
                                    ORDER BY x.created_at DESC", [$request->patient]);

        echo json_encode($consultations);
        return;
    }



    public function ajaxRequisitionList(Request $request)
    {
        $requisitions = Requisition::where('patients_id', '=', $request->patient)
                        ->leftJoin('patients as pt', 'pt.id', '=', 'requisition.patients_id')
                        ->leftJoin('users as us', 'us.id', '=', 'requisition.users_id')
                        ->leftJoin('clinics', 'clinics.id', '=', 'us.clinic')
                        ->groupBy('requisition.users_id', 'requisition.modifier', DB::raw("DATE(requisition.created_at)"))
                        ->orderBy('requisition.created_at', 'DESC')
                        ->select('requisition.*', 'clinics.name as clinic',
                            DB::raw("CONCAT(pt.last_name,', ',pt.first_name,' ',CASE WHEN pt.suffix IS NOT NULL THEN pt.suffix ELSE '' END,' ',CASE WHEN pt.middle_name IS NOT NULL THEN LEFT(pt.middle_name, 1) ELSE '' END) as name"),
                            DB::raw("CONCAT(us.first_name,' ',CASE WHEN us.middle_name IS NOT NULL THEN LEFT(us.middle_name, 1) ELSE '' END,' ',us.last_name) as doctor"))
                        ->get();
        echo json_encode($requisitions);
        return;
    }




    public function ajaxRefferals(Request $request)
    {
        $refferals = DB::select("SELECT rf.*, FD.fromDoctor, TD.toDoctor, FC.fromClinic, TC.toClinic, 
                    CONCAT(pt.last_name,', ',pt.first_name,' ',CASE WHEN pt.suffix IS NOT NULL THEN pt.suffix ELSE '' END,' ',CASE WHEN pt.middle_name IS NOT NULL THEN LEFT(pt.middle_name, 1) ELSE '' END) as name 
                    FROM refferals rf 
                    LEFT JOIN (SELECT us.id as fdid, CONCAT(CASE WHEN us.last_name IS NOT NULL THEN us.last_name ELSE '' END,' ',LEFT(us.middle_name, 1),'.',' ',CASE WHEN us.first_name IS NOT NULL THEN us.first_name ELSE '' END) as fromDoctor FROM users us ) as FD 
                    ON FD.fdid = rf.users_id 
                    LEFT JOIN (SELECT usr.id as tdid, CONCAT(CASE WHEN usr.last_name IS NOT NULL THEN usr.last_name ELSE '' END,' ',LEFT(usr.middle_name, 1),'.',' ',CASE WHEN usr.first_name IS NOT NULL THEN usr.first_name ELSE '' END) as toDoctor FROM users usr ) as TD 
                    ON TD.tdid = rf.assignedTo 
                    LEFT JOIN (SELECT fclinic.id as fcid, fclinic.name as fromClinic FROM clinics fclinic) as FC ON FC.fcid = rf.from_clinic 
                    LEFT JOIN (SELECT tclinic.id as tcid, tclinic.name as toClinic FROM clinics tclinic) as TC ON TC.tcid = rf.to_clinic
                    LEFT JOIN patients pt ON pt.id = rf.patients_id
                    WHERE rf.patients_id = $request->patient");
        echo json_encode($refferals);
        return;
    }



    public function ajaxFollowup(Request $request)
    {
        $followups = DB::select("SELECT ff.*, clinics.name as clinic, FD.fromDoctor, TD.toDoctor, CONCAT(pt.last_name,', ',pt.first_name,' ',CASE WHEN pt.suffix IS NOT NULL THEN pt.suffix ELSE '' END,' ',CASE WHEN pt.middle_name IS NOT NULL THEN LEFT(pt.middle_name, 1) ELSE '' END) as name FROM followup ff
                        LEFT JOIN patients pt ON pt.id = ff.patients_id
                        LEFT JOIN clinics ON clinics.id = ff.clinic_code
                        LEFT JOIN (SELECT us.id, CONCAT(CASE WHEN us.last_name IS NOT NULL THEN us.last_name ELSE '' END,' ',LEFT(us.middle_name, 1),'.',' ',CASE WHEN us.first_name IS NOT NULL THEN us.first_name ELSE '' END) as fromDoctor FROM users us) as FD ON FD.id = ff.users_id
                        LEFT JOIN (SELECT usr.id, CONCAT(CASE WHEN usr.last_name IS NOT NULL THEN usr.last_name ELSE '' END,' ',LEFT(usr.middle_name, 1),'.',' ',CASE WHEN usr.first_name IS NOT NULL THEN usr.first_name ELSE '' END) as toDoctor FROM users usr ) as TD 
                        ON TD.id = ff.assignedTo
                        WHERE ff.patients_id = $request->patient");
        echo json_encode($followups);
        return;
    }


}
