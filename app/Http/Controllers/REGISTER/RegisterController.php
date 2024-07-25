<?php

namespace App\Http\Controllers\REGISTER;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\REGISTER\HospitalIDController;
use App\Patient;
use App\Triage;
use App\VitalSigns;
use App\Clinic;
use App\Regforreferral;
use App\ForDelete;
use App\Printed;
use Auth;
use DB;
use Validator;
use Response;
use Carbon\Carbon;



class RegisterController extends Controller
{
    public function index(Request $request)
    {  
        if ($request->deleted == true) {
            $data = Patient::deletePatient();
        }
        else if (count($request->post()) > 0) {
            $data = Patient::Search($request);
        }
        else{
            $data = Patient::Today();
        }
        return view('OPDMS.patients.pages.main', compact('data', 'request'));
    }
    public function store(Request $request)
    {
        /*=============HOSPITAL NO================*/
        // if (!$request->hospital_no) {
        //     $hospital_no = DB::select("SELECT 
        //                                 MAX(hospital_no) as hospital_no
        //                             FROM patients
        //                             WHERE hospital_no NOT IN(SELECT hospital_no FROM adopted_hostpital_numbers)");
        //     $hospital_no = $hospital_no[0]->hospital_no;

        //     $get = false;

            
            
        //     if ($hospital_no) {
        //         while($get == false){
        //             $hospital_no = $hospital_no + 1;
        //             $hospital_no =  str_pad($hospital_no, 6, '0', STR_PAD_LEFT);
        //             $try = DB::select("SELECT hospital_no FROM patients WHERE hospital_no = ?", [$hospital_no]);
        //             if (!$try) {
        //                 $get = true;
        //             }
        //         }
        //     }else{
        //         $hospital_no = '000001';
        //     }
        //     $request->request->add(['hospital_no' => $hospital_no]);
        // }

        /*==========================USED FUNCTIONS ID=========================*/
        $hospital_no = Patient::max('hospital_no');
        if ($hospital_no) {
            $hospital_no = $hospital_no + 1;
            $hospital_no =  str_pad($hospital_no, 6, '0', STR_PAD_LEFT);
        }else{
            $hospital_no = '000001';
        }
        $request->request->add(['hospital_no' => $hospital_no]);
        /*===================================================================*/
        

        /*===============BARCODE================*/        
        $random = rand(000001, 600000);
        $generated_num = (strlen($random) < 6)? str_pad($random, 6, '0', STR_PAD_LEFT) : $random ;
        $barcode = 'EVRMC'.date("mdY").$generated_num;
        $request->request->add(['barcode' => $barcode]);


        /*=============REQUEST=================*/

            $rules = array(
                    'last_name' => 'required',
                    'first_name' => 'required',
                    'birthday' => 'required|date|before_or_equal:'.Carbon::now()->format('Y-m-d').'',
                    'city_municipality' => 'required',
                    'sex' => 'required',
                    'hospital_no' => 'unique:patients',
                    );

            $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return Response::json(array(
                        'errors' => $validator->getMessageBag()->toArray()
                    ));
                }else{
                    try{
                        $patient = Patient::create([
                                        'first_name' => strtoupper(str_replace('ñ', 'Ñ', $request->first_name)),
                                        'middle_name' => strtoupper(str_replace('ñ', 'Ñ', $request->middle_name)),
                                        'last_name' => strtoupper(str_replace('ñ', 'Ñ', $request->last_name)),
                                        'suffix' => $request->suffix,
                                        'sex' => $request->sex,
                                        'birthday' => Carbon::parse($request->birthday)->format('Y-m-d'),
                                        'age' => $request->age,
                                        'civil_status' => $request->civil_status,
                                        'address' => $request->address,
                                        'city_municipality' => $request->city_municipality,
                                        'brgy' => $request->brgy,
                                        'contact_no' => $request->contact_no,
                                        'hospital_no' => $request->hospital_no,
                                        'barcode' => $request->barcode,
                                        'users_id' => Auth::user()->id,
                                    ]);

                    }catch(QueryException $ex){
                        $patient = 'Synchronize Registration Not Allowed.';
                    }
                }
        $regforreferral = null;
        $triage = null;
        if ($patient != 'Synchronize Registration Not Allowed.') {
            if ($request->referral == "yes")
            {
                $regforreferral = new Regforreferral();
                $regforreferral->patients_id = $patient->id;
                $regforreferral->save();
            }
           
            if ($request->clinic_code_store) {
                $triage = new Triage();
                $triage->patients_id = $patient->id;
                $triage->users_id = Auth::user()->id;
                $triage->clinic_code = $request->clinic_code_store;
                $triage->save();

                
            }
            if ($triage) {
                $vitalsigns = new VitalSigns();
                $vitalsigns->storeVitalSigns($request, $triage->id, $patient->id);
            }
        }


        echo json_encode(['patient' => $patient, 'regforreferral' => $regforreferral, 'triage' => $triage]);
        return;
    }

    public function show($id)
    {


        $patient = DB::table('patients')
                        ->whereIn('id', explode(',', $id))
                        ->orderBy('last_name', 'ASC')
                        ->get();
        DB::table('patients')
                                ->whereIn('id', explode(',', $id))
                                ->update(array('printed' => 'Y'));
        $list = explode(',', $id);
        foreach ($list as $key => $value) {
           $print = new Printed();
           $print->users_id = Auth::user()->id;
           $print->patient_id = $list[$key];
           $print->save();
        }
        $hospital = new HospitalIDController();
        $hospital->hospitalid($patient);


    }


    public function edit($id)
    {
        $patient = Patient::find($id);
        $triage = Triage::where('patients_id', '=', $id)
                        ->whereDate('created_at', '=', Carbon::today())->first();
        $vital = VitalSigns::where('patients_id', '=', $id)
                        ->whereDate('created_at', '=', Carbon::today())->first();
        $referral = Regforreferral::where('patients_id', '=', $patient->id)->first();
        $address = DB::select("SELECT b.id, b.brgyDesc,
                                        c.citymunCode, c.citymunDesc,
                                        d.provCode, d.provDesc,
                                        e.regCode, e.regDesc
                                FROM patients a 
                                LEFT JOIN refbrgy b ON a.brgy = b.id
                                LEFT JOIN refcitymun c ON a.city_municipality = c.citymunCode
                                LEFT JOIN refprovince d ON c.provCode = d.provCode
                                LEFT JOIN refregion e ON d.regCode = e.regCode
                                WHERE a.id = ?
                                ", [$id]);
        echo json_encode(['patient' => $patient, 'triage' => $triage, 'vital' => $vital, 'referral' => $referral, 'address' => $address[0]]);
        return;
    }
    public function update(Request $request, $id)
    {
        $rules = array(
                'last_name' => 'required',
                'first_name' => 'required',
                'birthday' => 'required|date|before_or_equal:'.Carbon::now()->format('Y-m-d').'',
                'city_municipality' => 'required',
                'sex' => 'required',
            );
        $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return Response::json(array(
                    'errors' => $validator->getMessageBag()->toArray()
                ));
            }else{
                $patient = Patient::find($id);
                $patient->first_name = strtoupper(str_replace('ñ', 'Ñ', $request->first_name));
                $patient->middle_name = strtoupper(str_replace('ñ', 'Ñ', $request->middle_name));
                $patient->last_name = strtoupper(str_replace('ñ', 'Ñ', $request->last_name));
                $patient->suffix = $request->suffix;
                $patient->sex = $request->sex;
                $patient->birthday = Carbon::parse($request->birthday)->format('Y-m-d');
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
                if ($patient->walkin && !$patient->hospital_no) {
                    # code...
                    $hospital_no = Patient::max('hospital_no');
                    if ($hospital_no) {
                        $hospital_no = $hospital_no + 1;
                        $hospital_no =  str_pad($hospital_no, 6, '0', STR_PAD_LEFT);
                    }else{
                        $hospital_no = '000001';
                    }
                    $request->request->add(['hospital_no' => $hospital_no]);

                    $patient->hospital_no = $hospital_no;
                }
                $patient->walkin = null;
                $patient->save();

                $referral = Regforreferral::where('patients_id', '=', $id)->first();
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

                if (Carbon::parse($patient->created_at)->format('Y-m-d') == Carbon::parse(Carbon::today())->format('Y-m-d')) {

                    if ($request->clinic_code) {
                        $triage = Triage::where('patients_id', '=', $id)
                                        ->whereDate('created_at', '=', Carbon::today())
                                        ->first();
                        if (!$triage) {
                            $triage = new Triage();
                            $triage->patients_id = $id;
                        }
                        $triage->users_id = Auth::user()->id;
                        $triage->clinic_code = $request->clinic_code;
                        $triage->save();
                        $vital = VitalSigns::where('patients_id', '=', $id)
                                        ->whereDate('created_at', '=', Carbon::today())
                                        ->first();
                        if (!$vital) {
                            $vitalsigns = new VitalSigns();
                            $vitalsigns->storeVitalSigns($request, $triage->id, $patient->id);
                        }else{
                            $vital->weight = $request->weight;
                            $vital->height = $request->height;
                            $vital->blood_pressure = $request->blood_pressure;
                            $vital->pulse_rate = $request->pulse_rate;
                            $vital->respiration_rate = $request->respiration_rate;
                            $vital->body_temperature = $request->body_temperature;
                            $vital->save();
                        }
                    }
                }
            }
        echo json_encode($patient);
        return;
    }
    public function destroy($id, Request $request)
    {
        // dd($request);
        $delete = null;
        $rules = array(
                'remark' => 'required',
            );
        $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return Response::json(array(
                    'errors' => $validator->getMessageBag()->toArray()
                ));
            }else{
                $check = ForDelete::where('patient_id', '=', $id)->first();
                if (!$check) {
                    $delete = new ForDelete();
                    $delete->user_id = Auth::user()->id;
                    $delete->patient_id = $id;
                    $delete->remark = $request->remark;
                    $delete->save();
                }

            }
        echo json_encode($delete);
        return;
    }
}
