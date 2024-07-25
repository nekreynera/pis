<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Patient;
use App\Watcher;
use Validator;
use DB;
use Auth;
use Carbon;
use Session;

class WatchersController extends Controller
{

    public function index()
    {
        return view('patients.watcher');
    }

    public function show($id)
    {
        $patient = Patient::find($id);
        // dd($patient);
        return view('patients.watcher', compact('id', 'patient'));
    }
   
    
    public function getpatientwatcher($id)
    {
    	$data = DB::select("SELECT b.last_name, b.first_name, b.middle_name, b.suffix, b.birthday, b.sex, a.created_at, b.id, a.patient_id
							FROM watchers a 
							LEFT JOIN patients b ON a.watcher_id = b.id
                            WHERE a.patient_id = ?
                            ORDER BY a.created_at ASC
    						", [$id]);
    	echo json_encode($data);
    	return;
    }
    public function deletewatcher($pid, $wid)
    {
        $watcher = Watcher::where('patient_id', '=', $pid)
                            ->where('watcher_id', '=', $wid)
                            ->first()
                            ->delete();
        echo json_encode($watcher);
        return;

    }
    

}