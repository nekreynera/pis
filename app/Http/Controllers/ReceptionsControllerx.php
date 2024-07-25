<?php

namespace App\Http\Controllers;

use App\Cashincome;
use Illuminate\Http\Request;
use App\Patient;
use App\Queue;
use App\Clinic;
use App\VitalSigns;
use App\Assignation;
use App\Requisition;
use App\History;
use App\User;
use App\Triage;
use App\Consultation;
use App\FileManager;
use App\ConsultationsICD;
use App\Diagnosed;
use App\DiagnosisICD;
use App\Mssclassification;
use App\Refferal;
use App\Followup;
use App\Alert;
use Session;
use Validator;
use Auth;
use DB;
use Carbon;

class ReceptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect('overview');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    /*public function patient_info2($id = false, $asgnId = false)
    {
        $patient = Patient::find($id);
        $vital_signs = VitalSigns::where('patients_id', '=', $id)->whereDate('created_at', Carbon::now()->format('Y-m-d'))->latest()->get();
        $consultationStatus = Assignation::find($asgnId);

        $allDoctors = User::where('role', '=', 7)
            ->select('id', DB::raw("CONCAT(users.last_name,' ',users.first_name,' ',users.middle_name) as name"))
            ->where('clinic', '=', Auth::user()->clinic)
            ->orderBy('last_name')
            ->get();

        return view('receptions.patient_info', compact('patient', 'vital_signs', 'consultationStatus', 'allDoctors'));
    }*/


    public function patient_info($id = false)
    {
        $patient =  DB::table('patients')
                    ->leftJoin('mssclassification as mc', 'mc.patients_id', '=', 'patients.id')
                    ->leftJoin('mss', 'mss.id', '=', 'mc.mss_id')
                    ->select('patients.*', 'mss.label', 'mss.discount')
                    ->where('patients.id', '=', $id)
                    ->first();

        $vital_signs = VitalSigns::where('patients_id', '=', $id)->whereDate('created_at', Carbon::now()->format('Y-m-d'))->latest()->get();

        /*$refferals = Refferal::select('refferals.*', 'clinics.name', DB::raw("CONCAT(CASE WHEN us.last_name IS NOT NULL THEN us.last_name ELSE '' END,' ',LEFT(us.middle_name, 1),'.',' ',CASE WHEN us.first_name IS NOT NULL THEN us.first_name ELSE '' END) as doctorsname"))
            ->where('patients_id', '=', $id)
            ->where('to_clinic', '=', Auth::user()->clinic)
            ->where('status', '=', 'P')
            ->leftJoin('users as us', 'us.id', '=', 'refferals.users_id')
            ->leftJoin('clinics', function ($join){
                $join->on('clinics.id', '=', 'refferals.from_clinic');
            })->get();*/

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
                WHERE rf.patients_id = $id AND rf.to_clinic = ".Auth::user()->clinic." AND rf.status = 'P' ");



        /*$followups = Followup::select('followup.*', 'clinics.name', DB::raw("CONCAT(CASE WHEN us.last_name IS NOT NULL THEN us.last_name ELSE '' END,' ',LEFT(us.middle_name, 1),'.',' ',CASE WHEN us.first_name IS NOT NULL THEN us.first_name ELSE '' END) as doctorsname"))
            ->where('patients_id', '=', $id)
            ->where('status', '=', 'P')
            ->where('clinic_code', '=', Auth::user()->clinic)
            ->leftJoin('users as us', 'us.id', '=', 'assignedTo')
            ->leftJoin('clinics', 'clinics.id', '=', 'followup.clinic_code')
            ->get();*/

    $followups = Followup::select('followup.*', 'clinics.name', DB::raw("CONCAT(CASE WHEN us.last_name IS NOT NULL THEN us.last_name ELSE '' END,' ',LEFT(us.middle_name, 1),'.',' ',CASE WHEN us.first_name IS NOT NULL THEN us.first_name ELSE '' END) as doctorsname"))
        ->where('patients_id', '=', $id)
        ->where('status', '=', 'P')
        ->where('clinic_code', '=', Auth::user()->clinic)
        ->leftJoin('users as us', 'us.id', '=', 'assignedTo')
        ->leftJoin('clinics', 'clinics.id', '=', 'followup.clinic_code')
        ->get();
        


        return view('receptions.patient_info', compact('patient', 'vital_signs', 'followups', 'refferals'));
    }



    public function receptionsbarcode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'barcode' => 'required'
        ]);
        if($validator->passes()){
            /*check if patient is already registered*/
            $patient = Patient::where('barcode', '=', $request->barcode)
                                ->orWhere('hospital_no', '=', $request->barcode)
                                ->get()->first();

            if ($patient) {

                $statusArray = array(31,10,48,22,21);

                /*check if patient is mss classified*/
                 //$checkIfClassified = Mssclassification::where('patients_id', '=', $patient->id)->first();
                 /*if (count($checkIfClassified) > 0 || Auth::user()->clinic == 32 || Auth::user()->clinic == 43){

                     if (Auth::user()->clinic == 32 || Auth::user()->clinic == 43){
                         $proceed = true;
                     }else{
                         if (count($checkIfClassified) > 0){
                             $proceed = ($checkIfClassified->validity >= Carbon::now()->toDateString())? true : false;
                         }else{
                             $proceed = false;
                         }
                     }

                     if ($proceed){*/
                        /*check if patient is already on the queue and is on the same clinic*/
                        $checkQueueList = Queue::where('patients_id', '=', $patient->id)
                            ->where('clinic_code', '=', Auth::user()->clinic)
                            ->whereDate('created_at', Carbon::now()->format('Y-m-d'))
                            ->count();
                        if ($checkQueueList <= 0) {
                            $queue = new Queue;
                            $queue->patients_id = $patient->id;
                            $queue->users_id = Auth::user()->id;
                            $queue->clinic_code = Auth::user()->clinic;

                            if (in_array(Auth::user()->clinic, $statusArray)){ /*check if clinic does not have a doctor*/
                                $queue->queue_status = 'P';
                            }

                            $queue->save();
                            Session::flash('toaster', array('success', 'Patient is now on the queue list'));

                            /*if (Auth::user()->clinic != 8){
                                return redirect('overview/T');
                            }*/
                            return redirect('overview');
                        }else{
                            Session::flash('toaster', array('error', 'Patient is already on the queue list.'));
                            return redirect()->back()->withInput();
                        }
                     /*}else{
                         Session::flash('toaster', array('error', 'MSS Classification already expired.'));
                         return redirect()->back()->withInput();
                     }
                 }else{
                     Session::flash('toaster', array('error', 'Patient is not yet MSS classified and will not be included in the queue list. Kindly advise the patient to proceed to MSS for classification.'));
                     return redirect()->back()->withInput();
                 }*/
            }else{
                Session::flash('toaster', array('error', 'Credentials Not Found'));
                return redirect()->back()->withInput();
            }
        }else{
            return redirect()->back()->withErrors($validator);
        }
    }




    public function queueStatus($qid, $status)
    {
        Queue::find($qid)->update(['queue_status'=>$status]);
        if ($status == 'F'){
            $autoDoneOfCashincome = array(21,22,48);
            $patient = Queue::find($qid);

            if (in_array(Auth::user()->clinic, $autoDoneOfCashincome)){
                    DB::table('cashincome')
                    ->where([
                        ['cc.clinic_id', Auth::user()->clinic],
                        ['cashincome.patients_id', $patient->patients_id],
                    ])
                    ->leftJoin('ancillaryrequist as an', 'an.id', 'cashincome.ancillaryrequist_id')
                    ->leftJoin('cashincomesubcategory as cs', 'cs.id', 'an.cashincomesubcategory_id')
                    ->leftJoin('cashincomecategory as cc', 'cc.id', 'cs.cashincomecategory_id')
                    ->update(['cashincome.get' => 'Y']);
            }
        }


        return redirect()->back()->with('toaster', array('success', 'Patient status changed'));
    }




    public function done($id, $status)
    {
        Cashincome::find($id)->update(['get'=>$status]);
        return redirect()->back()->with('toaster', array('success', 'Item successfully done'));
    }


    /*public function cancelQueue($qid = false)
    {
        Queue::find($qid)->update(['queue_status'=>'C']);
        return redirect()->back()->with('toaster', array('error', 'Patient marked as NAWC'));
    }*/



    public function overview($status = false)
    {
        $noDoctorsClinic = array(31,10,48,22,21);
        // if (in_array(Auth::user()->clinic, $noDoctorsClinic)){
        //     switch ($status){
        //         case 'P':
        //             $statistic = "AND qu.queue_status = 'P'";
        //             break;
        //         case 'C':
        //             $statistic = "AND qu.queue_status = 'C'";
        //             break;
        //         case 'F':
        //             $statistic = "AND qu.queue_status = 'F'";
        //             break;
        //         case 'T':
        //             $statistic = "";
        //             break;
        //         case 'D':
        //             $statistic = "AND qu.queue_status = 'D'";
        //             break;
        //         default:
        //             $statistic = "AND qu.queue_status = 'P'";
        //             break;
        //     }
        // }else{
        //     switch ($status){
        //         case 'S':
        //             $statistic = "AND asgn.status = 'S'";
        //             break;
        //         case 'P':
        //             $statistic = "AND asgn.status = 'P'";
        //             break;
        //         case 'C':
        //             $statistic = "AND asgn.status = 'C'";
        //             break;
        //         case 'F':
        //             $statistic = "AND asgn.status = 'F'";
        //             break;
        //         case 'H':
        //             $statistic = "AND asgn.status = 'H'";
        //             break;
        //         case 'T':
        //             $statistic = "";
        //             break;
        //         default:
        //             $statistic = "AND asgn.status IS NULL";
        //             break;
        //     }
        // }

        // $patients = DB::select("SELECT pt.id, pt.birthday, pt.barcode, qu.queue_status, qu.id as qid, CONCAT(pt.last_name,' ',pt.first_name,' ',CASE WHEN pt.suffix IS NOT NULL THEN pt.suffix ELSE '' END,' ',CASE WHEN pt.middle_name IS NOT NULL THEN pt.middle_name ELSE ''     END) as name,
        //             CONCAT(CASE WHEN us.first_name IS NOT NULL THEN us.first_name ELSE '' END,' ',LEFT(us.middle_name, 1),'.',' ',CASE WHEN us.last_name IS NOT NULL THEN us.last_name ELSE '' END) as doctorsname, 
        //             asgn.status, asgn.id as asgnid, asgn.doctors_id, qu.created_at, F.ff, R.rf, consultations.id as cid FROM queues as qu
        //             LEFT JOIN patients as pt ON pt.id = qu.patients_id
        //             LEFT JOIN assignations asgn ON asgn.patients_id = qu.patients_id AND asgn.clinic_code = ".Auth::user()->clinic." AND DATE(asgn.created_at) = CURDATE()
        //             LEFT JOIN users us ON us.id = asgn.doctors_id
        //             LEFT JOIN (SELECT COUNT(*) as ff, followup.patients_id AS fpid FROM followup WHERE followup.status = 'P' AND followup.clinic_code = ".Auth::user()->clinic." GROUP BY patients_id) F ON F.fpid = qu.patients_id
        //             LEFT JOIN (SELECT COUNT(*) as rf, refferals.patients_id AS rpid FROM refferals WHERE refferals.status = 'P' AND refferals.to_clinic = ".Auth::user()->clinic." GROUP BY patients_id) R ON R.rpid = qu.patients_id
        //             LEFT JOIN consultations ON consultations.patients_id = qu.patients_id
        //             WHERE DATE(qu.created_at) = CURDATE()
        //             AND qu.clinic_code = ".Auth::user()->clinic."
        //             ".$statistic."
        //             GROUP BY qu.patients_id ORDER BY qu.created_at ASC");


        // $allDoctors = User::where('role', '=', 7)
        //                     ->select('id', DB::raw("CONCAT(users.first_name,' ',CASE WHEN users.middle_name IS NOT NULL THEN LEFT(users.middle_name, 1) ELSE '' END ,'. ',users.last_name) as name"))
        //                     ->where('clinic', '=', Auth::user()->clinic)
        //                     ->where('activated', 'Y')
        //                     ->orderBy('name')
                            // ->get();


        // $doctors = DB::select("select CONCAT(us.first_name,' ', LEFT(us.middle_name, 1),'.',' ',us.last_name) as name, A.id, B.pending, C.cancel, S.serving, F.finished, H.paused from users A
        //             LEFT JOIN (select assignations.doctors_id, COUNT(*) AS pending from assignations where assignations.status is NOT null and assignations.status = 'P'
        //             AND DATE(assignations.created_at) = CURDATE() GROUP by assignations.doctors_id) B on A.id = B.doctors_id
        //             LEFT JOIN (select assignations.doctors_id,COUNT(*) AS cancel from assignations where assignations.status is NOT null and assignations.status = 'C'
        //             AND DATE(assignations.created_at) = CURDATE() GROUP by assignations.doctors_id) C on A.id = C.doctors_id
        //             LEFT JOIN (select assignations.doctors_id,COUNT(*) AS serving from assignations where assignations.status is NOT null and assignations.status = 'S'
        //             AND DATE(assignations.created_at) = CURDATE() GROUP by assignations.doctors_id) S on A.id = S.doctors_id
        //             LEFT JOIN (select assignations.doctors_id,COUNT(*) AS finished from assignations where assignations.status is NOT null and assignations.status = 'F'
        //             AND DATE(assignations.created_at) = CURDATE() GROUP by assignations.doctors_id) F on A.id = F.doctors_id
        //             LEFT JOIN (select assignations.doctors_id,COUNT(*) AS paused from assignations where assignations.status is NOT null and assignations.status = 'H'
        //             AND DATE(assignations.created_at) = CURDATE() GROUP by assignations.doctors_id) H on A.id = H.doctors_id
        //             LEFT JOIN users us ON us.id = A.id
        //             WHERE us.role = 7 AND us.clinic = ".Auth::user()->clinic."
        //             AND us.activated = 'Y'
        //             GROUP BY A.id");


        if (in_array(Auth::user()->clinic, $noDoctorsClinic)){
            $survey = Queue::where('clinic_code', Auth::user()->clinic)
                            ->select(DB::raw("COUNT(*) as total"), 'queue_status as status')
                            ->whereDate(DB::raw("DATE(created_at)"), DB::raw("CURDATE()"))
                            ->groupBy('queue_status')
                            ->get();
        }else{
            $survey = DB::select("SELECT DISTINCT(SELECT COUNT(*) FROM assignations asgn WHERE clinic_code = ".Auth::user()->clinic."
                    AND DATE(asgn.created_at) = CURDATE() AND status = 'P') AS pending,(SELECT COUNT(*) FROM assignations asgn WHERE clinic_code = ".Auth::user()->clinic."
                    AND DATE(asgn.created_at) = CURDATE() AND status = 'F') as finished,(SELECT COUNT(*) FROM assignations asgn WHERE clinic_code = ".Auth::user()->clinic."
                    AND DATE(asgn.created_at) = CURDATE() AND status = 'C') as nawc,(SELECT COUNT(*) FROM assignations asgn WHERE clinic_code = ".Auth::user()->clinic."
                    AND DATE(asgn.created_at) = CURDATE() AND status = 'H') as paused,(SELECT COUNT(*) FROM assignations asgn WHERE clinic_code = ".Auth::user()->clinic."
                    AND DATE(asgn.created_at) = CURDATE() AND status = 'S') as serving FROM assignations asgn WHERE clinic_code = ".Auth::user()->clinic."
                    AND DATE(asgn.created_at) = CURDATE()");
        }


        // $unassigend = DB::select("SELECT COUNT(*) FROM queues as qu
        //             LEFT JOIN assignations asgn ON asgn.patients_id = qu.patients_id AND asgn.clinic_code = ".Auth::user()->clinic." AND DATE(asgn.created_at) = CURDATE()
        //             WHERE DATE(qu.created_at) = CURDATE()
        //             AND qu.clinic_code = ".Auth::user()->clinic."
        //             AND status IS NULL
        //             GROUP BY qu.patients_id");

        $alert = Alert::where('clinic', Auth::user()->clinic)->first();
         return view('receptions.overview', compact('status', 'alert', 'survey'));
         // return view('receptions.overview', compact('patients', 'status', 'allDoctors', 'alert', 'survey'));
    }

    public function loadDoctors()
    {
        $doctors = DB::select("select CONCAT(us.first_name,' ', LEFT(us.middle_name, 1),'.',' ',us.last_name) as name, A.id, B.pending, C.cancel, S.serving, F.finished, H.paused,
                    '' as 'activeStat' from users A
                    LEFT JOIN (select assignations.doctors_id, COUNT(*) AS pending from assignations where assignations.status is NOT null and assignations.status = 'P'
                    AND DATE(assignations.created_at) = CURDATE() GROUP by assignations.doctors_id) B on A.id = B.doctors_id
                    LEFT JOIN (select assignations.doctors_id,COUNT(*) AS cancel from assignations where assignations.status is NOT null and assignations.status = 'C'
                    AND DATE(assignations.created_at) = CURDATE() GROUP by assignations.doctors_id) C on A.id = C.doctors_id
                    LEFT JOIN (select assignations.doctors_id,COUNT(*) AS serving from assignations where assignations.status is NOT null and assignations.status = 'S'
                    AND DATE(assignations.created_at) = CURDATE() GROUP by assignations.doctors_id) S on A.id = S.doctors_id
                    LEFT JOIN (select assignations.doctors_id,COUNT(*) AS finished from assignations where assignations.status is NOT null and assignations.status = 'F'
                    AND DATE(assignations.created_at) = CURDATE() GROUP by assignations.doctors_id) F on A.id = F.doctors_id
                    LEFT JOIN (select assignations.doctors_id,COUNT(*) AS paused from assignations where assignations.status is NOT null and assignations.status = 'H'
                    AND DATE(assignations.created_at) = CURDATE() GROUP by assignations.doctors_id) H on A.id = H.doctors_id
                    LEFT JOIN users us ON us.id = A.id
                    WHERE us.role = 7 AND us.clinic = ".Auth::user()->clinic."
                    AND us.activated = 'Y'
                    GROUP BY A.id");

        $listDoctors = array();

        foreach ($doctors as $key => $value) {
            $listDoctors[$key]['id'] = $value->id;
            $listDoctors[$key]['name'] = $value->name;
            $listDoctors[$key]['serving'] = $value->serving;
            $listDoctors[$key]['finished'] = $value->finished;
            $listDoctors[$key]['pending'] = $value->pending;
            $listDoctors[$key]['paused'] = $value->paused;
            $listDoctors[$key]['cancel'] = $value->cancel;
            $listDoctors[$key]['activeStat'] = $this->isDoctorActive($value->id);
        }

        return response()->json($Auth::user()->clinic);
    }

    public function isDoctorActive($id)
    {
        return Cache::has('active_'.$id);
    }

    public function loadStatus()
    {
        $noDoctorsClinic = array(31,10,48,22,21);
        // if (in_array(Auth::user()->clinic, $noDoctorsClinic)){
        //     $survey = Queue::where('clinic_code', Auth::user()->clinic)
        //                     ->select(DB::raw("COUNT(*) as total"), 'queue_status as status')
        //                     ->whereDate(DB::raw("DATE(created_at)"), DB::raw("CURDATE()"))
        //                     ->groupBy('queue_status')
        //                     ->get();
        // }else{
            $survey = DB::select("SELECT DISTINCT(SELECT COUNT(*) FROM assignations asgn WHERE clinic_code = ".Auth::user()->clinic."
                    AND DATE(asgn.created_at) = CURDATE() AND status = 'P') AS pending,(SELECT COUNT(*) FROM assignations asgn WHERE clinic_code = ".Auth::user()->clinic."
                    AND DATE(asgn.created_at) = CURDATE() AND status = 'F') as finished,(SELECT COUNT(*) FROM assignations asgn WHERE clinic_code = ".Auth::user()->clinic."
                    AND DATE(asgn.created_at) = CURDATE() AND status = 'C') as nawc,(SELECT COUNT(*) FROM assignations asgn WHERE clinic_code = ".Auth::user()->clinic."
                    AND DATE(asgn.created_at) = CURDATE() AND status = 'H') as paused,(SELECT COUNT(*) FROM assignations asgn WHERE clinic_code = ".Auth::user()->clinic."
                    AND DATE(asgn.created_at) = CURDATE() AND status = 'S') as serving FROM assignations asgn WHERE clinic_code = ".Auth::user()->clinic."
                    AND DATE(asgn.created_at) = CURDATE()");
        // }

        $unassigend = DB::select("SELECT COUNT(*) FROM queues as qu
                    LEFT JOIN assignations asgn ON asgn.patients_id = qu.patients_id AND asgn.clinic_code = ".Auth::user()->clinic." AND DATE(asgn.created_at) = CURDATE()
                    WHERE DATE(qu.created_at) = CURDATE()
                    AND qu.clinic_code = ".Auth::user()->clinic."
                    AND status IS NULL
                    GROUP BY qu.patients_id");



        return response()->json(array_merge($survey, ['unassigned' => $unassigend, 'userClinic' => Auth::user()->clinic]));
    }

    public function loadPatients()
    {
        $status = request('status');
        $noDoctorsClinic = array(31,10,48,22,21);
        $chrgingClinics = array(3,5,8,24,32,34,10,48,22,21,25,11,26,52,17);
        if (in_array(Auth::user()->clinic, $noDoctorsClinic)){
            switch ($status){
                case 'P':
                    $statistic = "AND qu.queue_status = 'P'";
                    break;
                case 'C':
                    $statistic = "AND qu.queue_status = 'C'";
                    break;
                case 'F':
                    $statistic = "AND qu.queue_status = 'F'";
                    break;
                case 'T':
                    $statistic = "";
                    break;
                case 'D':
                    $statistic = "AND qu.queue_status = 'D'";
                    break;
                default:
                    $statistic = "AND qu.queue_status = 'P'";
                    break;
            }
        }else{
            switch ($status){
                case 'S':
                    $statistic = "AND asgn.status = 'S'";
                    break;
                case 'P':
                    $statistic = "AND asgn.status = 'P'";
                    break;
                case 'C':
                    $statistic = "AND asgn.status = 'C'";
                    break;
                case 'F':
                    $statistic = "AND asgn.status = 'F'";
                    break;
                case 'H':
                    $statistic = "AND asgn.status = 'H'";
                    break;
                case 'T':
                    $statistic = "";
                    break;
                default:
                    $statistic = "AND asgn.status IS NULL";
                    break;
            }
        }

        $patients = DB::select("SELECT pt.id, pt.birthday, pt.barcode, qu.queue_status, qu.id as qid, CONCAT(pt.last_name,' ',pt.first_name,' ',CASE WHEN pt.suffix IS NOT NULL THEN pt.suffix ELSE '' END,' ',CASE WHEN pt.middle_name IS NOT NULL THEN pt.middle_name ELSE ''     END) as name,
                    CONCAT(CASE WHEN us.first_name IS NOT NULL THEN us.first_name ELSE '' END,' ',LEFT(us.middle_name, 1),'.',' ',CASE WHEN us.last_name IS NOT NULL THEN us.last_name ELSE '' END) as doctorsname, 
                    asgn.status, asgn.id as asgnid, asgn.doctors_id, qu.created_at, F.ff, R.rf, consultations.id as cid FROM queues as qu
                    LEFT JOIN patients as pt ON pt.id = qu.patients_id
                    LEFT JOIN assignations asgn ON asgn.patients_id = qu.patients_id AND asgn.clinic_code = ".Auth::user()->clinic." AND DATE(asgn.created_at) = CURDATE()
                    LEFT JOIN users us ON us.id = asgn.doctors_id
                    LEFT JOIN (SELECT COUNT(*) as ff, followup.patients_id AS fpid FROM followup WHERE followup.status = 'P' AND followup.clinic_code = ".Auth::user()->clinic." GROUP BY patients_id) F ON F.fpid = qu.patients_id
                    LEFT JOIN (SELECT COUNT(*) as rf, refferals.patients_id AS rpid FROM refferals WHERE refferals.status = 'P' AND refferals.to_clinic = ".Auth::user()->clinic." GROUP BY patients_id) R ON R.rpid = qu.patients_id
                    LEFT JOIN consultations ON consultations.patients_id = qu.patients_id
                    WHERE DATE(qu.created_at) = CURDATE()
                    AND qu.clinic_code = ".Auth::user()->clinic."
                    ".$statistic."
                    GROUP BY qu.patients_id ORDER BY qu.created_at ASC");

        $allDoctors = User::where('role', '=', 7)
                            ->select('id', DB::raw("CONCAT(users.first_name,' ',CASE WHEN users.middle_name IS NOT NULL THEN LEFT(users.middle_name, 1) ELSE '' END ,'. ',users.last_name) as name"))
                            ->where('clinic', '=', Auth::user()->clinic)
                            ->where('activated', 'Y')
                            ->orderBy('name')
                            ->get();

        $loadPatients = array();

        foreach ($patients as $key => $value) {
            $loadPatients[$key]['id'] = $value->id;
            $loadPatients[$key]['birthday'] = $value->birthday;
            $loadPatients[$key]['barcode'] = $value->barcode;
            $loadPatients[$key]['queue_status'] = $value->queue_status;
            $loadPatients[$key]['qid'] = $value->qid;
            $loadPatients[$key]['name'] = $value->name;
            $loadPatients[$key]['doctorsname'] = $value->doctorsname;
            $loadPatients[$key]['status'] = $value->status;
            $loadPatients[$key]['asgnid'] = $value->asgnid;
            $loadPatients[$key]['asgnid'] = $value->asgnid;
            $loadPatients[$key]['doctors_id'] = $value->doctors_id;
            $loadPatients[$key]['created_at'] = $value->created_at;
            $loadPatients[$key]['ff'] = $value->ff;
            $loadPatients[$key]['rf'] = $value->rf;
            $loadPatients[$key]['cid'] = $value->cid;
            $loadPatients[$key]['authCheck'] = in_array(Auth::user()->clinic, $noDoctorsClinic);
            $loadPatients[$key]['age'] = Patient::age($value->birthday);
            $loadPatients[$key]['userClinic'] = Auth::user()->clinic;
            $loadPatients[$key]['activeStat'] = $this->isDoctorActive($value->doctors_id);
            $loadPatients[$key]['checkIfForRefferal'] = $value->ff + $value->rf > 0 ? Refferal::checkIfForRefferal($value->id) : array();
            foreach ($allDoctors as $key2 => $doctor) {
                $loadPatients[$key]['allDoctors'][$key2]['id'] = $doctor->id;
                $loadPatients[$key]['allDoctors'][$key2]['name'] = $doctor->name;
                $loadPatients[$key]['allDoctors'][$key2]['doctorActiveStat'] = $this->isDoctorActive($doctor->id);
            }
            $loadPatients[$key]['assignedDoctor'] = Refferal::countAllNotifications($value->id);
            // $loadPatients[$key]['charging'] = Ancillaryrequist::otherCharging($value->id);
            // $loadPatients[$key]['undoneItems'] = Cashincome::getAllUndonedItems($value->id);
        }

        return response()->json($loadPatients);
    }

    public function getAllActiveDoctors()
    {
        $allDoctors = User::where('role', '=', 7)
                            ->select('id', DB::raw("CONCAT(users.first_name,' ',CASE WHEN users.middle_name IS NOT NULL THEN LEFT(users.middle_name, 1) ELSE '' END ,'. ',users.last_name) as name"))
                            ->where('clinic', '=', Auth::user()->clinic)
                            ->where('activated', 'Y')
                            ->orderBy('name')
                            ->get();

        $loadPatients = array();
        foreach ($allDoctors as $key => $doctor) {
            $loadPatients[$key]['id'] = $doctor->id;
            $loadPatients[$key]['name'] = $doctor->name;
            $loadPatients[$key]['doctorActiveStat'] = $this->isDoctorActive($doctor->id);
            $loadPatients[$key]['assignedDoctor'] = Refferal::countAllNotifications(request('pid'));
        }

        return response()->json($loadPatients);
    }

    public function loadCharging()
    {
        $request_ids = request('ids');
        $request_queue_stat = request('queueStat');
        $ids = explode(",",$request_ids);
        $queue_stat = explode(",",$request_queue_stat);
        $countID = count($ids);
        $chrgingClinics = array(3,5,8,24,32,34,10,48,22,21,25,11,26,52,17);

        for ($i=0;$i<$countID;$i++) {
            $charging[$i]['id'] = $ids[$i];
            $charging[$i]['charging'] = in_array(Auth::user()->clinic, $chrgingClinics) ? Ancillaryrequist::otherCharging($ids[$i]) : '';
            $charging[$i]['queue_stat'] = $queue_stat[$i];
            $charging[$i]['userClinic'] = Auth::user()->clinic;
        }

        return response()->json($charging);
    }

    public function loadCountConsultation()
    {
        $request_ids = request('ids');
        $ids = explode(",",$request_ids);
        $countID = count($ids);

        for ($i=0;$i<$countID;$i++) {
            $consultationCount[$i]['id'] = $ids[$i];
            $consultationCount[$i]['note_id'] = Cashincome::getNoteId($ids[$i]);
            $consultationCount[$i]['consultationCount'] = Consultation::check_saved_consultation_exist($ids[$i]);
        }

        return  response()->json($consultationCount);
    }

    public function loadAllUndonePatients()
    {
        $request_ids = request('ids');
        $ids = explode(",",$request_ids);
        $countID = count($ids);
        $chrgingClinics = array(3,5,8,24,32,34,10,48,22,21,25,11,26,52,17);
        $loadAllUndone = array();

        for ($i=0;$i<$countID;$i++) {
            $loadAllUndone[$i]['id'] = $ids[$i];
            $loadAllUndone[$i]['loadAllUndone'] = in_array(Auth::user()->clinic, $chrgingClinics) ? Cashincome::getAllUndonedItems($ids[$i]) : array();
        }
        return response()->json($loadAllUndone);
    }



    public function status($did = false, $status = false)
    {
        /*$assignations = DB::table('assignations')
                                ->select('assignations.*', DB::raw("CONCAT(pt.last_name,' ',pt.first_name,' ',CASE WHEN pt.suffix IS NOT NULL THEN pt.suffix ELSE '' END,' ',CASE WHEN pt.middle_name IS NOT NULL THEN pt.middle_name ELSE '' END) as name"))
                                ->where('doctors_id', '=', $did)
                                ->leftJoin('patients as pt', 'pt.id', '=', 'assignations.patients_id')
                                ->where('status', '=', $status)
                                ->whereDate('assignations.created_at', Carbon::now()->format('Y-m-d'))
                                ->where('assignations.clinic_code', '=', Auth::user()->clinic)
                                ->get();*/

        $doctor = User::find($did);

        $patients = DB::select("SELECT pt.id, pt.birthday, pt.barcode, CONCAT(pt.last_name,' ',pt.first_name,' ',CASE WHEN pt.suffix IS NOT NULL THEN pt.suffix ELSE '' END,' ',CASE WHEN pt.middle_name IS NOT NULL THEN pt.middle_name ELSE '' END) as name, 
                    CONCAT(CASE WHEN us.first_name IS NOT NULL THEN us.first_name ELSE '' END,' ',LEFT(us.middle_name, 1),'.',' ',CASE WHEN us.last_name IS NOT NULL THEN us.last_name ELSE '' END) as doctorsname, 
                    asgn.status, asgn.id as asgnid, asgn.doctors_id, asgn.created_at, F.ff, R.rf, consultations.id as cid, MAX(qu.created_at) created_at FROM queues as qu
                    LEFT JOIN patients as pt ON pt.id = qu.patients_id
                    LEFT JOIN assignations asgn ON asgn.patients_id = qu.patients_id AND asgn.clinic_code = ".Auth::user()->clinic." AND DATE(asgn.created_at) = CURDATE()
                    LEFT JOIN users us ON us.id = asgn.doctors_id
                    LEFT JOIN (SELECT COUNT(*) as ff, followup.patients_id AS fpid FROM followup WHERE followup.status = 'P' AND followup.clinic_code = ".Auth::user()->clinic." GROUP BY patients_id) F ON F.fpid = qu.patients_id
                    LEFT JOIN (SELECT COUNT(*) as rf, refferals.patients_id AS rpid FROM refferals WHERE refferals.status = 'P' AND refferals.to_clinic = ".Auth::user()->clinic." GROUP BY patients_id) R ON R.rpid = qu.patients_id
                    LEFT JOIN consultations ON consultations.patients_id = qu.patients_id
                    WHERE DATE(asgn.created_at) = CURDATE()
                    AND asgn.status = '".$status."'
                    AND asgn.doctors_id = $did
                    GROUP BY qu.patients_id ORDER BY asgn.created_at DESC");

        $allDoctors = User::where('role', '=', 7)
            ->select('id', DB::raw("CONCAT(users.first_name,' ',CASE WHEN users.middle_name IS NOT NULL THEN LEFT(users.middle_name, 1) ELSE '' END ,'. ',users.last_name) as name"))
            ->where('clinic', '=', Auth::user()->clinic)
            ->orderBy('name')
            ->get();

        return view('receptions.status', compact('allDoctors', 'patients', 'doctor', 'status'));

    }





    public function patientsearch()
    {
        return view('receptions.searchpatient');
    }




    public function searchpatient(Request $request)
    {
        if($request->name){
            $patients = DB::table('patients')
                ->select('patients.*', 'consultations.id as cid')
                ->leftJoin('consultations', 'consultations.patients_id', 'patients.id')
                ->where(DB::raw("CONCAT(last_name,' ',first_name,' ',middle_name)"), 'like', '%'.$request->name.'%')
                ->groupBy('patients.id')
                ->get();
        }elseif ($request->birthday) {
            $patients = Patient::where('birthday', 'like', $request->birthday.'%')
                ->select('patients.*', 'consultations.id as cid')
                ->leftJoin('consultations', 'consultations.patients_id', 'patients.id')
                ->groupBy('patients.id')
                ->get();
        }elseif ($request->barcode) {
            $patients = Patient::where('barcode', 'like', '%'.$request->barcode.'%')
                ->select('patients.*', 'consultations.id as cid')
                ->leftJoin('consultations', 'consultations.patients_id', 'patients.id')
                ->groupBy('patients.id')
                ->get();
        }elseif ($request->hospital_no) {
            $patients = Patient::where('hospital_no', 'like', '%'.$request->hospital_no.'%')
                ->select('patients.*', 'consultations.id as cid')
                ->leftJoin('consultations', 'consultations.patients_id', 'patients.id')
                ->groupBy('patients.id')
                ->get();
        }elseif ($request->created_at) {
            $patients = Patient::where('created_at', 'like', $request->created_at.'%')
                ->select('patients.*', 'consultations.id as cid')
                ->leftJoin('consultations', 'consultations.patients_id', 'patients.id')
                ->groupBy('patients.id')
                ->get();
        }
        if (isset($patients) && count($patients) > 0) {
            Session::flash('toaster', array('success', 'Matching Records Found.'));
            return view('receptions.searchpatient', compact('patients'));
        }
        Session::flash('toaster', array('error', 'No Matching Records Found.'));
        return view('receptions.searchpatient');
    }




    public function doctorsStatus()
    {
        $doctors = DB::select("select CONCAT(us.first_name,' ', LEFT(us.middle_name, 1),'.',' ',us.last_name) as name, A.id, B.pending, C.cancel, S.serving, F.finished, H.paused from users A
                    LEFT JOIN (select assignations.doctors_id, COUNT(*) AS pending from assignations where assignations.status is NOT null and assignations.status = 'P'
                    AND DATE(assignations.created_at) = CURDATE() GROUP by assignations.doctors_id) B on A.id = B.doctors_id
                    LEFT JOIN (select assignations.doctors_id,COUNT(*) AS cancel from assignations where assignations.status is NOT null and assignations.status = 'C'
                    AND DATE(assignations.created_at) = CURDATE() GROUP by assignations.doctors_id) C on A.id = C.doctors_id
                    LEFT JOIN (select assignations.doctors_id,COUNT(*) AS serving from assignations where assignations.status is NOT null and assignations.status = 'S'
                    AND DATE(assignations.created_at) = CURDATE() GROUP by assignations.doctors_id) S on A.id = S.doctors_id
                    LEFT JOIN (select assignations.doctors_id,COUNT(*) AS finished from assignations where assignations.status is NOT null and assignations.status = 'F'
                    AND DATE(assignations.created_at) = CURDATE() GROUP by assignations.doctors_id) F on A.id = F.doctors_id
                    LEFT JOIN (select assignations.doctors_id,COUNT(*) AS paused from assignations where assignations.status is NOT null and assignations.status = 'H'
                    AND DATE(assignations.created_at) = CURDATE() GROUP by assignations.doctors_id) H on A.id = H.doctors_id
                    LEFT JOIN users us ON us.id = A.id
                    WHERE us.role = 7 AND us.clinic = ".Auth::user()->clinic."
                    GROUP BY A.id");

        return view('receptions.doctors', compact('doctors'));
    }




    public function patientsStatus()
    {
        /*$patients = DB::table('queues as qu')
            ->select('pt.id', DB::raw("CONCAT(pt.last_name,' ',pt.first_name,' ',CASE WHEN pt.suffix IS NOT NULL THEN pt.suffix ELSE '' END,' ',CASE WHEN pt.middle_name IS NOT NULL THEN pt.middle_name ELSE '' END) as name"), DB::raw("CONCAT(CASE WHEN us.first_name IS NOT NULL THEN us.first_name ELSE '' END,' ',LEFT(us.middle_name, 1),'.',' ',CASE WHEN us.last_name IS NOT NULL THEN us.last_name ELSE '' END) as doctorsname"), 'asgn.status', 'asgn.id as asgnid', 'asgn.doctors_id', 'qu.created_at')
            ->whereDate('qu.created_at', Carbon::now()->format('Y-m-d'))
            ->leftJoin('patients as pt', 'pt.id', '=', 'qu.patients_id')
            ->where('qu.clinic_code', '=', Auth::user()->clinic)
            ->leftJoin('assignations as asgn', function($join){
                $join->on('asgn.patients_id', '=', 'qu.patients_id');
                $join->on('asgn.clinic_code', '=', 'qu.clinic_code');
                $join->whereDate('asgn.created_at', '=', Carbon::now()->format('Y-m-d'));
            })
            ->leftJoin('users as us', 'us.id', '=', 'asgn.doctors_id')
            ->orderBy('qu.created_at', 'DESC')
            ->get();*/

        $patients = DB::select("SELECT pt.id, pt.birthday, CONCAT(pt.last_name,' ',pt.first_name,' ',CASE WHEN pt.suffix IS NOT NULL THEN pt.suffix ELSE '' END,' ',CASE WHEN pt.middle_name IS NOT NULL THEN pt.middle_name ELSE ''     END) as name, 
                    CONCAT(CASE WHEN us.first_name IS NOT NULL THEN us.first_name ELSE '' END,' ',LEFT(us.middle_name, 1),'.',' ',CASE WHEN us.last_name IS NOT NULL THEN us.last_name ELSE '' END) as doctorsname, 
                    asgn.status, asgn.id as asgnid, asgn.doctors_id, qu.created_at, F.ff, R.rf, consultations.id as cid FROM queues as qu
                    LEFT JOIN patients as pt ON pt.id = qu.patients_id
                    LEFT JOIN assignations asgn ON asgn.patients_id = qu.patients_id AND asgn.clinic_code = ".Auth::user()->clinic." AND DATE(asgn.created_at) = CURDATE()
                    LEFT JOIN users us ON us.id = asgn.doctors_id
                    LEFT JOIN (SELECT COUNT(*) as ff, followup.patients_id AS fpid FROM followup WHERE followup.status = 'P' AND followup.clinic_code = ".Auth::user()->clinic." GROUP BY patients_id) F ON F.fpid = qu.patients_id
                    LEFT JOIN (SELECT COUNT(*) as rf, refferals.patients_id AS rpid FROM refferals WHERE refferals.status = 'P' AND refferals.to_clinic = ".Auth::user()->clinic." GROUP BY patients_id) R ON R.rpid = qu.patients_id
                    LEFT JOIN consultations ON consultations.patients_id = qu.patients_id
                    WHERE DATE(qu.created_at) = CURDATE()
                    AND qu.clinic_code = ".Auth::user()->clinic."
                    GROUP BY qu.patients_id ORDER BY qu.created_at DESC");

        $allDoctors = User::where('role', '=', 7)
            ->select('id', DB::raw("CONCAT(CASE WHEN users.first_name IS NOT NULL THEN users.first_name ELSE '' END,' ',LEFT(users.middle_name, 1),'.',' ',CASE WHEN users.last_name IS NOT NULL THEN users.last_name ELSE '' END) as name"))
            ->where('clinic', '=', Auth::user()->clinic)
            ->orderBy('last_name')
            ->get();

        return view('receptions.patients', compact('patients', 'allDoctors'));
    }

    public function vs_scanbarcode(){
        return view('receptions.vs_scanbarcode');
    }


    public function vs_verifybarcode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'barcode' => 'required'
        ]);
        if($validator->passes()){
            /*check if patient is already registered*/
            $patient = Patient::where('barcode', '=', $request->barcode)->get()->first();
            if ($patient) {
                return redirect('vitalSigns/'.$patient->id);
            }else{
                Session::flash('toaster', array('error', 'Barcode unrecognized.'));
                return redirect()->back()->withInput();
            }
        }else{
            return redirect()->back()->withErrors($validator);
        }
    }


    public function vitalSigns($id = false)
    {
        $patient = Patient::find($id);
        $clinics = Clinic::orderBy('name')->get();
        $clinicID = Clinic::find(Auth::user()->clinic);
        return view('receptions.vital_signs', compact('patient', 'clinics', 'clinicID'));
    }


    public function storeVitalSigns(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'clinic_code' => 'required',
        ]);
        if ($validator->passes()) {
            $request->request->add(['users_id' => Auth::user()->id]);
            $triage = Triage::create($request->all());

            $vitalsigns = new VitalSigns();
            $vitalsigns->storeVitalSigns($request, $triage->id, $request->patients_id);
            Session::flash('toaster', array('success', 'Vital Signs successfully saved.'));
            return redirect()->back();
        }else{
            return redirect()->back()->withInput()->withErrors($validator);
        }
    }



    public function receptions_records($id = false)
    {
        $history = History::records($id);
        return view('receptions.records', compact('history'));
    }


    public function receptions_reqList($id = false)
    {
        $requisitions = Requisition::where('patients_id', '=', $id)
                                    ->leftJoin('patients as pt', 'pt.id', '=', 'requisition.patients_id')
                                    ->leftJoin('users as us', 'us.id', '=', 'requisition.users_id')
                                    ->leftJoin('clinics', 'clinics.id', '=', 'us.clinic')
                                    ->groupBy('requisition.users_id', 'requisition.modifier', DB::raw("DATE(requisition.created_at)"))
                                    ->orderBy('requisition.created_at', 'DESC')
                                    ->select('requisition.*', 'clinics.name as clinic', DB::raw("CONCAT(pt.last_name,', ',pt.first_name,' ',CASE WHEN pt.suffix IS NOT NULL THEN pt.suffix ELSE '' END,' ',CASE WHEN pt.middle_name IS NOT NULL THEN LEFT(pt.middle_name, 1) ELSE '' END) as name"), DB::raw("CONCAT(us.first_name,' ', LEFT(us.middle_name, 1),'.',' ',us.last_name) as doctor"))
                                    ->get();
        return view('receptions.requisition_list', compact('requisitions'));
    }

    public function receptions_reqShow($id = false)
    {
        $requisition = Requisition::find($id);
        $requisitions = Requisition::where('patients_id', '=', $requisition->patients_id)
                        ->where('users_id', '=', $requisition->users_id)
                        ->where('modifier', '=', $requisition->modifier)
                        ->whereDate('requisition.created_at', '=', Carbon::parse($requisition->created_at)->toDateString())
                        ->leftJoin('ancillary_items', 'ancillary_items.id', '=', 'requisition.item_id')
                        ->select('ancillary_items.*', 'requisition.qty', 'requisition.created_at as requisitionDate')
                        ->get();
        return view('receptions.requisition_show', compact('requisitions', 'requisition'));
    }


    public function rcptn_consultation_list($id = false)
    {
        $consultations = Consultation::where('patients_id', '=', $id)
                                ->leftJoin('patients as pt', 'pt.id', '=', 'consultations.patients_id')
                                ->leftJoin('clinics', 'clinics.id', '=', 'consultations.clinic_code')
                                ->leftJoin('users as us', 'us.id', '=', 'consultations.users_id')
                                ->select('consultations.*', 'clinics.name as clinic', DB::raw("CONCAT(pt.last_name,', ',pt.first_name,' ',CASE WHEN pt.suffix IS NOT NULL THEN pt.suffix ELSE '' END,' ',CASE WHEN pt.middle_name IS NOT NULL THEN LEFT(pt.middle_name, 1) ELSE '' END) as name"), DB::raw("CONCAT(us.first_name,' ', LEFT(us.middle_name, 1),'.',' ',us.last_name) as doctor"))
                                ->orderBy('consultations.created_at', 'DECS')
                                ->get();
        return view('receptions.consultation_list', compact('consultations'));
    }

    public function rcptn_consultationDetails($id = false)
    {
        $consultation = Consultation::find($id);
        $files = FileManager::where('consultations_id', '=', $id)->get();
        $patient = Patient::find($consultation->patients_id);
        $directory = '/PatientFiles/EVRMC-'.$patient->id.'-'.$patient->last_name.'/';

        $consultations_icds = ConsultationsICD::select('icd_codes.description')
                            ->leftJoin('icd_codes', 'icd_codes.id', '=', 'consultations_icd.icd')
                            ->where('consultations_id', '=', $consultation->id)->get();

        return view('receptions.consultation_show', compact('consultation', 'files', 'directory', 'consultations_icds', 'patient'));
    }


    public function rcptn_diagnosisList($id = false)
    {
        $diagnosis = Diagnosed::where('patients_id', '=', $id)
                                ->leftJoin('patients as pt', 'pt.id', '=', 'diagnosis.patients_id')
                                ->leftJoin('users as us', 'us.id', '=', 'diagnosis.users_id')
                                ->leftJoin('clinics', 'clinics.id', '=', 'us.clinic')
                                ->select('diagnosis.*', 'clinics.name as clinic', DB::raw("CONCAT(pt.last_name,', ',pt.first_name,' ',CASE WHEN pt.suffix IS NOT NULL THEN pt.suffix ELSE '' END,' ',CASE WHEN pt.middle_name IS NOT NULL THEN LEFT(pt.middle_name, 1) ELSE '' END) as name"), DB::raw("CONCAT(us.first_name,' ', LEFT(us.middle_name, 1),'.',' ',us.last_name) as doctor"))
                                ->get();
        return view('receptions.diagnosis_list', compact('diagnosis'));
    }


    public function rcptn_diagnosisShow($id = false)
    {
        $diagnosis = Diagnosed::find($id);
        $diagnosis_icds = DiagnosisICD::select('icd_codes.description')
                                ->leftJoin('icd_codes', 'icd_codes.id', '=', 'diagnosis_icd.icd')
                                ->where('diagnosis_id', '=', $diagnosis->id)->get();
        return view('receptions.diagnosis_preview', compact('diagnosis', 'diagnosis_icds'));
    }

    public function rcptn_refferalList($pid = false)
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
                    WHERE rf.patients_id = $pid");
        return view('receptions.refferal_list', compact('refferals'));
    }


    public function rcptn_followupList($pid = false)
    {
        $followups = DB::select("SELECT ff.*, clinics.name as clinic, FD.fromDoctor, TD.toDoctor, CONCAT(pt.last_name,', ',pt.first_name,' ',CASE WHEN pt.suffix IS NOT NULL THEN pt.suffix ELSE '' END,' ',CASE WHEN pt.middle_name IS NOT NULL THEN LEFT(pt.middle_name, 1) ELSE '' END) as name FROM followup ff
                        LEFT JOIN patients pt ON pt.id = ff.patients_id
                        LEFT JOIN clinics ON clinics.id = ff.clinic_code
                        LEFT JOIN (SELECT us.id, CONCAT(CASE WHEN us.last_name IS NOT NULL THEN us.last_name ELSE '' END,' ',LEFT(us.middle_name, 1),'.',' ',CASE WHEN us.first_name IS NOT NULL THEN us.first_name ELSE '' END) as fromDoctor FROM users us) as FD ON FD.id = ff.users_id
                        LEFT JOIN (SELECT usr.id, CONCAT(CASE WHEN usr.last_name IS NOT NULL THEN usr.last_name ELSE '' END,' ',LEFT(usr.middle_name, 1),'.',' ',CASE WHEN usr.first_name IS NOT NULL THEN usr.first_name ELSE '' END) as toDoctor FROM users usr ) as TD
                        ON TD.id = ff.assignedTo
                        WHERE ff.patients_id = $pid");
        return view('receptions.followup_list', compact('followups'));
    }


}
