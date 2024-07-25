<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use DNS1D;
use DB;
use Carbon\Carbon;
use Auth;
use Session;

/**
* 
*/
class ConsolidationController extends Controller
{
	public function reports(Request $request)
	{
		if ($request->filter == 'class-d') {
				$transaction = DB::select("SELECT d.id,
							CONCAT(d.last_name,', ',d.first_name,' ', CASE WHEN d.middle_name IS NOT NULL THEN LEFT(d.middle_name, 1) ELSE '' END) as patient_name,
							d.age,
							CONCAT(f.citymunDesc,', ',h.provDesc) as address,
							g.item_description, g.brand, b.qty, (b.qty * a.price) as total_amount
							FROM sales a 
							LEFT JOIN pharmanagerequest b ON a.pharmanagerequest_id = b.id
							LEFT JOIN requisition c ON b.requisition_id = c.id
							LEFT JOIN ancillary_items g ON c.item_id = g.id
							LEFT JOIN patients d ON c.patients_id = d.id
							LEFT JOIN refbrgy e ON d.brgy = e.id
		                    LEFT JOIN refcitymun f ON e.citymunCode = f.citymunCode
		                    LEFT JOIN refprovince h ON f.provCode = h.provCode
		                    LEFT JOIN mssclassification i ON d.id = i.patients_id
		                    WHERE a.mss_id IN(9)
		                    AND a.status = 'Y'
		                    AND a.price > 0
		                    AND DATE(a.created_at) >= ?
							AND DATE(a.created_at) <= ?
							ORDER BY a.id ASC
							", [$request->from, $request->to]);
				 //dd($transaction);
				$patients = DB::select("SELECT DISTINCT c.patients_id
							FROM sales a
							LEFT JOIN pharmanagerequest b ON a.pharmanagerequest_id = b.id
							LEFT JOIN requisition c ON b.requisition_id = c.id
		                    LEFT JOIN patients d ON c.patients_id = d.id
		                    LEFT JOIN mssclassification e ON d.id = e.patients_id
		                    LEFT JOIN ancillary_items f ON c.item_id = f.id
		                    WHERE a.mss_id IN(9)
		                    AND a.status = 'Y'
		                    AND a.price > 0
		                    AND DATE(a.created_at) >= ?
							AND DATE(a.created_at) <= ?
							", [$request->from, $request->to]);
						$from = Carbon::parse($_GET['from'])->format('m/d/Y');
						$to = Carbon::parse($_GET['to'])->format('m/d/Y');
						PDF::SetTitle('PHARMACY ISSUANCE FORM');
						// PDF::IncludeJS("print();");
						PDF::AddPage('P', 'LEGAL');
						PDF::Image('./public/images/doh-logo.png',20,10,25);
						PDF::Image('./public/images/evrmc-logo.png',170,10.5,18);
						PDF::SetFont('Times','',10);
						PDF::Text(190,20,"MSS CLASS-D",0,'C');
						PDF::SetXY(190,10);
						PDF::Cell(15,1,'PT : '.count($patients).'',0,0,'L');
						PDF::SetXY(190,15);
						PDF::Cell(15,1,'Rx : '.count($transaction).'',0,0,'L');
						PDF::SetXY(98,10);
						PDF::Cell(15,1,'REQUISITION AND ISSUE SLIP',0,0,'C');
						PDF::SetXY(98,10);
						PDF::Cell(17,15,'EASTERN VISAYAS REGIONAL MEDICAL CENTER',0,0,'C');
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
						PDF::Cell(1,15,'DATE: '.$from.' - '.$to.'',0,0,'L');

						PDF::SetFont('Times','',7);
						PDF::SetAutoPageBreak(TRUE, 0);
						
						$y = PDF::GetY() + 10;
					
						PDF::SetXY(3, $y);
						PDF::Cell(40,5,'NAME OF PATIENT',1,1,'C');
						PDF::SetXY(3+40, $y);
						PDF::Cell(7,5,'AGE',1,1,'C');
						PDF::SetXY(3+47, $y);
						PDF::Cell(53,5,'ADDRESS',1,1,'C');
						PDF::SetXY(3+100, $y);
						PDF::Cell(57,5,'GENERIC NAME',1,1,'C');
						PDF::SetXY(3+117+40, $y);
						PDF::Cell(25,5,'BRAND NAME',1,1,'C');
						PDF::SetXY(3+117+40+25, $y);
						PDF::Cell(12,5,'QTY',1,1,'C');
						PDF::SetXY(3+115+40+39, $y);
						PDF::Cell(15,5,'AMOUNT',1,1,'C');
						$l = 0;
						$totala = 0;
						foreach ($transaction as $list) {
							$y = PDF::GetY();
							if ($l == 59 || $l == 122 || $l == 185 || $l == 248 || $l == 311 || $l == 374 || $l == 437 || $l == 500 || $l == 563 || $l == 626 || $l == 689
							|| $l == 752 || $l == 815 || $l == 878 || $l == 941 || $l == 1004  || $l == 1067 || $l == 1130  || $l == 1193  || $l == 1256 || $l == 1319 
							|| $l == 1445 || $l == 1508) {
							PDF::SetAutoPageBreak(TRUE, 0);
							PDF::AddPage();
							$y = 25;	# code...
							}
							PDF::SetXY(3, $y);
							PDF::Cell(40,5,''.$list->patient_name.'',1,1,'L');
							PDF::SetXY(3+40, $y);
							PDF::Cell(7,5,''.$list->age.'',1,1,'C');
							PDF::SetXY(3+47, $y);
							PDF::Cell(53,5,''.$list->address.'',1,1,'L');
							PDF::SetXY(3+100, $y);
							PDF::Cell(57,5,''.$list->item_description.'',1,1,'L');
							PDF::SetXY(3+117+40, $y);
							PDF::Cell(25,5,''.$list->brand.'',1,1,'C');
							PDF::SetXY(3+117+40+25, $y);
							PDF::Cell(12,5,''.$list->qty.'',1,1,'C');
							PDF::SetXY(3+115+40+39, $y);
							PDF::Cell(15,5,''.number_format($list->total_amount, 2, '.', ',').'',1,1,'R');
							$totala += $list->total_amount;
						$l++;
						}
						$y = PDF::GetY();
							PDF::SetXY(3, $y);
							PDF::Cell(194,5,'TOTAL',1,1,'C');
							PDF::SetXY(3+115+40+39, $y);
							PDF::Cell(15,5,''.number_format($totala, 2, '.', ',').'',1,1,'R');
						
				        PDF::Output();

						return;
		}
		elseif ($request->filter == 'class-c') {
				$transaction = DB::select("SELECT f.label,f.description, a.or_no,
					 							CONCAT(d.last_name,', ',d.first_name,' ', LEFT(d.middle_name, 1), '.') as patient_name, 
					                            d.age,
					                            CONCAT(i.citymunDesc,', ',j.provDesc) as address,
					 					        g.item_description, g.brand, b.qty, (b.qty * a.price) as total_amount,
					 					        (CASE 
					 					        	WHEN f.discount
					 					        	THEN ((b.qty * a.price) * f.discount)
					 					        	ELSE 0
					 					        END) as discount_price,
					 					        (CASE 
					 					        	WHEN f.discount
					 					        	THEN ((b.qty * a.price) - ((b.qty * a.price) * f.discount))
					 					        	ELSE (b.qty * a.price)
					 					        END) as paid
					 					FROM sales a 
					 					LEFT JOIN pharmanagerequest b ON a.pharmanagerequest_id = b.id
					 					LEFT JOIN requisition c ON b.requisition_id = c.id
					 					LEFT JOIN ancillary_items g ON c.item_id = g.id
					 					LEFT JOIN patients d ON c.patients_id = d.id
					 					LEFT JOIN mssclassification e ON d.id = e.patients_id
					 					LEFT JOIN mss f ON a.mss_id = f.id
					                    LEFT JOIN refbrgy h ON d.brgy = h.id
					                    LEFT JOIN refcitymun i ON h.citymunCode = i.citymunCode
					                    LEFT JOIN refprovince j ON i.provCode = j.provCode
					                    WHERE a.mss_id IN(3,4,5,6,7,8)
					                    AND DATE(a.created_at) BETWEEN ? AND ?
										AND a.price > 0
										AND a.status = 'Y'
										AND a.void = '0'
					 					ORDER BY a.id ASC
					 					", [$request->from, $request->to]);
				$patients = DB::select("SELECT DISTINCT c.patients_id
							FROM sales a
							LEFT JOIN pharmanagerequest b ON a.pharmanagerequest_id = b.id
							LEFT JOIN requisition c ON b.requisition_id = c.id
		                    LEFT JOIN patients d ON c.patients_id = d.id
		                    LEFT JOIN mssclassification e ON d.id = e.patients_id
		                    WHERE a.mss_id IN(3,4,5,6,7,8)
		                    AND DATE(a.created_at) >= ?
							AND DATE(a.created_at) <= ?
							AND a.price > 0
							AND a.status = 'Y'
							AND a.void = '0'
							", [$request->from, $request->to]);
				// dd($transaction);
		$from = Carbon::parse($request->from)->format('m/d/Y');
		$to = Carbon::parse($request->to)->format('m/d/Y');
		PDF::SetTitle('PHARMACY ISSUANCE FORM');
		PDF::SetAutoPageBreak(TRUE, 0);
		PDF::AddPage('L', 'LEGAL');
		PDF::Image('./public/images/doh-logo.png',50,5,25);
		PDF::Image('./public/images/evrmc-logo.png',230+60,5,18);
		PDF::SetFont('Times','',10);
		PDF::Text(310,20,"MSS CLASS-C",0,'C');
		PDF::Text(250+60,10,'PT: '.count($patients).'');
		PDF::Text(250+60,15,'Rx: '.count($transaction).'');
		PDF::SetXY(140+35,5);
		PDF::Cell(15,1,'REQUISITION AND ISSUE SLIP',0,0,'C');
		PDF::SetXY(140+35,5);
		PDF::Cell(17,15,'EASTERN VISAYAS REGIONAL MEDICAL CENTER',0,0,'C');
		PDF::SetXY(140+35,10);
		PDF::Cell(16,15,'OUT PATIENT DEPARTMENT',0,0,'C');
		PDF::SetFont('Times','',8);
		PDF::SetXY(140+35,15);
		PDF::Cell(16,15,'CABALAWAN TACLOBAN CITY, LEYTE, PHILIPPINES',0,0,'C');
		PDF::SetXY(10,17);
		PDF::Cell(16,15,"________________________________________________________________________________________________________________________________________________________________________________________________________________________________________",0,0,'');

		PDF::SetFont('Times','',10);
		PDF::SetXY(140+35,21);
		PDF::Cell(16,15,'ISSUANCE FORM',0,0,'C');
		PDF::SetXY(5,21);
		PDF::Cell(1,15,'DATE: '.$from.' - '.$to.'',0,0,'L');
		$y = PDF::GetY() + 10;
		PDF::SetXY(5, $y);
		PDF::MultiCell(35,10,"CLASSIFICATION &\n OR#",1,'C',false);
		PDF::SetXY(5+35, $y);
		PDF::MultiCell(70,10,"NAME OF PATIENT",1,'C',false);
		PDF::SetXY(5+85+20, $y);
		PDF::MultiCell(10,10,"AGE",1,'C',false);
		PDF::SetXY(5+95+20, $y);
		PDF::MultiCell(60,10,"ADDRESS",1,'C',false);
		PDF::SetXY(5+95+50+30, $y);
		PDF::MultiCell(60,10,"GENERIC NAME",1,'C',false);
		PDF::SetXY(5+95+100+40, $y);
		PDF::MultiCell(35,10,"BRAND NAME",1,'C',false);
		PDF::SetXY(5+95+100+35+40, $y);
		PDF::MultiCell(10,10,"QTY",1,'C',false);
		PDF::SetXY(5+95+100+35+50, $y);
		PDF::MultiCell(17,10,"TOTAL \nAMT.",1,'C',false);
		PDF::SetXY(5+95+100+35+10+17+40, $y);
		PDF::MultiCell(45,5,"DISCOUNTED",1,'C',false);
		PDF::SetXY(5+95+100+35+10+17+40, $y+5);
		PDF::SetFont('Times','',7);
		PDF::MultiCell(23,5,"AMT.PAID",1,'C',false);
		PDF::SetXY(5+95+100+35+10+17+15+48, $y+5);
		PDF::MultiCell(22,5,"AMT",1,'C',false);

		PDF::SetFont('Times','',8);
		$r = 0;
		$totala = 0;
		$totald = 0;
		$totalp = 0;
		foreach ($transaction as $list) {
		$y = PDF::GetY();
		if ($r == 32 || $r == 67 || $r == 102 || $r == 137 || $r == 172 || $r == 207 || $r == 137 || $r == 242 || $r == 277 || $r == 312 || $r == 347 || $r == 382 || $r == 417
			|| $r == 452 || $r == 487 || $r == 522 || $r == 557 || $r == 592 || $r == 627 || $r == 662 || $r == 697 || $r == 732 || $r == 767 || $r == 802 || $r == 837 || $r == 872
			|| $r == 907 || $r == 942 || $r == 977 || $r == 1012) {
		PDF::SetAutoPageBreak(TRUE, 0);
		PDF::AddPage('L');
		$y = 25;	# code...
		}
		PDF::SetXY(5, $y);
		PDF::Cell(35,5,''.$list->label.'-'.$list->description.'% - '.$list->or_no.'',1,1,'C');
		PDF::SetXY(5+35, $y);
		PDF::Cell(70,5,''.$list->patient_name.'',1,1,'L');
		PDF::SetXY(5+85+20, $y);
		PDF::Cell(10,5,''.$list->age.'',1,1,'C');
		PDF::SetXY(5+95+20, $y);
		PDF::SetFont('Times','',7);
		PDF::Cell(60,5,''.$list->address.'',1,1,'L');
		PDF::SetXY(5+95+50+30, $y);
		PDF::Cell(60,5,''.$list->item_description.'',1,1,'L');
		PDF::SetFont('Times','',8);
		PDF::SetXY(5+95+100+40, $y);
		PDF::Cell(35,5,''.$list->brand.'',1,1,'C');
		PDF::SetXY(5+95+100+35+40, $y);
		PDF::Cell(10,5,''.$list->qty.'',1,1,'C');
		PDF::SetXY(5+95+100+35+10+40, $y);
		PDF::Cell(17,5,''.number_format($list->total_amount, 2, '.', ',').'',1,1,'R');

		$totala += $list->total_amount;
		PDF::SetXY(5+95+100+35+10+17+40, $y);
		PDF::Cell(23,5,''.number_format($list->paid, 2, '.', ',').'',1,1,'R');
		$totald += $list->discount_price;
		PDF::SetXY(5+95+100+35+10+17+15+48, $y);
		PDF::Cell(22,5,''.number_format($list->discount_price, 2, '.', ',').'',1,1,'R');
		$totalp += $list->paid;
		$r++;
		}
		
		$y = PDF::GetY();
		PDF::SetXY(5, $y);
		PDF::Cell(280,5,'TOTAL',1,1,'C');
		PDF::SetXY(5+95+100+35+10+40, $y);
		PDF::Cell(17,5,''.number_format($totala, 2, '.', ',').'',1,1,'R');
		PDF::SetXY(5+95+100+35+10+17+40, $y);
		PDF::Cell(23,5,''.number_format($totalp, 2, '.', ',').'',1,1,'R');
		PDF::SetXY(5+95+100+35+10+17+15+48, $y);
		PDF::Cell(22,5,''.number_format($totald, 2, '.', ',').'',1,1,'R');
		PDF::Output();
		return;



		}elseif ($request->filter == 'free-meds') {
			$transaction = DB::select("SELECT d.id,
						CONCAT(d.last_name,', ',d.first_name,' ', LEFT(d.middle_name, 1), '.') as patient_name,
						d.age,
						CONCAT(f.citymunDesc,', ',h.provDesc) as address,
						g.item_description,
						g.brand,
						b.qty,
						a.price
						FROM sales a 
						LEFT JOIN pharmanagerequest b ON a.pharmanagerequest_id = b.id
						LEFT JOIN requisition c ON b.requisition_id = c.id
						LEFT JOIN ancillary_items g ON c.item_id = g.id
						LEFT JOIN patients d ON c.patients_id = d.id
						LEFT JOIN refbrgy e ON d.brgy = e.id
	                    LEFT JOIN refcitymun f ON e.citymunCode = f.citymunCode
	                    LEFT JOIN refprovince h ON f.provCode = h.provCode
	                    WHERE a.status = 'Y'
	                    AND a.price <= 0
	                    AND DATE(a.created_at) >= ?
						AND DATE(a.created_at) <= ?
						ORDER BY a.id ASC
						", [$request->from, $request->to]);
			// dd($transaction);
			$patients = DB::select("SELECT DISTINCT c.patients_id
						FROM sales a
						LEFT JOIN pharmanagerequest b ON a.pharmanagerequest_id = b.id
						LEFT JOIN requisition c ON b.requisition_id = c.id
	                    LEFT JOIN patients d ON c.patients_id = d.id
	                    LEFT JOIN ancillary_items f ON c.item_id = f.id
	                    WHERE a.status = 'Y'
	                    AND a.price <= 0
	                    AND DATE(a.created_at) >= ?
						AND DATE(a.created_at) <= ?
						", [$request->from, $request->to]);
			$from = Carbon::parse($_GET['from'])->format('m/d/Y');
			$to = Carbon::parse($_GET['to'])->format('m/d/Y');
			PDF::SetTitle('PHARMACY ISSUANCE FORM');
			// PDF::IncludeJS("print();");
			PDF::AddPage('P', 'LEGAL');
			PDF::Image('./public/images/doh-logo.png',20,10,25);
			PDF::Image('./public/images/evrmc-logo.png',170,10.5,18);
			PDF::SetFont('Times','',10);
			PDF::Text(190,20,"FREE MEDS",0,'C');
			PDF::SetXY(190,10);
			PDF::Cell(15,1,'PT : '.count($patients).'',0,0,'L');
			PDF::SetXY(190,15);
			PDF::Cell(15,1,'Rx : '.count($transaction).'',0,0,'L');
			PDF::SetXY(98,10);
			PDF::Cell(15,1,'REQUISITION AND ISSUE SLIP',0,0,'C');
			PDF::SetXY(98,10);
			PDF::Cell(17,15,'EASTERN VISAYAS REGIONAL MEDICAL CENTER',0,0,'C');
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
			PDF::Cell(1,15,'DATE: '.$from.' - '.$to.'',0,0,'L');

			PDF::SetFont('Times','',7);
			PDF::SetAutoPageBreak(TRUE, 0);
			
			$y = PDF::GetY() + 10;
		
			PDF::SetXY(3, $y);
			PDF::Cell(40,5,'NAME OF PATIENT',1,1,'C');
			PDF::SetXY(3+40, $y);
			PDF::Cell(7,5,'AGE',1,1,'C');
			PDF::SetXY(3+47, $y);
			PDF::Cell(53,5,'ADDRESS',1,1,'C');
			PDF::SetXY(3+100, $y);
			PDF::Cell(57,5,'GENERIC NAME',1,1,'C');
			PDF::SetXY(3+117+40, $y);
			PDF::Cell(35,5,'BRAND NAME',1,1,'C');
			PDF::SetXY(3+117+40+35, $y);
			PDF::Cell(17,5,'QTY',1,1,'C');
			
			$l = 0;
			$totala = 0;
			foreach ($transaction as $list) {
				$y = PDF::GetY();
				if ($l == 59 || $l == 122 || $l == 185 || $l == 248 || $l == 311 || $l == 374 || $l == 437 || $l == 500 || $l == 563 || $l == 626 || $l == 689
							|| $l == 752 || $l == 815 || $l == 878 || $l == 941 || $l == 1004  || $l == 1067 || $l == 1130  || $l == 1193  || $l == 1256 || $l == 1319 
							|| $l == 1445 || $l == 1508)  {
				PDF::SetAutoPageBreak(TRUE, 0);
				PDF::AddPage();
				$y = 25;	# code...
				}
				PDF::SetXY(3, $y);
				PDF::Cell(40,5,''.$list->patient_name.'',1,1,'L');
				PDF::SetXY(3+40, $y);
				PDF::Cell(7,5,''.$list->age.'',1,1,'C');
				PDF::SetXY(3+47, $y);
				PDF::Cell(53,5,''.$list->address.'',1,1,'L');
				PDF::SetXY(3+100, $y);
				PDF::Cell(57,5,''.$list->item_description.'',1,1,'L');
				PDF::SetXY(3+117+40, $y);
				PDF::Cell(35,5,''.$list->brand.'',1,1,'C');
				PDF::SetXY(3+117+40+35, $y);
				PDF::Cell(17,5,''.$list->qty.'',1,1,'C');
				
			$l++;
			}
			
	        PDF::Output();

			return;
		}elseif ($request->filter == 'all') {
			$transaction = DB::select("SELECT f.label,f.description, a.or_no,
				 							CONCAT(d.last_name,', ',d.first_name,' ', LEFT(d.middle_name, 1), '.') as patient_name, 
				                            d.age,
				                            CONCAT(i.citymunDesc,', ',j.provDesc) as address,
				 					        g.item_description, g.brand, b.qty, (b.qty * a.price) as total_amount,
				 					        (CASE 
				 					        	WHEN f.discount
				 					        	THEN ((b.qty * a.price) * f.discount)
				 					        	ELSE 0
				 					        END) as discount_price,
				 					        (CASE 
				 					        	WHEN f.discount
				 					        	THEN ((b.qty * a.price) - ((b.qty * a.price) * f.discount))
				 					        	ELSE (b.qty * a.price)
				 					        END) as paid,
				 					        a.mss_id
				 					FROM sales a 
				 					LEFT JOIN pharmanagerequest b ON a.pharmanagerequest_id = b.id
				 					LEFT JOIN requisition c ON b.requisition_id = c.id
				 					LEFT JOIN ancillary_items g ON c.item_id = g.id
				 					LEFT JOIN patients d ON c.patients_id = d.id
				 					LEFT JOIN mssclassification e ON d.id = e.patients_id
				 					LEFT JOIN mss f ON a.mss_id = f.id
				                    LEFT JOIN refbrgy h ON d.brgy = h.id
				                    LEFT JOIN refcitymun i ON h.citymunCode = i.citymunCode
				                    LEFT JOIN refprovince j ON i.provCode = j.provCode
				                    WHERE DATE(a.created_at) >= ?
									AND DATE(a.created_at) <= ?
									AND a.status = 'Y'
									AND a.void = '0'
				 					ORDER BY a.id ASC
				 					", [$request->from, $request->to]);
			$patients = DB::select("SELECT DISTINCT c.patients_id
						FROM sales a
						LEFT JOIN pharmanagerequest b ON a.pharmanagerequest_id = b.id
						LEFT JOIN requisition c ON b.requisition_id = c.id
	                    LEFT JOIN patients d ON c.patients_id = d.id
	                    LEFT JOIN mssclassification e ON d.id = e.patients_id
	                    WHERE DATE(a.created_at) >= ?
						AND DATE(a.created_at) <= ?
						AND a.status = 'Y'
						AND a.void = '0'
						", [$request->from, $request->to]);
			// dd($transaction);
			$from = Carbon::parse($request->from)->format('m/d/Y');
			$to = Carbon::parse($request->to)->format('m/d/Y');
			PDF::SetTitle('PHARMACY ISSUANCE FORM');
			PDF::SetAutoPageBreak(TRUE, 0);
			PDF::AddPage('L', 'LEGAL');
			PDF::Image('./public/images/doh-logo.png',50,5,25);
			PDF::Image('./public/images/evrmc-logo.png',230+60,5,18);
			PDF::SetFont('Times','',10);
			// PDF::Text(310,20,"MSS CLASS-C",0,'C');
			PDF::Text(250+60,10,'PT: '.count($patients).'');
			PDF::Text(250+60,15,'Rx: '.count($transaction).'');
			PDF::SetXY(140+35,5);
			PDF::Cell(15,1,'REQUISITION AND ISSUE SLIP',0,0,'C');
			PDF::SetXY(140+35,5);
			PDF::Cell(17,15,'EASTERN VISAYAS REGIONAL MEDICAL CENTER',0,0,'C');
			PDF::SetXY(140+35,10);
			PDF::Cell(16,15,'OUT PATIENT DEPARTMENT',0,0,'C');
			PDF::SetFont('Times','',8);
			PDF::SetXY(140+35,15);
			PDF::Cell(16,15,'CABALAWAN TACLOBAN CITY, LEYTE, PHILIPPINES',0,0,'C');
			PDF::SetXY(10,17);
			PDF::Cell(16,15,"________________________________________________________________________________________________________________________________________________________________________________________________________________________________________",0,0,'');

			PDF::SetFont('Times','',10);
			PDF::SetXY(140+35,21);
			PDF::Cell(16,15,'ISSUANCE FORM',0,0,'C');
			PDF::SetXY(5,21);
			PDF::Cell(1,15,'DATE: '.$from.' - '.$to.'',0,0,'L');
			$y = PDF::GetY() + 10;
			PDF::SetXY(5, $y);
			PDF::MultiCell(35,10,"CLASSIFICATION &\n OR#",1,'C',false);
			PDF::SetXY(5+35, $y);
			PDF::MultiCell(70,10,"NAME OF PATIENT",1,'C',false);
			PDF::SetXY(5+85+20, $y);
			PDF::MultiCell(10,10,"AGE",1,'C',false);
			PDF::SetXY(5+95+20, $y);
			PDF::MultiCell(60,10,"ADDRESS",1,'C',false);
			PDF::SetXY(5+95+50+30, $y);
			PDF::MultiCell(60,10,"GENERIC NAME",1,'C',false);
			PDF::SetXY(5+95+100+40, $y);
			PDF::MultiCell(35,10,"BRAND NAME",1,'C',false);
			PDF::SetXY(5+95+100+35+40, $y);
			PDF::MultiCell(10,10,"QTY",1,'C',false);
			PDF::SetXY(5+95+100+35+50, $y);
			PDF::MultiCell(17,10,"TOTAL \nAMT.",1,'C',false);
			PDF::SetXY(5+95+100+35+10+17+40, $y);
			PDF::MultiCell(45,5,"DISCOUNTED",1,'C',false);
			PDF::SetXY(5+95+100+35+10+17+40, $y+5);
			PDF::SetFont('Times','',7);
			PDF::MultiCell(23,5,"AMT.PAID",1,'C',false);
			PDF::SetXY(5+95+100+35+10+17+15+48, $y+5);
			PDF::MultiCell(22,5,"AMT",1,'C',false);

			PDF::SetFont('Times','',8);
			$r = 0;
			$totala = 0;
			$totald = 0;
			$totalp = 0;
			foreach ($transaction as $list) {
			$y = PDF::GetY();
			if ($r == 32 || $r == 67 || $r == 102 || $r == 137 || $r == 172 || $r == 207 || $r == 137 || $r == 242 || $r == 277 || $r == 312 || $r == 347 || $r == 382 || $r == 417
				|| $r == 452 || $r == 487 || $r == 522 || $r == 557 || $r == 592 || $r == 627 || $r == 662 || $r == 697 || $r == 732 || $r == 767 || $r == 802 || $r == 837 || $r == 872
				|| $r == 907 || $r == 942 || $r == 977 || $r == 1012) {
			PDF::SetAutoPageBreak(TRUE, 0);
			PDF::AddPage('L');
			$y = 25;	# code...
			}
			PDF::SetXY(5, $y);
			if ($list->mss_id) {
				if(is_numeric($list->description)){
					if (strlen($list->or_no) > 7) {
						PDF::Cell(35,5,''.$list->label.'-'.$list->description.'%',1,1,'C');
					}else{
						PDF::Cell(35,5,''.$list->label.'-'.$list->description.'% - '.$list->or_no.'',1,1,'C');
					}
					
				}else{
					PDF::Cell(35,5,''.$list->label.'-'.$list->description.'',1,1,'C');
				}
			}else{
				PDF::SetFont('Times','B',9);
				PDF::Cell(35,5,'N/A - '.$list->or_no.'',1,1,'C');

			}
			PDF::SetFont('Times','',8);
			
			PDF::SetXY(5+35, $y);
			PDF::Cell(70,5,''.$list->patient_name.'',1,1,'L');
			PDF::SetXY(5+85+20, $y);
			PDF::Cell(10,5,''.$list->age.'',1,1,'C');
			PDF::SetXY(5+95+20, $y);
			PDF::SetFont('Times','',7);
			PDF::Cell(60,5,''.$list->address.'',1,1,'L');
			PDF::SetXY(5+95+50+30, $y);
			PDF::Cell(60,5,''.$list->item_description.'',1,1,'L');
			PDF::SetFont('Times','',8);
			PDF::SetXY(5+95+100+40, $y);
			PDF::Cell(35,5,''.$list->brand.'',1,1,'C');
			PDF::SetXY(5+95+100+35+40, $y);
			PDF::Cell(10,5,''.$list->qty.'',1,1,'C');
			PDF::SetXY(5+95+100+35+10+40, $y);
			PDF::Cell(17,5,''.number_format($list->total_amount, 2, '.', ',').'',1,1,'R');

			$totala += $list->total_amount;
			PDF::SetXY(5+95+100+35+10+17+40, $y);
			PDF::Cell(23,5,''.number_format($list->paid, 2, '.', ',').'',1,1,'R');
			$totald += $list->discount_price;
			PDF::SetXY(5+95+100+35+10+17+15+48, $y);
			PDF::Cell(22,5,''.number_format($list->discount_price, 2, '.', ',').'',1,1,'R');
			$totalp += $list->paid;
			$r++;
			}
			
			$y = PDF::GetY();
			PDF::SetXY(5, $y);
			PDF::Cell(280,5,'TOTAL',1,1,'C');
			PDF::SetXY(5+95+100+35+10+40, $y);
			PDF::Cell(17,5,''.number_format($totala, 2, '.', ',').'',1,1,'R');
			PDF::SetXY(5+95+100+35+10+17+40, $y);
			PDF::Cell(23,5,''.number_format($totalp, 2, '.', ',').'',1,1,'R');
			PDF::SetXY(5+95+100+35+10+17+15+48, $y);
			PDF::Cell(22,5,''.number_format($totald, 2, '.', ',').'',1,1,'R');
			PDF::Output();
			return;

		}
		elseif ($request->filter == "full-pay") {
			$transaction = DB::select("SELECT f.label,f.description, a.or_no,
					 							CONCAT(d.last_name,', ',d.first_name,' ', LEFT(d.middle_name, 1), '.') as patient_name, 
					                            d.age,
					                            CONCAT(i.citymunDesc,', ',j.provDesc) as address,
					 					        g.item_description, g.brand, b.qty, (b.qty * a.price) as total_amount,
					 					        (CASE 
					 					        	WHEN f.discount
					 					        	THEN ((b.qty * a.price) * f.discount)
					 					        	ELSE 0
					 					        END) as discount_price,
					 					        (CASE 
					 					        	WHEN f.discount
					 					        	THEN ((b.qty * a.price) - ((b.qty * a.price) * f.discount))
					 					        	ELSE (b.qty * a.price)
					 					        END) as paid
					 					FROM sales a 
					 					LEFT JOIN pharmanagerequest b ON a.pharmanagerequest_id = b.id
					 					LEFT JOIN requisition c ON b.requisition_id = c.id
					 					LEFT JOIN ancillary_items g ON c.item_id = g.id
					 					LEFT JOIN patients d ON c.patients_id = d.id
					 					LEFT JOIN mssclassification e ON d.id = e.patients_id
					 					LEFT JOIN mss f ON a.mss_id = f.id
					                    LEFT JOIN refbrgy h ON d.brgy = h.id
					                    LEFT JOIN refcitymun i ON h.citymunCode = i.citymunCode
					                    LEFT JOIN refprovince j ON i.provCode = j.provCode
					                    WHERE a.mss_id IN(0)
					                    AND DATE(a.created_at) >= ?
										AND DATE(a.created_at) <= ?
										AND a.price > 0
										AND a.status = 'Y'
										AND a.void = '0'
					 					ORDER BY a.id ASC
					 					", [$request->from, $request->to]);
				$patients = DB::select("SELECT DISTINCT c.patients_id
							FROM sales a
							LEFT JOIN pharmanagerequest b ON a.pharmanagerequest_id = b.id
							LEFT JOIN requisition c ON b.requisition_id = c.id
		                    LEFT JOIN patients d ON c.patients_id = d.id
		                    LEFT JOIN mssclassification e ON d.id = e.patients_id
		                    WHERE a.mss_id IN(0)
		                    AND DATE(a.created_at) >= ?
							AND DATE(a.created_at) <= ?
							AND a.price > 0
							AND a.status = 'Y'
							AND a.void = '0'
							", [$request->from, $request->to]);
				// dd($transaction);
		$from = Carbon::parse($request->from)->format('m/d/Y');
		$to = Carbon::parse($request->to)->format('m/d/Y');
		PDF::SetTitle('PHARMACY ISSUANCE FORM');
		PDF::SetAutoPageBreak(TRUE, 0);
		PDF::AddPage('L', 'LEGAL');
		PDF::Image('./public/images/doh-logo.png',50,5,25);
		PDF::Image('./public/images/evrmc-logo.png',230+60,5,18);
		PDF::SetFont('Times','',10);
		PDF::Text(310,20,"FULL PAY",0,'C');
		PDF::Text(250+60,10,'PT: '.count($patients).'');
		PDF::Text(250+60,15,'Rx: '.count($transaction).'');
		PDF::SetXY(140+35,5);
		PDF::Cell(15,1,'REQUISITION AND ISSUE SLIP',0,0,'C');
		PDF::SetXY(140+35,5);
		PDF::Cell(17,15,'EASTERN VISAYAS REGIONAL MEDICAL CENTER',0,0,'C');
		PDF::SetXY(140+35,10);
		PDF::Cell(16,15,'OUT PATIENT DEPARTMENT',0,0,'C');
		PDF::SetFont('Times','',8);
		PDF::SetXY(140+35,15);
		PDF::Cell(16,15,'CABALAWAN TACLOBAN CITY, LEYTE, PHILIPPINES',0,0,'C');
		PDF::SetXY(10,17);
		PDF::Cell(16,15,"________________________________________________________________________________________________________________________________________________________________________________________________________________________________________",0,0,'');

		PDF::SetFont('Times','',10);
		PDF::SetXY(140+35,21);
		PDF::Cell(16,15,'ISSUANCE FORM',0,0,'C');
		PDF::SetXY(5,21);
		PDF::Cell(1,15,'DATE: '.$from.' - '.$to.'',0,0,'L');
		$y = PDF::GetY() + 10;
		PDF::SetXY(5, $y);
		PDF::MultiCell(35,10,"OR#",1,'C',false);
		PDF::SetXY(5+35, $y);
		PDF::MultiCell(70,10,"NAME OF PATIENT",1,'C',false);
		PDF::SetXY(5+85+20, $y);
		PDF::MultiCell(10,10,"AGE",1,'C',false);
		PDF::SetXY(5+95+20, $y);
		PDF::MultiCell(60,10,"ADDRESS",1,'C',false);
		PDF::SetXY(5+95+50+30, $y);
		PDF::MultiCell(60,10,"GENERIC NAME",1,'C',false);
		PDF::SetXY(5+95+100+40, $y);
		PDF::MultiCell(35,10,"BRAND NAME",1,'C',false);
		PDF::SetXY(5+95+100+35+40, $y);
		PDF::MultiCell(10,10,"QTY",1,'C',false);
		PDF::SetXY(5+95+100+35+50, $y);
		PDF::MultiCell(17,10,"TOTAL \nAMT.",1,'C',false);
		
		PDF::SetXY(5+95+100+35+10+17+40, $y);
		PDF::SetFont('Times','',7);
		PDF::MultiCell(45,10,"AMT.PAID",1,'C',false);
		

		PDF::SetFont('Times','',8);
		$r = 0;
		$totala = 0;
		$totald = 0;
		$totalp = 0;
		foreach ($transaction as $list) {
		$y = PDF::GetY();
		if ($r == 32 || $r == 67 || $r == 102 || $r == 137 || $r == 172 || $r == 207 || $r == 137 || $r == 242 || $r == 277 || $r == 312 || $r == 347 || $r == 382 || $r == 417
			|| $r == 452 || $r == 487 || $r == 522 || $r == 557 || $r == 592 || $r == 627 || $r == 662 || $r == 697 || $r == 732 || $r == 767 || $r == 802 || $r == 837 || $r == 872
			|| $r == 907 || $r == 942 || $r == 977 || $r == 1012) {
		PDF::SetAutoPageBreak(TRUE, 0);
		PDF::AddPage('L');
		$y = 25;	# code...
		}
		PDF::SetXY(5, $y);
		PDF::Cell(35,5,''.$list->or_no.'',1,1,'C');
		PDF::SetXY(5+35, $y);
		PDF::Cell(70,5,''.$list->patient_name.'',1,1,'L');
		PDF::SetXY(5+85+20, $y);
		PDF::Cell(10,5,''.$list->age.'',1,1,'C');
		PDF::SetXY(5+95+20, $y);
		PDF::SetFont('Times','',7);
		PDF::Cell(60,5,''.$list->address.'',1,1,'L');
		PDF::SetXY(5+95+50+30, $y);
		PDF::Cell(60,5,''.$list->item_description.'',1,1,'L');
		PDF::SetFont('Times','',8);
		PDF::SetXY(5+95+100+40, $y);
		PDF::Cell(35,5,''.$list->brand.'',1,1,'C');
		PDF::SetXY(5+95+100+35+40, $y);
		PDF::Cell(10,5,''.$list->qty.'',1,1,'C');
		PDF::SetXY(5+95+100+35+10+40, $y);
		PDF::Cell(17,5,''.number_format($list->total_amount, 2, '.', ',').'',1,1,'R');

		$totala += $list->total_amount;
		PDF::SetXY(5+95+100+35+10+17+40, $y);
		PDF::Cell(45,5,''.number_format($list->paid, 2, '.', ',').'',1,1,'R');
		$totald += $list->discount_price;
		// PDF::SetXY(5+95+100+35+10+17+15+48, $y);
		// PDF::Cell(22,5,''.number_format($list->discount_price, 2, '.', ',').'',1,1,'R');
		$totalp += $list->paid;
		$r++;
		}
		
		$y = PDF::GetY();
		PDF::SetXY(5, $y);
		PDF::Cell(280,5,'TOTAL',1,1,'C');
		PDF::SetXY(5+95+100+35+10+40, $y);
		PDF::Cell(17,5,''.number_format($totala, 2, '.', ',').'',1,1,'R');
		PDF::SetXY(5+95+100+35+10+17+40, $y);
		PDF::Cell(45,5,''.number_format($totalp, 2, '.', ',').'',1,1,'R');
		// PDF::SetXY(5+95+100+35+10+17+15+48, $y);
		// PDF::Cell(22,5,''.number_format($totald, 2, '.', ',').'',1,1,'R');
		PDF::Output();
		return;

		}{
		return view("pharmacy.reports");
		}
	}
	public function exportmedicineotpdf(Request $request)
	{
		if ($request->stats == "all") {
			$medicine = DB::select("SELECT a.*, b.stock, c.status
								FROM ancillary_items a 
								LEFT JOIN pharstocks b ON a.id = b.items_id 
								LEFT JOIN pharitemstatus c ON a.id = c.items_id
								WHERE a.clinic_code = 1031
								ORDER BY a.item_description ASC");
		}else{
			if ($request->stats == "deleted") {
				$medicine = DB::select("SELECT a.*, b.stock, c.status
									FROM ancillary_items a 
									LEFT JOIN pharstocks b ON a.id = b.items_id 
									LEFT JOIN pharitemstatus c ON a.id = c.items_id
									WHERE a.clinic_code = 1031
									AND a.trash = 'Y'
									ORDER BY a.item_description ASC");
			}else if ($request->stats == "inactive") {
				$medicine = DB::select("SELECT a.*, b.stock, c.status
									FROM ancillary_items a 
									LEFT JOIN pharstocks b ON a.id = b.items_id 
									LEFT JOIN pharitemstatus c ON a.id = c.items_id
									WHERE a.clinic_code = 1031
									AND a.trash = 'N'
									AND c.status = 'N'
									ORDER BY a.item_description ASC");
			}else if ($request->stats == "active"){
				$medicine = DB::select("SELECT a.*, b.stock, c.status
									FROM ancillary_items a 
									LEFT JOIN pharstocks b ON a.id = b.items_id 
									LEFT JOIN pharitemstatus c ON a.id = c.items_id
									WHERE a.clinic_code = 1031
									AND a.trash = 'N'
									AND c.status = 'Y'
									ORDER BY a.item_description ASC");
			}
		}
		
		// dd($medicine);
		PDF::SetTitle('PHARMACY INVENTORY');
		// PDF::IncludeJS("print();");
		PDF::AddPage();
		PDF::Image('./public/images/doh-logo.png',20,10,25);
		PDF::Image('./public/images/evrmc-logo.png',170,10.5,18);
		PDF::SetFont('Times','',10);
		PDF::SetXY(98,10);
		PDF::Cell(15,1,'REQUISITION AND ISSUE SLIP',0,0,'C');
		PDF::SetXY(98,10);

		PDF::Cell(17,15,'EASTERN VISAYAS REGIONAL MEDICAL CENTER',0,0,'C');
		PDF::Text(155,30,''.strtoupper($request->stats).' MEDICINES');
		PDF::SetXY(98,15);
		PDF::Cell(16,15,'OUT PATIENT DEPARTMENT',0,0,'C');
		PDF::SetFont('Times','',8);
		PDF::SetXY(98,20);
		PDF::Cell(16,15,'CABALAWAN TACLOBAN CITY, LEYTE, PHILIPPINES',0,0,'C');

		PDF::SetXY(98,25);
		PDF::Cell(16,15,"____________________________________________________________________________________________________________________________",0,0,'C');

		$y = PDF::GetY()+12;
		PDF::SetXY(15,$y);
		PDF::Cell(10,5,"#",1,1,'C');
		PDF::SetXY(25,$y);
		PDF::Cell(40,5,"BRAND",1,1,'C');
		PDF::SetXY(65,$y);
		PDF::Cell(80,5,"GENERIC NAME",1,1,'C');
		PDF::SetXY(145,$y);
		PDF::Cell(25,5,"EXPIRE DATE",1,1,'C');
		PDF::SetXY(170,$y);
		PDF::Cell(25,5,"STOCK",1,1,'C');
		$r = 1;
		foreach ($medicine as $list) {
			$y = PDF::GetY();
			if ($r == 45 || $r == 93 || $r == 141 || $r == 189 || $r == 237 || $r == 285 || $r == 333 || $r == 381 || $r == 429 || $r == 477 || $r == 525 || $r == 573 || $r == 621
				|| $r == 669 || $r == 717 || $r == 765) {
			PDF::SetAutoPageBreak(TRUE, 0);
			PDF::AddPage();
			$y = 30;	# code...
			}
			PDF::SetXY(15,$y);
			PDF::Cell(10,5,$r,1,1,'C');
			PDF::SetXY(25,$y);
			PDF::Cell(40,5,$list->brand,1,1,'');
			PDF::SetXY(65,$y);
			PDF::Cell(80,5,$list->item_description,1,1,'');
			PDF::SetXY(145,$y);
			PDF::Cell(25,5,Carbon::parse($list->expire_date)->format('m/d/Y'),1,1,'C');
			PDF::SetXY(170,$y);
			PDF::Cell(25,5,$list->stock,1,1,'C');
		$r++;
		}

		PDF::Output();

		return;
	}
	public function pharmacycencus(Request $request)
	{
		$month = DB::select("SELECT DATE(created_at) as dates, MONTH(created_at) as months FROM sales WHERE sales.status = 'Y' AND sales.void = '0' GROUP BY MONTH(created_at)");
		$year = DB::select("SELECT DATE(created_at) as dates, year(created_at) as years FROM sales WHERE sales.status = 'Y' AND sales.void = '0' GROUP BY year(created_at)");
		return view('pharmacy.census', compact('request', 'month', 'year'));
	}
	public function transactions(Request $request)
	{
		return view('pharmacy.transactions');
	}

}


?>