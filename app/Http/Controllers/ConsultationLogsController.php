<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Consultation;
use Auth;
use Session;
use Carbon;
use DB;

class ConsultationLogsController extends Controller
{

    public function consultationLogs($starting = false, $ending = false, $status = false)
    {
        if ($starting){
            $patients = DB::table('assignations')
                ->select('assignations.*', 'pt.birthday', 'consultations.id as pcid', 'pt.id as pid',
                    DB::raw("CONCAT(pt.last_name,', ',pt.first_name,' ',
                    CASE WHEN pt.suffix IS NOT NULL THEN pt.suffix ELSE '' END,' ',
                    CASE WHEN pt.middle_name IS NOT NULL THEN LEFT(pt.middle_name, 1) ELSE '' END) as name"))
                ->leftJoin('patients as pt', 'pt.id', '=', 'assignations.patients_id')
                ->leftJoin('consultations', 'consultations.patients_id', '=', 'pt.id')
                //->whereBetween(DB::raw("DATE(assignations.created_at)"), [$startingDate, $endingDate])
                ->whereBetween(DB::raw("DATE(assignations.created_at)"), [$starting, $ending])
                ->where('doctors_id', '=', Auth::user()->id)
                ->where('assignations.clinic_code', '=', Auth::user()->clinic)
                ->groupBy('pt.id', DB::raw("DATE(assignations.created_at)"))
                ->orderBy('assignations.created_at', 'ASC')
                ->when($status == 'H', function ($query) use ($status){
                    return $query->where('status', $status);
                })
                ->when($status == 'C', function ($query) use ($status){
                    return $query->where('status', $status);
                })
                ->when($status == 'F', function ($query) use ($status){
                    return $query->where('status', $status);
                })
                ->when($status == false, function ($query) use ($status){
                    return $query->whereIn('status', ['P','H','S','C','F']);
                })
                ->when($status == 'S', function ($query) use ($status){
                    return $query->where('status', $status);
                })
                ->when($status == 'P', function ($query) use ($status){
                    return $query->where('status', 'P');
                })
                ->get();

            $survey = DB::select("SELECT DISTINCT(SELECT COUNT(*) FROM assignations asgn WHERE doctors_id = ".Auth::user()->id."
                    AND DATE(asgn.created_at) BETWEEN '".$starting."' AND '".$ending."' AND status = 'P') AS pending,(SELECT COUNT(*) FROM assignations asgn WHERE doctors_id = ".Auth::user()->id."
                    AND DATE(asgn.created_at) BETWEEN '".$starting."' AND '".$ending."' AND status = 'F') as finished,(SELECT COUNT(*) FROM assignations asgn WHERE doctors_id = ".Auth::user()->id."
                    AND DATE(asgn.created_at) BETWEEN '".$starting."' AND '".$ending."' AND status = 'C') as nawc,(SELECT COUNT(*) FROM assignations asgn WHERE doctors_id = ".Auth::user()->id."
                    AND DATE(asgn.created_at) BETWEEN '".$starting."' AND '".$ending."' AND status = 'H') as paused,(SELECT COUNT(*) FROM assignations asgn WHERE doctors_id = ".Auth::user()->id."
                    AND DATE(asgn.created_at) BETWEEN '".$starting."' AND '".$ending."' AND status = 'S') as serving FROM assignations asgn WHERE doctors_id = ".Auth::user()->id."
                    AND DATE(asgn.created_at) BETWEEN '".$starting."' AND '".$ending."'");
        }else{
            $patients = null;
            $survey = null;
        }

        //dd($survey);

        return view('doctors.consultationLogs', compact('patients', 'starting', 'ending', 'survey', 'status'));
    }


    public function searchConsultationLogs(Request $request)
    {
        return redirect()->route('logsConsultation', ['starting' => $request->starting, 'ending' => $request->ending]);
    }

}