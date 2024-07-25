<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class VitalSigns extends Model
{
	protected $table = "vital_signs";

    protected $fillable = [
        'triage_id', 'patients_id', 'users_id', 'weight', 'height', 'blood_pressure', 'pulse_rate', 'respiration_rate', 'body_temperature'
    ];

    public function getColumn(){
      return $this->fillable;
    }


    public function storeVitalSigns($request, $triage_id, $patients_id)
    {
        // OLD
        foreach ($this->fillable as $vitalsigns){
            if ($request->$vitalsigns){
                if ($vitalsigns == 'patients_id' || $vitalsigns == 'users_id'){
                    continue;
                }else{
                    $vital_signs = new VitalSigns();
                    $vital_signs->patients_id = $patients_id;
                    $vital_signs->users_id = Auth::user()->id;
                    $vital_signs->triage_id = $triage_id;
                    $vital_signs->weight = $request->weight;
                    $vital_signs->height = $request->height;
                    $vital_signs->blood_pressure = $request->blood_pressure;
                    $vital_signs->pulse_rate = $request->pulse_rate;
                    $vital_signs->respiration_rate = $request->respiration_rate;
                    $vital_signs->body_temperature = $request->body_temperature;
                    $vital_signs->save();
                    break;
                }
            }
        }
        return;

        // NEWLY UPDATED BY ARCHIE
        // $vital_signs = new VitalSigns();
        // $vital_signs->patients_id = $patients_id;
        // $vital_signs->users_id = Auth::user()->id;
        // $vital_signs->triage_id = $triage_id;
        // $vital_signs->weight = $request->weight;
        // $vital_signs->height = $request->height;
        // $vital_signs->blood_pressure = $request->blood_pressure;
        // $vital_signs->pulse_rate = $request->pulse_rate;
        // $vital_signs->respiration_rate = $request->respiration_rate;
        // $vital_signs->body_temperature = $request->body_temperature;
        // $vital_signs->save();
        // return;
    }



}
