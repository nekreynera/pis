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



class CensusController extends Controller{


    public function famedcensus($starting = false, $ending = false, $limit = false)
    {
        $clinic = Auth::user()->clinic;
        if (!$limit){
            $limit = 5000;
        }
        /*$census = DB::select("SELECT COUNT(cicd.icd) AS icdTop, cicd.icd, icd_codes.code, cicd.users_id, icd_codes.description, pt.id, pt.birthday, pt.sex FROM consultations_icd cicd
                                            LEFT JOIN icd_codes ON icd_codes.id = cicd.icd
                                            LEFT JOIN consultations cons ON cons.id = cicd.consultations_id
                                            LEFT JOIN patients pt ON pt.id = cicd.patients_id
                                            LEFT JOIN users ON users.id = cicd.users_id
                                            WHERE DATE(cicd.created_at) BETWEEN '".$starting."' AND '".$ending."'
                                            AND users.clinic = $clinic GROUP BY cicd.icd ORDER BY COUNT(cicd.icd) DESC LIMIT $limit");*/

        $census = DB::select("SELECT COUNT(cicd.icd) AS icdTop, cicd.icd, LEFT(icd_codes.code, 3) as code, 
                                cicd.users_id, icd_codes.description, pt.id, pt.birthday, pt.sex 
                                FROM consultations_icd cicd
                                LEFT JOIN icd_codes ON icd_codes.id = cicd.icd
                                LEFT JOIN consultations cons ON cons.id = cicd.consultations_id
                                LEFT JOIN patients pt ON pt.id = cicd.patients_id
                                LEFT JOIN users ON users.id = cicd.users_id
                                WHERE DATE(cicd.created_at) BETWEEN '".$starting."' AND '".$ending."'
                                AND cons.clinic_code = '".$clinic."' 
                                AND LEFT(code, 3) REGEXP '[0-9]$'
                                GROUP BY LEFT(code, 3)
                                ORDER BY COUNT(cicd.icd) DESC LIMIT $limit");

        $clinic = Clinic::find(Auth::user()->clinic);
        return view('receptions.census', compact('census', 'clinic', 'starting', 'ending', 'limit'));
    }

    public function receptionCensus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'startingDate' => 'required|before_or_equal:'.$request->endingDate,
            'endingDate' => 'required|after_or_equal:'.$request->startingDate,
        ]);
        if ($validator->passes()) {
            //dd($request->filter);
            return redirect("famedcensus/$request->startingDate/$request->endingDate/$request->filter");
        }else{
            return redirect()->back()->withInput()->withErrors($validator);
        }
    }



    public function demographic($starting = false, $ending = false, $category = false)
    {

        if ($starting){

            $demographics = Queue::whereBetween(DB::raw("DATE(queues.created_at)"), [$starting, $ending])
                ->leftJoin('patients as pt', 'pt.id', 'queues.patients_id')
                ->leftJoin('refcitymun', 'refcitymun.citymunCode', '=', 'pt.city_municipality')
                ->leftJoin('refprovince', 'refprovince.provCode', '=', 'refcitymun.provCode')
                ->whereNotNull('city_municipality')
                ->where('queues.clinic_code', '=', Auth::user()->clinic)
                // ->groupBy('queues.patients_id', DB::raw('DATE(queues.created_at)')) // WRONG CODE
                ->groupBy('queues.patients_id')
                ->when($category == 'New', function ($query) use ($category){
                    return $query->havingRaw('COUNT(queues.patients_id) = 1');
                })
                ->when($category == 'Old', function ($query) use ($category){
                    return $query->havingRaw('COUNT(queues.patients_id) > 1');
                })
                ->select('queues.patients_id', 'pt.birthday', 'pt.sex',
                    DB::raw("CONCAT(pt.last_name,' ',pt.first_name,' ',
                CASE WHEN pt.suffix IS NOT NULL THEN pt.suffix ELSE '' END,' ',
                CASE WHEN pt.middle_name IS NOT NULL THEN LEFT(pt.middle_name, 1) ELSE '' END) as name"),
                    'pt.city_municipality', 'refcitymun.citymunDesc', 'refcitymun.district', 'refprovince.provCode',
                    DB::raw("COUNT(queues.patients_id) AS total"))
                ->orderBy('queues.created_at', 'desc')
                ->get();


        }else{
            $demographics = null;
        }

        $clinic = Clinic::find(Auth::user()->clinic);

        return view('receptions.demographic', compact('demographics', 'starting', 'ending', 'category', 'clinic'));

    }




    public function demographicRequest(Request $request)
    {
        return redirect()->route('demographic', ['starting'=>$request->starting, 'ending'=>$request->ending, 'category'=>$request->category]);
    }



    public function demographicSummaryPost(Request $request)
    {
        return redirect()->route('demographicSummary', ['starting'=>$request->starting, 'ending'=>$request->ending]);
    }


    public function demographicSummary($starting = false, $ending = false)
    {
        if ($starting){
            /*$demographics = Consultation::select('consultations.patients_id', 'pt.birthday', 'pt.sex',
                DB::raw("CONCAT(pt.last_name,' ',pt.first_name,' ',CASE WHEN pt.suffix IS NOT NULL THEN pt.suffix ELSE '' END,' ',CASE WHEN pt.middle_name IS NOT NULL THEN LEFT(pt.middle_name, 1) ELSE '' END) as name"),
                'pt.city_municipality', 'refcitymun.citymunDesc', 'refcitymun.district', 'refprovince.provCode', DB::raw("COUNT(consultations.patients_id) AS total"))
                ->leftJoin('patients as pt', 'pt.id', '=', 'consultations.patients_id')
                ->leftJoin('refcitymun', 'refcitymun.citymunCode', '=', 'pt.city_municipality')
                ->leftJoin('refprovince', 'refprovince.provCode', '=', 'refcitymun.provCode')
                ->whereBetween(DB::raw("DATE(consultations.created_at)"), [$starting, $ending])
                ->whereNotNull('city_municipality')
                ->where('consultations.clinic_code', '=', Auth::user()->clinic)
                ->groupBy('consultations.patients_id')
                ->orderBy('consultations.created_at', 'desc')
                ->get();*/

            $demographics = Queue::whereBetween(DB::raw("DATE(queues.created_at)"), [$starting, $ending])
                ->leftJoin('patients as pt', 'pt.id', 'queues.patients_id')
                ->leftJoin('refcitymun', 'refcitymun.citymunCode', '=', 'pt.city_municipality')
                ->leftJoin('refprovince', 'refprovince.provCode', '=', 'refcitymun.provCode')
                ->whereNotNull('city_municipality')
                ->where('queues.clinic_code', '=', Auth::user()->clinic)
                // ->groupBy('queues.patients_id', DB::raw("DATE(queues.created_at)")) // WRONG CODE
                ->groupBy('queues.patients_id')
                ->select('queues.patients_id', 'pt.birthday', 'pt.sex',
                    DB::raw("CONCAT(pt.last_name,' ',pt.first_name,' ',
                CASE WHEN pt.suffix IS NOT NULL THEN pt.suffix ELSE '' END,' ',
                CASE WHEN pt.middle_name IS NOT NULL THEN LEFT(pt.middle_name, 1) ELSE '' END) as name"),
                    'pt.city_municipality', 'refcitymun.citymunDesc', 'refcitymun.district', 'refprovince.provCode',
                    DB::raw("COUNT(queues.patients_id) AS total"))
                ->orderBy('queues.created_at', 'desc')
                ->get();




        }else{
            $demographics = null;
        }


        $final = array();
        $new = 0;
        $old = 0;
        $cso = 0;
        $csn = 0;
        $geriaO = 0;
        $geriaN = 0;
        $ted = 0;
        if ($demographics) {

            foreach ($demographics as $demographic) {


                $age = Patient::censusage($demographic->birthday);
                if ($age >= 60 && $age <= 70 && $demographic->total > 1){
                    $cso++;
                }elseif ($age >= 60 && $age <= 70 && $demographic->total == 1){
                    $csn++;
                }
                if ($age >= 70 && $demographic->total > 1){
                    $geriaO++;
                }elseif ($age >= 70 && $demographic->total == 1){
                    $geriaN++;
                }

                if ($demographic->provCode == '0837' && $demographic->city_municipality == '083747') {
                    if ($demographic->total > 1) {
                        (array_key_exists('TO', $final) ? $final['TO']++ : array_push($final, $final['TO'] = 1));
                        $old++;
                    } else {
                        (array_key_exists('TN', $final) ? $final['TN']++ : array_push($final, $final['TN'] = 1));
                        $new++;
                    }
                }
                (!array_key_exists('TN', $final)) ? array_push($final, $final['TN'] = 0) : '';
                (!array_key_exists('TO', $final)) ? array_push($final, $final['TO'] = 0) : '';
                for ($i = 1; $i < 6; $i++) {
                    if ($demographic->provCode == '0837' && $demographic->city_municipality != '083747') {
                        if ($demographic->district == $i) {
                            if ($demographic->total > 1) {
                                array_key_exists('LO' . $i, $final) ? $final['LO' . $i]++ : array_push($final, $final['LO' . $i] = 1);
                                $old++;
                            } else {
                                array_key_exists('LN' . $i, $final) ? $final['LN' . $i]++ : array_push($final, $final['LN' . $i] = 1);
                                $new++;
                            }
                        }
                    }
                    (!array_key_exists('LO' . $i, $final)) ? array_push($final, $final['LO' . $i] = 0) : '';
                    (!array_key_exists('LN' . $i, $final)) ? array_push($final, $final['LN' . $i] = 0) : '';
                }
                for ($i = 1; $i < 3; $i++) {
                    if ($demographic->provCode == '0860') {
                        if ($demographic->district == $i) {
                            if ($demographic->total > 1) {
                                array_key_exists('WSO' . $i, $final) ? $final['WSO' . $i]++ : array_push($final, $final['WSO' . $i] = 1);
                                $old++;
                            } else {
                                array_key_exists('WSN' . $i, $final) ? $final['WSN' . $i]++ : array_push($final, $final['WSN' . $i] = 1);
                                $new++;
                            }
                        }
                    }
                    (!array_key_exists('WSO' . $i, $final)) ? array_push($final, $final['WSO' . $i] = 0) : '';
                    (!array_key_exists('WSN' . $i, $final)) ? array_push($final, $final['WSN' . $i] = 0) : '';
                }
                for ($i = 1; $i < 3; $i++) {
                    if ($demographic->provCode == '0826') {
                        if ($demographic->district == $i) {
                            if ($demographic->total > 1) {
                                array_key_exists('ESO' . $i, $final) ? $final['ESO' . $i]++ : array_push($final, $final['ESO' . $i] = 1);
                                $old++;
                            } else {
                                array_key_exists('ESN' . $i, $final) ? $final['ESN' . $i]++ : array_push($final, $final['ESN' . $i] = 1);
                                $new++;
                            }
                        }
                    }
                    (!array_key_exists('ESO' . $i, $final)) ? array_push($final, $final['ESO' . $i] = 0) : '';
                    (!array_key_exists('ESN' . $i, $final)) ? array_push($final, $final['ESN' . $i] = 0) : '';
                }
                for ($i = 1; $i < 3; $i++) {
                    if ($demographic->provCode == '0848') {
                        if ($demographic->district == $i) {
                            if ($demographic->total > 1) {
                                array_key_exists('NSO' . $i, $final) ? $final['NSO' . $i]++ : array_push($final, $final['NSO' . $i] = 1);
                                $old++;
                            } else {
                                array_key_exists('NSN' . $i, $final) ? $final['NSN' . $i]++ : array_push($final, $final['NSN' . $i] = 1);
                                $new++;
                            }
                        }
                    }
                    (!array_key_exists('NSO' . $i, $final)) ? array_push($final, $final['NSO' . $i] = 0) : '';
                    (!array_key_exists('NSN' . $i, $final)) ? array_push($final, $final['NSN' . $i] = 0) : '';
                }
                for ($i = 1; $i < 3; $i++) {
                    if ($demographic->provCode == '0864') {
                        if ($demographic->district == $i) {
                            if ($demographic->total > 1) {
                                array_key_exists('SLO' . $i, $final) ? $final['SLO' . $i]++ : array_push($final, $final['SLO' . $i] = 1);
                                $old++;
                            } else {
                                array_key_exists('SLN' . $i, $final) ? $final['SLN' . $i]++ : array_push($final, $final['SLN' . $i] = 1);
                                $new++;
                            }
                        }
                    }
                    (!array_key_exists('SLO' . $i, $final)) ? array_push($final, $final['SLO' . $i] = 0) : '';
                    (!array_key_exists('SLN' . $i, $final)) ? array_push($final, $final['SLN' . $i] = 0) : '';
                }
                for ($i = 1; $i < 3; $i++) {
                    if ($demographic->provCode == '0878') {
                        if ($demographic->district == $i) {
                            if ($demographic->total > 1) {
                                array_key_exists('BO' . $i, $final) ? $final['BO' . $i]++ : array_push($final, $final['BO' . $i] = 1);
                                $old++;
                            } else {
                                array_key_exists('BN' . $i, $final) ? $final['BN' . $i]++ : array_push($final, $final['BN' . $i] = 1);
                                $new++;
                            }
                        }
                    }
                    (!array_key_exists('BO' . $i, $final)) ? array_push($final, $final['BO' . $i] = 0) : '';
                    (!array_key_exists('BN' . $i, $final)) ? array_push($final, $final['BN' . $i] = 0) : '';
                }
            }

        }


        $clinic = Clinic::find(Auth::user()->clinic);

        return view('receptions.demographicSumarry', compact('final', 'new', 'old', 'cso', 'csn', 'geriaO', 'geriaN', 'starting', 'ending', 'clinic'));
    }


}
