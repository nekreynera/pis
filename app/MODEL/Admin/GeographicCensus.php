<?php

namespace App\MODEL\Admin;

use Illuminate\Database\Eloquent\Model;
use App\Assignation;

class GeographicCensus extends Model
{
	public static function checkifnewvisit($request, $patients_id, $date_consolted)
    {
    	$data = Assignation::where('patients_id', '=', $patients_id)
                                    ->where('clinic_code', '=', $request->clinic_id)
                                    ->whereDate('created_at', '<', $date_consolted)
                                    ->first();
        return $data;
    }
}
