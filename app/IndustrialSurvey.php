<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IndustrialSurvey extends  Model
{

    protected $table = "industrial_surveys";

    protected $fillable = [
        'industrial_form_id', 'general_survey', 'skin_integument', 'heent', 'respiratory', 'cardiovascular',
        'gastrointestinal', 'genitourinary', 'neurologic'
    ];

    public $timestamps = false;


    public function store($request, $id = false)
    {
        $procceed = false;

        $generalSurvey = null;
        $survey_skin_integument = null;
        $survey_heent = null;
        $survey_respiratory = null;
        $survey_cardiovascular = null;
        $survey_gastrointestinal = null;
        $survey_genitourinary = null;
        $survey_neurologic = null;

        if($request->has('general_surveyRadio')){
            if($request->general_surveyRadio == 0){
                $generalSurvey = $request->general_surveyRadio;
            }else{
                $generalSurvey = $request->general_survey;
            }
            $procceed = true;
        }
        if($request->has('skin_integumentRadio')){
            if($request->skin_integumentRadio == 0){
                $survey_skin_integument = $request->skin_integumentRadio;
            }else{
                $survey_skin_integument = $request->survey_skin_integument;
            }
            $procceed = true;
        }
        if($request->has('heentRadio')){
            if($request->heentRadio == 0){
                $survey_heent = $request->heentRadio;
            }else{
                $survey_heent = $request->survey_heent;
            }
            $procceed = true;
        }
        if($request->has('respiratoryRadio')){
            if($request->respiratoryRadio == 0){
                $survey_respiratory = $request->respiratoryRadio;
            }else{
                $survey_respiratory = $request->survey_respiratory;
            }
            $procceed = true;
        }
        if($request->has('cardiovascularRadio')){
            if($request->cardiovascularRadio == 0){
                $survey_cardiovascular = $request->cardiovascularRadio;
            }else{
                $survey_cardiovascular = $request->survey_cardiovascular;
            }
            $procceed = true;
        }
        if($request->has('gastrointestinalRadio')){
            if($request->gastrointestinalRadio == 0){
                $survey_gastrointestinal = $request->gastrointestinalRadio;
            }else{
                $survey_gastrointestinal = $request->survey_gastrointestinal;
            }
            $procceed = true;
        }
        if($request->has('genitourinaryRadio')){
            if($request->genitourinaryRadio == 0){
                $survey_genitourinary = $request->genitourinaryRadio;
            }else{
                $survey_genitourinary = $request->survey_genitourinary;
            }
            $procceed = true;
        }
        if($request->has('neurologicRadio')){
            if($request->neurologicRadio == 0){
                $survey_neurologic = $request->neurologicRadio;
            }else{
                $survey_neurologic = $request->survey_neurologic;
            }
            $procceed = true;
        }




        if($procceed || !empty($request->industrialFormId)){


            if(empty($request->industrialFormId)){
                $check = true;
            }else{
                $checkResult = IndustrialSurvey::where('industrial_form_id', $request->industrialFormId)->first();
                $check = ($checkResult)? false : true ;
            }


            if(empty($request->industrialFormId) || $check) {
                IndustrialSurvey::create([
                    'industrial_form_id' => ($request->industrialFormId)? $request->industrialFormId : $id,
                    'general_survey' => $generalSurvey,
                    'skin_integument' => $survey_skin_integument,
                    'heent' => $survey_heent,
                    'respiratory' => $survey_respiratory,
                    'cardiovascular' => $survey_cardiovascular,
                    'gastrointestinal' => $survey_gastrointestinal,
                    'genitourinary' => $survey_genitourinary,
                    'neurologic' => $survey_neurologic,
                ]);
            }else{
                IndustrialSurvey::where('industrial_form_id', $request->industrialFormId)
                ->update([
                    'general_survey' => $generalSurvey,
                    'skin_integument' => $survey_skin_integument,
                    'heent' => $survey_heent,
                    'respiratory' => $survey_respiratory,
                    'cardiovascular' => $survey_cardiovascular,
                    'gastrointestinal' => $survey_gastrointestinal,
                    'genitourinary' => $survey_genitourinary,
                    'neurologic' => $survey_neurologic,
                ]);
            }

            return 1;
        }else{
            return 0;
        }




    }


}
