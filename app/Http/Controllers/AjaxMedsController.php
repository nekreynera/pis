<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Contracts\Support\JsonableInterface;
use App\Patient;
use App\Consultation;
use App\MedInterns;
use App\Requisition;
use App\User;
use DB;
use Session;
use Carbon;
use Validator;
use Auth;

class AjaxMedsController extends Controller
{
    public function medsWatch(Request $request)
    {
        $medicine = Requisition::find($request->id);
        if ($medicine){
            $meds = Requisition::where('requisition.modifier', '=', $medicine->modifier)
                                ->leftJoin('pharmanagerequest as pm', 'requisition.id', '=', 'pm.requisition_id')
                                ->leftJoin('ancillary_items', 'ancillary_items.id', '=', 'requisition.item_id')
                                ->select('ancillary_items.*', 'requisition.users_id', 'requisition.id as rid', 'requisition.qty', 'pm.qty as pmQty', 'requisition.created_at as createdDate')
                                ->get();
            return $meds->toJson();
        }
    }

    public function medsUpdate(Request $request)
    {
        Requisition::find($request->rid)->update(['qty'=>$request->qty]);
    }

    public function medsDelete(Request $request)
    {
        Requisition::find($request->rid)->delete();
    }

}