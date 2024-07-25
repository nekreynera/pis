<?php

namespace App\Http\Controllers\OPDMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\JsonableInterface;
use App\Patient;
use DB;
use Carbon;
use Auth;


class PatientInfoController extends Controller
{
    public function patient_info_vs(Request $request)
    {
        $data = Patient::where('patients.id', $request->pid)
            ->leftJoin('mssclassification', 'mssclassification.patients_id', 'patients.id')
            ->leftJoin('mss', 'mss.id', 'mssclassification.mss_id')
            ->leftJoin('vital_signs', function ($join){
                $join->on('vital_signs.patients_id', 'patients.id')
                    ->where(DB::raw('DATE(vital_signs.created_at)'), DB::raw('CURDATE()'));
            })
            ->select('*', 'patients.created_at as date_reg', 'vital_signs.created_at as vs_created_date')
            ->first();
        return $data->toJson();
    }

    public function patient_name(Patient $patient)
    {
        return $patient->toJson();
    }
}
