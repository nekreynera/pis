<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Clinic;
use App\Cashincomecategory;
use App\Cashincomesubcategory;
use App\Ancillaryrequist;
use App\Cashincome;
use App\Patient;
use PDF;
use DNS1D;
use DB;
use Carbon;
use Auth;
use Session;

class AncillaryreportController extends Controller
{
		

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		
	}
	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		
	}
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		
		
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
		
	}
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
	    
	}
	static function getclinic($id)
	{
		$clinic = Clinic::find($id);
		return $clinic;
	}
	public function ancillarycensus(Request $request)
	{
		// dd(Auth::user()->clinic);
		if ($request->top == 'ALL') {
			$request->top = 1000;
		}
		$census = DB::select("SELECT a.category_id, 
									b.sub_category, 
							        sum(a.qty) as result,
							        COUNT(*) as person,
							        COUNT(c.sex) as male,
							        COUNT(d.sex) as female
							FROM cashincome a
							LEFT JOIN cashincomesubcategory b ON a.category_id = b.id 
							LEFT JOIN patients c ON a.patients_id = c.id AND c.sex = 'M'
							LEFT JOIN patients d ON a.patients_id = d.id AND d.sex = 'F'
							LEFT JOIN users e  ON a.users_id = e.id
							LEFT JOIN cashincomecategory f ON b.cashincomecategory_id = f.id
							WHERE f.clinic_id = ?
							AND a.get = 'Y'
							AND (CASE 
									WHEN ? = '3'
									THEN DATE(a.created_at) 
									ELSE DATE(a.updated_at) 
								END)
							BETWEEN ? AND ?
							GROUP BY a.category_id  
							ORDER BY result  DESC
							LIMIT ?
							",
							[Auth::user()->clinic,
							Auth::user()->clinic,
							$request->from,
							$request->to,
							$request->top]);
		// dd($census);
		$consultation = DB::select("SELECT a.*, b.sex  
							FROM assignations a 
							LEFT JOIN patients b ON a.patients_id = b.id
							WHERE a.clinic_code = ? 
							AND a.status = 'F' 
							AND DATE(a.created_at) 
							BETWEEN ? AND ?
							", 
							[Auth::user()->clinic,
							$request->from,
							$request->to]);
		
		return view('ancillary.census', compact('census', 'consultation'));
		
		
	}
	public function ancillaryreport(Request $request)
	{
		if (isset($request->type) || isset($request->from) || isset($request->to)) {
			if ($request->type == 'c') {
				$data = DB::select("SELECT CONCAT(c.label,' ',c.description,'% - ',a.or_no) as classifcation,
									b.last_name, b.first_name, b.middle_name,
							        b.birthday, 
							        d.citymunDesc,
							        e.sub_category,
							        a.qty,
							        (a.price * a.qty) as amount,
							        (CASE 
							         	WHEN a.discount 
							         	THEN ((a.price * a.qty) - a.discount)
							         	ELSE (a.price * a.qty) 
							         END) as paid,
							         (CASE 
							          	WHEN a.discount
							          	THEN a.discount
							          	ELSE '0'
							          END) as discount
							        
							FROM cashincome a
							LEFT JOIN patients b ON a.patients_id = b.id
							LEFT JOIN mss c ON a.mss_id = c.id 
							LEFT JOIN refcitymun d ON b.city_municipality = d.citymunCode
							LEFT JOIN cashincomesubcategory e ON a.category_id = e.id
							LEFT JOIN cashincomecategory f ON e.cashincomecategory_id = f.id
							WHERE a.mss_id IN(3,4,5,6,7,8)
							AND DATE(a.created_at) >= ?
							AND DATE(a.created_at) <= ?
							AND a.void = '0'
							AND f.clinic_id = ?
							ORDER BY a.created_at ASC
							", [$request->from,
								$request->to,
								Auth::user()->clinic]);
				$patients = DB::select("SELECT COUNT(*) as result
							FROM cashincome a
							LEFT JOIN patients b ON a.patients_id = b.id
							LEFT JOIN cashincomesubcategory e ON a.category_id = e.id
							LEFT JOIN cashincomecategory f ON e.cashincomecategory_id = f.id
							WHERE a.mss_id IN(3,4,5,6,7,8)
							AND DATE(a.created_at) >= ?
							AND DATE(a.created_at) <= ?
							AND a.void = '0'
							AND f.clinic_id = ?
							GROUP BY a.patients_id
							ORDER BY a.or_no ASC
							", [$request->from,
								$request->to,
								Auth::user()->clinic]);

				// dd($patients);
				PDF::SetTitle('ANCILLARY ISSUANCE FORM');
				PDF::SetAutoPageBreak(TRUE, 0);
				PDF::AddPage('L', array(215.9,330.2));
				PDF::Image('./public/images/doh-logo.png',70,5,25);
				PDF::Image('./public/images/evrmc-logo.png',250,5,18);
				PDF::SetFont('Times','',10);
				PDF::Text(270,10,'Patient: '.count($patients).'');
				PDF::Text(270,15,'Particular: '.count($data).'');
				PDF::Text(270,20,'ISSUANCE OF CLASS C ');
				PDF::SetXY(160,5);
				PDF::Cell(15,1,'REQUISITION AND ISSUE SLIP',0,0,'C');
				PDF::SetXY(160,5);
				PDF::Cell(17,15,'EASTERN VISAYAS MEDICAL CENTER',0,0,'C');
				PDF::SetXY(160,10);
				PDF::Cell(16,15,'OUT PATIENT DEPARTMENT',0,0,'C');
				PDF::SetFont('Times','',8);
				PDF::SetXY(160,15);
				PDF::Cell(16,15,'CABALAWAN TACLOBAN CITY, LEYTE, PHILIPPINES',0,0,'C');
				PDF::SetXY(160,17);
				PDF::Cell(10,15,"_________________________________________________________________________________________________________________________________________________________________________________________",0,0,'C');

				PDF::SetFont('Times','',10);
				PDF::SetXY(160,21);
				PDF::Cell(16,15,'ISSUANCE FORM',0,0,'C');
				PDF::SetXY(10,21);
				PDF::Cell(1,15,'DATE: '.Carbon::parse($request->from)->format('m/d/Y').' to '.Carbon::parse($request->to)->format('m/d/Y').'',0,0,'L');
				$y = PDF::GetY() + 10;
				PDF::SetXY(10, $y);
				PDF::SetFont('Times','',8);
				PDF::MultiCell(35,10,"CLASSIFICATION \n& OR#",1,'C',false);
				PDF::SetXY(5+40, $y);
				PDF::SetFont('Times','',10);
				PDF::MultiCell(55,10,"NAME OF PATIENT",1,'C',false);
				PDF::SetXY(5+95, $y);
				PDF::MultiCell(10,10,"AGE",1,'C',false);
				PDF::SetXY(5+105, $y);
				PDF::MultiCell(65,10,"ADDRESS",1,'C',false);
				PDF::SetXY(5+95+75, $y);
				PDF::MultiCell(70,10,"PARTICULAR",1,'C',false);
				PDF::SetXY(5+95+100+45, $y);
				PDF::MultiCell(10,10,"QTY",1,'C',false);
				PDF::SetXY(5+95+100+35+20, $y);
				PDF::MultiCell(22,10,"TOTAL \nAMT.",1,'C',false);
				PDF::SetXY(5+95+100+35+10+32, $y);
				PDF::MultiCell(40,5,"DISCOUNTED",1,'C',false);
				PDF::SetXY(5+95+100+35+10+32, $y+5);
				PDF::SetFont('Times','',7);
				PDF::MultiCell(20,5,"AMT.PAID",1,'C',false);
				PDF::SetXY(5+95+100+35+10+17+35, $y+5);
				PDF::MultiCell(20,5,"AMT",1,'C',false);
				$i=1;
				$total = 0;
				$paid = 0;
				$discount = 0;
				foreach($data as $list) { 

    			$cellY = PDF::getStringHeight(70, $list->sub_category);
				
					$y = PDF::GetY();
				
				if ($i == 33 || $i == 70 || $i == 107 || $i == 144 || $i == 181 || $i == 217 || $i == 254 
					|| $i == 292 || $i == 330 || $i == 368 || $i == 406 || $i == 444 || $i == 482 
					|| $i == 520 || $i == 558 || $i == 596 || $i == 634 || $i == 672 || $i == 710 
					|| $i == 748 || $i == 786 || $i == 824 || $i == 862 || $i == 900 || $i == 938 
					|| $i == 976 || $i == 1014) {
				PDF::SetAutoPageBreak(TRUE, 0);
				PDF::AddPage('L', array(215.9,330.2));
				$y = 15;	# code...
				}
				PDF::SetXY(10, $y);
				PDF::SetFont('Times','',8);
				PDF::Cell(35,$cellY,$list->classifcation,1,1,'C');
				PDF::SetXY(5+40, $y);
				PDF::SetFont('Times','',10);
				PDF::Cell(55,$cellY,$list->last_name.", ".$list->first_name." ".substr($list->middle_name, 0,1).".",1,'C',false);
				PDF::SetXY(5+95, $y);

				$agePatient = Patient::age($list->birthday);
				
				PDF::Cell(10,$cellY,$agePatient,1,1,'C');
				PDF::SetXY(5+105, $y);
				PDF::Cell(65,$cellY,$list->citymunDesc,1,'C',false);
				PDF::SetXY(5+95+75, $y);
				PDF::MultiCell(70,$cellY,$list->sub_category,1,'',false);
				// PDF::Cell(70,5,"".$list->sub_category."",1,'C',false);
				PDF::SetXY(5+95+100+45, $y);
				PDF::Cell(10,$cellY,$list->qty,1,1,'C');
				PDF::SetXY(5+95+100+35+20, $y);
				PDF::Cell(22,$cellY,number_format($list->amount, 2, '.', ','),1,1,'R');
				$total += $list->amount;
				PDF::SetXY(5+95+100+35+10+32, $y);
				PDF::Cell(20,$cellY,number_format($list->paid, 2, '.', ','),1,1,'R');
				$paid += $list->paid;
				PDF::SetXY(5+95+100+35+10+17+35, $y);
				PDF::Cell(20,$cellY,number_format($list->discount, 2, '.', ','),1,1,'R');
				$discount += $list->discount;
				$i++;
				}
				$y = PDF::GetY();
				PDF::SetXY(10, $y);
				
				PDF::Cell(245,5,"TOTAL",1,1,'R');
				PDF::SetXY(5+95+100+35+20, $y);
				PDF::Cell(22,5,"".number_format($total, 2, '.', ',')."",1,1,'R');
				PDF::SetXY(5+95+100+35+10+32, $y);
				PDF::Cell(20,5,"".number_format($paid, 2, '.', ',')."",1,1,'R');
				PDF::SetXY(5+95+100+35+10+17+35, $y);
				PDF::Cell(20,5,"".number_format($discount, 2, '.', ',')."",1,1,'R');
				
				PDF::Output();
				return;
			}elseif ($request->type == 'd') {
				$data = DB::select("SELECT CONCAT(c.label,' ',c.description,'% - ',a.or_no) as classifcation,
									b.last_name, b.first_name, b.middle_name,
							        b.birthday, 
							        d.citymunDesc,
							        e.sub_category,
							        a.qty,
							        (a.price * a.qty) as amount,
							        (CASE 
							         	WHEN a.discount 
							         	THEN ((a.price * a.qty) - a.discount)
							         	ELSE (a.price * a.qty) 
							         END) as paid,
							         (CASE 
							          	WHEN a.discount
							          	THEN a.discount
							          	ELSE '0'
							          END) as discount
							FROM cashincome a
							LEFT JOIN patients b ON a.patients_id = b.id
							LEFT JOIN mss c ON a.mss_id = c.id 
							LEFT JOIN refcitymun d ON b.city_municipality = d.citymunCode
							LEFT JOIN cashincomesubcategory e ON a.category_id = e.id
							LEFT JOIN cashincomecategory f ON e.cashincomecategory_id = f.id
							WHERE a.mss_id IN(9)
							AND DATE(a.created_at) >= ?
							AND DATE(a.created_at) <= ?
							-- AND a.get = 'Y'
							AND f.clinic_id = ?
							ORDER BY a.created_at ASC
							", [$request->from,
								$request->to,
								Auth::user()->clinic]);
				$patients = DB::select("SELECT COUNT(*) as result
							FROM cashincome a
							LEFT JOIN patients b ON a.patients_id = b.id
							LEFT JOIN cashincomesubcategory e ON a.category_id = e.id
							LEFT JOIN cashincomecategory f ON e.cashincomecategory_id = f.id
							WHERE a.mss_id IN(9)
							AND DATE(a.created_at) >= ?
							AND DATE(a.created_at) <= ?
							-- AND a.get = 'Y'
							AND f.clinic_id = ?
							GROUP BY a.patients_id
							-- ORDER BY a.or_no ASC
							", [$request->from,
								$request->to,
								Auth::user()->clinic]);
				PDF::SetTitle('ISSUANCE FORM');
				// PDF::IncludeJS("print();");
				PDF::AddPage();
				PDF::Image('./public/images/doh-logo.png',20,10,25);
				PDF::Image('./public/images/evrmc-logo.png',170,10.5,18);
				PDF::SetFont('Times','',10);
				PDF::SetXY(190,10);
				PDF::Cell(15,1,'Patient : '.count($patients).'',0,0,'L');
				PDF::SetXY(190,15);
				PDF::Cell(15,1,'Particular : '.count($data).'',0,0,'L');
				PDF::SetXY(98,10);
				PDF::Cell(15,1,'REQUISITION AND ISSUE SLIP',0,0,'C');
				PDF::SetXY(98,10);
				PDF::Cell(17,15,'EASTERN VISAYAS MEDICAL CENTER',0,0,'C');
				PDF::SetXY(98,15);
				PDF::Cell(16,15,'OUT PATIENT DEPARTMENT',0,0,'C');
				PDF::SetFont('Times','',8);
				PDF::SetXY(98,20);
				PDF::Cell(16,15,'CABALAWAN TACLOBAN CITY, LEYTE, PHILIPPINES',0,0,'C');
				PDF::SetXY(98,25);
				PDF::Cell(16,15,"____________________________________________________________________________________________________________________________",0,0,'C');

				PDF::SetFont('Times','',10);
				PDF::SetXY(98,30);
				PDF::Cell(16,15,'ISSUANCE FORM',0,0,'C');
				PDF::SetXY(3,30);
				PDF::Cell(1,15,'DATE: '.Carbon::parse($request->from)->format('m/d/Y').' to '.Carbon::parse($request->to)->format('m/d/Y').'',0,0,'L');

				PDF::SetFont('Times','',7);
				PDF::SetAutoPageBreak(TRUE, 0);
				
				$y = PDF::GetY() + 10;
			
				PDF::SetXY(3, $y);
				PDF::Cell(50,5,'NAME OF PATIENT',1,1,'C');
				PDF::SetXY(3+50, $y);
				PDF::Cell(10,5,'AGE',1,1,'C');
				PDF::SetXY(3+60, $y);
				PDF::Cell(55,5,'ADDRESS',1,1,'C');
				PDF::SetXY(3+115, $y);
				PDF::Cell(65,5,'PARTICULAR',1,1,'C');
				PDF::SetXY(3+117+40+23, $y);
				PDF::Cell(10,5,'QTY',1,1,'C');
				PDF::SetXY(3+115+40+35, $y);
				PDF::Cell(13,5,'AMOUNT',1,1,'C');
				$l = 0;
				$total = 0;
				foreach ($data as $list) {
					$y = PDF::GetY();
					if ($l == 47 || $l == 102 || $l == 157 || $l == 212 || $l == 267 ) {
					PDF::SetAutoPageBreak(TRUE, 0);
					PDF::AddPage();
					$y = 5;	# code...
					}
    				$cellY = PDF::getStringHeight(65, $list->sub_category);
					PDF::SetXY(3, $y);
					PDF::Cell(50,$cellY,''.$list->last_name.', '.$list->first_name.' '.substr($list->middle_name, 0,1).'',1,1,'L');
					PDF::SetXY(3+50, $y);
					$agePatient = Patient::age($list->birthday);
					PDF::Cell(10,$cellY,''.$agePatient.'',1,1,'C');
					PDF::SetXY(3+60, $y);
					PDF::Cell(55,$cellY,''.$list->citymunDesc.'',1,1,'L');
					PDF::SetXY(3+115, $y);
					PDF::MultiCell(65,$cellY,$list->sub_category,1,'C',false);
					// PDF::Cell(65,5,''.$list->sub_category.'',1,1,'L');
					PDF::SetXY(3+117+40+23, $y);
					PDF::Cell(10,$cellY,''.$list->qty.'',1,1,'C');
					PDF::SetXY(3+115+40+35, $y);
					PDF::Cell(13,$cellY,''.number_format($list->amount, 2, '.', ',').'',1,1,'R');
					$total += $list->amount;
				$l++;
				}
				
				$y = PDF::GetY();
					PDF::SetXY(3, $y);
					PDF::Cell(190,5,'TOTAL',1,1,'C');
					PDF::SetXY(3+115+40+35, $y);
					PDF::Cell(13,5,''.number_format($total, 2, '.', ',').'',1,1,'R');
				
		        PDF::Output();
				return;
			}
			else if ($request->type == 'all') {
				$data = DB::select("SELECT CONCAT(c.label,' ',c.description) as classifcation,
									a.or_no,
									b.last_name, b.first_name, b.middle_name,
							        b.birthday, 
							        d.citymunDesc,
							        e.sub_category,
							        a.qty,
							        (a.price * a.qty) as amount,
							        (CASE 
							         	WHEN a.discount 
							         	THEN ((a.price * a.qty) - a.discount)
							         	ELSE (a.price * a.qty) 
							         END) as paid,
							         (CASE 
							          	WHEN a.discount
							          	THEN a.discount
							          	ELSE '0'
							          END) as discount
							FROM cashincome a
							LEFT JOIN patients b ON a.patients_id = b.id
							LEFT JOIN mss c ON a.mss_id = c.id 
							LEFT JOIN refcitymun d ON b.city_municipality = d.citymunCode
							LEFT JOIN cashincomesubcategory e ON a.category_id = e.id
							LEFT JOIN cashincomecategory f ON e.cashincomecategory_id = f.id
							WHERE DATE(a.created_at) >= ?
							AND DATE(a.created_at) <= ?
							AND a.void = '0'
							AND f.clinic_id = ?
							ORDER BY a.created_at ASC
							", [$request->from,
								$request->to,
								Auth::user()->clinic]);
				$patients = DB::select("SELECT COUNT(*) as result
							FROM cashincome a
							LEFT JOIN patients b ON a.patients_id = b.id
							LEFT JOIN cashincomesubcategory e ON a.category_id = e.id
							LEFT JOIN cashincomecategory f ON e.cashincomecategory_id = f.id
							WHERE DATE(a.created_at) >= ?
							AND DATE(a.created_at) <= ?
							AND a.void = '0'
							AND f.clinic_id = ?
							GROUP BY a.patients_id
							", [$request->from,
								$request->to,
								Auth::user()->clinic]);

				// dd($patients);
				PDF::SetTitle('ANCILLARY ISSUANCE FORM');
				PDF::SetAutoPageBreak(TRUE, 0);
				PDF::AddPage('L', array(215.9,330.2));
				PDF::Image('./public/images/doh-logo.png',70,5,25);
				PDF::Image('./public/images/evrmc-logo.png',250,5,18);
				PDF::SetFont('Times','',10);
				PDF::Text(270,10,'Patient: '.count($patients).'');
				PDF::Text(270,15,'Particular: '.count($data).'');
				// PDF::Text(270,20,'ISSUANCE OF CLASS C ');
				PDF::SetXY(160,5);
				PDF::Cell(15,1,'REQUISITION AND ISSUE SLIP',0,0,'C');
				PDF::SetXY(160,5);
				PDF::Cell(17,15,'EASTERN VISAYAS MEDICAL CENTER',0,0,'C');
				PDF::SetXY(160,10);
				PDF::Cell(16,15,'OUT PATIENT DEPARTMENT',0,0,'C');
				PDF::SetFont('Times','',8);
				PDF::SetXY(160,15);
				PDF::Cell(16,15,'CABALAWAN TACLOBAN CITY, LEYTE, PHILIPPINES',0,0,'C');
				PDF::SetXY(160,17);
				PDF::Cell(10,15,"_________________________________________________________________________________________________________________________________________________________________________________________",0,0,'C');

				PDF::SetFont('Times','',10);
				PDF::SetXY(160,21);
				PDF::Cell(16,15,'ISSUANCE FORM',0,0,'C');
				PDF::SetXY(10,21);
				PDF::Cell(1,15,'DATE: '.Carbon::parse($request->from)->format('m/d/Y').' to '.Carbon::parse($request->to)->format('m/d/Y').'',0,0,'L');
				$y = PDF::GetY() + 10;
				PDF::SetXY(10, $y);
				PDF::SetFont('Times','',8);
				PDF::MultiCell(35,10,"CLASSIFICATION \n& OR#",1,'C',false);
				PDF::SetXY(5+40, $y);
				PDF::SetFont('Times','',10);
				PDF::MultiCell(55,10,"NAME OF PATIENT",1,'C',false);
				PDF::SetXY(5+95, $y);
				PDF::MultiCell(10,10,"AGE",1,'C',false);
				PDF::SetXY(5+105, $y);
				PDF::MultiCell(65,10,"ADDRESS",1,'C',false);
				PDF::SetXY(5+95+75, $y);
				PDF::MultiCell(70,10,"PARTICULAR",1,'C',false);
				PDF::SetXY(5+95+100+45, $y);
				PDF::MultiCell(10,10,"QTY",1,'C',false);
				PDF::SetXY(5+95+100+35+20, $y);
				PDF::MultiCell(22,10,"TOTAL \nAMT.",1,'C',false);
				PDF::SetXY(5+95+100+35+10+32, $y);
				PDF::MultiCell(40,5,"DISCOUNTED",1,'C',false);
				PDF::SetXY(5+95+100+35+10+32, $y+5);
				PDF::SetFont('Times','',7);
				PDF::MultiCell(20,5,"AMT.PAID",1,'C',false);
				PDF::SetXY(5+95+100+35+10+17+35, $y+5);
				PDF::MultiCell(20,5,"AMT",1,'C',false);
				$i=1;
				$total = 0;
				$paid = 0;
				$discount = 0;

				foreach($data as $list) { 

				
					$y = PDF::GetY();
				
				if ($y >= 180) {
				PDF::SetAutoPageBreak(TRUE, 0);
				PDF::AddPage('L', array(215.9,330.2));
				$y = 15;	# code...
				}

    			$cellY = PDF::getStringHeight(70, $list->sub_category);
				PDF::SetXY(10, $y);
				PDF::SetFont('Times','',8);
				if ($list->classifcation == "D CHARITY") {
				PDF::Cell(35,$cellY,"".$list->classifcation."",1,1,'C');
				}else{
				PDF::Cell(35,$cellY,"".$list->classifcation."-".$list->or_no,1,1,'C');	
				}
				PDF::SetXY(5+40, $y);
				PDF::SetFont('Times','',10);
				PDF::Cell(55,$cellY,"".$list->last_name.", ".$list->first_name." ".substr($list->middle_name, 0,1).".",1,'C',false);
				PDF::SetXY(5+95, $y);

				$agePatient = Patient::age($list->birthday);
				
				PDF::Cell(10,$cellY,"".$agePatient."",1,1,'C');
				PDF::SetXY(5+105, $y);
				PDF::Cell(65,$cellY,"".$list->citymunDesc."",1,'C',false);
				PDF::SetXY(5+95+75, $y);
				PDF::MultiCell(70,$cellY,$list->sub_category,1,'C',false);
				// PDF::Cell(70,5,"".$list->sub_category."",1,'C',false);
				PDF::SetXY(5+95+100+45, $y);
				PDF::Cell(10,$cellY,"".$list->qty."",1,1,'C');
				PDF::SetXY(5+95+100+35+20, $y);
				PDF::Cell(22,$cellY,"".number_format($list->amount, 2, '.', ',')."",1,1,'R');
				$total += $list->amount;
				PDF::SetXY(5+95+100+35+10+32, $y);
				PDF::Cell(20,$cellY,"".number_format($list->paid, 2, '.', ',')."",1,1,'R');
				$paid += $list->paid;
				PDF::SetXY(5+95+100+35+10+17+35, $y);
				PDF::Cell(20,$cellY,"".number_format($list->discount, 2, '.', ',')."",1,1,'R');
				$discount += $list->discount;
				$i++;
				}
				$y = PDF::GetY();
				PDF::SetXY(10, $y);
				
				PDF::Cell(245,5,"TOTAL",1,1,'R');
				PDF::SetXY(5+95+100+35+20, $y);
				PDF::Cell(22,5,"".number_format($total, 2, '.', ',')."",1,1,'R');
				PDF::SetXY(5+95+100+35+10+32, $y);
				PDF::Cell(20,5,"".number_format($paid, 2, '.', ',')."",1,1,'R');
				PDF::SetXY(5+95+100+35+10+17+35, $y);
				PDF::Cell(20,5,"".number_format($discount, 2, '.', ',')."",1,1,'R');
				
				PDF::Output();
				return;
			}
		}
		else{
		return view('ancillary.report');	
		}
		

	}
	
	public function exportservicetopdf(Request $request)
	{
		if ($request->list != "''" && $request->trash == "''") {
			$request->trash = "'N'";
			$status = $request->list;
		}elseif ($request->list == "''" && $request->trash != "''") {
			$request->list = "'active'".','."'inactive'";
			$status = "DELETED";
		}elseif ($request->list == "''" && $request->trash == "''") {
			$request->trash = "'N'".','."'Y'";
			$request->list = "'active'".','."'inactive'";
			$status = "";
		}
		
		$services = DB::select("SELECT a.*, c.name 
									FROM cashincomesubcategory a
									LEFT JOIN cashincomecategory b ON a.cashincomecategory_id = b.id
                                    LEFT JOIN clinics c ON c.id = ?
									WHERE b.clinic_id = ?
									AND a.trash IN($request->trash)
									AND a.status IN($request->list)
									ORDER BY a.sub_category ASC
								", [Auth::user()->clinic,
									Auth::user()->clinic]);
		
		// $sample = str_replace('""', ' ', $request->list);
		// dd($services);
		PDF::SetTitle('ISSUANCE FORM');
				// PDF::IncludeJS("print();");
				PDF::AddPage();
				PDF::Image('./public/images/doh-logo.png',20,10,25);
				PDF::Image('./public/images/evrmc-logo.png',170,10.5,18);
				PDF::SetFont('Times','',10);
				PDF::SetXY(98,10);
				// PDF::Cell(15,1,'SERVICES',0,0,'C');
				PDF::SetXY(98,10);
				PDF::Cell(17,15,'EASTERN VISAYAS MEDICAL CENTER',0,0,'C');
				PDF::SetXY(98,15);
				PDF::Cell(16,15,'OUT PATIENT DEPARTMENT',0,0,'C');
				PDF::SetFont('Times','',8);
				PDF::SetXY(98,20);
				PDF::Cell(16,15,'CABALAWAN TACLOBAN CITY, LEYTE, PHILIPPINES',0,0,'C');
				PDF::SetXY(98,25);

				PDF::Cell(16,15,"____________________________________________________________________________________________________________________________",0,0,'C');
				
				$y = PDF::GetY()+15;
				PDF::Text(100,35,''.$services[0]->name.' '.strtoupper($status).' SERVICES');
				PDF::SetXY(15,$y);
				PDF::Cell(110,5,'PARTICULARS',1,1,'C');
				PDF::SetXY(125,$y);
				PDF::Cell(35,5,'STATUS',1,1,'C');
				PDF::SetXY(160,$y);
				PDF::Cell(35,5,'PRICE',1,1,'C');
				$i = 0;
				foreach ($services as $list) {
				$y = PDF::GetY();
				if ($i == 45 || $i == 93 || $i == 141 || $i == 144 || $i == 189 || $i == 237 || $i == 285 || $i == 333) {
				PDF::SetAutoPageBreak(TRUE, 0);
				PDF::AddPage();
				$y = 25;	# code...
				}
				PDF::SetXY(15,$y);
				PDF::Cell(110,5,$list->sub_category,1,1,'');
				PDF::SetXY(125,$y);
				if ($list->trash == "Y") {
				PDF::Cell(35,5,"DELETED",1,1,'C');	# code...
				}else{
				PDF::Cell(35,5,strtoupper($list->status),1,1,'C');
				}
				PDF::SetXY(160,$y);
				PDF::Cell(35,5,number_format($list->price,2,'.',','),1,1,'R');
					# code...
				$i++;
				}

		PDF::Output();
		return;
	}
	
	
}