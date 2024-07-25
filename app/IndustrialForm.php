<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class IndustrialForm extends Model
{
    protected $table = "industrial_forms";

    protected $fillable = [
        'patient_id', 'user_id', 'date_consulted', 'result'
    ];


    public function store($request)
    {
        $check = IndustrialForm::find($request->industrialFormId);

        if(empty($request->industrialFormId) || !$check) {
            $result = IndustrialForm::create([
                'patient_id' => $request->pid,
                'user_id' => Auth::user()->id,
                'date_consulted' => $request->date_consulted,
                'result' => $request->result
            ]);
            return $result;
        }else{
            IndustrialForm::find($request->industrialFormId)
                            ->update([
                                'patient_id' => $request->pid,
                                'user_id' => Auth::user()->id,
                                'date_consulted' => $request->date_consulted,
                                'result' => $request->result
                            ]);
            return false;
        }
    }


    public function system_reviews()
    {
        return $this->hasOne(IndustrialSystemReview::class);
    }


    public function industrial_history()
    {
        return $this->hasOne(IndustrialHistory::class);
    }

    public function physical_exams()
    {
        return $this->hasOne(IndustrialPhysicalExam::class);
    }

    public function industrial_surveys()
    {
        return $this->hasOne(IndustrialSurvey::class);
    }

    public function final_results()
    {
        return $this->hasOne(IndustrialFinalResult::class);
    }


}
