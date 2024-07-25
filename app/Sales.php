<?php

namespace App;
use DB;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
	protected $table = "sales";

    protected $fillable = [
        'pharmanagerequest_id', 'users_id', 'status', 'mss_id', 'price', 'or_no', 'void', 'cash'
    ];
    static function chargetofund($exid, $start_month, $end_month, $year)
    {	
    	$data = DB::select("SELECT COUNT(*) as result, 
									MONTH(created_at) as yearmonth 
							FROM sales  
							WHERE sales.mss_id IN($exid)
							AND sales.void = '0'
							AND sales.status = 'Y'
							AND MONTH(sales.created_at) BETWEEN ? AND ?
							AND YEAR(sales.created_at) = ?
							AND sales.price > 0
							GROUP BY MONTH(sales.created_at)
							", [$start_month, $end_month, $year]);
    	return $data;
    }
    static function dispensedmeds($start_month, $year)
    {
    	$data = DB::select("SELECT c.item_id, d.item_description, d.unitofmeasure, SUM(b.qty) as result
							FROM sales a
							LEFT JOIN pharmanagerequest b ON a.pharmanagerequest_id = b.id
							LEFT JOIN requisition c ON b.requisition_id = c.id
							LEFT JOIN ancillary_items d ON c.item_id = d.id
							WHERE a.void = '0'
							AND a.status = 'Y'
							AND MONTH(a.created_at) = ?
							AND YEAR(a.created_at) = ?
							GROUP BY c.item_id
							ORDER BY result DESC
							", [$start_month, $year]);
    	return $data;
    }
  //   static function demographic($explaceid, $start_month, $end_month, $year)
  //   {
		// $data = DB::select("SELECT c.item_id,f.brand,f.item_description,f.unitofmeasure, COUNT(*) as result, SUM(b.qty) as overallqty 
		// 					FROM sales a 
		// 					LEFT JOIN pharmanagerequest b ON a.pharmanagerequest_id = b.id
		// 					LEFT JOIN requisition c ON b.requisition_id = c.id
		// 					LEFT JOIN patients d ON c.patients_id = d.id
		// 					LEFT JOIN refcitymun e ON d.city_municipality = e.citymunCode
		// 					LEFT JOIN ancillary_items f ON c.item_id = f.id
		// 					WHERE e.id IN($explaceid)
		// 					AND MONTH(a.created_at) BETWEEN ? AND ?
		// 					AND YEAR(a.created_at) = ?
		// 					AND a.void = '0'
		// 					AND a.status = 'Y'
		// 					GROUP BY c.item_id
		// 					ORDER BY overallqty DESC
		// 					LIMIT 1
		// 					", [$start_month, $end_month, $year]);
		// return $data;
  //   }
    static function demographicpermonth($explaceid, $months, $year)
    {
    	$data = DB::select("SELECT COUNT(*) as result, SUM(b.qty) as overallqty, MONTH(a.created_at) as months, f.brand,f.item_description,f.unitofmeasure
							FROM sales a 
							LEFT JOIN pharmanagerequest b ON a.pharmanagerequest_id = b.id
							LEFT JOIN requisition c ON b.requisition_id = c.id
							LEFT JOIN patients d ON c.patients_id = d.id
							LEFT JOIN refcitymun e ON d.city_municipality = e.citymunCode
							LEFT JOIN ancillary_items f ON c.item_id = f.id
							WHERE e.id IN($explaceid)
							AND MONTH(a.created_at) = ?
							AND YEAR(a.created_at) = ?
							AND a.void = '0'
							AND a.status = 'Y'
							GROUP BY c.item_id
							ORDER BY overallqty DESC
							LIMIT 1
							", [$months, $year]);

		return $data;
    }
    static function outsideroedemographicpermonth($months, $year)
    {
    	$data = DB::select("SELECT COUNT(*) as result, SUM(b.qty) as overallqty, MONTH(a.created_at) as months, f.brand,f.item_description,f.unitofmeasure
							FROM sales a 
							LEFT JOIN pharmanagerequest b ON a.pharmanagerequest_id = b.id
							LEFT JOIN requisition c ON b.requisition_id = c.id
							LEFT JOIN patients d ON c.patients_id = d.id
							LEFT JOIN refcitymun e ON d.city_municipality = e.citymunCode
							LEFT JOIN ancillary_items f ON c.item_id = f.id
							WHERE e.regDesc NOT IN(08)
							AND MONTH(a.created_at) = ?
							AND YEAR(a.created_at) = ?
							AND a.void = '0'
							AND a.status = 'Y'
							GROUP BY c.item_id
							ORDER BY overallqty DESC
							LIMIT 1
							", [$months, $year]);
		return $data;
    }

}
