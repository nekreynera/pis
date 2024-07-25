<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Refregion;
use App\Refprovince;
use App\Refcitymun;
use App\Refbrgy;

class AddressController extends Controller
{
		public function regions()
		{
			$regions = Refregion::all();
			echo json_encode($regions);
			return;
		}	

		public function province(Request $request)
		{
			$provinces = Refprovince::where('regCode', $request->regCode)->get();
			echo json_encode($provinces);
			return;
		}

		public function city_municipality(Request $request)
		{
			$city_municipality = Refcitymun::where('provCode', $request->provCode)->get();
			echo json_encode($city_municipality);
			return;
		}

		public function brgy(Request $request)
		{
			$brgy = Refbrgy::where('citymunCode', $request->citymunCode)->get();
			echo json_encode($brgy);
			return;
		}


}