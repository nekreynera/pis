<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IndustrialSystemReview extends  Model
{

    protected $table = "industrial_system_reviews";

    protected $fillable = [
        'industrial_form_id', 'heent', 'gastrointestinal', 'neurologic', 'respiratory', 'genitourinary',
        'musculoskeletal', 'cardiovascular', 'metabolic_endocrine', 'skin_integument'
    ];


    public $timestamps = false;


    public function store($request, $id = false)
    {
        $heent = ($request->heent)? implode(',',$request->heent) : null;
        $gastrointestinal = ($request->gastrointestinal)? implode(',',$request->gastrointestinal) : null;
        $neurologic = ($request->neurologic)? implode(',',$request->neurologic) : null;
        $respiratory = ($request->respiratory)? implode(',',$request->respiratory) : null;
        $genitourinary = ($request->genitourinary)? implode(',',$request->genitourinary) : null;
        $musculoskeletal = ($request->musculoskeletal)? implode(',',$request->musculoskeletal) : null;
        $cardiovascular = ($request->cardiovascular)? implode(',',$request->cardiovascular) : null;
        $metabolic_endocrine = ($request->metabolic_endocrine)? implode(',',$request->metabolic_endocrine) : null;
        $skin_integument = ($request->skin_integument)? implode(',',$request->skin_integument) : null;


        if($heent || $gastrointestinal || $neurologic
            || $respiratory || $genitourinary
            || $musculoskeletal || $cardiovascular
            || $metabolic_endocrine || $skin_integument
            || !empty($request->industrialFormId))
        {

            if(empty($request->industrialFormId)){
                $check = true;
            }else{
                $checkResult = IndustrialSystemReview::where('industrial_form_id', $request->industrialFormId)->first();
                $check = ($checkResult)? false : true;
            }


            if(empty($request->industrialFormId) || $check) {
                IndustrialSystemReview::create([
                    'industrial_form_id' => ($request->industrialFormId)? $request->industrialFormId : $id,
                    'heent' => $heent,
                    'gastrointestinal' => $gastrointestinal,
                    'neurologic' => $neurologic,
                    'respiratory' => $respiratory,
                    'genitourinary' => $genitourinary,
                    'musculoskeletal' => $musculoskeletal,
                    'cardiovascular' => $cardiovascular,
                    'metabolic_endocrine' => $metabolic_endocrine,
                    'skin_integument' => $skin_integument,
                ]);
            }else{
                IndustrialSystemReview::where('industrial_form_id', $request->industrialFormId)
                ->update([
                    'heent' => $heent,
                    'gastrointestinal' => $gastrointestinal,
                    'neurologic' => $neurologic,
                    'respiratory' => $respiratory,
                    'genitourinary' => $genitourinary,
                    'musculoskeletal' => $musculoskeletal,
                    'cardiovascular' => $cardiovascular,
                    'metabolic_endocrine' => $metabolic_endocrine,
                    'skin_integument' => $skin_integument,
                ]);
            }

            return 1;
        }else{
            return 0;
        }
    }


}
