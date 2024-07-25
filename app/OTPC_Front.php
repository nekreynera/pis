<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OTPC_Front extends Model
{
    protected $table = "otpc_front";

    protected $fillable = [
        'patient_id',
        'user_id',
        'age_months',
        'date_of_admission',
        'admission_status',
        'adults',
        'children',
        'twin',
        'distance_to_home',
        'four_ps',
        'muac_front',
        'weight',
        'height',
        'whz_score',
        'edemaAdmission',
        'admission_criteria',
        'other_description',
        'breastfeed_or_drink',
        'vomit',
        'convulsion',
        'lethargic_unconscious',
        'diarrhea',
        'stools_day',
        'vomiting',
        'frequency',
        'passing_urine',
        'cough',
        'how_long_swollen',
        'appetite_at_home',
        'breastfeeding',
        'reported_problems',
        'other_med_problems',
        'other_medical_problems',
        'respiration_rate',
        'edemaBack',
        'temperature',
        'chest_retractions',
        'eyes',
        'dehydration',
        'conjuctiva',
        'mouth',
        'ears',
        'disability',
        'skin_changes',
        'extremities',
        'appetite_test',
        'drugsFront',
        'dateFront',
        'dosageFront'
    ];
}
