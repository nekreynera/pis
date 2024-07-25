<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use App\Patient;
use App\Clinic;
use App\Followup;
use Auth;
use Session;
use Validator;
use Carbon;
use DB;


class FollowupController extends Controller
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
        $clinic = Clinic::find(Auth::user()->clinic);
        $doctors = User::where([
            ['role', '=', 7],
            ['clinic', '=', Auth::user()->clinic],
            ['activated', '=', 'Y']
        ])->get();
        $followups = DB::select("SELECT ff.*, clinics.name as clinic, FD.fromDoctor, TD.toDoctor, CONCAT(pt.last_name,', ',pt.first_name,' ',CASE WHEN pt.suffix IS NOT NULL THEN pt.suffix ELSE '' END,' ',CASE WHEN pt.middle_name IS NOT NULL THEN LEFT(pt.middle_name, 1) ELSE '' END) as name FROM followup ff
                        LEFT JOIN patients pt ON pt.id = ff.patients_id
                        LEFT JOIN clinics ON clinics.id = ff.clinic_code
                        LEFT JOIN (SELECT us.id, CONCAT(CASE WHEN us.last_name IS NOT NULL THEN us.last_name ELSE '' END,' ',LEFT(us.middle_name, 1),'.',' ',CASE WHEN us.first_name IS NOT NULL THEN us.first_name ELSE '' END) as fromDoctor FROM users us) as FD ON FD.id = ff.users_id
                        LEFT JOIN (SELECT usr.id, CONCAT(CASE WHEN usr.last_name IS NOT NULL THEN usr.last_name ELSE '' END,' ',LEFT(usr.middle_name, 1),'.',' ',CASE WHEN usr.first_name IS NOT NULL THEN usr.first_name ELSE '' END) as toDoctor FROM users usr ) as TD 
                        ON TD.id = ff.assignedTo
                        WHERE ff.patients_id = $pid");

        return view('doctors.followup', compact('patient', 'clinic', 'doctors', 'followups'));
    }

    public function store(Request $request)
    {
        $pid = $request->session()->get('pid');
        $validator = Validator::make($request->all(), [
            'followupdate' => 'required|date|after_or_equal:'.Carbon::now()->format('Y-m-d').''
        ]);
        if ($validator->passes()){
            $checkFollowup = Followup::where('patients_id', '=', $pid)
                                        ->where('clinic_code', '=', $request->clinic_code)
                                        ->where('followupdate', '=', $request->followupdate)
                                        ->where('status', '=', 'P')
                                        ->count();
            if ($checkFollowup <= 0){
                $request->request->add(['patients_id' => $pid, 'users_id' => Auth::user()->id]);
                Followup::create($request->all());
                Session::flash('toaster', array('success', 'Follow Up created succesfully'));
                return redirect()->back();
            }else{
                Session::flash('toaster', array('error', 'Pending follow-up schedule for this date and clinic.'));
                return redirect()->back();
            }
        }else{
            Session::flash('toaster', array('error', 'Follow Up date is required.'));
            return redirect()->back()->withInput()->withErrors($validator);
        }
    }



    public function edit($id)
    {
        $followup = Followup::find($id);
        $patient = Patient::find($followup->patients_id);
        $clinic = Clinic::find(Auth::user()->clinic);
        $doctors = User::where('role', '=', 7)->where('clinic', '=', Auth::user()->clinic)->get();
        $followups = DB::select("SELECT ff.*, clinics.name as clinic, FD.fromDoctor, TD.toDoctor, CONCAT(pt.last_name,', ',pt.first_name,' ',CASE WHEN pt.suffix IS NOT NULL THEN pt.suffix ELSE '' END,' ',CASE WHEN pt.middle_name IS NOT NULL THEN LEFT(pt.middle_name, 1) ELSE '' END) as name FROM followup ff
                        LEFT JOIN patients pt ON pt.id = ff.patients_id
                        LEFT JOIN clinics ON clinics.id = ff.clinic_code
                        LEFT JOIN (SELECT us.id, CONCAT(CASE WHEN us.last_name IS NOT NULL THEN us.last_name ELSE '' END,' ',LEFT(us.middle_name, 1),'.',' ',CASE WHEN us.first_name IS NOT NULL THEN us.first_name ELSE '' END) as fromDoctor FROM users us) as FD ON FD.id = ff.users_id
                        LEFT JOIN (SELECT usr.id, CONCAT(CASE WHEN usr.last_name IS NOT NULL THEN usr.last_name ELSE '' END,' ',LEFT(usr.middle_name, 1),'.',' ',CASE WHEN usr.first_name IS NOT NULL THEN usr.first_name ELSE '' END) as toDoctor FROM users usr ) as TD 
                        ON TD.id = ff.assignedTo
                        WHERE ff.patients_id = $followup->patients_id");
        return view('doctors.followup', compact('patient', 'clinic', 'doctors', 'followups', 'followup'));
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'followupdate' => 'required|date|after_or_equal:'.Carbon::now()->format('Y-m-d').''
        ]);
        if ($validator->passes()){
            $followup = Followup::find($id);
            $followup->reason = $request->reason;
            $followup->clinic_code = $request->clinic_code;
            $followup->assignedTo = $request->assignedTo;
            $followup->followupdate = $request->followupdate;
            $followup->save();
            Session::flash('toaster', array('succes', 'Followup successfully updated.'));
            return redirect()->back();
        }else{
            Session::flash('toaster', array('error', 'Follow Up date is required.'));
            return redirect()->back()->withInput()->withErrors($validator);
        }
    }



    public function destroy($id)
    {
        Followup::find($id)->delete();
        Session::flash('toaster', array('error', 'Followup was been deleted.'));
        return redirect('followup');
    }




    public function followup_list($pid = false)
    {
        $followups = DB::select("SELECT ff.*, clinics.name as clinic, FD.fromDoctor, TD.toDoctor, CONCAT(pt.last_name,', ',pt.first_name,' ',CASE WHEN pt.suffix IS NOT NULL THEN pt.suffix ELSE '' END,' ',CASE WHEN pt.middle_name IS NOT NULL THEN LEFT(pt.middle_name, 1) ELSE '' END) as name FROM followup ff
                        LEFT JOIN patients pt ON pt.id = ff.patients_id
                        LEFT JOIN clinics ON clinics.id = ff.clinic_code
                        LEFT JOIN (SELECT us.id, CONCAT(CASE WHEN us.last_name IS NOT NULL THEN us.last_name ELSE '' END,' ',LEFT(us.middle_name, 1),'.',' ',CASE WHEN us.first_name IS NOT NULL THEN us.first_name ELSE '' END) as fromDoctor FROM users us) as FD ON FD.id = ff.users_id
                        LEFT JOIN (SELECT usr.id, CONCAT(CASE WHEN usr.last_name IS NOT NULL THEN usr.last_name ELSE '' END,' ',LEFT(usr.middle_name, 1),'.',' ',CASE WHEN usr.first_name IS NOT NULL THEN usr.first_name ELSE '' END) as toDoctor FROM users usr ) as TD 
                        ON TD.id = ff.assignedTo
                        WHERE ff.patients_id = $pid");
        return view('doctors.followup_list', compact('followups'));
    }


    public function review_followup($pid = false)
    {
        $uid = Auth::user()->id;
        $followups = DB::select("SELECT ff.*, clinics.name as clinic, FD.fromDoctor, TD.toDoctor, CONCAT(pt.last_name,', ',pt.first_name,' ',CASE WHEN pt.suffix IS NOT NULL THEN pt.suffix ELSE '' END,' ',CASE WHEN pt.middle_name IS NOT NULL THEN LEFT(pt.middle_name, 1) ELSE '' END) as name FROM followup ff
                        LEFT JOIN patients pt ON pt.id = ff.patients_id
                        LEFT JOIN clinics ON clinics.id = ff.clinic_code
                        LEFT JOIN (SELECT us.id, CONCAT(CASE WHEN us.last_name IS NOT NULL THEN us.last_name ELSE '' END,' ',LEFT(us.middle_name, 1),'.',' ',CASE WHEN us.first_name IS NOT NULL THEN us.first_name ELSE '' END) as fromDoctor FROM users us) as FD ON FD.id = ff.users_id
                        LEFT JOIN (SELECT usr.id, CONCAT(CASE WHEN usr.last_name IS NOT NULL THEN usr.last_name ELSE '' END,' ',LEFT(usr.middle_name, 1),'.',' ',CASE WHEN usr.first_name IS NOT NULL THEN usr.first_name ELSE '' END) as toDoctor FROM users usr ) as TD 
                        ON TD.id = ff.assignedTo
                        WHERE ff.patients_id = $pid AND ff.users_id = $uid AND DATE(ff.created_at) = CURDATE()");
        return view('doctors.review_followup', compact('followups'));
    }



}
