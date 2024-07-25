<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Session;
use DB;
use Auth;

class Requisitionwithlaboratory extends Model
{
    static function pendingrequest($patient_id){
    	$request = DB::select("SELECT a.id as request_id,
                b.id as item_id,
                ('ancillary') as item_type,
                b.status,
                b.sub_category as name,
                a.qty,
                b.price,
                a.created_at as created_at
        FROM ancillaryrequist a 
        LEFT JOIN cashincomesubcategory b ON a.cashincomesubcategory_id = b.id
        WHERE a.patients_id = ?
        AND a.id NOT IN(SELECT 
                            ancillaryrequist_id 
                        FROM cashincome
                        WHERE `patients_id` = ?
                        AND `void` = '0'
                        AND `get`= (CASE WHEN `mss_id` IN(9,10,11,12,13) THEN 'Y' ELSE `get` END))
        UNION ALL
        SELECT c.id as request_id,
                e.id as item_id,
                ('laboratory') as item_type,
                e.status,
                e.name,
                c.qty,
                e.price,
                d.created_at as created_at
        FROM laboratory_requests c
        LEFT JOIN laboratory_request_groups d ON c.laboratory_request_group_id = d.id
        LEFT JOIN laboratory_sub_list e ON c.item_id = e.id
        WHERE c.status = 'Pending'
        AND d.patient_id = ?
        AND NOT EXISTS(SELECT *
                        FROM laboratory_payment 
                        WHERE c.id = laboratory_payment.laboratory_request_id
                        AND void = 0
                        AND mss_id NOT IN(9,10,11,12,13))
        ORDER BY request_id ASC"
        ,[
            $patient_id,
            $patient_id,
            $patient_id
        ]);
        return $request;
    }
}
