<?php

namespace App\Http\Controllers;

use App\Patient;
use Illuminate\Http\Request;
use App\ChildhoodCare;
use App\Clinic;
use Auth;
use Session;
use PDF;

class ChildHoodCareController extends Controller
{


    public function create(Patient $patient)
    {
        $patient = Patient::where('patients.id', $patient->id)
            ->leftJoin('refcitymun', 'refcitymun.citymunCode', 'patients.city_municipality')
            ->leftJoin('refprovince', 'refprovince.provCode', 'refcitymun.provCode')
            ->leftJoin('refbrgy', 'refbrgy.id', 'patients.brgy')
            ->leftJoin('refregion', 'refregion.regCode', 'refcitymun.regDesc')
            ->when($patient->brgy, function ($query) use ($patient){
                return $query->where('refbrgy.id', $patient->brgy);
            }, function ($query) use ($patient){
                return $query->where('refcitymun.citymunCode', $patient->city_municipality);
            })
            ->select('*', 'patients.id as pid')
            ->first();

        return view('nurse.pedia.childhood_care', compact('patient'));
    }



    public function edit($id)
    {
        $data = ChildhoodCare::find($id);

        $patientDetail = Patient::find($data->patient_id);

        $patient = Patient::where('patients.id', $patientDetail->id)
            ->leftJoin('refcitymun', 'refcitymun.citymunCode', 'patients.city_municipality')
            ->leftJoin('refprovince', 'refprovince.provCode', 'refcitymun.provCode')
            ->leftJoin('refbrgy', 'refbrgy.id', 'patients.brgy')
            ->leftJoin('refregion', 'refregion.regCode', 'refcitymun.regDesc')
            ->when($patientDetail->brgy, function ($query) use ($patientDetail){
                return $query->where('refbrgy.id', $patientDetail->brgy);
            }, function ($query) use ($patientDetail){
                return $query->where('refcitymun.citymunCode', $patientDetail->city_municipality);
            })
            ->first();

        return view('nurse.pedia.childhood_care_edit', compact('patient', 'data'));

    }

    public function store(Request $request)
    {

        $bro_sisArray = [];
        $genderArray = [];
        $dateBirthArray = [];
        for ($i=0;$i<12;$i++){
            if ($request->input('bro_sis'.$i)){
                array_push($bro_sisArray,$request->input('bro_sis'.$i));
            }else{
                array_push($bro_sisArray,'*');
            }
            if ($request->input('gender'.$i)){
                array_push($genderArray,$request->input('gender'.$i));
            }else{
                array_push($genderArray,'*');
            }
            if ($request->input('date_birth'.$i)){
                array_push($dateBirthArray,$request->input('date_birth'.$i));
            }else{
                array_push($dateBirthArray,'*');
            }
        }

        $bros_sis = implode('^', $bro_sisArray);
        $gender = implode('^', $genderArray);
        $dateBirth = implode('^', $dateBirthArray);



        $pvArray = [];
        $opvArray = [];
        $mmr_twoArray = [];
        $ipvArray = [];
        $pcvArray = [];
        for ($i=0;$i<6;$i++){
            if ($request->input('pv'.$i)){
                array_push($pvArray,$request->input('pv'.$i));
            }else{
                array_push($pvArray,'*');
            }
            if ($request->input('opv'.$i)){
                array_push($opvArray,$request->input('opv'.$i));
            }else{
                array_push($opvArray,'*');
            }
            if ($request->input('mmr_two'.$i)){
                array_push($mmr_twoArray,$request->input('mmr_two'.$i));
            }else{
                array_push($mmr_twoArray,'*');
            }
            if ($request->input('ipv'.$i)){
                array_push($ipvArray,$request->input('ipv'.$i));
            }else{
                array_push($ipvArray,'*');
            }
            if ($request->input('pcv'.$i)){
                array_push($pcvArray,$request->input('pcv'.$i));
            }else{
                array_push($pcvArray,'*');
            }
        }

        $pv = implode('^', $pvArray);
        $opv = implode('^', $opvArray);
        $mmr_two = implode('^', $mmr_twoArray);
        $ipv = implode('^', $ipvArray);
        $pcv = implode('^', $pcvArray);



        $request->request->add([
            'bro_sis'=>$bros_sis,
            'gender'=>$gender,
            'date_birth'=>$dateBirth,
            'pv'=>$pv,
            'opv'=>$opv,
            'mmr_two'=>$mmr_two,
            'ipv'=>$ipv,
            'pcv'=>$pcv,
            'user_id'=>Auth::user()->id
        ]);


        if ($request->exists('updateChildhoodCare')){
            // update data
            ChildhoodCare::find($request->updateChildhoodCare)->update($request->all());
            Session::flash('toaster', array('success', 'Childhood Care Updated'));
            return redirect('childhood_care_edit/'.$request->updateChildhoodCare);
        }else{
            // save data
            $result = ChildhoodCare::create($request->all());
            Session::flash('toaster', array('success', 'Childhood Care Saved'));
            return redirect('childhood_care_edit/'.$result->id);
        }


    }



    public function childHoodCareList(Request $request)
    {
        $data = ChildhoodCare::where('patient_id', $request->pid)->get();
        $clinic = Auth::user()->clinic;
        echo json_encode(['data' => $data, 'clinic' => $clinic]);
        return;
    }



    public function printChildHoodCare($id)
    {
        $data = ChildhoodCare::find($id);

        $patientDetail = Patient::find($data->patient_id);

        $patient = Patient::where('patients.id', $patientDetail->id)
            ->leftJoin('refcitymun', 'refcitymun.citymunCode', 'patients.city_municipality')
            ->leftJoin('refprovince', 'refprovince.provCode', 'refcitymun.provCode')
            ->leftJoin('refbrgy', 'refbrgy.id', 'patients.brgy')
            ->leftJoin('refregion', 'refregion.regCode', 'refcitymun.regDesc')
            ->when($patientDetail->brgy, function ($query) use ($patientDetail){
                return $query->where('refbrgy.id', $patientDetail->brgy);
            }, function ($query) use ($patientDetail){
                return $query->where('refcitymun.citymunCode', $patientDetail->city_municipality);
            })
            ->first();


        PDF::SetTitle('OTPC');
        PDF::SetAutoPageBreak(true, 10, true);
        PDF::AddPage('P','Letter');
        PDF::SetFont('times','');
        PDF::SetXY(83,5);
        PDF::Cell(45,1,'Republic of the Philippines',0,0,'C',false,'',2,false,'T');
        PDF::SetXY(86,10);
        PDF::Cell(40,1,'Department of Health',0,0,'C',false,'',2,false,'T');
        PDF::SetXY(68,15);
        PDF::Cell(75,1,'Department of Health Regional Office No. 8',0,0,'C',false,'',2,false,'T');
        PDF::SetXY(55,20);
        PDF::Cell(100,1,'EASTERN VISAYAS MEDICAL CENTER',0,0,'C',false,'',2,false,'T');
        PDF::SetXY(93,25);
        PDF::Cell(25,1,'Tacloban City',0,0,'C',false,'',2,false,'T');
        PDF::SetXY(65,30);
        PDF::Cell(80,1,'(053)832-0308;evrmcmccoffice@gmail.com',0,0,'C',false,'',2,false,'T');
        PDF::SetXY(73,40);
        PDF::SetFont('times','B',14);
        PDF::Cell(70,1,'EARLY CHILDHOOD CARE',0,0,'C',false,'',2,false,'T');
        PDF::SetFont('times','B',14);
        PDF::SetXY(72,45);
        PDF::Cell(70,1,'AND DEVELOPMENT CARD',0,0,'C',false,'',2,false,'T');
        PDF::Image('./public/images/doh-logo.png',20,10,35);
        PDF::Image('./public/images/sentrong_sigla.png',160,10.5,25);

        $style = array('width' => .1, 'cap' => 'square', 'color' => array(0, 0, 0));

        $childHoodCare = \View::make('nurse.pedia.printChildHoodCare', compact('data', 'patient'));
        PDF::SetFont('helvetica','N',11);
        PDF::SetXY(10,55);
        PDF::writeHTML($childHoodCare, false);

        PDF::Output();

        //return view('nurse.pedia.childhood_care_edit', compact('patient', 'data'));


    }


}
