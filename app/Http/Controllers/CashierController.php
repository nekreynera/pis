<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Patient;
use App\Mss;
use App\Mssclassification;
use App\User;
use App\Cashrecieptno;
use App\Cashidsale;
use App\Sales;
use App\ConvertNumberToWord;
use App\Cashmanualsale;
use App\Cashcredintials;
use App\Cashincomecategory;
use App\Cashincomesubcategory;
use App\Cashincome;
use App\Ancillaryrequist;
use App\Requisition;
use App\Pharmanagerequest;
use App\LaboratorySubList;
use App\LaboratoryPayment;
use App\LaboratoryRequest;
use App\LaboratoryRequestGroup;
use App\Alert;

use App\Refprovince;
use App\Refbrgy;
use App\Refcitymun;
use App\Refregion;
USE App\Triage;

use Validator;
use PDF;
use DNS1D;
use DB;
use Carbon;
use Auth;
use Session;

class CashierController extends Controller
{
		

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$patients = DB::select("SELECT id, 
										hospital_no, 
										CONCAT(first_name, ' ',middle_name, ' ',last_name) AS name, 
										age 
								FROM patients 
								WHERE DATE(created_at) = CURRENT_DATE()
                                AND id NOT IN(select patients_id from cashidsale)
								ORDER BY id DESC");
		$months = DB::select("SELECT DATE(created_at) as months 
								FROM patients
								GROUP BY MONTH(created_at)
								ORDER BY created_at DESC");
		// $reciept = Cashrecieptno::where('user_id', '=', Auth::user()->id)
		// 			->get()
		// 			->first();
		// dd(Auth::user()->id);
		$alert = Alert::where('clinic', Auth::user()->id)->first();
				if ($request->alert) {
				    if (!$alert) {
				        $store = new Alert();
				        $store->clinic = Auth::user()->id;
				        $store->save();
				    }
				    $alert = Alert::where('clinic', Auth::user()->id)->first();
				}

		$regions = Refregion::all();
		$provinces = Refprovince::where('regCode', '=', '08')->get();
		$citys = Refcitymun::where('provCode', '=', '0837')->get();
		$brgys = Refbrgy::where('citymunCode', '=', '083747')->get();
		return view('cashier.home', compact('patients', 'months', 'alert', 'regions', 'provinces', 'citys', 'brgys'));
		// return view('cashier.home', compact('patients', 'months'));
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
	public function getpatientbymonth(Request $request)
	{
		$date = explode('-', $request->date);

		$patients =	DB::select("SELECT id, hospital_no, CONCAT(first_name, ' ',middle_name, ' ',last_name) AS name, age 
			 			FROM patients 
						WHERE MONTH(created_at) = ?
						AND YEAR(created_at) = ? 
						AND id NOT IN(select patients_id from cashidsale)
						ORDER BY first_name ASC", [$date[1], $date[0]]);
		echo json_encode($patients);
		return;
	}
	public function reprintbymonth()
	{
		$months = DB::select("SELECT DATE(created_at) as months 
								FROM patients
								WHERE id NOT IN(select patients_id from cashidsale)
								GROUP BY MONTH(created_at)
								ORDER BY created_at DESC");
		echo json_encode($months);
		return;
	}
	public function reprintgetpatientbymonth(Request $request)
	{
		$date = explode('-', $request->date);

		$patients =	DB::select("SELECT b.id, 
										b.hospital_no, 
										CONCAT(b.first_name, ' ',b.middle_name, ' ',b.last_name) AS name, 
										age,
										count(*) as printed
								FROM cashidsale a
                                LEFT JOIN patients b ON a.patients_id = b.id
								WHERE MONTH(b.created_at) = ?
								AND YEAR(b.created_at) = ? 
								GROUP BY a.patients_id
								ORDER BY a.id DESC", [$date[1], $date[0]]);
		echo json_encode($patients);
		return;
	}
	public function getpatientbyid(Request $request)
	{
		$patient = Patient::find($request->id);
		$reciept = Cashrecieptno::where('user_id', '=', Auth::user()->id)
				->where('requistion_type', '=', 'INCOME')
				->first();
		echo json_encode(['patient' => $patient, 'reciept' => $reciept]);
		return;
	}
	public function setrecieptnumber(Request $request)
	{
		$user  = Cashrecieptno::where('user_id', '=', Auth::user()->id)
				->where('requistion_type', '=', $request->type)
				->first();

				if ($user) {
					$user->reciept_no = $request->reciept;
					$user->save();
				}
				else{
					$reciept = new Cashrecieptno();
					$reciept->user_id = Auth::user()->id;
					$reciept->requistion_type =  $request->type;
					$reciept->reciept_no = $request->reciept;
					$reciept->save();
				}
		echo json_encode($user);
		return;
	}
	public function submittransaction(Request $request)
		{


			if ($request->category_id == '1') {
				$sale = new Cashidsale();
					$user  =  Cashrecieptno::where('user_id', '=', Auth::user()->id)
							->where('requistion_type', '=', 'INCOME')
							->first();
					$sale->or_no = $user->reciept_no;
					$sale->users_id = Auth::user()->id;
					$sale->patients_id = $request->patient_id;
					$sale->price = $request->price;
					$sale->cash = $request->cash;
					$sale->save();
					
			}
			// elseif ($request->category_id == '2') {
			// 	foreach ($request->manage_id as $key => $u) {
			// 		$sale = new Sales();
			// 		$user  =  Cashrecieptno::where('user_id', '=', Auth::user()->id)
			// 				->where('requistion_type', '=', 'MEDICINE')
			// 				->first();
			// 		$sale->pharmanagerequest_id = $request->manage_id[$key];
			// 		$sale->users_id = Auth::user()->id;
			// 		$sale->mss_id = $request->mss_id;
			// 		$sale->price = $request->price[$key];
			// 		$sale->or_no = $user->reciept_no;
			// 		$sale->cash = $request->cash;
			// 		$sale->save();
			// 	}
			// }
			// elseif ($request->category_id == '3') {
			// 	foreach ($request->item_name as $key => $u) {
			// 		$manual = new Cashmanualsale();
			// 		$user  =  Cashrecieptno::where('user_id', '=', Auth::user()->id)
			// 				->where('requistion_type', '=', 'INCOME')
			// 				->first();
			// 		$manual->users_id = Auth::user()->id;
			// 		$manual->patients_id = $request->patient_id;
			// 		$manual->mss_id = $request->mss_id;
			// 		$manual->item = $request->item_name[$key];
			// 		$manual->qty = $request->item_qty[$key];
			// 		$manual->price = $request->item_price[$key];
			// 		$manual->or_no = $user->reciept_no;
			// 		$manual->cash = $request->cash;
			// 		$manual->save();
			// 	}
			// }
			elseif ($request->category_id == '4') {
				$labloop = 1;
				$modifier = Str::random(20);
				$group_id = null;
				foreach ($request->sub_category as $key => $u) {
					$user  =  Cashrecieptno::where('user_id', '=', Auth::user()->id)
							->where('requistion_type', '=', 'INCOME')
							->first();
					$income = null;
					if ($request->category[$key] == "10") {
						if ($request->request_id[$key] != '0') {
							$income = LaboratoryPayment::where('laboratory_request_id', '=', $request->request_id[$key])
														->where('void', '=', 0)->first();
							$LaboratoryPayment_status = true;
						}
						if (!$income) {
							$LaboratoryPayment_status = false;
							$income = new LaboratoryPayment();
						}
						if ($request->request_id[$key] == "0") {
							if ($labloop <= 1) {
								$labloop+=1;
								$LaboratoryRequestGroup = new LaboratoryRequestGroup();
							    $LaboratoryRequestGroup->user_id = Auth::user()->id;
							    $LaboratoryRequestGroup->patient_id = $request->patient_id;
							    $LaboratoryRequestGroup->save();
							    $group_id = $LaboratoryRequestGroup->id;
							}
							$LaboratoryRequest = new LaboratoryRequest();
							$LaboratoryRequest->item_id = $request->sub_category[$key];
							$LaboratoryRequest->qty = $request->item_qty[$key];
							$LaboratoryRequest->laboratory_request_group_id = $group_id;
							$LaboratoryRequest->save();
							$income->laboratory_request_id = $LaboratoryRequest->id;
						}else{

							$check = LaboratoryRequest::find($request->request_id[$key]);
							if (!$check) {
								if ($labloop <= 1) {
									$labloop+=1;
									$LaboratoryRequestGroup = new LaboratoryRequestGroup();
								    $LaboratoryRequestGroup->user_id = Auth::user()->id;
								    $LaboratoryRequestGroup->patient_id = $request->patient_id;
								    $LaboratoryRequestGroup->save();
							    	$group_id = $LaboratoryRequestGroup->id;
								}
								$LaboratoryRequest = new LaboratoryRequest();
								$LaboratoryRequest->item_id = $request->sub_category[$key];
								$LaboratoryRequest->qty = $request->item_qty[$key];
								$LaboratoryRequest->laboratory_request_group_id = $group_id;
								$LaboratoryRequest->save();
								$income->laboratory_request_id = $LaboratoryRequest->id;
							}else{
								if ($check->item_id != $request->sub_category[$key]) {
									if ($labloop <= 1) {
										$labloop+=1;
										$LaboratoryRequestGroup = new LaboratoryRequestGroup();
									    $LaboratoryRequestGroup->user_id = Auth::user()->id;
									    $LaboratoryRequestGroup->patient_id = $request->patient_id;
									    $LaboratoryRequestGroup->save();
							    		$group_id = $LaboratoryRequestGroup->id;
									}
									$LaboratoryRequest = new LaboratoryRequest();
									$LaboratoryRequest->item_id = $request->sub_category[$key];
									$LaboratoryRequest->qty = $request->item_qty[$key];
									$LaboratoryRequest->laboratory_request_group_id = $group_id;
									$LaboratoryRequest->save();
									$income->laboratory_request_id = $LaboratoryRequest->id;
								}else{
									$income->laboratory_request_id = $request->request_id[$key];
								}
							}
						}
						$income->user_id = Auth::user()->id;
						if (!$LaboratoryPayment_status) {
							$income->mss_id = $request->mss_id;
						}
						$income->price = $request->item_price[$key];
						if (!$LaboratoryPayment_status) {
							$income->discount = $request->item_discount[$key];
						}
						$income->cash = $request->cash;
						$income->or_no = $user->reciept_no;
						if ($income->dbnp == 1) {
							$income->dbnp = 2;
						}
						if ($income->mss_charge == 1) {
							$income->mss_charge = 2;
						}
						$income->created_at = Carbon::now()->format('Y-m-d H:i:s');
						$income->save();
					}else{
						if ($request->request_id[$key] != '0' || $request->request_id[$key]) {
							$income = Cashincome::where('ancillaryrequist_id', '=', $request->request_id[$key])
											->where('void', '=', '0')->first();
						}
						
						$Cashincome_status = true;
						if (!$income) {
							$income = new Cashincome();
							$Cashincome_status = false;
						}
						if ($request->request_id[$key] == "0") {
							$ancillaryrequist = new Ancillaryrequist();
							$ancillaryrequist->users_id = Auth::user()->id;
							$ancillaryrequist->patients_id = $request->patient_id;
							$ancillaryrequist->cashincomesubcategory_id = $request->sub_category[$key];
							$ancillaryrequist->qty = $request->item_qty[$key];
							$ancillaryrequist->modifier = $modifier;
							$ancillaryrequist->save();
							$income->ancillaryrequist_id = $ancillaryrequist->id;
						}else{
							$income->ancillaryrequist_id = $request->request_id[$key];
						}
						$income->users_id = Auth::user()->id;
						$income->patients_id = $request->patient_id;
						if (!$Cashincome_status) {
							$income->mss_id = $request->mss_id;
						}
						$income->category_id = $request->sub_category[$key];
						$income->qty = $request->item_qty[$key];
						$income->price = $request->item_price[$key];
						$income->or_no = $user->reciept_no;
						$income->cash = $request->cash;
						if (!$Cashincome_status) {
							$income->discount = $request->item_discount[$key];
						}
						if ($income->mss_charge == 1) {
							$income->mss_charge = 2;
						}
						$income->created_at = Carbon::now()->format('Y-m-d H:i:s');
						$income->save();

						if ($request->category[$key] == '12' || $request->category[$key] == '6' || $request->category[$key] == '10')
					  	{
					  		$triage = Triage::where('patients_id', '=', $request->patient_id)
					  							->whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))->first();
					  		if (!$triage) {
					  			$triage = new Triage();
					  			$triage->patients_id = $request->patient_id;
					  			$triage->users_id = Auth::user()->id;
					  			if ($request->category[$key] == '10') {
					  				$clinic_code = 1042;
					  			}elseif ($request->category[$key] == '6') {
					  				$clinic_code = 1033;
					  			}elseif ($request->category[$key] == '6') {
					  				$clinic_code = 2022;
					  			}
					  			$triage->clinic_code = 2022;
					  			$triage->save();
					  		}
					  	}
					}
				}
				
			  	
			}
			else{
			return redirect()->back()->with('toaster', array('error', 'Oops! somethings went wrong.'));	
			}
			$user->reciept_no = $user->reciept_no + 1;
			$user->save();
			
			// return redirect()->back()->with('toaster', array('success', 'transaction saved.'));

			/*=============================print reciept=================================*/
			$patient = Patient::find($request->patient_id);
			PDF::SetTitle('TRANSACTION RECIEPT');
			PDF::SetAutoPageBreak(TRUE, 0);
			PDF::AddPage('P',array(115,203));
			PDF::SetFont('helvetica','',10);
			PDF::SetMargins(0,0,0);
			PDF::SetXY(60,35);
			$reciept_no = $user->reciept_no - 1;
			PDF::Cell(30,5,''.$reciept_no.'',0,0,'R');
			PDF::SetXY(60,50);
			PDF::Cell(30,5,''.Carbon::now()->setTime(0,0)->format('m/d/Y').'',0,0,'C');
			
			PDF::SetXY(43,175);
			PDF::Cell(50,5,''.strtoupper(Auth::user()->first_name.' '.substr(Auth::user()->middle_name,0,1).'. '.Auth::user()->last_name).'',0,0,'C');
			PDF::SetXY(25,60);
			PDF::Cell(70,5,''.($patient->hospital_no)?$patient->hospital_no:'WALK-IN-'.$patient->walkin,0,0);
			PDF::SetXY(25,65);
			PDF::Cell(70,5,''.strtoupper($patient->last_name.', '.$patient->first_name.' '.substr($patient->middle_name,0,1)).'',0,0);
			
			
			PDF::SetXY(17,77);
			if ($request->category_id == '1') {
				$y = PDF::GetY()+6;
				PDF::SetXY(15,$y);
				//PDF::Cell(40,5,'HOSPITAL ID',0,0);
				PDF::Cell(40,5, ($request->price == 75)?'HOSPITAL ID':'REPRINT HOSPITAL ID',0,0);
				PDF::SetXY(75,$y);
				PDF::Cell(25,5,''.$request->price.'',0,0,'R');
				PDF::SetXY(75,135);
				PDF::SetFont('helvetica','B',13);
				PDF::Cell(25,5,''.$request->price.'',0,0,'R');
				PDF::SetXY(20,140);
				$number= '';
				$cent = "";
				$total_payment = '0.0';
				$pos = strpos($total_payment, ".");
				if($pos!==false){
				    $number = explode(".", $total_payment);
				    $words = strtoupper(ConvertNumberToWord::converter($number[0]));
				    $cent = $number[1];
				}
				else{
				    $cent = 0;
				    $words = strtoupper(ConvertNumberToWord::converter($number[0]));
				}
				PDF::SetFont('helvetica','B',12);
				PDF::Cell(70,5,"".strtoupper(ConvertNumberToWord::converter($request->price))." AND  ".$cent."/100 PESOS ONLY",0,0,'C');
			}
			elseif ($request->category_id == '2') {
				$total = 0;
				foreach ($request->manage_id as $key => $u) {
					$y = PDF::GetY()+6;
					PDF::SetXY(15,$y);
					PDF::Cell(40,5,''.substr($request->medicine_name[$key],0,32).'',0,0);
					PDF::SetXY(75,$y);
					PDF::Cell(25,5,''.number_format($request->item_netamount[$key], 2, '.', ',').'',0,0,'R');
					$total += $request->item_netamount[$key];
				}
				PDF::SetXY(75,135);
				PDF::SetFont('helvetica','B',13);
				PDF::Cell(25,5,''.number_format($total, 2, '.', ',').'',0,0,'R');
				PDF::SetXY(20,140);
				$number= '';
				$cent = "";
				$pos = strpos(number_format($total, 2), ".");
				if($pos!==false){
				    $number = explode(".", number_format($total, 2));
				    $words = strtoupper(ConvertNumberToWord::converter($number[0]));
				    $cent = $number[1];
				}
				else{
				    $cent = 0;
				    $words = strtoupper(ConvertNumberToWord::converter($number[0]));
				}
				PDF::SetFont('helvetica','B',12);
				PDF::MultiCell(70,10,"".strtoupper(ConvertNumberToWord::converter($total))." AND ".$cent."/100 PESOS ONLY",0,'T',false);
				
			}
			
			elseif ($request->category_id == '3') {
				$total = 0;
				foreach ($request->item_name as $key => $u) {
					$y = PDF::GetY()+6;
					PDF::SetXY(15,$y);
					PDF::Cell(40,5,''.substr($request->item_name[$key],0,32).'',0,0);
					PDF::SetXY(75,$y);
					PDF::Cell(25,5,''.number_format($request->item_netamount[$key], 2, '.', ',').'',0,0,'R');
					$total += $request->item_netamount[$key];
				}
				PDF::SetXY(75,135);
				PDF::SetFont('helvetica','B',13);
				PDF::Cell(25,5,''.number_format($total, 2, '.', ',').'',0,0,'R');
				PDF::SetXY(20,140);
				$pos = strpos(number_format($total, 2), ".");
				if($pos!==false){
				    $number = explode(".", number_format($total, 2));
				    $words = strtoupper(ConvertNumberToWord::converter($number[0]));
				    $cent = $number[1];
				}
				else{
				    $cent = 0;
				    $words = strtoupper(ConvertNumberToWord::converter($number[0]));
				}
				PDF::SetFont('helvetica','B',12);
				PDF::MultiCell(70,10,"".strtoupper(ConvertNumberToWord::converter($total))." AND ".$cent."/100 PESOS ONLY",0,'T',false);
				# code...
			}
			elseif ($request->category_id == '4') {
				$total = 0;
				foreach ($request->sub_description as $key => $u) {
					$y = PDF::GetY()+4;
					PDF::SetXY(15,$y);
					PDF::Cell(40,5,''.substr($request->sub_description[$key],0,32).'',0,0);
					PDF::SetXY(70,$y);
					PDF::Cell(25,5,''.number_format($request->item_netamount[$key], 2, '.', ',').'',0,0,'R');
					$total += $request->item_netamount[$key];
				}
				PDF::SetXY(70,140);
				PDF::SetFont('helvetica','B',13);
				PDF::Cell(25,5,''.number_format($total, 2, '.', ',').'',0,0,'R');
				PDF::SetXY(20,145);
				PDF::SetFont('helvetica','',10);
				$pos = strpos(number_format($total, 2), ".");
				if($pos!==false){
				    $number = explode(".", number_format($total, 2));
				    $words = strtoupper(ConvertNumberToWord::converter($number[0]));
				    $cent = $number[1];
				}
				else{
				    $cent = 0;
				    $words = strtoupper(ConvertNumberToWord::converter($number[0]));
				}
				PDF::SetFont('helvetica','B',12);
				PDF::MultiCell(70,10,"".strtoupper(ConvertNumberToWord::converter($total))." AND  ".$cent."/100 PESOS ONLY",0,'T',false);
				# code...
			}

			// for ($i=1; $i <= 10  ; $i++) { 
				// $y = PDF::GetY()+6;
				// PDF::SetXY(15,$y);
				// PDF::Cell(40,5,''.substr($string,0,19).'...',0,0);
				// PDF::SetXY(75,$y);
				// PDF::Cell(25,5,'100.0'.$i.'',0,0,'R');

			// }

			
			
			
			PDF::IncludeJS("print();");
			PDF::Output();
			return;
			/*=============================end od print reciept=================================*/

		}
	public function scanbarcode(Request $request)
	{

		$patient = DB::table('mss')
						->rightJoin('mssclassification', 'mss.id', '=', 'mssclassification.mss_id')
						->rightJoin('patients', 'mssclassification.patients_id', '=', 'patients.id')
						->where('patients.barcode', '=', $request->barcode)
						->orWhere('patients.hospital_no', '=', $request->barcode)
						->get()
						->first();
		$reciept = Cashrecieptno::where('user_id', '=', Auth::user()->id)
				->where('requistion_type', '=', 'MEDICINE')
				->first();
		if ($patient) {
		$manage = DB::select("SELECT a.id, CONCAT(c.brand, ' ',c.item_description) as medicine, 
									c.price, 
							        a.qty, 
							        (c.price * a.qty) as amount,
                                    (CASE 
                                     	WHEN e.discount 
                                     	THEN ((c.price * a.qty) * e.discount)
                                     	ELSE 0
                                     END)as discount,
                                     (CASE 
                                      	WHEN e.discount 
                                      	THEN ((c.price * a.qty) - ((c.price * a.qty) * e.discount)) 
                                      	ELSE (c.price * a.qty)
                                      END) as netamount
								FROM pharmanagerequest a 
								LEFT JOIN requisition b ON a.requisition_id = b.id
                                LEFT JOIN ancillary_items c ON b.item_id = c.id
                                LEFT JOIN mssclassification d ON b.patients_id = d.patients_id AND d.validity >= CURRENT_DATE()
                                LEFT JOIN mss e ON d.mss_id = e.id
                                WHERE b.patients_id = ?
                                AND a.id NOT IN(SELECT pharmanagerequest_id FROM sales WHERE void = 0) 
                                AND c.price > 0
                                ORDER BY a.id ASC
							", [$patient->id]);
				echo json_encode(['patient' => $patient, 'manage' => $manage, 'reciept' => $reciept]);
		}
		else{
			echo json_encode(['patient' => $patient, 'reciept' => $reciept]);
		}	
		return;

	}
	public function getpatientbybarcode(Request $request)
	{
		
		$data = DB::select("SELECT CONCAT(a.last_name, ' ',a.first_name, ' ',a.middle_name) as patient_name,
									c.label, 
							        c.description,
							        -- b.mss_id,
							        (null) as mss_id,
							        a.sex,
							        a.contact_no,
							        a.id,
							        (0) as discount,
							        -- c.discount,
							        a.hospital_no,
							        a.walkin
							FROM patients a 
							LEFT JOIN mssclassification b ON a.id = b.patients_id AND b.validity >= CURRENT_DATE()
							LEFT JOIN mss c ON b.mss_id = c.id
							WHERE a.barcode = ?
							OR a.hospital_no = ?
							", [$request->barcode, $request->barcode]);
		$reciept = Cashrecieptno::where('user_id', '=', Auth::user()->id)
				->where('requistion_type', '=', 'INCOME')
				->first();
		$charge = DB::select("SELECT a.id as id, 
								g.id as cat_id, 
								f.id as sub_id, 
								f.sub_category, 
								(CASE WHEN h.price THEN h.price ELSE f.price END) as price, 
								(CASE WHEN h.qty THEN h.qty ELSE a.qty END) as qty, 
								(0) as discount,
                              	a.created_at as created_at,
                              	CONCAT(e.last_name,', ',e.first_name) as charged_by,
                              	h.void,
                              	(null) as dbnp,
                              	h.mss_charge,
							    h.discount as payment_discount,
							    SUM(i.granted_amount) as granted_amount
							FROM ancillaryrequist a 
							LEFT JOIN mssclassification b ON a.patients_id = b.patients_id AND b.validity >= CURRENT_DATE() 
							LEFT JOIN mss c ON b.mss_id = c.id 
							LEFT JOIN patients d ON  a.patients_id = d.id 
							LEFT JOIN users e ON a.users_id = e.id
							LEFT JOIN cashincomesubcategory f ON a.cashincomesubcategory_id = f.id
							LEFT JOIN cashincomecategory g ON f.cashincomecategory_id = g.id 
							LEFT JOIN cashincome h ON a.id = h.ancillaryrequist_id AND h.void = '0'
							LEFT JOIN payment_guarantor i ON h.id = i.payment_id AND i.type = 0
							WHERE d.id = ? 
							AND g.id NOT IN(10)
							AND ((h.void IS NULL OR h.void = '1') OR (h.void = '0' AND h.mss_charge != 2)) 
							GROUP BY a.id
							UNION ALL
							SELECT a.id as id,
									(10) as cat_id,
							        a.item_id as sub_id,
							        b.name as sub_category,
							        (CASE WHEN f.price THEN f.price ELSE b.price END) as price,
							        a.qty,
									(0) as discount,
							        c.created_at as created_at,
                              		CONCAT(g.last_name,', ',g.first_name) as charged_by,
							        f.void,
							        f.dbnp,
							        f.mss_charge,
							        f.discount as payment_discount,
							        SUM(h.granted_amount) as granted_amount
							FROM laboratory_requests a
							LEFT JOIN laboratory_sub_list b ON a.item_id = b.id
							LEFT JOIN laboratory_request_groups c ON a.laboratory_request_group_id = c.id
							LEFT JOIN mssclassification d ON c.patient_id = d.patients_id
										AND d.validity >= CURRENT_DATE()
							LEFT JOIN mss e ON d.mss_id = e.id
							LEFT JOIN laboratory_payment f ON a.id = f.laboratory_request_id AND f.void = 0
							LEFT JOIN users g ON c.user_id = g.id
							LEFT JOIN payment_guarantor h ON f.id = h.payment_id AND h.type = 1
							WHERE c.patient_id = ?
							AND a.status != 'Removed'
							AND ((f.void IS NULL OR f.void = 1) OR (f.void = 0 AND f.mss_charge != 2) OR (f.void = 0 AND f.dbnp != 2)) 
							-- AND (f.dbnp IS NULL OR f.dbnp = 1) 
							-- AND (f.mss_charge IS NULL OR f.mss_charge = 1) 
							GROUP BY a.id
							ORDER BY created_at ASC, id ASC
							", [
								$data[0]->id,
								$data[0]->id
							]);
		echo json_encode(['data' =>  $data, 'reciept' => $reciept, 'charge' => $charge]);
		return;
	}
	public function transaction()
	{
		$data = [];
		return view('cashier.transaction', compact('data'));
	}

	public function getallTransactionsbyday(Request $request)
	{
		$cshier_id = Auth::user()->id;
		if ($cshier_id == 150 || $cshier_id == 325) {
		  $cshier_id = '150,325';
		}
		elseif ($cshier_id == 269 || $cshier_id == 259 || $cshier_id == 145) {
          $cshier_id = '269,259,145';
        }
        elseif ($cshier_id == 366 || $cshier_id == 320) {
          $cshier_id = '366,320';
        }
		$data =  DB::select("SELECT a.void,
									DATE(a.created_at) as dates,
									a.or_no as numbers, 
							        CONCAT(e.last_name, ', ',e.first_name,' ',e.middle_name) as payor,
							        ('DRUGS AND MEDICINES') as particulars,
                                     (CASE 
                                      	WHEN f.discount 
                                      	THEN SUM((b.qty * a.price) - ((b.qty * a.price) * f.discount)) 
                                      	ELSE SUM(b.qty * a.price)  
                                      END) as total,
							       (' ') as other,
                                   (CASE 
                                      	WHEN f.discount 
                                      	THEN SUM((b.qty * a.price) - ((b.qty * a.price) * f.discount)) 
                                      	ELSE SUM(b.qty * a.price)  
                                    END) as medicines,
                                   (' ') as medical,
                                   (' ') as laboratory,
                                   (' ') as radiology,
                                   (' ') as cardiology,
                                   (' ') as supply,
                                   ('pharmacy') as type
							FROM sales a
							LEFT JOIN pharmanagerequest b ON a.pharmanagerequest_id = b.id 
							LEFT JOIN requisition c ON b.requisition_id = c.id
							LEFT JOIN ancillary_items d ON c.item_id = d.id
							LEFT JOIN patients e ON c.patients_id = e.id
							LEFT JOIN mss f ON a.mss_id = f.id
							LEFT JOIN users g ON a.users_id = g.id
							WHERE date(a.created_at) IN($cshier_id)
							-- AND a.mss_id NOT IN(9,10,11,12,13)
							-- AND a.price > 0
							AND a.users_id = ?
                            GROUP BY a.or_no
                            UNION
							SELECT h.void,
									DATE(h.created_at) as dates, 
                                    h.or_no as numbers,
									CONCAT(i.last_name, ', ',i.first_name,' ',i.middle_name) as payor,
									('HOSPITAL ID') as particulars,
							        h.price as total,
                                    h.price as other,
                                    (' ') as medicines,
                                    (' ') as medical,
                                    (' ') as laboratory,
                                    (' ') as radiology,
                                    (' ') as cardiology,
                                    (' ') as supply,
                                    ('hospital id') as type
							FROM cashidsale h
							LEFT JOIN patients i ON h.patients_id = i.id
							LEFT JOIN users j ON h.users_id = j.id
							WHERE date(h.created_at) = ?
							AND h.users_id IN($cshier_id)
							GROUP BY h.or_no
							UNION 
							SELECT o.void,
								DATE(o.created_at) as dates,
                                o.or_no as numbers,
							    CONCAT(p.last_name, ', ',p.first_name,' ',p.middle_name) as payor,
                                (CASE 
                                 	WHEN t.id IN(6,11,13)
                                 	THEN s.sub_category
                                 	WHEN s.type
                                 	THEN s.sub_category
                                 	ELSE t.category
                                 END) as particulars,
						        (CASE 
                                 	WHEN o.discount 
                                 	THEN SUM(((o.qty * o.price) - o.discount) - COALESCE(pg.granted_amount, 0 ))
                                 	ELSE SUM(((o.qty * o.price) - 0) - COALESCE(pg.granted_amount, 0 ))
                                 END) as total,
                                (CASE 
                                	WHEN t.id IN(1, 2, 3, 4, 5, 7, 8, 13, 14, 15, 17, 18, 19)
                                 	AND s.type = 0
                                	THEN (CASE 
	                                     	WHEN o.discount 
	                                     	THEN SUM(((o.qty * o.price) - o.discount) - COALESCE(pg.granted_amount, 0 ))
	                                     	ELSE SUM(((o.qty * o.price) - 0) - COALESCE(pg.granted_amount, 0 ))
	                                     END) 
                                	ELSE  ' '
                                END) as other,
                                (' ') as medicines,
                                (CASE 
                                	WHEN t.id IN(9) 
                                 	AND s.type = 0
                                	THEN SUM(((o.qty * o.price) - o.discount) - COALESCE(pg.granted_amount, 0 ))
                                	ELSE ' '
                                END) as medical,
                                (CASE 
                                 	WHEN t.id = 10 
                                 	AND s.type = 0
                                 	THEN SUM(((o.qty * o.price) - o.discount) - COALESCE(pg.granted_amount, 0 ))
                                 	ELSE ' '
                                 END) as laboratory,
                                (CASE 
                                 	WHEN t.id IN(6,11)
                                 	AND s.type = 0
                                 	THEN SUM(((o.qty * o.price) - o.discount) - COALESCE(pg.granted_amount, 0 ))
                                 	ELSE ' '
                                 END) as radiology,
                                (CASE 
                                 	WHEN t.id IN(12) 
                                 	AND s.type = 0
                                 	THEN SUM(((o.qty * o.price) - o.discount) - COALESCE(pg.granted_amount, 0 ))
                                 	ELSE ' '
                                 END) as cardiology,
                                 (CASE 
                                 	WHEN s.type = 1 
                                 	THEN SUM(((o.qty * o.price) - o.discount) - COALESCE(pg.granted_amount, 0 ))
                                 	ELSE ' '
                                 END) as supply,
                                 ('income') as type 
							FROM cashincome o
							LEFT JOIN patients p ON o.patients_id = p.id
							LEFT JOIN mss q ON o.mss_id = q.id
							LEFT JOIN users r ON o.users_id = r.id
                            LEFT JOIN cashincomesubcategory s ON o.category_id = s.id
                            LEFT JOIN cashincomecategory t ON s.cashincomecategory_id = t.id
                            -- LEFT JOIN payment_guarantor pg ON o.id = pg.payment_id AND pg.type = 0
                            LEFT JOIN 
                            	(SELECT payment_id, SUM(granted_amount) as granted_amount FROM payment_guarantor WHERE type = 0 GROUP BY payment_id) pg 
                            ON o.id = pg.payment_id

                            WHERE date(o.created_at) = ?
							AND o.users_id IN($cshier_id)
							GROUP BY o.or_no, t.id
							UNION
							SELECT 
								u.void,
							    DATE(u.created_at) as dates,
							    u.or_no as numbers,
							    CONCAT(x.last_name, ', ',x.first_name,' ',x.middle_name) as payor,
							    ('LABORATORY') as particulars,
							    SUM(((v.qty * u.price) - u.discount) - (COALESCE(pgu.granted_amount, 0 ))) as total,
							    ('') as other,
							    ('') as medicines,
							    ('') as medical,     
							    SUM(((v.qty * u.price) - u.discount) - (COALESCE(pgu.granted_amount, 0 ))) as laboratory,
							    ('') as radiology,
							    ('') as cardiology,
							    ('') as supply,
							    ('income') as type
							FROM laboratory_payment u
							LEFT JOIN laboratory_requests v ON u.laboratory_request_id = v.id
							LEFT JOIN laboratory_request_groups w ON v.laboratory_request_group_id = w.id
							LEFT JOIN patients x ON w.patient_id = x.id
							LEFT JOIN laboratory_sub_list y ON v.item_id = y.id
							LEFT JOIN 
								(SELECT payment_id, SUM(granted_amount) as granted_amount FROM payment_guarantor WHERE type = 1 GROUP BY payment_id) pgu 
							ON u.id = pgu.payment_id
							WHERE DATE(u.created_at) = ?
							AND u.user_id IN($cshier_id)
							GROUP BY u.or_no
                            ORDER BY numbers ASC
							", [
									$request->day, 
									$request->day, 
									$request->day,
									$request->day
								]);
		echo json_encode($data);
		return;
	}
	public function gettransactionbymonth(Request $request)
	{
		$date = explode('-', $request->month);
		$data =  DB::select("SELECT a.void,
									DATE(a.created_at) as dates,
									a.or_no as numbers, 
							        CONCAT(e.last_name, ', ',e.first_name,' ',e.middle_name) as payor,
							        ('DRUGS AND MEDICINES') as particulars,
                                     (CASE 
                                      	WHEN f.discount 
                                      	THEN SUM((b.qty * a.price) - ((b.qty * a.price) * f.discount)) 
                                      	ELSE SUM(b.qty * a.price)  
                                      END) as total,
							       (' ') as other,
                                   (CASE 
                                      	WHEN f.discount 
                                      	THEN SUM((b.qty * a.price) - ((b.qty * a.price) * f.discount)) 
                                      	ELSE SUM(b.qty * a.price)  
                                    END) as medicines,
                                   (' ') as medical,
                                   (' ') as laboratory,
                                   (' ') as radiology,
                                   (' ') as cardiology,
                                   ('pharmacy') as type
							FROM sales a
							LEFT JOIN pharmanagerequest b ON a.pharmanagerequest_id = b.id 
							LEFT JOIN requisition c ON b.requisition_id = c.id
							LEFT JOIN ancillary_items d ON c.item_id = d.id
							LEFT JOIN patients e ON c.patients_id = e.id
							LEFT JOIN mss f ON a.mss_id = f.id
							LEFT JOIN users g ON a.users_id = g.id
							WHERE YEAR(a.created_at) = ?
							AND MONTH(a.created_at) = ?
							-- AND a.mss_id NOT IN(9,10,11,12,13)
							-- AND a.price > 0
							AND a.users_id = ?
							GROUP BY a.or_no
							UNION 
							SELECT h.void,
									DATE(h.created_at) as dates, 
                                    h.or_no as numbers,
									CONCAT(i.last_name, ', ',i.first_name,' ',i.middle_name) as payor,
									('HOSPITAL ID') as particulars,
							        h.price as total,
                                    h.price as other,
                                    (' ') as medicines,
                                    (' ') as medical,
                                    (' ') as laboratory,
                                    (' ') as radiology,
                                    (' ') as cardiology,
                                    ('hospital id') as type
							FROM cashidsale h
							LEFT JOIN patients i ON h.patients_id = i.id
							LEFT JOIN users j ON h.users_id = j.id
							WHERE YEAR(h.created_at) = ?
							AND MONTH(h.created_at) = ?
							AND h.users_id = ?
							GROUP BY h.or_no
							UNION
							SELECT o.void,
									DATE(o.created_at) as dates,
                                    o.or_no as numbers,
								    CONCAT(p.last_name, ', ',p.first_name,' ',p.middle_name) as payor,
                                    (CASE 
                                     	WHEN t.id IN(6,11,13)
                                     	THEN s.sub_category
                                     	ELSE t.category
                                     END) as particulars,
                                     (CASE 
                                     	WHEN o.discount 
                                     	THEN SUM((o.qty * o.price) - o.discount)
                                     	ELSE SUM((o.qty * o.price) - 0)
                                     END) as total,
                                    (CASE 
                                    	WHEN t.id IN(1, 2, 3, 4, 5, 7, 8, 13, 14, 15, 17, 18, 19)
                                    	THEN (CASE 
		                                     	WHEN o.discount 
		                                     	THEN SUM((o.qty * o.price) - o.discount)
		                                     	ELSE SUM((o.qty * o.price) - 0)
		                                     END) 
                                    	ELSE  ' '
                                    END) as other,
                                    (' ') as medicines,
                                    (CASE 
                                    	WHEN t.id IN(9) 
                                    	THEN SUM((o.qty * o.price) - o.discount)
                                    	ELSE ' '
                                    END) as medical,
                                    (CASE 
                                     	WHEN t.id = 10 
                                     	THEN SUM((o.qty * o.price) - o.discount)
                                     	ELSE ' '
                                     END) as laboratory,
                                    (CASE 
                                     	WHEN t.id IN(6,11) 
                                     	THEN SUM((o.qty * o.price) - o.discount)
                                     	ELSE ' '
                                     END) as radiology,
                                    (CASE 
                                     	WHEN t.id IN(12) 
                                     	THEN SUM((o.qty * o.price) - o.discount)
                                     	ELSE ' '
                                     END) as cardiology,
                                     ('income') as type 
							FROM cashincome o
							LEFT JOIN patients p ON o.patients_id = p.id
							LEFT JOIN mss q ON o.mss_id = q.id
							LEFT JOIN users r ON o.users_id = r.id
                            LEFT JOIN cashincomesubcategory s ON o.category_id = s.id
                            LEFT JOIN cashincomecategory t ON s.cashincomecategory_id = t.id
                            WHERE YEAR(o.created_at) = ?
							AND MONTH(o.created_at) = ?
							AND o.users_id = ?
							GROUP BY o.or_no, t.id
							ORDER BY numbers ASC
							", [$date[0],$date[1], Auth::user()->id, 
								$date[0],$date[1], Auth::user()->id,
								$date[0],$date[1], Auth::user()->id,
								$date[0],$date[1], Auth::user()->id]);
				echo json_encode($data);
		return;
	}
	public function monthlya()
	{
		$month = DB::select("SELECT x.dates 
							FROM(
							    SELECT DATE(created_at) as dates FROM sales GROUP BY MONTH(created_at)
							    UNION 
							    SELECT DATE(created_at) as dates FROM cashidsale GROUP BY MONTH(created_at)
							    UNION
							    SELECT DATE(created_at) as dates FROM cashmanualsale GROUP BY MONTH(created_at)
							)x
							GROUP BY MONTH(x.dates)
							");
		echo json_encode($month);
		return;
	}
	public function checkcredintials(request $request)
	{
		$check = Cashcredintials::where('credintials', '=', $request->cred)
				->where('users_id', '=', Auth::user()->id)
				->first();
		echo json_encode($check);
		return;
	}
	public function gettransactionbyorno(Request $request)
	{
		if ($request->tdtype == 'pharmacy') {
			$data = DB::select("SELECT a.id, 
										a.or_no, 
								        d.brand, 
								        d.item_description, 
								        a.price, 
								        b.qty,
								        e.discount,
								        (a.price * b.qty) as amount,
								        (CASE 
								         	WHEN e.discount 
								         	THEN ((a.price * b.qty) * e.discount) 
								         	ELSE 0 
								         END) as tot_discount,
								         (CASE 
								         	WHEN e.discount 
								         	THEN ((a.price * b.qty) - ((a.price * b.qty) * e.discount)) 
								         	ELSE (a.price * b.qty)
								         END) as tot_amount,
								         c.patients_id as ptid
								FROM sales a 
								LEFT JOIN pharmanagerequest b ON a.pharmanagerequest_id = b.id
								LEFT JOIN requisition c ON b.requisition_id = c.id
								LEFT JOIN ancillary_items d ON c.item_id = d.id
								LEFT JOIN mss e ON a.mss_id = e.id
								WHERE a.or_no = ?
								", [$request->tdor_no]);
		}elseif ($request->tdtype == 'manual') {
			$data = DB::select("SELECT a.id,
										a.or_no,
										(' ') as brand,
										a.item as item_description,
										a.price,
										a.qty,
										b.discount,
										(a.price * a.qty) as amount,
										(CASE 
										 	WHEN b.discount 
										 	THEN ((a.price * a.qty) * b.discount) 
										 	ELSE 0 
										 END) as tot_discount,
										 (CASE 
										 	WHEN b.discount 
										 	THEN ((a.price * a.qty) - ((a.price * a.qty) * b.discount)) 
										 	ELSE (a.price * a.qty)
										 END) as tot_amount,
										 a.patients_id as ptid
								FROM cashmanualsale a 
								LEFT JOIN mss b ON a.mss_id = b.id
								WHERE a.or_no = ?
								", [$request->tdor_no]);
		}
		elseif ($request->tdtype == 'hospital id') {
			$data = DB::select("SELECT id,
										or_no,
										(' ') as brand,
										('HOSPITAL ID') as item_description,
										price,
										('1') as qty,
										price as amount,
										0 as tot_discount,
										price as tot_amount,
										patients_id as ptid
								FROM cashidsale
								WHERE or_no = ?
								", [$request->tdor_no]);
		}
		elseif ($request->tdtype == 'income') {
			$data = DB::select("SELECT a.id, 
										a.or_no, 
								        c.category as brand, 
								        b.sub_category as item_description, 
								        a.price, 
								        a.qty,
								        d.discount,
								        (a.price * a.qty) as amount,
								        (CASE 
								        	WHEN a.discount 
								        	THEN a.discount 
								        	ELSE 0 
								        END) as tot_discount,
								        (ex.granted_amount) as granted_amount,
								         (CASE 
								         	WHEN a.id 
								         	THEN (((a.price * a.qty) - a.discount) - COALESCE(ex.granted_amount, 0 )) 
								         	ELSE (a.price * a.qty)
								         END) as tot_amount,
										 a.patients_id as ptid
								FROM cashincome a 
								LEFT JOIN cashincomesubcategory b ON a.category_id = b.id
                                LEFT JOIN cashincomecategory c ON b.cashincomecategory_id = c.id
								LEFT JOIN mss d ON a.mss_id = d.id
								LEFT JOIN 
								  (SELECT payment_id, SUM(granted_amount) as granted_amount FROM payment_guarantor WHERE type = 0 GROUP BY payment_id) ex 
								ON a.id = ex.payment_id
								-- LEFT JOIN payment_guarantor ex ON a.id = ex.payment_id AND ex.type = 0
								WHERE a.or_no = ?
								GROUP BY a.id
								UNION
								SELECT 
										e.id,
										e.or_no,
								        ('LABORATORY') as brand,
								        g.name as item_description,
								        e.price,
								        f.qty,
								        h.discount,
								        (f.qty * e.price) as amount,
								        e.discount as tot_discount,
								        SUM(j.granted_amount) as granted_amount,
								        ((f.qty * e.price) - e.discount) - COALESCE(SUM(j.granted_amount), 0 ) as tot_amount,
								        i.patient_id as ptid
								FROM laboratory_payment e 
								LEFT JOIN laboratory_requests f ON e.laboratory_request_id = f.id
								LEFT JOIN laboratory_sub_list g ON f.item_id = g.id
								LEFT JOIN mss h ON e.mss_id = h.id
								LEFT JOIN laboratory_request_groups i ON f.laboratory_request_group_id = i.id
								LEFT JOIN payment_guarantor j ON e.id = j.payment_id AND j.type = 1
								WHERE e.or_no = ?
								GROUP BY e.id
								", [
									$request->tdor_no,
									$request->tdor_no
									]);
		}
		echo json_encode($data);
		return;
	}
	public function voidtransaction(Request $request)
	{
		if ($request->type == 'pharmacy') {
			$transaction = DB::update("UPDATE sales SET void = '1' WHERE or_no = ?", [$request->or_no]);				
		}elseif ($request->type == 'manual') {
			$transaction = DB::update("UPDATE cashmanualsale SET void = '1' WHERE or_no = ?", [$request->or_no]);				
		}
		elseif ($request->type == 'hospital id') {
			$transaction = DB::update("UPDATE cashidsale SET void = '1' WHERE or_no = ?", [$request->or_no]);				
		}
		elseif ($request->type == 'income') {
			$transaction = DB::update("UPDATE cashincome SET void = '1' WHERE or_no = ?", [$request->or_no]);	
			$payment = LaboratoryPayment::where('or_no', '=', $request->or_no)->get();
			if (count($payment) > 0) {
				foreach ($payment as $list) {
					$list->void = 1;
					$list->save();
				}
			}				
		}
		echo json_encode($transaction);
		return;
	}
	public function unvoidtransaction(Request $request)
	{
		if ($request->type == 'pharmacy') {
			$transaction = DB::update("UPDATE sales SET void = '0' WHERE or_no = ?", [$request->or_no]);				
		}elseif ($request->type == 'manual') {
			$transaction = DB::update("UPDATE cashmanualsale SET void = '0' WHERE or_no = ?", [$request->or_no]);				
		}
		elseif ($request->type == 'hospital id') {
			$transaction = DB::update("UPDATE cashidsale SET void = '0' WHERE or_no = ?", [$request->or_no]);				
		}
		elseif ($request->type == 'income') {
			$transaction = DB::update("UPDATE cashincome SET void = '0' WHERE or_no = ?", [$request->or_no]);		
			$payment = LaboratoryPayment::where('or_no', '=', $request->or_no)->get();
			if (count($payment) > 0) {
				foreach ($payment as $list) {
					$list->void = 0;
					$list->save();
				}
			}			
		}
		echo json_encode($transaction);
		return;
	}
	public function getsubcaegorybycaetogoryid(Request $request)
	{
		if ($request->category_id == '10') {
			$sub = LaboratorySubList::where('status', '=', 'Active')
							->select(
									'name as sub_category',
									'price',
									'id'
									)
							->orderBy('name', 'ASC')->get();
		}else{
			$sub = Cashincomesubcategory::where('cashincomecategory_id', '=', $request->category_id)
					->where('trash', '=', 'N')->orderBy('sub_category')->get();
		}
		echo json_encode($sub);	
		return;
	}
	public function getortransaction(Request $request)
	{
		if ($request->type == 'pharmacy') {
			$transaction = DB::select("SELECT CONCAT(d.first_name, ' ',d.middle_name, ' ',d.last_name) as patient_name,
												'Medicine' as reciept_type,
										        'OR2' as series_type,
										        a.or_no,
										        a.created_at,
										        (CASE 
																		         	WHEN e.discount 
																		         	THEN SUM((a.price * b.qty) - ((a.price * b.qty) * e.discount)) 
																		         	ELSE SUM(a.price * b.qty)
																		         END) as tot_amount
										FROM sales a
										LEFT JOIN pharmanagerequest b ON a.pharmanagerequest_id = b.id
										LEFT JOIN requisition c ON b.requisition_id = c.id
										LEFT JOIN patients d ON c.patients_id = d.id
										LEFT JOIN mss e ON a.mss_id = e.id
										WHERE a.or_no = ?
										GROUP BY a.or_no", [$request->or_no]);				
		}
		elseif ($request->type == 'manual') {
			$transaction = DB::select("SELECT CONCAT(b.first_name, ' ',b.middle_name, ' ',b.last_name) as patient_name,
											'Income' as reciept_type,
											'OR1' as series_type,
											a.or_no,
											a.created_at,
											(CASE 
											 	WHEN c.discount 
											 	THEN SUM((a.price * a.qty) - ((a.price * a.qty) * c.discount)) 
											 	ELSE SUM(a.price * a.qty)
											 END) as tot_amount
										FROM cashmanualsale a 
										LEFT JOIN patients b ON a.patients_id = b.id
										LEFT JOIN mss c ON a.mss_id = c.id
										WHERE or_no = ?
										GROUP BY a.or_no", [$request->or_no]);				
		}
		elseif ($request->type == 'hospital id') {
			$transaction = DB::select("SELECT CONCAT(b.first_name, ' ',b.middle_name, ' ',b.last_name) as patient_name,
											'Income' as reciept_type,
											'OR1' as series_type,
											a.or_no,
											a.created_at,
											a.price as tot_amount
										FROM cashidsale a 
										LEFT JOIN patients b ON a.patients_id = b.id
										WHERE or_no = ?", [$request->or_no]);				
		}
		elseif ($request->type == 'income') {
			$transaction = DB::select("SELECT CONCAT(y.first_name, ' ',y.middle_name, ' ',y.last_name) as patient_name,
												('Income') as reciept_type,
										        ('OR1') as series_type,
										        x.or_no,
										        x.created_at,
										        SUM(x.tot_amount) as tot_amount
										FROM (
										    	SELECT a.patients_id, 
										    			a.or_no, 
										    			a.created_at,
										    			((a.qty * a.price) - a.discount) as tot_amount
										    	FROM cashincome a
										    	UNION 
										    	SELECT d.patient_id as patients_id,
										    			b.or_no, 
										    			b.created_at,
										    			((c.qty * b.price) - b.discount) as tot_amount
										    	FROM laboratory_payment b
										    	LEFT JOIN laboratory_requests c ON b.laboratory_request_id = c.id
										    	LEFT JOIN laboratory_request_groups d ON c.laboratory_request_group_id = d.id
												)x
										LEFT JOIN patients y ON x.patients_id = y.id
										WHERE x.or_no = ?
										GROUP BY x.or_no", [$request->or_no]);	
			if (count($transaction) < 1) {
				
			}			
		}
		echo json_encode($transaction);
		return;
	}
	public function updaterecieptnumber(Request $request)
	{
		if ($request->or_no == $request->recieptnoorig) {
			$check = 'The O.R number you want to entry successfully saved.';
		}else{
			$datas = DB::select("SELECT x.or_no , 
										x.type,
								        DATE(x.created_at) as date,
								        y.last_name, y.first_name, y.middle_name
								FROM(
								    SELECT a.or_no, 'pharmacy' as type, a.users_id, a.created_at FROM sales a
								    UNION 
								    SELECT b.or_no, 'id' as type, b.users_id, b.created_at FROM cashidsale b
								    UNION 
								    SELECT c.or_no, 'ancillary' as type, c.users_id, c.created_at FROM cashincome c
								    UNION 
								    SELECT d.or_no, 'laboratory' as type, d.user_id, d.created_at as users_id FROM laboratory_payment d
									)x
								LEFT JOIN users y ON x.users_id = y.id 
								WHERE x.or_no = ?
								GROUP BY x.or_no
								", [$request->or_no]);
			if (count($datas) >= 1) {
				$check = 'The O.R number you want to entry is already used by Cashier: '.$datas[0]->last_name.' '.$datas[0]->first_name.' in date: '.Carbon::parse($datas[0]->date)->format('M/d/Y').'.';
			}else{
				if ($request->type == 'pharmacy') {
					$transaction = DB::update("UPDATE sales SET or_no = ? WHERE or_no = ?", [$request->or_no, $request->recieptnoorig]);				
				}elseif ($request->type == 'manual') {
					$transaction = DB::update("UPDATE cashmanualsale SET or_no = ? WHERE or_no = ?", [$request->or_no, $request->recieptnoorig]);				
				}
				elseif ($request->type == 'hospital id') {
					$transaction = DB::update("UPDATE cashidsale SET or_no = ? WHERE or_no = ?", [$request->or_no, $request->recieptnoorig]);				
				}
				elseif ($request->type == 'income') {
					$transaction = DB::update("UPDATE cashincome SET or_no = ? WHERE or_no = ?", [$request->or_no, $request->recieptnoorig]);
					$payment = LaboratoryPayment::where('or_no', '=', $request->recieptnoorig)->get();
					if (count($payment) > 0) {
						foreach ($payment as $list) {
							$list->or_no = $request->or_no;
							$list->save();
						}
					}			
				}
				$check = 'The O.R number you want to entry successfully saved.';
			}
		}
		echo json_encode($check);
		return;
	}
	public function searchpatient(Request $request)
	{

		$patients = DB::select("SELECT id, 
										hospital_no, 
										CONCAT(first_name, ' ',middle_name, ' ',last_name) AS name, 
										age 
								FROM patients 
                                WHERE hospital_no LIKE '%".$request->hospital_no."%'
								ORDER BY id DESC");
		echo json_encode($patients);
		return;
	}
	public function searchreprintid(Request $request)
	{
		$patients = DB::select("SELECT id, 
										hospital_no, 
										CONCAT(first_name, ' ',middle_name, ' ',last_name) AS name, 
										age 
								FROM patients 
	                            WHERE hospital_no LIKE '%".$request->hospital_no."%'
								ORDER BY id DESC");
		echo json_encode($patients);
		return;
	}
	public function reprint($or, $type)
	{
		if ($type == 'pharmacy') {
			$data = DB::select("SELECT a.id, 
										a.or_no, 
								        d.brand, 
								        d.item_description, 
								        a.price, 
								        b.qty,
								        e.discount,
								        (a.price * b.qty) as amount,
								        (CASE 
								         	WHEN e.discount 
								         	THEN ((a.price * b.qty) * e.discount) 
								         	ELSE 0 
								         END) as tot_discount,
								         (CASE 
								         	WHEN e.discount 
								         	THEN ((a.price * b.qty) - ((a.price * b.qty) * e.discount)) 
								         	ELSE (a.price * b.qty)
								         END) as tot_amount,
								         c.patients_id,
								         a.created_at
								FROM sales a 
								LEFT JOIN pharmanagerequest b ON a.pharmanagerequest_id = b.id
								LEFT JOIN requisition c ON b.requisition_id = c.id
								LEFT JOIN ancillary_items d ON c.item_id = d.id
								LEFT JOIN mss e ON a.mss_id = e.id
								WHERE a.or_no = ?
								", [$or]);
		}elseif ($type == 'manual') {
			$data = DB::select("SELECT a.id,
										a.or_no,
										(' ') as brand,
										a.item as item_description,
										a.price,
										a.qty,
										b.discount,
										(a.price * a.qty) as amount,
										(CASE 
										 	WHEN b.discount 
										 	THEN ((a.price * a.qty) * b.discount) 
										 	ELSE 0 
										 END) as tot_discount,
										 (CASE 
										 	WHEN b.discount 
										 	THEN ((a.price * a.qty) - ((a.price * a.qty) * b.discount)) 
										 	ELSE (a.price * a.qty)
										 END) as tot_amount,
										 a.patients_id,
										 a.created_at
								FROM cashmanualsale a 
								LEFT JOIN mss b ON a.mss_id = b.id
								WHERE a.or_no = ?
								", [$or]);
		}
		elseif ($type == 'hospital id') {
			$data = DB::select("SELECT id,
										or_no,
										(' ') as brand,
										('HOSPITAL ID') as item_description,
										price,
										('1') as qty,
										price as amount,
										0 as tot_discount,
										price as tot_amount,
										patients_id,
										created_at
								FROM cashidsale
								WHERE or_no = ?
								", [$or]);
		}
		elseif ($type == 'income') {
			$data = DB::select("SELECT a.id, 
										a.or_no, 
								        c.category as brand, 
								        b.sub_category as item_description, 
								        a.price, 
								        a.qty,
								        d.discount,
								        (a.price * a.qty) as amount,
								        a.patients_id,
								        a.created_at,
								        (CASE 
								        	WHEN a.discount 
								        	THEN a.discount 
								        	ELSE 0 
								        END) as tot_discount,
								        (((a.price * a.qty) - a.discount) - COALESCE(SUM(ex.granted_amount), 0 )) as tot_amount
								FROM cashincome a 
								LEFT JOIN cashincomesubcategory b ON a.category_id = b.id
                                LEFT JOIN cashincomecategory c ON b.cashincomecategory_id = c.id
								LEFT JOIN mss d ON a.mss_id = d.id
								LEFT JOIN payment_guarantor ex ON a.id = ex.payment_id AND ex.type = 0
								WHERE a.or_no = ?
								GROUP BY a.id
								UNION
								SELECT 
										e.id,
										e.or_no,
								        ('LABORATORY') as brand,
								        g.name as item_description,
								        e.price,
								        f.qty,
								        h.discount,
								        (f.qty * e.price) as amount,
								        i.patient_id,
								        e.created_at,
								        e.discount as tot_discount,
								       	(((f.qty * e.price) - e.discount) - COALESCE(SUM(j.granted_amount), 0 )) as tot_amount
								FROM laboratory_payment e 
								LEFT JOIN laboratory_requests f ON e.laboratory_request_id = f.id
								LEFT JOIN laboratory_sub_list g ON f.item_id = g.id
								LEFT JOIN mss h ON e.mss_id = h.id
								LEFT JOIN laboratory_request_groups i ON f.laboratory_request_group_id = i.id
								LEFT JOIN payment_guarantor j ON e.id = j.payment_id AND j.type = 1
								WHERE e.or_no = ?
								GROUP BY e.id
								", [	
										$or,
										$or
									]);
		}
		if ($data) {
		// dd($data);
		
		$patient = Patient::find($data[0]->patients_id);
		PDF::SetTitle('TRANSACTION RECIEPT');
		PDF::SetAutoPageBreak(TRUE, 0);
		PDF::AddPage('P',array(115,203));
		PDF::SetFont('helvetica','',10);
		PDF::SetMargins(0,0,0);
		PDF::SetXY(60,35);
		PDF::Cell(30,5,''.$data[0]->or_no.'',0,0,'R');
		PDF::SetXY(60,50);
		PDF::Cell(30,5,''.Carbon::parse($data[0]->created_at)->format('m/d/Y').'',0,0,'C');
		
		PDF::SetXY(43,175);
		PDF::Cell(50,5,''.strtoupper(Auth::user()->first_name.' '.substr(Auth::user()->middle_name,0,1).'. '.Auth::user()->last_name).'',0,0,'C');
		PDF::SetXY(25,65);
		PDF::Cell(70,5,''.strtoupper($patient->last_name.', '.$patient->first_name.' '.substr($patient->middle_name,0,1)).'',0,0);
		
		PDF::SetXY(17,77);
			$total = 0;
			foreach ($data as $list) {
				$y = PDF::GetY()+6;
				PDF::SetXY(15,$y);
				PDF::Cell(40,5,''.substr(ucwords($list->item_description),0,32).'',0,0);
				PDF::SetXY(70,$y);
				PDF::Cell(25,5,''.number_format($list->tot_amount, 2, '.', ',').'',0,0,'R');
				$total += $list->tot_amount;
			}
			PDF::SetXY(70,135);
			PDF::SetFont('helvetica','B',13);
			PDF::Cell(25,5,''.number_format($total, 2, '.', ',').'',0,0,'R');
			PDF::SetXY(20,140);
			
			$pos = strpos(number_format($total, 2), ".");
			if($pos!==false){
			    $number = explode(".", number_format($total, 2));
			    $words = strtoupper(ConvertNumberToWord::converter($number[0]));
			    $cent = $number[1];
			}
			else{
			    $cent = 0;
			    $words = strtoupper(ConvertNumberToWord::converter($number[0]));
			}
			PDF::SetFont('helvetica','B',12);
			PDF::MultiCell(70,10,"".strtoupper(ConvertNumberToWord::converter($total))." AND  ".$cent."/100 PESOS ONLY",0,'T',false);
		PDF::IncludeJS("print();");
		PDF::Output();
		return;

		}else{
			dd('no data to print');
		}
	}
	public function getcategory()
	{
		$category = Cashincomecategory::all();
		echo json_encode($category);
		return;
	}
	public function getsubcategorybycatid(Request $request)
	{
		if ($request->cat_id == 10) {
			$subcategory = DB::select("SELECT id, 
												price, 
												name as sub_category
										FROM laboratory_sub_list
										");
		}else{
			$subcategory = Cashincomesubcategory::where('cashincomecategory_id', '=', $request->cat_id)->get();
		}
		echo json_encode($subcategory);
		return;
	}
	public function searchospitalno($no)
	{
		$data = Patient::where('hospital_no', '=', $no)->first();
		echo json_encode($data);
		return;
	}
	public function storeincomeor(Request $request)
	{
		$validator = Validator::make($request->all(), [
		        'date' => 'date|before_or_equal:'.Carbon::now()->format('Y-m-d').'',
		        'or_no' => 'required|unique:cashincome|unique:cashidsale|unique:sales|numeric',
		        'hospital_no' => 'required|numeric',
		        'ptname' => 'required',
		        'or_type' => 'required'
		    ]);
		if ($validator->passes()) {
			$mss = Mssclassification::where('patients_id', '=', $request->ptid)
									->where('validity', '>=', Carbon::now()->format('Y-m-d'))
									->first();
			if ($request->or_type == 'i') {
				$data = new Cashincome();
				$data->users_id = Auth::user()->id;
				$data->ancillaryrequist_id = 0;
				$data->patients_id = $request->ptid;
				
				if($mss){
					$data->mss_id = $mss->mss_id;
				}else{
					$data->mss_id = 0;
				}
				$data->category_id = 313;
				$data->price = 0;
				$data->qty = 0;
				$data->or_no = $request->or_no;
				$data->void = '1';
				$data->cash = 0;
				$data->discount = 0;
				$data->get = 'N';
				$data->created_at = $request->date;
				$data->save();
			}else{
				$now = Carbon::now();
				$date = Carbon::parse($now)->format('mdY');
				$modifier = $date.Auth::user()->id.$request->patient_id;

				$save = new Requisition();
				$save->users_id = Auth::user()->id;
				$save->patients_id = $request->ptid;
				$save->item_id = 1;
				$save->qty = 1;
				$save->modifier = $modifier;
				$save->save();


				$manage = new Pharmanagerequest();
				$manage->requisition_id = $save->id;
				$manage->users_id = Auth::user()->id;
				$manage->qty = 1;
				$manage->modifier = $modifier;
				$manage->save();

				$sale = new Sales();
				$sale->pharmanagerequest_id = $manage->id;
				$sale->users_id = Auth::user()->id;
				if($mss){
					$sale->mss_id = $mss->mss_id;
				}else{
					$sale->mss_id = 0;
				}
				$sale->price = 0;
				$sale->or_no = $request->or_no;
				$sale->void = 1;
				$sale->cash = '0';
				$sale->save();
			}
			return redirect()->back()->with('toaster', array('success', 'The O.R series successfully added'));
		}else{
			return redirect()->back()->withInput()->withErrors($validator);  
		}
	}
	public function changetransactionpatient(Request $request, $id)
	{
		if ($request->pthtype == 'pharmacy') {
			$sales = Sales::where('or_no', '=', $id)->get();
			foreach ($sales as $sale) {
				$manage = Pharmanagerequest::find($sale->pharmanagerequest_id);
				$data = Requisition::find($manage->requisition_id);
				$data->patients_id = $request->pthid;
				$data->save();
			}
		}
		elseif ($request->pthtype == 'hospital id') {
			$data = Cashidsale::where('or_no', '=', $id)->first();
			$data->patients_id = $request->pthid;
			$data->save();
		}
		elseif ($request->pthtype == 'income') {
			$incomes = Cashincome::where('or_no', '=', $id)->get();
			if (count($incomes) > 0) {
				foreach ($incomes as $data) {
					$data->patients_id = $request->pthid;
					$data->save();
				}
			}
			$payment = LaboratoryPayment::where('or_no', '=', $id)->first();
			if ($payment) {
				$LaboratoryRequest = LaboratoryRequest::where('id', '=', $payment->laboratory_request_id)->first();
				$data = LaboratoryRequestGroup::find($LaboratoryRequest->laboratory_request_group_id);
				$data->patient_id = $request->pthid;
				$data->save();
			}
		}
		echo json_encode($data);
		return;
		
	}
	
}