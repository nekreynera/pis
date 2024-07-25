<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Clinic;
use App\Cashincomecategory;
use App\Cashincomesubcategory;
use App\Ancillaryrequist;
use App\Cashincome;
use PDF;
use DNS1D;
use DB;
use Carbon;
use Auth;
use Session;

class ReferralController extends Controller
{
	public function index()
	{
		return view('referral.overview');
	}		
	
}