<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;

class Radiology extends Model
{
    protected $table = "radiology";

    protected $fillable = [
        'patient_id', 'user_id', 'ancillaryrequest_id', 'content', 'result', 'imageID', 'clinicalData', 'physician'
    ];




    public static function highestCases($date, $citymun = false, $provCode = false, $district = false, $region = false)
    {
        if ($region == '08'){
            $code = "AND refcitymun.provCode = $provCode AND refcitymun.district = $district";
        }else{
            $code = "AND refcitymun.regDesc != '08'";
        }

        $query = '';
        if ($provCode == '0837'){
            if ($citymun == '083747'){
                $query = "AND refcitymun.citymunCode = $citymun";
            }else{
                $query = "AND refcitymun.citymunCode != '083747'";
            }
        }

        /*$query = DB::select("SELECT MAX(description) as highest, cid, subcategory FROM (
                            SELECT COUNT(cs.id) as description, cs.id as cid, cs.sub_category as subcategory FROM ancillaryrequist an
                            LEFT JOIN cashincomesubcategory cs ON cs.id = an.cashincomesubcategory_id
                            LEFT JOIN cashincomecategory cc ON cc.id = cs.cashincomecategory_id
                            LEFT JOIN patients pt ON pt.id = an.patients_id
                            LEFT JOIN refcitymun ON refcitymun.citymunCode = pt.city_municipality
                            WHERE cc.clinic_id = ".Auth::user()->clinic."
                            AND DATE(an.created_at) LIKE '".$date."%'
                            ".$code."
                            AND pt.city_municipality IS NOT NULL
                            ".$query."
                            GROUP BY cs.id, MONTH(an.created_at)
                            ORDER BY an.patients_id
                        ) Result");*/


        $query = DB::select("SELECT COUNT(cs.id) as highest, cs.id as cid, cs.sub_category as subcategory FROM ancillaryrequist an
                            LEFT JOIN cashincomesubcategory cs ON cs.id = an.cashincomesubcategory_id
                            LEFT JOIN cashincomecategory cc ON cc.id = cs.cashincomecategory_id
                            LEFT JOIN patients pt ON pt.id = an.patients_id
                            LEFT JOIN refcitymun ON refcitymun.citymunCode = pt.city_municipality
                            WHERE cc.clinic_id = ".Auth::user()->clinic."
                            AND DATE(an.created_at) LIKE '".$date."%'
                            ".$code."
                            AND pt.city_municipality IS NOT NULL
                            ".$query."
                            GROUP BY cs.id, MONTH(an.created_at)
                            ORDER BY highest DESC
                            LIMIT 1");

        return $query;
    }




    public static function otherCases($date, $citymun = false, $cid, $provCode = false, $district = false, $region = false)
    {

        if ($region == '08'){
            $code = "AND refcitymun.provCode = $provCode AND refcitymun.district = $district";
        }else{
            $code = "AND refcitymun.regDesc != '08'";
        }
        $query = '';
        if ($provCode == '0837'){
            if ($citymun == '083747'){
                $query = "AND refcitymun.citymunCode = $citymun";
            }else{
                $query = "AND refcitymun.citymunCode != '083747'";
            }
        }

        $query = DB::select("SELECT SUM(description) as others FROM (
                            SELECT COUNT(cs.id) as description, cs.id as cid FROM ancillaryrequist an
                            LEFT JOIN cashincomesubcategory cs ON cs.id = an.cashincomesubcategory_id
                            LEFT JOIN cashincomecategory cc ON cc.id = cs.cashincomecategory_id
                            LEFT JOIN patients pt ON pt.id = an.patients_id
                            LEFT JOIN refcitymun ON refcitymun.citymunCode = pt.city_municipality
                            WHERE cc.clinic_id = ".Auth::user()->clinic."
                            AND DATE(an.created_at) LIKE '".$date."%'
                            ".$code."
                            AND pt.city_municipality IS NOT NULL
                            AND cs.id != ".$cid."
                            ".$query."
                            GROUP BY cs.id, MONTH(an.created_at)
                            ORDER BY an.patients_id
                            ) OTHERS");

        //dd($query);
        return $query;

    }




    public static function weeklyReport($start, $ending)
    {
        $result = DB::select("SELECT COUNT(*) total
                                FROM ancillaryrequist an
                                LEFT JOIN cashincomesubcategory cs ON cs.id = an.cashincomesubcategory_id
                                LEFT JOIN cashincomecategory cc ON cc.id = cs.cashincomecategory_id
                                WHERE cc.clinic_id = ".Auth::user()->clinic."
                                AND DATE(an.created_at) BETWEEN '".$start."' AND '".$ending."' ");
        return $result;
    }


    public static function withResult($start, $ending)
    {
        $result = DB::select("SELECT COUNT(*) total
                            FROM ancillaryrequist an
                            LEFT JOIN cashincomesubcategory cs ON cs.id = an.cashincomesubcategory_id
                            LEFT JOIN cashincomecategory cc ON cc.id = cs.cashincomecategory_id
                            LEFT JOIN radiology ON radiology.ancillaryrequest_id = an.id
                            WHERE cc.clinic_id = ".Auth::user()->clinic."
                            AND DATE(an.created_at) BETWEEN '".$start."' AND '".$ending."'
                            AND radiology.id IS NOT NULL");
        return $result;
    }










}
