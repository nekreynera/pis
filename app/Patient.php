<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon;
use DB;

class Patient extends Model
{
	protected $table = "patients";

    protected $fillable = [
        'first_name', 
        'middle_name', 
        'last_name', 
        'suffix', 
        'sex', 
        'birthday', 
        'age', 
        'civil_status', 
        'address', 
        'city_municipality',
        'brgy', 
        'contact_no', 
        'hospital_no', 
        'barcode', 
        'printed', 
        'users_id', 
        'profile',
        'walkin'
    ];

    public static function age($birthday)
    {
        if ($birthday == null) {
            $age = null;
        }else{
            $now = Carbon::now()->toDateString();
            $birth = date_create($birthday);
            $today = date_create($now);
            $diff=date_diff($birth,$today);
            $age = $diff->format("%y");
            if ($age == 0){
                $age = $diff->format("%m month(s) old");
                if ($age == 0){
                    $age = $diff->format("%a day(s) old");
                }
            }
        }
        return $age;
    }

    public static function censusage($birthday)
    {
        $now = Carbon::now()->toDateString();
        $birth = date_create($birthday);
        $today = date_create($now);
        $diff=date_diff($birth,$today);
        $age = $diff->format("%y");
        return $age;
    }


    public static function address($id)
    {
        $patient = Patient::find($id);
        if ($patient->brgy){
            $address = DB::table('refbrgy')
                ->leftJoin('refcitymun', 'refbrgy.citymunCode', '=', 'refcitymun.citymunCode')
                ->leftJoin('refprovince', 'refcitymun.provCode', '=', 'refprovince.provCode')
                ->leftJoin('refregion', 'refprovince.regCode', '=', 'refregion.regCode')
                ->select('refbrgy.brgyDesc', 'refcitymun.citymunDesc', 'provDesc', 'refregion.regDesc')
                ->where('refbrgy.id', '=', $patient->brgy)
                ->get()->first();
        }elseif ($patient->city_municipality){
            $address = DB::table('refcitymun')
                ->leftJoin('refprovince', 'refcitymun.provCode', '=', 'refprovince.provCode')
                ->leftJoin('refregion', 'refprovince.regCode', '=', 'refregion.regCode')
                ->select('refcitymun.citymunDesc', 'provDesc', 'refregion.regDesc')
                ->where('refcitymun.citymunCode', '=', $patient->city_municipality)
                ->get()->first();
        }else{
            $address = false;
        }
        return $address;
    }
    static function Today()
    {
        return DB::select("SELECT a.id,
                                a.hospital_no,
                                a.last_name,
                                a.first_name,
                                a.middle_name,
                                a.civil_status,
                                b.brgyDesc, c.citymunDesc, d.provDesc,
                                a.birthday,
                                a.sex,
                                DATE(a.created_at) as regdate,
                                e.id as fordelete,
                                a.printed
                        FROM patients a 
                        LEFT JOIN refbrgy b ON a.brgy = b.id
                        LEFT JOIN refcitymun c ON a.city_municipality = c.citymunCode
                        LEFT JOIN refprovince d ON c.provCode = d.provCode
                        LEFT JOIN fordelete e ON a.id = e.patient_id
                        WHERE DATE(a.created_at) = ?
                        AND a.walkin IS NULL
                        ORDER BY a.id DESC
                        LIMIT 50
                        ", [Carbon::today()]);
    }
    static function Search($request)
    {
        return DB::select("SELECT a.id,
                                a.hospital_no,
                                a.last_name,
                                a.first_name,
                                a.middle_name,
                                a.civil_status,
                                b.brgyDesc, c.citymunDesc, d.provDesc,
                                a.birthday,
                                a.sex,
                                DATE(a.created_at) as regdate,
                                e.id as fordelete,
                                a.printed
                        FROM patients a 
                        LEFT JOIN refbrgy b ON a.brgy = b.id
                        LEFT JOIN refcitymun c ON a.city_municipality = c.citymunCode
                        LEFT JOIN refprovince d ON c.provCode = d.provCode
                        LEFT JOIN fordelete e ON a.id = e.patient_id
                        WHERE
                        (CASE 
                            WHEN ? != '' THEN a.last_name LIKE ?
                            WHEN ? THEN a.hospital_no LIKE ?
                            WHEN ? != '' THEN a.first_name LIKE ?
                            WHEN ? != '' THEN CONCAT(a.last_name,' ',a.first_name) LIKE ?
                            WHEN ? != '' THEN DATE(a.created_at) = ?
                            WHEN ? != '' THEN CONCAT(a.hospital_no,' ',a.last_name,' ',a.first_name,' ',a.middle_name) LIKE ?
                        END)
                        AND a.walkin IS NULL
                        ORDER BY a.id DESC"
                        ,[$request->lname, '%'.$request->lname.'%', 
                            $request->hospital_no, '%'.$request->hospital_no.'%', 
                            $request->fname, '%'.$request->fname.'%',
                            $request->completename, '%'.$request->completename.'%',
                            $request->datereg, $request->datereg,
                            $request->patient, '%'.$request->patient.'%']);   
    }
    static function deletePatient()
    {
        return DB::select("SELECT a.id,
                                a.hospital_no,
                                a.last_name,
                                a.first_name,
                                a.middle_name,
                                a.civil_status,
                                b.brgyDesc, c.citymunDesc, d.provDesc,
                                a.birthday,
                                a.sex,
                                DATE(a.created_at) as regdate,
                                e.id as fordelete,
                                a.printed
                        FROM patients a 
                        LEFT JOIN refbrgy b ON a.brgy = b.id
                        LEFT JOIN refcitymun c ON a.city_municipality = c.citymunCode
                        LEFT JOIN refprovince d ON c.provCode = d.provCode
                        LEFT JOIN fordelete e ON a.id = e.patient_id
                        WHERE a.id IN(SELECT patient_id
                                     FROM fordelete)
                        AND a.walkin IS NULL
                        ORDER BY a.id DESC"
                        );
    }
}
