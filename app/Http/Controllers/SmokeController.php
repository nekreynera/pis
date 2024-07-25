<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Smoke;
use Auth;
use DB;

class SmokeController extends Controller
{
		


		public function storeSmoke($pid)
		{
			Smoke::create([
				'user_id' => Auth::user()->id,
				'patient_id' => $pid,
			]);
		}


		public function deleteSmoke($pid)
		{
			Smoke::where('patient_id', $pid)->delete();
		}



		public function smoke_cessation($start=false, $end=false)
		{
			if ($start && $end) {
				$smokes = Smoke::where([
							['user_id', Auth::user()->id],
						])
						->whereBetween(DB::raw("DATE(smokes.created_at)"), [$start,$end])
						->leftJoin('patients', 'patients.id', 'smokes.patient_id')
						->get();
			}else{
				$smokes = null;
			}

			return view('doctors.reports.smoke', compact('smokes', 'start', 'end'));
		}

		public function smoke_store(Request $request)
		{
			return redirect('smoke_cessation/'.$request->start.'/'.$request->end);
		}



}