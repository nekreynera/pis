<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\JsonableInterface;
use App\Consultation;
use App\FileManager;
use DB;
use Validator;
use Auth;
use Carbon;
use Session;

class RecordsController extends Controller
{

    public function consultationWatch(Request $request){
        $consultation = Consultation::find($request->cid);
        return $consultation->toJson();
    }


}