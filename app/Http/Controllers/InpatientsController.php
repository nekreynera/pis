<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Patient;
use App\Inpatient;
use App\Watcher;
use Validator;
use DB;
use Auth;
use Carbon;
use Session;

class InpatientsController extends Controller
{

    public function selectpatient($id)
    {
        $patient = Inpatient::checkInpatient($id);
        if ($patient) {
            if (Carbon::parse($patient->created_at)->format('Y-m-d') == Carbon::now()->format('Y-m-d')) {
                return redirect('admittedpatient')->with('toaster', array('success', 'Patient Already Registered Today.'));
            }else{
                Inpatient::storeInpatient($id);  
                return redirect('admittedpatient')->with('toaster', array('success', 'Patient Selected.'));
            }
        }else{
            Inpatient::storeInpatient($id);
            return redirect('admittedpatient')->with('toaster', array('success', 'Patient Selected.'));
        }
        
    }
    public function admittedpatient()
    {
        $data = DB::select("SELECT a.patients_id, b.hospital_no, b.last_name, b.first_name, b.middle_name, b.suffix, b.address, b.birthday, MAX(a.created_at) as created_at, b.sex, b.barcode, a.id
                            FROM inpatient a 
                            LEFT JOIN patients b ON a.patients_id = b.id
                            -- WHERE DATE(a.created_at) = CURRENT_DATE()
                            GROUP BY a.patients_id
                            ORDER BY a.created_at DESC 
                            ");
        return view('patients.admitted', compact('data'));
    }
    public function searchadmitted(Request $request)
    {
        if($request->name){
            $data = DB::select("SELECT a.patients_id, b.hospital_no, b.last_name, b.first_name, b.middle_name, b.suffix, b.address, b.birthday, MAX(a.created_at) as created_at, b.sex, b.barcode, a.id
                            FROM inpatient a 
                            LEFT JOIN patients b ON a.patients_id = b.id
                            WHERE CONCAT(b.last_name,' ',b.first_name,' ',b.middle_name) LIKE ?
                            GROUP BY a.patients_id
                            ORDER BY a.created_at DESC
                            ", ['%'.$request->name.'%']);
        }elseif ($request->birthday) {
            $data = DB::select("SELECT a.patients_id, b.hospital_no, b.last_name, b.first_name, b.middle_name, b.suffix, b.address, b.birthday, MAX(a.created_at) as created_at, b.sex, b.barcode, a.id
                            FROM inpatient a 
                            LEFT JOIN patients b ON a.patients_id = b.id
                            WHERE DATE(b.birthday) = ?
                            GROUP BY a.patients_id
                            ORDER BY a.created_at DESC
                            ", [$request->birthday]);
        }elseif ($request->barcode) {
            $data = DB::select("SELECT a.patients_id, b.hospital_no, b.last_name, b.first_name, b.middle_name, b.suffix, b.address, b.birthday, MAX(a.created_at) as created_at, b.sex, b.barcode, a.id
                            FROM inpatient a 
                            LEFT JOIN patients b ON a.patients_id = b.id
                            WHERE b.barcode = ?
                            GROUP BY a.patients_id
                            ORDER BY a.created_at DESC
                            ", [$request->barcode]);
        }elseif ($request->hospital_no) {
            $data = DB::select("SELECT a.patients_id, b.hospital_no, b.last_name, b.first_name, b.middle_name, b.suffix, b.address, b.birthday, MAX(a.created_at) as created_at, b.sex, b.barcode, a.id
                            FROM inpatient a 
                            LEFT JOIN patients b ON a.patients_id = b.id
                            WHERE b.hospital_no = ?
                            GROUP BY a.patients_id
                            ORDER BY a.created_at DESC
                            ", [$request->hospital_no]);
        }elseif ($request->created_at) {
            $data = DB::select("SELECT a.patients_id, b.hospital_no, b.last_name, b.first_name, b.middle_name, b.suffix, b.address, b.birthday, MAX(a.created_at) as created_at, b.sex, b.barcode, a.id
                            FROM inpatient a 
                            LEFT JOIN patients b ON a.patients_id = b.id
                            WHERE DATE(a.created_at) = ?
                            GROUP BY a.patients_id
                            ORDER BY a.created_at DESC
                            ", [$request->created_at]);
        }
        if (isset($data) && count($data) > 0) {
            Session::flash('toaster', array('success', 'Matching Records Found.'));
            return view('patients.admitted', compact('data'));
        }else{
            Session::flash('toaster', array('error', 'No Matching Records Found.'));
            return view('patients.admitted', compact('data'));
        }
    }
    public function checkwatcher(Request $request)
    {
        $patient = DB::select("SELECT a.hospital_no,a.id,a.last_name,a.first_name,a.middle_name,a.birthday,a.sex,a.address, 
                            a.created_at as addate, a.id 
                            FROM patients a
                            WHERE a.last_name LIKE ?
                            AND a.first_name LIKE ?
                            AND a.id NOT IN($request->ptid)
                            ", ['%'.$request->last_name.'%', '%'.$request->first_name.'%']);
        if (COUNT($patient) > 0) {
            return view('patients.checkwatcher', compact('patient', 'request'));
        }else{
            return redirect('watcher/'.$request->ptid.'')->withInput();    
        }
    }
    public function selectwatcher($pid, $wid)
    {
        (new Watcher())->storePatientWatcher($pid, $wid);
        return redirect('admittedpatient')->with('toaster', array('success', 'Watcher Added.'));
    }
    public function deleteinpatient($pid)
    {
       Inpatient::where('patients_id', '=', $pid)->delete();
       Watcher::where('patient_id', '=', $pid)->delete();
       return redirect('admittedpatient')->with('toaster', array('warning', 'Patient and its Watcher Deleted.'));
    }

    
    

}