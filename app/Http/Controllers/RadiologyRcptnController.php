<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Contracts\Support\JsonableInterface;
use App\Patient;
use App\Clinic;
use App\User;
use App\Laboratory;
use App\AncillaryItem;
use DB;
use Session;
use Carbon;
use Validator;
use Auth;


class RadiologyRcptnController extends Controller
{

    public function index()
    {
        return view('radiology.receptions.scan');
    }

    public function scan(Request $request)
    {

    }

}