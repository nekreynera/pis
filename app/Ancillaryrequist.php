<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;

class Ancillaryrequist extends Model
{
    protected $table = "ancillaryrequist";

    protected $fillable = [
        'users_id', 'clinic_id','patients_id', 'cashincomesubcategory_id', 'qty', 'modifier'
    ];

    public static function storeLabs($request ,$modifier, $i)
    {
        $labs = new Ancillaryrequist();
        $labs->users_id = Auth::user()->id;
        $labs->patients_id = $request->session()->get('pid');
        $labs->cashincomesubcategory_id = $request->input('item.'.$i);
        $labs->qty = $request->input('qty.'.$i);
        $labs->modifier = $modifier;
        $labs->save();
        return $labs;
    }


    public static function charging($pid)
    {
        $clinic = Cashincomecategory::where('clinic_id', Auth::user()->clinic)->pluck('id')->first();

        /*$charging = DB::select("SELECT DISTINCT(SELECT COUNT(*) AS request FROM ancillaryrequist an
                    LEFT JOIN cashincome ci ON ci.ancillaryrequist_id = an.id
                    LEFT JOIN radiology ON radiology.ancillaryrequest_id = an.id
                    LEFT JOIN cashincomesubcategory cs ON cs.id = an.cashincomesubcategory_id
                    LEFT JOIN cashincomecategory cc ON cc.id = cs.cashincomecategory_id
                    WHERE an.patients_id = $pid AND radiology.id IS NULL AND cc.clinic_id = ".Auth::user()->clinic.") as managed,
                    (SELECT COUNT(*) AS paid FROM cashincome ci
                	LEFT JOIN ancillaryrequist an  ON ci.ancillaryrequist_id = an.id
                	LEFT JOIN radiology ON radiology.ancillaryrequest_id = ci.ancillaryrequist_id
                    LEFT JOIN cashincomesubcategory cs ON cs.id = an.cashincomesubcategory_id
                    LEFT JOIN cashincomecategory cc ON cc.id = cs.cashincomecategory_id
                    WHERE an.patients_id = $pid AND cc.clinic_id = ".Auth::user()->clinic." AND radiology.id IS NULL) as paid,
                    (SELECT COUNT(*) AS request FROM ancillaryrequist an 
                    LEFT JOIN cashincome ci ON ci.ancillaryrequist_id = an.id
                    LEFT JOIN radiology ON radiology.ancillaryrequest_id = an.id
                    LEFT JOIN cashincomesubcategory cs ON cs.id = an.cashincomesubcategory_id
                    LEFT JOIN cashincomecategory cc ON cc.id = cs.cashincomecategory_id
                    WHERE an.patients_id = $pid AND radiology.id IS NULL AND cc.clinic_id = ".Auth::user()->clinic.") as request
                    FROM ancillaryrequist an
                    WHERE an.patients_id = $pid");*/


        $charging = DB::select("SELECT DISTINCT
                    (SELECT COUNT(*) AS paid FROM cashincome ci
                	LEFT JOIN ancillaryrequist an  ON ci.ancillaryrequist_id = an.id
                	LEFT JOIN radiology ON radiology.ancillaryrequest_id = ci.ancillaryrequist_id
                    LEFT JOIN cashincomesubcategory cs ON cs.id = an.cashincomesubcategory_id
                    LEFT JOIN cashincomecategory cc ON cc.id = cs.cashincomecategory_id
                    WHERE an.patients_id = $pid AND cc.clinic_id = ".Auth::user()->clinic." AND radiology.id IS NULL AND ci.void = '0') as paid,
                    (SELECT COUNT(*) AS request FROM ancillaryrequist an 
                    LEFT JOIN cashincome ci ON ci.ancillaryrequist_id = an.id
                    LEFT JOIN radiology ON radiology.ancillaryrequest_id = an.id
                    LEFT JOIN cashincomesubcategory cs ON cs.id = an.cashincomesubcategory_id
                    LEFT JOIN cashincomecategory cc ON cc.id = cs.cashincomecategory_id
                    WHERE an.patients_id = $pid AND radiology.id IS NULL AND cc.clinic_id = ".Auth::user()->clinic.") as request
                    FROM ancillaryrequist an
                    WHERE an.patients_id = $pid");

        return $charging;
    }





    public static function otherCharging($pid)
    {
        // $charging = DB::select("SELECT DISTINCT(SELECT COUNT(*) AS paid 
        //             FROM ancillaryrequist an 
        //             LEFT JOIN cashincome ci ON ci.ancillaryrequist_id = an.id AND ci.get = 'N'
        //             LEFT JOIN cashincomesubcategory cs ON cs.id = an.cashincomesubcategory_id
        //             LEFT JOIN cashincomecategory cc ON cc.id = cs.cashincomecategory_id
        //             WHERE an.patients_id = $pid AND cc.clinic_id = ".Auth::user()->clinic." AND ci.id IS NOT NULL AND ci.void = '0') as paid,
        //             (SELECT COUNT(*) AS request FROM ancillaryrequist an 
        //             LEFT JOIN cashincomesubcategory cs ON cs.id = an.cashincomesubcategory_id
        //             LEFT JOIN cashincomecategory ci ON ci.id = cs.cashincomecategory_id
        //             LEFT JOIN cashincome ON cashincome.ancillaryrequist_id = an.id
        //              WHERE an.patients_id = $pid AND ci.clinic_id = ".Auth::user()->clinic."
        //             AND (CASE WHEN cashincome.id IS NOT NULL THEN cashincome.get = 'N' AND cashincome.void = '0' ELSE an.id = an.id END)) as request
        //             FROM ancillaryrequist an
        //             WHERE an.patients_id = $pid");
        $charging = DB::select("SELECT COUNT(a.id) as request, COUNT(b.id) as paid
                                FROM ancillaryrequist a
                                LEFT JOIN cashincome b ON a.id = b.ancillaryrequist_id AND b.void = '0'
                                LEFT JOIN cashincomesubcategory c ON a.cashincomesubcategory_id = c.id
                                LEFT JOIN cashincomecategory d ON c.cashincomecategory_id = d.id
                                WHERE a.patients_id = ?
                                AND d.clinic_id = ?
                                AND (CASE WHEN b.id THEN b.get = 'N' ELSE a.id = a.id END) 
                                ORDER BY a.id DESC
                                ", [$pid, Auth::user()->clinic]);
        return $charging;
    }



    /*public static function ecgCharging($pid)
    {
        $charging = DB::select("SELECT DISTINCT(SELECT COUNT(*) AS paid 
                    FROM cashincome ci
                    LEFT JOIN ancillaryrequist an ON ci.ancillaryrequist_id = an.id 
                    LEFT JOIN cashincomesubcategory cs ON cs.id = an.cashincomesubcategory_id
                    LEFT JOIN cashincomecategory cc ON cc.id = cs.cashincomecategory_id
                    WHERE an.patients_id = $pid AND cc.clinic_id = ".Auth::user()->clinic.") as paid,
                    (SELECT COUNT(*) AS request FROM ancillaryrequist an 
                    LEFT JOIN cashincomesubcategory cs ON cs.id = an.cashincomesubcategory_id
                    LEFT JOIN cashincomecategory ci ON ci.id = cs.cashincomecategory_id
                     WHERE an.patients_id = $pid AND ci.clinic_id = ".Auth::user()->clinic.") as request
                    FROM ancillaryrequist an
                    WHERE an.patients_id = $pid");
        return $charging;
    }*/


    public static function topLeading($id, $date)
    {
        $query = DB::select("SELECT COUNT(cs.id) as total
                            FROM ancillaryrequist an
                            LEFT JOIN cashincomesubcategory cs ON cs.id = an.cashincomesubcategory_id
                            LEFT JOIN cashincomecategory cc ON cc.id = cs.cashincomecategory_id
                            WHERE cc.clinic_id = ".Auth::user()->clinic."
                            AND DATE(an.created_at) LIKE '".$date."%'
                            AND cs.id = ".$id." ");

        return $query[0]->total;


    }
    static function getpatientrequest($patient_id)
    {
        $data = DB::select("SELECT a.id, b.sub_category, c.id as salesid
                            FROM ancillaryrequist a 
                            LEFT JOIN cashincomesubcategory b ON a.cashincomesubcategory_id = b.id
                            LEFT JOIN cashincome c ON a.id = c.ancillaryrequist_id
                            WHERE a.patients_id = ?
                            AND a.cashincomesubcategory_id IN(187,188)
                            ORDER BY a.id DESC
                            ", [$patient_id]);
        return $data;


    }





}
