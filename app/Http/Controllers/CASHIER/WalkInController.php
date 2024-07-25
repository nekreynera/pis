<?php

namespace App\Http\Controllers\CASHIER;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Patient;
use Auth;
use Validator;
use Response;
use Carbon\Carbon;


class WalkInController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $walkin_no = Patient::max('walkin');
        if ($walkin_no) {
            $walkin_no = $walkin_no + 1;
            $walkin_no =  str_pad($walkin_no, 6, '0', STR_PAD_LEFT);
        }else{
            $walkin_no = '000001';
        }
        $request->request->add(['walkin_no' => $walkin_no]);
        /*===================================================================*/
        

        /*===============BARCODE================*/        
        $random = rand(000001, 600000);
        $generated_num = (strlen($random) < 6)? str_pad($random, 6, '0', STR_PAD_LEFT) : $random ;
        $barcode = 'EVRMC'.date("mdY").$generated_num;
        $request->request->add(['barcode' => $barcode]);


        /*=============REQUEST=================*/

            $rules = array(
                    'last_name' => 'required',
                    'first_name' => 'required',
                    'birthday' => 'required|date|before_or_equal:'.Carbon::now()->format('Y-m-d').'',
                    'city_municipality' => 'required',
                    'sex' => 'required',
                    'hospital_no' => 'unique:patients',
                    );

            $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return Response::json(array(
                        'errors' => $validator->getMessageBag()->toArray()
                    ));
                }else{
                    try{
                        $patient = Patient::where('last_name', '=' , $request->last_name)
                                            ->where('first_name', '=', $request->first_name)
                                            ->where('birthday', '=', Carbon::parse($request->birthday)->format('Y-m-d'))
                                            ->first();
                        if (!$patient) {
                            $patient = Patient::create([
                                            'first_name' => strtoupper(str_replace('ñ', 'Ñ', $request->first_name)),
                                            'middle_name' => strtoupper(str_replace('ñ', 'Ñ', $request->middle_name)),
                                            'last_name' => strtoupper(str_replace('ñ', 'Ñ', $request->last_name)),
                                            'suffix' => $request->suffix,
                                            'sex' => $request->sex,
                                            'birthday' => Carbon::parse($request->birthday)->format('Y-m-d'),
                                            'civil_status' => $request->civil_status,
                                            'city_municipality' => $request->city_municipality,
                                            'brgy' => $request->brgy,
                                            'contact_no' => $request->contact_no,
                                            // 'hospital_no' => $request->hospital_no,
                                            'barcode' => $request->barcode,
                                            'users_id' => Auth::user()->id,
                                            'walkin' => $request->walkin_no
                                        ]);
                        }
                    }catch(QueryException $ex){
                        $patient = 'Synchronize Registration Not Allowed.';
                    }
                }
        echo json_encode($patient);
        return;
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
        //
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
}
