<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Serving;
use Illuminate\Support\Facades\Auth;

class Assignation extends Model
{
	protected $table = "assignations";

    protected $fillable = [
        'patients_id', 'doctors_id', 'users_id', 'clinic_code', 'status'
    ];


    public static function checkServing()
    {
        $check = Serving::where('servings.doctors_id', '=', Auth::user()->id)
                        ->whereDate('servings.created_at', Carbon::now()->toDateString())
                        ->leftJoin('assignations as asgn', 'asgn.id', '=', 'servings.assignations_id')
                        ->select('servings.id', 'asgn.status')
                        ->latest('servings.created_at')->first();
        return $check;
    }


}
