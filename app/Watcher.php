<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Watcher extends Model
{
    protected $table = "watchers";

    protected $fillable = [
        'patient_id', 'watcher_id'
    ];


    public function updateWatcher($request, $watcher)
    {
        Watcher::where([
            ['patient_id', $request->patient_id]
        ])->update([
            'watcher_id'=>$watcher
        ]);
        return;
    }


    public function storeWatcher($pid)
    {
        Watcher::create([
            'patient_id' => $pid
        ]);
        return;
    }
    public function storePatientWatcher($pid, $wid)
    {
        Watcher::create([
            'patient_id' => $pid,
            'watcher_id' => $wid 
        ]);
        return;
    }

}
