<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Malasakit;

use App\Patient;
use App\Mss;
use App\Mssclassification;
use App\Mssdiagnosis;
use App\Mssexpenses;
use App\Msshouseexpenses;
use App\Mssfamily;
use App\User;
use App\Malasakitfamily;
use App\Refbrgy;
use Validator;
use DB;
use Auth;
use PDF;
use Carbon\Carbon;
use Session;

/**
* 
*/
class MalasakitController extends Controller
{
  public function index()
  {
    return view('malasakit.main');
  }
  public function checkpatient(Request $request)
  {
    $checkpatient = Patient::where('barcode', '=', $request->credentials)
                            ->orWhere('hospital_no', '=', $request->credentials)->first();
            if ($checkpatient) {
                $checkmss = Mssclassification::where('patients_id', '=', $checkpatient->id)->first();
                  // dd($checkmss);
                    if ($checkmss) {
                        if ($checkmss->validity >= Carbon::now()->format('Y-m-d')) {
                            $medicine = DB::select("SELECT f.*, d.id, d.last_name, d.first_name, d.middle_name, SUM(a.qty * c.price) as amount, COUNT(*) as result
                                                    FROM pharmanagerequest a 
                                                    LEFT JOIN requisition b ON a.requisition_id = b.id
                                                    LEFT JOIN ancillary_items c ON b.item_id = c.id
                                                    LEFT JOIN patients d ON b.patients_id = d.id
                                                    LEFT JOIN mssclassification e ON b.patients_id = e.id
                                                    LEFT JOIN mss f ON e.mss_id = f.id
                                                    WHERE a.id NOT IN(SELECT pharmanagerequest_id FROM sales)
                                                    AND f.id NOT IN(9,10,11,12,13,14,15)
                                                    AND b.patients_id = ?
                                                    GROUP BY b.patients_id  
                                                    ORDER BY `amount`  DESC
                                                  ", [$checkpatient->id]);
                            MalasakitController::malasakitprint($checkmss->id, $medicine);
                        }else{
                            return redirect()->back()->with('toaster', array('error', 'Patient MSS Classification Expired (' .Carbon::parse($checkmss->validity)->format('M/d/Y'). ')'));
                        }
                    }else{
                        return redirect()->back()->with('toaster', array('error', 'Patient is not MSS Classified'));
                    }
               
            }else{
                return redirect()->back()->with('toaster', array('error', 'Patient not found.'));
            }
  }
	public function malasakit($id)
	{
	  $patient = DB::table('mssclassification')
	        ->leftJoin('patients', 'mssclassification.patients_id', '=', 'patients.id')
	        ->leftJoin('mssdiagnosis', 'mssclassification.id', '=', 'mssdiagnosis.classification_id')
	        ->leftJoin('mssexpenses', 'mssclassification.id', '=', 'mssexpenses.classification_id')
	        ->leftJoin('msshouseexpenses', 'mssclassification.id', '=', 'msshouseexpenses.classification_id')
	        ->leftJoin('mss', 'mssclassification.mss_id', '=', 'mss.id')
	        ->leftJoin('malasakit', 'mssclassification.id', '=', 'malasakit.classification_id')
	        ->where('mssclassification.id', '=', $id)
	        ->get()
	        ->first();
	  $fam = DB::select("SELECT * 
	  					FROM malasakitfamily a 
	  					LEFT JOIN mssfamily b ON a.mssfamily_id = b.id
	  					WHERE b.patient_id = ?
	  					", [$patient->patients_id]);
	  if (COUNT($fam) > 0) {
	  	$family = $fam;
	  }else{
	  	$family = Mssfamily::where('patient_id', $patient->patients_id)->get();
	  }
	                       
	  return view('mss.malasakitform', compact('patient', 'family', 'id'));
	}
	public function malasakitsave(Request $request)
	{
		$request->request->add(['classification_id' => $request->classification_id]);
		$id = $request->classification_id;

		/*==================for mssclassification tb==================*/
      	$mssclassification = Mssclassification::find($id);
      	$mssclassification->fill($request->all());
      	$mssclassification->save();

      	/*=====================for malasakit tb===============================*/
      	$malasakit = Malasakit::where('classification_id', $id)->first();
      	if ($malasakit) {
      		$mlkst = $malasakit; 
      	}else{
      		$mlkst = new Malasakit();
      	}
      	$mlkst->classification_id = $request->classification_id;
      	$mlkst->users_id = Auth::user()->id;
      	$mlkst->mlkstinterviewed = $request->mlkstinterviewed;
      	$mlkst->mlkstrelpatient = $request->mlkstrelpatient;
      	$mlkst->mlkstaddress = $request->mlkstaddress;
      	$mlkst->mlkstcontact = $request->mlkstcontact;
      	$mlkst->mlkstnationality = $request->mlkstnationality;
      	$sect = "";
      	if ($request->mlkstsectorial) {
		      	if (count($request->mlkstsectorial) > 0) {
			      	foreach ($request->mlkstsectorial as $key => $u) {
			      		$sect.=$request->mlkstsectorial[$key].",";
			      	}
			    $mlkst->mlkstsectorial = $sect;
		      	}
      	}
      	$mlkst->mlksttfincome = $request->mlksttfincome;

      	$prob = "";
      	if ($request->mlkstproblem) {
      		if (count($request->mlkstproblem) > 0) {
		      	foreach ($request->mlkstproblem as $key => $u) {
		      		$prob.=$request->mlkstproblem[$key].",";
		      	}
		      	$mlkst->mlkstproblem = $prob;
	      	}
      	}
      	$mlkst->mlkstassesment = $request->mlkstassesment;
	  	$mlkst->save();

      /*==================for mssdiagnoses tb================================*/
      	$mssDiagnosis = Mssdiagnosis::where('classification_id', $id)->first();
      	if ($mssDiagnosis){
        	$mssDiagnosis->fill($request->all());
        	$mssDiagnosis->save();
      	}else{
        	$diagnosis = new Mssdiagnosis();
        	$columns = $diagnosis->getColumn();
        	$mssDiagnos = false;
        	foreach ($columns as $row) {
            	if ($request->$row && $row != 'classification_id'){
                  	$mssDiagnos = true;
            	}
        	}
	        if ($mssDiagnos){
	          	Mssdiagnosis::create($request->all());
	        }
   		}
   		/*==================ffor mssexpenses tb*/
    	$Mssexpenses = Mssexpenses::where('classification_id', $id)->get()->first();
    	if ($Mssexpenses){
        	$Mssexpenses->fill($request->all());
        	$Mssexpenses->save();
    	}else{
	        $expenses = new Mssexpenses();
	        $excolumns = $expenses->getColumn();
	        $mssExpense = false;
        	foreach ($excolumns as $row) {
	            if ($request->$row && $row != 'classification_id'){
	                $mssExpense = true;
	            }
	        }
	        if ($mssExpense){
	          	Mssexpenses::create($request->all());
	        }
    	}
    	$Msshouseexpenses = Msshouseexpenses::where('classification_id', $id)->get()->first();
    	if ($Msshouseexpenses) {
    		$houseexp = $Msshouseexpenses; 
    	}else{
        	$houseexp = new Msshouseexpenses();
    	}
	    if ($request->houselot != "" || $request->light != "" || $request->water != "" || $request->fuel != "") {
	     	$houseexp->classification_id = $id;
	     	$houseexp->monthly_expenses = $request->monthly_expenses;
	     	$houseexp->monthly_expenditures = $request->monthly_expenditures;
	     	$houseexp->houselot = $request->houselot;
	     	$houseexp->light = $request->light;
	     	$houseexp->water = $request->water;
	     	$houseexp->fuel = $request->fuel;
	     	$houseexp->save();
	    }
        foreach ($request->name as $key => $u) {
            if ($request->id[$key]) {
              $mssfamily = Mssfamily::find($request->id[$key]);
            }
            else{
              $mssfamily = new Mssfamily();
            }
            if ($request->name[$key] != "") {
  	          $mssfamily->patient_id = $request->patients_id;
  	          $mssfamily->name = $request->name[$key];
  	          $mssfamily->age = $request->age[$key];
  	          $mssfamily->status = $request->status[$key];
  	          $mssfamily->relationship = $request->relationship[$key];
  	          $mssfamily->feducation = $request->feducation[$key];
  	          $mssfamily->foccupation = $request->foccupation[$key];
  	          $mssfamily->fincome = $request->fincome[$key];
  	          $mssfamily->save();


  	          	$mlkstfam = Malasakitfamily::where('mssfamily_id', '=', $mssfamily->id)->first();
  	          	if ($mlkstfam) {
            	  	$mlkstfam->birthday = $request->birthday[$key];
            	  	$mlkstfam->sex = $request->sex[$key];
            	  	$mlkstfam->save();
  	          	}else{
	      	        $mlkstf = new Malasakitfamily();
	      	        $mlkstf->mssfamily_id = $mssfamily->id;
                	$mlkstf->birthday = $request->birthday[$key];
                	$mlkstf->sex = $request->sex[$key];
                	$mlkstf->save();
             	}
            }
            

        }
      	$request->session()->flash('toaster', array('success', 'Success'));
      	return redirect('mss');
	}
	public function malasakitprint($id)
	{
		$patient = DB::table('mssclassification')
          ->select('*', 'patients.created_at')
		      ->leftJoin('patients', 'mssclassification.patients_id', '=', 'patients.id')
		      ->leftJoin('mssdiagnosis', 'mssclassification.id', '=', 'mssdiagnosis.classification_id')
		      ->leftJoin('mssexpenses', 'mssclassification.id', '=', 'mssexpenses.classification_id')
		      ->leftJoin('msshouseexpenses', 'mssclassification.id', '=', 'msshouseexpenses.classification_id')
		      ->leftJoin('mss', 'mssclassification.mss_id', '=', 'mss.id')
		      ->leftJoin('malasakit', 'mssclassification.id', '=', 'malasakit.classification_id')
		      ->where('mssclassification.id', '=', $id)
		      ->get()
		      ->first();
    $brgy = Refbrgy::find($patient->brgy);
    $address = DB::select("SELECT a.citymunDesc, a.district, b.provDesc, c.regDesc
                          FROM refcitymun a
                          LEFT JOIN refprovince b ON a.provCode = b.provCode
                          LEFT JOIN refregion c ON b.regCode = c.regCode
                          WHERE a.citymunCode = ?
                          ", [$patient->city_municipality]);

		$user = User::find($patient->users_id);
		$fam = DB::select("SELECT * 
							FROM malasakitfamily a 
							LEFT JOIN mssfamily b ON a.mssfamily_id = b.id
							WHERE b.patient_id = ?
							", [$patient->patients_id]);
		if (COUNT($fam) > 0) {
			$family = $fam;
		}else{
			$family = Mssfamily::where('patient_id', $patient->patients_id)->get();
		}
		// dd($patient);
		PDF::SetTitle('GENERAL INTAKE SHEET');
		// PDF::IncludeJS("print();");
		PDF::SetAutoPageBreak(TRUE, 0);
		PDF::AddPage();
		PDF::Image('./public/images/malasakit.jpg',150,0,51);
		PDF::SetFont('', 'B', 23);
		PDF::text(15,15,"GENERAL INTAKE SHEET");

		PDF::SetFont('', 'B', 17);
		PDF::text(15,30,"MALASAKIT CENTER");
		PDF::SetFont('', '', 8.5);
    PDF::text(15,36,"EASTERN VISAYAS REGIONAL MEDICAL CENTER");
		PDF::text(135,41,"Case Number ________________________");
	

		$table = "<table>
            	 </table>";
        $y = PDF::getY()-5;
        PDF::Rect(15, $y+11, 180, 237);
        // PDF::writeHTMLCell(180, 235, 15, $y+11, $table, 1, 0);
        // PDF::writeHTMLCell(180.3, 235, 15, $y+11.3, $table, 1, 0);
       
         $style = array('width' => 0.1, 'color' => array(0, 0, 0));
        // $y = PDF::getY()-1;
        $y = PDF::getY()+5;
       	PDF::text(17,49,"Date of Intake/Interview");
       	PDF::text(78,48,"".Carbon::parse()->now()->format('d/m/Y')."");/*=================================dateofintake*/
       	PDF::Line(60,  $y+5.5, 115,  $y+5.5, $style);
       	PDF::text(120,49,"Time of Interview");
       	// PDF::text(155,48,"");/*================================timeofintake*/
       	PDF::Line(60,  $y+14.5, 115,  $y+14.5, $style);


       	PDF::text(17,58,"Name of Informant");
       	// PDF::text(70,57.5,"")/*================================informant*/;
       	PDF::Line(150,  $y+5.5, 190,  $y+5.5, $style);
		    PDF::text(120,58,"Relation to Patient");
		    // PDF::text(155,57.5,"")/*================================relationship*/;
       	PDF::Line(150,  $y+14.5, 190,  $y+14.5, $style);


       	PDF::Line(17,  $y+24.5, 145,  $y+24.5, $style);
       	PDF::Line(147,  $y+24.5, 148,  $y+21.5, $style);
       	PDF::Line(150,  $y+24.5, 190,  $y+24.5, $style);
		    // PDF::text(50,67.5,"".$patient->mlkstaddress."")/*================================address*/;
		    // PDF::text(155,67.5,"".$patient->mlkstcontact."")/*================================contact*/;
       	PDF::SetFont('', '', 7);
       	PDF::text(80,52,"dd/mm/yyyy");
       	PDF::text(80,61,"Full Name");
       	PDF::text(80,71,"Address");
       	PDF::text(160,71,"Contact Number");


       	PDF::SetFont('', 'B', 9);
       	PDF::SetFillColor(220, 220, 220);
        PDF::SetXY(15,75);
       	PDF::Cell(180,5,"I. IDENTIFYING INFORMATION",1,0,'',true);



       	PDF::SetFont('', '', 8.5);
       	PDF::text(17,83,"Client's Name");
       	PDF::Line(60,  $y+39.6, 145,  $y+39.6, $style);
        // $y = PDF::getY()-1.2;
        PDF::SetXY(60,$y+35.5);
        PDF::Cell(20,5,"".$patient->last_name.",",0,0,'C')/*==============================last name===========================*/;
        PDF::SetXY(80,$y+35.5);
        PDF::Cell(20,5,"".$patient->first_name."",0,0,'C')/*==============================first name===========================*/;
        PDF::SetXY(100,$y+35.5);
        PDF::Cell(23,5,"".$patient->middle_name."",0,0,'C')/*==============================middle name===========================*/;
        PDF::SetXY(120,$y+35.5);
        PDF::Cell(23,5,"".$patient->suffix."",0,0,'C')/*==============================middle name===========================*/;
       	PDF::Line(147,  $y+39.6, 148,  $y+36.6, $style);
       	PDF::Line(150,  $y+39.6, 190,  $y+39.6, $style);
        PDF::SetXY(150,$y+35.5);
        PDF::Cell(40,5,"".($patient->gender == 'M')?"MALE":"FEMALE"."",0,0,'C')/*=====================patient gender=========================*/;
       	PDF::SetFont('', '', 7);
       	$y = $y+39.6;
       	PDF::text(62,$y+.2,"Last Name      ,       First Name           Middle Name           Ext(Sr, Jr.)                                         Gender");




       	PDF::SetFont('', '', 8.5);
        PDF::SetXY(17,$y+6.5);
        PDF::Cell(39,5,"".Carbon::parse($patient->birthday)->format('d/m/Y')."",0,0,'C')/*=====================DATEOFBIRTH=========================*/;
       	PDF::Line(17,  $y+10.6, 56,  $y+10.6, $style);
       	PDF::Line(58,  $y+10.6, 59,  $y+7.5, $style);
        $agePatient = Patient::age($patient->birthday);
        PDF::SetXY(60,$y+6.5);
        PDF::Cell(41,5,"".$agePatient."",0,0,'C')/*=====================age=========================*/;
       	PDF::Line(60,  $y+10.6, 101,  $y+10.6, $style);
       	PDF::Line(103,  $y+10.6, 104,  $y+7.5, $style);
        PDF::SetXY(105,$y+6.5);
        PDF::Cell(85,5,"".$patient->pob."",0,0,'C')/*=====================pob=========================*/;
       	PDF::Line(105,  $y+10.6, 190,  $y+10.6, $style);
       	PDF::SetFont('', '', 7);
       	PDF::text(20,$y+10.7,"Date of Birth(dd/mm/yyyy)                          
       						Age                                                                        
       						Place of Birth");
       	$y = $y+10.7;
        // dd($patient);
        // $address
       	PDF::SetFont('', '', 8.5);
       	PDF::text(17,$y+5,"Permanent Address : ");
        PDF::SetXY(50,$y+5);
        PDF::Cell(140,5,"".$brgy->brgyDesc.", ".$address[0]->citymunDesc.", ".$address[0]->district.", ".$address[0]->provDesc.", ".$address[0]->regDesc."",0,0,'')/*=====================PERMANENT ADDRESS=========================*/;
       	PDF::Line(17,$y+9.2, 190,  $y+9.2, $style);
       	PDF::text(17,$y+15,"Present Address : ");
        // PDF::SetXY(50,$y+15);
        // PDF::Cell(140,5,"".$brgy->brgyDesc.", ".$address[0]->citymunDesc.", ".$address[0]->district.", ".$address[0]->provDesc.", ".$address[0]->regDesc."",0,0,'')/*=====================PRESENT ADDRESS=========================*/;
       	PDF::Line(17,$y+19.2, 190,  $y+19.2, $style);
       	PDF::SetFont('', '', 7);
       	PDF::text(85,$y+10,"St. Number, Barangay, City/Municipality, District, Province, Region");
       	PDF::text(85,$y+20,"St. Number, Barangay, City/Municipality, District, Province, Region");


       	$y = $y+20;
       	// dd($patient->civil_statuss);
       	$border_style = array('all' => array('width' => 0.1, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'phase' => 0));

       	PDF::SetFont('', '', 8.5);
       	PDF::SetFillColor(127);
       	if ($patient->civil_statuss == "Single") {
       		PDF::Rect(41, $y+5, 3.5, 3.5, 'DF', $border_style);/*Single*/
       	}else{
       		PDF::Rect(41, $y+5, 3.5, 3.5);
       	}
       	if ($patient->civil_statuss == "Married") {
       		PDF::Rect(62, $y+5, 3.5, 3.5, 'DF', $border_style);/*Married*/
       	}else{
       		PDF::Rect(62, $y+5, 3.5, 3.5);/*Married*/
       	}
       	if ($patient->civil_statuss == "Widow") {
       		PDF::Rect(85, $y+5, 3.5, 3.5, 'DF', $border_style);/*Widow*/
       	}else{
       		PDF::Rect(85, $y+5, 3.5, 3.5);/*Widow*/
       	}
       	if ($patient->civil_statuss == "Sep-legal" || $patient->civil_statuss == "Sep-fact") {
       		PDF::Rect(119, $y+5, 3.5, 3.5, 'DF', $border_style);/*Sep-legal Sep-fact*/
       	}else{
       		PDF::Rect(119, $y+5, 3.5, 3.5);/*Sep-legal Sep-fact*/
       	}
       	if ($patient->civil_statuss == "Child" || $patient->civil_statuss == "minor" || $patient->civil_statuss == "Common-law" || $patient->civil_statuss == "Unwed" ||  $patient->civil_statuss == "Divorce") {
       		PDF::Rect(182, $y+5, 3.5, 3.5, 'DF', $border_style);/**/
       	}else{
       		PDF::Rect(182, $y+5, 3.5, 3.5);/**/
       	}
       
       
       	
       	
       	
       	PDF::text(17,$y+5,"Civil Status : ");
       	PDF::text(45,$y+5,"Single
       						Married
       						Widow/Widower
       						Separated with Common Law Partner
       						Other");
       	PDF::text(17,$y+12,"Religion : ");
        PDF::SetXY(32,$y+12);
        PDF::Cell(72,5,"".$patient->religion."",0,0,'')/*=====================RELIGION=========================*/;
       	PDF::Line(32,$y+16.1, 103,  $y+16.1, $style);
       	PDF::text(105,$y+12,"Nationality : ");
        PDF::SetXY(125,$y+12);
        PDF::Cell(65,5,"".$patient->mlkstnationality."",0,0,'')/*=====================NATIONALITY=========================*/;
        PDF::Line(32,$y+16.1, 103,  $y+16.1, $style);
       	PDF::Line(125,$y+16.1, 190,  $y+16.1, $style);

       	$y = $y+16.1;
       	// dd($patient->education);
       	if ($patient->education == "Post-graduate") {
       	PDF::Rect(66, $y+5, 3.5, 3.5, 'DF', $border_style);/*pg*/
       	}else{
       	PDF::Rect(66, $y+5, 3.5, 3.5);/*pg*/
       	}
       	if ($patient->education == "College") {
       	PDF::Rect(98, $y+5, 3.5, 3.5, 'DF', $border_style);/*College*/
       	}else{
       	PDF::Rect(98, $y+5, 3.5, 3.5);/*College*/	
       	}
       	if ($patient->education == "High School") {
       	PDF::Rect(121, $y+5, 3.5, 3.5, 'DF', $border_style);/*hs*/
       	}else{
       	PDF::Rect(121, $y+5, 3.5, 3.5);/*hs*/	
       	}
       	if ($patient->education == "Elementary") {
       	PDF::Rect(149, $y+5, 3.5, 3.5, 'DF', $border_style);/*elementary*/
       	}else{
       	PDF::Rect(149, $y+5, 3.5, 3.5);/*elementary*/	
       	}
       	if ($patient->education == "Vocational") {
       	PDF::Rect(177, $y+5, 3.5, 3.5, 'DF', $border_style);/*Vocational*/
       	}else{
       	PDF::Rect(177, $y+5, 3.5, 3.5);/*Vocational*/	
       	}
       	if ($patient->education == " ") {
       	PDF::Rect(177, $y+5, 3.5, 3.5, 'DF', $border_style);/**/
       	}else{
       	PDF::Rect(177, $y+5, 3.5, 3.5);/**/	
       	}
       	
       	

       	PDF::text(17,$y+5,"Highest Educational Attainment : ");
       	PDF::text(70,$y+5,"Post-graduate
       						College
       						High School
       						Elementary
       						None");
       	PDF::text(17,$y+10,"Occupation : ");
       	PDF::text(35,$y+10,"".$patient->occupation."");/*================occupation*/
       	PDF::Line(36,$y+13.3, 103,  $y+13.3, $style);
       	PDF::text(105,$y+10,"Monthly Income : ");
       	PDF::text(130,$y+10,"".$patient->income."");/*====================mincome*/
       	PDF::Line(130,$y+13.3, 190,  $y+13.3, $style);


       	$y = $y+13.3;

       	PDF::text(17,$y+3,"Sectorial Membership : ");
       	PDF::SetFont('', '', 8);
       	$sectorial = explode(",", $patient->mlkstsectorial);
       	if (in_array(1, $sectorial)):
       		PDF::Rect(21, $y+7, 3, 3, 'DF', $border_style);/*1*/
       	else:
       		PDF::Rect(21, $y+7, 3, 3);/*1*/
       	endif;
       	if (in_array(2, $sectorial)):
       		PDF::Rect(21, $y+12, 3, 3, 'DF', $border_style);/*2*/
       	else:
       		PDF::Rect(21, $y+12, 3, 3);/*2*/
       	endif;
       	if (in_array(3, $sectorial)):
       		PDF::Rect(21, $y+17, 3, 3, 'DF', $border_style);/*3*/
       	else:
       		PDF::Rect(21, $y+17, 3, 3);/*3*/
       	endif;
       	if (in_array(4, $sectorial)):
       		PDF::Rect(21, $y+22, 3, 3, 'DF', $border_style);/*4*/
       	else:
       		PDF::Rect(21, $y+22, 3, 3);/*4*/
       	endif;
       	if (in_array(5, $sectorial)):
       		PDF::Rect(21, $y+27, 3, 3, 'DF', $border_style);/*5*/
       	else:
       		PDF::Rect(21, $y+27, 3, 3);/*5*/
       	endif;
       	if (in_array(6, $sectorial)):
       		PDF::Rect(104, $y+7, 3, 3, 'DF', $border_style);/*6*/
       	else:
       		PDF::Rect(104, $y+7, 3, 3);/*6*/
       	endif;
       	if (in_array(7, $sectorial)):
       		PDF::Rect(104, $y+12, 3, 3, 'DF', $border_style);/*7*/
       	else:
       		PDF::Rect(104, $y+12, 3, 3);/*7*/
       	endif;
        if (in_array(8, $sectorial)):
        	PDF::Rect(104, $y+17, 3, 3, 'DF', $border_style);/*8*/
       	else:
       		PDF::Rect(104, $y+17, 3, 3);/*8*/
       	endif;
       	if (in_array(9, $sectorial)):
       		PDF::Rect(104, $y+22, 3, 3, 'DF', $border_style);/*9*/
       	else:
       		PDF::Rect(104, $y+22, 3, 3);/*9*/
       	endif;
       	if (in_array(10, $sectorial)):
       		PDF::Rect(104, $y+27, 3, 3, 'DF', $border_style);/*10*/
       	else:
       		PDF::Rect(104, $y+27, 3, 3);/*10*/
       	endif;
       	if (in_array(11, $sectorial)):
       		PDF::Rect(151, $y+7, 3, 3, 'DF', $border_style);/*11*/
       	else:
       		PDF::Rect(151, $y+7, 3, 3);/*11*/
       	endif;
       	if (in_array(12, $sectorial)):
       		PDF::Rect(151, $y+12, 3, 3, 'DF', $border_style);/*12*/
       	else:
       		PDF::Rect(151, $y+12, 3, 3);/*12*/
       	endif;
       	if (in_array(13, $sectorial)):
       		PDF::Rect(151, $y+17, 3, 3, 'DF', $border_style);/*13*/
       	else:
       		PDF::Rect(151, $y+17, 3, 3);/*13*/
       	endif;
       	if (in_array(14, $sectorial)):
       		PDF::Rect(151, $y+22, 3, 3, 'DF', $border_style);/*14*/
       	else:
       		PDF::Rect(151, $y+22, 3, 3);/*14*/
       	endif;
       	if (in_array(15, $sectorial)):
       		PDF::Rect(151, $y+27, 3, 3, 'DF', $border_style);/*15*/
       	else:
       		PDF::Rect(151, $y+27, 3, 3);/*15*/
       	endif;
       

       	

       	
       
       	
       	
       	

       	PDF::text(25,$y+7,"Children in need of special protection                               
       						Inmate                                 
       						Personnel");
       	PDF::text(25,$y+12,"Youth in need of special protection                                   
       						Senior Citizen                      
       						Personnel Dependent");
       	PDF::text(25,$y+17,"Women in Especially Difficult Circumstance                     
       						Person With Disablity           
       					4Ps");
       	PDF::text(25,$y+22,"Family Head & Other Needy Adult                                    
       						Barangay Official                  
       					Gov't Employee");
       	PDF::text(25,$y+27,"Indegenous People                                                           
       						BHW                                     
       					Others (specify):");

       	$y = $y+27;
       	PDF::SetFont('', 'B', 9);
       	PDF::SetFillColor(220, 220, 220);
       	PDF::SetXY(15,$y+5);
       	PDF::Cell(180,5,"II. BENEFICIARIES INFORMATION (for DSWD / PCSO use only)",1,0,'',true);

       	$y = $y+5;
       	PDF::Rect(72, $y+5.5, 3, 3);
       	PDF::Rect(106.5, $y+5.5, 3, 3);

       	PDF::Rect(22, $y+10, 3, 3);/*==========================3*/
       	PDF::Rect(22, $y+15, 3, 3);/*==========================4*/
       	PDF::Rect(22, $y+25, 3, 3);/*==========================5*/
       	PDF::Rect(22, $y+30, 3, 3);/*==========================6*/
       	PDF::Rect(22, $y+35, 3, 3);/*==========================7*/

       	PDF::Rect(52, $y+15, 3, 3);/*==========================8*/
       	PDF::Rect(52, $y+20, 3, 3);/*==========================9*/

       	PDF::Rect(47, $y+40, 3, 3);/*==========================10*/
       	PDF::Rect(47, $y+45, 3, 3);/*==========================11*/
       	PDF::Rect(47, $y+50, 3, 3);/*==========================12*/
       	PDF::Rect(47, $y+55, 3, 3);/*==========================13*/
       	PDF::Rect(47, $y+60, 3, 3);/*==========================14*/

       	PDF::Rect(74, $y+40, 3, 3);/*==========================15*/
       	PDF::Rect(74, $y+45, 3, 3);/*==========================16*/
       	PDF::Rect(74, $y+50, 3, 3);/*==========================17*/
       	PDF::Rect(74, $y+55, 3, 3);/*==========================18*/

       	PDF::Rect(103, $y+10, 3, 3);/*==========================19*/
       	PDF::Rect(103, $y+15, 3, 3);/*==========================20*/
       	PDF::Rect(103, $y+20, 3, 3);/*==========================21*/
       	PDF::Rect(103, $y+25, 3, 3);/*==========================22*/
       	PDF::Rect(103, $y+30, 3, 3);/*==========================23*/
       	PDF::Rect(103, $y+35, 3, 3);/*==========================24*/
       	PDF::Rect(103, $y+40, 3, 3);/*==========================25*/
       	PDF::Rect(103, $y+45, 3, 3);/*==========================26*/
       	PDF::Rect(103, $y+50, 3, 3);/*==========================27*/
       	PDF::Rect(103, $y+55, 3, 3);/*==========================28*/
     

       	PDF::SetFont('', '', 8.5);
       	PDF::text(17,$y+5,"Nature of Assistance Requested");
       	PDF::SetFont('', '', 8);
       	PDF::text(75,$y+5,"In - Patient           
       						Out - Patient");
       	PDF::text(25,$y+10,"Confinement                                                                    
       						Laboratory/Diagnostic Procedure (specify)");
       	PDF::text(25,$y+15,"Dialysis           
       						Hemodialysis                             
       						Medical Device (pacemaker, stent etc)");
       	PDF::text(55,$y+20,"Peritoneal                                  
       						Surgical Supplies");
       	PDF::text(25,$y+25,"Chemotherapy                                                                 
       						Implant (bone, cochlear, etc)");
       	PDF::text(25,$y+30,"Radiation Therapy                                                           
       						Assistive Device (hearing aid, wheelchair, prosthesis)");
       	PDF::text(25,$y+35,"Medicines                                                                        
       						Non & Minimally Non-invasive Procedures");
       	PDF::text(50,$y+40,"Medicines   
       						Psyhchiatric   
       						(ESWL, Endoscopy, Laparoscopic procedure, etc)");
       	PDF::text(50,$y+45,"Post-Op      
       						Post Transplant
       			Transplant (Specify)");
       	PDF::text(50,$y+50,"Factor 8,9   
       						Antibiotics      
       						Rehabilative Therapy (Physical, Occupational, Speech)");
       	PDF::text(50,$y+55,"OR Medicines
       			IVIG               
       						Other (specify)");
       	PDF::text(50,$y+60,"Other (specify)");

       	$y = $y+60;
       	PDF::SetFont('', 'B', 9);
       	PDF::SetFillColor(220, 220, 220);
       	PDF::SetXY(15,$y+4);
       	PDF::Cell(180,5,"III. FAMILY COMPOSITION",1,0,'',true);

       	$y = $y+5;
       	PDF::SetFont('', '', 6.5);

       	PDF::SetXY($x=16,$y+5);
       	PDF::Cell($cell=42,4,"Last Name/First Name/Middle Name",1,0,'C');

       	PDF::SetXY($x+$cell,$y+5);
       	PDF::Cell(15,4,"Birthdate",1,0,'C');

       	PDF::SetXY($x+$cell+15,$y+5);
       	PDF::Cell(8,4,"Sex",1,0,'C');

       	PDF::SetXY($x+$cell+15+8,$y+5);
       	PDF::Cell(14,4,"Civil Status",1,0,'C');

       	PDF::SetXY($x+$cell+15+8+14,$y+5);
       	PDF::Cell(22,4,"Relation to Patient",1,0,'C');

       	PDF::SetXY($x+$cell+15+8+14+22,$y+5);
       	PDF::Cell(35,4,"Highest Educational Attainment",1,0,'C');

       	PDF::SetXY($x+$cell+15+8+14+22+35,$y+5);
       	PDF::Cell(21,4,"Occupation",1,0,'C');

       	PDF::SetXY($x+$cell+15+8+14+22+35+21,$y+5);
       	PDF::Cell(21,4,"Monthly Income",1,0,'C');


       	$l = 0;
       	foreach ($family as $list) {
       		$y = $y+3.3;
       		PDF::SetXY($x=16,$y+5.6);
       		PDF::Cell($cell=42,3.3,"".$list->name."",1,0,'C');

       		PDF::SetXY($x+$cell,$y+5.6);
       		PDF::Cell(15,3.3,"".$list->birthday."",1,0,'C');

       		PDF::SetXY($x+$cell+15,$y+5.6);
       		PDF::Cell(8,3.3,"".$list->sex."",1,0,'C');

       		PDF::SetXY($x+$cell+15+8,$y+5.6);
       		PDF::Cell(14,3.3,"".$list->status."",1,0,'C');

       		PDF::SetXY($x+$cell+15+8+14,$y+5.6);
       		PDF::Cell(22,3.3,"".$list->relationship."",1,0,'C');

       		PDF::SetXY($x+$cell+15+8+14+22,$y+5.6);
       		PDF::Cell(35,3.3,"".$list->feducation."",1,0,'C');

       		PDF::SetXY($x+$cell+15+8+14+22+35,$y+5.6);
       		PDF::Cell(21,3.3,"".$list->foccupation."",1,0,'C');

       		PDF::SetXY($x+$cell+15+8+14+22+35+21,$y+5.6);
       		PDF::Cell(21,3.3,"".$list->fincome."",1,0,'C');
       		$l++;
       	}

       	for ($i=$l; $i <= 8; $i++) { 
       		$y = $y+3.3;
       		PDF::SetXY($x=16,$y+5.6);
       		PDF::Cell($cell=42,3.3,"",1,0,'C');

       		PDF::SetXY($x+$cell,$y+5.6);
       		PDF::Cell(15,3.3,"",1,0,'C');

       		PDF::SetXY($x+$cell+15,$y+5.6);
       		PDF::Cell(8,3.3,"",1,0,'C');

       		PDF::SetXY($x+$cell+15+8,$y+5.6);
       		PDF::Cell(14,3.3,"",1,0,'C');

       		PDF::SetXY($x+$cell+15+8+14,$y+5.6);
       		PDF::Cell(22,3.3,"",1,0,'C');

       		PDF::SetXY($x+$cell+15+8+14+22,$y+5.6);
       		PDF::Cell(35,3.3,"",1,0,'C');

       		PDF::SetXY($x+$cell+15+8+14+22+35,$y+5.6);
       		PDF::Cell(21,3.3,"",1,0,'C');

       		PDF::SetXY($x+$cell+15+8+14+22+35+21,$y+5.6);
       		PDF::Cell(21,3.3,"",1,0,'C');
       	}

       	
       	$style = array('width' => 0.5, 'color' => array(0, 0, 0));
        $y = 55;
        PDF::Line(15,  $y, 195,  $y, $style);
        PDF::Line(15,  $y+10, 195,  $y+10, $style);
        PDF::Line(15, $y+20, 195, $y+20, $style);
        PDF::Line(15, $y+25, 195, $y+25, $style);
        $yy = $y+25;
        PDF::Line(15, $yy+10, 195, $yy+10, $style);
        PDF::Line(15, $yy+20, 195, $yy+20, $style);
        PDF::Line(15, $yy+40, 195, $yy+40, $style);
        PDF::Line(15, $yy+55, 195, $yy+55, $style);
        PDF::Line(15, $yy+68, 195, $yy+68, $style);
        PDF::Line(15, $yy+98, 195, $yy+98, $style);
        PDF::Line(15, $yy+103, 195, $yy+103, $style);
        PDF::Line(15, $yy+162, 195, $yy+162, $style);
        PDF::Line(15, $yy+167, 195, $yy+167, $style);


        PDF::SetAutoPageBreak(TRUE, 0);
        PDF::AddPage();
        $style = array('width' => 0.1, 'color' => array(0, 0, 0));
        $styles = array('width' => 0.5, 'color' => array(0, 0, 0));
		$table = "<table>
            	 </table>";
        $y = PDF::getY();
        PDF::Rect(15, $y+11, 180, 102);
        // PDF::writeHTMLCell(180, 100, 15, $y+11, $table, 1, 0);
        PDF::Line(15, $y+11, 195, $y+11, $style);
        PDF::SetFont('', '', 8);
        PDF::SetXY(15,$y+11);
       	PDF::Cell(45,5,"Other Source/s Family income",1,0,'C');
       	PDF::SetXY(15+45,$y+11);
        if ($patient->source_income) {
          PDF::Cell(45,5,"".number_format($patient->source_income, 2, '.', ',')."",1,0,'C');/*===========other sources*/
        }
       	PDF::SetXY(15+90,$y+11);
       	PDF::Cell(45,5,"Total Family Income",1,0,'C');
       	PDF::SetXY(15+90+45,$y+11);
        if ($patient->mlksttfincome) {
          PDF::Cell(45,5,"".number_format($patient->mlksttfincome, 2, '.', ',')."",1,0,'C');/*===========total*/
        }
       	PDF::SetXY(15,$y+16);
       	PDF::SetFont('', 'B', 9);
       	PDF::Cell(180,5,"Breakdown",1,0,'C');

       	$y = $y+16;

       	PDF::SetFont('', 'B', 8);
       	$houselot = explode('-', $patient->houselot);
       	$light = explode('-', $patient->light);
       	$water = explode('-', $patient->water);

       	if ($houselot[0] == "rented") {
       		PDF::Rect(20, $y+10.5, 3, 3, 'DF', $border_style);/*==========================1*/
       	}else{
       		PDF::Rect(20, $y+10.5, 3, 3);/*==========================1*/
       	}
       	if ($light[0] == "electric") {
       		 PDF::Rect(20, $y+20.5, 3, 3,'DF', $border_style);/*==========================2*/
       	}else{
       		 PDF::Rect(20, $y+20.5, 3, 3);/*==========================2*/
       	}
      	if ($light[0] == "kerosene") {
      		PDF::Rect(20, $y+25.5, 3, 3,'DF', $border_style);/*==========================3*/	
      	}else{
			PDF::Rect(20, $y+25.5, 3, 3);/*==========================3*/
      	}
       	
       	if ($houselot[0] == "owned") {
       		PDF::Rect(63, $y+10.5, 3, 3, 'DF', $border_style);/*==========================4*/
       	}else{
       		PDF::Rect(63, $y+10.5, 3, 3);/*==========================4*/
       	}
       	if ($light[0] == "candle") {
       		PDF::Rect(63, $y+20.5, 3, 3, 'DF', $border_style);/*==========================5*/
       	}else{
       		PDF::Rect(63, $y+20.5, 3, 3);/*==========================5*/
       	}
       	if ($water[0] == "public") {
       		PDF::Rect(63, $y+35.5, 3, 3, 'DF', $border_style);/*==========================6*/# code...
       	}else{
			PDF::Rect(63, $y+35.5, 3, 3);/*==========================6*/
       	}
       	if ($water[0] == "owned") {
       		PDF::Rect(63, $y+40.5, 3, 3, 'DF', $border_style);/*==========================7*/
       	}else{
       		PDF::Rect(63, $y+40.5, 3, 3);/*==========================7*/
       	}
       
       
       	// dd($patient);
       	PDF::text(17,$y+5,"House/lot:                                                                                 
       						Food:  ".$patient->food."");
       	PDF::text(17,$y+15,"Light Source:                                                                           
       						Clothing: ".$patient->clothing."");
       	PDF::text(17,$y+30,"Water Source:                                                                          
       						Medical Expenditures:  ".$patient->expinditures."");
       	PDF::text(105,$y+10," Education:  ".$patient->educationphp."");
       	PDF::text(105,$y+20," Transportation: ".$patient->transportation."");
       	PDF::text(105,$y+25," House Help:  ".$patient->house_help."");
       	PDF::text(105,$y+35," Insurance Premium:  ".$patient->insurance."");
       	PDF::text(105,$y+40," Other: ".$patient->other_expenses."");
       	PDF::SetFont('', '', 8);
       	// dd($light);
       	if ($houselot[0] == "rented") {
       		PDF::text(23,$y+10," Rented(amount)  ".number_format($houselot[1], 2, '.', ',')."      
       						Owned");
       	}else{
       		PDF::text(23,$y+10," Rented(amount)             
       						Owned");
       	}
       	if ($light[0] == "electric") {
       		PDF::text(23,$y+20," Electric(amount)  ".number_format($light[1], 2, '.', ',')."            
       						Candle(amount)");
       	}elseif ($light[0] == "candle") {
       		PDF::text(23,$y+20," Electric(amount)                 
       						Candle(amount)  ".number_format($light[1], 2, '.', ',')."");
       	}else{
       		PDF::text(23,$y+20," Electric(amount)             
       						Candle(amount)");
       	}
       	if ($light[0] == "kerosene"){
       		PDF::text(23,$y+25," Kerosene(amount)   ".number_format($light[1], 2, '.', ',')."");
       	}else{
       		PDF::text(23,$y+25," Kerosene(amount)");		
       	}
		if ($water[0] == "public") {
			PDF::text(23,$y+35," Artisian Well                   
       						Public(amount)  ".number_format($water[1], 2, '.', ',')."");
		}else{
			PDF::text(23,$y+35," Artisian Well                   
       						Public(amount)");
		}
		if ($water[0] == "owned") {
			PDF::text(65,$y+40," Owned(Amount)    ".number_format($water[1], 2, '.', ',')."");
		}else{
			PDF::text(65,$y+40," Owned(Amount)");
		}
		if ($water[0] == "water_distric") {
			PDF::text(23,$y+45," Water District:   ".number_format($water[1], 2, '.', ',')."");
		}else{
			PDF::text(23,$y+45," Water District:");
		}
		
		for ($i=1; $i <=9 ; $i++) { 
			$y = $y+5;
			PDF::Line(17, $y+5, 103, $y+5, $style);
			PDF::Line(107, $y+5, 193, $y+5, $style);
		}

		$y = $y;
		PDF::Line(15, $y+5, 195, $y+5, $styles);
		PDF::Line(15, $y+10, 195, $y+10, $style);
		PDF::SetFont('', 'B', 9);
		PDF::SetFillColor(220, 220, 220);
		PDF::SetXY(15,$y+5);
		PDF::Cell(180,5,"IV. ASSESSMENT",1,0,'',true);

		$y = $y+5;
		// dd($patient->mlkstproblem);
		$mlkstproblem = explode(',', $patient->mlkstproblem);
		if (in_array(1, $mlkstproblem)) {
			PDF::Rect(27, $y+10, 3, 3, 'DF', $border_style);/*==========================1*/
		}else{
			PDF::Rect(27, $y+10, 3, 3);/*==========================1*/
		}
		// dd($patient->mlkstproblem);
		if (in_array(2, $mlkstproblem)) {
			PDF::Rect(27, $y+15, 3, 3, 'DF', $border_style);/*==========================2*/
		}else{
			PDF::Rect(27, $y+15, 3, 3);/*==========================2*/
		}

		if (in_array(3, $mlkstproblem)) {
			PDF::Rect(27, $y+20, 3, 3, 'DF', $border_style);/*==========================3*/
		}else{
			PDF::Rect(27, $y+20, 3, 3);/*==========================3*/
		}
		
		if (in_array(4, $mlkstproblem)) {
			PDF::Rect(104, $y+10, 3, 3, 'DF', $border_style);/*==========================4*/
		}else{
			PDF::Rect(104, $y+10, 3, 3);/*==========================4*/
		}
		
		if (in_array(5, $mlkstproblem)) {
			PDF::Rect(104, $y+15, 3, 3, 'DF', $border_style);/*==========================5*/
		}else{
			PDF::Rect(104, $y+15, 3, 3);/*==========================5*/
		}

		if (in_array(6, $mlkstproblem)) {
			PDF::Rect(104, $y+20, 3, 3, 'DF', $border_style);/*==========================6*/
		}else{
			PDF::Rect(104, $y+20, 3, 3);/*==========================6*/
		}

		PDF::SetFont('', 'B', 8);
		PDF::text(17,$y+5,"Problem Presented");
		PDF::text(17,$y+25,"Social Worker's Assesment:");
		PDF::SetFont('', '', 8);
		PDF::text(30,$y+10,"Health Condition of Patient (specify)                                
							Economic resources (specify)");
		PDF::text(30,$y+15,"Food/Nutrition (specify)                                                    
							Housing (specify)");
		PDF::text(30,$y+20,"Employment (specify)                                                       
							Other (specify)");
		PDF::SetXY(18,$y+29);
		PDF::MultiCell(174,15,"".$patient->mlkstassesment."",0,'',false);/*=======================assesment*/
		$y-=2;
		for ($i=1; $i <=4 ; $i++) { 
			$y +=4;
			PDF::Line(17, $y+30, 193, $y+30, $style);
		}
		$y+=30;

		PDF::Line(17, $y+9, 103, $y+9, $style);
		PDF::Line(150, $y+9, 195, $y+9, $style);
		PDF::text(45,$y+10,"Informant's/Client Signature                                                                                            
							Client's Thumbmark");

		PDF::text(17,$y+25,"Interviewed by : __________________________________________                                                 
							Date : _____________________");
		PDF::text(167,$y+25,"".Carbon::now()->setTime(0,0)->format('d/m/Y')."");/* date*/                                                                                        

		PDF::text(35,$y+28,"Signature above printed name of medical Social Worker                                                                      
							dd/mm/yyyy");

		
    PDF::IncludeJS("print();");
		PDF::Output();
		return;
	}
}