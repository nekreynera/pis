<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IndustrialFinalResult extends Model
{

    protected $table = "industrial_final_results";

    protected $fillable = [
        'industrial_form_id', 'assesment', 'plan', 'diagnostic', 'followup', 'referral', 'advise', 'therapeutics'
    ];

    public $timestamps = false;

    public  function store($request, $id = false)
    {
        if($request->assesment || $request->plan || $request->diagnostic ||
            $request->followup || $request->referral ||
            $request->advise || $request->therapeutics
            || !empty($request->industrialFormId))
        {

            if(empty($request->industrialFormId)){
                $check = true;
            }else{
                $checkResult = IndustrialFinalResult::where('industrial_form_id', $request->industrialFormId)->first();
                $check = ($checkResult)? false : true;
            }

            if(empty($request->industrialFormId) || $check) {
                IndustrialFinalResult::create([
                    'industrial_form_id' => ($request->industrialFormId)? $request->industrialFormId : $id,
                    'assesment' => $request->assesment,
                    'plan' => $request->plan,
                    'diagnostic' => $request->diagnostic,
                    'followup' => $request->followup,
                    'referral' => $request->referral,
                    'advise' => $request->advise,
                    'therapeutics' => $request->therapeutics,
                ]);
            }else{
                IndustrialFinalResult::where('industrial_form_id', $request->industrialFormId)
                ->update([
                    'assesment' => $request->assesment,
                    'plan' => $request->plan,
                    'diagnostic' => $request->diagnostic,
                    'followup' => $request->followup,
                    'referral' => $request->referral,
                    'advise' => $request->advise,
                    'therapeutics' => $request->therapeutics,
                ]);
            }

            return 1;
        }else{
            return 0;
        }
    }


}
