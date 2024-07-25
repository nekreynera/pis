<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Assignation;
use Auth;
use Carbon;
use Session;
use DB;

class Serving extends Model
{
	protected $table = "servings";

    protected $fillable = [
        'assignations_id', 'patients_id', 'modifier', 'doctors_id', 'users_id', 'clinic_code', 'status'
    ];

    public function serving()
    {
    	$serving = Serving::where('doctors_id', '=', Auth::user()->id)
			            ->whereDate('created_at', Carbon::now()->format('Y-m-d'))
			            ->latest()->first();
		if ($serving) {
            session(['pid' => $serving->patients_id, 'modifier' => $serving->modifier, 'modid' => $serving->id]);
			return $serving;
		}
		return $serving;
    }

    public function storeServing($id)
    {
    	$assignation = Assignation::where('patients_id', '=', $id)
                        ->where('doctors_id', '=', Auth::user()->id)
                        ->whereDate('created_at', Carbon::now()->format('Y-m-d'))
                        ->limit(1)->latest()->get();
        if (count($assignation) > 0) {
        	Assignation::find($assignation[0]->id)
        				->update(['status'=>'S']);

        	$random = Str::random(60);
        	$servings = new Serving();
            $servings->assignations_id = $assignation[0]->id;
            $servings->patients_id = $id;
            $servings->modifier = $random;
            $servings->doctors_id = Auth::user()->id;
            $servings->clinic_code = Auth::user()->clinic;
            $servings->status = 'S';
            $servings->save();
        	session(['pid' => $id, 'modifier' => $random, 'modid' => $servings->id]);
        }
        return false;
    }

    public static function endConsultation(Request $request)
    {
    	/*$assignation = Serving::find(Session::get('modid'));
    	Assignation::find($assignation->assignations_id)
        				->update(['status'=>'F']);
        Serving::find(Session::get('modid'))->delete();
        $request->session()->forget(['pid', 'modifier', 'modid']);*/

                // if (Auth::check()){
                //        $assignation = Serving::where('doctors_id', '=', Auth::user()->id)
                //                                ->whereDate('created_at', Carbon::now()->toDateString())
                //                                ->latest()->first();
                //        if ($assignation){
                //            Assignation::find($assignation->assignations_id)->update(['status'=>'F']);
                //            DB::table('servings')->where('id', '=', $assignation->id)->delete();
                //            //Serving::find($assignation->id)->delete();
                //            $request->session()->forget(['pid', 'modifier', 'modid']);
                //        }
                //}

        $assignation = Serving::where('doctors_id', '=', Auth::user()->id)
                                ->get();
        if (count($assignation) > 0){
            foreach ($assignation as $list) {
                Assignation::find($list->assignations_id)->update(['status'=>'F']);
                DB::table('servings')->where('id', '=', $list->id)->delete();
            }
            //Serving::find($assignation->id)->delete();
        }
        $request->session()->forget(['pid', 'modifier', 'modid']);

    	return false;
    }



}
