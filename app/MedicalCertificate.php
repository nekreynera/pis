<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Auth;
use DB;

class MedicalCertificate extends Model
{
    protected $table = "medical_certificates";

    protected $fillable = [
        'patient_id', 'user_id', 'cashincomesubcategory_id', 'status'
    ];


    public static function checkThis($pid)
    {
        $result = MedicalCertificate::where([
                        'patient_id' => $pid,
                        'user_id' => Auth::user()->id,
                    ])
                    ->where(DB::raw("DATE(created_at)"), Carbon::now()->toDateString())
                    ->count();
        return $result;
    }


}
