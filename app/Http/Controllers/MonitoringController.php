<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use DB;
use Auth;
use Carbon\Carbon;
use Session;


class MonitoringController extends Controller
{

    public function censusWatch($category = false, $daily = false)
    {
        if ($category && $daily){
            $date = Carbon::instance(new \DateTime($daily))->toDateString();
            return view('receptions.reports.daily', compact('date', 'daily', 'category'));
        }
        return view('receptions.reports.daily', compact('daily', 'category'));
    }



    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'optradio' => 'required',
            'daily' => 'nullable|date',
            'starting' => 'nullable|date',
            'ending' => 'nullable|date|after_or_equal:'.$request->starting.'',
        ]);


        if ($validator->passes()) {

            if ($request->optradio == 'daily'){
                return redirect("censusWatch/$request->optradio/$request->daily");
            }else{
                if(Carbon::parse($request->starting)->year != Carbon::parse($request->ending)->year){
                    return redirect()->back()->with('toaster', array('error', 'Query must be in the same year.'));
                }else{
                    return redirect("censusMonthly/$request->starting/$request->ending/$request->optradio");
                }
            }

        }else{
            $census = ($request->optradio == 'daily')? 'daily' : 'monthly';
            Session::flash('census', $census);
            return redirect()->back()->withInput()->withErrors($validator);
        }

    }





    public function censusMonthly($starting = false, $ending = false, $category = false)
    {
        $start = Carbon::instance(new \DateTime($starting))->toDateString();
        $end = Carbon::instance(new \DateTime($ending))->toDateString();
        return view('receptions.reports.monthly45', compact('start', 'end', 'starting', 'ending', 'category'));
    }






    public static function monitor($date, $status){
        $noDoctorsClinic = array(10,48,22,21);

        if (!in_array(Auth::user()->clinic, $noDoctorsClinic)){
            if ($status == 'U'){
                $code = 'AND asgn.id IS NULL';
            }else{
                $code = "AND asgn.status = '".$status."'";
            }
            $query = DB::select("SELECT COUNT(*) as total, status, queueDate as date FROM
                                (
                                SELECT asgn.status, queues.created_at as queueDate
                                FROM queues
                                LEFT JOIN assignations asgn ON asgn.patients_id = queues.patients_id 
                                AND asgn.clinic_code = queues.clinic_code 
                                AND DATE(asgn.created_at) = DATE(queues.created_at)
                                WHERE DATE(queues.created_at) = '".$date."'
                                AND queues.clinic_code = ".Auth::user()->clinic."
                                ".$code."
                                GROUP BY queues.patients_id, DATE(queues.created_at)
                                ) as jesus
                                GROUP BY DATE(queueDate)");


        }else{
            if (Auth::user()->clinic == 22){
                if ($status == 'D'){
                    $query = DB::select("SELECT COUNT(*) as total FROM queues
                            WHERE DATE(created_at) = '".$date."'
                            AND clinic_code = ".Auth::user()->clinic."
                            AND queue_status IN ('F','D')");
                }else{
                    $query = DB::select("SELECT COUNT(*) as total FROM queues
                            WHERE DATE(created_at) = '".$date."'
                            AND clinic_code = ".Auth::user()->clinic."
                            AND queue_status = '".$status."'");
                }
            }else{
                $query = DB::select("SELECT COUNT(*) as total FROM queues
                            WHERE DATE(created_at) = '".$date."'
                            AND clinic_code = ".Auth::user()->clinic."
                            AND queue_status = '".$status."'");
            }
        }

        if (!empty($query)){
            return $query[0]->total;
        }else{
            return 0;
        }
    }


    public static function monitorMonthly($starting, $ending, $category)
    {
        $noDoctorsClinic = array(10,48,22,21);
        if (!in_array(Auth::user()->clinic, $noDoctorsClinic)) {
            if ($category == 'U') {
                $code = 'AND asgn.id IS NULL';
            } else {
                $code = "AND asgn.status = '" . $category . "'";
            }
            $query = DB::select("SELECT COUNT(*) as total FROM
                            (
                            SELECT asgn.status, queues.created_at as queueDate
                            FROM queues
                            LEFT JOIN assignations asgn ON asgn.patients_id = queues.patients_id 
                            AND asgn.clinic_code = queues.clinic_code 
                            AND DATE(asgn.created_at) = DATE(queues.created_at)
                            WHERE DATE(queues.created_at) BETWEEN '" . $starting . "' AND '" . $ending . "'
                            AND queues.clinic_code = " . Auth::user()->clinic . "
                            " . $code . "
                            GROUP BY queues.patients_id, DATE(queues.created_at)
                                ) jesus");
        }else{

            if (Auth::user()->clinic == 22 || Auth::user()->clinic == 21){
                if ($category == 'D'){
                    $query = DB::select("SELECT COUNT(*) as total FROM queues
                            WHERE DATE(created_at) BETWEEN '" . $starting . "' AND '" . $ending . "'
                            AND clinic_code = ".Auth::user()->clinic."
                            AND queue_status IN ('F','D')");
                }else{
                    $query = DB::select("SELECT COUNT(*) as total FROM queues
                            WHERE DATE(created_at) BETWEEN '" . $starting . "' AND '" . $ending . "'
                            AND clinic_code = ".Auth::user()->clinic."
                            AND queue_status = '".$category."'");
                }
            }else{
                $query = DB::select("SELECT COUNT(*) as total FROM queues
                            WHERE DATE(created_at) BETWEEN '" . $starting . "' AND '" . $ending . "'
                            AND clinic_code = ".Auth::user()->clinic."
                            AND queue_status = '".$category."'");
            }

        }
        if (!empty($query)){
            return $query[0]->total;
        }else{
            return 0;
        }
    }







}