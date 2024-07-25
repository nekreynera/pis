<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;


class Inpatient extends Model
{
    protected $table = "inpatient";

    protected $fillable = [
        'users_id', 'patients_id', 'status'
    ];


    // public function updateWatcher($request, $watcher)
    // {
    //     Watcher::where([
    //         ['patient_id', $request->patient_id],
    //         ['status', 'A']
    //     ])->update([
    //         'watcher_id'=>$watcher
    //     ]);
    //     return;
    // }


    static function storeInpatient($id)
    {
        Inpatient::create([
            'users_id' => Auth::user()->id,
            'patients_id' => $id
        ]);
        return;
    }
    static function checkInpatient($id)
    {
        $data = Inpatient::where('patients_id', '=', $id)->orderByDesc('id')->first();
        
        // dd($data);
        return $data;
    }

}
