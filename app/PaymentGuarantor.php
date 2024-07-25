<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB; 
class PaymentGuarantor extends Model
{
    protected $table = "payment_guarantor";

    protected $fillable = [
        'user_id', 
        'type', 
        'payment_id',
        'guarantor_id', 
        'granted_amount',
    ];
    public static function availedpatient($request)
    {
    	$data =  DB::select("SELECT 
                                a.id as id,
                                c.last_name, c.first_name, c.middle_name,
                                e.category as clinic_ancillary,
                                GROUP_CONCAT(d.sub_category) as services,
                                SUM(a.granted_amount) as total_amount
                            FROM payment_guarantor a 
                            LEFT JOIN cashincome b ON a.payment_id = b.id
                            LEFT JOIN patients c ON b.patients_id = c.id
                            LEFT JOIN cashincomesubcategory d ON b.category_id = d.id
                            LEFT JOIN cashincomecategory e ON d.cashincomecategory_id = e.id
                            WHERE a.guarantor_id = ?
                            AND b.mss_charge = 2
                            AND a.type = 0
                            AND DATE(a.created_at) BETWEEN ? AND ?
                            GROUP BY e.id
                            UNION
                            SELECT 
                                f.id as id,
                                j.last_name, j.first_name, j.middle_name,
                                ('Laboratory') as clinic_ancillary,
                                GROUP_CONCAT(k.name) as services,
                                SUM(f.granted_amount) as total_amount
                            FROM payment_guarantor f
                            LEFT JOIN laboratory_payment g ON f.payment_id = g.id
                            LEFT JOIN laboratory_requests h ON g.laboratory_request_id = h.id
                            LEFT JOIN laboratory_request_groups i ON h.laboratory_request_group_id = i.id
                            LEFT JOIN patients j ON i.patient_id = j.id
                            LEFT JOIN laboratory_sub_list k ON h.item_id = k.id
                            WHERE f.guarantor_id = ? 
                            AND g.mss_charge = 2
                            AND f.type = 1
                             AND DATE(f.created_at) BETWEEN ? AND ?
                            GROUP BY h.id
                            ORDER BY id ASC", [
                            					$request->mss_id,
                                                $request->start_date,
                                                $request->end_date,
                            					$request->mss_id,
                                                $request->start_date,
                                                $request->end_date
                                            ]);
    	$sponsors = DB::select("SELECT 
                                    b.label, b.description,
                                    SUM(a.granted_amount) as total_amount,
                                    c.patients_id as patient_id
                                FROM payment_guarantor a 
                                LEFT JOIN mss b ON a.guarantor_id = b.id
                                LEFT JOIN cashincome c ON a.payment_id = c.id
                                WHERE a.type = 0
                                AND c.mss_charge = 2
                                AND a.guarantor_id = ?
                                AND DATE(a.created_at) BETWEEN ? AND ?
                                GROUP BY c.patients_id
                                UNION
                                SELECT 
                                    h.label, h.description,
                                    SUM(D.granted_amount) as total_amount,
                                    g.patient_id as patient_id
                                FROM payment_guarantor d 
                                LEFT JOIN laboratory_payment e ON d.payment_id = e.id
                                LEFT JOIN laboratory_requests f ON e.laboratory_request_id = f.id
                                LEFT JOIN laboratory_request_groups g ON f.laboratory_request_group_id = g.id
                                LEFT JOIN mss h ON d.guarantor_id = h.id
                                WHERE d.type = 1
                                AND e.mss_charge = 2
                                AND d.guarantor_id = ?
                                AND DATE(d.created_at) BETWEEN ? AND ?
                                GROUP BY g.patient_id
    						", [
    							$request->mss_id,
    							$request->start_date,
                                $request->end_date,
                                $request->mss_id,
                                $request->start_date,
                                $request->end_date
    							]);
    	return ['data' => $data, 'sponsors' => $sponsors];
    }
}
