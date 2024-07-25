<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IndustrialPhysicalExam extends  Model
{

    protected $table = "industrial_physical_exams";

    protected $fillable = [
        'industrial_form_id', 'bp', 'hr', 'rr', 'temp', 'bmi', 'wt', 'ht'
    ];

    public $timestamps = false;

    public function store($request, $id = false)
    {
        if($request->bp || $request->hr || $request->rr || $request->temp
            || $request->bmi || $request->wt || $request->ht
            || !empty($request->industrialFormId))
        {
            if(empty($request->industrialFormId)){
                $check = true;
            }else{
                $checkResult = IndustrialPhysicalExam::where('industrial_form_id', $request->industrialFormId)->first();
                $check = ($checkResult)? false : true;
            }

            if(empty($request->industrialFormId) || $check) {
                IndustrialPhysicalExam::create([
                    'industrial_form_id' => ($request->industrialFormId)? $request->industrialFormId : $id,
                    'bp' => $request->bp,
                    'hr' => $request->hr,
                    'rr' => $request->rr,
                    'temp' => $request->temp,
                    'bmi' => $request->bmi,
                    'wt' => $request->wt,
                    'ht' => $request->ht,
                ]);
            }else{
                IndustrialPhysicalExam::where('industrial_form_id', $request->industrialFormId)
                ->update([
                    'bp' => $request->bp,
                    'hr' => $request->hr,
                    'rr' => $request->rr,
                    'temp' => $request->temp,
                    'bmi' => $request->bmi,
                    'wt' => $request->wt,
                    'ht' => $request->ht,
                ]);
            }

            return 1;
        }else{
            return 0;
        }
    }

}
