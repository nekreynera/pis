<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Patient;
use App\Inpatient;
use App\Clinic;
use App\Triage;
use App\VitalSigns;
use App\RegPatient;
use App\Cashidsale;
use App\TblPatients;
use App\Refbrgy;
use App\Pnp;
use App\Regdiagnosis;
use App\Regreferral;
use App\Reginitialdiag;
use App\Regadmittingdiag;
use App\User;
use App\Regdeletepatients;
use App\Regfacility;
use App\Ward;
use App\Regforreferral;
use App\Watcher;
use Validator;
use DB;
use Auth;
use Carbon\Carbon;
use Session;

class PatientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    /*public function duplicate()
    {
        $patients = DB::select("
                        SELECT COUNT(hospital_no) AS Total, pt.id, hospital_no, pt.created_at 
                        FROM patients pt
                        GROUP BY hospital_no
                        HAVING Total > 1
                        ORDER BY pt.created_at DESC");
        $i=1;
        foreach ($patients as $row){
            $hospital_no = Patient::max('hospital_no');
            $hospital_no = $hospital_no + 1;
            $hospital_no =  str_pad($hospital_no, 6, '0', STR_PAD_LEFT);
            echo $hospital_no.' '.$i;
            echo '<br/>';
            Patient::find($row->id)->update(['hospital_no' => $hospital_no]);
            $i++;
        }
    }*/

    
    public function index()
    {
        $clinics = Clinic::all();
        $facility = Regfacility::OrderBy('hospital', 'ASC')->get();
        $referral = Clinic::where('type', '=', 'c')->OrderBy('name', 'ASC')->get();
        $diagnosis = Regdiagnosis::OrderBy('diagnosis', 'ASC')->get();
        $ward = Ward::OrderBy('ward', 'ASC')->get();

        return view('patients.register', compact('clinics', 'diagnosis', 'facility', 'ward', 'referral'));
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
        $hospital_no = Patient::max('hospital_no');
        if ($hospital_no) {
            $hospital_no = $hospital_no + 1;
            $hospital_no =  str_pad($hospital_no, 6, '0', STR_PAD_LEFT);
        }else{
            $hospital_no = '000001';
        }

        $random = rand(000001, 600000);
        $generated_num = (strlen($random) < 6)? str_pad($random, 6, '0', STR_PAD_LEFT) : $random ;
        $barcode = 'EVRMC'.date("mdY").$generated_num;

        $request->request->add([
                                'barcode' => $barcode,
                                'hospital_no' => $hospital_no
                            ]);

        $validator = Validator::make($request->all(), [
                'last_name' => 'required|max:35',
                'first_name' => 'required|max:35',
                'middle_name' => 'nullable|max:35',
                'birthday' => 'nullable|date|before_or_equal:'.Carbon::now()->format('Y-m-d').'',
                'contact_no' => 'max:30',
                'address' => 'max:150',
                'region' => 'required',
                'province' => 'required',
                'city_municipality' => 'required',
                'hospital_no' => 'required|unique:patients',
                'barcode' => 'required|unique:patients',
                'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5048',
            ]);


            if ($validator->passes()) {
                $checkIfPatientAlreadyExist = Patient::where('last_name', '=', $request->last_name)
                                                        ->where('first_name', '=', $request->first_name)
                                                        ->where('middle_name', '=', $request->middle_name)->first();
                if ($checkIfPatientAlreadyExist){
                    if(Auth::user()->clinic == 54){
                    /*--- check if the patient you are registering as watcher is a patient ---*/
                        if($request->patient_id == $checkIfPatientAlreadyExist->id){
                            return redirect('admittedpatient')->with('toaster', array('error', 'You are registering a watcher who is currently admitted as patient.'));
                        }
                    
                        // if(!$request->patient_id){
                        //     Inpatient::storeInpatient($checkIfPatientAlreadyExist->id);
                        //     return redirect()->back()->with('toaster', array('success', 'Registration Successful..'));
                        // }
                        if($request->patient_id){
                            (new Watcher())->storePatientWatcher($request->patient_id, $checkIfPatientAlreadyExist->id);
                            return redirect('admittedpatient')->with('toaster', array('success', 'Watcher Successfully Registered.'));
                        }
                    }
                    return redirect()->back()->with('toaster', array('error', 'Patient Already Registered.'));   
                    
                }else {

                        if ($request->hasFile('profile')) {
                            $profile = $hospital_no.'.'.request('profile')->getClientOriginalExtension();
                            request('profile')->move('C:/xampp/htdocs/Profiles', $profile);
                        }else{
                            $profile = null;
                        }


                        try{
                            //$patient = Patient::create($request->all()); //store patient info...
                            $patient = Patient::create([
                                            'first_name' => strtoupper(str_replace('ñ', 'Ñ', $request->first_name)),
                                            'middle_name' => strtoupper(str_replace('ñ', 'Ñ', $request->middle_name)),
                                            'last_name' => strtoupper(str_replace('ñ', 'Ñ', $request->last_name)),
                                            'suffix' => $request->suffix,
                                            'sex' => $request->sex,
                                            'birthday' => $request->birthday,
                                            'age' => $request->age,
                                            'civil_status' => $request->civil_status,
                                            'address' => $request->address,
                                            'city_municipality' => $request->city_municipality,
                                            'brgy' => $request->brgy,
                                            'contact_no' => $request->contact_no,
                                            'hospital_no' => $request->hospital_no,
                                            'barcode' => $request->barcode,
                                            'profile' => $profile,
                                            'users_id' => $request->users_id,
                                        ]);

                        }catch(QueryException $ex){
                            return redirect()->back()->withInput()->with('toaster', array('error', 'Synchronize Registration Not Allowed.'));
                        }

                        if(Auth::user()->clinic == 54){
                            if($request->patient_id){
                                (new Watcher())->storePatientWatcher($request->patient_id, $patient->id);
                                return redirect('admittedpatient')->with('toaster', array('success', 'Watcher Successfully Registered.'));
                            }
                            if(!$request->patient_id){
                                Inpatient::storeInpatient($patient->id);
                                return redirect('admittedpatient')->with('toaster', array('success', 'Patient Successfully Registered.'));
                            }
                        }


                        /*==============================for referral=========================*/
                        if ($request->referral == "yes") {
                                $regforreferral = new Regforreferral();
                                $regforreferral->patients_id = $patient->id;
                                $regforreferral->save();
                            // $regreferral = new Regreferral();
                            // $regreferral->patient_id = $patient->id;
                            // $regreferral->facility = $request->facility;
                            // $regreferral->physician = $request->physician;
                            // $regreferral->reason = $request->reason; 
                            // $regreferral->accompany = $request->accompanying;
                            // $regreferral->complaint = $request->complaint; 
                            // $regreferral->refclinic = $request->refclinic;
                            // $regreferral->area = $request->area;
                            // $regreferral->save();
                            // if (count($request->initial_id) > 0) {
                            //     foreach ($request->initial_id as $key => $u) {
                            //         $reginitialdiag = new Reginitialdiag();
                            //         $reginitialdiag->regreferral_id = $regreferral->id;
                            //         $reginitialdiag->regdiagonsis_id = $request->initial_id[$key];
                            //         $reginitialdiag->save();
                            //     }
                            // }
                            // if ($request->ward == "in") {
                            //     if (count($request->admitting_id) > 0) {
                            //         foreach ($request->admitting_id as $key => $u) {
                            //             $regadmittingdiag = new Regadmittingdiag();
                            //             $regadmittingdiag->regreferral_id = $regreferral->id;
                            //             $regadmittingdiag->regdiagnosis_id = $request->admitting_id[$key];
                            //             $regadmittingdiag->save();
                            //         }
                            //     }
                            // }
                        }
                        /*=======================================================================*/

                        if ($request->clinic) {
                            $triage = new Triage();
                            $triage->patients_id = $patient->id;
                            $triage->users_id = Auth::user()->id;
                            $triage->clinic_code = $request->clinic;
                            $triage->save();

                            $vitalsigns = new VitalSigns();
                            $vitalsigns->storeVitalSigns($request, $triage->id, $patient->id);
                        }

                        // RegPatient::patientCensus();

                        if (Auth::user()->id == 172) {
                            Pnp::storePNP($patient->id);
                        }

                        return redirect('searchpatient')->with('toaster', array('success', 'Registration Successful.'));

                }//end of checkifPatientAlreadyExist Condition
            }else{
                return redirect()->back()->withInput()->withErrors($validator);  
            }
    }

    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $clinics = Clinic::all();
        $patient = Patient::find($id);
        $created_at = $patient->created_at;
        $created_atPlus5Min = Carbon::parse($patient->created_at)->addMinutes(8);
        $triage = Triage::where('patients_id', '=', $patient->id)
                ->where('created_at', '>=', $created_at)
                ->where('created_at', '<=', $created_atPlus5Min)
                ->where('finished', '=', 'N')
                ->get()->first();
        $vital_signs = VitalSigns::where('patients_id', '=', $patient->id)
                ->where('created_at', '>=', $created_at)
                ->where('created_at', '<=', $created_atPlus5Min)
                ->get()->first();
        $referral = Regforreferral::where('patients_id', '=', $patient->id)->first();
        return view('patients.edit', compact('patient', 'clinics', 'vital_signs', 'triage', 'referral'));
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
        $validator = Validator::make($request->all(), [
                'last_name' => 'required|max:35',
                'first_name' => 'required|max:35',
                'middle_name' => 'nullable|max:35',
                'birthday' => 'nullable|date|before_or_equal:'.Carbon::now()->format('Y-m-d').'',
                'contact_no' => 'max:30',
                'address' => 'max:150',
            ]);
            if ($validator->passes()) { 
                    
                $patient = Patient::find($id);
                $patient->first_name = strtoupper(str_replace('ñ', 'Ñ', $request->first_name));
                $patient->middle_name = strtoupper(str_replace('ñ', 'Ñ', $request->middle_name));
                $patient->last_name = strtoupper(str_replace('ñ', 'Ñ', $request->last_name));
                $patient->suffix = $request->suffix;
                $patient->sex = $request->sex;
                $patient->birthday = $request->birthday;
                $patient->age = $request->age;
                $patient->civil_status = $request->civil_status;
                $patient->contact_no = $request->contact_no;
                $patient->address = $request->address;
                if ($request->brgy) {
                    $patient->brgy = $request->brgy;
                }
                if ($request->city_municipality) {
                    $patient->city_municipality = $request->city_municipality;
                }
                $patient->save();
                $referral = Regforreferral::where('patients_id', '=', $patient->id)->first();
                if ($referral) {
                    if ($request->referral == "no") {
                       $referral->delete();
                    }

                }else{
                    if ($request->referral == "yes") {
                        $regforreferral = new Regforreferral();
                        $regforreferral->patients_id = $patient->id;
                        $regforreferral->save();
                    }
                }
                if ($request->triage) {
                    $triage = Triage::find($request->triage);
                    $triage->users_id = Auth::user()->id;
                    $triage->clinic_code = $request->clinic;
                    $triage->save();
                }

                if ($request->vital_signs) {
                    $vital_signs = VitalSigns::find($request->vital_signs);
                    $vital_signs->weight = $request->weight;
                    $vital_signs->height = $request->height;
                    $vital_signs->blood_pressure = $request->blood_pressure;
                    $vital_signs->pulse_rate = $request->pulse_rate;
                    $vital_signs->respiration_rate = $request->respiration_rate;
                    $vital_signs->body_temperature = $request->body_temperature;
                    $vital_signs->save();
                }
                if (Auth::user()->clinic == 54) {
                    return redirect('admittedpatient')->with('toaster', array('success', 'Updated Successfully.'));
                }else{
                    return redirect('searchpatient')->with('toaster', array('success', 'Updated Successfully.')); 
                }
                
            }else{
                return redirect()->back()->withInput()->withErrors($validator);  
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }


    public function unprinted()
    {
        $patients = DB::select("SELECT pt.*, cs.id as cid, cs.activated FROM patients pt 
                                LEFT JOIN cashidsale cs ON cs.patients_id = pt.id
                                WHERE pt.printed = 'N'
                                AND DATE(pt.created_at) = CURDATE()
                                ORDER BY pt.id DESC");
        return view('patients.unprinted', compact('patients'));
    }
    public function searchpatient()
    {

        $patients = DB::select("SELECT a.id, a.hospital_no, a.barcode, a.last_name, a.first_name, a.middle_name,
                                        a.address, a.birthday, a.sex, a.created_at, a.printed, (COUNT(b.patients_id) + COUNT(c.patients_id)) as paid
                                    FROM patients a 
                                    LEFT JOIN cashidsale b ON a.id = b.patients_id
                                    LEFT JOIN cashincome c ON a.id = c.patients_id AND c.category_id = 312
                                    WHERE DATE(a.created_at) = CURRENT_DATE()
                                    GROUP BY a.id  
                                    ORDER BY a.created_at DESC LIMIT 50");
        return view('patients.searchpatient', compact('patients'));
    }
    public function search(Request $request)
    {
        if($request->name){
           $patients = DB::select("SELECT a.id, a.hospital_no, a.barcode, a.last_name, a.first_name, a.middle_name,
                                        a.address, a.birthday, a.sex, a.created_at, a.printed, (COUNT(b.patients_id) + COUNT(c.patients_id)) as paid
                                    FROM patients a 
                                    LEFT JOIN cashidsale b ON a.id = b.patients_id
                                    LEFT JOIN cashincome c ON a.id = c.patients_id AND c.category_id = 312
                                        WHERE CONCAT(a.last_name,' ',a.first_name,' ',a.middle_name) LIKE ?
                                        GROUP BY a.id  
                                        ORDER BY a.created_at DESC
                                        ", ['%'.$request->name.'%']);
        }elseif ($request->birthday) {
            $patients = DB::select("SELECT a.id, a.hospital_no, a.barcode, a.last_name, a.first_name, a.middle_name,
                                        a.address, a.birthday, a.sex, a.created_at, a.printed, (COUNT(b.patients_id) + COUNT(c.patients_id)) as paid
                                    FROM patients a 
                                    LEFT JOIN cashidsale b ON a.id = b.patients_id
                                    LEFT JOIN cashincome c ON a.id = c.patients_id AND c.category_id = 312
                                        WHERE DATE(a.birthday) = ?
                                        GROUP BY a.id  
                                        ORDER BY a.created_at DESC
                                        ", [$request->birthday]);
        }elseif ($request->barcode) {
            $patients =  DB::select("SELECT a.id, a.hospital_no, a.barcode, a.last_name, a.first_name, a.middle_name,
                                        a.address, a.birthday, a.sex, a.created_at, a.printed, (COUNT(b.patients_id) + COUNT(c.patients_id)) as paid
                                    FROM patients a 
                                    LEFT JOIN cashidsale b ON a.id = b.patients_id
                                    LEFT JOIN cashincome c ON a.id = c.patients_id AND c.category_id = 312
                                        WHERE a.barcode = ?
                                        GROUP BY a.id  
                                        ORDER BY a.created_at DESC
                                        ", [$request->barcode]);
        }elseif ($request->hospital_no) {
            $patients =  DB::select("SELECT a.id, a.hospital_no, a.barcode, a.last_name, a.first_name, a.middle_name,
                                        a.address, a.birthday, a.sex, a.created_at, a.printed, (COUNT(b.patients_id) + COUNT(c.patients_id)) as paid
                                    FROM patients a 
                                    LEFT JOIN cashidsale b ON a.id = b.patients_id
                                    LEFT JOIN cashincome c ON a.id = c.patients_id AND c.category_id = 312
                                        WHERE a.hospital_no = ?
                                        GROUP BY a.id  
                                        ORDER BY a.created_at DESC
                                        ", [$request->hospital_no]);
        }elseif ($request->created_at) {
            $patients =  DB::select("SELECT a.id, a.hospital_no, a.barcode, a.last_name, a.first_name, a.middle_name,
                                        a.address, a.birthday, a.sex, a.created_at, a.printed, (COUNT(b.patients_id) + COUNT(c.patients_id)) as paid
                                    FROM patients a 
                                    LEFT JOIN cashidsale b ON a.id = b.patients_id
                                    LEFT JOIN cashincome c ON a.id = c.patients_id AND c.category_id = 312
                                        WHERE DATE(a.created_at) = ?
                                        GROUP BY a.id  
                                        ORDER BY a.created_at DESC
                                        ", [$request->created_at]);
        }
        if (isset($patients) && count($patients) > 0) {
            Session::flash('toaster', array('success', 'Matching Records Found.'));
            return view('patients.searchpatient', compact('patients'));
        }
        Session::flash('toaster', array('error', 'No Matching Records Found.'));
        return view('patients.searchpatient');
    }

    public function printed(Request $request)
    {
        DB::table('patients')
            ->where('id', '=', $request->id)
            ->update(['printed' => 'Y']);
        Cashidsale::where('patients_id', '=', $request->id)
                    ->latest()->first()->update(['activated'=>'N']);
        return;
    }


    public function census()
    {
        $registered = RegPatient::where('users_id', '=', Auth::user()->id)
                                    ->whereDate('reg_patients.created_at', Carbon::now()->toDateString())
                                    ->leftJoin('users as us', 'us.id', '=', 'reg_patients.users_id')
                                    ->select('reg_patients.*', DB::raw("CONCAT(CASE WHEN us.last_name IS NOT NULL THEN us.last_name ELSE '' END,' ',LEFT(us.middle_name, 1),'.',' ',CASE WHEN us.first_name IS NOT NULL THEN us.first_name ELSE '' END) as name"))
                                    ->get();
        return view('patients.census', compact('registered'));
    }

    public function getcensus(Request $request)
    {
        $from = $request->from;
        $to = $request->to;
        $registered = RegPatient::where('users_id', '=', Auth::user()->id)
                                    ->whereBetween(DB::raw('DATE(reg_patients.created_at)'), [$from, $to])
                                    ->leftJoin('users as us', 'us.id', '=', 'reg_patients.users_id')
                                    ->select('reg_patients.*', DB::raw("CONCAT(CASE WHEN us.first_name IS NOT NULL THEN us.first_name ELSE '' END,' ',LEFT(us.middle_name, 1),'.',' ',CASE WHEN us.last_name IS NOT NULL THEN us.last_name ELSE '' END) as name"))
                                    ->get();
        return view('patients.census', compact('registered'));
    }
    public function registerreport(Request $request)
    {
        // dd($request);
        if ($request->from != "" && $request->to != "") {
            $data = DB::select("SELECT DATE(a.created_at) as date, COUNT(*) as result 
                                FROM patients a
                                LEFT JOIN users b ON a.users_id = b.id
                                WHERE DATE(a.created_at) BETWEEN ? AND ?
                                AND b.clinic = ?
                                AND users_id =
                                   (CASE 
                                        WHEN '$request->user' = 'all' 
                                        THEN users_id
                                        ELSE ?
                                    END)
                                GROUP BY $request->group(a.created_at)
                            ", [$request->from, $request->to, $request->type, $request->user]);
        }else{
            $data = [];
        }
        $week = DB::select("SELECT WEEK(created_at) as weeks, date(created_at) as dates FROM patients GROUP BY WEEK(created_at) ORDER BY created_at ASC");
        // dd($week);
        
        return view('patients.reports', compact('request', 'data', 'week'));
    }
    public function searchpatientmodal(Request $request)
    {
        $patient = DB::select("SELECT a.hospital_no, a.last_name, a.first_name, a.middle_name, a.sex,a.birthday, a.id, ('reg') as info, CONCAT(b.citymunDesc,', ',c.provDesc) as place 
                                FROM patients a
                                LEFT JOIN refcitymun b ON a.city_municipality = b.citymunCode
                                LEFT JOIN refprovince c ON b.provCode = c.provCode
                                WHERE a.last_name LIKE '%$request->last_name%'
                                AND a.first_name LIKE '%$request->first_name%'
                                UNION 
                               SELECT d.hospital_no, d.last_name, d.first_name, d.middle_name, d.sex,d.birthday, d.id, ('del') as info, CONCAT(e.citymunDesc,', ',f.provDesc) as place 
                                FROM regdeletepatients d
                                LEFT JOIN refcitymun e ON d.city_municipality = e.citymunCode
                                LEFT JOIN refprovince f ON e.provCode = f.provCode
                                WHERE d.last_name LIKE '%$request->last_name%'
                                AND d.first_name LIKE '%$request->first_name%'
                            ");
        echo json_encode($patient);
        return;
    }
    public function markfordelete($id)
    {
        $patient = Patient::find($id);
        $save = new Regdeletepatients();
        $save->id = $patient->id;
        $save->users_id = Auth::user()->id;
        $save->first_name = $patient->first_name;
        $save->middle_name = $patient->middle_name;
        $save->last_name = $patient->last_name;
        $save->suffix = $patient->suffix;
        $save->sex = $patient->sex;
        $save->birthday = $patient->birthday;
        $save->age = $patient->age;
        $save->civil_status = $patient->civil_status;
        $save->address = $patient->address;
        $save->city_municipality = $patient->city_municipality;
        $save->brgy = $patient->brgy;
        $save->contact_no = $patient->contact_no;
        $save->hospital_no = $patient->hospital_no;
        $save->barcode = $patient->barcode;
        $save->printed = $patient->printed;
        $save->save();
        $patient->delete();
        echo json_encode($save);
        return;
    }
    public function restorepatient($id)
    {
        $patient = Regdeletepatients::find($id);
        $save = new Patient();
        $save->id = $patient->id;
        $save->users_id = Auth::user()->id;
        $save->first_name = $patient->first_name;
        $save->middle_name = $patient->middle_name;
        $save->last_name = $patient->last_name;
        $save->suffix = $patient->suffix;
        $save->sex = $patient->sex;
        $save->birthday = $patient->birthday;
        $save->age = $patient->age;
        $save->civil_status = $patient->civil_status;
        $save->address = $patient->address;
        $save->city_municipality = $patient->city_municipality;
        $save->brgy = $patient->brgy;
        $save->contact_no = $patient->contact_no;
        $save->hospital_no = $patient->hospital_no;
        $save->barcode = $patient->barcode;
        $save->printed = $patient->printed;
        $save->save();
        $patient->delete();
        echo json_encode($save);
        return;
    }
    public function referralreport(Request $request)
    {
        $month = DB::select("SELECT MONTH(created_at) AS months, created_at FROM regreferral GROUP BY MONTH(created_at)");

        $year = DB::select("SELECT YEAR(created_at) AS years, created_at FROM regreferral GROUP BY YEAR(created_at)");

        if (isset($request->starting_month) && !isset($request->hospitalid)) {
            $data = DB::select("SELECT b.hospital, a.facility as id, COUNT(*) as results
                               FROM regreferral a 
                               LEFT JOIN regfacility b ON a.facility = b.id
                               WHERE MONTH(a.created_at) BETWEEN ? AND ?
                               AND YEAR(a.created_at) = ?
                               GROUP BY a.facility
                               ", [$request->starting_month, $request->ending_month, $request->years]);
        }elseif (isset($request->month) && !isset($request->hospitalidbymonth)) {
            $data = DB::select("SELECT b.hospital, a.facility as id, COUNT(*) as results
                               FROM regreferral a 
                               LEFT JOIN regfacility b ON a.facility = b.id
                               WHERE MONTH(a.created_at) = ?
                               AND YEAR(a.created_at) = ?
                               GROUP BY a.facility
                               ", [$request->month, $request->years]);
        }elseif (isset($request->hospitalid)) {
            $data = DB::select("SELECT a.id as refid, a.facility, b.id as iniid, b.regdiagonsis_id as diagid, c.diagnosis, count(*) as results
                                FROM regreferral a 
                                LEFT JOIN reginitialdiag b ON a.id = b.regreferral_id
                                LEFT JOIN regdiagnosis c ON b.regdiagonsis_id = c.id
                                WHERE a.facility = ?
                                AND MONTH(created_at) BETWEEN ? AND ?
                                AND YEAR(created_at) = ?
                                AND a.id IN(SELECT regreferral_id FROM reginitialdiag)
                                GROUP BY b.regdiagonsis_id
                                ORDER BY results DESC
                               ", [$request->hospitalid, $request->starting_month, $request->ending_month, $request->years]);
            
        
        }elseif (isset($request->hospitalidbymonth)) {
            $data = DB::select("SELECT a.id as refid, a.facility, b.id as iniid, b.regdiagonsis_id as diagid, c.diagnosis, count(*) as results
                                FROM regreferral a 
                                LEFT JOIN reginitialdiag b ON a.id = b.regreferral_id
                                LEFT JOIN regdiagnosis c ON b.regdiagonsis_id = c.id
                                WHERE a.facility = ?
                                AND MONTH(created_at) = ?
                                AND YEAR(created_at) = ?
                                AND a.id IN(SELECT regreferral_id FROM reginitialdiag)
                                GROUP BY b.regdiagonsis_id
                                ORDER BY results DESC
                               ", [$request->hospitalidbymonth, $request->month, $request->years]);
            
        }
        // dd($data);
       
        return view("patients.referralreport", compact('month', 'year', 'data', 'request'));
    }
    public function getuserbyclinic($id)
    { 
       $user = DB::select("SELECT * 
                            FROM `users` 
                            WHERE `role` = 1
                            AND`activated` = 'Y'
                            AND `id` NOT IN(135,242)
                            AND clinic = ?
                            ORDER BY last_name ASC
                            ", [$id]);
        echo json_encode($user);
        return;
    }
    public function checkpatient(Request $request)
    {
        $patient = DB::select("SELECT a.hospital_no,a.id,a.last_name,a.first_name,a.middle_name,a.birthday,a.sex,a.address, 
                            a.created_at as addate, a.id 
                            FROM patients a
                            WHERE a.last_name LIKE ?
                            AND a.first_name LIKE ?
                            ", ['%'.$request->last_name.'%', '%'.$request->first_name.'%']);
        if (COUNT($patient) > 0) {
            return view('patients.checkpatient', compact('patient', 'request'));
        }else{
            return redirect('patients')->withInput();    
        }
    }
    public function ignorepatients(Request $request)
    {
        return redirect('patients')->withInput();
    }
    public function admitpatient($id)
    {
        $watcher = new Watcher();
        $watcher->patient_id = $id;
        $watcher->save();
        return redirect('admittedpatient')->with('toaster', array('success', 'Patient Admitted.'));
    }
    public function dischargedpatient($id)
    {
        $watcher = Watcher::find($id);
        $watcher->status = 'D';
        $watcher->save();
        return redirect('admittedpatient')->with('toaster', array('success', 'Patient Discharged.'));
    }
    public function admitpatientbyid($id)
    {
       $watcher = Watcher::find($id);
       $watcher->status = 'A';
       $watcher->save();
       return redirect('admittedpatient')->with('toaster', array('success', 'Patient Admitted.'));
    }




    public function mergePatients()
    {
        dd('alldone ty lord jesus');
        /*$tblPatient = TblPatients::all();
        foreach ($tblPatient as $tblPatients){
            $patient = new Patient();
            $patient->id = $tblPatients->id;
            $patient->first_name = (!empty($tblPatients->first_name))? strtoupper(str_replace('Ã‘', 'Ñ', $tblPatients->first_name)) : null;
            $patient->last_name = (!empty($tblPatients->last_name))? strtoupper(str_replace('Ã‘', 'Ñ', $tblPatients->last_name)) : null;
            $patient->middle_name = (!empty($tblPatients->middle_name))? strtoupper(str_replace('Ã‘', 'Ñ', $tblPatients->middle_name)) : null;
            $patient->sex = (!empty($tblPatients->sex))? $tblPatients->sex : null;
            $patient->birthday = (!empty($tblPatients->birthday))? $tblPatients->birthday : null;
            $patient->age = (!empty($tblPatients->age))? $tblPatients->age : null;
            $patient->civil_status = (!empty($tblPatients->civil_status))? $tblPatients->civil_status : null;


            $brgy = ($tblPatients->brgy == 'Select' || $tblPatients->brgy == 'Select Bara' || empty($tblPatients->brgy) || $tblPatients->brgy == null)? null : $tblPatients->brgy;

            if ($brgy){
                $location = DB::table('refbrgy')
                    ->leftJoin('refcitymun', 'refbrgy.citymunCode', '=', 'refcitymun.citymunCode')
                    ->leftJoin('refprovince', 'refcitymun.provCode', '=', 'refprovince.provCode')
                    ->leftJoin('refregion', 'refprovince.regCode', '=', 'refregion.regCode')
                    ->select('refbrgy.brgyDesc', 'refcitymun.citymunDesc', 'refprovince.provDesc', 'refregion.regDesc')
                    ->where('refbrgy.id', '=', $brgy)
                    ->first();
                $address = $location->regDesc.', '.$location->provDesc.', '.$location->citymunDesc.', '.$location->brgyDesc;
            }else{
                $address = null;
            }

            if ($brgy){
                $cities = Refbrgy::find($brgy);
                $city = $cities->citymunCode;
            }else{
                $city = null;
            }

            $patient->address = $address;
            $patient->city_municipality = $city;
            $patient->brgy = $brgy;

            $patient->contact_no = (!empty($tblPatients->contact_no))? $tblPatients->contact_no : null;
            $patient->hospital_no = (!empty($tblPatients->hospital_no))? $tblPatients->hospital_no : null;
            $patient->barcode = $tblPatients->barcode;
            $patient->printed = $tblPatients->printed;
            $patient->created_at = $tblPatients->date_reg;
            $patient->save();
        }*/
    }




}
