<?php

namespace App\Http\Controllers\REGISTER;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Patient;
use App\User;
use App\Clinic;
use App\LaboratoryRequest;
use Response;
use Validator;
use Carbon\Carbon;
use DB;
use Auth;

class MedicalRecordController extends Controller
{
	public function medical($id)
	{
	    $patient = Patient::find($id);

	    $ancillary = DB::select("SELECT COUNT(*) as result,
                                    x.category_id,
                                    c.id
	                            FROM(SELECT patients_id, 
                                     		cashincomesubcategory_id as category_id,
                                     		id
                                     FROM ancillaryrequist
                                     WHERE id NOT IN(SELECT ancillaryrequist_id 
                                                                      FROM cashincome 
                                                                      WHERE patients_id = ?)
                                     UNION
                                     SELECT patients_id,
                                     		category_id,
                                     		id
                                     FROM cashincome
                                	) x
	                            LEFT JOIN cashincomesubcategory b ON x.category_id = b.id
	                            LEFT JOIN cashincomecategory c ON b.cashincomecategory_id = c.id
	                            WHERE x.patients_id = ?
                                GROUP BY c.id
	                            ", [$id, $id]);

	    $appoinment = DB::select("SELECT 
	                                X.result,
	                                X.patients_id,
	                                X.tabl
	                            FROM (
	                                    SELECT 
	                                        COUNT(*) as result, 
	                                        patients_id,
	                                        ('refferals') as tabl
	                                    FROM refferals
	                                    GROUP BY patients_id
	                                    UNION
	                                    SELECT 
	                                        COUNT(*) as result, 
	                                        patients_id,
	                                        ('followup') as tabl
	                                    FROM followup
	                                    GROUP BY patients_id
	                                    ) AS X
	                            WHERE X.patients_id = ?
	                            ", [$id]);

	    $consultation = DB::select("SELECT 
	                                    x.id,
	                                    x.patient_id
	                                FROM (
	                                    SELECT 
	                                        id,
	                                        patient_id  
	                                    FROM childhood_care
	                                    UNION
	                                    SELECT 
	                                        id,
	                                        patient_id 
	                                    FROM otpc_front
	                                    UNION 
	                                    SELECT
	                                        id,
	                                        patient_id 
	                                    FROM kmc
	                                    UNION
	                                    SELECT
	                                        id,
	                                        patients_id as patient_id
	                                    FROM consultations
                                        UNION
                                        SELECT
	                                        id,
	                                        patient_id
	                                    FROM industrial_forms
	                                    ) as x 
	                                WHERE x.patient_id = ?", [$id]);
	     $laboratory = DB::select("SELECT 
                                    a.id
                                FROM laboratory_requests a 
                                LEFT JOIN laboratory_request_groups b ON a.laboratory_request_group_id = b.id
                                WHERE b.patient_id = ?
                                UNION 
                                SELECT c.id
                                FROM ancillaryrequist c
                                LEFT JOIN cashincome d ON c.id = d.ancillaryrequist_id
                                LEFT JOIN cashincomesubcategory e ON c.cashincomesubcategory_id = e.id
                                LEFT JOIN cashincomecategory f ON e.cashincomecategory_id = f.id
                                WHERE c.patients_id = ?
                                AND f.id IN(10)
                                AND d.id IS NOT NULL
                                ", [$id, $id]);
	    echo json_encode([
	    					'patient' => $patient, 
	    					'ancillary' => $ancillary, 
	    					'appoinment' => $appoinment, 
	    					'consultation' => $consultation, 
	    					'laboratory' => $laboratory, 
	    				]);
	    return;
	}


	public function consultation($id)
	{
		$consultation = DB::select("SELECT 
	                                    x.created_at,
                                        b.last_name, b.first_name, b.middle_name,
                                        c.name as clinic,
                                        d.description as role
	                                FROM (
	                                    SELECT 
	                                        user_id, 
	                                        created_at,
                                        	patient_id
	                                    FROM childhood_care
	                                    UNION
	                                    SELECT 
	                                        user_id, 
	                                        created_at,
                                        	patient_id
	                                    FROM otpc_front
	                                    UNION 
	                                    SELECT
	                                        user_id,
	                                        created_at,
                                        	patient_id
	                                    FROM kmc
	                                    UNION
	                                    SELECT
	                                        users_id as user_id,
	                                        created_at,
                                        	patients_id as patient_id
	                                    FROM consultations
	                                    UNION
                                        SELECT
	                                        user_id,
	                                        created_at,
	                                        patient_id
	                                    FROM industrial_forms
	                                    ) as x 
                                    LEFT JOIN users b ON x.user_id = b.id
                                    LEFT JOIN clinics c ON b.clinic = c.id
                                    LEFT JOIN roles d ON b.role = d.id
	                                WHERE x.patient_id = ?
	                                ORDER BY created_at DESC", [$id]);
		echo json_encode($consultation);
		return;
	}
	public function ancillary($patient, $category)
	{
		if ($category == 10) {
			$ancillary = LaboratoryRequest::gettransactionwitholdtable($patient);
		}else{
			$ancillary = DB::select("SELECT b.sub_category,
											x.qty,
									        x.created_at,
									        x.status
		                            FROM(SELECT patients_id, 
	                                     		cashincomesubcategory_id as category_id,
	                                     		id,
	                                     		qty,
	                                     		created_at,
	                                     		('Pending') as status 
	                                     FROM ancillaryrequist
	                                     WHERE id NOT IN(SELECT ancillaryrequist_id 
	                                                                      FROM cashincome 
	                                                                      WHERE patients_id = ?
	                                                    				  AND void = '0')
	                                     UNION
	                                     SELECT patients_id,
	                                     		category_id,
	                                     		id,
	                                     		qty,
	                                     		created_at,
	                                     		(CASE 
	                                             	WHEN void = '0'
	                                             	THEN
	                                                    (CASE 
	                                                        WHEN get = 'Y' 
	                                                        THEN 'Done' 
	                                                        ELSE 'Paid' 
	                                                     END)
	                                             	ELSE 'Pending'
	                                             END) as status
	                                     FROM cashincome
	                                	) x
		                            LEFT JOIN cashincomesubcategory b ON x.category_id = b.id
		                            LEFT JOIN cashincomecategory c ON b.cashincomecategory_id = c.id
		                            WHERE x.patients_id = ?
	                                AND c.id IN($category)
									", [$patient, $patient]);
		}
		
		echo json_encode($ancillary);
		return;
	}
	public function referral($id)
	{
		$referral = DB::select("SELECT 
									b.name as from_clinic,
								    c.name as to_clinic,
								    a.status,
								    a.created_at 
								FROM refferals a 
								LEFT JOIN clinics b ON a.from_clinic = b.id
								LEFT JOIN clinics c ON a.to_clinic = c.id
								WHERE a.patients_id = ?
								ORDER BY a.created_at DESC
								", [$id]);
		echo json_encode($referral);
		return;
	}
	public function followup($id)
	{
		$followup = DB::select("SELECT
									c.name,
								    b.last_name, b.first_name, b.middle_name,
									a.followupdate,
								    a.status,
									a.created_at 
								FROM followup a 
								LEFT JOIN users b ON a.users_id = b.id
								LEFT JOIN clinics c ON a.clinic_code = c.id
								WHERE a.patients_id = ?
								", [$id]);
		echo json_encode($followup);
		return;
	}
}



