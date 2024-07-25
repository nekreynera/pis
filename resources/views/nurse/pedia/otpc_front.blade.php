@component('partials/header')

    @slot('title')
        PIS | OTPC Front
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


            <input type="hidden" name="patient_id" value="{{ $patient->pid }}" />

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
                        <input type="text" class="smallInput" style="width: 60%" name="age_months">
                    </td>
                    <td colspan="2">
                        <label>Sex</label>
                        &nbsp; &nbsp; &nbsp;
                        <label class="normalLabel"><input type="radio" disabled @if($patient->sex == 'M') checked @endif> M</label>
                        <label class="normalLabel"><input type="radio" disabled @if($patient->sex == 'F') checked @endif> F</label>
                    </td>
                    <td colspan="4">
                        <label>Date of Admission </label>
                        <input type="date" name="date_of_admission" class="smallInput" style="width: 60%">
                    </td>
                </tr>
                <tr>
                    <td><label>Admission Status</label></td>
                    <td colspan="7" class="admissionStatus">
                        <em>Screened by Nurse/MD</em>
                        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                        <label class="normalLabel"><input type="radio" name="admission_status" value="Walk-in"> Walk-in</label>
                        <label class="normalLabel"><input type="radio" name="admission_status" value="From IC"> From IC</label>
                        <label class="normalLabel"><input type="radio" name="admission_status" value="From SFP"> From SFP</label>
                        <label class="normalLabel"><input type="radio" name="admission_status" value="From other OC"> From other OC</label>
                        <label class="normalLabel"><input type="radio" name="admission_status" value="Readmission (Relapse)"> Readmission (Relapse)</label>
                        <label class="normalLabel"><input type="radio" name="admission_status" value="ITC Refusal"> ITC Refusal</label>
                    </td>
                </tr>
                <tr>
                    <td><label>Total Number in Household</label></td>
                    <td>
                        #Adults
                        <input type="number" class="smallInput" name="adults">
                    </td>
                    <td>
                        #Children
                        <input type="number" class="smallInput" name="children">
                    </td>
                    <td><label>Twin</label></td>
                    <td>
                        <label class="normalLabel"><input type="radio" name="twin" value="1"> Yes</label>
                        &nbsp; &nbsp;
                        <label class="normalLabel"><input type="radio" name="twin" value="0"> No</label>
                    </td>
                    <td>
                        <label>Distance to home (hrs)</label>
                        <input type="text" name="distance_to_home" class="smallInput" style="width: 150px">
                    </td>
                    <td><label>4Ps Beneficiary?</label></td>
                    <td>
                        <label class="normappetite_test_dayalLabel"><input type="radio" name="four_ps" value="1"> Yes</label>
                        &nbsp; &nbsp;
                        <label class="normalLabel"><input type="radio" name="four_ps" value="0"> No</label>
                    </td>
                </tr>
                <tr>
                    <th colspan="8" class="text-center bg-primary">Admission Anthropometry</th>
                </tr>
                <tr>
                    <td>
                        <label>MUAC(cm): </label>
                        <input type="text" class="smallInput" name="muac_front" />
                    </td>
                    <td colspan="2">
                        <input type="text" class="smallInput" name="weight">
                        Weight (kg)
                    </td>
                    <td colspan="2">
                        <input type="text" class="smallInput" name="height">
                        Height (cm)
                    </td>
                    <td colspan="3">
                        <input type="text" name="whz_score" class="smallInput">
                        WHZ score
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Admission Criteria (encircle all apllicable)</label>
                    </td>
                    <td>
                        <label class="normalLabel">Edema</label>
                        <input type="text" class="smallInput" name="edemaAdmission" style="width: 100%">
                    </td>
                    <td>
                        <label class="normalLabel"><input type="radio" name="admission_criteria" class="opposeOthers" value="MUAC < 11.5 cm"> MUAC < 11.5 cm</label>
                    </td>
                    <td colspan="2">
                        <label class="normalLabel"><input type="radio" name="admission_criteria" class="opposeOthers" value="WHZ <- 3<"> WHZ <- 3</label>
                    </td>
                    <td>
                        <label class="normalLabel"><input type="radio" name="admission_criteria" class="thisOther" value="other"> Other (specify)</label>
                    </td>
                    <td colspan="2">
                        <input type="text" name="other_description" class="smallInput enableOtherField" disabled style="width: 100%">
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
                        <label class="normalLabel"><input type="radio" name="breastfeed_or_drink" value="1"> Yes</label>
                        &nbsp; &nbsp;
                        <label class="normalLabel"><input type="radio" name="breastfeed_or_drink" value="0"> No</label>
                    </td>
                    <td colspan="2">
                        <label>Does the Child Vomit Everything?</label>
                        &nbsp; &nbsp; &nbsp;
                        <label class="normalLabel"><input type="radio" name="vomit" value="1"> Yes</label>
                        &nbsp; &nbsp;
                        <label class="normalLabel"><input type="radio" name="vomit" value="0"> No</label>
                    </td>
                    <td colspan="2">
                        <label>Has the child convulsion?</label>
                        &nbsp; &nbsp; &nbsp;
                        <label class="normalLabel"><input type="radio" name="convulsion" value="1"> Yes</label>
                        &nbsp; &nbsp;
                        <label class="normalLabel"><input type="radio" name="convulsion" value="0"> No</label>
                    </td>
                    <td colspan="2">
                        <label>Is child lethargic / unconscious</label>
                        &nbsp; &nbsp; &nbsp;
                        <label class="normalLabel"><input type="radio" name="lethargic_unconscious" value="1"> Yes</label>
                        &nbsp; &nbsp;
                        <label class="normalLabel"><input type="radio" name="lethargic_unconscious" value="0"> No</label>
                    </td>
                </tr>
                <tr>
                    <td><label>Diarrhea</label></td>
                    <td>
                        <label class="normalLabel"><input type="radio" name="diarrhea" value="1"> Yes</label>
                        &nbsp; &nbsp;
                        <label class="normalLabel"><input type="radio" name="diarrhea" value="0"> No</label>
                    </td>
                    <td><label>Stools / Day</label></td>
                    <td colspan="5">
                        <label class="normalLabel"><input type="radio" name="stools_day" value="1-3"> 1-3</label>
                        &nbsp; &nbsp;
                        <label class="normalLabel"><input type="radio" name="stools_day" value="4-5"> 4-5</label>
                        &nbsp; &nbsp;
                        <label class="normalLabel"><input type="radio" name="stools_day" value=">5"> >5</label>
                    </td>
                </tr>
                <tr>
                    <td><label>Vomiting</label></td>
                    <td>
                        <label class="normalLabel"><input type="radio" name="vomiting" value="1"> Yes</label>
                        &nbsp; &nbsp;
                        <label class="normalLabel"><input type="radio" name="vomiting" value="0"> No</label>
                    </td>
                    <td rowspan="2">
                        <label>Frequency</label>
                        <input type="text" name="frequency" class="smallInput" style="width: 100%">
                    </td>
                    <td colspan="3"><label>Passing Urine</label></td>
                    <td colspan="2">
                        <label class="normalLabel"><input type="radio" name="passing_urine" value="1"> Yes</label>
                        &nbsp; &nbsp;
                        <label class="normalLabel"><input type="radio" name="passing_urine" value="0"> No</label>
                    </td>
                </tr>
                <tr>
                    <td><label>Cough</label></td>
                    <td>
                        <label class="normalLabel"><input type="radio" name="cough" value="1"> Yes</label>
                        &nbsp; &nbsp;
                        <label class="normalLabel"><input type="radio" name="cough" value="0"> No</label>
                    </td>
                    <td colspan="3">
                        <label>If edema, how long swollen?</label>
                    </td>
                    <td colspan="2">
                        <input type="text" name="how_long_swollen" class="smallInput" style="width: 100%">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Appetite at home?</label>
                    </td>
                    <td colspan="2">
                        <label class="normalLabel"><input type="radio" name="appetite_at_home" value="good"> Good</label>
                        &nbsp; &nbsp;
                        <label class="normalLabel"><input type="radio" name="appetite_at_home" value="poor"> Poor</label>
                        &nbsp; &nbsp;
                        <label class="normalLabel"><input type="radio" name="appetite_at_home" value="none"> None</label>
                    </td>
                    <td colspan="3"><label>Breastfeeding</label></td>
                    <td colspan="2">
                        <label class="normalLabel"><input type="radio" name="breastfeeding" value="1"> Yes</label>
                        &nbsp; &nbsp;
                        <label class="normalLabel"><input type="radio" name="breastfeeding" value="0"> No</label>
                    </td>
                </tr>
                <tr>
                    <td><label>Reported Problems</label></td>
                    <td>
                        <input type="text" name="reported_problems" class="smallInput" style="width: 100%">
                    </td>
                    <td>
                        <label>Other Medical Problems</label>
                    </td>
                    <td colspan="5">
                        <label class="normalLabel"><input type="radio" name="other_med_problems" class="opposeOthers" value="Tuberculosis"> Tuberculosis</label>
                        &nbsp; &nbsp;
                        <label class="normalLabel"><input type="radio" name="other_med_problems" class="opposeOthers" value="Malaria"> Malaria</label>
                        &nbsp; &nbsp;
                        <label class="normalLabel"><input type="radio" name="other_med_problems" class="opposeOthers" value="Congenital anomalies"> Congenital anomalies</label>
                        &nbsp; &nbsp; <br>
                        <label class="normalLabel"><input type="radio" name="other_med_problems" class="thisOther" value="Others"> Others</label>
                        <input type="text" name="other_medical_problems" class="smallInput enableOtherField" disabled style="width: 60%" />
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
                        <label class="normalLabel"><input type="radio" name="respiration_rate" value="<30"> <30</label>
                        &nbsp; &nbsp;
                        <label class="normalLabel"><input type="radio" name="respiration_rate" value="30-39"> 30-39</label>
                        &nbsp; &nbsp;
                        <label class="normalLabel"><input type="radio" name="respiration_rate" value="40-49"> 40-49</label>
                        &nbsp; &nbsp;
                        <label class="normalLabel"><input type="radio" name="respiration_rate" value="50+"> 50+</label>
                    </td>
                    <td>
                        <label>Edema</label>
                    </td>
                    <td colspan="3">
                        <label class="normalLabel"><input type="radio" name="edema" value="+">+</label>
                        &nbsp; &nbsp;
                        <label class="normalLabel"><input type="radio" name="edema" value="++"> ++</label>
                        &nbsp; &nbsp;
                        <label class="normalLabel"><input type="radio" name="edema" value="+++"> +++</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Temperature (C)</label>
                    </td>
                    <td colspan="3">
                        <input type="text" name="temperature" class="smallInput" style="width: 100%" />
                    </td>
                    <td colspan="2">
                        <label>Chest Retractions</label>
                    </td>
                    <td colspan="2">
                        <label class="normalLabel"><input type="radio" name="chest_retractions" value="1"> Yes</label>
                        &nbsp; &nbsp;
                        <label class="normalLabel"><input type="radio" name="chest_retractions" value="0"> No</label>
                    </td>
                </tr>
                <tr>
                    <td><label>Eyes</label></td>
                    <td colspan="3">
                        <label class="normalLabel"><input type="radio" name="eyes" value="Normal">Normal</label>
                        &nbsp; &nbsp;
                        <label class="normalLabel"><input type="radio" name="eyes" value="Sunken"> Sunken</label>
                        &nbsp; &nbsp;
                        <label class="normalLabel"><input type="radio" name="eyes" value="Discharge"> Discharge</label>
                    </td>
                    <td>
                        <label>Dehydration</label>
                    </td>
                    <td colspan="3">
                        <label class="normalLabel"><input type="radio" name="dehydration" value="None"> None</label>
                        &nbsp; &nbsp;
                        <label class="normalLabel"><input type="radio" name="dehydration" value="Moderate"> Moderate</label>
                        &nbsp; &nbsp;
                        <label class="normalLabel"><input type="radio" name="dehydration" value="Severe"> Severe</label>
                    </td>
                </tr>
                <tr>
                    <td><label>Conjuctiva</label></td>
                    <td colspan="3">
                        <label class="normalLabel"><input type="radio" name="conjuctiva" value="Normal"> Normal</label>
                        &nbsp; &nbsp;
                        <label class="normalLabel"><input type="radio" name="conjuctiva" value="Pale"> Pale</label>
                    </td>
                    <td><label>Mouth</label></td>
                    <td colspan="3">
                        <label class="normalLabel"><input type="radio" name="mouth" value="Normal"> Normal</label>
                        &nbsp; &nbsp;
                        <label class="normalLabel"><input type="radio" name="mouth" value="Sores"> Sores</label>
                        &nbsp; &nbsp;
                        <label class="normalLabel"><input type="radio" name="mouth" value="Candida"> Candida</label>
                    </td>
                </tr>
                <tr>
                    <td><label>Ears</label></td>
                    <td colspan="3">
                        <label class="normalLabel"><input type="radio" name="ears" value="Normal"> Normal</label>
                        &nbsp; &nbsp;
                        <label class="normalLabel"><input type="radio" name="ears" value="Discharge"> Discharge</label>
                    </td>
                    <td>
                        <label>Disability</label>
                    </td>
                    <td colspan="3">
                        <label class="normalLabel"><input type="radio" name="disability" value="1"> Yes</label>
                        &nbsp; &nbsp;
                        <label class="normalLabel"><input type="radio" name="disability" value="0"> No</label>
                    </td>
                </tr>
                <tr>
                    <td><label>Skin Changes</label></td>
                    <td colspan="4">
                        <label class="normalLabel"><input type="radio" name="skin_changes" value="None"> None</label>
                        &nbsp; &nbsp;
                        <label class="normalLabel"><input type="radio" name="skin_changes" value="Scabies"> Scabies</label>
                        &nbsp; &nbsp;
                        <label class="normalLabel"><input type="radio" name="skin_changes" value="Peeling"> Peeling</label>
                        &nbsp; &nbsp;
                        <label class="normalLabel"><input type="radio" name="skin_changes" value="Ulcer/Abscesses"> Ulcer/Abscesses</label>
                    </td>
                    <td>
                        <label>Extremities</label>
                    </td>
                    <td colspan="2">
                        <label class="normalLabel"><input type="radio" name="extremities" value="Normal"> Normal</label>
                        &nbsp; &nbsp;
                        <label class="normalLabel"><input type="radio" name="extremities" value="Cold"> Cold</label>
                    </td>
                </tr>
                <tr>
                    <td><label>Appetite Test</label></td>
                    <td colspan="2">
                        <label class="normalLabel"><input type="radio" name="appetite_test" value="Pass"> Pass</label>
                        &nbsp; &nbsp;
                        <label class="normalLabel"><input type="radio" name="appetite_test" value="Fail"> Fail</label>
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
                    <td colspan="2">
                        <input type="text" name="drug1" class="smallInput" style="width: 100%" />
                    </td>
                    <td colspan="2">
                        <input type="date" name="dateAdmission1" class="smallInput" style="width: 100%" />
                    </td>
                    <td colspan="3">
                        <input type="text" name="dosage1" class="smallInput" style="width: 100%" />
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="text" name="drug2" class="smallInput" style="width: 100%" />
                    </td>
                    <td colspan="2">
                        <input type="date" name="dateAdmission2" class="smallInput" style="width: 100%" />
                    </td>
                    <td colspan="3">
                        <input type="text" name="dosage2" class="smallInput" style="width: 100%" />
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="text" name="drug3" class="smallInput" style="width: 100%" />
                    </td>
                    <td colspan="2">
                        <input type="date" name="dateAdmission3" class="smallInput" style="width: 100%" />
                    </td>
                    <td colspan="3">
                        <input type="text" name="dosage3" class="smallInput" style="width: 100%" />
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="text" name="drug4" class="smallInput" style="width: 100%" />
                    </td>
                    <td colspan="2">
                        <input type="date" name="dateAdmission4" class="smallInput" style="width: 100%" />
                    </td>
                    <td colspan="3">
                        <input type="text" name="dosage4" class="smallInput" style="width: 100%" />
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
                <tr>
                    <td><label>Date</label></td>
                    @for($i=1;$i<18;$i++)
                        <td>
                            <input type="date" name="date{{ $i }}" class="smallInput" style="width: 100%">
                        </td>
                    @endfor
                </tr>
                <tr>
                    <th colspan="18">Anthropometry</th>
                </tr>
                <tr>
                    <td><label>Weight (kg)</label></td>
                    @for($i=1;$i<18;$i++)
                        <td>
                            <input type="text" name="weightKG{{ $i }}" class="smallInput" style="width: 100%">
                        </td>
                    @endfor
                </tr>
                <tr>
                    <td><label>Weight loss * (Y/N)</label></td>
                    @for($i=1;$i<18;$i++)
                        <td>
                            <input type="text" name="weightLoss{{ $i }}" class="smallInput" style="width: 100%">
                        </td>
                    @endfor
                </tr>
                <tr>
                    <td><label>MUAC (cm)</label></td>
                    @for($i=1;$i<18;$i++)
                        <td>
                            <input type="text" name="muac{{ $i }}" class="smallInput" style="width: 100%">
                        </td>
                    @endfor
                </tr>
                <tr>
                    <td><label>Edema (+ ++ +++)</label></td>
                    @for($i=1;$i<18;$i++)
                        <td>
                            <input type="text" name="edemaBack{{ $i }}" class="smallInput" style="width: 100%">
                        </td>
                    @endfor
                </tr>
                <tr>
                    <td><label>Length/Height</label></td>
                    @for($i=1;$i<18;$i++)
                        <td>
                            <input type="text" name="length_height{{ $i }}" class="smallInput" style="width: 100%">
                        </td>
                    @endfor
                </tr>
                <tr>
                    <td><label>WHZ</label></td>
                    @for($i=1;$i<18;$i++)
                        <td>
                            <input type="text" name="whz{{ $i }}" class="smallInput" style="width: 100%">
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
                    @for($i=1;$i<18;$i++)
                        <td>
                            <input type="text" name="diarrheaDays{{ $i }}" class="smallInput" style="width: 100%">
                        </td>
                    @endfor
                </tr>
                <tr>
                    <td><label>Vomiting (#days)</label></td>
                    @for($i=1;$i<18;$i++)
                        <td>
                            <input type="text" name="vomiting_days{{ $i }}" class="smallInput" style="width: 100%">
                        </td>
                    @endfor
                </tr>
                <tr>
                    <td><label>Fever (#days)</label></td>
                    @for($i=1;$i<18;$i++)
                        <td>
                            <input type="text" name="fever_days{{ $i }}" class="smallInput" style="width: 100%">
                        </td>
                    @endfor
                </tr>
                <tr>
                    <td><label>Cough (#days)</label></td>
                    @for($i=1;$i<18;$i++)
                        <td>
                            <input type="text" name="cough_days{{ $i }}" class="smallInput" style="width: 100%">
                        </td>
                    @endfor
                </tr>
                <tr>
                    <th colspan="18">Physical Examination</th>
                </tr>
                <tr>
                    <td><label>Temperature (C)</label></td>
                    @for($i=1;$i<18;$i++)
                        <td>
                            <input type="text" name="temperatureDays{{ $i }}" class="smallInput" style="width: 100%">
                        </td>
                    @endfor
                </tr>
                <tr>
                    <td><label>Respiration Rate (# / min)</label></td>
                    @for($i=1;$i<18;$i++)
                        <td>
                            <input type="text" name="respirationRate{{ $i }}" class="smallInput" style="width: 100%">
                        </td>
                    @endfor
                </tr>
                <tr>
                    <td><label>Dehydrated (Y/ N)</label></td>
                    @for($i=1;$i<18;$i++)
                        <td>
                            <input type="text" name="dehydrated{{ $i }}" class="smallInput" style="width: 100%">
                        </td>
                    @endfor
                </tr>
                <tr>
                    <td><label>Anemia (Y/N)</label></td>
                    @for($i=1;$i<18;$i++)
                        <td>
                            <input type="text" name="anemia{{ $i }}" class="smallInput" style="width: 100%">
                        </td>
                    @endfor
                </tr>
                <tr>
                    <td><label>Skin Infection (Y/N)</label></td>
                    @for($i=1;$i<18;$i++)
                        <td>
                            <input type="text" name="skin_infection{{ $i }}" class="smallInput" style="width: 100%">
                        </td>
                    @endfor
                </tr>
                <tr>
                    <td><label>Appetite Test (Pass/Fail)</label></td>
                    @for($i=1;$i<18;$i++)
                        <td>
                            <input type="text" name="appetite_test_day{{ $i }}" class="smallInput" style="width: 100%">
                        </td>
                    @endfor
                </tr>
                <tr>
                    <td><label>Action Needed (Y/N)</label></td>
                    @for($i=1;$i<18;$i++)
                        <td>
                            <input type="text" name="action_needed{{ $i }}" class="smallInput" style="width: 100%">
                        </td>
                    @endfor
                </tr>
                <tr>
                    <td><label>Appetite Test (Pass/Fail) (note below)</label></td>
                    @for($i=1;$i<18;$i++)
                        <td>
                            <input type="text" name="appetite_test_pass_fail{{ $i }}" class="smallInput" style="width: 100%">
                        </td>
                    @endfor
                </tr>
                <tr>
                    <td><label>Other Medication (see front of card)</label></td>
                    @for($i=1;$i<18;$i++)
                        <td>
                            <input type="text" name="other_medication{{ $i }}" class="smallInput" style="width: 100%">
                        </td>
                    @endfor
                </tr>
                <tr>
                    <td><label>RUTF (#sachets)</label></td>
                    @for($i=1;$i<18;$i++)
                        <td>
                            <input type="text" name="rutf{{ $i }}" class="smallInput" style="width: 100%">
                        </td>
                    @endfor
                </tr>
                <tr>
                    <td><label>Name of Examiner</label></td>
                    @for($i=1;$i<18;$i++)
                        <td>
                            <input type="text" name="examiner{{ $i }}" class="smallInput" style="width: 100%">
                        </td>
                    @endfor
                </tr>
                <tr>
                    <td><label>OUTCOME ***</label></td>
                    @for($i=1;$i<18;$i++)
                        <td>
                            <input type="text" name="outcome{{ $i }}" class="smallInput" style="width: 100%">
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
                <button type="submit" class="btn btn-success btnSave" title="Click to save">
                    <i class="fa fa-save"></i>
                </button>
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
