@component('partials/header')

    @slot('title')
        PIS | OTPC Front Edit
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/plugins/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/nurse/pedia/otpc_front.css') }}" rel="stylesheet" />
@stop


@section('header')
    @include('nurse.pedia.navigation')
@stop



@section('content')


    <div class="loaderRefresh" style="position: fixed">
        <div class="loaderWaiting">
            <i class="fa fa-spinner fa-spin"></i>
            <span> Please Wait...</span>
        </div>
    </div>

    <div class="container">




        <form action="{{ url('otpc_save') }}" method="post" id="otpc_submit">

            <input type="hidden" name="updateOTPC" value="{{ $data->id }}" />

            {{ csrf_field() }}

            <div class="table-responsive" id="otpc_front_table_div">

                <h5 class="text-center"><strong>OTC Chart</strong></h5>
                <h5 class="text-center"><strong>ADMISSION DETAILS: OUT PATIENT THERAPEUTIC CARE (FRONT)</strong></h5>

                <span class="text-info">Instructions:</span>
                <small>
                    <em class="text-info">
                        Please fill up needed details and encircle appropriate text or values based on history taking and physical examination
                    </em>
                </small>
                <br>
                <table class="table table-bordered table-condensed">
                    <tbody>
                    <tr>
                        <td><label>Name</label></td>
                        <td colspan="3">
                            <input type="text" class="smallInput" style="width: 100%"
                                   value="{{ $patient->last_name.', '.$patient->first_name.' '.$patient->suffix.' '.$patient->middle_name }}"
                                   required readonly>
                        </td>
                        <td><label>Reg. No</label></td>
                        <td colspan="3">
                            <input type="text" class="smallInput" style="width: 100%"
                                   value="{{ $patient->hospital_no }}" required readonly>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Municipality</label></td>
                        <td colspan="3">
                            <input type="text" class="smallInput" style="width: 100%"
                                   value="{{ $patient->citymunDesc }}" required readonly>
                        </td>
                        <td><label>Barangay</label></td>
                        <td colspan="3">
                            <input type="text" class="smallInput" style="width: 100%"
                                   value="{{ $patient->brgyDesc }}" readonly>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <label>Age (months)</label>
                            <input type="text" class="smallInput" value="{{ $data->age_months }}" style="width: 60%" name="age_months">
                        </td>
                        <td colspan="2">
                            <label>Sex</label>
                            &nbsp; &nbsp; &nbsp;
                            <label class="normalLabel"><input type="radio" disabled @if($patient->sex == 'M') checked @endif> M</label>
                            <label class="normalLabel"><input type="radio" disabled @if($patient->sex == 'F') checked @endif> F</label>
                        </td>
                        <td colspan="4">
                            <label>Date of Admission </label>
                            <input type="date" name="date_of_admission" value="{{ $data->date_of_admission }}" class="smallInput" style="width: 60%">
                        </td>
                    </tr>
                    <tr>
                        <td><label>Admission Status</label></td>
                        <td colspan="7" class="admissionStatus">
                            <em>Screened by Nurse/MD</em>
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                            <label class="normalLabel"><input type="radio" name="admission_status" value="Walk-in"
                                                              @if($data->admission_status == 'Walk-in') checked @endif> Walk-in</label>
                            <label class="normalLabel"><input type="radio" name="admission_status" value="From IC"
                                                              @if($data->admission_status == 'From IC') checked @endif> From IC</label>
                            <label class="normalLabel"><input type="radio" name="admission_status" value="From SFP"
                                                              @if($data->admission_status == 'From SFP') checked @endif> From SFP</label>
                            <label class="normalLabel"><input type="radio" name="admission_status" value="From other OC"
                                                              @if($data->admission_status == 'From other OC') checked @endif> From other OC</label>
                            <label class="normalLabel"><input type="radio" name="admission_status" value="Readmission (Relapse)"
                                                              @if($data->admission_status == 'Readmission (Relapse)') checked @endif> Readmission (Relapse)</label>
                            <label class="normalLabel"><input type="radio" name="admission_status" value="ITC Refusal"
                                                              @if($data->admission_status == 'ITC Refusal') checked @endif> ITC Refusal</label>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Total Number in Household</label></td>
                        <td>
                            #Adults
                            <input type="number" class="smallInput" name="adults" value="{{ $data->adults }}">
                        </td>
                        <td>
                            #Children
                            <input type="number" class="smallInput" name="children" value="{{ $data->children }}">
                        </td>
                        <td><label>Twin</label></td>
                        <td>
                            <label class="normalLabel"><input type="radio" name="twin" value="1"
                                                              @if($data->twin == 1) checked @endif> Yes</label>
                            &nbsp; &nbsp;
                            <label class="normalLabel"><input type="radio" name="twin" value="0"
                                                              @if($data->twin == '0') checked @endif> No</label>
                        </td>
                        <td>
                            <label>Distance to home (hrs)</label>
                            <input type="text" name="distance_to_home" class="smallInput" value="{{ $data->distance_to_home }}" style="width: 150px">
                        </td>
                        <td><label>4Ps Beneficiary?</label></td>
                        <td>
                            <label class="normappetite_test_dayalLabel">
                                <input type="radio" name="four_ps" @if($data->four_ps == 1) checked @endif value="1"> Yes
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="four_ps" @if($data->four_ps == '0') checked @endif value="0"> No
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <th colspan="8" class="text-center bg-primary">Admission Anthropometry</th>
                    </tr>
                    <tr>
                        <td>
                            <label>MUAC(cm): </label>
                            <input type="text" class="smallInput" name="muac_front" value="{{ $data->muac_front }}">
                        </td>
                        <td colspan="2">
                            <input type="text" class="smallInput" value="{{ $data->weight }}" name="weight">
                            Weight (kg)
                        </td>
                        <td colspan="2">
                            <input type="text" class="smallInput" value="{{ $data->height }}" name="height">
                            Height (cm)
                        </td>
                        <td colspan="3">
                            <input type="text" name="whz_score" value="{{ $data->whz_score }}" class="smallInput">
                            WHZ score
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Admission Criteria (encircle all apllicable)</label>
                        </td>
                        <td>
                            <label class="normalLabel">Edema</label>
                            <input type="text" class="smallInput" name="edemaAdmission" value="{{ $data->edemaAdmission }}" style="width: 100%">
                        </td>
                        <td>
                            <label class="normalLabel">
                                <input type="radio" name="admission_criteria" class="opposeOthers" value="MUAC < 11.5 cm"
                                       @if($data->admission_criteria == 'MUAC < 11.5 cm') checked @endif> MUAC < 11.5 cm
                            </label>
                        </td>
                        <td colspan="2">
                            <label class="normalLabel">
                                <input type="radio" name="admission_criteria" class="opposeOthers" value="WHZ <- 3<"
                                       @if($data->admission_criteria == 'WHZ <- 3<') checked @endif> WHZ <- 3
                            </label>
                        </td>
                        <td>
                            <label class="normalLabel">
                                <input type="radio" name="admission_criteria" class="thisOther" value="other"
                                       @if($data->admission_criteria == 'other') checked @endif> Other (specify)
                            </label>
                        </td>
                        <td colspan="2">
                            <input type="text" name="other_description" class="smallInput enableOtherField"
                                   @if($data->admission_criteria != 'other') disabled @endif
                                   style="width: 100%"
                                   value="{{ $data->other_description }}">
                        </td>
                    </tr>
                    <tr>
                        <th colspan="8" class="text-center bg-primary">History</th>
                    </tr>
                    <tr>
                        <td>
                            <label>IMCI Danger Signs</label>
                        </td>
                        <td>
                            <label>Able to drink or breastfeed?</label> &nbsp; &nbsp; &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="breastfeed_or_drink" value="1"
                                       @if($data->breastfeed_or_drink == 1) checked @endif> Yes
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="breastfeed_or_drink" value="0"
                                       @if($data->breastfeed_or_drink == '0') checked @endif> No
                            </label>
                        </td>
                        <td colspan="2">
                            <label>Does the Child Vomit Everything?</label>
                            &nbsp; &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="vomit" value="1"
                                       @if($data->vomit == 1) checked @endif> Yes
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="vomit" value="0"
                                       @if($data->vomit == '0') checked @endif> No
                            </label>
                        </td>
                        <td colspan="2">
                            <label>Has the child convulsion?</label>
                            &nbsp; &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="convulsion" value="1"
                                       @if($data->convulsion == 1) checked @endif> Yes
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="convulsion" value="0"
                                       @if($data->convulsion == '0') checked @endif> No
                            </label>
                        </td>
                        <td colspan="2">
                            <label>Is child lethargic / unconscious</label>
                            &nbsp; &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="lethargic_unconscious" value="1"
                                       @if($data->lethargic_unconscious == 1) checked @endif> Yes
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="lethargic_unconscious" value="0"
                                       @if($data->lethargic_unconscious == '0') checked @endif> No
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Diarrhea</label></td>
                        <td>
                            <label class="normalLabel">
                                <input type="radio" name="diarrhea" value="1"
                                       @if($data->diarrhea == 1) checked @endif> Yes
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="diarrhea" value="0"
                                       @if($data->diarrhea == '0') checked @endif> No
                            </label>
                        </td>
                        <td><label>Stools / Day</label></td>
                        <td colspan="5">
                            <label class="normalLabel">
                                <input type="radio" name="stools_day" value="1-3"
                                       @if($data->stools_day == "1-3") checked @endif> 1-3
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="stools_day" value="4-5"
                                       @if($data->stools_day == "4-5") checked @endif> 4-5
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="stools_day" value=">5"
                                       @if($data->stools_day == ">5") checked @endif> >5
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Vomiting</label></td>
                        <td>
                            <label class="normalLabel">
                                <input type="radio" name="vomiting" value="1"
                                       @if($data->vomiting == 1) checked @endif> Yes
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="vomiting" value="0"
                                       @if($data->vomiting == '0') checked @endif> No
                            </label>
                        </td>
                        <td rowspan="2">
                            <label>Frequency</label>
                            <input type="text" name="frequency" value="{{ $data->frequency }}" class="smallInput" style="width: 100%">
                        </td>
                        <td colspan="3"><label>Passing Urine</label></td>
                        <td colspan="2">
                            <label class="normalLabel">
                                <input type="radio" name="passing_urine" value="1"
                                       @if($data->passing_urine == 1) checked @endif> Yes
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="passing_urine" value="0"
                                       @if($data->passing_urine == '0') checked @endif> No
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Cough</label></td>
                        <td>
                            <label class="normalLabel">
                                <input type="radio" name="cough" value="1"
                                       @if($data->cough == 1) checked @endif> Yes
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="cough" value="0"
                                       @if($data->cough == '0') checked @endif> No
                            </label>
                        </td>
                        <td colspan="3">
                            <label>If edema, how long swollen?</label>
                        </td>
                        <td colspan="2">
                            <input type="text" name="how_long_swollen" value="{{ $data->how_long_swollen }}" class="smallInput" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Appetite at home?</label>
                        </td>
                        <td colspan="2">
                            <label class="normalLabel">
                                <input type="radio" name="appetite_at_home" value="good"
                                       @if($data->appetite_at_home == 'good') checked @endif> Good
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="appetite_at_home" value="poor"
                                       @if($data->appetite_at_home == 'poor') checked @endif> Poor
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="appetite_at_home" value="none"
                                       @if($data->appetite_at_home == 'none') checked @endif> None
                            </label>
                        </td>
                        <td colspan="3"><label>Breastfeeding</label></td>
                        <td colspan="2">
                            <label class="normalLabel">
                                <input type="radio" name="breastfeeding" value="1"
                                       @if($data->breastfeeding == 1) checked @endif> Yes
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="breastfeeding" value="0"
                                       @if($data->breastfeeding == '0') checked @endif> No
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Reported Problems</label></td>
                        <td>
                            <input type="text" name="reported_problems" value="{{ $data->reported_problems }}"
                                   class="smallInput" style="width: 100%">
                        </td>
                        <td>
                            <label>Other Medical Problems</label>
                        </td>
                        <td colspan="5">
                            <label class="normalLabel">
                                <input type="radio" name="other_med_problems" class="opposeOthers" value="Tuberculosis"
                                       @if($data->other_med_problems == 'Tuberculosis') checked @endif> Tuberculosis
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="other_med_problems" class="opposeOthers" value="Malaria"
                                       @if($data->other_med_problems == "Malaria") checked @endif> Malaria
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="other_med_problems" class="opposeOthers" value="Congenital anomalies"
                                       @if($data->other_med_problems == "Congenital anomalies") checked @endif> Congenital anomalies
                            </label>
                            &nbsp; &nbsp; <br>
                            <label class="normalLabel">
                                <input type="radio" name="other_med_problems" class="thisOther" value="Others"
                                       @if($data->other_med_problems == "Others") checked @endif> Others
                            </label>
                            <input type="text" name="other_medical_problems" value="{{ $data->other_medical_problems }}"
                                   class="smallInput enableOtherField" style="width: 60%"
                                   @if($data->other_med_problems != "Others") disabled @endif/>
                        </td>
                    </tr>
                    <tr>
                        <th class="text-center bg-primary" colspan="8">Physical Examination</th>
                    </tr>
                    <tr>
                        <td>
                            <label>Respiration Rate (#min)</label>
                        </td>
                        <td colspan="3">
                            <label class="normalLabel">
                                <input type="radio" name="respiration_rate" value="<30"
                                       @if($data->respiration_rate == "<30") checked @endif> <30
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="respiration_rate" value="30-39"
                                       @if($data->respiration_rate == "30-39") checked @endif> 30-39
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="respiration_rate" value="40-49"
                                       @if($data->respiration_rate == "40-49") checked @endif> 40-49
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="respiration_rate" value="50+"
                                       @if($data->respiration_rate == "50+") checked @endif> 50+
                            </label>
                        </td>
                        <td>
                            <label>Edema</label>
                        </td>
                        <td colspan="3">
                            <label class="normalLabel">
                                <input type="radio" name="edema" value="+"
                                       @if($data->edema == "+") checked @endif>+
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="edema" value="++"
                                       @if($data->edema == "++") checked @endif> ++
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="edema" value="+++"
                                       @if($data->edema == "+++") checked @endif> +++
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Temperature (C)</label>
                        </td>
                        <td colspan="3">
                            <input type="text" name="temperature" value="{{ $data->temperature }}"
                                   class="smallInput" style="width: 100%" />
                        </td>
                        <td colspan="2">
                            <label>Chest Retractions</label>
                        </td>
                        <td colspan="2">
                            <label class="normalLabel">
                                <input type="radio" name="chest_retractions" value="1"
                                       @if($data->chest_retractions == 1) checked @endif> Yes
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="chest_retractions" value="0"
                                       @if($data->chest_retractions == '0') checked @endif> No
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Eyes</label></td>
                        <td colspan="3">
                            <label class="normalLabel">
                                <input type="radio" name="eyes" value="Normal"
                                       @if($data->eyes == "Normal") checked @endif>Normal
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="eyes" value="Sunken"
                                       @if($data->eyes == "Sunken") checked @endif> Sunken
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="eyes" value="Discharge"
                                       @if($data->eyes == "Discharge") checked @endif> Discharge
                            </label>
                        </td>
                        <td>
                            <label>Dehydration</label>
                        </td>
                        <td colspan="3">
                            <label class="normalLabel">
                                <input type="radio" name="dehydration" value="None"
                                       @if($data->dehydration == "None") checked @endif> None
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="dehydration" value="Moderate"
                                       @if($data->dehydration == "Moderate") checked @endif> Moderate
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="dehydration" value="Severe"
                                       @if($data->dehydration == "Severe") checked @endif> Severe
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Conjuctiva</label></td>
                        <td colspan="3">
                            <label class="normalLabel">
                                <input type="radio" name="conjuctiva" value="Normal"
                                       @if($data->conjuctiva == "Normal") checked @endif> Normal
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="conjuctiva" value="Pale"
                                       @if($data->conjuctiva == "Pale") checked @endif> Pale
                            </label>
                        </td>
                        <td><label>Mouth</label></td>
                        <td colspan="3">
                            <label class="normalLabel">
                                <input type="radio" name="mouth" value="Normal"
                                       @if($data->mouth == "Normal") checked @endif> Normal
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="mouth" value="Sores"
                                       @if($data->mouth == "Sores") checked @endif> Sores
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="mouth" value="Candida"
                                       @if($data->mouth == "Candida") checked @endif> Candida
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Ears</label></td>
                        <td colspan="3">
                            <label class="normalLabel">
                                <input type="radio" name="ears" value="Normal"
                                       @if($data->ears == "Normal") checked @endif> Normal
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="ears" value="Discharge"
                                       @if($data->ears == "Discharge") checked @endif> Discharge
                            </label>
                        </td>
                        <td>
                            <label>Disability</label>
                        </td>
                        <td colspan="3">
                            <label class="normalLabel">
                                <input type="radio" name="disability" value="1"
                                       @if($data->disability == 1) checked @endif> Yes
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="disability" value="0"
                                       @if($data->disability == '0') checked @endif> No
                            </label>
                        </td>
                    </tr>

                    <tr>
                        <td><label>Skin Changes</label></td>
                        <td colspan="4">
                            <label class="normalLabel">
                                <input type="radio" name="skin_changes" value="None"
                                       @if($data->skin_changes == "None") checked @endif> None
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="skin_changes" value="Scabies"
                                       @if($data->skin_changes == "Scabies") checked @endif> Scabies
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="skin_changes" value="Peeling"
                                       @if($data->skin_changes == "Peeling") checked @endif> Peeling
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="skin_changes" value="Ulcer/Abscesses"
                                       @if($data->skin_changes == "Ulcer/Abscesses") checked @endif> Ulcer/Abscesses
                            </label>
                        </td>
                        <td>
                            <label>Extremities</label>
                        </td>
                        <td colspan="2">
                            <label class="normalLabel">
                                <input type="radio" name="extremities" value="Normal"
                                       @if($data->extremities == "Normal") checked @endif> Normal
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="extremities" value="Cold"
                                       @if($data->extremities == "Cold") checked @endif> Cold
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Appetite Test</label></td>
                        <td colspan="2">
                            <label class="normalLabel">
                                <input type="radio" name="appetite_test" value="Pass"
                                       @if($data->appetite_test == "Pass") checked @endif> Pass
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="appetite_test" value="Fail"
                                       @if($data->appetite_test == "Fail") checked @endif> Fail
                            </label>
                        </td>
                        <td colspan="5">
                            NOTE: <em>If child failed appetite test, refer IMMEDIATELY TO ITC</em>
                        </td>
                    </tr>
                    <tr>
                        <th class="text-center bg-primary" colspan="8">Routine Admission Medication</th>
                    </tr>
                    <tr>
                        <td rowspan="5"><label>Admission</label>:</td>
                        <td colspan="2"><label>Drug</label></td>
                        <td colspan="2"><label>Date</label></td>
                        <td colspan="3"><label>Dosage</label></td>
                    </tr>
                    <tr>
                        <?php
                            $drugsFront = explode('^', $data->drugsFront);
                            $dateFront = explode('^', $data->dateFront);
                            $dosageFront = explode('^', $data->dosageFront);
                        ?>
                        <td colspan="2">
                            <input type="text" name="drug1" class="smallInput" style="width: 100%"
                            value="{{ $drugsFront[0] }}" />
                        </td>
                        <td colspan="2">
                            <input type="date" value="{{ $dateFront[0] }}" name="dateAdmission1" class="smallInput" style="width: 100%" />
                        </td>
                        <td colspan="3">
                            <input type="text" name="dosage1" value="{{ $dosageFront[0] }}" class="smallInput" style="width: 100%" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="text" name="drug2" class="smallInput" style="width: 100%"
                                   value="{{ $drugsFront[1] }}"/>
                        </td>
                        <td colspan="2">
                            <input type="date" value="{{ $dateFront[1] }}" name="dateAdmission2" class="smallInput" style="width: 100%" />
                        </td>
                        <td colspan="3">
                            <input type="text" name="dosage2" value="{{ $dosageFront[1] }}" class="smallInput" style="width: 100%" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="text" name="drug3" class="smallInput" style="width: 100%"
                                   value="{{ $drugsFront[2] }}"/>
                        </td>
                        <td colspan="2">
                            <input type="date" value="{{ $dateFront[2] }}" name="dateAdmission3" class="smallInput" style="width: 100%" />
                        </td>
                        <td colspan="3">
                            <input type="text" name="dosage3" value="{{ $dosageFront[2] }}" class="smallInput" style="width: 100%" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="text" name="drug4" class="smallInput" style="width: 100%"
                                   value="{{ $drugsFront[3] }}"/>
                        </td>
                        <td colspan="2">
                            <input type="date" value="{{ $dateFront[3] }}" name="dateAdmission4" class="smallInput" style="width: 100%" />
                        </td>
                        <td colspan="3">
                            <input type="text" name="dosage4" value="{{ $dosageFront[3] }}" class="smallInput" style="width: 100%" />
                        </td>
                    </tr>

                    </tbody>
                </table>
            </div>


            <hr>


            <div class="table-responsive" id="otpc_back_table_div">
                <h5 class="text-center"><strong>FOLLOW UP: OUTPATIENT THERAPEUTIC CARE (BACK)</strong></h5>
                <table class="table table-bordered">
                    <tr>
                        <td colspan="9">
                            <label>Name:</label>
                            <input type="text" class="smallInput" style="width: 90%"
                                   value="{{ $patient->last_name.', '.$patient->first_name.' '.$patient->suffix.' '.$patient->middle_name }}"
                                   readonly/>
                        </td>
                        <td colspan="9">
                            <label>Registration Number:</label>
                            <input type="text" name="registrationNumber" class="smallInput"
                                   value="{{ $patient->hospital_no }}" style="width: 70%"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Week</label>
                        </td>
                        <td>ADM</td>
                        @for($i=2;$i<18;$i++)
                            <td>{{ $i }}</td>
                        @endfor
                    </tr>

                    {{-- for otpc back change to array --}}
                    <?php
                        $date = array_map('removeAsterisk', explode('^', $data->date));
                        $weightKG = array_map('removeAsterisk', explode('^', $data->weightKG));
                        $weightLoss = array_map('removeAsterisk', explode('^', $data->weightLoss));
                        $muac = array_map('removeAsterisk', explode('^', $data->muac));
                        $edemaBack = array_map('removeAsterisk', explode('^', $data->edemaBack));
                        $length_height = array_map('removeAsterisk', explode('^', $data->length_height));
                        $whz = array_map('removeAsterisk', explode('^', $data->whz));
                        $diarrheaDays = array_map('removeAsterisk', explode('^', $data->diarrheaDays));
                        $vomiting_days = array_map('removeAsterisk', explode('^', $data->vomiting_days));
                        $fever_days = array_map('removeAsterisk', explode('^', $data->fever_days));
                        $cough_days = array_map('removeAsterisk', explode('^', $data->cough_days));
                        $temperatureDays = array_map('removeAsterisk', explode('^', $data->temperatureDays));
                        $respirationRate = array_map('removeAsterisk', explode('^', $data->respirationRate));
                        $dehydrated = array_map('removeAsterisk', explode('^', $data->dehydrated));
                        $anemia = array_map('removeAsterisk', explode('^', $data->anemia));
                        $skin_infection = array_map('removeAsterisk', explode('^', $data->skin_infection));
                        $appetite_test_day = array_map('removeAsterisk', explode('^', $data->appetite_test_day));
                        $action_needed = array_map('removeAsterisk', explode('^', $data->action_needed));
                        $appetite_test_pass_fail = array_map('removeAsterisk', explode('^', $data->appetite_test_pass_fail));
                        $other_medication = array_map('removeAsterisk', explode('^', $data->other_medication));
                        $rutf = array_map('removeAsterisk', explode('^', $data->rutf));
                        $examiner = array_map('removeAsterisk', explode('^', $data->examiner));
                        $outcome = array_map('removeAsterisk', explode('^', $data->outcome));

                        function removeAsterisk($value){
                            if ($value == '*'){
                                return '';
                            }else{
                                return $value;
                            }
                        }
                    ?>


                    <tr>
                        <td><label>Date</label></td>
                        @for($i=0;$i<17;$i++)
                            <td>
                                <input type="date" name="date{{ $i }}" value="{{ $date[$i] }}" class="smallInput" style="width: 100%">
                            </td>
                        @endfor
                    </tr>
                    <tr>
                        <th colspan="18">Anthropometry</th>
                    </tr>
                    <tr>
                        <td><label>Weight (kg)</label></td>
                        @for($i=0;$i<17;$i++)
                            <td>
                                <input type="text" name="weightKG{{ $i }}" value="{{ $weightKG[$i] }}" class="smallInput" style="width: 100%">
                            </td>
                        @endfor
                    </tr>
                    <tr>
                        <td><label>Weight loss * (Y/N)</label></td>
                        @for($i=0;$i<17;$i++)
                            <td>
                                <input type="text" name="weightLoss{{ $i }}" value="{{ $weightLoss[$i] }}" class="smallInput" style="width: 100%">
                            </td>
                        @endfor
                    </tr>
                    <tr>
                        <td><label>MUAC (cm)</label></td>
                        @for($i=0;$i<17;$i++)
                            <td>
                                <input type="text" name="muac{{ $i }}" value="{{ $muac[$i] }}" class="smallInput" style="width: 100%">
                            </td>
                        @endfor
                    </tr>
                    <tr>
                        <td><label>Edema (+ ++ +++)</label></td>
                        @for($i=0;$i<17;$i++)
                            <td>
                                <input type="text" name="edemaBack{{ $i }}" value="{{ $edemaBack[$i] }}" class="smallInput" style="width: 100%">
                            </td>
                        @endfor
                    </tr>
                    <tr>
                        <td><label>Length/Height</label></td>
                        @for($i=0;$i<17;$i++)
                            <td>
                                <input type="text" name="length_height{{ $i }}" value="{{ $length_height[$i] }}" class="smallInput" style="width: 100%">
                            </td>
                        @endfor
                    </tr>
                    <tr>
                        <td><label>WHZ</label></td>
                        @for($i=0;$i<10;$i++)
                            <td>
                                <input type="text" name="whz{{ $i }}" value="{{ $whz[$i] }}" class="smallInput" style="width: 100%">
                            </td>
                        @endfor
                    </tr>
                    <tr>
                        <td colspan="18">
                            * WEIGHT CHANGES MARASMICS: If below weight on week 3 refer for home visit. If no weight gain by week 5 refer to ITC.
                        </td>
                    </tr>
                    <tr>
                        <th colspan="18">History</th>
                    </tr>
                    <tr>
                        <td><label>Diarrhea (#days)</label></td>
                        @for($i=0;$i<17;$i++)
                            <td>
                                <input type="text" name="diarrheaDays{{ $i }}" value="{{ $diarrheaDays[$i] }}" class="smallInput" style="width: 100%">
                            </td>
                        @endfor
                    </tr>
                    <tr>
                        <td><label>Vomiting (#days)</label></td>
                        @for($i=0;$i<17;$i++)
                            <td>
                                <input type="text" name="vomiting_days{{ $i }}" value="{{ $vomiting_days[$i] }}" class="smallInput" style="width: 100%">
                            </td>
                        @endfor
                    </tr>
                    <tr>
                        <td><label>Fever (#days)</label></td>
                        @for($i=0;$i<17;$i++)
                            <td>
                                <input type="text" name="fever_days{{ $i }}" value="{{ $fever_days[$i] }}" class="smallInput" style="width: 100%">
                            </td>
                        @endfor
                    </tr>
                    <tr>
                        <td><label>Cough (#days)</label></td>
                        @for($i=0;$i<17;$i++)
                            <td>
                                <input type="text" name="cough_days{{ $i }}" value="{{ $cough_days[$i] }}" class="smallInput" style="width: 100%">
                            </td>
                        @endfor
                    </tr>
                    <tr>
                        <th colspan="18">Physical Examination</th>
                    </tr>
                    <tr>
                        <td><label>Temperature (C)</label></td>
                        @for($i=0;$i<17;$i++)
                            <td>
                                <input type="text" name="temperatureDays{{ $i }}" value="{{ $temperatureDays[$i] }}" class="smallInput" style="width: 100%">
                            </td>
                        @endfor
                    </tr>
                    <tr>
                        <td><label>Respiration Rate (# / min)</label></td>
                        @for($i=0;$i<17;$i++)
                            <td>
                                <input type="text" name="respirationRate{{ $i }}" value="{{ $respirationRate[$i] }}" class="smallInput" style="width: 100%">
                            </td>
                        @endfor
                    </tr>
                    <tr>
                        <td><label>Dehydrated (Y/ N)</label></td>
                        @for($i=0;$i<17;$i++)
                            <td>
                                <input type="text" name="dehydrated{{ $i }}" value="{{ $dehydrated[$i] }}" class="smallInput" style="width: 100%">
                            </td>
                        @endfor
                    </tr>
                    <tr>
                        <td><label>Anemia (Y/N)</label></td>
                        @for($i=0;$i<17;$i++)
                            <td>
                                <input type="text" name="anemia{{ $i }}" value="{{ $anemia[$i] }}" class="smallInput" style="width: 100%">
                            </td>
                        @endfor
                    </tr>
                    <tr>
                        <td><label>Skin Infection (Y/N)</label></td>
                        @for($i=0;$i<17;$i++)
                            <td>
                                <input type="text" name="skin_infection{{ $i }}" value="{{ $skin_infection[$i] }}" class="smallInput" style="width: 100%">
                            </td>
                        @endfor
                    </tr>
                    <tr>
                        <td><label>Appetite Test (Pass/Fail)</label></td>
                        @for($i=0;$i<17;$i++)
                            <td>
                                <input type="text" name="appetite_test_day{{ $i }}" value="{{ $appetite_test_day[$i] }}" class="smallInput" style="width: 100%">
                            </td>
                        @endfor
                    </tr>
                    <tr>
                        <td><label>Action Needed (Y/N)</label></td>
                        @for($i=0;$i<17;$i++)
                            <td>
                                <input type="text" name="action_needed{{ $i }}" value="{{ $action_needed[$i] }}" class="smallInput" style="width: 100%">
                            </td>
                        @endfor
                    </tr>
                    <tr>
                        <td><label>Appetite Test (Pass/Fail) (note below)</label></td>
                        @for($i=0;$i<17;$i++)
                            <td>
                                <input type="text" name="appetite_test_pass_fail{{ $i }}" value="{{ $appetite_test_pass_fail[$i] }}" class="smallInput" style="width: 100%">
                            </td>
                        @endfor
                    </tr>
                    <tr>
                        <td><label>Other Medication (see front of card)</label></td>
                        @for($i=0;$i<17;$i++)
                            <td>
                                <input type="text" name="other_medication{{ $i }}" value="{{ $other_medication[$i] }}" class="smallInput" style="width: 100%">
                            </td>
                        @endfor
                    </tr>
                    <tr>
                        <td><label>RUTF (#sachets)</label></td>
                        @for($i=0;$i<17;$i++)
                            <td>
                                <input type="text" name="rutf{{ $i }}" value="{{ $rutf[$i] }}" class="smallInput" style="width: 100%">
                            </td>
                        @endfor
                    </tr>
                    <tr>
                        <td><label>Name of Examiner</label></td>
                        @for($i=0;$i<17;$i++)
                            <td>
                                <input type="text" name="examiner{{ $i }}" value="{{ $examiner[$i] }}" class="smallInput" style="width: 100%">
                            </td>
                        @endfor
                    </tr>
                    <tr>
                        <td><label>OUTCOME ***</label></td>
                        @for($i=0;$i<17;$i++)
                            <td>
                                <input type="text" name="outcome{{ $i }}" value="{{ $outcome[$i] }}" class="smallInput" style="width: 100%">
                            </td>
                        @endfor
                    </tr>
                    <tr>
                        <td colspan="18">
                            *** A = absent &nbsp; &nbsp; &nbsp;
                            D = defaulter (3 consecutive absences) &nbsp; &nbsp; &nbsp;
                            T = transfer to Inpatient &nbsp; &nbsp; &nbsp;
                            X = died &nbsp; &nbsp; &nbsp;
                            C = discharged cured &nbsp; &nbsp; &nbsp;
                            RT = refused transfer &nbsp; &nbsp; &nbsp;
                            HV = home visit &nbsp; &nbsp; &nbsp;
                            NC = discharged non-cured &nbsp; &nbsp; &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td colspan="18" class="text-center">**Action taken (include data)</td>
                    </tr>
                </table>


                <div class="buttonWrapper">
                    <a href="#0" class="cd-top js-cd-top">Top</a>
                    @if(Auth::user()->clinic == 26)
                        <button type="submit" class="btn btn-success btnSave" title="Click to save">
                            <i class="fa fa-save"></i>
                        </button>
                    @endif
                </div>
            </div>


            <br>
            <br>
            <br>
            <br>

        </form>
    </div>

@endsection



@section('footer')
@stop



@section('pagescript')

    @include('message.toaster')
    <script src="{{ asset('public/plugins/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/plugins/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/js/nurse/pedia/otpc.js') }}"></script>

    @include('receptions.message.notify')

@stop


@endcomponent
