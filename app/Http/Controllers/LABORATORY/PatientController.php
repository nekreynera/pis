<?php

namespace App\Http\Controllers\LABORATORY;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\LaboratoryQueues;
use App\Patient;
use App\User;
use App\LaboratoryRequest;
use App\LaboratoryRequestGroup;
use App\LaboratoryPayment;

use App\LaboratoryModel;
use App\LaboratorySub;
use App\LaboratorySubList;
use App\LaboratoryDone;
use App\LaboratoryDoneReferences;
use App\LaboratoryUndone;
use App\LaboratoryPrintedRequest;

use App\Mssclassification;

use App\Requisitionwithlaboratory;
use App\Clinic;
use App\Alert;

use Auth;
use Validator;
use Response;
use DB;
use Carbon;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (count($request->post()) > 0) {
            $patients = LaboratoryQueues::search($request);
        }else{
            $patients = LaboratoryQueues::patientstoday();
        }
        $alert = Alert::where('clinic', Auth::user()->id)->first();
        if ($request->alert) {
            if (!$alert) {
                $store = new Alert();
                $store->clinic = Auth::user()->id;
                $store->save();
            }
            $alert = Alert::where('clinic', Auth::user()->id)->first();
        }
        return view('OPDMS.laboratory.pages.patient', compact('patients', 'request', 'alert'));
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
        $modifier = Str::random(20);
        $LaboratoryRequestGroup = new LaboratoryRequestGroup();
        $LaboratoryRequestGroup->user_id =  $request->user_id;
        $user = null;
        if ($request->user_id) {
            $user = User::find($request->user_id);
        }
        $LaboratoryRequestGroup->clinic_id =  ($user)?$user->clinic:null;
        $LaboratoryRequestGroup->patient_id = $request->patient_id;
        $LaboratoryRequestGroup->save();
        foreach ($request->item_id as $key => $value) {
            $LaboratoryRequest = new LaboratoryRequest();
            $LaboratoryRequest->item_id = $request->item_id[$key];
            $LaboratoryRequest->qty = $request->item_qty[$key];
            $LaboratoryRequest->laboratory_request_group_id = $LaboratoryRequestGroup->id;
            $LaboratoryRequest->save();
            if ($request->mss_discount == '1') {
                if ($request->user_id != '672') {
                    $LaboratoryPayment = new LaboratoryPayment();
                    $LaboratoryPayment->user_id = Auth::user()->id;
                    $LaboratoryPayment->laboratory_request_id = $LaboratoryRequest->id;
                    $LaboratoryPayment->mss_id = $request->mss_id;
                    $LaboratoryPayment->price = $request->item_price[$key];
                    $LaboratoryPayment->discount = $request->item_discount[$key];
                    $LaboratoryPayment->or_no = $modifier;
                    $LaboratoryPayment->save();
                }
            }
        }
        $patient = Patient::find($request->patient_id);
        $info = Mssclassification::getPaitentinfoandclassification($request->patient_id);
        $request = LaboratoryRequest::gettransaction($request->patient_id);
        echo json_encode([
                            'patient' => $patient,
                            'info' => $info,
                            'request' => $request
                        ]);
        return;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $patient = Patient::find($id);
        $info = Mssclassification::getPaitentinfoandclassification($patient->id);
        $laboratory = LaboratoryModel::orderBy('id')->get();
        $sub = LaboratorySub::orderBy('id')->get();
        $list = LaboratorySubList::orderBy('name', 'ASC')->get();
        $request = LaboratoryRequest::gettransaction($patient->id);
        
        echo json_encode([
                            'info' => $info,
                            'sub' => $sub, 
                            'list' => $list, 
                            'laboratory' => $laboratory,
                            'patient' => $patient,
                            'request' => $request
                        ]);
        return;
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
    public function getlaboratorypatients()
    {
        $data = DB::table('laboratory_queues')
                        ->leftJoin('laboratory_request_groups', function($join){
                            $join->on('laboratory_request_groups.patient_id', '=', 'laboratory_queues.patient_id')
                            ->where('laboratory_request_groups.status', "pending");
                        })
                        ->leftJoin('users', 'laboratory_request_groups.user_id', '=', 'users.id')
                        ->leftJoin('patients', 'laboratory_queues.patient_id', '=', 'patients.id')
                        ->leftJoin('roles', 'users.role', '=', 'roles.id')
                        ->select('laboratory_queues.patient_id',
                                'patients.hospital_no',
                                'patients.last_name',
                                'patients.first_name',
                                'patients.suffix',
                                'patients.middle_name',
                                'roles.description as role',
                                'users.last_name as uslname',
                                'users.first_name as usfname',
                                'users.middle_name as usmname',
                                'patients.birthday',
                                'laboratory_queues.created_at')
                        ->orderBy('laboratory_queues.id', 'DESC')
                        ->get();
        echo json_encode($data);
        return;
    }
    public function laboratorypatientscheck(Request $request)
    {
        $store = null;
        $info = null;
        $laboratory = [];
        $sub = [];
        $list = [];
        $lablist = [];
        $queuing = [];
        $patient = null;
        $patients = [];
        $pending_request = [];

        $rules = array(
                'hospital_no' => 'required',
                );
        $validator = Validator::make($request->all(), $rules);
            if ($validator->fails())
            {
                return Response::json(array(
                    'errors' => $validator->getMessageBag()->toArray()
                ));
            }else{
                if (strpos($request->hospital_no, 'WALK-IN-') !== false) {
                    $find = explode('-', $request->hospital_no);
                    $patient = Patient::where('walkin', $find[2])
                                        ->first();
                }else{
                    $patient = Patient::where('hospital_no', $request->hospital_no)
                                        ->orWhere('barcode', $request->hospital_no)
                                        ->first();
                }
                if ($patient) 
                {
                    $queuing = LaboratoryQueues::where('patient_id', $patient->id)
                                                ->whereDate('created_at', Carbon::now()->format('Y-m-d'))
                                                ->get();
                    if (count($queuing) <= 0) {
                        $info = Mssclassification::getPaitentinfoandclassification($patient->id);
                        $laboratory = LaboratoryModel::orderBy('id')->get();
                        $sub = LaboratorySub::orderBy('id')->get();
                        $list = LaboratorySubList::orderBy('name', 'ASC')->get();
                        $request = LaboratoryRequest::gettransaction($patient->id);

                        $LaboratoryQueues = new LaboratoryQueues();
                        $LaboratoryQueues->user_id = Auth::user()->id;
                        $LaboratoryQueues->patient_id = $patient->id;
                        $LaboratoryQueues->save();

                        $patients = LaboratoryQueues::patientstoday();
                    }
                }
            }

        
        echo json_encode([
                            'store' => $store, 
                            'queuing' => $queuing, 
                            'info' => $info,
                            'sub' => $sub, 
                            'list' => $list, 
                            'laboratory' => $laboratory,
                            'patient' => $patient,
                            'patients' => $patients,
                            'request' => $request
                        ]);
        return;
    }
    public function markedlaboratoryrequestasdone(Request $request)
    {
        $modifier = Str::random(20);
        if (count($request->request_id) > 0) {
            $done_ref = DB::select("SELECT MAX(number) as number FROM laboratory_done_references");
            if ($done_ref[0]) {
                $done_no = $done_ref[0]->number + 1;
            }else{
                $done_no = 1;
            }

            $references = new LaboratoryDoneReferences();
            try {
                $references->number = $done_no;
                $references->save();
            } catch (Exception $e) {
                try {
                    $references->number = $done_no + 1;
                    $references->save();
                } catch (Exception $e) {
                    $references->number = $done_no + 1;
                    $references->save();
                }
            }
            

            foreach ($request->request_id as $key => $value) {
                $LaboratoryRequest = LaboratoryRequest::find($request->request_id[$key]);
                $LaboratoryRequest->status = 'Done';

                $LaboratoryDone = new LaboratoryDone();
                $LaboratoryDone->laboratory_request_id = $request->request_id[$key];
                $LaboratoryDone->user_id = Auth::user()->id;
                $LaboratoryDone->done_no = $references->number;
                
                $LaboratoryPayment = LaboratoryPayment::where('laboratory_request_id', '=', $LaboratoryRequest->id)->first();
                if (!$LaboratoryPayment) {
                    $LaboratoryPayment = new LaboratoryPayment();
                    $LaboratoryPayment->user_id = Auth::user()->id;
                    $LaboratoryPayment->laboratory_request_id = $LaboratoryRequest->id;
                    $LaboratoryPayment->mss_id = ($request->mss_id)? $request->mss_id : 0;
                    $LaboratoryPayment->price = $request->item_price[$key];
                    $LaboratoryPayment->discount = 0;
                    $LaboratoryPayment->or_no = $modifier;
                    $LaboratoryPayment->dbnp = 1;
                    $LaboratoryPayment->save();
                }
                // LaboratoryUndone::where('laboratory_request_id', '=', $request->request_id[$key])->delete();

                $LaboratoryDone->save();
                $LaboratoryRequest->save();
            }
        }
       
        $patient = Patient::find($request->patient_id);
        $info = Mssclassification::getPaitentinfoandclassification($request->patient_id);
        $request = LaboratoryRequest::gettransaction($request->patient_id);
        echo json_encode([
                            'patient' => $patient,
                            'info' => $info,
                            'request' => $request
                        ]);
        return;
    }
    public function markedlaboratoryrequestasundone(Request $request)
    {
        foreach ($request->request_id as $key => $value) {
            $LaboratoryRequest = LaboratoryRequest::find($request->request_id[$key]);
            $LaboratoryRequest->status = 'Pending';

            $LaboratoryUndone = new LaboratoryUndone();
            $LaboratoryUndone->laboratory_request_id = $request->request_id[$key];
            $LaboratoryUndone->user_id = Auth::user()->id;
            $LaboratoryUndone->remark = $request->remark;

            LaboratoryDone::where('laboratory_request_id', '=', $request->request_id[$key])->delete();
            LaboratoryPayment::where('laboratory_request_id', '=', $request->request_id[$key])
                            ->where('dbnp', '=', 1)
                            ->delete();

            $LaboratoryUndone->save();
            $LaboratoryRequest->save();
        }
        $patient = Patient::find($request->patient_id);
        $info = Mssclassification::getPaitentinfoandclassification($request->patient_id);
        $request = LaboratoryRequest::gettransaction($request->patient_id);
        echo json_encode([
                            'patient' => $patient,
                            'info' => $info,
                            'request' => $request
                        ]);
        return;
    }
    public function markedlaboratoryrequestasremove(Request $request)
    {
        foreach ($request->request_id as $key => $value) {
            $LaboratoryRequest = LaboratoryRequest::find($request->request_id[$key]);
            $LaboratoryRequest->status = 'Removed';

            $LaboratoryPayment = LaboratoryPayment::where('laboratory_request_id', '=', $request->request_id[$key])
                                                    ->whereIn('mss_id', [9,10,11,12,13])->first();
            if ($LaboratoryPayment) {
                $LaboratoryPayment->delete();
            }

            $LaboratoryRequest->save();
        }

        $patient = Patient::find($request->patient_id);
        $info = Mssclassification::getPaitentinfoandclassification($request->patient_id);
        $request = LaboratoryRequest::gettransaction($request->patient_id);
        echo json_encode([
                            'patient' => $patient,
                            'info' => $info,
                            'request' => $request
                        ]);
        return;
        # code...
    }
    public function getlaboratorypatientsbystatus($stats)
    {
        if ($stats == 'ALL') {
            $patients = LaboratoryQueues::patientstoday();
        }else{
            $patients = LaboratoryQueues::patient($status = $stats);
        }
        echo json_encode($patients);
        return;
    }

    public function updatepatientqueingstatus($patient_id, $action, $stats)
    {
        $queue = LaboratoryQueues::where('patient_id', '=', $patient_id)
                        ->whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))
                        ->first();
        $queue->status = $action;
        $queue->save();
        $patients = LaboratoryQueues::patientstoday();
        echo json_encode($patients);
        return;
    }


    function getalltransactedpatiens(){
        $data = DB::select("SELECT a.id,
                                    c.hospital_no,
                                    c.last_name, c.first_name, c.middle_name,
                                    e.name as sub,
                                    d.name  as lists,
                                    b.created_at as request_date,
                                    f.created_at as recieve_date,
                                    a.status
                            FROM laboratory_requests a
                            LEFT JOIN laboratory_request_groups b ON a.laboratory_request_group_id = b.id
                            LEFT JOIN patients c  ON b.patient_id = c.id
                            LEFT JOIN laboratory_sub_list d ON a.item_id = d.id
                            LEFT JOIN laboratory_sub e ON d.laboratory_sub_id = e.id
                            LEFT JOIN laboratory_done f ON a.id = f.laboratory_request_id
                            WHERE f.id IS NOT NULL
                            AND a.status = 'Done'
                            ORDER BY b.created_at DESC
                            LIMIT 100");
        echo json_encode($data);
        return;
    }

    public function searchtransactedpatients(Request $request)
    {
        $data = DB::select("SELECT a.id,
                                    c.hospital_no,
                                    c.last_name, c.first_name, c.middle_name,
                                    e.name as sub,
                                    d.name  as lists,
                                    b.created_at as request_date,
                                    f.created_at as recieve_date,
                                    a.status
                            FROM laboratory_requests a
                            LEFT JOIN laboratory_request_groups b ON a.laboratory_request_group_id = b.id
                            LEFT JOIN patients c  ON b.patient_id = c.id
                            LEFT JOIN laboratory_sub_list d ON a.item_id = d.id
                            LEFT JOIN laboratory_sub e ON d.laboratory_sub_id = e.id
                            LEFT JOIN laboratory_done f ON a.id = f.laboratory_request_id
                            WHERE f.id IS NOT NULL
                            AND a.status = 'Done'
                            AND CONCAT(c.hospital_no,' ',c.last_name,' ',c.first_name,' ',c.middle_name) LIKE ?
                            ORDER BY b.created_at DESC
                            LIMIT 100",
                            ['%'.$request->keyword.'%']);
        echo json_encode($data);
        return;
    }
    public function laboratoryhistory(Request $request)
    {
        return view('OPDMS.laboratory.pages.history', compact('request'));
    }
    public function getalldoctors()
    {
        $data = DB::table('users')
                    ->leftJoin('clinics', 'users.clinic', '=', 'clinics.id')
                    ->leftJoin('med_interns', 'users.id', '=', 'med_interns.interns_id')
                    ->where('users.role', '=', 7)
                    ->whereNotIn('users.id', [672,777])
                    ->orderBy('users.last_name', 'ASC')
                    ->select(
                            'users.id', 
                            'med_interns.interns_id',
                            'users.last_name', 
                            'users.first_name', 
                            'users.middle_name', 
                            'clinics.name'
                        )
                    ->get();
        echo json_encode($data);
        return;
    }
    public function getopdclinics()
    {
        $clinics = Clinic::where('type', '=', 'c')->orderBy('name')->get();
        echo json_encode($clinics);
        return;
    }
    public function laboratory_new_doctor(Request $request)
    {
        $user = User::where('last_name', '=', $request->last_name)
                    ->where('first_name', '=', $request->first_name)
                    ->where('clinic', '=', $request->clinic)
                    ->first();
        if (!$user) {
            $user = new User();
            $user->last_name = $request->last_name;
            $user->first_name = $request->first_name;
            $user->middle_name = $request->middle_name;
            $user->role = 7;
            $user->clinic = $request->clinic;
            $user->activated = 'N';
            $user->save();
        }
        echo json_encode($user);
        return;
    }
}
