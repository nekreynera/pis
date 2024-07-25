<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\MedicalCertificate;
use App\Ancillaryrequist;
use Auth;

class MedicalCertificateController extends Controller
{
    public function store($pid, $id)
    {
        MedicalCertificate::create([
            'patient_id' => $pid,
            'user_id' => Auth::user()->id,
            'cashincomesubcategory_id' => $id
        ]);



        Ancillaryrequist::create([
            'patients_id' => $pid,
            'users_id' => Auth::user()->id,
            'cashincomesubcategory_id' => $id,
            'qty' => 1,
            'modifier' => Str::random(20)
        ]);



        return back()->with('toaster', array('success', 'Request for medical certificate successfully saved'));
    }


}