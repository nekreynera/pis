<?php

namespace App\Http\Controllers\OPDMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Patient;
use App\Mssclassification;
use App\Queue;
use App\OPDMS\MSSExemptedClinic;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class QRCodeController extends Controller
{

    public function qrcode(Request $request)
    {
        /* check if field is not empty */
        $validator = Validator::make($request->all(), [
            'qrcode' => 'required'
        ]);
        if($validator->passes()){
            /*check if patient is already registered*/
            $patient = Patient::where('barcode', $request->qrcode)
                        ->orWhere('hospital_no', $request->qrcode)
                        ->first();
            if ($patient){
                /*check if patient is mss classified*/
                $checkIfClassified = Mssclassification::where('patients_id', '=', $patient->id)->first();

                $mss_exemption = MSSExemptedClinic::pluck('clinic_id')->all(); // check if clinic is mss exempted

                if ($checkIfClassified || in_array(Auth::user()->clinic, $mss_exemption)){

                    // check if mss classification has expired or clinic is mss exempted
                    $proceed = ($checkIfClassified->validity >= Carbon::now()->toDateString()
                        || in_array(Auth::user()->clinic, $mss_exemption))? true : false;
                    if ($proceed){
                        /*check if patient is already on the queue and is on the same clinic*/
                        $checkQueueList = Queue::where('patients_id', '=', $patient->id)
                                            ->where('clinic_code', '=', Auth::user()->clinic)
                                            ->whereDate('created_at', Carbon::now()->format('Y-m-d'))
                                            ->count();
                        if ($checkQueueList <= 0) {
                            // insert patient to the queue
                            Queue::create([
                                'patients_id' => $patient->id,
                                'users_id' => Auth::user()->id,
                                'clinic_code' => Auth::user()->clinic
                            ]);
                            Session::flash('toastr', array('success', 'Patient is now on the queue list'));
                            return redirect()->back();
                        }else{
                            Session::flash('toastr', array('error', 'Patient is already on the queue list.'));
                            return redirect()->back();
                        }
                    }else{
                        Session::flash('toastr', array('error', 'MSS Classification already expired.'));
                        return redirect()->back();
                    }
                }else{
                    Session::flash('toastr', array('error', 'Patient is not yet MSS classified and will not be included in the queue list. Kindly advise the patient to proceed to MSS for classification.'));
                    return redirect()->back();
                }
            }else{
                Session::flash('toastr', array('error', 'Credentials Not Found'));
                return redirect()->back();
            }
        }else{
            return redirect()->back()->with('toastr', array('error', 'QR Code or Hospital number required'));
        }
    }


}
