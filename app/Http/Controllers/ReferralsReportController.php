<?php

namespace App\Http\Controllers;

use App\Clinic;
use Illuminate\Http\Request;
use App\Refferal;
use Illuminate\Support\Facades\Auth;
use DB;

class ReferralsReportController extends Controller
{
    public function refferalsReport($type= false, $starting = false, $ending = false)
    {
        if($type){
            if ($type == 'out') {
                $refferals = Refferal::where([
                       ['from_clinic', Auth::user()->clinic],
                    ])
                       ->whereBetween(DB::raw('DATE(refferals.created_at)'), [''.$starting.'', ''.$ending.''])
                       ->leftJoin('clinics', 'clinics.id', 'refferals.to_clinic')
                       ->select(DB::raw('COUNT(refferals.to_clinic) AS total'), 'clinics.name')
                       ->groupBy('refferals.to_clinic')
                       ->orderBy('total', 'desc')
                       ->get();
            }else{
                $refferals = Refferal::where([
                            ['to_clinic', Auth::user()->clinic],
                            ['status', 'F'],
                        ])
                            ->whereBetween(DB::raw('DATE(refferals.created_at)'), [''.$starting.'', ''.$ending.''])
                            ->leftJoin('clinics', 'clinics.id', 'refferals.from_clinic')
                            ->select(DB::raw('COUNT(refferals.to_clinic) AS total'), 'clinics.name')
                            ->groupBy('refferals.from_clinic')
                            ->orderBy('total', 'desc')
                            ->get();
            }
            
        }else{
            $refferals = null;
        }
        $clinicName = Clinic::find(Auth::user()->clinic);
        return view('receptions.reports.referrals', compact('refferals', 'type', 'starting', 'ending', 'clinicName'));
    }


    public function store(Request $request)
    {
        return redirect("refferalsReport/$request->type/$request->starting/$request->ending");
    }

}