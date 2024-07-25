<?php

namespace App\Http\Controllers;

use App\Consultation;
use Illuminate\Http\Request;
use Illuminate\Pagination;
use Illuminate\Contracts\Support\JsonableInterface;
use Illuminate\Http\Response;
use App\Diagnosed;
use App\ICD;
use App\DiagnosisICD;
use App\Patient;
use Auth;
use Session;
use Carbon;
use Validator;
use DB;
use PDF;

use Illuminate\Http\Resources\Json;


class DiagnosisController extends Controller
{

    public function __construct()
    {
        $this->middleware('patients', ['only' => ['index']]);
    }


    public function index()
    {
        $icds = ICD::paginate(50);
        $patient = Patient::find(Session::get('pid'));
        return view('doctors.diagnosis_form', compact('icds', 'patient'));
    }


    public function searchICD(Request $request)
    {
        if (empty($request->searchkey) || $request->searchkey == ''){
            $icds = ICD::paginate(15);
        }else{
            $searchkey = $request->searchkey;
            $icds = ICD::where('description', 'like', '%'.$searchkey.'%')->paginate(15);
        }
        return $icds->toJson();
    }

    public function searchICDByCode(Request $request)
    {
        if (empty($request->searchkey) || $request->searchkey == ''){
            $icds = ICD::paginate(15);
        }else{
            $searchkey = $request->searchkey;
            $icds = ICD::where('code', 'like', '%'.$searchkey.'%')->paginate(15);
        }
        return $icds->toJson();
    }


    public function store(Request $request)
    {
        $request->request->add([
            'patients_id' => $request->session()->get('pid'),
            'users_id' => Auth::user()->id
        ]);
        $validator = Validator::make($request->all(), [
            'diagnosis' => 'required'
        ]);
        if ($validator->passes()){
            $diagnosis = Diagnosed::create($request->all());
            if (count($request->icd) > 0){
                foreach ($request->icd as $code){
                    $diagnosis_icd = new DiagnosisICD();
                    $diagnosis_icd->patients_id = $request->session()->get('pid');
                    $diagnosis_icd->users_id = Auth::user()->id;
                    $diagnosis_icd->diagnosis_id = $diagnosis->id;
                    $diagnosis_icd->icd = $code;
                    $diagnosis_icd->save();
                }
            }
            Session::flash('toaster', array('success', 'Diagnosis succesfully saved.'));
            return redirect("diagnosis/$diagnosis->id");
        }else{
            return redirect()->back()->with('toaster', array('error', 'Diagnosis form cannot be empty.'));
        }
    }


    public function show($id)
    {
        $diagnosis = Diagnosed::find($id);
        $diagnosis_icds = DiagnosisICD::select('icd_codes.description')
                                        ->leftJoin('icd_codes', 'icd_codes.id', '=', 'diagnosis_icd.icd')
                                        ->where('diagnosis_id', '=', $diagnosis->id)->get();
        return view('doctors.diagnosis_preview', compact('diagnosis', 'diagnosis_icds'));
    }


    public function edit($id)
    {
        $diagnosis = Diagnosed::find($id);
        $diagnosis_icds = DiagnosisICD::select('icd_codes.description', 'icd_codes.id as icd_id', 'diagnosis_icd.id as dicd_id')
                                        ->leftJoin('icd_codes', 'icd_codes.id', '=', 'diagnosis_icd.icd')
                                        ->where('diagnosis_id', '=', $diagnosis->id)->get();
        $patient = Patient::where('id', '=', $diagnosis->patients_id)->first();
        return view('doctors.diagnosis_edit', compact('diagnosis', 'diagnosis_icds', 'patient'));
    }

    public function update(Request $request, $id)
    {
        Diagnosed::find($id)->update($request->all());
        DiagnosisICD::where('diagnosis_id', '=', $id)->delete();
        if (count($request->icd) > 0){
            foreach ($request->icd as $code){
                $diagnosis_icd = new DiagnosisICD();
                $diagnosis_icd->patients_id = $request->session()->get('pid');
                $diagnosis_icd->users_id = Auth::user()->id;
                $diagnosis_icd->diagnosis_id = $id;
                $diagnosis_icd->icd = $code;
                $diagnosis_icd->save();
            }
        }
        Session::flash('toaster', array('success','Diagnosis successfully updated.'));
        return redirect("diagnosis/$id");
    }

    public function destroy(Request $request)
    {
        DiagnosisICD::find($request->id)->delete();
        return;
    }

    public function delete($id)
    {
        Diagnosed::find($id)->delete();
        DiagnosisICD::where('diagnosis_id', '=', $id)->delete();
        Session::flash('toaster', array('error','Diagnosis was been deleted.'));
        return redirect('patientlist');
    }

    public function diagnosis_list($id = false)
    {
        $diagnosis = Diagnosed::where('patients_id', '=', $id)
                        ->leftJoin('patients as pt', 'pt.id', '=', 'diagnosis.patients_id')
                        ->leftJoin('users as us', 'us.id', '=', 'diagnosis.users_id')
                        ->leftJoin('clinics', 'clinics.id', '=', 'us.clinic')
                        ->select('diagnosis.*', 'clinics.name as clinic', DB::raw("CONCAT(pt.last_name,', ',pt.first_name,' ',CASE WHEN pt.suffix IS NOT NULL THEN pt.suffix ELSE '' END,' ',CASE WHEN pt.middle_name IS NOT NULL THEN LEFT(pt.middle_name, 1) ELSE '' END) as name"), DB::raw("CONCAT(us.first_name,' ', LEFT(us.middle_name, 1),'.',' ',us.last_name) as doctor"))
                        ->get();
        return view('doctors.diagnosis_list', compact('diagnosis'));
    }

    public function printdiagnosis($id)
    {
        $consultation = Diagnosed::where('diagnosis.id', '=', $id)
            ->leftJoin('patients as pt', 'pt.id', '=', 'diagnosis.patients_id')->first();

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

        PDF::SetXY(10,75);
        PDF::Cell(23,1,'GIVEN NAME:',0,0,'C',false,'',2,false,'T');
        PDF::Text(32,75,$consultation->first_name);
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

        PDF::SetFont('helvetica','N',11);
        PDF::SetXY(10,105);
        PDF::writeHTML($consultation->diagnosis, false);
        PDF::Output();
    }








}
