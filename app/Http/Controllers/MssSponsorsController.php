<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Mss;
use App\LaboratoryRequest;
use App\Ancillaryrequist;
use App\LaboratoryPayment;
use App\Cashincome;
use App\PaymentGuarantor;
use Auth;
use DB;

class MssSponsorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
    }
    public function patient_sponsors()
    {
        $data = Mss::where('type', '=', 1)->orderBy('id', 'ASC')->get();
        return view('mss.sponsors', compact('data'));
    }
    public function patient_discounts()
    {
        $data = Mss::where('type', '=', 0)->orderBy('id', 'ASC')->get();
        return view('mss.sponsors', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $data = new Mss();
        $data->label = $request->labels;
        $data->description = $request->description;
        $data->discount = $request->discount;
        $data->type = $request->type;
        $data->status = $request->status;
        $data->save();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        echo json_encode(Mss::find($id));
        return;
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
        //
        $data = Mss::find($id);
        $data->label = $request->labels;
        $data->description = $request->description;
        $data->status = $request->status;
        $data->save();
        // echo json_encode($data);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function updatependingpaymentdiscounts(Request $request)
    {
        $user_id = Auth::user()->id;
        $modifier = Str::random(20);





        foreach ($request->request_type as $index => $value) {
            if ($request->request_type[$index] == "laboratory") {
                $data = LaboratoryPayment::where('laboratory_request_id', '=', $request->request_id_for_payment[$index])->first();
                if (!$data) {
                    $data = new LaboratoryPayment();
                }
                $data->user_id = $user_id;
                $data->laboratory_request_id = $request->request_id_for_payment[$index];
                $data->mss_id = $request->mss_classification[$index];
                $data->price = $request->request_price[$index];
                $data->discount = $request->request_discount[$index];
                $data->or_no = $modifier;
                $granted_amount = 0;
                foreach ($request->guarantor as $i => $v) {
                    if ($request->request_id_for_payment[$index] == $request->request_id_for_guarantor[$i]) {
                        $granted_amount+=$request->granted_amount[$i];
                    }
                }

                $data->mss_charge = (($request->request_price[$index] * $request->request_qty[$index]) <= ($request->request_discount[$index] + $granted_amount))?
                                    2:1;
                $data->void = 0;
                $data->cash = null;
                $data->dbnp = null;
                $data->save();
            }elseif ($request->request_type[$index] == "ancillary") {
                $data = Cashincome::where('ancillaryrequist_id', '=', $request->request_id_for_payment[$index])->first();
                if (!$data) {
                    $data = new Cashincome();
                }
                $data->users_id = $user_id;
                $data->ancillaryrequist_id = $request->request_id_for_payment[$index];
                $data->patients_id = $request->patient_id;
                $data->mss_id = $request->mss_classification[$index];
                $data->category_id = $request->item_id[$index];
                $data->price = $request->request_price[$index];
                $data->qty = $request->request_qty[$index];
                $data->or_no = $modifier;
                $data->void = '0';
                $data->cash = 0;
                $data->discount = $request->request_discount[$index];
                $data->get = 'N'; 
                $granted_amount = 0;
                foreach ($request->guarantor as $i => $v) {
                    if ($request->request_id_for_payment[$index] == $request->request_id_for_guarantor[$i]) {
                        $granted_amount+=$request->granted_amount[$i];
                    }
                }
                $data->mss_charge = (($request->request_price[$index] * $request->request_qty[$index]) <= ($request->request_discount[$index] + $granted_amount))?
                                    2:1;
                $data->save();
            }
            foreach ($request->guarantor as $i => $v) {
                if ($request->request_id_for_payment[$index] == $request->request_id_for_guarantor[$i]) {
                    $PaymentGuarantor = PaymentGuarantor::find($request->payment_guarantor_id[$i]);

                    if ($request->guarantor[$i] != 'null' && $request->granted_amount[$i] != 'null') {
                        if (!$PaymentGuarantor) {
                            $PaymentGuarantor = new PaymentGuarantor();
                        }
                        $PaymentGuarantor->user_id = $user_id;
                        $PaymentGuarantor->type = ($request->request_type[$index] == 'laboratory')?1:0;
                        $PaymentGuarantor->payment_id = $data->id;
                        $PaymentGuarantor->guarantor_id = $request->guarantor[$i];
                        $PaymentGuarantor->granted_amount = $request->granted_amount[$i];
                        $PaymentGuarantor->save();
                    }else{
                        if ($PaymentGuarantor) {
                            $PaymentGuarantor->delete();
                        }
                    }
                }
            }
            
        }
        echo json_encode('success');
        return;
    }

    public function guarantormonitoring(Request $request)
    {
        if ($request->summaray_for == '1') {
            $data = PaymentGuarantor::availedpatient($request);
        }
       
        echo json_encode($data);
        return;
    }

    public function deletepaymentguarantor($id)
    {
        $data = PaymentGuarantor::find($id)->delete();
        echo json_encode($data);
        return;
        # code...
    }
}
