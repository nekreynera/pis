<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IndustrialHistory extends Model
{

    protected $table = "industrial_histories";

    protected $fillable = [
        'industrial_form_id', 'illnesses', 'smoker', 'obstetric', 'hospitalization', 'packyear', 'menarche', 'allergies',
        'drinker', 'coitus'
    ];


    public $timestamps = false;


    public function store($request, $id = false)
    {
        if($request->illnesses || $request->hospitalization
            || $request->allergies || $request->smoker || $request->packyear
            || $request->drinker || $request->menarche || $request->coitus
            || !empty($request->industrialFormId))
        {

            $arrsyObstetric = array();
            $obstetricContinue = false;
            for($i=1; $i<7; $i++){
                if($request->input('obstetric'.$i) || $request->input('obstetric'.$i) == '0'){
                    array_push($arrsyObstetric, $request->input('obstetric'.$i));
                    $obstetricContinue = true;
                }else{
                    array_push($arrsyObstetric, '*');
                }
            }
            if($obstetricContinue){
                $obstetric = implode(',',$arrsyObstetric);
            }else{
                $obstetric = null;
            }


            if(empty($request->industrialFormId)){
                $check = true;
            }else{
                $checkResult = IndustrialHistory::where('industrial_form_id', $request->industrialFormId)->first();
                $check = ($checkResult)? false : true;
            }


            if(empty($request->industrialFormId) || $check) {
                IndustrialHistory::create([
                    'industrial_form_id' => ($request->industrialFormId)? $request->industrialFormId : $id,
                    'illnesses' => $request->illnesses,
                    'smoker' => $request->smoker,
                    'obstetric' => $obstetric,
                    'hospitalization' => $request->hospitalization,
                    'packyear' => $request->packyear,
                    'menarche' => $request->menarche,
                    'allergies' => $request->allergies,
                    'drinker' => $request->drinker,
                    'coitus' => $request->coitus,
                ]);
            }else {
                IndustrialHistory::where('industrial_form_id', $request->industrialFormId)
                ->update([
                    'illnesses' => $request->illnesses,
                    'smoker' => $request->smoker,
                    'obstetric' => $obstetric,
                    'hospitalization' => $request->hospitalization,
                    'packyear' => $request->packyear,
                    'menarche' => $request->menarche,
                    'allergies' => $request->allergies,
                    'drinker' => $request->drinker,
                    'coitus' => $request->coitus,
                ]);
            }

            return 1;
        }else{
            return 0;
        }
    }



}
