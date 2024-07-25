<?php

namespace App\Http\Controllers\LABORATORY;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\LaboratoryModel;
use App\LaboratorySub;
use App\LaboratorySubList;
use Auth;
use Validator;
use Response;

class LaboratorysubController extends Controller
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
        $rules = array(
                'laboratory_id' => 'required',
                'name' => 'required|unique:laboratory_sub',
                );

        $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return Response::json(array(
                    'errors' => $validator->getMessageBag()->toArray()
                ));
            }else{
                LaboratorySub::create($request->all());
                $sub = LaboratorySub::orderBy('id')->get();
                $laboratory = LaboratoryModel::orderBy('id')->get();
                $request = ['sub' => $sub, 'laboratory' => $laboratory];
            }
        echo json_encode($request);
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
        echo json_encode(LaboratorySub::where('laboratory_id', $id)->orderBy('id')->get());
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
        echo json_encode(LaboratorySub::find($id));
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
        $rules = array(
                'laboratory_id' => 'required',
                'name' => 'required',
                );

        $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return Response::json(array(
                    'errors' => $validator->getMessageBag()->toArray()
                ));
            }else{
                $subs = LaboratorySub::find($id);
                $subs->fill($request->all());
                $subs->save();

                $sub = LaboratorySub::orderBy('id')->get();
                $laboratory = LaboratoryModel::orderBy('id')->get();
                $request = ['sub' => $sub, 'laboratory' => $laboratory];
            }
        echo json_encode($request);
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
        //
    }

    /**
     * get the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function getLaboratorySub($id)
    // {
        
    // }
}
