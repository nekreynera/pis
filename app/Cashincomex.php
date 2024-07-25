<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Cashincome extends Model
{
	protected $table = "cashincome";

    protected $fillable = [
        'users_id', 'ancillaryrequist_id', 'patients_id', 'mss_id', 'category_id', 'price', 'qty', 'or_no', 'void', 'cash', 'discount','get'
    ];

    public static function storeIncome($request ,$modifier, $i, $labs, $mssClassification)
    {
        $pricing = Cashincomesubcategory::find($request->input('item.'.$i));
        $discount = $pricing->price * $request->input('qty.'.$i);
        $cashincome = new Cashincome();
        $cashincome->ancillaryrequist_id = $labs->id;
        $cashincome->users_id = Auth::user()->id;
        $cashincome->patients_id = $request->session()->get('pid');
        $cashincome->mss_id = $mssClassification->id;
        $cashincome->category_id = $request->input('item.'.$i);
        $cashincome->price = $pricing->price;
        $cashincome->qty = $request->input('qty.'.$i);
        $cashincome->or_no = $modifier;
        $cashincome->discount = $discount;
        $cashincome->save();
        return $cashincome;
    }



    public static function getAllUndonedItems($pid)
    {
        $undoneItems = Cashincome::where([
                            ['cashincome.patients_id', $pid],
                            ['cashincome.get', 'N'],
                            ['cc.clinic_id', Auth::user()->clinic],
                            ['cashincome.void', '0'],
                        ])
                        ->leftJoin('ancillaryrequist as an', 'an.id', 'cashincome.ancillaryrequist_id')
                        ->leftJoin('cashincomesubcategory as cs', 'cs.id', 'an.cashincomesubcategory_id')
                        ->leftJoin('cashincomecategory as cc', 'cc.id', 'cs.cashincomecategory_id')
                        ->select('cashincome.id', 'sub_category', 'an.created_at', 'cashincome.get')
                        ->orderBy('cashincome.get', 'asc')->get();
        return $undoneItems;
    }

    public static function getNoteId($id)
    {
        $notes = DB::select("SELECT A.*, B.role FROM consultations A
                            LEFT JOIN users B on A.users_id = B.id
                            WHERE A.patients_id = ? AND DATE(A.created_at) = CURDATE()
                            ORDER BY A.id DESC LIMIT 1", [$id]);
        return $notes;
        // return '';
    }


    public static function getAllECGUndonedItems($pid)
    {
        $undoneItems = Cashincome::where([
            ['cashincome.patients_id', $pid],
            ['cashincome.get', 'N'],
            ['cc.clinic_id', Auth::user()->clinic],
        ])
            ->leftJoin('ancillaryrequist as an', 'an.id', 'cashincome.ancillaryrequist_id')
            ->leftJoin('cashincomesubcategory as cs', 'cs.id', 'an.cashincomesubcategory_id')
            ->leftJoin('cashincomecategory as cc', 'cc.id', 'cs.cashincomecategory_id')
            ->select('cashincome.id', 'sub_category', 'an.created_at')->get();
        return $undoneItems;
    }


}
