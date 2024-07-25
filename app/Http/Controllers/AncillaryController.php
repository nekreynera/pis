<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Clinic;
use App\Cashincomecategory;
use App\Cashincomesubcategory;
use App\Ancillaryrequist;
use App\Cashincome;
use App\Alert;
use App\Mss;
use PDF;
use DNS1D;
use DB;
use Carbon;
use Auth;
use Session;

class AncillaryController extends Controller
{
		

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$alert = Alert::where('clinic', Auth::user()->clinic)->first();
		if (!$alert) {
			$store = new Alert();
			$store->clinic = Auth::user()->clinic;
			$store->save();
		}
		if($request->list){
			$services = DB::table('cashincomecategory')
					->leftJoin('cashincomesubcategory', 'cashincomecategory.id', '=', 'cashincomesubcategory.cashincomecategory_id')
					->where('clinic_id', '=', Auth::user()->clinic)
					->where('cashincomesubcategory.trash', '=', 'N')
					->where('cashincomesubcategory.status', '=', $request->list)
					->orderBy('sub_category')
					->get();
		}else if ($request->trash) {
			$services = DB::table('cashincomecategory')
					->leftJoin('cashincomesubcategory', 'cashincomecategory.id', '=', 'cashincomesubcategory.cashincomecategory_id')
					->where('clinic_id', '=', Auth::user()->clinic)
					->where('cashincomesubcategory.trash', '=', $request->trash)
					->orderBy('sub_category')
					->get();
		}else{
			$services = DB::table('cashincomecategory')
					->leftJoin('cashincomesubcategory', 'cashincomecategory.id', '=', 'cashincomesubcategory.cashincomecategory_id')
					->where('clinic_id', '=', Auth::user()->clinic)
					->orderBy('sub_category')
					->get();
		}
		$tab = DB::table('cashincomecategory')
				->leftJoin('cashincomesubcategory', 'cashincomecategory.id', '=', 'cashincomesubcategory.cashincomecategory_id')
				->where('clinic_id', '=', Auth::user()->clinic)
				->orderBy('sub_category')
				->get();
		
		return view('ancillary.list', compact('services', 'request', 'tab'));
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
		// if(Auth::user()->clinic == "31"){
		// 	$id = $request->type;
		// }else{
			$category = Cashincomecategory::where('clinic_id', '=', Auth::user()->clinic)->first();
			$id = $category->id;
		// }
		
		$subcategory = new Cashincomesubcategory();
		$subcategory->cashincomecategory_id = $id;
		$subcategory->sub_category = $request->sub_category;
		$subcategory->price = $request->price;
		$subcategory->status = $request->status;
		$subcategory->type = $request->type;
		$subcategory->save();
		return redirect()->back()->with('toaster', array('success', 'Service Added.'));
		// dd($request);
	}
	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$service = Cashincomesubcategory::find($id);
		echo json_encode($service);
		return;
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
		 echo json_encode($id);
		 return;
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

	public function editservice(Request $request)
	{

		$service = Cashincomesubcategory::find($request->hidden_id);
		// if(Auth::user()->clinic == "31"){
		// $service->cashincomecategory_id = $request->type;
		// }
		$service->sub_category = $request->sub_category;
		$service->price = $request->price;
		$service->status = $request->status;
		$service->type = $request->type;
		$service->save();
		echo json_encode($service);
		return;
	}
	public function movetotrash($id)
	{
		$service = Cashincomesubcategory::find($id);
		$service->trash = 'Y';
		$service->save();
		return redirect()->back()->with('toaster', array('success', 'Service Deleted.'));
	}
	public function directrequisition()
	{
		return view('ancillary.scandirectrequistion');
	}

	public function scandirect(Request $request)
	{
		$patient =  DB::table('mss')
							->rightJoin('mssclassification', 'mss.id', '=', 'mssclassification.mss_id')
							->rightJoin('patients', 'mssclassification.patients_id', '=', 'patients.id')
							->where('patients.barcode', '=', $request->barcode)
							->orWhere('patients.hospital_no', '=', $request->barcode)
							->get()
							->first();
		if ($patient) {
			$services = DB::table('cashincomecategory')
						->leftJoin('cashincomesubcategory', 'cashincomecategory.id', '=', 'cashincomesubcategory.cashincomecategory_id')
						->where('cashincomecategory.clinic_id', '=', Auth::user()->clinic)
						->where('cashincomesubcategory.trash', '=', 'N')
						->where('cashincomesubcategory.status', '=', 'active')
						->orderBy('sub_category')
						->get();
			$pendingunpaid = DB::select("SELECT a.id, 
										COUNT(*) as req, 
										CONCAT(e.last_name,', ',e.first_name,' ',LEFT(e.middle_name, 1),'.') as users, 
										a.updated_at, 
										a.modifier
										FROM ancillaryrequist a
										LEFT JOIN cashincomesubcategory c ON a.cashincomesubcategory_id = c.id
										LEFT JOIN patients d ON a.patients_id = d.id
										LEFT JOIN users e ON a.users_id = e.id
										LEFT JOIN cashincomecategory f ON c.cashincomecategory_id = f.id
										WHERE a.id NOT IN(SELECT ancillaryrequist_id FROM cashincome WHERE ancillaryrequist_id >= 1)
										AND d.id = ?
										AND f.clinic_id = ?
										GROUP BY a.modifier
								", [$patient->id,
									Auth::user()->clinic]);
			// dd($patient->id);
			$pendingpaid = DB::select("SELECT a.id, 
											COUNT(*) as req,
											CONCAT(d.last_name,', ',d.first_name,' ',LEFT(d.middle_name, 1)) as users,
											a.updated_at,
											a.or_no
											FROM cashincome a  
											LEFT JOIN mss b ON a.mss_id = b.id
											LEFT JOIN patients c ON a.patients_id = c.id
											LEFT JOIN users d ON a.users_id = d.id
											LEFT JOIN cashincomesubcategory e ON a.category_id = e.id
											LEFT JOIN cashincomecategory f ON e.cashincomecategory_id = f.id
											WHERE a.get = 'N'
											AND c.id = ?
											AND f.clinic_id = ?
											GROUP BY a.or_no
											", [$patient->id,
												Auth::user()->clinic]);
			return view('ancillary.requisition', compact('patient', 'services', 'pendingunpaid', 'pendingpaid'));
		}else{
			return redirect()->back()->with('toaster', array('danger', 'Patient not found.'));
		}
		
	}

	public function ancillaryrequisition(Request $request)
	{
		// dd($request);
		$modifier = Str::random(20);
		foreach ($request->particular_id as $key => $u) {
			$ancillaryrequist = new Ancillaryrequist();
			$ancillaryrequist->users_id = Auth::user()->id;
			$ancillaryrequist->patients_id = $request->patient_id;
			$ancillaryrequist->cashincomesubcategory_id = $request->particular_id[$key];
			$ancillaryrequist->qty = $request->qty[$key];
			$ancillaryrequist->modifier = $modifier;
			$ancillaryrequist->save();
			if ($request->mss_id >= 9 && $request->mss_id <= 13) {
					$cashincome = new Cashincome();
					$cashincome->users_id = Auth::user()->id;
					$cashincome->ancillaryrequist_id = $ancillaryrequist->id;
					$cashincome->patients_id = $request->patient_id;
					$cashincome->mss_id = $request->mss_id;
					$cashincome->category_id = $request->particular_id[$key];
					$cashincome->price = $request->price[$key];
					$cashincome->qty = $request->qty[$key];
					$cashincome->or_no = $modifier;
					$cashincome->cash = '0';
					$discount = $request->price[$key] * $request->qty[$key]; 
					$cashincome->discount = $discount;
					$cashincome->save();
			}
		}
		if ($request->mss_id >= 9 && $request->mss_id <= 13) {
			return redirect('paidtransaction')->with('toaster', array('success', 'requisition save.'));
		}else{
			return redirect('unpaidtransaction')->with('toaster', array('success', 'requisition save.'));
		}
		
	}
	// public function ancillarytransaction()
	// {
	// 	$data = DB::select('SELECT 
	// 							(CASE 
	// 						     	WHEN e.mss_id 
	// 						     	THEN CONCAT(h.label,"-",h.description) 
	// 						     	ELSE CONCAT(c.label,"-",c.description) 
	// 						     END) as mss,
	// 							(CASE 
	// 						     	WHEN a.id IN(SELECT ancillaryrequist_id FROM cashincome)
	// 						     	THEN SUM((e.price * e.qty) - e.discount)
	// 						     	ELSE SUM((d.price * a.qty) * c.discount)
	// 						     END) as netamount,
	// 						b.first_name,b.middle_name,b.last_name, 
	// 						CONCAT(g.last_name,", ",g.first_name," ",LEFT(g.middle_name, 1), "." ) as users, 
	// 						a.created_at,
	// 						e.or_no,
	// 						a.modifier
	// 						FROM ancillaryrequist a 
	// 						LEFT JOIN patients b ON a.patients_id = b.id
	// 						LEFT JOIN mssclassification f ON a.patients_id = f.patients_id
	// 						LEFT JOIN mss c ON f.mss_id = c.id
	// 						LEFT JOIN cashincomesubcategory d ON a.cashincomesubcategory_id = d.id
	// 						LEFT JOIN cashincome e ON a.id = e.ancillaryrequist_id
 //                            LEFT JOIN users g ON a.users_id = g.id
 //                            LEFT JOIN mss h ON e.mss_id = h.id
	// 						WHERE DATE(a.created_at) = CURRENT_DATE()
 //                            GROUP BY a.modifier
 //                            ORDER BY a.created_at DESC
	// 						');
	// 	return view('ancillary.transaction', compact('data'));
	// }
	public function paidtransaction(Request $request)
	{
		if ($request->from || $request->to) {
			$data = DB::select("SELECT b.id, b.label, b.description,
													c.id as patient_id,
													c.last_name, c.first_name, c.middle_name,
											        CONCAT(d.last_name,', ',d.first_name,' ',LEFT(d.middle_name, 1)) as users,
											        a.created_at,
											        a.or_no,
											        b.discount
											FROM cashincome a  
											LEFT JOIN mss b ON a.mss_id = b.id
											LEFT JOIN patients c ON a.patients_id = c.id
											LEFT JOIN users d ON a.users_id = d.id
											LEFT JOIN cashincomesubcategory e ON a.category_id = e.id
											LEFT JOIN cashincomecategory f ON e.cashincomecategory_id = f.id
											WHERE DATE(a.created_at) >= ?
											AND DATE(a.created_at) <= ?
											AND f.clinic_id = ?
											AND a.void = '0'
											GROUP BY a.or_no
											ORDER BY a.created_at DESC
											", [$request->from,
												$request->to,
												Auth::user()->clinic]);
		}else{
			$data = DB::select("SELECT b.id, b.label, b.description,
										c.id as patient_id,
										c.last_name, c.first_name, c.middle_name,
								        CONCAT(d.last_name,', ',d.first_name,' ',LEFT(d.middle_name, 1)) as users,
								        a.created_at,
								        a.or_no,
								        b.discount
								FROM cashincome a  
								LEFT JOIN mss b ON a.mss_id = b.id
								LEFT JOIN patients c ON a.patients_id = c.id
								LEFT JOIN users d ON a.users_id = d.id
								LEFT JOIN cashincomesubcategory e ON a.category_id = e.id
								LEFT JOIN cashincomecategory f ON e.cashincomecategory_id = f.id
								WHERE DATE(a.created_at) = CURRENT_DATE()
								AND f.clinic_id = ?
								AND a.void = '0'
								GROUP BY a.or_no
								ORDER BY a.created_at DESC
								", [Auth::user()->clinic]);
		}
		return view('ancillary.transaction', compact('data'));
	}
	public function viewpaidrequisition($modifier, $patient_id)
	{ 
		$data = DB::select("SELECT a.id, b.id as sub_id, b.sub_category, a.patients_id, a.or_no,
									a.price, 
							        a.qty,
							        (a.price * a.qty) as amount,
							        a.discount, 
							        ((a.price * a.qty) - a.discount) as netamount
							FROM cashincome a 
							LEFT JOIN cashincomesubcategory b ON a.category_id = b.id
							WHERE a.or_no = ?
							AND b.status = 'active'
							",
							[$modifier]);
		$patient =  DB::table('mss')
							->rightJoin('mssclassification', 'mss.id', '=', 'mssclassification.mss_id')
							->rightJoin('patients', 'mssclassification.patients_id', '=', 'patients.id')
							->where('patients.id', '=', $patient_id)
							->get()
							->first();
		$services = DB::select("SELECT a.*, c.category_id
								FROM cashincomesubcategory a
								LEFT JOIN cashincomecategory b ON a.cashincomecategory_id = b.id
								LEFT JOIN cashincome c ON a.id = c.category_id AND c.or_no = ? 
								WHERE b.clinic_id = ?
								AND a.trash = 'N'
								AND a.status = 'active'
								ORDER BY a.sub_category ASC
								", [$modifier, Auth::user()->clinic]);

		return view('ancillary.usertransaction', compact('data', 'patient', 'services'));
	}
	public function updateancillaryrequisition(Request $request)
	{
		
		Cashincome::where('or_no', '=', $request->income_or_no)->delete();
		Ancillaryrequist::where('modifier', '=', $request->income_or_no)->delete();

		$modifier = Str::random(20);
		foreach ($request->particular_id as $key => $u) {
			$ancillaryrequist = new Ancillaryrequist();
			$ancillaryrequist->users_id = Auth::user()->id;
			$ancillaryrequist->patients_id = $request->patient_id;
			$ancillaryrequist->cashincomesubcategory_id = $request->particular_id[$key];
			$ancillaryrequist->qty = $request->qty[$key];
			$ancillaryrequist->modifier = $modifier;
			$ancillaryrequist->save();
			if ($request->mss_id >= 9 && $request->mss_id <= 13) {
					$cashincome = new Cashincome();
					$cashincome->users_id = Auth::user()->id;
					$cashincome->ancillaryrequist_id = $ancillaryrequist->id;
					$cashincome->patients_id = $request->patient_id;
					$cashincome->mss_id = $request->mss_id;
					$cashincome->category_id = $request->particular_id[$key];
					$cashincome->price = $request->price[$key];
					$cashincome->qty = $request->qty[$key];
					$cashincome->or_no = $modifier;
					$cashincome->cash = '0';
					$discount = $request->price[$key] * $request->qty[$key]; 
					$cashincome->discount = $discount;
					$cashincome->save();
			}
		}
		if ($request->mss_id >= 9 && $request->mss_id <= 13) {
			return redirect('paidtransaction')->with('toaster', array('success', 'requisition updated.'));
		}else{
			return redirect('unpaidtransaction')->with('toaster', array('success', 'requisition updated.'));
		}
		
	}
	public function removepaidrequisition($modifier)
	{
		Cashincome::where('or_no', '=', $modifier)->delete();
		Ancillaryrequist::where('modifier', '=', $modifier)->delete();
		return redirect()->back()->with('toaster', array('danger', 'requisition remove.'));
	}
	public function unpaidtransaction(Request $request)
	{
		if ($request->from || $request->to) {
			$data = DB::select("SELECT c.id, c.label,c.description,c.discount,
										d.id as patient_id,
								        d.first_name, d.middle_name, d.last_name,
								        CONCAT(e.last_name,', ',e.first_name,' ',LEFT(e.middle_name, 1),'.') as users,
								        a.created_at,
								        a.modifier
								FROM ancillaryrequist a 
								LEFT JOIN mssclassification b ON a.patients_id = b.patients_id 
								LEFT JOIN mss c ON b.mss_id = c.id 
								LEFT JOIN patients d ON  a.patients_id = d.id 
								LEFT JOIN users e ON a.users_id = e.id
								LEFT JOIN cashincomesubcategory f ON a.cashincomesubcategory_id = f.id
								LEFT JOIN cashincomecategory g ON f.cashincomecategory_id = g.id 
								WHERE a.id NOT IN(SELECT ancillaryrequist_id FROM cashincome WHERE ancillaryrequist_id >= 1)
								AND g.clinic_id = ?
								AND DATE(a.created_at) >= ?
								AND DATE(a.created_at) <= ?
								GROUP BY a.modifier
								ORDER BY a.created_at DESC
								", [Auth::user()->clinic,
									$request->from,
									$request->to]);
		}else{
			$data = DB::select("SELECT c.id, c.label,c.description,c.discount,
										d.id as patient_id,
								        d.first_name, d.middle_name, d.last_name,
								        CONCAT(e.last_name,', ',e.first_name,' ',LEFT(e.middle_name, 1),'.') as users,
								        a.created_at,
								        a.modifier
								FROM ancillaryrequist a 
								LEFT JOIN mssclassification b ON a.patients_id = b.patients_id 
								LEFT JOIN mss c ON b.mss_id = c.id 
								LEFT JOIN patients d ON  a.patients_id = d.id 
								LEFT JOIN users e ON a.users_id = e.id
								LEFT JOIN cashincomesubcategory f ON a.cashincomesubcategory_id = f.id
								LEFT JOIN cashincomecategory g ON f.cashincomecategory_id = g.id 
								WHERE a.id NOT IN(SELECT ancillaryrequist_id FROM cashincome WHERE ancillaryrequist_id >= 1)
								AND g.clinic_id = ?
								AND DATE(a.created_at) = CURRENT_DATE()
								GROUP BY a.modifier
								ORDER BY a.created_at DESC
								", [Auth::user()->clinic]);
		}
		return view('ancillary.unpaidtransaction', compact('data'));
	}
	public function viewunpaidrequisition($modifier, $patient_id)
	{
		$data = DB::select("SELECT a.id, b.id as sub_id, b.sub_category, a.patients_id, a.modifier as or_no,
									b.price, 
							        a.qty,
							        (b.price * a.qty) as amount,
                                    (CASE 
                                     	WHEN e.discount
                                     	THEN ((b.price * a.qty) * e.discount) 
                                     	ELSE '0'
                                     END) as discount,
							      	 (CASE 
                                     	WHEN e.discount
                                     	THEN ((b.price * a.qty) - ((b.price * a.qty) * e.discount)) 
                                     	ELSE (b.price * a.qty)
                                     END) as netamount
							FROM ancillaryrequist a 
							LEFT JOIN cashincomesubcategory b ON a.cashincomesubcategory_id = b.id
                            LEFT JOIN patients c ON a.patients_id = c.id 
                            LEFT JOIN mssclassification d ON c.id = d.patients_id
                            LEFT JOIN mss e ON d.mss_id = e.id
							WHERE a.modifier = ?
							AND b.status = 'active'
							AND a.id NOT IN(SELECT ancillaryrequist_id FROM cashincome WHERE ancillaryrequist_id >= 1)
							", [$modifier]);
		$patient =  DB::table('mss')
							->rightJoin('mssclassification', 'mss.id', '=', 'mssclassification.mss_id')
							->rightJoin('patients', 'mssclassification.patients_id', '=', 'patients.id')
							->where('patients.id', '=', $patient_id)
							->get()
							->first();
		$services = DB::select("SELECT a.*, c.cashincomesubcategory_id as category_id
										FROM cashincomesubcategory a
										LEFT JOIN cashincomecategory b ON a.cashincomecategory_id = b.id
										LEFT JOIN ancillaryrequist c ON a.id = c.cashincomesubcategory_id AND c.modifier = ? AND c.id NOT IN(SELECT ancillaryrequist_id FROM cashincome WHERE ancillaryrequist_id >= 1)
										WHERE b.clinic_id = ?
										AND a.trash = 'N'
										AND a.status = 'active'
										ORDER BY a.sub_category ASC
										", [$modifier, Auth::user()->clinic]
								);
		return view('ancillary.unpaidusertransaction', compact('data', 'patient', 'services'));
	}
	public function updateunpaidancillaryrequisition(Request $request)
	{
		Ancillaryrequist::where('modifier', '=', $request->income_or_no)->delete();
		$modifier = Str::random(20);
		if (COUNT($request->particular_id) > 0) {
			foreach ($request->particular_id as $key => $u) {
				$ancillaryrequist = new Ancillaryrequist();
				$ancillaryrequist->users_id = Auth::user()->id;
				$ancillaryrequist->patients_id = $request->patient_id;
				$ancillaryrequist->cashincomesubcategory_id = $request->particular_id[$key];
				$ancillaryrequist->qty = $request->qty[$key];
				$ancillaryrequist->modifier = $modifier;
				$ancillaryrequist->save();
				if ($request->mss_id >= 9 && $request->mss_id <= 13) {
						$cashincome = new Cashincome();
						$cashincome->users_id = Auth::user()->id;
						$cashincome->ancillaryrequist_id = $ancillaryrequist->id;
						$cashincome->patients_id = $request->patient_id;
						$cashincome->mss_id = $request->mss_id;
						$cashincome->category_id = $request->particular_id[$key];
						$cashincome->price = $request->price[$key];
						$cashincome->qty = $request->qty[$key];
						$cashincome->or_no = $modifier;
						$cashincome->cash = '0';
						$discount = $request->price[$key] * $request->qty[$key]; 
						$cashincome->discount = $discount;
						$cashincome->save();
				}
			}
		}
		if ($request->mss_id >= 9 && $request->mss_id <= 13) {
			return redirect('paidtransaction')->with('toaster', array('success', 'requisition updated.'));
		}else{
			return redirect('unpaidtransaction')->with('toaster', array('success', 'requisition updated.'));
		}
	}
	public function removeunpaidrequisition($modifier)
	{
		Ancillaryrequist::where('modifier', '=', $modifier)->delete();
		return redirect()->back()->with('toaster', array('danger', 'requisition remove.'));
	}
	public function maskasdonerequistion($modifier, $patient_id)
	{
		$data = DB::select("SELECT a.id, b.id as sub_id, b.sub_category, a.patients_id, a.or_no,
									a.price, 
							        a.qty,
							        (a.price * a.qty) as amount,
							        a.discount, 
							        ((a.price * a.qty) - a.discount) as netamount,
							        a.get
							FROM cashincome a 
							LEFT JOIN cashincomesubcategory b ON a.category_id = b.id
							LEFT JOIN cashincomecategory c ON b.cashincomecategory_id = c.id
							WHERE a.or_no = ?
							AND b.status = 'active'
							AND c.clinic_id = ?
							",
							[$modifier,
							Auth::user()->clinic]);
		$patient =  DB::table('mss')
							->rightJoin('mssclassification', 'mss.id', '=', 'mssclassification.mss_id')
							->rightJoin('patients', 'mssclassification.patients_id', '=', 'patients.id')
							->where('patients.id', '=', $patient_id)
							->get()
							->first();
		return view('ancillary.markasdonerequisition', compact('data', 'patient'));
	}
	public function markparticularasdone($id)
	{
		$paid = Cashincome::find($id);
		$paid->get = 'Y';
		$paid->save();
		return redirect()->back()->with('toaster', array('success', 'particular requisition finished'));
	}
	public function markparticularaspending($id)
	{
		$paid = Cashincome::find($id);
		$paid->get = 'N';
		$paid->save();
		return redirect()->back()->with('toaster', array('warning', 'particular requisition pending'));
	}
	public function viewpaidparticulars(Request $request)
	{
		$particulars = DB::select("SELECT a.id, b.id as sub_id, b.sub_category, a.patients_id, a.or_no,
											a.price, 
									        a.qty,
									        (a.price * a.qty) as amount,
									        a.discount, 
									        ((a.price * a.qty) - a.discount) as netamount
									FROM cashincome a 
									LEFT JOIN cashincomesubcategory b ON a.category_id = b.id
									LEFT JOIN cashincomecategory c ON b.cashincomecategory_id = c.id
									WHERE a.or_no = ?
									AND a.get = 'N'
									AND c.clinic_id = ?
									", 
									[$request->or_no,
									Auth::user()->clinic]);
		echo json_encode($particulars);
		return;
	}
	public function viewunpaidparticulars(Request $request)
	{
		$particulars = DB::select("SELECT a.id, b.id as sub_id, b.sub_category, a.patients_id, a.modifier as or_no,
											b.price, 
									        a.qty,
									        (b.price * a.qty) as amount,
		                                    (CASE 
		                                     	WHEN e.discount
		                                     	THEN ((b.price * a.qty) * e.discount) 
		                                     	ELSE '0'
		                                     END) as discount,
									      	 (CASE 
		                                     	WHEN e.discount
		                                     	THEN ((b.price * a.qty) - ((b.price * a.qty) * e.discount)) 
		                                     	ELSE (b.price * a.qty)
		                                     END) as netamount
									FROM ancillaryrequist a 
									LEFT JOIN cashincomesubcategory b ON a.cashincomesubcategory_id = b.id
		                            LEFT JOIN patients c ON a.patients_id = c.id 
		                            LEFT JOIN mssclassification d ON c.id = d.patients_id
		                            LEFT JOIN mss e ON d.mss_id = e.id
		                            LEFT JOIN cashincomecategory f ON b.cashincomecategory_id = f.id
									WHERE a.modifier = ?
									AND b.status = 'active'
									AND a.id NOT IN(SELECT ancillaryrequist_id FROM cashincome WHERE ancillaryrequist_id >= 1)
									AND f.clinic_id = ?
									", [$request->or_no,
										Auth::user()->clinic]);
		echo json_encode($particulars);
		return;
	}
	public function restoreservice($id)
	{
		$service = Cashincomesubcategory::find($id);
		$service->trash = "N";
		$service->save();
		return redirect()->back()->with('toaster', array('success', 'Service Restored.'));
	}
	public function getpatientinfo($id)
	{
		$patient = DB::select("SELECT a.*, c.label, c.description, c.discount, c.id as mss_id 
								FROM patients a 
								LEFT JOIN mssclassification b ON a.id = b.patients_id AND DATE(b.validity) >= CURRENT_DATE()
								LEFT JOIN mss c ON b.mss_id = c.id
								WHERE a.id = ?
							", [$id]);
		$services = DB::select("SELECT a.*, b.clinic_id, b.category 
							FROM cashincomesubcategory a 
							LEFT JOIN  cashincomecategory b ON a.cashincomecategory_id = b.id
							WHERE b.clinic_id = ?
							AND a.status = 'active' 
							AND trash = 'N'
							", [Auth::user()->clinic]);
		$pending = DB::select("SELECT c.id as serviceid,
										c.sub_category, 
										(CASE 
								         	WHEN b.id
								         	THEN b.price
								         	ELSE c.price
								        END) as price,
								        bb.price as bb_price,
								        (CASE 
								          	WHEN b.id 
								          	THEN b.qty 
								          	ELSE a.qty 
								        END) as qty,
								        bb.qty as bb_qty,
								        b.discount,
								        bb.discount as bb_discount,
								        pgg.granted_amount as pgg_granted_amount,
								        a.id as reqid,
								        b.id as cashid,
								        b.get,
								        b.mss_id,
								        (CASE 
								         	WHEN b.id
								         	THEN DATE(b.created_at)
								         	ELSE DATE(a.created_at)
								         END) as created_at,
								         CONCAT(e.label,' - ',e.description) as mss_name,
								         e.discount as mss_discount,
								         SUM(pg.granted_amount) as granted_amount
								FROM ancillaryrequist a
								LEFT JOIN cashincome b ON a.id = b.ancillaryrequist_id AND b.void = '0' AND (b.mss_charge IS NULL OR b.mss_charge = 2)
								LEFT JOIN cashincome bb ON a.id = bb.ancillaryrequist_id AND bb.void = '0'
								LEFT JOIN cashincomesubcategory c ON a.cashincomesubcategory_id = c.id
								LEFT JOIN cashincomecategory d ON c.cashincomecategory_id = d.id
								LEFT JOIN mss e ON b.mss_id = e.id
								LEFT JOIN payment_guarantor pg ON b.id = pg.payment_id AND pg.type = 0
								-- LEFT JOIN payment_guarantor pgg ON bb.id = pgg.payment_id AND pgg.type = 0
								LEFT JOIN 
									(SELECT payment_id, SUM(granted_amount) as granted_amount FROM payment_guarantor WHERE type = 0 GROUP BY payment_id) pgg 
								ON bb.id = pgg.payment_id
								WHERE a.patients_id = ?
								AND d.clinic_id = ?
								GROUP BY a.id
								ORDER BY a.id ASC
							" , [$id, Auth::user()->clinic]);
		echo json_encode(['patient' => $patient[0],'services' => $services, 'pending' => $pending]);
		return;
	}
	public function deleteserviceRequistion($id)
	{

		$requesition = Ancillaryrequist::where('id', '=', $id)->delete();
		echo json_encode($requesition);
		return;
	}
	public function insertServiceRequest(Request $request)
	{
		$modifier = Str::random(20);
		$requisition = new Ancillaryrequist();
		$requisition->users_id = Auth::user()->id;
		$requisition->clinic_id = Auth::user()->clinic;
		$requisition->patients_id = $request->patient_id;
		$requisition->cashincomesubcategory_id = $request->id;
		$requisition->qty = $request->qty;
		$requisition->modifier = $modifier;
		$requisition->save();
		// $mss = Mss::find($request->mss_id);
		$service = Cashincomesubcategory::find($request->id);
		// if ($mss->discount == 1 || $service->price <= 0) {
		// 	$service = Cashincomesubcategory::find($request->id);
		// 	$cashincome = new Cashincome();
		// 	$cashincome->users_id = Auth::user()->id;
		// 	$cashincome->ancillaryrequist_id = $requisition->id;
		// 	$cashincome->patients_id = $request->patient_id;
		// 	$cashincome->mss_id = $request->mss_id;
		// 	$cashincome->category_id = $request->id;
		// 	$cashincome->price = $service->price;
		// 	$cashincome->qty = $request->qty;
		// 	$cashincome->or_no = $modifier;
		// 	$cashincome->cash = '0';
		// 	$discount = $service->price * $request->qty;
		// 	$cashincome->discount = $discount;
		// 	$cashincome->save();
		// 	echo json_encode(['requisition' => $requisition, 'cashincome' => $cashincome]);
		// }else{
			$cashincome = null;
			echo json_encode(['requisition' => $requisition, 'cashincome' => $cashincome]);
		// }
		
		return;
	}
	public function editServiceRequest(Request $request)
	{
		$requisition = Ancillaryrequist::find($request->reqid);
		$requisition->qty = $request->reqqty;
		$requisition->save();
		echo json_encode($requisition);
		return;
	}
	public function statusServiceRequistion(Request $request)
	{
		$paid = Cashincome::find($request->cashid);
		$paid->get = $request->stats;
		$paid->save();
		echo json_encode($paid);
		return;
	}
	public function deletefreeservicerequisition($id)
	{
		$free = Cashincome::find($id);
		if ($free->ancillaryrequist_id) {
			if ($free->ancillaryrequist_id > 0) {
				$requisition = Ancillaryrequist::find($free->ancillaryrequist_id);
				$requisition->delete();
			}
		}
		$free->delete();
		echo json_encode(["free" => $free, "requisition" => $requisition]);
		return;
	}
	public function patientservicehistory($id)
	{
		$history = DB::select("SELECT b.sub_category, 
							a.price,
					        a.qty, 
					        a.discount,
					        CONCAT(e.last_name,', ',e.first_name,' ',LEFT(e.middle_name, 1),'.') as reqname,
					        CONCAT(f.last_name,', ',f.first_name,' ',LEFT(f.middle_name, 1),'.') as asname,
					        DATE(d.created_at) as dates,
					        (CASE 
					        	WHEN g.discount = 1 
					        	THEN CONCAT(g.label,' - ',g.description)
					        	ELSE a.or_no 
					        END) as or_no,
					        SUM(pg.granted_amount) as granted_amount
					FROM cashincome a 
					LEFT JOIN cashincomesubcategory b ON a.category_id = b.id
					LEFT JOIN cashincomecategory c ON b.cashincomecategory_id = c.id
					LEFT JOIN ancillaryrequist d ON a.ancillaryrequist_id = d.id
					LEFT JOIN users e ON a.users_id = e.id
					LEFT JOIN users f ON d.users_id = f.id
					LEFT JOIN mss g ON a.mss_id = g.id
					LEFT JOIN payment_guarantor pg ON a.id = pg.payment_id AND pg.type = 0
					WHERE a.patients_id = ?
					AND a.get = 'Y'
					GROUP BY d.id
					ORDER BY d.created_at ASC, d.id ASC
					", [$id]);
		echo json_encode($history);
		return;
	}
	
}