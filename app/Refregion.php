<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Refregion extends Model
{
	protected $table = "refregion";

    protected $fillable = [
        'psgcCode', 'regDesc', 'regCode',
    ];

    public static function getAddress($pid)
    {
        $patient = Patient::find($pid);
        if ($patient->brgy){
            $address = DB::table('refbrgy')
                ->leftJoin('refcitymun', 'refbrgy.citymunCode', '=', 'refcitymun.citymunCode')
                ->leftJoin('refprovince', 'refcitymun.provCode', '=', 'refprovince.provCode')
                ->leftJoin('refregion', 'refprovince.regCode', '=', 'refregion.regCode')
                ->select('refbrgy.brgyDesc', 'refcitymun.citymunDesc', 'provDesc', 'refregion.regDesc')
                ->where('refbrgy.id', '=', $patient->brgy)
                ->first();
        }elseif ($patient->city_municipality){
            $address = DB::table('refcitymun')
                ->leftJoin('refprovince', 'refcitymun.provCode', '=', 'refprovince.provCode')
                ->leftJoin('refregion', 'refprovince.regCode', '=', 'refregion.regCode')
                ->select('refcitymun.citymunDesc', 'provDesc', 'refregion.regDesc')
                ->where('refcitymun.citymunCode', '=', $patient->city_municipality)
                ->first();
        }else{
					$address = null;
				}
        return $address;
    }

}
