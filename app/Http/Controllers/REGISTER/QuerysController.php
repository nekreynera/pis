<?php

namespace App\Http\Controllers\REGISTER;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Http\Controllers\Controller;
use App\Patient;
use App\User;
use App\Clinic;
use App\ForDelete;
use App\AdoptedhostpitalNumbers;
use App\Regdeletepatients;
use Response;
use Validator;
use Carbon\Carbon;
use DB;
use Auth;

class QuerysController extends Controller
{
   	public function Search(Request $request)
    {
        if ($request->option == '1') {
            $rules = array(
                'l_name' => 'required',
                'f_name' => 'required',
            );
                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return Response::json(array(
                        'errors' => $validator->getMessageBag()->toArray()
                    ));
                }else{
                    $data = Patient::where('last_name', 'like', '%'.$request->l_name.'%')
                                ->where('first_name', 'like', '%'.$request->f_name.'%')
                                ->limit(200)
                                ->get();
                }
        }else{
            $rules = array(
                'id_no' => 'numeric|digits:6',
            );
                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return Response::json(array(
                        'errors' => $validator->getMessageBag()->toArray()
                    ));
                }else{
                    $data = Patient::where('hospital_no', 'like', '%'.$request->id_no.'%')->get();
                }
        }
        echo json_encode($data);
        return;
    }
    public function clinics()
    {
   	 	echo json_encode(Clinic::all());
   	 	return;
    }
    public function today()
    {
        echo json_encode(Patient::Today());
        return;
    }

    public function reserve(Request $request)
    {
        $data = null;
        try{
            $data = AdoptedhostpitalNumbers::create(['hospital_no' => $request->hospital_no]);
        }catch(QueryException $ex){}
        echo json_encode($data);
        return;
    }
    public function print($count)
    {
        echo json_encode(DB::table('patients')->orderByDesc('id')->limit($count)->get());
        return;
    }
    public function searchprint(Request $request)
    {
        echo json_encode(Patient::where(DB::raw("CONCAT(last_name,' ',first_name,' ',middle_name)"), 'like', '%'.$request->patient.'%')
                                        ->orWhere('hospital_no', 'like', '%'.$request->patient.'%')
                                        ->limit(200)
                                        ->get());
        return;
    }
    public function patient($id)
    {
        $patient = Patient::find($id);
        $user = Auth::user();
        echo json_encode(['patient' => $patient, 'user' => $user]);
        return;
    }
    public function cancel($id)
    {
        echo json_encode(ForDelete::where('patient_id', '=', $id)->first()->delete());
        return;
    }
    public function information($id)
    {
        echo json_encode(DB::table('patients')
                        ->leftJoin('mssclassification', function($join)
                        {
                            $join->on('mssclassification.patients_id', 'patients.id')
                                ->on('mssclassification.validity', '>=', DB::raw('CURDATE()'));
                        })
                        ->leftJoin('mss', 'mss.id', '=', 'mssclassification.mss_id')
                        ->where('patients.id', '=', $id)
                        ->first());
        return;                      
    }

    public function register_report(Request $request)
    {
        $data = [];
        if ($request->generate) {
            foreach ($request->arr_from as $key => $value) {
                if ($request->arr_from[$key]) {
                     $request->request->add(['from' => $request->arr_from[$key]]);
                }
                if ($request->arr_to[$key]) {
                     $request->request->add(['to' => $request->arr_to[$key]]);
                }
            }
            
                $validator = Validator::make($request->all(), [
                    'generate' => 'required',
                    'user' => 'required',
                    'from' => 'required|date|before_or_equal:'.Carbon::now()->format('m/d/Y').'|before_or_equal:to',
                    'to' => 'required|date|before_or_equal:'.Carbon::now()->format('m/d/Y').'|after_or_equal:from',
                ]);

            if ($validator->passes()) { 
                $data = DB::select("SELECT DATE(a.created_at) as date, COUNT(*) as result 
                                    FROM $request->report
                                    LEFT JOIN users b ON a.users_id = b.id
                                    WHERE DATE(a.created_at) BETWEEN ? AND ?
                                    AND a.users_id =
                                       (CASE 
                                            WHEN '$request->user' = 'All' 
                                            THEN a.users_id
                                            ELSE ?
                                        END)
                                    GROUP BY $request->generate(a.created_at)
                                ", [Carbon::parse($request->from)->format('Y-m-d'), 
                                    Carbon::parse($request->to)->format('Y-m-d'), 
                                    $request->user]);
                
            }else{
                return redirect()->back()->withInput()->withErrors($validator);  
            }
        }
        
        return view('OPDMS.patients.pages.report', compact('data', 'request'));
    }
    public function getpatienttransaction($id)
    {
        $paid = DB::select("SELECT h.price,
                                    h.or_no,
                                    j.last_name, j.first_name, j.middle_name,
                                    DATE(h.created_at) as created_at
                            FROM cashidsale h
                            LEFT JOIN users j ON h.users_id = j.id
                            WHERE h.patients_id = ?
                            AND h.void = 0
                            UNION 
                            SELECT a.price,
                                    a.or_no,
                                    b.last_name, b.first_name, b.middle_name,
                                    DATE(a.created_at) as created_at
                            FROM cashincome a 
                            LEFT JOIN users b ON a.users_id = b.id
                            WHERE a.patients_id = ?
                            AND a.void = '0'
                            AND a.category_id = 312
                            ORDER BY created_at DESC
                            ", [$id, $id]);
        $printed = DB::select("SELECT b.last_name,
                                    b.first_name,
                                    b.middle_name,
                            a.created_at 
                            FROM printed a 
                            LEFT JOIN users b ON a.users_id = b.id
                            WHERE a.patient_id = ?
                        ", [$id]);
        echo json_encode(['paid' => $paid, 'printed' => $printed]);
        return;
    }

    public function delete($id)
    {
        $patient = Patient::find($id);
        $save = new Regdeletepatients();
        $save->id = $patient->id;
        $save->users_id = Auth::user()->id;
        $save->first_name = $patient->first_name;
        $save->middle_name = $patient->middle_name;
        $save->last_name = $patient->last_name;
        $save->suffix = $patient->suffix;
        $save->sex = $patient->sex;
        $save->birthday = $patient->birthday;
        $save->age = $patient->age;
        $save->civil_status = $patient->civil_status;
        $save->address = $patient->address;
        $save->city_municipality = $patient->city_municipality;
        $save->brgy = $patient->brgy;
        $save->contact_no = $patient->contact_no;
        $save->hospital_no = $patient->hospital_no;
        $save->barcode = $patient->barcode;
        $save->printed = $patient->printed;
        $save->save();
        $patient->delete();
        echo json_encode($save);
        return;
    }
}
