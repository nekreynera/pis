<?php

namespace App\Http\Controllers;

use App\Patient;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\Consultation;
use Illuminate\Support\Facades\Session;

class ChiefComplaintController extends Controller
{


    public function chief_complaint($pid)
    {
        $patient = Patient::find($pid);
        return view('receptions.chief_complaint', compact('patient'));
    }

    public function chief_complaint_ajax(Request $request)
    {
        $patient = Patient::find($request->id);
        return response()->json($patient);
    }

    public function saveChiefComplaint(Request $request)
    {

        Consultation::create([
            'patients_id' => $request->pid,
            'users_id' => Auth::user()->id,
            'clinic_code' => Auth::user()->clinic,
            'consultation' => $request->consultation
        ]);
        Session::flash('toaster', array('success', 'Consultation successfully saved'));
        return redirect('overview');
    }

    public function saveChiefComplaintAjax(Request $request)
    {
        if($request->runningModal == 1)
        {
            $id = Consultation::create([
                'patients_id' => $request->pid,
                'users_id' => Auth::user()->id,
                'clinic_code' => Auth::user()->clinic,
                'consultation' => $request->consultation
            ]);  
            return response()->json($id);
        }
        else
        {
            $doctorsConsultation = str_replace('id="doctors" class="mceNonEditable"', 'id="doctors" class="mceEditable"', $request->consultation);
            Consultation::find($request->pid)->update(['consultation'=>$doctorsConsultation]);
            return response()->json(0);
        }
    }

}
