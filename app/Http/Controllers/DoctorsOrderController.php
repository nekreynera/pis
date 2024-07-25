<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Patient;
use App\DoctorsOrder;



class DoctorsOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('patients', ['only' => ['index']]);
    }

    public function index()
    {
        $patient = Patient::find(Session::get('pid'));
        return view('doctors.doctors_order', compact('patient'));
    }

    public function store(Request $request)
    {
        $doctors_order = new DoctorsOrder();
        $doctors_order->patients_id = $request->session()->get('pid');
        $doctors_order->users_id = Auth::user()->id;
        $doctors_order->reason = $request->reason;
        $doctors_order->disposition = $request->disposition;
        $doctors_order->save();
        return redirect()->back()->with('toaster', array('success', 'Doctors Order Succesfully Saved.'));
    }

}
