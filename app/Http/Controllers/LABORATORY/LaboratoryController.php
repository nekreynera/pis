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

class LaboratoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sub = LaboratorySub::orderBy('id')->get();
        $laboratory = LaboratoryModel::orderBy('id')->get();
        $lablist = LaboratorySubList::orderBy('name', 'ASC')->get();
        return view('OPDMS.laboratory.pages.laboratory', compact('laboratory', 'sub', 'lablist'));
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
    public function getLaboratory()
    {
        echo json_encode(LaboratoryModel::orderBy('id')->get());
        return;
    }
}
