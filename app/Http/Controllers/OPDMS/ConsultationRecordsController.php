<?php

namespace App\Http\Controllers\OPDMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Support\Jsonable;
use App\Consultation;

class ConsultationRecordsController extends Controller
{

    public function get_all_consultation_records(Request $request) // get all consultation records of this patient for showing on the modal
    {
        $consultations = DB::table('consultations')
                ->where('consultations.patients_id', $request->pid)
                ->leftJoin('users', 'users.id', 'consultations.users_id')
                ->leftJoin('clinics', 'clinics.id', 'consultations.clinic_code')
                ->select('consultations.id as cid', 'consultations.created_at',
                    'clinics.name', 'users.last_name', 'users.first_name', 'users.middle_name', 'users.role')
                ->orderBy('consultations.created_at', 'desc')
                ->get();
        return $consultations->toJson();
    }


    public function show_consultation(Request $request)
    {
        $consultation = Consultation::where('consultations.id', $request->id)
                            ->leftJoin('users', 'users.id', 'consultations.users_id')
                            ->leftJoin('clinics', 'clinics.id', 'consultations.clinic_code')
                            ->select('consultations.id as cid', 'consultations.consultation', 'consultations.created_at',
                                'consultations.users_id as users_id',
                                'clinics.name', 'users.last_name', 'users.first_name', 'users.middle_name', 'users.role')
                            ->orderBy('consultations.created_at', 'desc')
                            ->first();
        return $consultation->toJson();
    }

}
