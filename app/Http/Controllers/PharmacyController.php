<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use App\AncillaryItem;
use App\Pharstocks;
use App\Pharitemstatus;
use App\Pharlogs;
use App\Patient;
use App\Requisition;
use App\Pharmanagerequest;
use App\Pharinventory;
use App\Sales;
use App\Pharchargeless;
use App\Mssclassification;
use Carbon\Carbon;
use App\Postcharge;
use DB;
use Validator;
use Auth;
use Session;

class PharmacyController extends Controller
{
		

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		
		if ($request->stats == 'active') {
			// dd("123");
			$medicine = DB::table('pharstocks')
					->rightJoin('pharitemstatus', 'pharstocks.items_id', '=', 'pharitemstatus.items_id')
					->rightJoin('ancillary_items', 'pharitemstatus.items_id', '=', 'ancillary_items.id')
					->where('clinic_code', '=', '1031')
					->where('pharitemstatus.status', '=', 'Y')
					->where('ancillary_items.trash', '=', 'N')
			        ->orderBy('ancillary_items.id', 'DESC')
					->get();
		}elseif ($request->stats == 'inactive') {
			// dd("12s3");
			$medicine = DB::table('pharstocks')
					->rightJoin('pharitemstatus', 'pharstocks.items_id', '=', 'pharitemstatus.items_id')
					->rightJoin('ancillary_items', 'pharitemstatus.items_id', '=', 'ancillary_items.id')
					->where('clinic_code', '=', '1031')
					->where('pharitemstatus.status', '=', 'N')
					->where('ancillary_items.trash', '=', 'N')
			        ->orderBy('ancillary_items.id', 'DESC')
					->get();
		}elseif ($request->stats == 'deleted') {
			$medicine = DB::table('pharstocks')
								->rightJoin('pharitemstatus', 'pharstocks.items_id', '=', 'pharitemstatus.items_id')
								->rightJoin('ancillary_items', 'pharitemstatus.items_id', '=', 'ancillary_items.id')
								->where('clinic_code', '=', '1031')
								->where('ancillary_items.trash', '=', 'Y')
						        ->orderBy('ancillary_items.id', 'DESC')
								->get();
		}else{
			$medicine = DB::table('pharstocks')
					->rightJoin('pharitemstatus', 'pharstocks.items_id', '=', 'pharitemstatus.items_id')
					->rightJoin('ancillary_items', 'pharitemstatus.items_id', '=', 'ancillary_items.id')
					->where('clinic_code', '=', '1031')
			        ->orderBy('ancillary_items.id', 'DESC')
					->get();
		}
		$counting = DB::table('pharstocks')
					->rightJoin('pharitemstatus', 'pharstocks.items_id', '=', 'pharitemstatus.items_id')
					->rightJoin('ancillary_items', 'pharitemstatus.items_id', '=', 'ancillary_items.id')
					->where('clinic_code', '=', '1031')
			        ->orderBy('ancillary_items.id', 'DESC')
					->get();
		

		$maxid = DB::select("SELECT MAX(CAST(SUBSTRING(item_id, 4, length(item_id)-3) AS UNSIGNED)) as result FROM ancillary_items WHERE clinic_code = '1031'");
		$maxids = $maxid[0]->result + 1;
        $maxids =  str_pad($maxids, 7, '0', STR_PAD_LEFT);

		return view('pharmacy.medicine', compact('medicine', 'maxids', 'counting'));
		
	}
	
	public function store(Request $request)
	{

		$medicine = new AncillaryItem();
		$medicine->clinic_code = '1031';
		$medicine->item_id = $request->item_id;
		$medicine->brand = $request->brand;
		$medicine->item_description = $request->item_description;
		$medicine->expire_date = $request->expire_date;
		$medicine->unitofmeasure = $request->unitofmeasure;
		$medicine->price = $request->price;
		$medicine->save();

		$status = new Pharitemstatus();
		$status->items_id = $medicine->id;
		$status->status = $request->status;
		$status->save();

		$stock = new Pharstocks();
		$stock->items_id = $medicine->id;
		$stock->stock = $request->stock;
		$stock->save();

		$logs = new Pharlogs();
		$logs->users_id = Auth::user()->id;
		$logs->items_id = $medicine->id;
		$logs->action = 'Added new item';
		$logs->remarks = $request->remarks;
		$logs->save();

		$invetory = new Pharinventory();
		$invetory->users_id = Auth::user()->id;
		$invetory->item_id =  $medicine->id;
		$invetory->qty = $request->stock;
		$invetory->save();


		return redirect()->back()->with('toaster', array('success', 'Medicine Added.'));
	}


	public function update(Request $request, $id)
	{
	 	$medicine = AncillaryItem::find($id);
	 	if ($medicine->brand != $request->brand || 
	 		$medicine->item_description != $request->item_description || 
	 		$medicine->unitofmeasure != $request->unitofmeasure || 
	 		$medicine->expire_date != $request->expire_date ||
	 		$medicine->price != $request->price) {
	 		$logs = new Pharlogs();
	 		$logs->users_id = Auth::user()->id;
	 		$logs->items_id = $id;
	 		$logs->action = 'updated specification';
	 		$logs->remarks = $request->remarks;
	 		$logs->save();
	 		$medicine->brand = $request->brand;
	 		$medicine->item_description = $request->item_description;
	 		$medicine->unitofmeasure = $request->unitofmeasure;
	 		$medicine->expire_date = $request->expire_date;
	 		$medicine->price = $request->price;
	 		$medicine->save();
	 	}
	 	

	 	$status = Pharitemstatus::where('items_id', '=', $id)->get()->first();
	 	if ($status) {
		 	if ($status->status != $request->status) {
		 		$status->status = $request->status;
		 		$status->save();
		 		$logs = new Pharlogs();
		 		$logs->users_id = Auth::user()->id;
		 		$logs->items_id = $id;
		 		$logs->action = 'Changed the status to '.$request->status.'';
		 		$logs->remarks = $request->remarks;
		 		$logs->save();
		 	}
	 	}else{
	 		$insert = new Pharitemstatus();
	 		$insert->items_id = $medicine->id;
	 		$insert->status = $request->status;
	 		$insert->save();
	 	}
	 	

	 	$stock = Pharstocks::where('items_id', '=', $id)->get()->first();
	 	if ($stock) {
		 	if ($stock->stock != $request->stock) {

		 		$logs = new Pharlogs();
		 		$logs->users_id = Auth::user()->id;
		 		$logs->items_id = $id;
		 		$logs->action = $request->actstock.' '.$request->inputstock;
		 		$logs->remarks = $request->remarks;
		 		$logs->save();

		 		$stock->stock = $request->stock;
		 		$stock->save();
		 	}
	 	}else{
	 		$logs = new Pharlogs();
	 		$logs->users_id = Auth::user()->id;
	 		$logs->items_id = $id;
	 		$logs->action = $request->actstock.' '.$request->inputstock;
	 		$logs->remarks = $request->remarks;
	 		$logs->save();

	 		$inserts = new Pharstocks();
	 		$inserts->items_id = $medicine->id;
	 		$inserts->stock = $request->stock;
	 		$inserts->save();
	 	}
	 	if ($request->inputstock) {
	 		$invetory = new Pharinventory();
		 	$invetory->users_id = Auth::user()->id;
		 	$invetory->item_id = $medicine->id;
		 	$invetory->qty = $request->inputstock;
		 	$invetory->save();
	 	}
	 	

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
		$med = AncillaryItem::find($id); 
		$med->trash = 'Y';
	 	$med->save();

	 	// $stock = Pharstocks::where('items_id', '=', $id);
	 	// $stock->delete();

	 	/*kaylangan hin delete*/
		
		$logs = new Pharlogs();
		$logs->users_id = Auth::user()->id;
		$logs->items_id = $id;
		$logs->action = 'Moved the item to trash';
		$logs->save();

		echo json_encode($med);
	    return;
	}
	public function edititem(Request $request)
	{
		$medicine = DB::table('pharstocks')
		->rightJoin('pharitemstatus', 'pharstocks.items_id', '=', 'pharitemstatus.items_id')
		->rightJoin('ancillary_items', 'pharitemstatus.items_id', '=', 'ancillary_items.id')
		->where('ancillary_items.id', '=', $request->id)
		->get()->first();

		echo json_encode($medicine);
		return;
	}
	public function logs()
	{
		if (isset($_GET['from']) && isset($_GET['to'])) {
		$logs = DB::select("SELECT a.id, d.item_id, d.brand, d.item_description, a.action, a.remarks, 
						CONCAT(b.last_name,', ',b.first_name,' ', LEFT( b.	middle_name, 1), '.') as user_name, 
						a.created_at 
						FROM pharlogs a 
						LEFT JOIN users b ON a.users_id = b.id
						LEFT JOIN ancillary_items d ON a.items_id = d.id
						WHERE DATE(a.created_at) >= '".$_GET['from']."' 
						AND DATE(a.created_at) <= '".$_GET['to']."' 
						ORDER BY a.id DESC
		        		");
		}else{
			$logs = [];
		}
		// dd($logs);
		return view('pharmacy.logs', compact('logs'));
	}
	// public function setmedicine(Request $request)
	// {
	// 	$patient =  DB::table('mss')
	// 						->rightJoin('mssclassification', 'mss.id', '=', 'mssclassification.mss_id')
	// 						->rightJoin('patients', 'mssclassification.patients_id', '=', 'patients.id')
	// 						->where('patients.barcode', '=', $request->barcode)
	// 						->orWhere('patients.hospital_no', '=', $request->barcode)
	// 						->get()
	// 						->first();
	// 	if ($patient) {
	// 		$medicines = DB::select("SELECT b.stock, 
	// 										b.level, 
	// 										c.status, 
	// 										a.* 
	// 									FROM ancillary_items a
	//                                     LEFT JOIN pharstocks b ON b.items_id = a.id
	//                                     LEFT JOIN pharitemstatus c ON c.items_id = a.id
	//                                     WHERE a.clinic_code = 1031
	//                                     AND b.stock > 0
	//                                     AND c.status = 'Y'
	//                                     ORDER BY a.item_description ASC");
	// 		// dd($patient->id);
	// 		$requisition = DB::select("SELECT CONCAT(b.last_name,', ',b.first_name,' ',LEFT(b.middle_name, 1),'.') as user_name,
	// 										COUNT(*) as many,
	// 								        a.updated_at,
	// 								        a.modifier,
 //                                            SUM(a.qty) as req,
 //                                            (SELECT SUM(qty) FROM requisition WHERE modifier = a.modifier GROUP BY modifier)  as req,
 //                                            SUM(c.qty) as mgmt,
 //                                            (CASE 
 //                                         	WHEN c.qty 
 //                                         	THEN (SELECT SUM(qty) FROM pharmanagerequest WHERE modifier = c.modifier GROUP BY modifier)
 //                                         	ELSE 0
 //                                         END) as mgmt
	// 								FROM requisition a 
	// 								LEFT JOIN users b ON a.users_id = b.id
 //                                    LEFT JOIN pharmanagerequest c ON a.id = c.requisition_id
 //                                    WHERE a.patients_id = ?
 //                                   	AND (SELECT SUM(qty) FROM requisition WHERE modifier = a.modifier AND item_id = a.item_id GROUP BY modifier) 
 //                                    	>
 //                                        (CASE 
 //                                         	WHEN c.qty 
 //                                         	THEN (SELECT SUM(qty) FROM pharmanagerequest WHERE modifier = c.modifier AND requisition_id = c.requisition_id  GROUP BY modifier)
 //                                         	ELSE 0
 //                                         END)
	// 								GROUP BY a.modifier
	// 								ORDER BY a.created_at DESC
	// 								", [$patient->id]);
	// 		$managed = DB::select("SELECT CONCAT(b.last_name,', ',b.first_name,' ',LEFT(b.middle_name, 1),'.') as user_name,
	// 													CONCAT(d.last_name,', ',d.first_name,' ',LEFT(d.middle_name, 1),'.') as reqby,
	// 													COUNT(*) as many,
	// 											        a.updated_at,
	// 											        a.modifier
	// 											FROM pharmanagerequest a 
	// 											LEFT JOIN users b ON a.users_id = b.id
	// 		                                    LEFT JOIN requisition c ON a.requisition_id = c.id
	// 		                                    LEFT JOIN users d ON c.users_id = d.id
	// 											WHERE c.patients_id = ?
	// 											AND a.id NOT IN(select pharmanagerequest_id from sales)
	// 											GROUP BY a.modifier
	// 											ORDER BY a.created_at DESC
	// 											", [$patient->id]);
	// 		$paid = DB::select("SELECT CONCAT(c.last_name,', ',c.first_name,' ',LEFT(c.middle_name, 1),'.') as user_name,
	// 									CONCAT(e.last_name,', ',e.first_name,' ',LEFT(e.middle_name, 1),'.') as pharmacist,
	// 								COUNT(*) as many,
	// 							    a.updated_at,
	// 							    a.mss_id,
	// 							    a.or_no
	// 							FROM sales a 
	// 							LEFT JOIN pharmanagerequest b on a.pharmanagerequest_id = b.id
	// 							LEFT JOIN users c ON a.users_id = c.id
	// 							LEFT JOIN users e ON b.users_id = e.id
	// 							LEFT JOIN requisition d ON b.requisition_id = d.id
	// 							WHERE a.status = 'N'
	// 							AND d.patients_id = ?
	// 							GROUP BY a.or_no
	// 							ORDER BY a.created_at DESC
	// 							", [$patient->id]);
	// 		return view('pharmacy.manualinput', compact('patient', 'medicines', 'requisition', 'managed', 'paid'));
	// 	}
	// 	else{
	// 		return redirect()->back()->with('toaster', array('error', 'Patient not found.'));
	// 	}
	// }

	// public function saverequest(Request $request)
	// {
	// 	$modifier = Str::random(20);
	// 	foreach ($request->inputqty as $key => $u) {
	// 		$manage = new Pharmanagerequest();
	// 		$manage->qty = $request->inputqty[$key];
	// 		$manage->requisition_id = $request->inputid[$key];
	// 		$manage->modifier = $modifier;
	// 		$manage->users_id = Auth::user()->id;
	// 		$manage->save();
	// 		$stock = Pharstocks::where('items_id', '=', $request->anc_id[$key])->get()->first();
	// 		$stock->stock = $stock->stock - $request->inputqty[$key];
	// 		$stock->save();  
	//  		$invetory = new Pharinventory();
	// 	 	$invetory->users_id = Auth::user()->id;
	// 	 	$invetory->item_id = $request->anc_id[$key];
	// 	 	$invetory->qty = '-'.$request->inputqty[$key];
	// 	 	$invetory->save();
	// 	 	$medicine = AncillaryItem::find($request->anc_id[$key]);
	// 	 	if ($request->mss_id >= 9 || $medicine->price <= 0) {
	// 	 		$sale = new Sales();
	// 			$sale->pharmanagerequest_id = $manage->id;
	// 			$sale->users_id = Auth::user()->id;
	// 			$sale->mss_id = $request->mss_id;
	// 			$sale->price = $request->priceid[$key];
	// 			$sale->or_no = '0';
	// 			$sale->cash = '0';
	// 			$sale->save();
	// 	 	}
	// 	}
		
	// 	return redirect('phartransaction')->with('toaster', array('success', 'Patient request managed/controlled.'));


	// }
	// public function markasdone(Request $request)
	// {
	// 	foreach ($request->id as $key => $v) {
	// 		$sales = Sales::find($request->id[$key]);
	// 		$sales->status = 'Y';
	// 		$sales->save();
	// 	}
	// 	return redirect('patientrequest')->with('toaster', array('success', 'Patient requisition done.'));
	// }
	// public function transaction(Request $request)
	// {
	
	// 	if (isset($request->from) && isset($request->to)) {
	// 	$transaction = DB::select("SELECT d.id,f.label,f.description, a.or_no, b.modifier, a.price, 
	// 								CONCAT(d.last_name,', ',d.first_name,' ', LEFT(d.middle_name, 1), '.') as patient_name, 
	// 								d.address, 
	// 								SUM(b.qty * a.price) as total_amount, 
	// 								(CASE 
	// 									WHEN f.discount 
	// 									THEN SUM((b.qty * a.price) * f.discount)
	// 									ELSE 0 
	// 								END) as discount_price,
	// 								(CASE 
	// 									WHEN f.discount
	// 									THEN SUM((b.qty * a.price) - ((b.qty * a.price) * f.discount)) 
	// 									ELSE SUM(b.qty * a.price)
	// 								END) as paid
	// 								FROM sales a 
	// 								LEFT JOIN pharmanagerequest b ON a.pharmanagerequest_id = b.id
	// 								LEFT JOIN requisition c ON b.requisition_id = c.id
	// 								LEFT JOIN ancillary_items g ON c.item_id = g.id
	// 								LEFT JOIN patients d ON c.patients_id = d.id
	// 								LEFT JOIN mssclassification e ON d.id = e.patients_id
	// 								LEFT JOIN mss f ON a.mss_id = f.id
	// 								WHERE DATE(a.created_at) >= ?
	// 								AND DATE(a.created_at) <= ?
	// 								AND a.status = 'Y'
	// 								AND b.users_id = ?
	// 								GROUP BY a.or_no, b.modifier
	// 								ORDER BY a.id DESC
	// 							", [$request->from, $request->to, Auth::user()->id]);
	// 	}
	// 	else{
	// 		$transaction = [];
	// 	}
	// 	return view('pharmacy.transaction', compact('transaction'));
	// }
	// public function managedtransaction()
	// {
	// 	$transaction = DB::select("SELECT a.id, e.label, e.description, 
	// 								CONCAT(f.last_name, ' ', f.first_name, ', ', f.middle_name) as patient_name,
	// 								SUM((c.price * a.qty) * e.discount) as netamount,
 //                                    CONCAT(g.last_name, ' ', g.first_name, ', ', g.middle_name) as users_name,
 //                                    a.created_at,
 //                                    a.updated_at,
 //                                    a.modifier
	// 								FROM pharmanagerequest a 
	// 								LEFT JOIN requisition b ON a.requisition_id = b.id
	// 								LEFT JOIN ancillary_items c ON b.item_id = c.id
	// 								LEFT JOIN mssclassification d ON b.patients_id = d.patients_id
	// 								LEFT JOIN mss e ON d.mss_id = e.id
	// 								LEFT JOIN patients f ON b.patients_id = f.id 
 //                                    LEFT JOIN users g ON a.users_id = g.id
	// 								WHERE a.id NOT IN(select pharmanagerequest_id from sales)
	// 								AND a.users_id = ?
	// 								GROUP BY a.modifier
	// 								", [Auth::user()->id]);
	// 	return view('pharmacy.managerequestbygroup', compact('transaction'));
	// }
	// public function editmanagereqeust($modifier)
	// {
	// 	$transaction = DB::select("SELECT a.id, e.label, e.description, 
	// 								CONCAT(f.last_name, '-', f.first_name, '-', f.middle_name) as name,
	// 								c.item_description, c.brand, c.price, a.qty
	// 								FROM pharmanagerequest a 
	// 								LEFT JOIN requisition b ON a.requisition_id = b.id
	// 								LEFT JOIN ancillary_items c ON b.item_id = c.id
	// 								LEFT JOIN mssclassification d ON b.patients_id = d.patients_id
	// 								LEFT JOIN mss e ON d.mss_id = e.id
	// 								LEFT JOIN patients f ON b.patients_id = f.id 
	// 								WHERE a.id NOT IN(select pharmanagerequest_id from sales)
	// 								AND a.modifier = ?
	// 								", [$modifier]);
	// 	return view('pharmacy.pendingtransaction', compact('transaction'));
	// }
	// public function cancelmanagerequest($modifier)
	// {
	// 	$manage = DB::select("SELECT b.item_id, a.qty, a.modifier
	// 						FROM pharmanagerequest a
	// 						LEFT JOIN requisition b ON a.requisition_id = b.id
	// 						WHERE a.modifier = ?", [$modifier]);
	// 	foreach ($manage as $list) {
	// 		$stock = DB::update("UPDATE pharstocks SET stock = stock + ? WHERE items_id = ?", [$list->qty, $list->item_id]); 
	// 	}
	// 	$delete = DB::delete("DELETE FROM `pharmanagerequest` WHERE modifier = ?", [$modifier]);
	// 	return back()->with('toaster', array('error', 'Managed requisition Canceled.'));
	// }
	// public function inventory()
	// {
		
	// 	$inventory = DB::select("SELECT a.brand, 
	// 									a.item_description, 
	// 							        a.unitofmeasure,
	// 									a.price, 
	// 							        a.expire_date, 
	// 							        a.trash, 
	// 							        b.stock, 
	// 							        c.status 
	// 							FROM ancillary_items a 
	// 							LEFT JOIN pharstocks b ON a.id = b.items_id
	// 							LEFT JOIN pharitemstatus c ON a.id = c.items_id
	// 							ORDER BY a.brand ASC
	// 							");
		
		
	// 	return view('pharmacy.inventory', compact('inventory'));
	// }
	// public function getusertransaction(Request $request)
	// {
	// 	$transaction = DB::select("SELECT f.label,f.description, a.or_no,d.age,e.mswd, a.price, g.unitofmeasure, 
 // 							CONCAT(d.last_name,', ',d.first_name,' ', LEFT(d.middle_name, 1), '.') as patient_name, 
 // 					        d.address, g.item_description, g.brand, b.qty, (b.qty * a.price) as total_amount, 
 // 					        (CASE 
 // 					        	WHEN f.discount 
 // 					        	THEN ((b.qty * a.price) * f.discount)
 // 					        	ELSE 0 
 // 					        END) as discount_price,
 // 					        (CASE 
 // 					        	WHEN f.discount 
 // 					        	THEN ((b.qty * a.price) - ((b.qty * a.price) * f.discount))
 // 					        	ELSE (b.qty * a.price)
 // 					        END) as paid
 // 					FROM sales a 
 // 					LEFT JOIN pharmanagerequest b ON a.pharmanagerequest_id = b.id
 // 					LEFT JOIN requisition c ON b.requisition_id = c.id
 // 					LEFT JOIN ancillary_items g ON c.item_id = g.id
 // 					LEFT JOIN patients d ON c.patients_id = d.id
 // 					LEFT JOIN mssclassification e ON d.id = e.patients_id
 // 					LEFT JOIN mss f ON a.mss_id = f.id
 // 					WHERE a.or_no = ?
 // 					AND b.modifier = ?
 // 					AND DATE(a.created_at) >= ?
	// 				AND DATE(a.created_at) <= ?
	// 				AND a.status = 'Y'
 // 					ORDER BY a.id DESC
	// 						", [$request->or_no, $request->modifier, $request->from, $request->to]);
		
	// 	echo json_encode($transaction);
	// 	return;
	// }
	public function getItemstatus(Request $request)
	{
		$item = DB::select("SELECT b.item_id, a.action, b.brand, b.item_description, b.expire_date, c.stock,d.status,
							CONCAT(e.last_name,' ',e.first_name,' ',e.middle_name) as name 
							FROM pharlogs a
							LEFT JOIN ancillary_items b ON a.items_id = b.id
							LEFT JOIN pharstocks c ON a.items_id = c.items_id
							LEFT JOIN pharitemstatus d ON a.items_id = d.items_id
							LEFT JOIN users e ON a.users_id = e.id
							WHERE a.id = ".$request->item_id."
							");
		echo json_encode($item[0]);
		return;
	}
	// public function updatemanageqty(Request $request)
	// {
	// 	$manage = Pharmanagerequest::find($request->id);
	// 	$requisition = Requisition::find($manage->requisition_id); 
	// 	if ($manage->qty > $request->qtyinput) {
	// 		$deff = $manage->qty - $request->qtyinput;
	// 		$stock = DB::update("UPDATE pharstocks SET stock = stock + ? WHERE items_id = ?", [$deff, $requisition->item_id]);
	// 	}
	// 	if ($manage->qty < $request->qtyinput) {
	// 		$deff = $request->qtyinput - $manage->qty;
	// 		$stock = DB::update("UPDATE pharstocks SET stock = stock - ? WHERE items_id = ?", [$deff, $requisition->item_id]);
	// 	}
	// 	$manage->qty = $request->qtyinput;
	// 	$manage->save();
	// 	echo json_encode($requisition);

	// 	return;
	// }
	public function deletemanageqty(Request $request)
	{
		$manage = Pharmanagerequest::find($request->id);
		$requisition = Requisition::find($manage->requisition_id);
		$stock = DB::update("UPDATE pharstocks SET stock = stock + ? WHERE items_id = ?", [$manage->qty, $requisition->item_id]);
		$manage->delete();
		echo json_encode($manage);

		return;
		
	}
	// public function manualinput()
	// {
	// 	return view('pharmacy.manualscan');
	// }
    // public function pharmacystore(Request $request)
    // {
    // 		    $modifier = Str::random(20);
    // 		    foreach ($request->item_id as $key => $value) {
    // 	            $requisition = new Requisition();
    // 	            $requisition->users_id = Auth::user()->id;
    // 	            $requisition->patients_id = $request->patient_id;
    // 	            $requisition->item_id = $request->item_id[$key];
    // 	            $requisition->qty = $request->qtyreq[$key];
    // 	            $requisition->modifier = $modifier;
    // 	            $requisition->save();
    	           

    // 	           			$manage = new Pharmanagerequest();
    // 	           			$manage->qty = $request->qtyman[$key];
    // 	           			$manage->requisition_id = $requisition->id;
    // 	           			$manage->modifier = $modifier;
    // 	           			$manage->users_id = Auth::user()->id;
    // 	           			$manage->save();
    // 	           			$stock = Pharstocks::where('items_id', '=', $request->item_id[$key])->get()->first();
    // 	           			$stock->stock = $stock->stock - $request->qtyman[$key];
    // 	           			$stock->save();  
    // 	           	 		$invetory = new Pharinventory();
    // 	           		 	$invetory->users_id = Auth::user()->id;
    // 	           		 	$invetory->item_id = $request->item_id[$key];
    // 	           		 	$invetory->qty = '-'.$request->qtyman[$key];
    // 	           		 	$invetory->save();
    	           		 	
    // 	           		 		if ($request->mss_id >= 9 || $request->pricereq[$key] <= 0) {
	   //  	           		 		$sale = new Sales();
	   //  	           				$sale->pharmanagerequest_id = $manage->id;
	   //  	           				$sale->users_id = Auth::user()->id;
	   //  	           				$sale->mss_id = $request->mss_id;
	   //  	           				$sale->price = $request->pricereq[$key];
	   //  	           				$sale->or_no = $modifier;
	   //  	           				$sale->cash = '0';
	   //  	           				$sale->save();
    // 	           		 		}
    // 	        }
    // 	        Session::flash('toaster', array('success', 'Requisition saved.'));
    // 	        return redirect('phartransaction');
    // }
    // public function viewpendingrequisition(Request $request)
    // {
    // 	$requisition = DB::select("SELECT a.item_id,
    // 									c.brand, 
    // 									c.item_description,
    // 							        a.qty,
    // 							        (CASE 
    // 							        	WHEN d.qty 
    // 							        	THEN d.qty 
    // 							        	ELSE 0 
    // 							        END) as mgmt,
    // 							        a.modifier,
    // 							        c.price
    // 							FROM requisition a 
    // 							LEFT JOIN users b ON a.users_id = b.id
    //                             LEFT JOIN ancillary_items c ON a.item_id = c.id
    // 							LEFT JOIN pharmanagerequest d ON a.id = d.requisition_id
    // 							WHERE a.modifier = ?
    // 							", [$request->orno]);
    // 	echo json_encode($requisition);
    // 	return;
    // }
    // public function viewmanagedrequisition(Request $request)
    // {
    // 	$managed = DB::select("SELECT b.item_id,
    // 									d.brand, 
    // 									d.item_description,
    // 							        a.qty,
    // 							        a.modifier as mgmtmod,
    // 							        b.modifier as reqmod,
    // 							        d.price
    // 							FROM pharmanagerequest a 
    //                             LEFT JOIN requisition b ON a.requisition_id = b.id
    // 							LEFT JOIN users c ON a.users_id = c.id
    //                             LEFT JOIN ancillary_items d ON b.item_id = d.id
    // 							WHERE a.modifier = ?
    // 							", [$request->orno]);
    // 	echo json_encode($managed);
    // 	return;
    // }
  //   public function viewpaidrequisition(Request $request)
  //   {
		// $paid = DB::select("SELECT c.item_id,
		// 								f.brand, 
		// 								f.item_description,
		// 						        b.qty,
		// 						        a.or_no,
		// 						        a.mss_id,
		// 						        f.price,
		// 						        c.modifier,
		// 						        c.patients_id
  //                               FROM sales a 
		// 						LEFT JOIN pharmanagerequest b ON a.pharmanagerequest_id = b.id
	 //                            LEFT JOIN requisition c ON b.requisition_id = c.id
		// 						LEFT JOIN users d ON a.users_id = d.id
	 //                            LEFT JOIN ancillary_items f ON c.item_id = f.id
		// 						WHERE a.or_no = ?
  //                               AND a.status = 'N'
		// 						", [$request->orno]);
  //   	echo json_encode($paid);
  //   	return;
  //   }
  //   public function managerequistion($modifier, $patient_id)
  //   {
		// $patient =  DB::table('mss')
		// 					->rightJoin('mssclassification', 'mss.id', '=', 'mssclassification.mss_id')
		// 					->rightJoin('patients', 'mssclassification.patients_id', '=', 'patients.id')
		// 					->where('patients.id', '=', $patient_id)
		// 					->get()
		// 					->first();
							
		// 					// dd($modifier);
		// if ($patient) {
		// 	$medicines = DB::select("SELECT a.id, 
		// 											c.id as anc_id, 
		// 									        c.brand, 
		// 									        c.item_description, 
		// 									        c.price, 
		// 									        a.qty as rqty,
		// 											b.stock, 
		// 											d.status,
		// 											c.expire_date,
		// 														  (SELECT SUM(qty) FROM pharmanagerequest WHERE requisition_id = a.id) as manage_qty, 
		// 														 (CASE 
		// 															WHEN b.stock < (a.qty - (CASE 
		// 									                                                 	WHEN (SELECT SUM(qty) FROM pharmanagerequest WHERE requisition_id = a.id) 
		// 									                                                 	THEN (SELECT SUM(qty) FROM pharmanagerequest WHERE requisition_id = a.id) ELSE 0 
		// 									                                                 END)) 
		// 									                       THEN b.stock
		// 														  END) as ramaining,
		// 														 (CASE 
		// 									                        WHEN b.stock 
		// 									                           THEN 
		// 																 (CASE 
		// 									                                WHEN b.stock <= 0 
		// 									                                THEN 'OUT OF STOCK'
		// 									                              END)
		// 									                           ELSE 'OUT OF STOCK'
		// 														  END) as error
		// 									FROM requisition a 
		// 									LEFT JOIN pharstocks b ON a.item_id = b.items_id
		// 									LEFT JOIN ancillary_items c ON a.item_id = c.id
		// 									LEFT JOIN  pharitemstatus d ON a.item_id = d.items_id
		// 									WHERE a.patients_id = ?
		// 									AND a.modifier = ?
		// 									AND a.qty > (CASE 
		// 									             	WHEN (SELECT SUM(qty) FROM pharmanagerequest WHERE requisition_id = a.id) 
		// 									             	THEN (SELECT SUM(qty) FROM pharmanagerequest WHERE requisition_id = a.id) 
		// 									             	ELSE 0 
		// 									             END)
		// 									ORDER BY a.id ASC
	 //                                    ", [$patient_id, $modifier]);
			
			
		// 	return view('pharmacy.managerequistion', compact('patient', 'medicines'));
		// }
		
		
    	
  //   }
 //    public function removemanagerequistion(Request $request)
	// {
	
	// 	$manage = DB::select("SELECT b.item_id, a.qty, a.modifier
	// 						FROM pharmanagerequest a
	// 						LEFT JOIN requisition b ON a.requisition_id = b.id
	// 						WHERE a.modifier = ?", [$request->orno]);
	// 	foreach ($manage as $list) {
	// 		$stock = DB::update("UPDATE pharstocks SET stock = stock + ? WHERE items_id = ?", [$list->qty, $list->item_id]); 
	// 		$insert = DB::insert("INSERT INTO `pharinventory`(`users_id`, `item_id`, `qty`) VALUES (?,?,?)", [Auth::user()->id, $list->item_id, $list->qty]);
	// 	}
	// 	$delete = DB::delete("DELETE FROM `pharmanagerequest` WHERE modifier = ?", [$request->orno]);
	// 	return back()->with('toaster', array('error', 'Managed requisition Canceled.'));
	// }

	// public function editmanagerequistion($modifier, $patients_id, $mgmtmod)
	// {
	// 	$patient =  DB::table('mss')
	// 						->rightJoin('mssclassification', 'mss.id', '=', 'mssclassification.mss_id')
	// 						->rightJoin('patients', 'mssclassification.patients_id', '=', 'patients.id')
	// 						->where('patients.id', '=', $patients_id)
	// 						->get()
	// 						->first();
	// 	$managed = DB::select("SELECT d.id as mgmtid, 
	// 												a.id as reqid,
	// 												c.id as anc_id, 
	// 										        c.brand, 
	// 										        c.item_description, 
	// 										        c.price, 
	// 										        a.qty as rqty,
	// 										        e.status,
	// 										        c.expire_date,
	// 												(CASE 
	// 													WHEN (SELECT SUM(qty) FROM pharmanagerequest WHERE requisition_id = a.id AND id IN(SELECT pharmanagerequest_id FROM sales WHERE status = 'Y')) 
	// 													THEN (SELECT SUM(qty) FROM pharmanagerequest WHERE requisition_id = a.id AND id IN(SELECT pharmanagerequest_id FROM sales WHERE status = 'Y')) ELSE 0 
	// 												  END) as manage_qty, 
	// 												b.stock, 
	// 															 (CASE 
	// 																WHEN b.stock < (a.qty - (CASE 
	// 										                                                 	WHEN (SELECT SUM(qty) FROM pharmanagerequest WHERE requisition_id = a.id) 
	// 										                                                 	THEN (SELECT SUM(qty) FROM pharmanagerequest WHERE requisition_id = a.id) ELSE 0 
	// 										                                                 END)) 
	// 										                       THEN b.stock
	// 															  END) as ramaining,
	// 															 (CASE 
	// 										                        WHEN b.stock 
	// 										                           THEN 
	// 																	 (CASE 
	// 										                                WHEN b.stock <= 0 
	// 										                                THEN 'OUT OF STOCK'
	// 										                              END)
	// 										                           ELSE 'OUT OF STOCK'
	// 															  END) as error,
	// 															  d.qty as mgmtqty
	// 										FROM requisition a 
	// 										LEFT JOIN pharstocks b ON a.item_id = b.items_id
	// 										LEFT JOIN ancillary_items c ON a.item_id = c.id
 //                                            LEFT JOIN pharmanagerequest d ON a.id = d.requisition_id
 //                                            LEFT JOIN pharitemstatus e ON a.item_id = e.items_id
 //                                            WHERE d.modifier = ?
	// 										AND a.patients_id = ?
	// 										AND a.modifier = ?
	// 										ORDER BY a.id ASC
	// 								", [$mgmtmod, $patients_id, $modifier]);
	// 	return view('pharmacy.editmanagerequisition', compact('patient', 'managed', 'mgmtmod'));
		
	// }
	// public function updatemanagerequest(Request $request)
	// {
	// 	$mod = Str::random(20);
	// 	$manage = DB::select("SELECT b.item_id, a.qty, a.modifier
	// 						FROM pharmanagerequest a
	// 						LEFT JOIN requisition b ON a.requisition_id = b.id
	// 						WHERE a.modifier = ?", [$request->modifier]);
	// 	foreach ($manage as $list) {
	// 		$stock = DB::update("UPDATE pharstocks SET stock = stock + ? WHERE items_id = ?", [$list->qty, $list->item_id]); 
	// 	}
	// 	$delete = DB::delete("DELETE FROM `pharmanagerequest` WHERE modifier = ?", [$request->modifier]);

	// 	foreach ($request->price as $key => $u) {
	// 		$managed = new Pharmanagerequest();
	// 		$managed->requisition_id = $request->reqid[$key];
	// 		$managed->users_id = Auth::user()->id;
	// 		$managed->qty = $request->inputqty[$key];
	// 		$managed->modifier = $mod;
	// 		$managed->save();
	// 			$stock = Pharstocks::where('items_id', '=', $request->anc_id[$key])->get()->first();
	// 			$stock->stock = $stock->stock - $request->inputqty[$key];
	// 			$stock->save();  
	// 		 		$invetory = new Pharinventory();
	// 			 	$invetory->users_id = Auth::user()->id;
	// 			 	$invetory->item_id = $request->anc_id[$key];
	// 			 	$invetory->qty = '-'.$request->inputqty[$key];
	// 			 	$invetory->save();
	// 	}
	// 	Session::flash('toaster', array('success', 'Managed Requisition updated.'));
 //    	return redirect('phartransaction');
		
	// }
	// public function editpaidrequistion($modifier, $mss, $id)
	// {
	// 	$patient =  DB::select("SELECT *, b.id as mss_id, a.id as patient_id 
	// 							FROM patients a 
	// 							LEFT JOIN mss b ON b.id = ?
	// 							WHERE a.id = ?
	// 							", [$mss, $id]);
	// 	$patient = $patient[0];
	// 			if ($patient) {
	// 				$medicines = DB::select("SELECT b.stock, 
	// 												b.level, 
	// 												c.status, 
	// 												a.*,
	// 												d.id as req_id
	// 											FROM ancillary_items a
	// 		                                    LEFT JOIN pharstocks b ON b.items_id = a.id
	// 		                                    LEFT JOIN pharitemstatus c ON c.items_id = a.id
	// 		                                    LEFT JOIN requisition d ON a.id = d.item_id AND d.modifier = ? AND d.id 
	// 		                                    	IN(SELECT pharmanagerequest.requisition_id 
	// 		                                    		FROM pharmanagerequest 
	// 		                                    		LEFT JOIN sales ON pharmanagerequest.id = sales.pharmanagerequest_id
	// 		                                    		WHERE sales.status = 'N')
	// 		                                    WHERE a.clinic_code = 1031
	// 		                                    AND b.stock > 0
	// 		                                    AND c.status = 'Y'
	// 		                                    ORDER BY a.item_description ASC"
	// 		                                    , [$modifier] );
	// 				// dd($medicines);
	// 				$requisition = DB::select("SELECT b.id,
	// 												  a.item_id,
	// 												  a.qty,
	// 												  b.brand,
	// 												  b.item_description,
	// 												  b.unitofmeasure,
	// 												  b.price
	// 											FROM requisition a 
	// 											LEFT JOIN ancillary_items b ON a.item_id = b.id
	// 											LEFT JOIN pharmanagerequest c ON a.id = c.requisition_id
	// 											LEFT JOIN sales d ON c.id = d.pharmanagerequest_id
	// 											WHERE a.modifier = ?
	// 											AND d.status = 'N'
	// 											", [$modifier]);
	// 				// dd($requisition);
	// 				return view('pharmacy.editpaidrequisition', compact('patient', 'medicines', 'requisition', 'modifier'));
	// 			}
	// 			else{
	// 				return redirect()->back()->with('toaster', array('error', 'Patient not found.'));
	// 			}
	// }
	// public function updatepaidrequisition(Request $request)
	// {
	// 	$modifier = Str::random(20);
	// 		$requisition = Requisition::where('modifier', '=', $request->modifier)->get();
	// 		// dd($requisition);
	// 		foreach ($requisition as $list) {
	// 			$pharinventory = DB::insert("INSERT INTO `pharinventory`(`users_id`, `item_id`, `qty`) VALUES (?,?,?)", [Auth::user()->id, $list->item_id, $list->qty]);
	// 			$stock = Pharstocks::where('items_id', '=', $list->item_id)->first();
	// 			$stock->stock = $stock->stock + $list->qty;
	// 			$stock->save();
	// 			$manage = Pharmanagerequest::where('requisition_id', '=', $list->id)->first();
	// 			$sales = Sales::where('pharmanagerequest_id', '=', $manage->id)->first();
	// 			$req = Requisition::find($list->id)->delete();
	// 			$manage->delete();
	// 			$sales->delete();

	// 		}
	// 		if (count($request->item_id) > 0) {
	// 	    foreach ($request->item_id as $key => $value) {
	//             $requisition = new Requisition();
	//             $requisition->users_id = Auth::user()->id;
	//             $requisition->patients_id = $request->patient_id;
	//             $requisition->item_id = $request->item_id[$key];
	//             $requisition->qty = $request->qtyreq[$key];
	//             $requisition->modifier = $modifier;
	//             $requisition->save();
	           

	//            			$manage = new Pharmanagerequest();
	//            			$manage->qty = $request->qtyman[$key];
	//            			$manage->requisition_id = $requisition->id;
	//            			$manage->modifier = $modifier;
	//            			$manage->users_id = Auth::user()->id;
	//            			$manage->save();
	//            			$stock = Pharstocks::where('items_id', '=', $request->item_id[$key])->get()->first();
	//            			$stock->stock = $stock->stock - $request->qtyman[$key];
	//            			$stock->save();  
	//            	 		$invetory = new Pharinventory();
	//            		 	$invetory->users_id = Auth::user()->id;
	//            		 	$invetory->item_id = $request->item_id[$key];
	//            		 	$invetory->qty = '-'.$request->qtyman[$key];
	//            		 	$invetory->save();
	           		 	
	//            		 		if ($request->mss_id >= 9 || $request->pricereq[$key] <= 0) {
 //    	           		 		$sale = new Sales();
 //    	           				$sale->pharmanagerequest_id = $manage->id;
 //    	           				$sale->users_id = Auth::user()->id;
 //    	           				$sale->mss_id = $request->mss_id;
 //    	           				$sale->price = $request->pricereq[$key];
 //    	           				$sale->or_no = $modifier;
 //    	           				$sale->cash = '0';
 //    	           				$sale->save();
	//            		 		}
	//         }
	//         Session::flash('toaster', array('success', 'Paid Requisition updated.'));
	//     }else{
	//     	Session::flash('toaster', array('error', 'Requisition is now empty.'));
	//     }
	//     return redirect('phartransaction');
	// }
	public function phartransaction(Request $request)
	{
		// dd($request->hospital_no);
		if ($request->hospital_no) {
			$transaction = DB::select("SELECT b.hospital_no,
												a.patients_id, 
												b.last_name, b.first_name, b.middle_name, 
										        COUNT(a.patients_id) as requisition,
										        COUNT(c.requisition_id) as managed,
										        COUNT(d.pharmanagerequest_id) as paid,
										        f.*,
										        d.or_no
										FROM requisition a
										LEFT JOIN patients b ON a.patients_id = b.id
										LEFT JOIN pharmanagerequest c ON a.id = c.requisition_id
										LEFT JOIN sales d ON c.id = d.pharmanagerequest_id AND d.void = 0
										LEFT JOIN mssclassification e ON b.id = e.patients_id
										LEFT JOIN mss f ON e.mss_id = f.id
										WHERE b.hospital_no = ? 
										GROUP BY a.patients_id
										ORDER BY a.created_at DESC
										", [$request->hospital_no]);
			if (count($transaction) <= 0) {
				$transaction = DB::select("SELECT a.hospital_no,
													a.id as patients_id,
													a.last_name,
													a.first_name,
													a.middle_name,
													'0' as requisition,
													'0' as managed,
													'0' as paid,
													b.mss_id as id,
													c.label,
													c.description,
													c.discount,
													null as or_no
											FROM patients a 
											LEFT JOIN mssclassification b ON a.id = b.patients_id
											LEFT JOIN mss c ON b.mss_id = c.id
											WHERE a.hospital_no = ?
											", [$request->hospital_no]);
				// dd($transaction);
			}
			$pending = [];
		}else{
			if ($request->from || $request->to) {
				$transaction = DB::select("SELECT b.hospital_no,
													a.patients_id, 
													b.last_name, b.first_name, b.middle_name, 
											        COUNT(a.patients_id) as requisition,
											        COUNT(c.requisition_id) as managed,
											        COUNT(d.pharmanagerequest_id) as paid,
											        f.*,
											        d.or_no
											FROM requisition a
											LEFT JOIN patients b ON a.patients_id = b.id
											LEFT JOIN pharmanagerequest c ON a.id = c.requisition_id
											LEFT JOIN sales d ON c.id = d.pharmanagerequest_id AND d.void = 0
											LEFT JOIN mssclassification e ON b.id = e.patients_id
											LEFT JOIN mss f ON e.mss_id = f.id
											WHERE DATE(a.created_at) >= ? 
											AND DATE(a.created_at) <= ? 
											GROUP BY a.patients_id
											ORDER BY a.created_at DESC
											", [$request->from, $request->to]);
				$pending = DB::select("SELECT 
										(SELECT COUNT(*) 
									     	FROM requisition 
									     	WHERE id NOT IN(SELECT requisition_id FROM pharmanagerequest) 
									    	AND DATE(created_at) BETWEEN ? AND ?
									    ) as request,
									    (SELECT COUNT(*) 
									     	FROM pharmanagerequest 
									     	WHERE id NOT IN(SELECT pharmanagerequest_id FROM sales)
									     	AND DATE(created_at) BETWEEN ? AND ?
									    )as managed,
									    (SELECT COUNT(*) 
									     	FROM sales 
									     	WHERE sales.status = 'N'
									    	AND DATE(created_at) BETWEEN ? AND ?
									    ) as pending_sales,
									    (SELECT COUNT(*) 
									     	FROM sales 
									     	WHERE sales.status = 'Y'
									    	AND DATE(created_at) BETWEEN ? AND ?
									    	AND sales.void = '0'
									    ) as done_sales
									FROM requisition
									LIMIT 1", [$request->from, $request->to,
												$request->from, $request->to,
												$request->from, $request->to,
												$request->from, $request->to]);
			}else{
				$transaction = DB::select("SELECT b.hospital_no,
													a.patients_id, 
													b.last_name, b.first_name, b.middle_name, 
											        COUNT(a.patients_id) as requisition,
											        COUNT(c.requisition_id) as managed,
											        COUNT(d.pharmanagerequest_id) as paid,
											        f.*,
											        d.or_no
											FROM requisition a
											LEFT JOIN patients b ON a.patients_id = b.id
											LEFT JOIN pharmanagerequest c ON a.id = c.requisition_id
											LEFT JOIN sales d ON c.id = d.pharmanagerequest_id AND d.void = 0
											LEFT JOIN mssclassification e ON b.id = e.patients_id
											LEFT JOIN mss f ON e.mss_id = f.id
											WHERE DATE(a.created_at) = CURRENT_DATE() 
											GROUP BY a.patients_id
											ORDER BY a.created_at DESC");
				$pending = DB::select("SELECT 
										(SELECT COUNT(*) 
									     	FROM requisition
									    	WHERE id NOT IN(SELECT requisition_id FROM pharmanagerequest) 
									    	AND DATE(created_at) = CURRENT_DATE()
									    ) as request,
									    (SELECT COUNT(*) 
									     	FROM pharmanagerequest 
									     	WHERE id NOT IN(SELECT pharmanagerequest_id FROM sales)
									     	AND DATE(created_at) = CURRENT_DATE()
									    )as managed,
									    (SELECT COUNT(*) 
									     	FROM sales 
									     	WHERE sales.status = 'N'
									    	AND DATE(sales.created_at) = CURRENT_DATE()
									    ) as pending_sales,
									    (SELECT COUNT(*) 
									     	FROM sales 
									     	WHERE sales.status = 'Y'
									    	AND DATE(sales.created_at) = CURRENT_DATE()
									    ) as done_sales
									FROM requisition
									LIMIT 1");
			}
		}
		$medicines = DB::select("SELECT b.stock, 
										b.level, 
										c.status, 
										a.* 
									FROM ancillary_items a
                                    LEFT JOIN pharstocks b ON b.items_id = a.id
                                    LEFT JOIN pharitemstatus c ON c.items_id = a.id
                                    WHERE a.clinic_code = 1031
                                    AND b.stock > 0
                                    AND c.status = 'Y'
                                    AND a.trash = 'N'
                                    ORDER BY a.item_description ASC");
		

		return view("pharmacy.overview", compact('medicines', 'transaction', 'pending'));
	}
	public function transactionlist(Request $request)
	{
		if ($request->from != "" || $request->to != "") {
		$transaction = DB::select("SELECT b.hospital_no,
											a.patients_id, 
											b.last_name, b.first_name, b.middle_name, 
									        COUNT(a.patients_id) as requisition,
									        COUNT(c.requisition_id) as managed,
									        COUNT(d.pharmanagerequest_id) as paid,
									        f.*
									FROM requisition a
									LEFT JOIN patients b ON a.patients_id = b.id
									LEFT JOIN pharmanagerequest c ON a.id = c.requisition_id
									LEFT JOIN sales d ON c.id = d.pharmanagerequest_id
									LEFT JOIN mssclassification e ON b.id = e.patients_id
									LEFT JOIN mss f ON e.mss_id = f.id
									WHERE DATE(a.created_at) >= ? 
									AND DATE(a.created_at) <= ? 
									GROUP BY a.patients_id
									ORDER BY a.created_at DESC
									", [$request->from, $request->to]);
		}elseif ($request->hospital_no != "") {
		$transaction = DB::select("SELECT b.hospital_no,
											a.patients_id, 
											b.last_name, b.first_name, b.middle_name, 
									        COUNT(a.patients_id) as requisition,
									        COUNT(c.requisition_id) as managed,
									        COUNT(d.pharmanagerequest_id) as paid,
									        f.*
									FROM requisition a
									LEFT JOIN patients b ON a.patients_id = b.id
									LEFT JOIN pharmanagerequest c ON a.id = c.requisition_id
									LEFT JOIN sales d ON c.id = d.pharmanagerequest_id
									LEFT JOIN mssclassification e ON b.id = e.patients_id
									LEFT JOIN mss f ON e.mss_id = f.id
									WHERE b.hospital_no = ?
									GROUP BY a.patients_id
									ORDER BY a.created_at DESC",
									[$request->hospital_no]);
		}else{
		$transaction = DB::select("SELECT b.hospital_no,
											a.patients_id, 
											b.last_name, b.first_name, b.middle_name, 
									        COUNT(a.patients_id) as requisition,
									        COUNT(c.requisition_id) as managed,
									        COUNT(d.pharmanagerequest_id) as paid,
									        f.*
									FROM requisition a
									LEFT JOIN patients b ON a.patients_id = b.id
									LEFT JOIN pharmanagerequest c ON a.id = c.requisition_id
									LEFT JOIN sales d ON c.id = d.pharmanagerequest_id
									LEFT JOIN mssclassification e ON b.id = e.patients_id
									LEFT JOIN mss f ON e.mss_id = f.id
									WHERE DATE(a.created_at) = CURRENT_DATE() 
									GROUP BY a.patients_id
									ORDER BY a.created_at DESC");
		}
		echo json_encode($transaction);
		return;
	}
	public function viewpatientmedtransaction(Request $request)
	{
		if ($request->hospital_no != "") {
			$user = DB::select("SELECT a.id as requisition,
									g.brand,
							        g.item_description,
							        (CASE 
							        	WHEN d.id
							        	THEN d.price
							        	ELSE g.price
							        END) as price,
							        a.qty,
							        c.qty as mgmtqty,
							        c.id as managed,
							        d.id as sales,
							        f.discount,
							        d.mss_id,
							        d.price as sale_price,
							        d.status as get,
							        b.id as patient,
							        a.item_id,
							        CONCAT(h.last_name,', ',h.first_name,' ', LEFT(h.last_name, 1),'.') as req_name,
							        CONCAT(i.last_name,', ',i.first_name,' ', LEFT(i.last_name, 1),'.') as mgmt_name,
							        (CASE WHEN d.id THEN d.created_at ELSE a.created_at END) as created_at,
							        j.stock
								FROM requisition a
								LEFT JOIN patients b ON a.patients_id = b.id
								LEFT JOIN pharmanagerequest c ON a.id = c.requisition_id
								LEFT JOIN sales d ON c.id = d.pharmanagerequest_id AND d.void = 0
								LEFT JOIN mssclassification e ON b.id = e.patients_id
								LEFT JOIN mss f ON e.mss_id = f.id
	                            LEFT JOIN ancillary_items g ON a.item_id = g.id
	                            LEFT JOIN users h ON a.users_id = h.id
	                            LEFT JOIN users i ON c.users_id = i.id
	                            LEFT JOIN pharstocks j ON a.item_id = j.items_id
	                            WHERE a.patients_id = ?
	                            ORDER BY a.created_at DESC	
								", [$request->id]);
		}else{
			if ($request->from != "" || $request->to != "") {
			$user = DB::select("SELECT a.id as requisition,
									g.brand,
							        g.item_description,
							        (CASE 
							        	WHEN d.id
							        	THEN d.price
							        	ELSE g.price
							        END) as price,
							        a.qty,
							        c.qty as mgmtqty,
							        c.id as managed,
							        d.id as sales,
							        f.discount,
							        d.mss_id,
							        d.price as sale_price,
							        d.status as get,
							        b.id as patient,
							        a.item_id,
							        CONCAT(h.last_name,', ',h.first_name,' ', LEFT(h.last_name, 1),'.') as req_name,
							        CONCAT(i.last_name,', ',i.first_name,' ', LEFT(i.last_name, 1),'.') as mgmt_name,
							        (CASE WHEN d.id THEN d.created_at ELSE a.created_at END) as created_at,
							        j.stock
								FROM requisition a
								LEFT JOIN patients b ON a.patients_id = b.id
								LEFT JOIN pharmanagerequest c ON a.id = c.requisition_id
								LEFT JOIN sales d ON c.id = d.pharmanagerequest_id AND d.void = 0
								LEFT JOIN mssclassification e ON b.id = e.patients_id
								LEFT JOIN mss f ON e.mss_id = f.id
	                            LEFT JOIN ancillary_items g ON a.item_id = g.id
	                            LEFT JOIN users h ON a.users_id = h.id
	                            LEFT JOIN users i ON c.users_id = i.id
	                             LEFT JOIN pharstocks j ON a.item_id = j.items_id
	                            WHERE a.patients_id = ?
	                            AND (DATE(a.created_at) >= ? AND DATE(a.created_at) <= ?)
	                            ORDER BY a.created_at DESC	
								", [$request->id,
									$request->from, $request->to]);
			}else{
			$user = DB::select("SELECT a.id as requisition,
									g.brand,
							        g.item_description,
							        (CASE 
							        	WHEN d.id
							        	THEN d.price
							        	ELSE g.price
							        END) as price,
							        a.qty,
							        c.qty as mgmtqty,
							        c.id as managed,
							        d.id as sales,
							        f.discount,
							        d.mss_id,
							        d.price as sale_price,
							        d.status as get,
							        b.id as patient,
							        a.item_id,
							        CONCAT(h.last_name,', ',h.first_name,' ', LEFT(h.last_name, 1),'.') as req_name,
							        CONCAT(i.last_name,', ',i.first_name,' ', LEFT(i.last_name, 1),'.') as mgmt_name,
							        (CASE WHEN d.id THEN d.created_at ELSE a.created_at END) as created_at,
							        j.stock
								FROM requisition a
								LEFT JOIN patients b ON a.patients_id = b.id
								LEFT JOIN pharmanagerequest c ON a.id = c.requisition_id
								LEFT JOIN sales d ON c.id = d.pharmanagerequest_id AND d.void = 0
								LEFT JOIN mssclassification e ON b.id = e.patients_id
								LEFT JOIN mss f ON e.mss_id = f.id
	                            LEFT JOIN ancillary_items g ON a.item_id = g.id
	                            LEFT JOIN users h ON a.users_id = h.id
	                            LEFT JOIN users i ON c.users_id = i.id
	                            LEFT JOIN pharstocks j ON a.item_id = j.items_id
	                            WHERE a.patients_id = ?
	                            AND (DATE(a.created_at) = CURRENT_DATE())
	                            ORDER BY a.created_at DESC
								", [$request->id]);
			}
		}
		echo json_encode($user);
		return;
	}

	public function updatetransactionissuance(Request $request)
	{
		$sales = Sales::find($request->id);
		$sales->status = $request->gets;
		$sales->save();
		echo json_encode($sales);
		return;
	}

	public function managerequisition(Request $request)
	{
		
		$now = Carbon::now();
		$date = Carbon::parse($now)->format('mdY');
		$modifier = $date.Auth::user()->id.$request->patient_id;

		$manage = new Pharmanagerequest();
		$manage->requisition_id = $request->id;
		$manage->users_id = Auth::user()->id;
		$manage->qty = $request->qty;
		$manage->modifier = $modifier;
		if ($request->qty > 0) {
		$manage->save();
		}else{
			$manage = null;
		}

		$mss = Mssclassification::where('patients_id', '=', $request->patient_id)
				->where('validity', '>=', Carbon::parse($now)->format('Y-m-d'))
				->first();
		if ($mss && $manage) {
			if ($mss->mss_id >= 9 && $mss->mss_id <= 13 || $request->price <= 0) {
		 		$sale = new Sales();
				$sale->pharmanagerequest_id = $manage->id;
				$sale->users_id = Auth::user()->id;
				$sale->mss_id = $mss->mss_id;
				$sale->price = $request->price;
				$sale->or_no = $modifier;
				$sale->cash = '0';
				$sale->save();
			}
			else{
				$sale = null;
			}
		}
		else{
			$sale = null;
		}

		if ($manage) {
		$stock = Pharstocks::where('items_id', '=', $request->item_id)->first();
		$stock->stock = $stock->stock - $request->qty;
		$stock->save();  

 		$invetory = new Pharinventory();
	 	$invetory->users_id = Auth::user()->id;
	 	$invetory->item_id = $request->item_id;
	 	$invetory->qty = '-'.$request->qty;
	 	$invetory->save();
		}

		
		echo json_encode(['manage' =>  $manage, 'sale' => $sale]);

		return;
	}

	public function updatemanagerequisition(Request $request)
	{
		
		$manage = Pharmanagerequest::find($request->id);
		$requisition = Requisition::find($manage->requisition_id);
		$stock = Pharstocks::where('items_id', '=', $requisition->item_id)->first();
 		$invetory = new Pharinventory();
	 	$invetory->users_id = Auth::user()->id;
	 	$invetory->item_id = $requisition->item_id;
		

		if ($manage->qty > $request->qty) {
			$stock->stock = $stock->stock + ($manage->qty - $request->qty);
			$invetory->qty = $manage->qty - $request->qty;
		}else if ($manage->qty < $request->qty) {
			$stock->stock = $stock->stock - ($request->qty - $manage->qty);
			$invetory->qty = '-'.($request->qty - $manage->qty);
		}


		$manage->qty = $request->qty;
		$invetory->save();
		$stock->save();
		$manage->save();
		echo json_encode($manage);
		return;
	}

	public function cancelmanagerequisition(Request $request)
	{
		$manage = Pharmanagerequest::find($request->id);
		$requisition = Requisition::find($manage->requisition_id);

			$stock = Pharstocks::where('items_id', '=', $requisition->item_id)->first();
			$stock->stock = $stock->stock + $manage->qty;
			$stock->save();

			
	 		$invetory = new Pharinventory();
		 	$invetory->users_id = Auth::user()->id;
		 	$invetory->item_id = $requisition->item_id;
		 	$invetory->qty = $manage->qty;
		 	$invetory->save();

		$manage->delete();
		echo json_encode($manage);
		return;
	}
	public function saverequistion(Request $request)
	{
		$now = Carbon::now();
		$date = Carbon::parse($now)->format('mdY');
		$modifier = $date.Auth::user()->id.$request->patient_id;

		$save = new Requisition();
		$save->users_id = Auth::user()->id;
		$save->patients_id = $request->patient_id;
		$save->item_id = $request->item_id;
		$save->qty = $request->req_qty;
		$save->modifier = $modifier;
		$save->save();


		$manage = new Pharmanagerequest();
		$manage->requisition_id = $save->id;
		$manage->users_id = Auth::user()->id;
		$manage->qty = $request->mgmt_qty;
		$manage->modifier = $modifier;
		$manage->save();


		$mss = Mssclassification::where('patients_id', '=', $request->patient_id)
					->where('validity', '>=', Carbon::parse($now)->format('Y-m-d'))
					->first();
		if ($mss) {
			if ($mss->mss_id >= 9 && $mss->mss_id <= 13 || $request->price <= 0) {
		 		$sale = new Sales();
				$sale->pharmanagerequest_id = $manage->id;
				$sale->users_id = Auth::user()->id;
				$sale->mss_id = $mss->mss_id;
				$sale->price = $request->price;
				$sale->or_no = $modifier;
				$sale->cash = '0';
				$sale->save();
			}
			else{
				$sale = null;
			}
		}else{
			$sale = null;
		}
	


		$stock = Pharstocks::where('items_id', '=', $request->item_id)->first();
		$stock->stock = $stock->stock - $request->mgmt_qty;
		$stock->save();  

 		$invetory = new Pharinventory();
	 	$invetory->users_id = Auth::user()->id;
	 	$invetory->item_id = $request->item_id;
	 	$invetory->qty = '-'.$request->mgmt_qty;
	 	$invetory->save();
		echo json_encode(['manage' =>  $manage, 'sale' => $sale]);
		return;
	}
	public function deleterequistion(Request $request)
	{
		$requisition = Requisition::find($request->reqid);
		$manage = Pharmanagerequest::where('requisition_id', '=', $request->reqid)->first();
		// $requisition->delete();	
			if ($manage) {
				$stock = Pharstocks::where('items_id', '=', $requisition->item_id)->first();
				$stock->stock = $stock->stock + $manage->qty;
				$stock->save();  

		 		$invetory = new Pharinventory();
			 	$invetory->users_id = Auth::user()->id;
			 	$invetory->item_id = $requisition->item_id;
			 	$invetory->qty = $manage->qty;
			 	$invetory->save();
			 	$sales = Sales::where('pharmanagerequest_id', '=', $manage->id)->first();
			 	if ($sales) {
			 		$sales->delete();
			 	}
			 		$manage->delete();
			 		echo json_encode(['requisition' => $requisition, 'manage' =>  $manage, 'sales' => $sales]);
		 	}
		 	else{
		 	echo json_encode(['requisition' => $requisition]);
		 	}

		return;
	}
	public function postcharge($display)
	{
		$dis = rtrim($display,',');
		$print = DB::select("SELECT d.brand, d.item_description, d.unitofmeasure, a.price, b.qty, c.item_id, c.patients_id
							FROM sales a 
							LEFT JOIN pharmanagerequest b ON a.pharmanagerequest_id = b.id
							LEFT JOIN requisition c ON b.requisition_id = c.id
							LEFT JOIN ancillary_items d ON c.item_id = d.id
							WHERE a.id IN(".$dis.")
							");
		
		 $pdf = new Postcharge();
		 $pdf->setPatientID($print[0]->patients_id);
		 $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
		 $pdf->SetMargins(5,55,5,5);
		 $pdf->SetHeaderMargin(5);
		 $pdf->SetFooterMargin(5);
		 $pdf->SetAutoPageBreak(TRUE, 15);
		 $pdf->SetTitle('POSTCHARGE SLIP');
		 $pdf->AddPage('P',array(105,148.5));
		 $pdf->SetFont('times','',8);

		 $table = \View::make('pharmacy.postcharge', compact('print'));

		$pdf->writeHTML($table, true, false, false, false, '');
		$pdf->IncludeJS("print();");
		$pdf->Output();

		return;
	}
	public function restoremeds(Request $request)
	{
		$meds = AncillaryItem::find($request->id);
		$meds->trash = 'N';
		$meds->save();
		echo json_encode($request->id);
		return;
	}
	public function getallpendingrequesition(Request $request)
	{
		if ($request->from != "" && $request->to != "") {
			$requesition = DB::select("SELECT a.id, b.brand, b.item_description, b.unitofmeasure,b.price, a.qty, c.last_name,c.middle_name,c.first_name, 
										CONCAT(d.last_name,', ',d.first_name,' ',LEFT(d.middle_name, 1),'.') as users,
										e.id as role_id
										FROM requisition a
										LEFT JOIN ancillary_items b ON a.item_id = b.id
										LEFT JOIN patients c ON a.patients_id = c.id
										LEFT JOIN users d ON a.users_id = d.id
										LEFT JOIN roles e ON d.role = e.id 
										WHERE a.id NOT IN(SELECT requisition_id FROM pharmanagerequest) 
										AND DATE(a.created_at) BETWEEN ? AND ?
								    ", [$request->from, $request->to]);
		}else{
			$requesition = DB::select("SELECT a.id, b.brand, b.item_description, b.unitofmeasure,b.price, a.qty, c.last_name,c.middle_name,c.first_name, 
										CONCAT(d.last_name,', ',d.first_name,' ',LEFT(d.middle_name, 1), '.') as users,
										e.id as role_id
										FROM requisition a
										LEFT JOIN ancillary_items b ON a.item_id = b.id
										LEFT JOIN patients c ON a.patients_id = c.id
										LEFT JOIN users d ON a.users_id = d.id
										LEFT JOIN roles e ON d.role = e.id 
										WHERE a.id NOT IN(SELECT requisition_id FROM pharmanagerequest) 
										AND DATE(a.created_at) = CURRENT_DATE()
								    ");
		}
	  	echo json_encode($requesition);
	  	return;
	}
	public function deletecheckpendingrequesition($id)
	{
		$requisition = Requisition::find($id)->delete();
		echo json_encode($requisition);
		return;
	}
	public function getallpendingmanaged(Request $request)
	{
		if ($request->from != "" && $request->to != "") {
			$managed = DB::select("SELECT a.id, 
											c.brand, 
									        c.item_description, 
									        c.unitofmeasure, 
									        c.price, 
									        a.qty, 
									        d.last_name, 
									        d.middle_name, 
											d.first_name, 
											CONCAT(e.last_name,', ',e.first_name,' ',LEFT(e.middle_name, 1),'.') as users
									FROM pharmanagerequest a
									LEFT JOIN requisition b ON a.requisition_id = b.id
									LEFT JOIN ancillary_items c ON b.item_id = c.id
									LEFT JOIN patients d ON b.patients_id = d.id
									LEFT JOIN users e ON a.users_id = e.id
									WHERE a.id NOT IN(SELECT pharmanagerequest_id FROM sales)
									AND DATE(a.created_at) BETWEEN ? AND ?
									ORDER BY a.id DESC
								    ", [$request->from, $request->to]);
		}else{
			$managed = DB::select("SELECT a.id, 
											c.brand, 
									        c.item_description, 
									        c.unitofmeasure, 
									        c.price, 
									        a.qty, 
									        d.last_name, 
									        d.middle_name, 
											d.first_name, 
											CONCAT(e.last_name,', ',e.first_name,' ',LEFT(e.middle_name, 1),'.') as users
									FROM pharmanagerequest a
									LEFT JOIN requisition b ON a.requisition_id = b.id
									LEFT JOIN ancillary_items c ON b.item_id = c.id
									LEFT JOIN patients d ON b.patients_id = d.id
									LEFT JOIN users e ON a.users_id = e.id
									WHERE a.id NOT IN(SELECT pharmanagerequest_id FROM sales)
									AND DATE(a.created_at) = CURRENT_DATE()
									ORDER BY a.id DESC
								    ");
		}
	  	echo json_encode($managed);
	  	return;
	}
	public function deletecheckpendingmanaged($id)
	{
		$managed = Pharmanagerequest::find($id);
		$requisition = Requisition::find($managed->requisition_id);
		
			$stock = Pharstocks::where('items_id', '=', $requisition->item_id)->first();
			$stock->stock = $stock->stock + $managed->qty;
			$stock->save();

	 		$invetory = new Pharinventory();
		 	$invetory->users_id = Auth::user()->id;
		 	$invetory->item_id = $requisition->item_id;
		 	$invetory->qty = $managed->qty;
		 	$invetory->save();

		$managed->delete();
		$requisition->delete();
		echo json_encode(['managed' => $managed, 'requisition' => $requisition]);
		return;
	}
	public function getallundonetransactions(Request $request)
	{
		if ($request->from != "" && $request->to != "") {
			$undone = DB::select("SELECT a.id, 
										f.id as mss_id,
										f.label, f.description, a.or_no, 
										d.brand, d.item_description, d.unitofmeasure,
								        (a.price * b.qty) as amount,
								        b.qty,
								        e.last_name, e.middle_name, e.first_name
								FROM sales a
								LEFT JOIN pharmanagerequest b ON a.pharmanagerequest_id = b.id
								LEFT JOIN requisition c ON b.requisition_id = c.id
								LEFT JOIN ancillary_items d ON c.item_id = d.id
								LEFT JOIN patients e ON c.patients_id = e.id
								LEFT JOIN mss f ON a.mss_id = f.id
								WHERE a.status = 'N'
								AND a.void = '0'
								AND DATE(a.created_at) BETWEEN ? AND ?
								ORDER BY a.id DESC
								", [$request->from, $request->to]);
		}else{
			$undone = DB::select("SELECT a.id, 
										f.id as mss_id,
										f.label, f.description, a.or_no, 
										d.brand, d.item_description, d.unitofmeasure,
								        (a.price * b.qty) as amount,
								        b.qty,
								        e.last_name, e.middle_name, e.first_name
								FROM sales a
								LEFT JOIN pharmanagerequest b ON a.pharmanagerequest_id = b.id
								LEFT JOIN requisition c ON b.requisition_id = c.id
								LEFT JOIN ancillary_items d ON c.item_id = d.id
								LEFT JOIN patients e ON c.patients_id = e.id
								LEFT JOIN mss f ON a.mss_id = f.id
								WHERE a.status = 'N'
								AND a.void = '0'
								AND DATE(a.created_at) = CURRENT_DATE()
								ORDER BY a.id DESC
								");
		}
		echo json_encode($undone);
		return;
	}
	public function donepaidrequisition($id)
	{
		$sales = Sales::find($id);
		$sales->status = 'Y';
		$sales->save();
		echo json_encode($id);
		return;
	}
}
