<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Patient;
use App\Consultation;
use App\User;
use DB;
use Session;
use Carbon;
use Validator;
use Auth;

class NurseNotesController extends Controller
{

    public function index()
    {

    }


    public function show($cid)
    {
        $consultation = Consultation::where('consultations.id', '=', $cid)
                                    ->leftJoin('patients as pt', 'pt.id', '=', 'consultations.patients_id')
                                    ->select('consultations.id', 'consultations.consultation',
                                        DB::raw("CONCAT(pt.last_name,', ',pt.first_name,' ',CASE WHEN pt.suffix IS NOT NULL THEN pt.suffix ELSE '' END,' ',CASE WHEN pt.middle_name IS NOT NULL THEN LEFT(pt.middle_name, 1) ELSE '' END) as patient"))
                                    ->first();

        $doctorsConsultation = str_replace('id="doctors" class="mceEditable"', 'id="doctors" class="mceNonEditable"', $consultation->consultation);

        return view('receptions.nurseNotes', compact('consultation', 'doctorsConsultation'));
    }
    
    public function nurseNotesAjax(Request $request)
    {
        $cid = $request->cid;
        $consultation = Consultation::where('consultations.id', '=', $cid)
                                    ->leftJoin('patients as pt', 'pt.id', '=', 'consultations.patients_id')
                                    ->select('consultations.id', 'consultations.consultation',
                                        DB::raw("CONCAT(pt.last_name,', ',pt.first_name,' ',CASE WHEN pt.suffix IS NOT NULL THEN pt.suffix ELSE '' END,' ',CASE WHEN pt.middle_name IS NOT NULL THEN LEFT(pt.middle_name, 1) ELSE '' END) as patient"))
                                    ->first();

        $doctorsConsultation = str_replace('id="doctors" class="mceEditable"', 'id="doctors" class="mceNonEditable"', $consultation->consultation);
        return response()->json([$consultation,$doctorsConsultation]);
    }

    public function store(Request $request)
    {
        $doctorsConsultation = str_replace('id="doctors" class="mceNonEditable"', 'id="doctors" class="mceEditable"', $request->consultation);
        Consultation::find($request->cid)->update(['consultation'=>$doctorsConsultation]);
        Session::flash('toaster', array('success', 'Nurse notes successfully saved.'));
        return redirect('nurseNotes/'.$request->cid);
    }

    public function rcptnLogs($starting = false, $ending = false, $doctor = false)
    {
        if ($starting){
            $query = "";
            $query .= "SELECT qu.queue_status, qu.id as qid, pt.id, pt.birthday, CONCAT(pt.last_name,' ',pt.first_name,' ',
                    CASE WHEN pt.suffix IS NOT NULL THEN pt.suffix ELSE '' END,' ',
                    CASE WHEN pt.middle_name IS NOT NULL THEN pt.middle_name ELSE ''     END) as name,
                    CONCAT(CASE WHEN us.first_name IS NOT NULL THEN us.first_name ELSE '' END,' ',LEFT(us.middle_name, 1),'.',' ',
                    CASE WHEN us.last_name IS NOT NULL THEN us.last_name ELSE '' END) as doctorsname,
                    asgn.status, asgn.id as asgnid, asgn.doctors_id, qu.created_at, F.ff, R.rf, consultations.id as cid FROM queues as qu
                    LEFT JOIN patients as pt ON pt.id = qu.patients_id
                    LEFT JOIN assignations asgn ON asgn.patients_id = qu.patients_id 
                    AND asgn.clinic_code = ".Auth::user()->clinic." 
                    AND DATE(asgn.created_at) = DATE(qu.created_at)
                    LEFT JOIN users us ON us.id = asgn.doctors_id
                    LEFT JOIN (SELECT COUNT(*) as ff, followup.patients_id AS fpid 
                    FROM followup WHERE followup.status = 'P' AND followup.clinic_code = ".Auth::user()->clinic." 
                    GROUP BY patients_id) F ON F.fpid = qu.patients_id
                    LEFT JOIN (SELECT COUNT(*) as rf, refferals.patients_id AS rpid 
                    FROM refferals WHERE refferals.status = 'P' 
                    AND refferals.to_clinic = ".Auth::user()->clinic." 
                    GROUP BY patients_id) R ON R.rpid = qu.patients_id
                    LEFT JOIN consultations ON consultations.patients_id = qu.patients_id
                    WHERE qu.clinic_code = ".Auth::user()->clinic."
                    AND DATE(qu.created_at) BETWEEN '".$starting."' AND '".$ending."' ";
            if ($doctor != 0){
                $query .= "AND asgn.doctors_id = $doctor ";
            }else{
                $query .= '';
            }
            $query .= "GROUP BY qu.patients_id, DATE(qu.created_at) ORDER BY qu.created_at DESC";

            $patients = DB::select("$query");
        }else{
            $patients = null;
        }


        $allDoctors = User::where('role', '=', 7)
            ->select('id', DB::raw("CONCAT(users.first_name,' ',CASE WHEN users.middle_name IS NOT NULL THEN LEFT(users.middle_name, 1) ELSE '' END ,'. ',users.last_name) as name"))
            ->where('clinic', '=', Auth::user()->clinic)
            ->orderBy('name')
            ->get();


        return view('receptions.consultationLogs', compact('patients', 'allDoctors', 'starting', 'ending'));


    }



    public function rcptnLogsShow(Request $request)
    {
        return redirect()->route('rcptnLogs', ['starting'=>$request->starting,'ending'=>$request->ending,'doctor'=>$request->doctor]);
    }



}
