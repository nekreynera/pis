<?php

namespace App\Http\Controllers\ADMIN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exports\ADMIN\ConsultationLogs;
use Maatwebsite\Excel\Facades\Excel;
use App\Clinic;
use App\User;
use App\MedInterns;
use DB;

class ReportController extends Controller
{
	public function consultation_logs(Request $request)
	{
    	$clinics = Clinic::where('department', '=', 'C')->get();
		$filename = $request->doctor_name;
		if ($request->export_by == 'clinic') {
			$filename = Clinic::find($request->clinic_id)->name;
		}
    	if (count($request->post()) > 0) {
    		return Excel::download(new ConsultationLogs, $filename.".xlsx");
    	}else{
    		return view('admin.reports.consultation_logs', compact('clinics'));
    	}
	}

	public function getclinicdoctors($id)
    {
    	$doctors = User::where('clinic', '=', $id)
    					->where('role', '=', 7)
    					->whereNotIn('id', function($query) {
						   $query->select('interns_id')->from('med_interns');
						})
    					->get();
    	echo json_encode($doctors);
    	return;
    }
    public function geographic_cencus(Request $request)
    {
        $patients = [];
        if (count($request->post()) > 0) {
            $patients = DB::select("SELECT a.created_at,
                                        a.patients_id,
                                        a.clinic_code,
                                        b.sex,
                                        b.birthday,
                                        c.id as refcitymun_id,
                                        c.regDesc
                                FROM assignations a
                                LEFT JOIN patients b ON a.patients_id = b.id
                                LEFT JOIN refcitymun c ON b.city_municipality = c.citymunCode
                                WHERE a.clinic_code = ?
                                AND DATE(a.created_at) BETWEEN ? AND ?
                                AND a.status = 'F'
                                ORDER BY a.patients_id ASC, a.created_at ASC
                                ", [$request->clinic_id, $request->from, $request->to]);
        }
        $clinics = Clinic::where('department', '=', 'c')->get();
        return view('OPDMS.receptions.reports.geographic_cencus', compact('request', 'patients', 'clinics'));
    }
}
