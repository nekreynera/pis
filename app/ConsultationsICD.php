<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use DB;

class ConsultationsICD extends Model
{
    protected $table = "consultations_icd";

    protected $fillable = [
        'patients_id', 'users_id', 'consultations_id', 'icd'
    ];

    public static function getICD($starting, $ending, $cicd, $code){
        $uid = Auth::user()->id;
        $censusICD = DB::select("SELECT cicd.icd, cicd.users_id, icd_codes.description, pt.id, pt.birthday, pt.sex FROM consultations_icd cicd
                                            LEFT JOIN icd_codes ON icd_codes.id = cicd.icd
                                            LEFT JOIN consultations cons ON cons.id = cicd.consultations_id
                                            LEFT JOIN patients pt ON pt.id = cicd.patients_id
                                            LEFT JOIN users ON users.id = cicd.users_id
                                            WHERE DATE(cicd.created_at) BETWEEN '".$starting."' AND '".$ending."'
                                            AND LEFT(icd_codes.code, 3) = '".$code."'
                                            AND cons.clinic_code = ".Auth::user()->clinic." AND pt.id IS NOT NULL");
        //dd($censusICD);
        return $censusICD;
    }
}
