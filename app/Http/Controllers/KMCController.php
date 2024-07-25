<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\KMC;
use Auth;
use App\Patient;
use Session;
use PDF;


class KMCController extends Controller
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
            ->select('*', 'patients.id as id')
            ->first();

        return view('nurse.pedia.kmc', compact('patient'));
    }


    public function store(Request $request)
    {

        $feeding = ($request->feed)? serialize($request->feed) : null;
        $way_of_administration = ($request->feed)? serialize($request->wayofadministration) : null;
        $not_well = ($request->feed)? serialize($request->notwell) : null;
        $neuro = ($request->feed)? serialize($request->neurological) : null;
        $chronic_pathology = ($request->feed)? serialize($request->chronicpathology) : null;

        $request->request->add([
            'user_id' => Auth::user()->id,
            'feeding' => $feeding,
            'way_of_administration' => $way_of_administration,
            'not_well' => $not_well,
            'neuro' => $neuro,
            'chronic_pathology' => $chronic_pathology
        ]);


        if($request->exists('updatedKMC')){
            $kmc = KMC::find($request->updatedKMC)->update($request->all());
            Session::flash('toaster', array('success', 'Kangaroo Mother Care Program Updated'));
            return redirect('kmc_edit/'.$request->updatedKMC);
        }else{
            $kmc = KMC::create($request->all()); //save otpc_front
            Session::flash('toaster', array('success', 'Kangaroo Mother Care Program Saved'));
            return redirect('kmc_edit/'.$kmc->id);
        }

    }



    public function edit($id)
    {
        $data = KMC::find($id);

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


        return view('nurse.pedia.kmc_edit', compact('data', 'patient'));
    }


    public function kmcList(Request $request)
    {
        $data = KMC::where('patient_id', $request->pid)->get();
        return $data->toJson();
    }



    public function printKMC($id)
    {
        $data = KMC::find($id);

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
        PDF::SetFont('times','B',14);
        PDF::SetXY(65,38);
        PDF::Cell(80,1,'KMC (Kangaroo Mother Care Program)',0,0,'C',false,'',2,false,'T');
        PDF::Image('./public/images/doh-logo.png',20,10,35);
        PDF::Image('./public/images/evrmc-logo.png',160,10.5,25);


        $kmc = \View::make('nurse.pedia.printKMC', compact('data', 'patient'));
        PDF::SetFont('helvetica','N',11);
        PDF::SetXY(10,55);
        PDF::writeHTML($kmc, false);


        PDF::Output();



    }



}
