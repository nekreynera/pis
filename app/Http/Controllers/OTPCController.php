<?php

namespace App\Http\Controllers;

use App\Patient;
use Illuminate\Http\Request;
use App\OTPC_Front;
use App\OTPC_Back;
use App\Queue;
use App\Clinic;
use Auth;
use DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Contracts\Support\JsonableInterface;
use PDF;


class OTPCController extends Controller
{

    public function otpc_homepage(Patient $patient)
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

        return view('nurse.pedia.otpc_front', compact('patient'));
    }


    public function pediaQueing()
    {
        $queuings = Queue::where([
                [DB::raw('DATE(queues.created_at)'), DB::raw('CURDATE()')],
                ['queues.clinic_code', Auth::user()->clinic],
            ])
            ->leftJoin('patients', 'patients.id', 'queues.patients_id')
            ->leftJoin('assignations', function($join){
                $join->on('assignations.patients_id', 'queues.patients_id');
                $join->where('assignations.clinic_code', Auth::user()->clinic);
                $join->where(DB::raw('DATE(assignations.created_at)'), DB::raw('CURDATE()'));
            })
            ->leftJoin('users', 'users.id', 'assignations.doctors_id')
            ->orderBy('queues.created_at')
            ->groupBy('queues.patients_id')
            ->select('*', 'patients.id as patients_id', 'patients.last_name as ptLastName', 'patients.first_name as ptFirstName',
                'patients.suffix as ptSuffix', 'patients.middle_name as ptMiddleName', 'queues.created_at')
            ->paginate(10);

        return view('nurse.pedia.queing', compact('queuings'));
    }


    public function pediaSearchPatient(Request $request)
    {
        $queuings = Patient::where(DB::raw("CONCAT(patients.last_name,' ',patients.first_name)"),
                        'LIKE', '%'.$request->search.'%')
                        ->orWhere(DB::raw("SOUNDEX(CONCAT(patients.last_name,' ',patients.first_name))"),
                            DB::raw('SOUNDEX("'.$request->search.'")'))
                        ->orWhere([
                            'patients.hospital_no' => "$request->search",
                            'patients.barcode' => "$request->search"
                        ])
                        ->orWhere(DB::raw('DATE(patients.created_at)'), "$request->search")
                        ->paginate(10);

        $data = ['queuings' => $queuings, 'search' => $request->search];
//        $this->pediaSearch($data['queuings']);
        return view('nurse.pedia.search', compact('data'));
    }


    public function pediaSearch($data = false)
    {
        if (!$data){
            $data = ['search' => null];
        }
        return view('nurse.pedia.search', compact('data'));
    }



    public function edit($id)
    {
        $data = OTPC_Front::leftJoin('otpc_back', 'otpc_back.otpc_id', 'otpc_front.id')
                ->where('otpc_front.id', $id)
                ->first();

        $patientResult = Patient::find($data->patient_id);

        $patient = Patient::where('patients.id', $patientResult->id)
                ->leftJoin('refcitymun', 'refcitymun.citymunCode', 'patients.city_municipality')
                ->leftJoin('refprovince', 'refprovince.provCode', 'refcitymun.provCode')
                ->leftJoin('refbrgy', 'refbrgy.id', 'patients.brgy')
                ->leftJoin('refregion', 'refregion.regCode', 'refcitymun.regDesc')
                ->when($patientResult->brgy, function ($query) use ($patientResult){
                    return $query->where('refbrgy.id', $patientResult->brgy);
                }, function ($query) use ($patientResult){
                    return $query->where('refcitymun.citymunCode', $patientResult->city_municipality);
                })
                ->first();


        return view('nurse.pedia.edit_otpc', compact('data', 'patient'));
    }




    public function therapeuticCareList(Request $request)
    {
        $data = OTPC_Front::where('patient_id', $request->pid)->get();
        $clinic = Auth::user()->clinic;
        echo json_encode(['data' => $data, 'clinic' => $clinic]);
        return;
    }



    public function  otpc_save(Request $request)
    {

        $drugArray = [];
        $dateAdmissionArray = [];
        $dosageArray = [];
        for ($i=1;$i<5;$i++){
            if ($request->input('drug'.$i)){
                array_push($drugArray,$request->input('drug'.$i));
            }else{
                array_push($drugArray,'*');
            }
            if ($request->input('dateAdmission'.$i)){
                array_push($dateAdmissionArray,$request->input('dateAdmission'.$i));
            }else{
                array_push($dateAdmissionArray,'*');
            }
            if ($request->input('dosage'.$i)){
                array_push($dosageArray,$request->input('dosage'.$i));
            }else{
                array_push($dosageArray,'*');
            }
        }
        $drugs = implode('^',$drugArray);
        $dateAdmission = implode('^',$dateAdmissionArray);
        $dosage = implode('^',$dosageArray);


        //add request
        $request->request->add(['drugsFront'=>$drugs,'dateFront'=>$dateAdmission,'dosageFront'=>$dosage, 'user_id'=>Auth::user()->id]);

        if ($request->exists('updateOTPC')){
            $otpc = OTPC_Front::find($request->updateOTPC)->update($request->all());
        }else{
            $otpc = OTPC_Front::create($request->all()); //save otpc_front
        }





        $dateArray = [];
        $weightArray = [];
        $weightLosArray = [];
        $muacArray = [];
        $edemaArray = [];
        $length_heightArray = [];
        $whzArray = [];
        $diarrheaArrays = [];
        $vomitingDaysArrays = [];
        $feverDaysArrays = [];
        $coughDaysArrays = [];
        $temperatureArrays = [];
        $respirationRateArrays = [];
        $dehydratedArray = [];
        $anemiaArray = [];
        $skinInfectionArray = [];
        $appetiteTestArray = [];
        $actionNeededArray = [];
        $appetiteTestPassFailArray = [];
        $otherMedicationArray = [];
        $rutfArray = [];
        $nameOfExaminerArray = [];
        $outcomeArray = [];
        for ($i=0;$i<17;$i++){
            if ($request->input('date'.$i)){
                array_push($dateArray,$request->input('date'.$i));
            }else{
                array_push($dateArray,'*');
            }
            if ($request->input('weightKG'.$i)){
                array_push($weightArray,$request->input('weightKG'.$i));
            }else{
                array_push($weightArray,'*');
            }
            if ($request->input('weightLoss'.$i)){
                array_push($weightLosArray,$request->input('weightLoss'.$i));
            }else{
                array_push($weightLosArray,'*');
            }
            if ($request->input('muac'.$i)){
                array_push($muacArray,$request->input('muac'.$i));
            }else{
                array_push($muacArray,'*');
            }
            if ($request->input('edemaBack'.$i)){
                array_push($edemaArray,$request->input('edemaBack'.$i));
            }else{
                array_push($edemaArray,'*');
            }
            if ($request->input('length_height'.$i)){
                array_push($length_heightArray,$request->input('length_height'.$i));
            }else{
                array_push($length_heightArray,'*');
            }
            if ($request->input('whz'.$i)){
                array_push($whzArray,$request->input('whz'.$i));
            }else{
                array_push($whzArray,'*');
            }
            if ($request->input('diarrheaDays'.$i)){
                array_push($diarrheaArrays,$request->input('diarrheaDays'.$i));
            }else{
                array_push($diarrheaArrays,'*');
            }
            if ($request->input('vomiting_days'.$i)){
                array_push($vomitingDaysArrays,$request->input('vomiting_days'.$i));
            }else{
                array_push($vomitingDaysArrays,'*');
            }
            if ($request->input('fever_days'.$i)){
                array_push($feverDaysArrays,$request->input('fever_days'.$i));
            }else{
                array_push($feverDaysArrays,'*');
            }
            if ($request->input('cough_days'.$i)){
                array_push($coughDaysArrays,$request->input('cough_days'.$i));
            }else{
                array_push($coughDaysArrays,'*');
            }
            if ($request->input('temperatureDays'.$i)){
                array_push($temperatureArrays,$request->input('temperatureDays'.$i));
            }else{
                array_push($temperatureArrays,'*');
            }
            if ($request->input('respirationRate'.$i)){
                array_push($respirationRateArrays,$request->input('respirationRate'.$i));
            }else{
                array_push($respirationRateArrays,'*');
            }
            if ($request->input('dehydrated'.$i)){
                array_push($dehydratedArray,$request->input('dehydrated'.$i));
            }else{
                array_push($dehydratedArray,'*');
            }
            if ($request->input('anemia'.$i)){
                array_push($anemiaArray,$request->input('anemia'.$i));
            }else{
                array_push($anemiaArray,'*');
            }
            if ($request->input('skin_infection'.$i)){
                array_push($skinInfectionArray,$request->input('skin_infection'.$i));
            }else{
                array_push($skinInfectionArray,'*');
            }
            if ($request->input('appetite_test_day'.$i)){
                array_push($appetiteTestArray,$request->input('appetite_test_day'.$i));
            }else{
                array_push($appetiteTestArray,'*');
            }
            if ($request->input('action_needed'.$i)){
                array_push($actionNeededArray,$request->input('action_needed'.$i));
            }else{
                array_push($actionNeededArray,'*');
            }
            if ($request->input('appetite_test_pass_fail'.$i)){
                array_push($appetiteTestPassFailArray,$request->input('appetite_test_pass_fail'.$i));
            }else{
                array_push($appetiteTestPassFailArray,'*');
            }
            if ($request->input('other_medication'.$i)){
                array_push($otherMedicationArray,$request->input('other_medication'.$i));
            }else{
                array_push($otherMedicationArray,'*');
            }
            if ($request->input('rutf'.$i)){
                array_push($rutfArray,$request->input('rutf'.$i));
            }else{
                array_push($rutfArray,'*');
            }
            if ($request->input('examiner'.$i)){
                array_push($nameOfExaminerArray,$request->input('examiner'.$i));
            }else{
                array_push($nameOfExaminerArray,'*');
            }
            if ($request->input('outcome'.$i)){
                array_push($outcomeArray,$request->input('outcome'.$i));
            }else{
                array_push($outcomeArray,'*');

            }
        }

        $dateFinal = implode('^',$dateArray);
        $weightFinal = implode('^',$weightArray);
        $weightLosFinal = implode('^',$weightLosArray);
        $muacFinal = implode('^',$muacArray);
        $edemaFinal = implode('^',$edemaArray);
        $length_heightFinal = implode('^',$length_heightArray);
        $whzFinal = implode('^',$whzArray);
        $diarrheaFinal = implode('^',$diarrheaArrays);
        $vomitingDaysFinal = implode('^',$vomitingDaysArrays);
        $feverDaysFinal = implode('^',$feverDaysArrays);
        $coughDaysFinal = implode('^',$coughDaysArrays);
        $temperatureFinal = implode('^',$temperatureArrays);
        $respirationRateFinal = implode('^',$respirationRateArrays);
        $dehydratedFinal = implode('^',$dehydratedArray);
        $anemiaFinal = implode('^',$anemiaArray);
        $skinInfectionFinal = implode('^',$skinInfectionArray);
        $appetiteTestFinal = implode('^',$appetiteTestArray);
        $actionNeededFinal = implode('^',$actionNeededArray);
        $appetiteTestPassFailFinal = implode('^',$appetiteTestPassFailArray);
        $otherMedicationFinal = implode('^',$otherMedicationArray);
        $rutfFinal = implode('^',$rutfArray);
        $nameOfExaminerFinal = implode('^',$nameOfExaminerArray);
        $outcomeFinal = implode('^',$outcomeArray);


        //save otpc_back
        if ($request->exists('updateOTPC')){
            $otpcBack = OTPC_Back::find($request->updateOTPC);
        }else{
            $otpcBack = new OTPC_Back();
            $otpcBack->otpc_id = $otpc->id;
        }

       // OTPC_Back::create([
            $otpcBack->registrationNumber = $request->registrationNumber;
            $otpcBack->date = $dateFinal;
            $otpcBack->weightKG = $weightFinal;
            $otpcBack->weightLoss = $weightLosFinal;
            $otpcBack->muac = $muacFinal;
            $otpcBack->edemaBack = $edemaFinal;
            $otpcBack->length_height = $length_heightFinal;
            $otpcBack->whz = $whzFinal;
            $otpcBack->diarrheaDays = $diarrheaFinal;
            $otpcBack->vomiting_days = $vomitingDaysFinal;
            $otpcBack->fever_days = $feverDaysFinal;
            $otpcBack->cough_days = $coughDaysFinal;
            $otpcBack->temperatureDays = $temperatureFinal;
            $otpcBack->respirationRate = $respirationRateFinal;
            $otpcBack->dehydrated = $dehydratedFinal;
            $otpcBack->anemia = $anemiaFinal;
            $otpcBack->skin_infection = $skinInfectionFinal;
            $otpcBack->appetite_test_day = $appetiteTestFinal;
            $otpcBack->action_needed = $actionNeededFinal;
            $otpcBack->appetite_test_pass_fail = $appetiteTestPassFailFinal;
            $otpcBack->other_medication = $otherMedicationFinal;
            $otpcBack->rutf = $rutfFinal;
            $otpcBack->examiner = $nameOfExaminerFinal;
            $otpcBack->outcome = $outcomeFinal;
            $otpcBack->save();
        //]);

        if ($request->exists('updateOTPC')){
            Session::flash('toaster', array('success', 'Therapeutic Care Updated'));
            return redirect('otpc_edit/'.$request->updateOTPC);
        }else{
            Session::flash('toaster', array('success', 'Therapeutic Care Saved'));
            return redirect('otpc_edit/'.$otpc->id);
        }


    }




    public function printOTC($id)
    {
        $data = OTPC_Front::leftJoin('otpc_back', 'otpc_back.otpc_id', 'otpc_front.id')
            ->where('otpc_front.id', $id)
            ->first();

        $patientResult = Patient::find($data->patient_id);

        $patient = Patient::where('patients.id', $patientResult->id)
            ->leftJoin('refcitymun', 'refcitymun.citymunCode', 'patients.city_municipality')
            ->leftJoin('refprovince', 'refprovince.provCode', 'refcitymun.provCode')
            ->leftJoin('refbrgy', 'refbrgy.id', 'patients.brgy')
            ->leftJoin('refregion', 'refregion.regCode', 'refcitymun.regDesc')
            ->when($patientResult->brgy, function ($query) use ($patientResult){
                return $query->where('refbrgy.id', $patientResult->brgy);
            }, function ($query) use ($patientResult){
                return $query->where('refcitymun.citymunCode', $patientResult->city_municipality);
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
        PDF::Cell(100,1,'EASTERN VISAYAS REGIONAL MEDICAL CENTER',0,0,'C',false,'',2,false,'T');
        PDF::SetXY(93,25);
        PDF::Cell(25,1,'Tacloban City',0,0,'C',false,'',2,false,'T');
        PDF::SetXY(65,30);
        PDF::Cell(80,1,'(053)832-0308;evrmcmccoffice@gmail.com',0,0,'C',false,'',2,false,'T');
        PDF::SetXY(95,40);
        PDF::SetFont('times','B',14);
        PDF::Cell(20,1,'OTC Chart',0,0,'C',false,'',2,false,'T');
        PDF::SetFont('times','B',14);
        PDF::SetXY(46,45);
        PDF::Cell(120,1,'ADMISSION DETAILS: OUT PATIENT THERAPEUTIC CARE (FRONT)',0,0,'C',false,'',2,false,'T');
        PDF::Image('./public/images/doh-logo.png',20,10,35);
        PDF::Image('./public/images/evrmc-logo.png',160,10.5,25);

        $style = array('width' => .1, 'cap' => 'square', 'color' => array(0, 0, 0));

        $otpcPrint = \View::make('nurse.pedia.printOTPC', compact('data', 'patient'));

        PDF::SetFont('helvetica','N',11);
        PDF::SetXY(10,55);
        PDF::writeHTML($otpcPrint, false);


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
        PDF::Cell(100,1,'EASTERN VISAYAS REGIONAL MEDICAL CENTER',0,0,'C',false,'',2,false,'T');
        PDF::SetXY(93,25);
        PDF::Cell(25,1,'Tacloban City',0,0,'C',false,'',2,false,'T');
        PDF::SetXY(65,30);
        PDF::Cell(80,1,'(053)832-0308;evrmcmccoffice@gmail.com',0,0,'C',false,'',2,false,'T');
        PDF::SetXY(95,40);
        PDF::SetFont('times','B',14);
        PDF::Cell(20,1,'OTC Chart',0,0,'C',false,'',2,false,'T');
        PDF::SetFont('times','B',14);
        PDF::SetXY(46,45);
        PDF::Cell(115,1,'FOLLOW UP: OUT PATIENT THERAPEUTIC CARE (BACK)',0,0,'C',false,'',2,false,'T');
        PDF::Image('./public/images/doh-logo.png',20,10,35);
        PDF::Image('./public/images/evrmc-logo.png',160,10.5,25);



        $otpcPrintBack = \View::make('nurse.pedia.printOTPCBack', compact('data', 'patient'));
        PDF::SetFont('helvetica','N',11);
        PDF::SetXY(10,55);
        PDF::writeHTML($otpcPrintBack, false);

        PDF::Output();
    }











}
