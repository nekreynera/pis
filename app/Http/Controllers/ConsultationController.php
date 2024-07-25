<?php

namespace App\Http\Controllers;


use App\Clinic;
use App\Patient;
use Illuminate\Http\Request;
use App\Consultation;
use App\FileManager;
use App\ConsultationsICD;
use App\TblDiagnosis;
use App\ICD;
use App\Smoke;
use App\IndustrialForm;
use DB;
use Validator;
use Auth;
use Carbon\Carbon;
use Session;
use PDF;


class ConsultationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('patients', ['only' => ['index']]);
    }

    public function index(Request $request)
    {
        $pid = Session::get('pid');
        $patient = Patient::where('patients.id', $pid)
                    ->leftJoin('mssclassification', 'mssclassification.patients_id', 'patients.id')
                    ->leftJoin('mss', 'mss.id', 'mssclassification.mss_id')
                    ->select('*', 'patients.id')
                    ->first();


        /* smoke */
        $smoke = Smoke::where('patient_id',$pid)->first();

        /*$consultation = Consultation::where('patients_id', '=', $pid)
                                            ->where('users_id', '=', Auth::user()->id)
                                            ->whereDate('created_at', '=', Carbon::now()->toDateString())
                                            ->latest()->first();*/
        // $consultation = Consultation::where('patients_id', '=', $pid)
        //                                     ->where('users_id', '=', Auth::user()->id)
        //                                     ->orWhere('clinic_code', Auth::user()->clinic)
        //                                     ->whereDate('created_at', '=', Carbon::now()->toDateString())
        //                                     ->latest()->first();
                                            
        $consultation = Consultation::where('patients_id', '=', $pid)
                                            ->where('users_id', '=', Auth::user()->id)
                                            ->whereDate('consultations.created_at', '=', Carbon::now()->toDateString())
                                            ->orWhere('consultations.id', DB::raw("
                                            (SELECT consultations.id
                                            FROM consultations
                                            LEFT JOIN users ON users.id = consultations.users_id
                                            WHERE patients_id = ".$pid."
                                            AND users.role = 5
                                            AND clinic_code = ".Auth::user()->clinic."
                                            AND DATE(consultations.created_at) = CURDATE()
                                            ORDER BY consultations.created_at DESC
                                            LIMIT 1)"))
                                            ->select('consultations.*')
                                            ->latest()->first();

                                            //dd($consultation);
                                            //dd(Session::has('cid'));
        if ($consultation && !Session::has('freshForm')) {
            session(['cid'=>$consultation->id]); /*cid is consultation id*/
            $icdcodes = ConsultationsICD::where('consultations_id', '=', $consultation->id)
                                        ->leftJoin('icd_codes', 'icd_codes.id', '=', 'consultations_icd.icd')
                                        ->select('icd_codes.description', 'icd_codes.code', 'consultations_icd.*')
                                        ->get();

            $fileAttachments = FileManager::where('consultations_id', '=', $consultation->id)
                                            ->leftJoin('patients', 'patients.id', '=', 'files.patients_id')
                                            ->select('patients.id as ptid', 'patients.last_name', 'files.*')
                                            ->get();
        }else{
            $icdcodes = null;
            $fileAttachments = null;
        }

        $refferals = Consultation::refferals(false);
        $followups = Consultation::followups(false);
        $vital_signs = Consultation::vital_signs(false);

        if(Auth::user()->clinic == 43){
            $industrialConsultations = IndustrialForm::with('system_reviews', 'industrial_history',
                'physical_exams', 'industrial_surveys', 'final_results')
                ->where([
                    ['patient_id', $pid],
                    [DB::raw('DATE(industrial_forms.created_at)'), Carbon::now()->toDateString()],
                    ['industrial_forms.user_id', Auth::user()->id]
                ])
                ->first();
        }else{
            $industrialConsultations = null;
        }


        //dd($patient);
        //dd($industrialConsultations);
        return view('doctors.consultation', compact('patient', 'refferals', 'followups', 'vital_signs',  'consultation',
                                                    'icdcodes', 'fileAttachments', 'industrialConsultations', 'smoke'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*---- check if user has already saved recent consultation*/
        if (Session::has('cid')) {
            /*update consultation module*/

            Consultation::find(Session::get('cid'))->update(['consultation'=>$request->consultation, 'users_id'=>Auth::user()->id]);

            /*---------- This code of line is for CIDS only ---------*/

            /*get all consultation icd for */
            $getConsultationICD = ConsultationsICD::where('consultations_id', '=', Session::get('cid'))->pluck('id');
            if ($request->has('icd')) { /*check if a name="cid" is incoming*/
                $updateICD = array(); /*this is the array where we store cid to be updated*/
                $insertICD = array(); /*this id the array where we store new selected icds*/
                foreach($request->icd as $icdCode){
                    $explodedICD = explode('_', $icdCode); /*explode icd along with (_) underscore*/
                    if (isset($explodedICD[1])) {
                        array_push($updateICD, $explodedICD[0]);
                    }else{
                        array_push($insertICD, $explodedICD[0]);
                    }
                }
                if (count($updateICD) > 0) {
                    foreach ($getConsultationICD as $upICD) {
                        if (!in_array($upICD, $updateICD)) {
                            ConsultationsICD::find($upICD)->delete(); /*delete all census icds that is not found on the request*/
                        }
                    }
                }else{
                    if ($getConsultationICD) {
                        foreach ($getConsultationICD as $cidID) {
                            ConsultationsICD::destroy($cidID); /*destroy all icds if the user removes all icd that has to be updated*/
                        }
                    }
                }
                if (count($insertICD) > 0) { /*now insert all selected icds*/
                    foreach ($insertICD as $storeICD) {
                        $newICD = new ConsultationsICD();
                        $newICD->patients_id = Session::get('pid');
                        $newICD->users_id = Auth::user()->id;
                        $newICD->consultations_id = Session::get('cid');
                        $newICD->icd = $storeICD;
                        $newICD->save();
                    }
                }
            }else{
                if ($getConsultationICD) {/* delete all icds*/
                    foreach ($getConsultationICD as $cidID) {
                        ConsultationsICD::destroy($cidID);
                    }
                }
            }

            /*-------- end of cids code of line ------------*/




            /*----- start of img update code -----------*/
            $getAllFiles = FileManager::where('consultations_id', '=', Session::get('cid'))->pluck('filename');
            if ($request->has('img')) {
                $filesChecking = $getAllFiles->toArray();
                for ($i=0; $i < count($request->img); $i++) { 
                    if (in_array($request->input("img.$i"), $filesChecking)) {
                        $insertFile = FileManager::where('filename', '=', $request->input("img.$i"))
                                                    ->update([
                                                        'title' => $request->input("title.$i"),
                                                        'description' => $request->input("description.$i")
                                                    ]);
                        $keyOFarray = array_search($request->input("img.$i"), $filesChecking);
                        array_splice($filesChecking,$keyOFarray,1);
                    }else{
                        $insertNewFile = new FileManager();
                        $insertNewFile->consultations_id = Session::get('cid');
                        $insertNewFile->patients_id = Session::get('pid');
                        $insertNewFile->filename = strtolower($request->input("img.$i"));
                        $insertNewFile->title = $request->input("title.$i");
                        $insertNewFile->description = $request->input("description.$i");
                        $insertNewFile->save();
                    }
                }
                if (count($filesChecking) > 0) {
                    foreach ($filesChecking as $deleteFile) {
                        FileManager::where('filename', '=', $deleteFile)->delete();
                    }
                }
            }else{
                if ($getAllFiles) {
                    foreach ($getAllFiles as $deleteFilename) {
                        FileManager::where('filename', '=', $deleteFilename)->delete();
                    }
                }
            }

            /*----- end of img update code -----------*/

            $request->session()->forget('freshForm');

        }else{
            /* --- if session cid not exist -----*/
            $consultation = new Consultation();
            $consultation->patients_id = $request->session()->get('pid');
            $consultation->users_id = Auth::user()->id;
            $consultation->clinic_code = Auth::user()->clinic;
            $consultation->consultation = $request->consultation;
            $consultation->save();

            if ($request->has('img')){
                for($i=0;$i<count($request->img);$i++){
                     $filemanager = new FileManager();
                     $filemanager->consultations_id = $consultation->id;
                     $filemanager->patients_id = $request->session()->get('pid');
                     $filemanager->filename = strtolower($request->input("img.$i"));
                     $filemanager->title = $request->input("title.$i");
                     $filemanager->description = $request->input("description.$i");
                     $filemanager->save();
                }
            }

             if (count($request->icd) > 0){
                 foreach ($request->icd as $code){
                     $consultation_icd = new ConsultationsICD();
                     $consultation_icd->patients_id = $request->session()->get('pid');
                     $consultation_icd->users_id = Auth::user()->id;
                     $consultation_icd->consultations_id = $consultation->id;
                     $consultation_icd->icd = $code;
                     $consultation_icd->save();
                 }
             }
             session(['cid'=>$consultation->id]); /*cid is consultation id*/
             $request->session()->forget('freshForm');
            /*return redirect("consultationpreview/$consultation->id");*/
            return redirect('consultation')->with('toaster', array('success', 'Consultation successfully saved.'));
        }
       
        return redirect('consultation')->with('toaster', array('success', 'Consultation successfully updated.'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $consultation = Consultation::find($id);
        $icdcodes = ConsultationsICD::where('consultations_id', '=', $consultation->id)
                                        ->leftJoin('icd_codes', 'icd_codes.id', '=', 'consultations_icd.icd')
                                        ->select('icd_codes.description', 'icd_codes.code', 'consultations_icd.*')
                                        ->get();
        $fileAttachments = FileManager::where('consultations_id', '=', $consultation->id)
                                            ->leftJoin('patients', 'patients.id', '=', 'files.patients_id')
                                            ->select('patients.id as ptid', 'patients.last_name', 'files.*')
                                            ->get();
        $patient = Patient::find($consultation->patients_id);
        $editCID = $consultation->patients_id;
        $refferals = Consultation::refferals($consultation->patients_id);
        $followups = Consultation::followups($consultation->patients_id);
        $vital_signs = Consultation::vital_signs($consultation->patients_id);
        return view('doctors.editconsultation', compact('consultation', 'refferals', 'followups', 'vital_signs', 'icdcodes', 'patient', 'fileAttachments', 'editCID'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /*update consultation module*/
        $consultationUpdate = Consultation::find($id);
        Consultation::find($id)->update(['consultation'=>$request->consultation]);

        /*---------- This code of line is for CIDS only ---------*/

        /*get all consultation icd for */
        $getConsultationICD = ConsultationsICD::where('consultations_id', '=', $id)->pluck('id');
        if ($request->has('icd')) { /*check if a name="cid" is incoming*/
            $updateICD = array(); /*this is the array where we store cid to be updated*/
            $insertICD = array(); /*this id the array where we store new selected icds*/
            foreach($request->icd as $icdCode){
                $explodedICD = explode('_', $icdCode); /*explode icd along with (_) underscore*/
                if (isset($explodedICD[1])) {
                    array_push($updateICD, $explodedICD[0]);
                }else{
                    array_push($insertICD, $explodedICD[0]);
                }
            }
            if (count($updateICD) > 0) {
                foreach ($getConsultationICD as $upICD) {
                    if (!in_array($upICD, $updateICD)) {
                        ConsultationsICD::find($upICD)->delete(); /*delete all census icds that is not found on the request*/
                    }
                }
            }else{
                if ($getConsultationICD) {
                    foreach ($getConsultationICD as $cidID) {
                        ConsultationsICD::destroy($cidID); /*destroy all icds if the user removes all icd that has to be updated*/
                    }
                }
            }
            if (count($insertICD) > 0) { /*now insert all selected icds*/
                foreach ($insertICD as $storeICD) {
                    $newICD = new ConsultationsICD();
                    $newICD->patients_id = $consultationUpdate->patients_id;
                    $newICD->users_id = $consultationUpdate->users_id;
                    $newICD->consultations_id = $id;
                    $newICD->icd = $storeICD;
                    $newICD->save();
                }
            }
        }else{
            if ($getConsultationICD) {/* delete all icds*/
                foreach ($getConsultationICD as $cidID) {
                    ConsultationsICD::destroy($cidID);
                }
            }
        }

        /*-------- end of cids code of line ------------*/




        /*----- start of img update code -----------*/
        $getAllFiles = FileManager::where('consultations_id', '=', $id)->pluck('filename');
        if ($request->has('img')) {
            $filesChecking = $getAllFiles->toArray();
            for ($i=0; $i < count($request->img); $i++) { 
                if (in_array($request->input("img.$i"), $filesChecking)) {
                    $insertFile = FileManager::where('filename', '=', $request->input("img.$i"))
                                                ->update([
                                                    'title' => $request->input("title.$i"),
                                                    'description' => $request->input("description.$i")
                                                ]);
                    $keyOFarray = array_search($request->input("img.$i"), $filesChecking);
                    array_splice($filesChecking,$keyOFarray,1);
                }else{
                    $insertNewFile = new FileManager();
                    $insertNewFile->consultations_id = $id;
                    $insertNewFile->patients_id = $consultationUpdate->patients_id;
                    $insertNewFile->filename = strtolower($request->input("img.$i"));
                    $insertNewFile->title = $request->input("title.$i");
                    $insertNewFile->description = $request->input("description.$i");
                    $insertNewFile->save();
                }
            }
            if (count($filesChecking) > 0) {
                foreach ($filesChecking as $deleteFile) {
                    FileManager::where('filename', '=', $deleteFile)->delete();
                }
            }
        }else{
            if ($getAllFiles) {
                foreach ($getAllFiles as $deleteFilename) {
                    FileManager::where('filename', '=', $deleteFilename)->delete();
                }
            }
        }

        /*----- end of img update code -----------*/


        return redirect('consultation/'.$id.'/edit')->with('toaster', array('success', 'Consultation updated.'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        ConsultationsICD::find($request->id)->delete();
        return;
    }


    public function consultationpreview(Request $request, $id = false)
    {
        $consultation = Consultation::find($id);
        $files = FileManager::where('consultations_id', '=', $id)->get();
        if (empty($request->session()->get('pid'))){
            $patient = Patient::find($consultation->patients_id);
        }else{
            $patient = Patient::find($request->session()->get('pid'));
        }
        $directory = '/PatientFiles/EVRMC-'.$patient->id.'-'.$patient->last_name.'/';

        $consultations_icds = ConsultationsICD::select('icd_codes.description')
                        ->leftJoin('icd_codes', 'icd_codes.id', '=', 'consultations_icd.icd')
                        ->where('consultations_id', '=', $consultation->id)->get();

        return view('doctors.preview', compact('consultation', 'files', 'directory', 'consultations_icds'));
    }


    public function delete($id)
    {
        Consultation::find($id)->delete();
        FileManager::where('consultations_id', '=', $id)->delete();
        ConsultationsICD::where('consultations_id', '=', $id)->delete();
        Session::flash('toaster', array('error','Consultation has been deleted'));
        return redirect('patientlist');
    }


    public function createAnewForm(Request $request)
    {
        $request->session()->forget('cid');
        session(['freshForm'=>'fresh']); /*cid is consultation id*/
        return redirect('consultation');
    }


    public function print($id)
    {
        $consultation = Consultation::where('consultations.id', '=', $id)
                                        ->leftJoin('patients as pt', 'pt.id', '=', 'consultations.patients_id')->first();

        $address = Patient::address($consultation->patients_id);

        PDF::SetTitle('Consultation');
        PDF::SetAutoPageBreak(true, 10, true);
        PDF::AddPage('P','LEGAL');
        PDF::SetFont('times','');
        PDF::SetXY(83,5);
        PDF::Cell(45,1,'Republic of the Philippines',0,0,'C',false,'',2,false,'T');
        PDF::SetXY(86,10);
        PDF::Cell(40,1,'Department of Health',0,0,'C',false,'',2,false,'T');
        PDF::SetXY(68,15);
        PDF::Cell(75,1,'Department of Health Regional Office No. 8',0,0,'C',false,'',2,false,'T');
        PDF::SetXY(55,20);
        PDF::Cell(100,1,'EASTERN VISAYAS REGIONAL MEDICAL CENTER',0,0,'C',false,'',2,false,'T');
        PDF::SetXY(93,25);
        PDF::Cell(25,1,'Tacloban City',0,0,'C',false,'',2,false,'T');
        PDF::SetXY(65,30);
        PDF::Cell(80,1,'(053)832-0308;evrmcmccoffice@gmail.com',0,0,'C',false,'',2,false,'T');
        PDF::SetXY(70,40);
        PDF::SetFont('times','I');
        PDF::Cell(78,1,'"PHIC Accredited Health Care Provider"',0,0,'C',false,'',2,false,'T');
        PDF::SetFont('times','B',18);
        PDF::SetXY(70,50);
        PDF::Cell(80,1,'OUT PATIENT RECORD',0,0,'C',false,'',2,false,'T');
        PDF::Image('./public/images/doh-logo.png',20,10,35);
        PDF::Image('./public/images/evrmc-logo.png',160,10.5,25);

        $style = array('width' => .1, 'cap' => 'square', 'color' => array(0, 0, 0));

        PDF::SetFont('times','N',11);
        PDF::SetXY(130,63);
        PDF::Cell(40,1,'HOSPITAL RECORD NO:',0,0,'C',false,'',2,false,'T');
        PDF::Text(170,63,$consultation->hospital_no);
        PDF::Line(170, 67, 205, 67, $style);

        PDF::SetXY(10,70);
        PDF::Cell(23,1,'LAST NAME:',0,0,'C',false,'',2,false,'T');
        PDF::Text(32,70,$consultation->last_name);
        PDF::Line(33, 75, 90, 75, $style);

        PDF::SetXY(96,70);
        PDF::Cell(28,1,'MIDDLE NAME:',0,0,'C',false,'',2,false,'T');
        PDF::Text(123,70,$consultation->middle_name);
        PDF::Line(177, 75, 124, 75, $style);

        PDF::SetXY(180,70);
        PDF::Cell(10,1,'SEX:',0,0,'C',false,'',2,false,'T');
        PDF::Text(190,70,($consultation->sex == 'M')? 'Male' : 'Female');
        PDF::Line(205, 75, 190, 75, $style);

        $suffix = ($consultation->suffix)? $consultation->suffix.'.' : '';
        PDF::SetXY(10,75);
        PDF::Cell(23,1,'GIVEN NAME:',0,0,'C',false,'',2,false,'T');
        PDF::Text(32,75,$consultation->first_name.' '.$suffix);
        PDF::Line(33, 80, 90, 80, $style);

        PDF::SetXY(96,75);
        PDF::Cell(20,1,'BIRTHDAY:',0,0,'C',false,'',2,false,'T');
        PDF::Text(115,75,Carbon::parse($consultation->birthday)->format('F d, Y'));
        PDF::Line(150, 80, 115, 80, $style);

        PDF::SetXY(157,75);
        PDF::Cell(10,1,'AGE:',0,0,'C',false,'',2,false,'T');
        PDF::Text(167,75,Patient::age($consultation->birthday));
        PDF::Line(205, 80, 166, 80, $style);

        PDF::SetXY(10,80);
        PDF::Cell(25,1,'CIVIL STATUS:',0,0,'C',false,'',2,false,'T');
        PDF::Text(34,80,$consultation->civil_status);
        PDF::Line(35, 85, 90, 85, $style);

        PDF::SetXY(96,80);
        PDF::Cell(25,1,'CONTACT NO:',0,0,'C',false,'',2,false,'T');
        PDF::Text(120,80,$consultation->contact_no);
        PDF::Line(205, 85, 120, 85, $style);

        PDF::SetXY(10,85);
        PDF::Cell(19,1,'ADDRESS:',0,0,'C',false,'',2,false,'T');

        PDF::SetXY(29,85);
        PDF::Cell(13,1,'BRGY:',0,0,'C',false,'',2,false,'T');
        PDF::Text(41,85,(isset($address->brgyDesc))? $address->brgyDesc : '');
        PDF::Line(41, 90, 90, 90, $style);

        PDF::SetXY(96,85);
        PDF::Cell(38,1,'MUNICIPALITY/CITY:',0,0,'C',false,'',2,false,'T');
        PDF::Text(133,85,(isset($address->citymunDesc))? $address->citymunDesc : '');
        PDF::Line(133, 90, 205, 90, $style);

        PDF::SetXY(10,90);
        PDF::Cell(20,1,'PROVINCE:',0,0,'C',false,'',2,false,'T');
        PDF::Text(29,90,(isset($address->provDesc))? $address->provDesc : '');
        PDF::Line(29, 95, 90, 95, $style);

        PDF::SetXY(96,90);
        PDF::Cell(18,1,'DISTRICT:',0,0,'C',false,'',2,false,'T');
        PDF::Text(113,90,(isset($address->regDesc))? $address->regDesc : '');
        PDF::Line(112, 95, 205, 95, $style);

        $table3 = \View::make('doctors.consultation.print', compact('consultation'));

        PDF::SetFont('helvetica','N',11);
        PDF::SetXY(10,105);
        //PDF::writeHTML($consultation->consultation, false);
        PDF::writeHTML($table3, false);
        PDF::Output();
    }



    public function mergeConsultations()
    {
        dd('alldone ty lord jesus');
        /*$tblDiagnosis = TblDiagnosis::all();
        foreach ($tblDiagnosis as $row){
            $clinic = Clinic::where('code', '=', $row->clinic_code)->first();

            $table = \View::make('doctors.consultation_migrate', compact('row'));

            $consultations = new Consultation();
            $consultations->id = $row->diagnose_id;
            $consultations->patients_id = $row->patient_id;
            $consultations->users_id = ($row->user_id != null)? $row->user_id : '999';
            $consultations->clinic_code = ($clinic)? $clinic->id : '999';
            $consultations->consultation = $table;
            $consultations->created_at = $row->date_created;
            $consultations->updated_at = $row->date_created;
            $consultations->save();
        }*/
    }

}
