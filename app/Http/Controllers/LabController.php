<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Contracts\Support\JsonableInterface;
use App\Cashincomesubcategory;
use App\Requisition;
use App\Ancillaryrequist;
use App\Cashincome;
use App\Mssclassification;
use App\LaboratoryRequest;
use DB;
use Session;
use Carbon;
use Validator;
use Auth;

class LabController extends Controller
{


    public function index()
    {

    }


    public function store(Request $request)
    {
        $mssClassification = DB::table('mssclassification')
                            ->where('patients_id', '=', Session::get('pid'))
                            ->leftJoin('mss', 'mss.id', '=', 'mssclassification.mss_id')
                            ->select('mss.id', 'discount')->first();
        $mssArray = array('9', '10','11','12','13');
        $modifier = Str::random(20);

        for ($i=0;$i<count($request->category);$i++){
            if ($request->input('category.'.$i) == 1031){
                $meds = Requisition::storeMeds($request ,$modifier, $i);/*-- save medicines ---*/
            }else{
                $labs = Ancillaryrequist::storeLabs($request ,$modifier, $i);/*-- save labs ---*/
            }
            if ($mssClassification && in_array($mssClassification->id, $mssArray) && $request->input('category.'.$i) != 1031){
                $cashincome = Cashincome::storeIncome($request ,$modifier, $i, $labs, $mssClassification);/*-- save income ---*/
            }
        }
        return redirect()->back()->with('toaster', array('success', 'Requisition successfully saved.'));
    }



    /*--- get all ultrasound services ----*/
    public function ultrasoundWatch(Request $request)
    {
        $ultrasounds = Cashincomesubcategory::where('cashincomecategory_id', '=', $request->category)
                        ->where('trash', '=', 'N')
                        ->orderBy('sub_category')
                        ->get();
        return $ultrasounds->toJson();
    }


    public function ultrasoundShow(Request $request)
    {
        $ultrasound = Ancillaryrequist::where('ancillaryrequist.patients_id', '=', $request->patient)
                                        ->where('cs.cashincomecategory_id', '=', $request->category)
                                        ->leftJoin('cashincomesubcategory as cs', 'cs.id', '=', 'ancillaryrequist.cashincomesubcategory_id')
                                        ->leftJoin('cashincome', 'cashincome.ancillaryrequist_id', '=', 'ancillaryrequist.id')
                                        ->leftJoin('users as us', 'us.id', '=', 'ancillaryrequist.users_id')
                                        ->leftJoin('clinics', 'clinics.id', '=', 'us.clinic')
                                        ->leftJoin('radiology', 'radiology.ancillaryrequest_id', 'ancillaryrequist.id')
                                        ->select('cs.sub_category', 'cs.price', 'cs.status', 'ancillaryrequist.*', 'cashincome.get', 'clinics.name', 'radiology.id as rid',
                                            DB::raw("CONCAT(CASE WHEN us.first_name IS NOT NULL THEN us.first_name ELSE '' END,' ',CASE WHEN us.middle_name IS NOT NULL THEN LEFT(us.middle_name, 1) ELSE '' END,' ',CASE WHEN us.last_name IS NOT NULL THEN us.last_name ELSE '' END) as doctorsname"))
                                        ->orderBy('ancillaryrequist.created_at', 'desc')
                                        ->get();
        return $ultrasound->toJson();
    }
    public function checklaboratory(Request $request)
    {

        // $sub_domain = "\n192.168.30.50     weblis.com";
        // $append = file_put_contents('C:\Windows\System32\drivers\etc\hosts', $sub_domain.PHP_EOL , FILE_APPEND | LOCK_EX);

        $laboratory = DB::select("SELECT c.last_name, c.first_name, c.middle_name,
                                        d.name as clinic_name,
                                        e.name as item_name,
                                        (CASE WHEN f.id THEN f.price ELSE e.price END) as price,
                                        (CASE WHEN f.id THEN (CASE WHEN a.status = 'Done' THEN a.status ELSE 'Paid' END) ELSE a.status END) as status,
                                        b.created_at as created_at,
                                        a.lis_result_link,
                                        a.id as request_id
                                FROM laboratory_requests a
                                LEFT JOIN laboratory_request_groups b ON a.laboratory_request_group_id = b.id
                                LEFT JOIN users c ON b.user_id = c.id
                                LEFT JOIN clinics d ON c.clinic = d.id
                                LEFT JOIN laboratory_sub_list e ON a.item_id = e.id
                                LEFT JOIN laboratory_payment f ON a.id = f.laboratory_request_id
                                WHERE b.patient_id = ?
                                UNION 
                                SELECT c.last_name, c.first_name, c.middle_name,
                                        d.name as clinic_name,
                                        e.sub_category as item_name,
                                        (CASE WHEN b.id THEN b.price ELSE e.price END) as price,
                                        (CASE WHEN b.id THEN (CASE WHEN b.get = 'Y' THEN 'Finished' ELSE 'Paid' END) ELSE 'Pending' END) as status,
                                        a.created_at as created_at,
                                        (null) as lis_result_link,
                                        a.id as request_id
                                FROM ancillaryrequist a 
                                LEFT JOIN cashincome b ON a.id = b.ancillaryrequist_id
                                LEFT JOIN users c ON a.users_id = c.id
                                LEFT JOIN clinics d ON c.clinic = d.id
                                LEFT JOIN cashincomesubcategory e ON a.cashincomesubcategory_id = e.id
                                LEFT JOIN cashincomecategory f ON e.cashincomecategory_id = f.id
                                WHERE a.patients_id = ?
                                AND f.id IN(10)
                                ORDER BY created_at DESC
                                ", [$request->patient, $request->patient]);
        echo json_encode($laboratory);
        return;
    }

    public function getlaboratorypdf($id)
    {
        $data = LaboratoryRequest::find($id);

        /**
         * Transfer Files Server to Server using PHP Copy
         */
         
        /* Source File URL */
        $remote_file_url = $data->lis_result_link;

        /*get the file name*/
        if(preg_match("/\/(\d+)$/",$data->lis_result_link,$matches))
        {
          $end=$matches[1];
        }
        else
        {
          //Your URL didn't match.  This may or may not be a bad thing.
        }
         
        /* New file name and path for this file */
        $local_file = 'public/laboratory/result/pdf/'.$end.'.pdf';
         
        /* Copy the file from source url to server */
        $check =  file_exists($local_file);
        if (!$check) {
            $copy = copy( $remote_file_url, $local_file );
        }
         
        /* Add notice for success/failure */
        // if( !$copy ) {
        //     echo "Doh! failed to copy file...\n";
        // }
        // else{
        //     echo "WOOT! success to copy file...\n";
        // }
        echo json_encode($end);
        return;
    }



}