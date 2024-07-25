<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon;
use DB;

class LaboratoryPayment extends Model
{
    protected $table = "laboratory_payment";

    protected $fillable = [
        'user_id', 
        'laboratory_request_id', 
        'mss_id',
        'price',
        'discount',
        'cash',
        'or_no',
        'void',
        'dbnp', /*done but not paid*/
    ];

    static function getallmssclassifiedinC()
    {
        $data = DB::select("SELECT CONCAT(g.label,' ',g.description,' - ',a.or_no) as classification,  
                                    CONCAT(d.last_name,', ',d.first_name,' ',d.middle_name) as patient,
                                    YEAR(CURRENT_TIMESTAMP) - YEAR(d.birthday) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(d.birthday, 5)) as age,
                                    CONCAT(e.citymunDesc,', ',f.brgyDesc) as address,
                                    GROUP_CONCAT(h.name SEPARATOR ', ') as name,
                                    SUM((a.price * b.qty)) as amount,
                                    SUM((a.price * b.qty) - a.discount) as amount_paid,
                                    SUM(a.discount) as amount_discount
                            FROM laboratory_payment a 
                            LEFT JOIN laboratory_requests b ON a.laboratory_request_id = b.id
                            LEFT JOIN laboratory_request_groups c ON b.laboratory_request_group_id = c.id
                            LEFT JOIN patients d ON c.patient_id = d.id
                            LEFT JOIN refcitymun e ON d.city_municipality = e.citymunCode
                            LEFT JOIN refbrgy f ON d.brgy = f.id
                            LEFT JOIN mss g ON a.mss_id = g.id
                            LEFT JOIN laboratory_sub_list h ON b.item_id = h.id
                            WHERE a.mss_id IN(1,2,3,4,5,6,7,8,14,15,16)
                            AND a.void = 0
                            AND DATE(a.created_at) BETWEEN
                                ? AND ?
                            GROUP BY a.or_no
                            ORDER BY a.created_at ASC
                            ", [
                                Carbon::parse($_GET['from'])->format('Y-m-d'),
                                Carbon::parse($_GET['to'])->format('Y-m-d')
                                ]);
        return collect($data);
    }
    static function getallmssclassifiedinD()
    {
        $data = DB::select("SELECT CONCAT(g.label,' ',g.description) as classification,  
                                    CONCAT(d.last_name,', ',d.first_name,' ',d.middle_name) as patient,
                                    YEAR(CURRENT_TIMESTAMP) - YEAR(d.birthday) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(d.birthday, 5)) as age,
                                    CONCAT(e.citymunDesc,', ',f.brgyDesc) as address,
                                    GROUP_CONCAT(h.name SEPARATOR ', ') as name,
                                    SUM((a.price * b.qty)) as amount,
                                    SUM((a.price * b.qty) - a.discount) as amount_paid,
                                    SUM(a.discount) as amount_discount
                            FROM laboratory_payment a 
                            LEFT JOIN laboratory_requests b ON a.laboratory_request_id = b.id
                            LEFT JOIN laboratory_request_groups c ON b.laboratory_request_group_id = c.id
                            LEFT JOIN patients d ON c.patient_id = d.id
                            LEFT JOIN refcitymun e ON d.city_municipality = e.citymunCode
                            LEFT JOIN refbrgy f ON d.brgy = f.id
                            LEFT JOIN mss g ON a.mss_id = g.id
                            LEFT JOIN laboratory_sub_list h ON b.item_id = h.id
                            WHERE a.mss_id IN(9,10,11,12,13)
                            AND a.void = 0
                            AND DATE(a.created_at) BETWEEN
                                ? AND ?
                            GROUP BY c.patient_id
                            ORDER BY a.created_at ASC
                            ", [
                                Carbon::parse($_GET['from'])->format('Y-m-d'),
                                Carbon::parse($_GET['to'])->format('Y-m-d')
                                ]);
        return collect($data);
    }
}
