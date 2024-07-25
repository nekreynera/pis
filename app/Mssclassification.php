<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Mssclassification extends Model
{
	protected $table = "mssclassification";

    protected $fillable = [
        'patients_id', 'users_id', 'mss_id', 'interviewed', 'relpatient', 'mswd','referral','gender','civil_statuss',
        'living_arrangement','education','occupation','category','fourpis','sectorial',
        'household','duration','philhealth','membership','validity','created_at'
    ];

    static function getPaitentinfoandclassification($id){
    	$data = DB::table('patients')
                ->leftJoin('mssclassification', function($join)
                {
                    $join->on('mssclassification.patients_id', 'patients.id')
                        ->on('mssclassification.validity', '>=', DB::raw('CURDATE()'));
                })
                ->leftJoin('mss', 'mss.id', '=', 'mssclassification.mss_id')
                ->select('*', 'patients.created_at as regestered')
                ->where('patients.id', '=', $id)
                ->first();
    	return $data;
    }
}
