<?php

namespace App\Http\Controllers\LABORATORY;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exports\Laboratory\PatientExport;
use App\Exports\Laboratory\MssExport;
use App\Exports\Laboratory\MssDExport;
use Maatwebsite\Excel\Facades\Excel;

use App\LaboratoryQueues;
use Carbon;


class ReportController extends Controller
{
	public function laboratoryreports(Request $request)
	{
		$data = [];
		$column = [];
		$data_call = [];
		if (count($request->post()) > 0) {
			if ($request->type == '1') {
				if ($request->export == '1') {
					$data = LaboratoryQueues::export();
					$column = ['ID NO','LAST NAME', 'FIRST NAME', 'MIDDLE NAME', 'BIRTH DATE', 'GENDER', 'CIVIL STATUS', 'DATETIME REGISTERED',  'DATETIME QUEUED'];
					$data_call = ['hospital_no', 'last_name', 'first_name', 'middle_name', 'birthday', 'sex', 'civil_status', 'created_at', 'datetime_queued'];
				}elseif ($request->export == '2') {
					return Excel::download(new PatientExport(), 'Patients.xlsx');
				}
			}elseif ($request->type == '3') {
				if ($request->export == '1') {
				dd('under development');

				}elseif ($request->export == '2') {
					return Excel::download(new MssExport(), 'LABORATORYMSSCLASSC.xlsx');
				}
				
			}elseif ($request->type == '4') {
				if ($request->export == '1') {
				dd('under development');
				}elseif ($request->export == '2') {
					return Excel::download(new MssDExport(), 'LABORATORYMSSCLASSSD.xlsx');
				}
			}else{
				dd('under development');
			}
		}else{
			$request = null;
		}
			return view('OPDMS.laboratory.pages.report', compact('request', 'data', 'column', 'data_call'));


	}
    
}
