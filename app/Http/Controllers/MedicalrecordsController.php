<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Consultation;
use App\Patient;
use App\MedicalCertificate;
use Validator;
use DB;
use Auth;
use PDF;
use Carbon\Carbon;
use Session;

/**
* 
*/
class MedicalrecordsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->stats != "ALL") {
            $patients = DB::select("SELECT  b.last_name, b.first_name, b.middle_name, a.patient_id, b.hospital_no,
                                            (SELECT COUNT(*) FROM consultations s WHERE s.patients_id = a.patient_id) as records,
                                            -- ('0') as records,
                                            d.id as serviceid, d.sub_category,
                                            a.created_at,
                                            CONCAT(e.last_name,', ',e.first_name,' ',LEFT(e.middle_name, 1),'.') as users,
                                            a.id,
                                            f.name,
                                            a.status
                                    FROM medical_certificates a
                                    LEFT JOIN patients b ON a.patient_id = b.id
                                    LEFT JOIN cashincomesubcategory d ON a.cashincomesubcategory_id = d.id
                                    LEFT JOIN users e ON a.user_id = e.id
                                    LEFT JOIN clinics f ON e.clinic = f.id
                                    WHERE a.status = ?
                                    GROUP BY a.patient_id
                                    ORDER BY a.id DESC
                                    ", [$request->stats]);
        }else{
            $patients = DB::select("SELECT  b.last_name, b.first_name, b.middle_name, a.patient_id, b.hospital_no,
                                            (SELECT COUNT(*) FROM consultations s WHERE s.patients_id = a.patient_id) as records,
                                            -- ('0') as records,
                                            d.id as serviceid, d.sub_category,
                                            a.created_at,
                                            CONCAT(e.last_name,', ',e.first_name,' ',LEFT(e.middle_name, 1),'.') as users,
                                            a.id,
                                            f.name,
                                            a.status
                                    FROM medical_certificates a
                                    LEFT JOIN patients b ON a.patient_id = b.id
                                    LEFT JOIN cashincomesubcategory d ON a.cashincomesubcategory_id = d.id
                                    LEFT JOIN users e ON a.user_id = e.id
                                    LEFT JOIN clinics f ON e.clinic = f.id
                                    GROUP BY a.patient_id
                                    ORDER BY a.id DESC
                                    ");  
        }
        $tab = DB::select("SELECT * FROM medical_certificates");
       
        return view('medicalrecords.overview', compact('patients', 'tab', 'request'));
    }
    public function getpatientinfoandmssbyid($id)
    {
        $patient = DB::select("SELECT *, DATE(a.created_at) as created
                                FROM patients a 
                                LEFT JOIN mssclassification b ON a.id = b.patients_id
                                LEFT JOIN mss c ON b.mss_id = c.id
                                WHERE a.id = ?
                                ", [$id]);
        echo json_encode($patient[0]);
        return;
    }
    public function getpatientconsultationbyid($id)
    {
        $consultation = DB::select("SELECT a.id,
                                            b.last_name,b.first_name,b.middle_name,
                                            d.name,
                                            CONCAT(c.last_name,', ',c.first_name,' ',LEFT(c.middle_name, 1),'.') as users,
                                            DATE(a.created_at) as created
                                    FROM consultations a
                                    LEFT JOIN patients b ON a.patients_id = b.id
                                    LEFT JOIN users c ON a.users_id = c.id
                                    LEFT JOIN clinics d ON c.clinic = d.id
                                    WHERE a.patients_id = ?
                            ", [$id]);
        echo json_encode($consultation);
        return;
    }
    public function viewpatientconsultation($id)
    {
        $consultation = Consultation::find($id);
        dd($consultation);
    }
    public function addpatient(Request $request)
    {
        // dd($request);
       $patient = DB::select("SELECT *, DATE(a.created_at) as created
                                FROM patients a 
                                LEFT JOIN mssclassification b ON a.id = b.patients_id
                                LEFT JOIN mss c ON b.mss_id = c.id
                                WHERE a.hospital_no = ?
                                OR a.barcode = ?
                                ", [$request->credentials, $request->credentials]);
       if ($patient) {
            $pt = $patient[0];
            // dd($pt);
            return view('medicalrecords.addrequest', compact('pt'));
       }else{
            return redirect()->back()->with('toaster', array('error', 'Patient not found.'));
       }
    }
    public function addrequest(Request $request)
    {
        foreach ($request->ptrequest as $key => $u) {
            $mc = new MedicalCertificate();
            $mc->patient_id = $request->ptid;
            $mc->user_id = Auth::user()->id;
            $mc->cashincomesubcategory_id = $request->ptrequest[$key];
            if ($request->ptrequest[$key] != "") {
                $mc->save();
            }

        }
        dd($request);
    }
}