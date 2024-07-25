<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Contracts\Support\JsonableInterface;
use App\Patient;
use App\Clinic;
use App\User;
use App\Laboratory;
use App\AncillaryItem;
use DB;
use Session;
use Carbon;
use Validator;
use Auth;

class LaboratoryController extends Controller
{
	public function xray_list($id = false)
	{
		$xrays = Laboratory::where('patients_id', '=', $id)
							->where('ancillary_items.clinic_code', '=', 1034)
		                                ->leftJoin('patients as pt', 'pt.id', '=', 'laboratories.patients_id')
		                                ->leftJoin('users as us', 'us.id', '=', 'laboratories.users_id')
		                                ->leftJoin('clinics', 'clinics.id', '=', 'us.clinic')
		                                ->leftJoin('ancillary_items', 'ancillary_items.id', '=', 'laboratories.item_id')
		                                ->groupBy('laboratories.users_id', 'laboratories.modifier', DB::raw("DATE(laboratories.created_at)"))
		                                ->orderBy('laboratories.created_at', 'DESC')
		                                ->select('laboratories.*', 'clinics.name as clinic', DB::raw("CONCAT(pt.last_name,', ',pt.first_name,' ',CASE WHEN pt.suffix IS NOT NULL THEN pt.suffix ELSE '' END,' ',CASE WHEN pt.middle_name IS NOT NULL THEN LEFT(pt.middle_name, 1) ELSE '' END) as name"), DB::raw("CONCAT(us.first_name,' ', CASE WHEN us.middle_name IS NOT NULL THEN LEFT(us.middle_name, 1) ELSE '' END ,' ',us.last_name) as doctor"))
		                                ->get();
		return view('doctors.xray_list', compact('xrays'));
	}


	function xrayShow($id=false)
	{
		$xray = Laboratory::find($id);
		$xrays = Laboratory::where('modifier', '=', $xray->modifier)
							->where('ancillary_items.clinic_code', '=', 1034)
							->whereDate('laboratories.created_at', '=', Carbon::parse($xray->created_at)->toDateString())
							->select('laboratories.id', 'ancillary_items.item_description', 'laboratories.qty', 'ancillary_items.price', 'laboratories.created_at')
							->leftJoin('ancillary_items', 'ancillary_items.id', '=', 'laboratories.item_id')
							->get();
		$patient = Patient::find($xray->patients_id);
		return view('doctors.xrayDetails', compact('xray', 'xrays', 'patient'));
	}

	public function xrayEdit($id=false)
	{
		$labs = AncillaryItem::where('clinic_code', '=', 1034)->get();
		$laboratory = Laboratory::find($id);
		$laboratories = Laboratory::where('modifier', '=', $xray->modifier)
							->where('ancillary_items.clinic_code', '=', 1034)
							->whereDate('laboratories.created_at', '=', Carbon::parse($xray->created_at)->toDateString())
							->select('laboratories.id', 'ancillary_items.item_description', 'laboratories.qty', 'ancillary_items.price', 'laboratories.created_at')
							->leftJoin('ancillary_items', 'ancillary_items.id', '=', 'laboratories.item_id')
							->get();
		$clinic_code = 1034;
		$patient = Patient::find($xray->patients_id);
		return view('doctors.laboratoriesEdit', compact('laboratory', 'laboratories', 'labs', 'patient', 'clinic_code'));
	}

}
