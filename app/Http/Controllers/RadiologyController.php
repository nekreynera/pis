<?php

namespace App\Http\Controllers;

use App\Cashincome;
use App\Cashincomesubcategory;
use function foo\func;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Contracts\Support\JsonableInterface;
use App\Patient;
use App\Queue;
use App\Ancillaryrequist;
use App\AncillaryItem;
use App\VitalSigns;
use App\Radiology;
use App\Template;
use DB;
use Session;
use Carbon;
use Validator;
use Auth;
use PDF;
use App\PdfFile;

class RadiologyController extends Controller
{

	public function index()
	{
	    $patients = Queue::where('clinic_code', '=', 31)
                            ->whereDate('queues.created_at', Carbon::now()->toDateString())
                            ->where('queues.queue_status', 'P')
                            ->leftJoin('ancillaryrequist as an', 'an.patients_id', 'queues.patients_id')
                            ->leftJoin('cashincome as ci', 'ci.ancillaryrequist_id', 'an.id')
                            ->leftJoin('patients as pt', 'pt.id', '=', 'queues.patients_id')
                            ->select('queues.*', 'pt.birthday', 'pt.id as pid', 'pt.barcode', 'ci.get',
                                DB::raw("CONCAT(pt.last_name,' ',pt.first_name,' ',
                                CASE WHEN pt.suffix IS NOT NULL THEN pt.suffix ELSE '' END,' ',
                                CASE WHEN pt.middle_name IS NOT NULL THEN LEFT(pt.middle_name, 1) ELSE '' END) as patient"))
                            ->groupBy('queues.patients_id')
                            ->get();

        $survey = Queue::where('clinic_code', Auth::user()->clinic)
            ->select(DB::raw("COUNT(*) as total"), 'queue_status as status')
            ->whereDate(DB::raw("DATE(created_at)"), DB::raw("CURDATE()"))
            ->groupBy('queue_status')
            ->get();

		return view('radiology.patients', compact('patients', 'survey'));
	}


	public function radiologyHome($status = false)
    {
        $patients = Queue::where('clinic_code', '=', Auth::user()->clinic)
            ->whereDate('queues.created_at', Carbon::now()->toDateString())
            ->when($status == 'D', function ($query) use ($status) {
                return $query->where('queues.queue_status', $status);
            })
            ->when($status == 'T', function ($query) use ($status) {
                return $query->whereIn('queues.queue_status', ['F','D']);
            })
            ->when($status == false, function ($query) use ($status) {
                return $query->where('queues.queue_status', 'F');
            })
            ->leftJoin('ancillaryrequist as an', 'an.patients_id', 'queues.patients_id')
            ->leftJoin('cashincome as ci', 'ci.ancillaryrequist_id', 'an.id')
            ->leftJoin('patients as pt', 'pt.id', '=', 'queues.patients_id')
            ->select('queues.*', 'pt.birthday', 'pt.id as pid', 'pt.barcode', 'ci.get',
                DB::raw("CONCAT(pt.last_name,' ',pt.first_name,' ',
                                CASE WHEN pt.suffix IS NOT NULL THEN pt.suffix ELSE '' END,' ',
                                CASE WHEN pt.middle_name IS NOT NULL THEN LEFT(pt.middle_name, 1) ELSE '' END) as patient"))
            ->groupBy('queues.patients_id')
            ->get();

        //dd($patients);

        $survey = Queue::select(DB::raw("COUNT(*) as total"), 'queue_status as status')
            ->where('clinic_code', Auth::user()->clinic)
            ->whereDate(DB::raw("DATE(created_at)"), Carbon::now()->toDateString())
            ->whereIn('queue_status', ['F','D'])
            ->groupBy('queue_status')
            ->get();


        return view('radiology.patients', compact('patients', 'survey', 'status'));
    }








	public function show($id)
    {
        $patient = Patient::find($id);
        $vital = VitalSigns::where('patients_id', $id)->latest()->first();
        return view('radiology.information', compact('patient', 'vital'));
    }






	public function create()
    {
        return view('radiology.addResult');
    }












    public function store(Request $request)
    {
        $radiology = Radiology::create([
                        'patient_id' => $request->patient_id,
                        'user_id' => $request->user_id,
                        'ancillaryrequest_id' => $request->ancillaryrequest_id,
                        'result' => $request->result,
                        'imageID' => $request->imageID,
                        'clinicalData' => $request->clinicalData,
                        'physician' => $request->physician
                    ]);

        Cashincome::where('ancillaryrequist_id', $request->ancillaryrequest_id)->update(['get'=>'Y']);

        Session::flash('toaster', array('success', 'Result successfully saved.'));
        return redirect('radiology/'.$radiology->id.'/edit');
    }

















    public function edit($id)
    {
        $radiology = Radiology::where('radiology.id', $id)
                            ->leftJoin('ancillaryrequist', 'ancillaryrequist.id', 'radiology.ancillaryrequest_id')
                            ->leftJoin('cashincomesubcategory as cs', 'cs.id', 'ancillaryrequist.cashincomesubcategory_id')
                            ->leftJoin('cashincomecategory as cc', 'cc.id', 'cs.cashincomecategory_id')
                            ->leftJoin('patients as pt', 'pt.id', 'ancillaryrequist.patients_id')
                            ->select('cs.sub_category', 'cc.category', 'radiology.*', 'pt.birthday', 'pt.sex',
                                DB::raw("CONCAT(pt.last_name,' ',pt.first_name,' ',CASE WHEN pt.suffix IS NOT NULL THEN pt.suffix ELSE '' END,' ',
                                CASE WHEN pt.middle_name IS NOT NULL THEN pt.middle_name ELSE '' END) as patient"))
                            ->first();

        $ultrasound = Template::where('cc.id', 6)
            ->leftJoin('cashincomesubcategory as cs', 'cs.id', 'templates.subcategory_id')
            ->leftJoin('cashincomecategory as cc', 'cc.id', 'cs.cashincomecategory_id')
            ->select('templates.*')
            ->get();


        $xray = Template::where('cc.id', 11)
            ->leftJoin('cashincomesubcategory as cs', 'cs.id', 'templates.subcategory_id')
            ->leftJoin('cashincomecategory as cc', 'cc.id', 'cs.cashincomecategory_id')
            ->select('templates.*')
            ->get();

        return view('radiology.editResult', compact('radiology', 'ultrasound', 'xray'));
    }











    public function update(Request $request, $id)
    {
        Radiology::find($id)->update([
            'result' => $request->result,
            'imageID' => $request->imageID,
            'clinicalData' => $request->clinicalData,
            'physician' => $request->physician
        ]);
        Session::flash('toaster', array('success', 'Result successfully updated.'));
        return redirect('radiologyHome');
    }











	public function radiologyWatch(Request $request)
    {
        $radiology = Ancillaryrequist::where('ancillaryrequist.patients_id', '=', $request->pid)
                                        ->where('cc.clinic_id', Auth::user()->clinic)
                                        ->leftJoin('cashincomesubcategory as cs', 'cs.id', '=', 'ancillaryrequist.cashincomesubcategory_id')
                                        ->leftJoin('cashincome as ci', 'ci.ancillaryrequist_id', '=', 'ancillaryrequist.id')
                                        ->leftJoin('patients as pt', 'pt.id', '=', 'ancillaryrequist.patients_id')
                                        ->leftJoin('cashincomecategory as cc', 'cc.id', '=', 'cs.cashincomecategory_id')
                                        ->leftJoin('radiology', 'radiology.ancillaryrequest_id', '=', 'ancillaryrequist.id')
                                        ->leftJoin('users as us', 'us.id', '=', 'ancillaryrequist.users_id')
                                        ->leftJoin('clinics', 'clinics.id', '=', 'us.clinic')
                                        ->select('ci.get', 'cs.sub_category', 'cs.price', 'ancillaryrequist.*', 'cc.category', 'radiology.id as radiologyID', 'clinics.name as clinic',
                                            DB::raw("CONCAT(pt.last_name,' ',pt.first_name,' ',
                                            CASE WHEN pt.suffix IS NOT NULL THEN pt.suffix ELSE '' END,' ',
                                            CASE WHEN pt.middle_name IS NOT NULL THEN LEFT(pt.middle_name,1) ELSE '' END) as patient"),
                                            DB::raw("CONCAT(CASE WHEN us.first_name IS NOT NULL THEN us.first_name ELSE '' END,' ',LEFT(us.middle_name, 1),'.',' ',
                                            CASE WHEN us.last_name IS NOT NULL THEN us.last_name ELSE '' END) as requestedBy"))
                                        ->orderBy('ancillaryrequist.id', 'desc')
                                        /*->groupBy('ancillaryrequist.patients_id')*/
                                        ->get();
        return $radiology->toJson();
    }




    public function addTemplate()
    {
        $ultrasound = Template::where('cc.id', 6)
                            ->leftJoin('cashincomesubcategory as cs', 'cs.id', 'templates.subcategory_id')
                            ->leftJoin('cashincomecategory as cc', 'cc.id', 'cs.cashincomecategory_id')
                            ->select('templates.*')
                            ->get();


        $xray = Template::where('cc.id', 11)
                        ->leftJoin('cashincomesubcategory as cs', 'cs.id', 'templates.subcategory_id')
                        ->leftJoin('cashincomecategory as cc', 'cc.id', 'cs.cashincomecategory_id')
                        ->select('templates.*')
                        ->get();

        $radiology = Cashincomesubcategory::where('ci.clinic_id', Auth::user()->clinic)
                                        ->select('cashincomesubcategory.*', 'ci.category')
                                        ->leftJoin('cashincomecategory as ci', 'ci.id', 'cashincomesubcategory.cashincomecategory_id')
                                        ->orderBy('cashincomesubcategory.sub_category')
                                        ->get();
        return view('radiology.templates', compact('ultrasound', 'xray', 'radiology'));
    }







    public function storeTemplates(Request $request)
    {
        $this->validate($request, [
            'description' => 'required'
        ]);
        Template::create([
            'subcategory_id' => $request->subcategory_id,
            'description' => $request->description,
            'content' => $request->result,
        ]);
        return redirect()->back()->with('toaster', array('success', 'Template successfully added'));
    }


    public function editTemplate($id)
    {
        $ultrasound = Template::where('cc.id', 6)
            ->leftJoin('cashincomesubcategory as cs', 'cs.id', 'templates.subcategory_id')
            ->leftJoin('cashincomecategory as cc', 'cc.id', 'cs.cashincomecategory_id')
            ->select('templates.*')
            ->get();


        $xray = Template::where('cc.id', 11)
            ->leftJoin('cashincomesubcategory as cs', 'cs.id', 'templates.subcategory_id')
            ->leftJoin('cashincomecategory as cc', 'cc.id', 'cs.cashincomecategory_id')
            ->select('templates.*')
            ->get();

        $radiology = Cashincomesubcategory::where('ci.clinic_id', Auth::user()->clinic)
                ->select('cashincomesubcategory.*', 'ci.category')
                ->leftJoin('cashincomecategory as ci', 'ci.id', 'cashincomesubcategory.cashincomecategory_id')
                ->orderBy('cashincomesubcategory.sub_category')
                ->get();

        $template = Template::find($id);

        return view('radiology.editTemplate', compact('template', 'radiology', 'ultrasound', 'xray'));
    }


    public function storeEditTemplate(Request $request)
    {
        $this->validate($request, [
            'description' => 'required'
        ]);
        $template = Template::find($request->id);
        $template->subcategory_id = $request->subcategory_id;
        $template->description = $request->description;
        $template->content = $request->result;
        $template->save();
        return redirect()->back()->with('toaster', array('success', 'Template successfully edited'));
    }











    public function addResult($id = false)
    {
        $radiology = Ancillaryrequist::where('ancillaryrequist.id', $id)
                                        ->leftJoin('cashincomesubcategory as cs', 'cs.id', 'ancillaryrequist.cashincomesubcategory_id')
                                        ->leftJoin('cashincomecategory as cc', 'cc.id', 'cs.cashincomecategory_id')
                                        ->join('templates', function($join){
                                            $join->on('templates.subcategory_id', 'cs.id');
                                        })
                                        ->leftJoin('patients as pt', 'pt.id', 'ancillaryrequist.patients_id')
                                        ->select('cc.category',
                                            'cs.sub_category', 'templates.content','ancillaryrequist.*', 'pt.birthday', 'pt.sex',
                                            DB::raw("CONCAT(pt.last_name,' ',pt.first_name,' ',CASE WHEN pt.suffix IS NOT NULL THEN pt.suffix ELSE '' END,' ',
                                            CASE WHEN pt.middle_name IS NOT NULL THEN pt.middle_name ELSE '' END) as patient"))
                                        ->first();

        if ($radiology ==  null){
            $radiology = Ancillaryrequist::where('ancillaryrequist.id', $id)
                ->leftJoin('cashincomesubcategory as cs', 'cs.id', 'ancillaryrequist.cashincomesubcategory_id')
                ->leftJoin('cashincomecategory as cc', 'cc.id', 'cs.cashincomecategory_id')
                ->leftJoin('patients as pt', 'pt.id', 'ancillaryrequist.patients_id')
                ->select('cc.category',
                    'cs.sub_category', 'ancillaryrequist.*', 'pt.birthday',
                    DB::raw("CONCAT(pt.last_name,' ',pt.first_name,' ',CASE WHEN pt.suffix IS NOT NULL THEN pt.suffix ELSE '' END,' ',
                                            CASE WHEN pt.middle_name IS NOT NULL THEN pt.middle_name ELSE '' END) as patient"))
                ->first();
        }

        //dd($radiology);

        $ultrasound = Template::where('cc.id', 6)
            ->leftJoin('cashincomesubcategory as cs', 'cs.id', 'templates.subcategory_id')
            ->leftJoin('cashincomecategory as cc', 'cc.id', 'cs.cashincomecategory_id')
            ->select('templates.*')
            ->get();


        $xray = Template::where('cc.id', 11)
            ->leftJoin('cashincomesubcategory as cs', 'cs.id', 'templates.subcategory_id')
            ->leftJoin('cashincomecategory as cc', 'cc.id', 'cs.cashincomecategory_id')
            ->select('templates.*')
            ->get();

        return view('radiology.addResult', compact('radiology', 'ultrasound', 'xray'));
    }




    public function showTemplate(Request $request)
    {
        $template = Template::find($request->id);
        return $template->toJson();
    }



    public function quickView(Request $request)
    {
        $radiology = Radiology::find($request->rid);
        return $radiology->toJson();
    }


    public function radiologyResult(Request $request)
    {
        $radiology = Radiology::find($request->rid);
        return $radiology->toJson();
    }













    public function radiologySearch()
    {
        return view('radiology.search');
    }










    public function search(Request $request)
    {
        if($request->name){
            $patients = DB::table('patients')
                ->select('patients.*', 'radiology.id as rid')
                ->leftJoin('radiology', 'radiology.patient_id', 'patients.id')
                ->where(DB::raw("CONCAT(last_name,' ',first_name,' ',middle_name)"), 'like', '%'.$request->name.'%')
                ->groupBy('patients.id')
                ->get();
        }elseif ($request->birthday) {
            $patients = Patient::where('birthday', 'like', $request->birthday.'%')
                ->select('patients.*', 'radiology.id as rid')
                ->leftJoin('radiology', 'radiology.patient_id', 'patients.id')
                ->groupBy('patients.id')
                ->get();
        }elseif ($request->barcode) {
            $patients = Patient::where('barcode', 'like', '%'.$request->barcode.'%')
                ->select('patients.*', 'radiology.id as rid')
                ->leftJoin('radiology', 'radiology.patient_id', 'patients.id')
                ->groupBy('patients.id')
                ->get();
        }elseif ($request->hospital_no) {
            $patients = Patient::where('hospital_no', 'like', '%'.$request->hospital_no.'%')
                ->select('patients.*', 'radiology.id as rid')
                ->leftJoin('radiology', 'radiology.patient_id', 'patients.id')
                ->groupBy('patients.id')
                ->get();
        }elseif ($request->created_at) {
            $patients = Patient::where('created_at', 'like', $request->created_at.'%')
                ->select('patients.*', 'radiology.id as rid')
                ->leftJoin('radiology', 'radiology.patient_id', 'patients.id')
                ->groupBy('patients.id')
                ->get();
        }

        if (isset($patients) && count($patients) > 0) {
            Session::flash('toaster', array('success', 'Matching Records Found.'));
            return view('radiology.search', compact('patients'));
        }
        Session::flash('toaster', array('error', 'No Matching Records Found.'));
        return view('radiology.search');
    }






    public function history($starting = false, $ending = false)
    {
        $patients = Queue::where('clinic_code', Auth::user()->clinic)
            ->whereBetween(DB::raw("DATE(queues.created_at)"), [$starting, $ending])
            ->whereIn('queue_status', ['F','D'])
            ->leftJoin('patients as pt', 'pt.id', '=', 'queues.patients_id')
            ->select('queues.*', 'pt.birthday',
                DB::raw("CONCAT(pt.last_name,' ',pt.first_name,' ',
                                CASE WHEN pt.suffix IS NOT NULL THEN pt.suffix ELSE '' END,' ',
                                CASE WHEN pt.middle_name IS NOT NULL THEN LEFT(pt.middle_name, 1) ELSE '' END) as patient"))
            ->get();

        return view('radiology.history', compact('patients','starting', 'ending'));
    }









    public function radiologyhistory(Request $request)
    {
        return redirect("radiologyhistory/$request->starting/$request->ending");
    }







    public function radiologyPrint($rid)
    {

        $radiology = Radiology::where('radiology.id', $rid)
            ->leftJoin('patients as pt', 'pt.id', 'radiology.patient_id')
            ->select('radiology.*', 'pt.birthday','pt.sex',
                DB::raw("CONCAT(pt.last_name,' ',pt.first_name,' ',
                                            CASE WHEN pt.suffix IS NOT NULL THEN pt.suffix ELSE '' END,' ',
                                            CASE WHEN pt.middle_name IS NOT NULL THEN LEFT(pt.middle_name,1) ELSE '' END) as patient"))
            ->first();


        $dateQueue = Ancillaryrequist::find($radiology->ancillaryrequest_id);

        $style = array('width' => .1, 'cap' => 'square', 'color' => array(0, 0, 0));


        $pdf = new PdfFile();
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
        $pdf->SetMargins(5,5,5,5);
        $pdf->SetFooterMargin(5);
        $pdf->SetAutoPageBreak(TRUE, 10);
        $pdf->SetTitle('Radiology');
        $pdf->AddPage('P','letter');
        $pdf->SetFont('times','');


        $pdf->SetXY(83,5);
        $pdf->Cell(45,1,'Republic of the Philippines',0,0,'C',false,'',2,false,'T');
        $pdf->SetXY(86,10);
        $pdf->Cell(40,1,'Department of Health',0,0,'C',false,'',2,false,'T');
        $pdf->SetXY(68,15);
        $pdf->Cell(75,1,'Department of Health Regional Office No. 8',0,0,'C',false,'',2,false,'T');
        $pdf->SetXY(55,20);
        $pdf->Cell(100,1,'EASTERN VISAYAS REGIONAL MEDICAL CENTER',0,0,'C',false,'',2,false,'T');
        $pdf->SetXY(93,25);
        $pdf->Cell(25,1,'Tacloban City',0,0,'C',false,'',2,false,'T');
        $pdf->SetXY(65,30);
        $pdf->Cell(80,1,'(053)832-0308;evrmcmccoffice@gmail.com',0,0,'C',false,'',2,false,'T');
        $pdf->SetXY(70,40);
        $pdf->SetFont('times','I');
        $pdf->Cell(78,1,'"PHIC Accredited Health Care Provider"',0,0,'C',false,'',2,false,'T');
        $pdf->SetFont('times','B',18);
        $pdf->SetXY(70,50);
        $pdf->Image('./public/images/doh-logo.png',20,10,35);
        $pdf->Image('./public/images/evrmc-logo.png',160,10.5,25);

        $pdf->SetFont('times','N',11);
        $pdf->SetXY(5,50);

        $table = \View::make('radiology.print', compact('radiology', 'dateQueue'));
        $pdf->writeHTML($table, true, false, false, false, '');

        $pdf->SetXY(5,100);
        $pdf->writeHTML($radiology->result, true, false, false, false, '');


        $pdf->SetXY(5,100);
        $pdf->writeHTML($radiology->result, true, false, false, false, '');

        $pdf->Output();

    }







}
