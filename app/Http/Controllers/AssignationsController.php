<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Assignation;
use App\Queue;
use Validator;
use Carbon;
use Auth;
use Session;

class AssignationsController extends Controller
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


    public function assign($pid = false, $did = false)
    {   
        /*check if this patient is already assigned to the same doctor and status is not F, S, C*/
        $checkAssignation = Assignation::where('patients_id', '=', $pid)
                                        /*->where('doctors_id', '=', $did)*/
                                        ->where('clinic_code', '=', Auth::user()->clinic)
                                        ->whereDate('created_at', Carbon::now()->format('Y-m-d'))
                                        ->limit(1)->latest()->get();

        if (count($checkAssignation) <= 0) {
            $assign = new Assignation();
            $assign->patients_id = $pid;
            $assign->doctors_id = $did;
            $assign->users_id = Auth::user()->id;
            $assign->clinic_code = Auth::user()->clinic;
            $assign->save();
            Session::flash('toaster', array('success', 'Patient Succesfully Assigned'));
        }else{
            if ($checkAssignation[0]->status == 'C'){
                Assignation::where('id', '=', $checkAssignation[0]->id)
                    ->update(['doctors_id' => $did,'status' => 'P']);
                Session::flash('toaster', array('success', 'Patient Successfully Assigned'));
            }elseif ($checkAssignation[0]->status == 'F'){
                Assignation::where('id', '=', $checkAssignation[0]->id)
                    ->update(['doctors_id' => $did,'status' => 'P']);
                Session::flash('toaster', array('success', 'Patient Successfully Assigned'));
            } else{
                Session::flash('toaster', array('error', 'Patient Already Assigned'));
            }
        }
        return redirect()->back();
    }

    public function reassign($did = false, $id = false)
    {
        Assignation::where('id', '=', $id)
                    ->update(['doctors_id' => $did, 'status' => 'P']);

        Session::flash('toaster', array('success', 'Patient Succesfully Re-Assigned'));
        return redirect()->back();
    }


    public function cancelAssignation($id = false)
    {
        Assignation::where('id', '=', $id)
            ->update(['status' => 'C']);
        Session::flash('toaster', array('error', 'Patient Canceled!'));
        return redirect()->back();
    }

    public function cancelUnassigned($id = false)
    {
        Queue::where('patients_id', '=', $id)
                ->where('clinic_code', '=', Auth::user()->clinic)
                ->where('users_id', '=', Auth::user()->id)
                ->whereDate('created_at', Carbon::now()->format('Y-m-d'))
                ->limit(1)->latest()
                ->delete();

        Session::flash('toaster', array('error', 'Patient Canceled!'));
        return redirect('overview');
    }

    // Archie's new code
    public function cancelUnassignedPatient()
    {
        Queue::where('patients_id', '=', request('pid'))
                ->where('clinic_code', '=', Auth::user()->clinic)
                ->where('users_id', '=', Auth::user()->id)
                ->whereDate('created_at', Carbon::now()->format('Y-m-d'))
                ->limit(1)->latest()
                ->delete();

        return response()->json('success');
    }

    public function cancelAssignationPatient()
    {
        Assignation::where('id', '=', request('pid'))
            ->update(['status' => 'C']);
        Session::flash('toaster', array('error', 'Patient Canceled!'));
        return response()->json('success');
    }

    public function assignToDoctor()
    {
        $pid = request('pid');
        $did = request('did');
        $checkAssignation = Assignation::where('patients_id', '=', $pid)
                                        /*->where('doctors_id', '=', $did)*/
                                        ->where('clinic_code', '=', Auth::user()->clinic)
                                        ->whereDate('created_at', Carbon::now()->format('Y-m-d'))
                                        ->limit(1)->latest()->get();

        $id = 0;

        if (count($checkAssignation) <= 0) {
            $assign = new Assignation();
            $assign->patients_id = $pid;
            $assign->doctors_id = $did;
            $assign->users_id = Auth::user()->id;
            $assign->clinic_code = Auth::user()->clinic;
            $assign->save();

            $id = $assign->id;
        }else{
            if ($checkAssignation[0]->status == 'C'){
                $patient = Assignation::where('id', '=', $checkAssignation[0]->id);
                $id = $patient->update(['doctors_id' => $did,'status' => 'P']); 
            }elseif ($checkAssignation[0]->status == 'F'){
                $patient = Assignation::where('id', '=', $checkAssignation[0]->id);
                $id = $patient->update(['doctors_id' => $did,'status' => 'P']);
            } else{
                Session::flash('toaster', array('error', 'Patient Already Assigned'));
                $id = 0;
            }
        }
        return response()->json($id);
    }

    public function reassignToDoctor()
    {
        $aid = request('aid');
        $did = request('did');
        Assignation::where('id', '=', $aid)
                    ->update(['doctors_id' => $did, 'status' => 'P']);

        return response()->json('success');
    }









}
