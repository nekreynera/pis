<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Session;
use Auth;
use DB;
use Carbon;



class ReportsRadController extends Controller
{




    public function medServicesAccomplished($starting = false, $ending = false, $category = false)
    {

        if ($starting && $ending){

            $start = Carbon::instance(new \DateTime($starting))->toDateString();
            $end = Carbon::instance(new \DateTime($ending))->endOfMonth()->toDateString();


            if ($category == 'N'){
                $sign = '>';
            }elseif ($category == 'O'){
                $sign = '=';
            }



            $reports = DB::select("SELECT cc.category, cs.id as cid, cs.sub_category, an.id, an.patients_id,
                        MONTH(an.created_at) as month, COUNT(an.id) as total FROM cashincomesubcategory cs
                        LEFT JOIN cashincomecategory cc ON cc.id = cs.cashincomecategory_id
                        LEFT JOIN ancillaryrequist an ON an.cashincomesubcategory_id = cs.id 
                        AND DATE(an.created_at) BETWEEN '".$start."' AND '".$end."'
                        AND an.patients_id NOT IN (
                            
                            SELECT an.patients_id 
                            FROM cashincomesubcategory cs
                            LEFT JOIN cashincomecategory cc ON cc.id = cs.cashincomecategory_id
                            LEFT JOIN ancillaryrequist an ON an.cashincomesubcategory_id = cs.id
                            WHERE cc.clinic_id = ".Auth::user()->clinic."
                            AND an.patients_id IS NOT NULL
                            GROUP BY an.patients_id
                            HAVING COUNT(*) ".$sign." 1
                            ORDER BY cs.sub_category
                            
                        )
                        WHERE cc.clinic_id = ".Auth::user()->clinic."
                        GROUP BY cs.id, MONTH(an.created_at)  
                        ORDER BY sub_category, month");


        }else{
            $reports = null;
        }


        //dd($reports);

        return view('radiology.reports.medicalServicesAccomplished',
            compact('reports','starting', 'ending', 'category'));



    }




    public function topLeadingServices($starting = false, $ending = false, $limit = false)
    {
        if ($starting && $ending) {

            $start = Carbon::instance(new \DateTime($starting))->toDateString();
            $end = Carbon::instance(new \DateTime($ending))->endOfMonth()->toDateString();

            //dd(Carbon::parse($start)->month, Carbon::parse($end)->month);

            $reports = DB::select("SELECT COUNT(cs.id) as total, cs.id, cs.sub_category
                                    FROM ancillaryrequist an
                                    LEFT JOIN cashincomesubcategory cs ON cs.id = an.cashincomesubcategory_id
                                    LEFT JOIN cashincomecategory cc ON cc.id = cs.cashincomecategory_id
                                    WHERE cc.clinic_id = ".Auth::user()->clinic."
                                    AND MONTH(an.created_at) BETWEEN ".Carbon::parse($start)->month." AND ".Carbon::parse($end)->month."
                                    GROUP BY cs.id
                                    ORDER BY total DESC LIMIT ".$limit." ");

        } else {
            $reports = null;
            $start = null;
            $end = null;
        }


        return view('receptions.reports.topLeading',
            compact('reports','starting', 'ending', 'limit', 'start', 'end'));
    }



    public function searchTopServices(Request $request)
    {
        $this->validate($request, [
            'starting' => 'required|date',
            'ending' => 'required|date|after_or_equal:'.$request->starting.'',
        ]);

        if(Carbon::parse($request->starting)->year != Carbon::parse($request->ending)->year){
            return redirect()->back()->with('toaster', array('error', 'Query must be in the same year.'));
        }else{
            return redirect("topLeadingServices/$request->starting/$request->ending/$request->limit");
        }
    }






    public function search(Request $request)
    {
        $this->validate($request, [
            'starting' => 'required|date',
            'ending' => 'required|date|after_or_equal:'.$request->starting.'',
        ]);

        if(Carbon::parse($request->starting)->year != Carbon::parse($request->ending)->year){
            return redirect()->back()->with('toaster', array('error', 'Query must be in the same year.'));
        }else{
            return redirect("medServicesAccomplished/$request->starting/$request->ending/$request->category");
        }

    }






    public function highestCases($starting = false, $ending = false)
    {
        if ($starting && $ending){
            $leyte = DB::select("SELECT refregion.regCode, refprovince.provDesc, refprovince.provCode, refcitymun.citymunCode, 
                            refcitymun.district, refcitymun.citymunDesc FROM refregion
                            LEFT JOIN refprovince ON refprovince.regCode = refregion.regCode
                            LEFT JOIN refcitymun ON refcitymun.provCode = refprovince.provCode
                            WHERE refregion.regCode = 08
                            AND refprovince.provCode = 0837
                            AND refcitymun.citymunCode IN (083702, 083715, 083713, 083703, 083701, 083747)
                            AND district IS NOT NULL
                            GROUP BY refprovince.provCode, refcitymun.district, refcitymun.citymunCode
                            ORDER BY district, citymunDesc DESC");

            $samar = DB::select("SELECT refregion.regCode, refprovince.provDesc, refprovince.provCode, refcitymun.citymunCode, 
                            refcitymun.district, refcitymun.citymunDesc FROM refregion
                            LEFT JOIN refprovince ON refprovince.regCode = refregion.regCode
                            LEFT JOIN refcitymun ON refcitymun.provCode = refprovince.provCode
                            WHERE refregion.regCode = 08
                            AND refprovince.provCode != 0837
                            AND district IS NOT NULL
                            GROUP BY refprovince.provCode, refcitymun.district");
        }else{
            $leyte = null;
            $samar = null;
        }

        //dd($leyte);

        return view('radiology.reports.highestCases', compact('starting', 'ending', 'leyte', 'samar'));
    }


    public function highestCasesSearch(Request $request)
    {
        $this->validate($request, [
            'starting' => 'required|date',
            'ending' => 'required|date|after_or_equal:'.$request->starting.'',
        ]);

        if(Carbon::parse($request->starting)->year != Carbon::parse($request->ending)->year){
            return redirect()->back()->with('toaster', array('error', 'Query must be in the same year.'));
        }else{
            return redirect("highestCases/$request->starting/$request->ending");
        }
    }




    public function weeklyCensus($dateTime = false)
    {
        $originalDate = null;
        if ($dateTime){
            $originalDate = $dateTime;
            $dateTime = Carbon::parse($dateTime)->year.'-'.Carbon::parse($dateTime)->format('m').'-'.'01';
        }
        return view('radiology.reports.weeklyCensus', compact('dateTime', 'originalDate'));
    }




    public function weeklyCensusStore(Request $request)
    {
        return redirect("weeklyCensus/$request->dateTime");
    }








}