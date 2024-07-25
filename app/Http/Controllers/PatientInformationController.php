<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Contracts\Support\JsonableInterface;
use App\Patient;
use DB;
use Session;
use Carbon;
use Validator;
use Auth;

class PatientInformationController extends Controller
{



    public function patient_information($pid)
    {
        $data = Patient::where('patients.id', $pid)
                ->leftJoin('mssclassification', 'mssclassification.patients_id', 'patients.id')
                ->leftJoin('mss', 'mss.id', 'mssclassification.mss_id')
                ->leftJoin('vital_signs', function ($join){
                    $join->on('vital_signs.patients_id', 'patients.id')
                            ->where(DB::raw('DATE(vital_signs.created_at)'), DB::raw('CURDATE()'));
                })
                ->first();
        return $data->toJson();
    }



}