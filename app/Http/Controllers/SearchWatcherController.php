<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\JsonableInterface;
use App\Patient;
use App\Watcher;
use Validator;
use DB;
use Auth;
use Carbon;
use Session;

class SearchWatcherController extends Controller
{

    /*public function searchwatch($search = false)
    {
        $search = 'labal';
        if ($search) {
            
            $watchers = DB::select("SELECT pt.hospital_no, CONCAT(pt.last_name,', ', pt.first_name,' ',pt.middle_name) wName, W.pName as pName, wt.created_at 
                                    FROM watchers wt 
                                    LEFT JOIN patients pt ON pt.id = wt.watcher_id
                                    LEFT JOIN (
                                        SELECT CONCAT(pt.last_name,', ', pt.first_name,' ',pt.middle_name) as pName, watchers.id as ww 
                                        FROM watchers 
                                        LEFT JOIN patients pt ON watchers.patient_id = pt.id
                                    ) as W ON W.ww = wt.id
                                    WHERE CONCAT(pt.last_name,' ',pt.first_name) LIKE '%$search%'
                                    OR pt.hospital_no = '$search'
                                    OR pt.barcode = '$search'
                                    OR DATE(wt.created_at) = '$search'
                                     ");
        }else{
            $watchers = 'noresult';
        }

        if (!empty($watchers)) {
            //return $watchers->toJson();
            echo json_encode(true);
            return;
        }else{
            echo json_encode(false);
            return;
        }

        return view('patients.searchWatcher', compact('watchers', 'search'));
    }
*/

    public function store(Request $request)
    {
        $search = $request->search;
        $watchers = DB::select("SELECT pt.hospital_no, CONCAT(pt.last_name,', ', pt.first_name,' ',pt.middle_name) wName, W.pName as pName, wt.created_at 
                                    FROM watchers wt 
                                    LEFT JOIN patients pt ON pt.id = wt.watcher_id
                                    LEFT JOIN (
                                        SELECT CONCAT(pt.last_name,', ', pt.first_name,' ',pt.middle_name) as pName, watchers.id as ww 
                                        FROM watchers 
                                        LEFT JOIN patients pt ON watchers.patient_id = pt.id
                                    ) as W ON W.ww = wt.id
                                    WHERE CONCAT(pt.last_name,' ',pt.first_name) LIKE '%$search%'
                                    OR pt.hospital_no = '$search'
                                    OR pt.barcode = '$search'
                                    OR DATE(wt.created_at) = '$search'
                                     ");

        if (!empty($watchers)) {
            echo json_encode($watchers);
            return;
        }else{
            echo json_encode(false);
            return;
        }

    }


    /*public function store(Request $request)
    {
        return redirect('searchwatch/'.$request->search);
    }*/
    

}