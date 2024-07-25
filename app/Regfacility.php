<?php

namespace App;
use DB;

use Illuminate\Database\Eloquent\Model;

class Regfacility extends Model
{
    protected $table = "regfacility";

    protected $fillable = [
        'municipality', 'hospital', 'address', 'level', 'abc', 'contact_person', 'number', 'email', 'district'
    ];
    public $timestamps = false;

    public function getColumn(){
      return $this->fillable;
    }
    static function countpermonth($id, $starting_month, $ending_month, $years){
    	$data = DB::select("SELECT COUNT(*) as results, MONTH(a.created_at) as yearmonth
                            FROM regreferral a 
                            WHERE a.facility = ?
                            AND MONTH(a.created_at) BETWEEN ? AND ?
                            AND YEAR(a.created_at) = ?
                            GROUP BY MONTH(a.created_at)
    						", [$id, $starting_month, $ending_month, $years]);
    	return $data;
    }
    static function countperday($id, $month, $years)
    {
        $data = DB::select("SELECT COUNT(*) as results, DATE(a.created_at) as dates
                            FROM regreferral a 
                            WHERE a.facility = ?
                            AND MONTH(a.created_at) = ?
                            AND YEAR(a.created_at) = ?
                            GROUP BY DATE(a.created_at)
                            ", [$id, $month, $years]);
        return $data;
    }
    static function countpercase($diagid, $facility, $starting_month, $ending_month, $years)
    {
        $data = DB::select("SELECT MONTH(created_at) as yearmonth, count(*) as results
                            FROM regreferral a 
                            LEFT JOIN reginitialdiag b ON a.id = b.regreferral_id
                            LEFT JOIN regdiagnosis c ON b.regdiagonsis_id = c.id
                            WHERE c.id = ?
                            AND a.facility = ?
                            AND MONTH(created_at) BETWEEN ? AND ?
                            AND YEAR(created_at) = ?
                            AND a.id IN(SELECT regreferral_id FROM reginitialdiag)
                            GROUP BY MONTH(created_at)
                            ", [$diagid, $facility, $starting_month, $ending_month, $years]);
        return $data;
    }
    static function countpercaseday($diagid, $facility, $month, $years)
    {
        $data = DB::select("SELECT DATE(created_at) as days, count(*) as results
                               FROM regreferral a 
                               LEFT JOIN reginitialdiag b ON a.id = b.regreferral_id
                               LEFT JOIN regdiagnosis c ON b.regdiagonsis_id = c.id
                               WHERE c.id = ?
                               AND a.facility = ?
                               AND MONTH(created_at) = ?
                               AND YEAR(created_at) = ?
                               AND a.id IN(SELECT regreferral_id FROM reginitialdiag)
                               GROUP BY DATE(created_at)
                               ", [$diagid, $facility, $month, $years]);
        return $data;
    }
}
