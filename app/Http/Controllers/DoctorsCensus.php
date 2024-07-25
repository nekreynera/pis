<?php

namespace App\Http\Controllers;

use App\Queue;
use Illuminate\Http\Request;
use App\Patient;
use App\Clinic;
use App\VitalSigns;
use App\User;
use App\Consultation;
use App\ConsultationsICD;
use App\Mssclassification;
use App\ICD;
use Session;
use Validator;
use Auth;
use DB;
use Carbon;



class DoctorsCensus extends Controller{


    public function doctors_census($starting = false, $ending = false, $limit = false)
    {
        $clinic = Auth::user()->clinic;
        if (!$limit){
            $limit = 5000;
        }

        $census = DB::select("SELECT COUNT(cicd.icd) AS icdTop, cicd.icd, LEFT(icd_codes.code, 3) as code, 
                                cicd.users_id, icd_codes.description, pt.id, pt.birthday, pt.sex 
                                FROM consultations_icd cicd
                                LEFT JOIN icd_codes ON icd_codes.id = cicd.icd
                                LEFT JOIN consultations cons ON cons.id = cicd.consultations_id
                                LEFT JOIN patients pt ON pt.id = cicd.patients_id
                                LEFT JOIN users ON users.id = cicd.users_id
                                WHERE DATE(cicd.created_at) BETWEEN '".$starting."' AND '".$ending."'
                                AND cicd.users_id = '".Auth::user()->id."' 
                                AND cons.clinic_code = '".Auth::user()->clinic."' 
                                AND LEFT(code, 3) REGEXP '[0-9]$'
                                GROUP BY LEFT(code, 3)
                                ORDER BY COUNT(cicd.icd) DESC LIMIT $limit");

        // $clinic = Clinic::find(Auth::user()->clinic);
        return view('doctors.reports.census', compact('census', 'clinic', 'starting', 'ending', 'limit'));
    }

    public function doctorsStoreCensus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'startingDate' => 'required|before_or_equal:'.$request->endingDate,
            'endingDate' => 'required|after_or_equal:'.$request->startingDate,
        ]);
        if ($validator->passes()) {
            return redirect("doctors_census/$request->startingDate/$request->endingDate/$request->filter");
        }else{
            return redirect()->back()->withInput()->withErrors($validator);
        }
    }



}
