<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Patient;
use App\Clinic;
use App\Refferal;
use Auth;
use Session;
use Validator;
use Carbon;
use DB;

class RefferalController extends Controller
{

    public function __construct()
    {
        $this->middleware('patients', ['only' => ['index']]);
    }

    public function index(Request $request)
    {
        $pid = $request->session()->get('pid');
        // $patient = Patient::find($pid);
        $patient =  $patient = DB::table('patients')
                        ->leftJoin('mssclassification', function($join)
                        {
                            $join->on('mssclassification.patients_id', 'patients.id')
                                ->on('mssclassification.validity', '>=', DB::raw('CURDATE()'));
                        })
                        ->leftJoin('mss', 'mss.id', '=', 'mssclassification.mss_id')
                        ->select('patients.last_name',
                                'patients.first_name',
                                'patients.middle_name',
                                'patients.address',
                                'patients.hospital_no',
                                'patients.birthday',
                                'patients.civil_status',
                                'mss.label',
                                'mss.description',
                                'mss.id',
                                'mss.discount')
                        ->where('patients.id', '=', Session::get('pid'))
                        ->first();
        $clinics = Clinic::where('type', 'c')->orderBy('name')->get();
        /*$histories = Refferal::select('refferals.*', 'clinics.name', DB::raw("CONCAT(CASE WHEN us.last_name IS NOT NULL THEN us.last_name ELSE '' END,' ',LEFT(us.middle_name, 1),'.',' ',CASE WHEN us.first_name IS NOT NULL THEN us.first_name ELSE '' END) as doctorsname"))
                                ->where('patients_id', '=', $pid)
                                ->leftJoin('users as us', 'us.id', '=', 'assignedTo')
                                ->leftJoin('clinics', function ($join){
                                    $join->on('clinics.id', '=', 'refferals.to_clinic');
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
                    WHERE rf.patients_id = $pid");
        
        return view('doctors.refferal', compact('patient', 'clinics', 'refferals'));
    }


    public function store(Request $request)
    {
        $pid = $request->session()->get('pid');
        $validator = Validator::make($request->all(), [
            'to_clinic' => 'required'
        ]);
        if ($validator->passes()){
            $checkRefferal = Refferal::where('patients_id', '=', $pid)
                            ->where('to_clinic', '=', $request->to_clinic)
                            ->where('from_clinic', '=', Auth::user()->clinic)
                            ->where('users_id', '=', Auth::user()->id)
                            ->where('status', '=', 'P')
                            ->count();
            if ($checkRefferal <= 0){
                $request->request->add(['patients_id' => $pid, 'users_id' => Auth::user()->id, 'from_clinic' => Auth::user()->clinic]);
                Refferal::create($request->all());
                Session::flash('toaster', array('success', 'Refferal created succesfully'));
                return redirect()->back();
            }else{
                Session::flash('toaster', array('error', 'Pending refferal schedule for this date and clinic.'));
                return redirect()->back();
            }
        }else{
            return redirect()->back()->withInput()->withErrors($validator);
        }
    }


    public function edit($id)
    {
        $refferal = Refferal::find($id);
        $patient = Patient::find($refferal->patients_id);
        $clinics = Clinic::all();
        $users = User::where('clinic', '=', $refferal->to_clinic)
                        ->where('role', '=', 7)->get();
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
                    WHERE rf.patients_id = $refferal->patients_id");
        return view('doctors.refferal', compact('patient', 'clinics', 'refferals', 'refferal', 'users'));
    }





    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'to_clinic' => 'required'
        ]);
        if ($validator->passes()){
            $refferal = Refferal::find($id);
            $refferal->reason = $request->reason;
            $refferal->to_clinic = $request->to_clinic;
            $refferal->assignedTo = $request->assignedTo;
            $refferal->save();
            Session::flash('toaster', array('succes', 'Refferal successfully updated.'));
            return redirect()->back();
        }else{
            return redirect()->back()->withInput()->withErrors($validator);
        }

    }



    public function destroy($id)
    {
        Refferal::find($id)->delete();
        Session::flash('toaster', array('error', 'Refferal has been deleted.'));
        return redirect('refferal');
    }


    public function selectDoctors(Request $request)
    {
        $doctors = User::select('id', DB::raw("CONCAT(CASE WHEN last_name IS NOT NULL THEN last_name ELSE '' END,' ',LEFT(middle_name, 1),'.',' ',CASE WHEN first_name IS NOT NULL THEN first_name ELSE '' END) as doctorsname"))
                        ->where('clinic', '=', $request->clinic_code)
                        ->where('activated', '=', 'Y')
                        ->where('role', '=', 7)->get();
        echo json_encode($doctors);
        return;
    }

    public function refferal_list($pid = false)
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
        return view('doctors.refferal_list', compact('refferals'));
    }

    public function review_refferal($pid = false)
    {
        $uid = Auth::user()->id;
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
                    WHERE rf.patients_id = $pid AND rf.users_id = $uid AND DATE(rf.created_at) = CURDATE()");

        return view('doctors.review_refferals', compact('refferals'));
    }

}
