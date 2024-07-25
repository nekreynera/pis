<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class LaboratoryRequest extends Model
{
    protected $table = "laboratory_requests";

    protected $fillable = [
        'item_id', 
        'qty', 
        'laboratory_request_group_id',
        'status',
        'lis_result_link'
    ];
    public $timestamps = false;

    static function gettransaction($id){
      $data = DB::select("SELECT a.id as request_id,
                        a.item_id,
                        c.name,
                        a.qty,
                        (CASE 
                          WHEN e.id 
                          THEN e.price 
                          ELSE c.price
                        END) as price,
                        e.discount,
                        ee.discount as mss_addjusted_discount,
                        a.status as pr_status,
                        (CASE
                          WHEN pg.id 
                          THEN CONCAT(k.label,' - ',k.description)
                          WHEN e.void = 0 AND e.dbnp IS NULL 
                          THEN (CASE 
                                  WHEN j.discount = 1 
                                  THEN CONCAT(j.label,' - ',j.description) 
                                  ELSE 'Paid' 
                                  END)
                          WHEN e.dbnp = 1 
                          THEN 'Unpaid'
                          ELSE 'Unpaid'
                        END) as pa_status,
                        CONCAT(f.last_name,', ',f.first_name) as request_by,
                        b.created_at as request_created,
                        CONCAT(g.last_name,', ',g.first_name) as paid_by,
                        e.or_no,
                        e.created_at as payment_created,
                        CONCAT(i.last_name,', ',i.first_name) as done_by,
                        h.created_at as done_created,
                        e.mss_id,
                        CONCAT(j.label,' - ',j.description) as mss_name,
                        b.user_id,
                        j.discount as mss_discount,
                        SUM(DISTINCT pgg.granted_amount) as granted_amount
              FROM laboratory_requests a 
              LEFT JOIN laboratory_request_groups b ON a.laboratory_request_group_id = b.id
              LEFT JOIN laboratory_sub_list c ON a.item_id = c.id
              LEFT JOIN laboratory_sub d ON c.laboratory_sub_id = d.id
              LEFT JOIN laboratory_payment e ON a.id = e.laboratory_request_id AND e.void = 0 AND (e.mss_charge IS NULL OR e.mss_charge = 2)
              LEFT JOIN laboratory_payment ee ON a.id = ee.laboratory_request_id AND ee.void = 0
              LEFT JOIN users f ON b.user_id = f.id
              LEFT JOIN users g ON e.user_id = g.id
              LEFT JOIN laboratory_done h ON a.id = h.laboratory_request_id
              LEFT JOIN users i ON h.user_id = i.id
              LEFT JOIN mss j ON e.mss_id = j.id
              LEFT JOIN payment_guarantor pg ON e.id = pg.payment_id AND pg.type = 1
              LEFT JOIN payment_guarantor pgg ON ee.id = pgg.payment_id AND pgg.type = 1
              LEFT JOIN mss k ON pg.guarantor_id = k.id
              WHERE b.patient_id = ?
              AND a.status != 'Removed'
              GROUP BY a.id
              ORDER BY a.id DESC
                  ", [$id]);
      return $data;
    }
    static function gettransactionwitholdtable($id){
		$data = DB::select("SELECT 
                                        e.name as sub_category,
                                        a.qty,
                                        (CASE 
                                         	WHEN f.id 
                                         	THEN (CASE 
                                                  	WHEN a.status = 'Done' 
                                                  	THEN a.status 
                                                  	ELSE 'Paid' 
                                                  END) 
                                         	ELSE a.status 
                                         END) as status,
                                        b.created_at as created_at
                                FROM laboratory_requests a
                                LEFT JOIN laboratory_request_groups b ON a.laboratory_request_group_id = b.id
                                LEFT JOIN laboratory_sub_list e ON a.item_id = e.id
                                LEFT JOIN laboratory_payment f ON a.id = f.laboratory_request_id AND f.void = 0
                                WHERE b.patient_id = ?
                                AND a.status != 'Removed'
                                UNION 
                                SELECT k.sub_category,
                                        (CASE 
                                        	WHEN h.id
                                        	THEN h.qty
                                        	ELSE g.qty
                                        END) as qty,
                                        (CASE 
                                         	WHEN h.id 
                                         	THEN (CASE 
                                                  	WHEN h.get = 'Y' 
                                                  	THEN 'Done' 
                                                  	ELSE 'Paid' 
                                                  END) 
                                         	ELSE 'Pending' 
                                         END) as status,
                                        g.created_at as created_at
                                FROM ancillaryrequist g 
                                LEFT JOIN cashincome h ON g.id = h.ancillaryrequist_id AND h.void = '0'
                                LEFT JOIN cashincomesubcategory k ON g.cashincomesubcategory_id = k.id
                                LEFT JOIN cashincomecategory l ON k.cashincomecategory_id = l.id
                                WHERE g.patients_id = ?
                                AND l.id IN(10)
                                ORDER BY created_at DESC
								", [$id, $id]);
		return $data;
    }
}
