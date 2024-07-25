@component('partials/header')

    @slot('title')
        PIS | Patient Information
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/css/doctors/reset.css') }}" rel="stylesheet" />
    @if(Auth::user()->theme == 2)
        <link href="{{ asset('public/css/doctors/darkstyle.css') }}" rel="stylesheet" />
    @else
        <link href="{{ asset('public/css/doctors/greenstyle.css') }}" rel="stylesheet" />
    @endif
    <link href="{{ asset('public/plugins/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/doctors/patientinfo.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/doctors/diabetes.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/plugins/css/jquery-ui.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/plugins/wickedpicker/dist/wickedpicker.min.css') }}" rel="stylesheet" />
@endsection



@section('header')
    @include('doctors.navigation')
@stop



@section('content')
    @component('doctors.dashboard')
@section('main-content')

<div class="content-wrapper" style="padding: 43px 10px 0px;">


        @include('ancillary.loader')

        <br>
        <div class="panel panel-default">
            <div class="panel-body diabetes-panel-body" style="overflow: auto;">

            <input type="hidden" class="checkhasrecord" value="{{ $count <= 2 ? '' : '1' }}">

            <form class="diabetes-info">
                <!-- hidden inputs -->
                @if($diabetesInfo)
                    <input type="hidden" class="hidden-did" name="id" value="{{ $diabetesInfo->id }}">
                @endif
                <input type="hidden" name="pid" class="patient_id" value="{{ $pid }}">
                <!-- end -->
                <table class="table table-bordered table-condensed">
                    <tr>
                        <td colspan="2"><b>Patient:</b> {{ $patientsInfo[0]->first_name.' '.substr($patientsInfo[0]->middle_name, 0, 1).'.'.$patientsInfo[0]->last_name }}</td>
                        <td colspan="2"><b>Hospital Number:</b> {{ $patientsInfo[0]->hospital_no }}</td>
                    </tr>
                    <tr>
                        <td colspan="4"><b>Address:</b> {{ $patientsInfo[0]->address }}</td>
                    </tr>
                    <tr>
                        <td><b>Sex:</b> Male</td>
                        <td colspan="3"><b>Civil Status:</b> {{ $patientsInfo[0]->civil_status }}</td>
                    </tr>
                    <tr>
                        <td><b>Contact No:</b> {{ $patientsInfo[0]->contact_no }}</td>
                        <td><b>Birth Date:</b> {{ Carbon::parse($patientsInfo[0]->birthday)->toFormattedDateString() }}</td>
                        <td colspan="2"><b>Region:</b> {{ $patientsInfo[0]->regDesc }}</td>
                    </tr>
                    <tr>
                        <td><b>Religion:</b> <input type="text" name="religion" class="form-control input-sm religion" value="{{ $diabetesInfo ? $diabetesInfo->religion ? $diabetesInfo->religion : '' : '' }}" style="display: inline-block;"></td>
                        <td><b>Race:</b> <input type="text" name="race" class="form-control input-sm race" value="{{ $diabetesInfo ? $diabetesInfo->race ? $diabetesInfo->race : '' : '' }}" style="display: inline-block;"></td>
                        <td><b>Occupation:</b> <input type="text" name="occupation" class="form-control input-sm occupation" value="{{ $diabetesInfo ? $diabetesInfo->occupation ? $diabetesInfo->occupation : '' : '' }}" style="display: inline-block;"></td>
                        <td><b>Age as of first visit:</b> <input type="number" name="agefirstvisit" class="form-control input-sm agefirstvisit" value="{{ $diabetesInfo ? $diabetesInfo->agefirstvisit ? $diabetesInfo->agefirstvisit : '' : '' }}" style="display: inline-block;"></td>
                    </tr>
                    <tr>
                        <td colspan="4"><b>Contact Person in case of Emergency w/ Contact Number:</b> <input type="text" name="contactperson" class="form-control input-sm contactperson" value="{{ $diabetesInfo ? $diabetesInfo->contactperson ? $diabetesInfo->contactperson : '' : '' }}" style="display: inline-block;"></td>
                    </tr>
                </table>

            <div id="accordion">
              <h3>I. MEDICAL HISTORY</h3>
              <div style="padding: 10px;">
                <!-- <h4>I. MEDICAL HISTORY</h4> -->
                <div class="col-sm-6" style="padding-left: 0px;">
                    <table class="table table-bordered table-condensed">
                        <tr>
                            <td colspan="6" class="ABackground">A. Background</td>
                        </tr>
                        <tr>
                            <td colspan="6">
                                <input type="radio" class="abackground" name="diagnosisstatus" id="ndd" value="yes"
                                 {{ $diabetesInfo ? $diabetesInfo->diagnosisstatus == 'yes' ? 'checked' : '' : '' }}>
                                <label class="radioLabel" for="ndd">Newly diagnosed diabetes</label>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" width="50" class="text-right">Date of diagnosis:</td>
                            <td colspan="3" width="50" class="diabetes-input" >
                                <input type="text" class="form-control input-sm date_picker datediagnosis disabled" 
                                value="{{ $diabetesInfo ? $diabetesInfo->diagnosisstatus == 'yes' ? Carbon::parse($diabetesInfo->created_at)->format('m/d/Y') : '' : '' }}" 
                                {{ $diabetesInfo ? $diabetesInfo->diagnosisstatus == 'yes' ? '' : 'disabled' : '' }}>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6">
                                <input type="radio" class="abackground" name="diagnosisstatus" id="pdd" value="no" {{ $diabetesInfo ? $diabetesInfo->diagnosisstatus == 'no' ? 'checked' : '' : '' }}>
                                <label class="radioLabel" for="pdd">Previously diagnosed diabetes</label>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-right">Duration of diabetes:</td>
                            <td colspan="3" class="diabetes-input">
                                <input type="text" name="diabetesduration" class="form-control input-sm disabled" value="{{ $diabetesInfo ? $diabetesInfo->diagnosisstatus == 'no' ? $diabetesInfo->diabetesduration : '' : '' }}" {{ $diabetesInfo ? $diabetesInfo->diagnosisstatus == 'no' ? '' : 'disabled' : 'disabled' }}>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-right">Age of diagnosis:</td>
                            <td colspan="3" class="diabetes-input"><input type="text" name="diagnosisage" class="form-control input-sm disabled" value="{{ $diabetesInfo ? $diabetesInfo->diagnosisstatus == 'no' ? $diabetesInfo->diagnosisage : '' : '' }}" {{ $diabetesInfo ? $diabetesInfo->diagnosisstatus == 'no' ? '' : 'disabled' : 'disabled' }}></td>
                        </tr>
                        <tr>
                            <td colspan="6"><b>Did the patient suspect he/she had diabetes at the time of diagnosis?</b></td>
                        </tr>
                        <tr>
                            <td colspan="3"><input type="radio" name="didpatientsuspect" value="yes" id="yesTimeDiagnosis" {{ $diabetesInfo ? $diabetesInfo->didpatientsuspect == 'yes' ? 'checked' : '' : '' }}> <label class="radioLabel2" for="yesTimeDiagnosis">Yes</label></td>
                            <td colspan="3"><input type="radio" name="didpatientsuspect" value="no" {{ $diabetesInfo ? $diabetesInfo->didpatientsuspect == 'no' ? 'checked' : '' : '' }} id="noTimeDiagnosis"> <label class="radioLabel2" for="noTimeDiagnosis">No</label></td>
                        </tr>
                        <tr>
                            <td colspan="6"><b>Type of Diabetes</b></td>
                        </tr>
                        <tr>
                            <td colspan="2"><input type="radio" class="typeOfDiabetes" value="1" name="diabetistype" id="type1Diabetes" {{ $diabetesInfo ? $diabetesInfo->diabetistype == '1' ? 'checked' : '' : '' }}> <label class="radioLabel2" for="type1Diabetes">Type 1</label></td>
                            <td colspan="2"><input type="radio" class="typeOfDiabetes" value="2" name="diabetistype" id="type2Diabetes" {{ $diabetesInfo ? $diabetesInfo->diabetistype == '2' ? 'checked' : '' : '' }}> <label class="radioLabel2" for="type2Diabetes">Type 2</label></td>
                            <td colspan="2"><input type="radio" class="typeOfDiabetes" value="3" name="diabetistype" id="type3Diabetes" {{ $diabetesInfo ? $diabetesInfo->diabetistype == '3' ? 'checked' : '' : '' }}> <label class="radioLabel2" for="type3Diabetes">Type 3</label></td>
                        </tr>
                        <tr>
                            <td colspan="6" width="20"><input type="radio" class="typeOfDiabetes otherstypeOfDiabetes" value="4" name="diabetistype" id="typeOther" {{ $diabetesInfo ? $diabetesInfo->diabetistype == '4' ? 'checked' : '' : '' }}> <label class="radioLabel2" for="typeOther">Others:</label>
                                <textarea name="diabetistypeotherscontent" class="form-control input-sm" {{ $diabetesInfo ? $diabetesInfo->diabetistype == '4' ? '' : 'disabled' : 'disabled' }}>{{ $diabetesInfo ? $diabetesInfo->diabetistypeotherscontent  ? $diabetesInfo->diabetistypeotherscontent : '' : '' }}</textarea>
                            </td>
                        </tr>
                    </table>
                    <table class="table table-bordered table-condensed">
                        <tr>
                            <td colspan="6" class="BDiabetesEducation">B. Diabetes Education</td>
                        </tr>
                        <tr>
                            <td colspan="6">Has the patient attended any diabetes education session?</td>
                        </tr>
                        <tr>
                            <td colspan="3"><input type="radio" name="haspatientattendedanysession" id="hasAttendedSessionYes" value="yes" {{ $diabetesInfo ? $diabetesInfo->haspatientattendedanysession == 'yes' ? 'checked' : '' : '' }}> <label class="radioLabel2" for="hasAttendedSessionYes">Yes</label></td>
                            <td colspan="3"><input type="radio" name="haspatientattendedanysession" id="hasAttendedSessionNo" value="no" {{ $diabetesInfo ? $diabetesInfo->haspatientattendedanysession == 'no' ? 'checked' : '' : '' }}> <label class="radioLabel2" for="hasAttendedSessionNo">No</label></td>
                        </tr>
                    </table>
                </div>
                <div class="col-sm-6" style="padding-left: 0px;padding-right: 0px">
                    <table class="table table-bordered table-condensed">
                        <tr>
                            <td colspan="2" class="CCurrentTreatment">C. Current Treatment <span><kbd>(check all that apply)</i></kbd></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="checkbox" name="medicalnutritiontherapy" class="cMedicalNutritionTherapy" id="medicalNutritionTherapy" value="{{ $diabetesInfo ? $diabetesInfo->medicalnutritiontherapy == 'yes' ? 'yes' : 'no' : 'no' }}" {{ $diabetesInfo ? $diabetesInfo->medicalnutritiontherapy == 'yes' ? 'checked' : '' : '' }}>
                                <label class="radioLabel" for="medicalNutritionTherapy">Medical Nutrition Therapy</label>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="" width="200" class="text-right">Total Caloric Requirements:</td>
                            <td colspan="" class="diabetes-input">
                                <input type="text" name="totalcaloricrequirements" class="form-control input-sm" value="{{ $diabetesInfo ? $diabetesInfo->totalcaloricrequirements ? $diabetesInfo->totalcaloricrequirements : '' : '' }}" {{ $diabetesInfo ? $diabetesInfo->medicalnutritiontherapy == 'yes' ? '' : 'disabled' : 'disabled' }}>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="" class="text-right">Meals:</td>
                            <td colspan="" class="diabetes-input">
                                <input type="text" name="meals" class="form-control input-sm" value="{{ $diabetesInfo ? $diabetesInfo->meals ? $diabetesInfo->meals : '' : '' }}" {{ $diabetesInfo ? $diabetesInfo->medicalnutritiontherapy == 'yes' ? '' : 'disabled' : 'disabled' }}>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="" class="text-right">Snacks:</td>
                            <td colspan="" class="diabetes-input">
                                <input type="text" name="snacks" class="form-control input-sm" value="{{ $diabetesInfo ? $diabetesInfo->snacks ? $diabetesInfo->snacks : '' : '' }}" {{ $diabetesInfo ? $diabetesInfo->medicalnutritiontherapy == 'yes' ? '' : 'disabled' : 'disabled' }}>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="" class="text-right">CHO:</td>
                            <td colspan="" class="diabetes-input">
                                <input type="text" name="cho" class="form-control input-sm" value="{{ $diabetesInfo ? $diabetesInfo->cho ? $diabetesInfo->cho : '' : '' }}" {{ $diabetesInfo ? $diabetesInfo->medicalnutritiontherapy == 'yes' ? '' : 'disabled' : 'disabled' }}>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="" class="text-right">CHON:</td>
                            <td colspan="" class="diabetes-input">
                                <input type="text" name="chon" class="form-control input-sm" value="{{ $diabetesInfo ? $diabetesInfo->chon ? $diabetesInfo->chon : '' : '' }}" {{ $diabetesInfo ? $diabetesInfo->medicalnutritiontherapy == 'yes' ? '' : 'disabled' : 'disabled' }}>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="" class="text-right">Fats:</td>
                            <td colspan="" class="diabetes-input">
                                <input type="text" name="fats" class="form-control input-sm" value="{{ $diabetesInfo ? $diabetesInfo->fats ? $diabetesInfo->fats : '' : '' }}" {{ $diabetesInfo ? $diabetesInfo->medicalnutritiontherapy == 'yes' ? '' : 'disabled' : 'disabled' }}>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="" width="50">
                                <input type="checkbox" class="cPhysicalActivity" name="physicalactivity" id="physicalActivity" value="{{ $diabetesInfo ? $diabetesInfo->physicalactivity == 'yes' ? 'yes' : 'no' : 'no' }}" {{ $diabetesInfo ? $diabetesInfo->physicalactivity == 'yes' ? 'checked' : '' : '' }}>
                                <label class="radioLabel" for="physicalActivity">Physical Activity</label>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="" width="1" class="text-right">Mins/day:</td>
                            <td colspan="" class="diabetes-input">
                                <input type="text" name="minsday" class="form-control input-sm" value="{{ $diabetesInfo ? $diabetesInfo->minsday ? $diabetesInfo->minsday : '' : '' }}" {{ $diabetesInfo ? $diabetesInfo->physicalactivity == 'yes' ? '' : 'disabled' : 'disabled' }}>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="" class="text-right">Frequency/week:</td>
                            <td colspan="" class="diabetes-input">
                                <input type="text" name="frequency" class="form-control input-sm" value="{{ $diabetesInfo ? $diabetesInfo->frequency ? $diabetesInfo->frequency : '' : '' }}" {{ $diabetesInfo ? $diabetesInfo->physicalactivity == 'yes' ? '' : 'disabled' : 'disabled' }}>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" width="50">
                                <input type="checkbox" class="coralAntidiabetic" name="oralantidiabetic" id="oralAntidiabetic" value="{{ $diabetesInfo ? $diabetesInfo->oralantidiabetic == 'yes' ? 'yes' : 'no' : 'no' }}" {{ $diabetesInfo ? $diabetesInfo->oralantidiabetic == 'yes' ? 'checked' : '' : '' }}>
                                <label class="radioLabel" for="oralAntidiabetic">Oral Antidiabetic</label></td>
                        </tr>
                        <tr>
                            <td colspan="" class="text-right">
                                <input type="checkbox" name="sulfonylureas" id="sulfonylureas" value="{{ $diabetesInfo ? $diabetesInfo->sulfonylureas == 'yes' ? 'yes' : '' : '' }}" {{ $diabetesInfo ? $diabetesInfo->sulfonylureas == 'yes' ? 'checked' : '' : 'disabled' }} {{  $diabetesInfo ? $diabetesInfo->oralantidiabetic == 'yes' ? '' : 'disabled' : 'disabled' }}>
                                <label class="radioLabel2" for="sulfonylureas">Sulfonylureas</label>
                            </td>
                            <td colspan="" class="diabetes-input">
                                <div class="input-group input-group-sm">
                                  <input type="text" name="sulfonylureasMgday" class="form-control" placeholder="" aria-describedby="basic-addon2" value="{{ $diabetesInfo ? $diabetesInfo->sulfonylureasMgday ? $diabetesInfo->sulfonylureasMgday : '' : '' }}">
                                  <span class="input-group-addon" id="basic-addon2">mg/day</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="" class="text-right">
                                <input type="checkbox" name="metformin" id="Metformin" value="{{ $diabetesInfo ? $diabetesInfo->metformin == 'yes' ? 'yes' : 'no' : 'no' }}" {{ $diabetesInfo ? $diabetesInfo->metformin == 'yes' ? 'checked' : '' : 'disabled' }}  {{  $diabetesInfo ? $diabetesInfo->oralantidiabetic == 'yes' ? '' : 'disabled' : 'disabled' }}>
                                <label class="radioLabel2" for="Metformin">Metformin</label>
                            </td>
                            <td colspan="" class="diabetes-input">
                                <div class="input-group input-group-sm">
                                  <input type="text" name="metforminMgday" class="form-control" placeholder="" aria-describedby="basic-addon2" value="{{ $diabetesInfo ? $diabetesInfo->metforminMgday ? $diabetesInfo->metforminMgday : '' : '' }}">
                                  <span class="input-group-addon" id="basic-addon2">mg/day</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="" class="text-right">
                                <input type="checkbox" name="acarbose" id="acarbose" value="{{ $diabetesInfo ? $diabetesInfo->acarbose == 'yes' ? 'yes' : 'no' : 'no' }}" {{ $diabetesInfo ? $diabetesInfo->acarbose == 'yes' ? 'checked' : '' : 'disabled' }}  {{  $diabetesInfo ? $diabetesInfo->oralantidiabetic == 'yes' ? '' : 'disabled' : 'disabled' }}> <label class="radioLabel2" for="acarbose">acarbose</label>
                            </td>
                            <td colspan="" class="diabetes-input">
                                <div class="input-group input-group-sm">
                                  <input type="text" name="acarboseMgday" class="form-control" placeholder="" aria-describedby="basic-addon2" value="{{ $diabetesInfo ? $diabetesInfo->acarboseMgday ? $diabetesInfo->acarboseMgday : '' : '' }}">
                                  <span class="input-group-addon" id="basic-addon2">mg/day</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="" class="text-right">
                                <input type="checkbox" name="tzd" id="TZD" value="{{ $diabetesInfo ? $diabetesInfo->tzd == 'yes' ? 'yes' : 'no' : 'no' }}" {{ $diabetesInfo ? $diabetesInfo->tzd == 'yes' ? 'checked' : '' : 'disabled' }}  {{  $diabetesInfo ? $diabetesInfo->oralantidiabetic == 'yes' ? '' : 'disabled' : 'disabled' }}> <label class="radioLabel2" for="TZD">TZD</label>
                            </td>
                            <td colspan="" class="diabetes-input">
                                <div class="input-group input-group-sm">
                                  <input type="text" name="tzdMgday" class="form-control" placeholder="" aria-describedby="basic-addon2" value="{{ $diabetesInfo ? $diabetesInfo->tzdMgday ? $diabetesInfo->tzdMgday : '' : '' }}">
                                  <span class="input-group-addon" id="basic-addon2">mg/day</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="" class="text-right">
                                <input type="checkbox" name="oralantidiabeticothers" id="oralantidiabeticothers" value="{{ $diabetesInfo ? $diabetesInfo->oralantidiabeticothers == 'yes' ? 'yes' : 'no' : 'no' }}" {{ $diabetesInfo ? $diabetesInfo->oralantidiabeticothers == 'yes' ? 'checked' : '' : 'disabled' }}  {{  $diabetesInfo ? $diabetesInfo->oralantidiabetic == 'yes' ? '' : 'disabled' : 'disabled' }}> <label class="radioLabel2" for="oralantidiabeticothers">Others: Specify</label>
                            </td>
                            <td colspan="">
                                <textarea name="oralantidiabeticotherscontent" class="form-control input-sm" {{ $diabetesInfo ? $diabetesInfo->oralantidiabetic == 'yes' ? '' : 'disabled' : 'disabled' }}>{{ $diabetesInfo ? $diabetesInfo->oralantidiabeticotherscontent ? $diabetesInfo->oralantidiabeticotherscontent : '' : '' }}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="" width="50" class="text-right"><input type="checkbox" class="cinsulin" name="insulin" id="insulin" value="{{ $diabetesInfo ? $diabetesInfo->insulin == 'yes' ? 'yes' : 'no' : 'no' }}" {{ $diabetesInfo ? $diabetesInfo->insulin == 'yes' ? 'checked' : '' : '' }}> <label class="radioLabel" for="insulin">Insulin</label></td>
                            <td colspan="" class="diabetes-input" width="50">
                                <div class="input-group input-group-sm">
                                  <input type="text" name="insulintypeunits" class="form-control" aria-describedby="basic-addon2" value="{{ $diabetesInfo ? $diabetesInfo->insulintypeunits ? $diabetesInfo->insulintypeunits : '' : '' }}" {{ $diabetesInfo ? $diabetesInfo->insulin == 'yes' ? '' : 'disabled' : 'disabled' }}>
                                  <span class="input-group-addon" id="basic-addon2">Type, units/day</span>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6" style="padding-left: 0px;">
                    <table class="table table-bordered table-condensed">
                        <tr>
                            <td colspan="6" class="DOtherMedicalConditions">D. Other Medical Conditions</td>
                        </tr>
                        <tr>
                            <td colspan="1"></td>
                            <td colspan="1" class="text-center"><b>Date Diagnosed</b></td>
                            <td colspan="4"><b>Medications</b></td>
                        </tr>
                        <tr>
                            <td colspan="1" rowspan="4" width="110">
                                <input type="checkbox" class="dhypertension" name="hypertension_d" id="hypertension" 
                                value="{{ $diabetesInfo ? $diabetesInfo->hypertension_d == 'yes' ? 'yes' : 'no' : 'no' }}" 
                                {{ $diabetesInfo ? $diabetesInfo->hypertension_d == 'yes' ? 'checked' : '' : '' }}>
                                <label class="radioLabel2" for="hypertension">Hypertension</label>
                            </td>
                            <td colspan="1" rowspan="4" width="120" class="diabetes-date">
                                <input type="text" name="hypertensiondate" class="form-control date_picker input-sm" 
                                value="{{ $diabetesInfo ? $diabetesInfo->hypertensiondate ? Carbon::parse($diabetesInfo->hypertensiondate)->format('m/d/Y') : '' : '' }}" 
                                {{ $diabetesInfo ? $diabetesInfo->hypertension_d == 'yes' ? '' : 'disabled' : 'disabled' }}>
                            </td>
                            <td colspan="2" width="180">
                                <input type="checkbox" name="aceinhibitor_d" id="ACEinhibitor" 
                                value="{{ $diabetesInfo ? $diabetesInfo->aceinhibitor_d == 'yes' ? 'yes' : 'no' : 'no' }}" 
                                {{ $diabetesInfo ? $diabetesInfo->aceinhibitor_d == 'yes' ? 'checked' : '' : '' }} 
                                {{ $diabetesInfo ? $diabetesInfo->hypertension_d == 'yes' ? '' : 'disabled' : 'disabled' }}>
                                <label class="radioLabel2" for="ACEinhibitor">ACE inhibitor</label>
                            </td>
                            <td colspan="2" class="diabetes-input">
                                <div class="input-group input-group-sm">
                                  <input type="text" name="aceinhibitorMgday" class="form-control" aria-describedby="basic-addon2" 
                                  value="{{ $diabetesInfo ? $diabetesInfo->aceinhibitorMgday ? $diabetesInfo->aceinhibitorMgday : '' : '' }}" 
                                  {{ $diabetesInfo ? $diabetesInfo->hypertension_d == 'yes' ? '' : 'disabled' : 'disabled' }}>
                                  <span class="input-group-addon" id="basic-addon2">mg/day</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="checkbox" name="arb" id="ARB" 
                                value="{{ $diabetesInfo ? $diabetesInfo->arb == 'yes' ? 'yes' : 'no' : 'no' }}" 
                                {{ $diabetesInfo ? $diabetesInfo->arb == 'yes' ? 'checked' : '' : '' }} 
                                {{ $diabetesInfo ? $diabetesInfo->hypertension_d == 'yes' ? '' : 'disabled' : 'disabled' }}>
                                <label class="radioLabel2" for="ARB">ARB</label>
                            </td>
                            <td colspan="2" class="diabetes-input">
                                <div class="input-group input-group-sm">
                                  <input type="text" name="arbMgday" class="form-control" aria-describedby="basic-addon2" 
                                  value="{{ $diabetesInfo ? $diabetesInfo->arbMgday ? $diabetesInfo->arbMgday : '' : '' }}" 
                                  {{ $diabetesInfo ? $diabetesInfo->hypertension_d == 'yes' ? '' : 'disabled' : 'disabled' }}>
                                  <span class="input-group-addon" id="basic-addon2">mg/day</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="checkbox" name="hypertensiondateothers" id="hOthers" 
                                value="{{ $diabetesInfo ? $diabetesInfo->hypertensiondateothers == 'yes' ? 'yes' : 'no' : 'no' }}" 
                                {{ $diabetesInfo ? $diabetesInfo->hypertensiondateothers == 'yes' ? 'checked' : '' : '' }} 
                                {{ $diabetesInfo ? $diabetesInfo->hypertension_d == 'yes' ? '' : 'disabled' : 'disabled' }}>
                                <label class="radioLabel2" for="hOthers">Others: Specify</label>
                            </td>
                            <td colspan="2" class="diabetes-input">
                                <div class="input-group input-group-sm">
                                  <input type="text" name="hypertensionothersMgday" class="form-control" aria-describedby="basic-addon2" 
                                  value="{{ $diabetesInfo ? $diabetesInfo->hypertensionothersMgday ? $diabetesInfo->hypertensionothersMgday : '' : '' }}" 
                                  {{ $diabetesInfo ? $diabetesInfo->hypertension_d == 'yes' ? '' : 'disabled' : 'disabled' }}>
                                  <span class="input-group-addon" id="basic-addon2">mg/day</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="diabetes-input">
                                <div class="input-group input-group-sm bg-danger">
                                  <input type="text" name="hypertensionothersMgday2" class="form-control" aria-describedby="basic-addon2" 
                                  value="{{ $diabetesInfo ? $diabetesInfo->hypertensionothersMgday2 ? $diabetesInfo->hypertensionothersMgday2 : '' : '' }}" 
                                  {{ $diabetesInfo ? $diabetesInfo->hypertension_d == 'yes' ? '' : 'disabled' : 'disabled' }}>
                                  <span class="input-group-addon" id="basic-addon2">mg/day</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1" rowspan="3">
                                <input type="checkbox" class="ddyslipidemia" name="dyslipidemia" id="dyslipidemia" 
                                value="{{ $diabetesInfo ? $diabetesInfo->dyslipidemia == 'yes' ? 'yes' : 'no' : 'no' }}" 
                                {{ $diabetesInfo ? $diabetesInfo->dyslipidemia == 'yes' ? 'checked' : '' : '' }}>
                                <label class="radioLabel2" for="dyslipidemia">Dyslipidemia</label>
                            </td>
                            <td colspan="1" rowspan="3" class="diabetes-date">
                                <input type="text" name="dyslipidemiadate" class="form-control date_picker ddyslipidemiaDate input-sm" 
                                value="{{ $diabetesInfo ? $diabetesInfo->dyslipidemiadate ? Carbon::parse($diabetesInfo->dyslipidemiadate)->format('m/d/Y') : '' : '' }}" 
                                {{ $diabetesInfo ? $diabetesInfo->dyslipidemia == 'yes' ? '' : 'disabled' : 'disabled' }}></td>
                            <td colspan="2">
                                <input type="checkbox" name="statin" id="Statin" 
                                value="{{ $diabetesInfo ? $diabetesInfo->statin == 'yes' ? 'yes' : 'no' : 'no' }}" 
                                {{ $diabetesInfo ? $diabetesInfo->statin == 'yes' ? 'checked' : '' : '' }} 
                                {{ $diabetesInfo ? $diabetesInfo->dyslipidemia == 'yes' ? '' : 'disabled' : 'disabled' }}>
                                <label class="radioLabel2" for="Statin">Statin</label>
                            </td>
                            <td colspan="2" class="diabetes-input">
                                <div class="input-group input-group-sm">
                                  <input type="text" name="statinMgday" class="form-control" placeholder="" aria-describedby="basic-addon2" 
                                  value="{{ $diabetesInfo ? $diabetesInfo->statinMgday ? $diabetesInfo->statinMgday : '' : '' }}" 
                                  {{ $diabetesInfo ? $diabetesInfo->dyslipidemia == 'yes' ? '' : 'disabled' : 'disabled' }}>
                                  <span class="input-group-addon" id="basic-addon2">mg/day</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="checkbox" name="fibrates" id="Fibrates" 
                                value="{{ $diabetesInfo ? $diabetesInfo->fibrates == 'yes' ? 'yes' : 'no' : 'no' }}" 
                                {{ $diabetesInfo ? $diabetesInfo->fibrates == 'yes' ? 'checked' : '' : '' }} 
                                {{ $diabetesInfo ? $diabetesInfo->dyslipidemia == 'yes' ? '' : 'disabled' : 'disabled' }}>
                                <label class="radioLabel2" for="Fibrates">Fibrates</label>
                            </td>
                            <td colspan="2" class="diabetes-input">
                                <div class="input-group input-group-sm">
                                  <input type="text" name="fibratesMgday" class="form-control" placeholder="" aria-describedby="basic-addon2" 
                                  value="{{ $diabetesInfo ? $diabetesInfo->fibratesMgday ? $diabetesInfo->fibratesMgday : '' : '' }}" 
                                  {{ $diabetesInfo ? $diabetesInfo->dyslipidemia == 'yes' ? '' : 'disabled' : 'disabled' }}>
                                  <span class="input-group-addon" id="basic-addon2">mg/day</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="checkbox" class="" name="dyslipidemiaothers" id="dyslipidemiaOthers" 
                                value="{{ $diabetesInfo ? $diabetesInfo->dyslipidemiaothers == 'yes' ? 'yes' : 'no' : 'no' }}" 
                                {{ $diabetesInfo ? $diabetesInfo->dyslipidemiaothers == 'yes' ? 'checked' : '' : '' }} 
                                {{ $diabetesInfo ? $diabetesInfo->dyslipidemia == 'yes' ? '' : 'disabled' : 'disabled' }}>
                                <label class="radioLabel2" for="dyslipidemiaOthers">Others: Specify</label>
                            </td>
                            <td colspan="2" class="diabetes-input">
                                <div class="input-group input-group-sm">
                                  <input type="text" name="dyslipidemiaothersMgday" class="form-control" aria-describedby="basic-addon2" 
                                  value="{{ $diabetesInfo ? $diabetesInfo->dyslipidemiaothersMgday ? $diabetesInfo->dyslipidemiaothersMgday : '' : '' }}" 
                                  {{ $diabetesInfo ? $diabetesInfo->dyslipidemia == 'yes' ? '' : 'disabled' : 'disabled' }}>
                                  <span class="input-group-addon" id="basic-addon2">mg/day</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1">
                                <input type="checkbox" class="dotherhypertension" name="omcothers" id="othermedicalconditions" 
                                value="{{ $diabetesInfo ? $diabetesInfo->omcothers == 'yes' ? 'yes' : 'no' : 'no' }}" 
                                {{ $diabetesInfo ? $diabetesInfo->omcothers == 'yes' ? 'checked' : '' : '' }}>
                                <label class="radioLabel2" for="othermedicalconditions">Others: Specify</label>
                            </td>
                            <td colspan="5">
                                <textarea name="omcotherscontent" class="form-control input-sm" 
                                {{ $diabetesInfo ? $diabetesInfo->omcothers == 'yes' ? '' : 'disabled' : 'disabled' }}>{{ $diabetesInfo ? $diabetesInfo->omcotherscontent ? $diabetesInfo->omcotherscontent : '' : '' }}</textarea></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-3" style="padding-left: 0px;">
                    <table class="table table-bordered table-condensed">
                        <tr>
                            <td colspan="12" class="EHospitalizations">E. Hospitalizations</td>
                        </tr>
                        <tr>
                            <td colspan="3" width=""><input type="checkbox" name="dka" id="dka" value="{{ $diabetesInfo ? $diabetesInfo->dka == 'yes' ? 'yes' : 'no' : 'no' }}" {{ $diabetesInfo ? $diabetesInfo->dka == 'yes' ? 'checked' : '' : '' }}> <label class="radioLabel2" for="dka">DKA</label></td>
                            <td colspan="3" width=""><input type="checkbox" name="mi" id="mi" value="{{ $diabetesInfo ? $diabetesInfo->mi == 'yes' ? 'yes' : 'no' : 'no' }}" {{ $diabetesInfo ? $diabetesInfo->mi == 'yes' ? 'checked' : '' : '' }}> <label class="radioLabel2" for="mi">MI</label></td>
                            <td colspan="3"><input type="checkbox" name="estroke" id="estroke" value="{{ $diabetesInfo ? $diabetesInfo->estroke == 'yes' ? 'yes' : 'no' : 'no' }}" {{ $diabetesInfo ? $diabetesInfo->estroke == 'yes' ? 'checked' : '' : '' }}> <label class="radioLabel2" for="estroke">Stroke</label></td>
                        </tr>
                        <tr>
                            <td colspan="4"><input type="checkbox" name="hhs" id="HHS" value="{{ $diabetesInfo ? $diabetesInfo->hhs == 'yes' ? 'yes' : 'no' : 'no' }}" {{ $diabetesInfo ? $diabetesInfo->hhs == 'yes' ? 'checked' : '' : '' }}> <label  class="radioLabel2"for="HHS">HHS</label></td>
                            <td colspan="8"><input type="checkbox" name="angina" id="Angina" value="{{ $diabetesInfo ? $diabetesInfo->angina == 'yes' ? 'yes' : 'no' : 'no' }}" {{ $diabetesInfo ? $diabetesInfo->angina == 'yes' ? 'checked' : '' : '' }}> <label class="radioLabel2" for="Angina">Angina</label></td>
                        </tr>
                        <tr>
                            <td colspan="12"><input type="checkbox" name="hypoglycemia" id="Hypoglycemia" value="{{ $diabetesInfo ? $diabetesInfo->hypoglycemia == 'yes' ? 'yes' : 'no' : 'no' }}" {{ $diabetesInfo ? $diabetesInfo->hypoglycemia == 'yes' ? 'checked' : '' : '' }}> <label class="radioLabel2" for="Hypoglycemia">Hypoglycemia</label></td>
                        </tr>
                        <tr>
                            <td colspan="12">
                                <input type="checkbox" class="eOthers" name="others_e" id="eOthers" value="{{ $diabetesInfo ? $diabetesInfo->others_e == 'yes' ? 'yes' : 'no' : 'no' }}" {{ $diabetesInfo ? $diabetesInfo->others_e == 'yes' ? 'checked' : '' : '' }}>
                                <label class="radioLabel2" for="eOthers">Others</label>
                                <textarea name="otherscontent_e" class="form-control input-sm" {{ $diabetesInfo ? $diabetesInfo->others_e == 'yes' ? '' : 'disabled' : 'disabled' }}>{{ $diabetesInfo ? $diabetesInfo->otherscontent_e ? $diabetesInfo->otherscontent_e : '' : '' }}</textarea>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-3" style="padding-left: 0px;padding-right: 0px;">
                    <table class="table table-bordered table-condensed">
                        <tr>
                            <td colspan="12" class="FSurgeriesOperations">F. Surgeries/Operations</td>
                        </tr>
                        <tr>
                            <td colspan="12" width="300"><input name="amputation" type="checkbox" class="Amputation" id="Amputation" value="{{ $diabetesInfo ? $diabetesInfo->amputation == 'yes' ? 'yes' : 'no' : 'no' }}" {{ $diabetesInfo ? $diabetesInfo->amputation == 'yes' ? 'checked' : '' : '' }}> <label class="radioLabel2" for="Amputation">Amputation</label></td>
                        </tr>
                        <tr>
                            <td colspan="6">
                                <input type="checkbox" name="digital" id="Digital" value="{{ $diabetesInfo ? $diabetesInfo->digital == 'yes' ? 'yes' : 'no' : 'no' }}" {{ $diabetesInfo ? $diabetesInfo->digital == 'yes' ? 'checked' : '' : '' }}> <label class="radioLabel2" for="Digital">Digital</label>
                            </td>
                            <td colspan="6">
                                <input type="checkbox" name="bka" id="BKA" value="{{ $diabetesInfo ? $diabetesInfo->bka == 'yes' ? 'yes' : 'no' : 'no' }}" {{ $diabetesInfo ? $diabetesInfo->bka == 'yes' ? 'checked' : '' : '' }}> <label class="radioLabel2" for="BKA">BKA</label>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="12" width="100"><input type="checkbox" name="revascularization" id="Revascularization" value="{{ $diabetesInfo ? $diabetesInfo->revascularization == 'yes' ? 'yes' : 'no' : 'no' }}" {{ $diabetesInfo ? $diabetesInfo->revascularization == 'yes' ? 'checked' : '' : '' }}> <label class="radioLabel2" for="Revascularization">Revascularization</label></td>
                        </tr>
                        <tr>
                            <td colspan="12" width="8">
                                <input type="checkbox" name="others_f"  class="fothers" id="fothers" value="{{ $diabetesInfo ? $diabetesInfo->others_f == 'yes' ? 'yes' : 'no' : 'no' }}" {{ $diabetesInfo ? $diabetesInfo->others_f == 'yes' ? 'checked' : '' : '' }}>
                                <label class="radioLabel2" for="fothers">Others <i>(Specify)</i></label>
                                <textarea name="otherscontent_f" class="form-control input-sm" {{ $diabetesInfo ? $diabetesInfo->others_f == 'yes' ? '' : 'disabled' : 'disabled' }}>{{ $diabetesInfo ? $diabetesInfo->otherscontent_e ? $diabetesInfo->otherscontent_e : '' : '' }}</textarea>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6" style="padding-left: 0px;padding-right: 0px;">
                    <table class="table table-bordered table-condensed">
                        <tr>
                            <td colspan="12" class="GFamilyDiseases">G. Family Diseases</td>
                        </tr>
                        <tr>
                            <td colspan="1" width=""><input type="checkbox" name="diabetes_g" class="gDiabetes" id="gDiabetes" value="{{ $diabetesInfo ? $diabetesInfo->diabetes_g == 'yes' ? 'yes' : 'no' : 'no' }}" {{ $diabetesInfo ? $diabetesInfo->diabetes_g == 'yes' ? 'checked' : '' : '' }}> <label class="radioLabel2" for="gDiabetes">Diabetes</label></td>
                            <td colspan="4" width="160" class="text-right" style="vertical-align: middle"><label class="radioLabel2">Family members affected:</label></td>
                            <td colspan="8" width="" class="diabetes-input"><input type="text" name="familymembersaffected" class="form-control input-sm" value="{{ $diabetesInfo ? $diabetesInfo->familymembersaffected ? $diabetesInfo->familymembersaffected : '' : '' }}" {{ $diabetesInfo ? $diabetesInfo->diabetes_g == 'yes' ? '' : 'disabled' : 'disabled' }}></td>
                        </tr>
                        <tr>
                            <td colspan="2" width=""><input type="checkbox" name="hypertension_g" id="gHypertension" value="{{ $diabetesInfo ? $diabetesInfo->hypertension_g == 'yes' ? 'yes' : 'no' : 'no' }}" {{ $diabetesInfo ? $diabetesInfo->hypertension_g == 'yes' ? 'checked' : '' : '' }}> <label class="radioLabel2" for="gHypertension">Hypertension</label></td>
                            <td colspan="2" width=""><input type="checkbox" name="cvd" id="CVD" value="{{ $diabetesInfo ? $diabetesInfo->cvd == 'yes' ? 'yes' : 'no' : 'no' }}" {{ $diabetesInfo ? $diabetesInfo->cvd == 'yes' ? 'checked' : '' : '' }}> <label class="radioLabel2" for="CVD">CVD</label></td>
                            <td colspan="2"><input type="checkbox" name="stroke_g" id="g-stroke" value="{{ $diabetesInfo ? $diabetesInfo->stroke_g == 'yes' ? 'yes' : 'no' : 'no' }}" {{ $diabetesInfo ? $diabetesInfo->stroke_g == 'yes' ? 'checked' : '' : '' }}> <label class="radioLabel2" for="g-stroke">Stroke</label></td>
                            <td colspan="2" width=""><input type="checkbox" name="cancer" id="e-Cancer" value="{{ $diabetesInfo ? $diabetesInfo->cancer == 'yes' ? 'yes' : 'no' : 'no' }}" {{ $diabetesInfo ? $diabetesInfo->cancer == 'yes' ? 'checked' : '' : '' }}> <label class="radioLabel2" for="e-Cancer">Cancer</label></td>
                            <td colspan="2"><input type="checkbox" name="asthma" id="Asthma" value="{{ $diabetesInfo ? $diabetesInfo->asthma == 'yes' ? 'yes' : 'no' : 'no' }}" {{ $diabetesInfo ? $diabetesInfo->asthma == 'yes' ? 'checked' : '' : '' }}> <label class="radioLabel2" for="Asthma">Asthma</label></td>
                            <td colspan="2"><input type="checkbox" name="tb" id="TB" value="{{ $diabetesInfo ? $diabetesInfo->tb == 'yes' ? 'yes' : 'no' : 'no' }}" {{ $diabetesInfo ? $diabetesInfo->tb == 'yes' ? 'checked' : '' : '' }}> <label class="radioLabel2" for="TB">TB</label></td>
                        </tr>
                    </table>
                </div>
                <div class="clearfix visible-lg-block"></div>
                <div class="col-md-5" style="padding-left: 0px;">
                    <table class="table table-bordered table-condensed">
                        <tr>
                            <td colspan="6" class="HOBGYNEHistory">H. OB GYNE History</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="diabetes-input">
                                <div class="input-group input-group-sm">
                                  <span class="input-group-addon" id="basic-addon2">G</span>
                                  <input type="text" name="g" class="form-control" placeholder="" value="{{ $diabetesInfo ? $diabetesInfo->g ? $diabetesInfo->g : '' : '' }}" aria-describedby="basic-addon2">
                                </div>
                            </td>
                            <td colspan="2" class="diabetes-input">
                                <div class="input-group input-group-sm">
                                  <span class="input-group-addon" id="basic-addon2">P</span>
                                  <input type="text" name="p" class="form-control" placeholder="" value="{{ $diabetesInfo ? $diabetesInfo->p ? $diabetesInfo->p : '' : '' }}" aria-describedby="basic-addon2">
                                </div>
                            </td>
                            <td colspan="2" class="diabetes-input">
                                <div class="input-group input-group-sm">
                                  <span class="input-group-addon" id="basic-addon2">( T</span>
                                  <input type="text" name="t" class="form-control" placeholder="" value="{{ $diabetesInfo ? $diabetesInfo->t ? $diabetesInfo->t : '' : '' }}" aria-describedby="basic-addon2">
                                  <span class="input-group-addon" id="basic-addon2"> </span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="diabetes-input">
                                <div class="input-group input-group-sm">
                                  <span class="input-group-addon" id="basic-addon2">P</span>
                                  <input type="text" name="p2" class="form-control" placeholder="" value="{{ $diabetesInfo ? $diabetesInfo->p2 ? $diabetesInfo->p2 : '' : '' }}" aria-describedby="basic-addon2">
                                </div>
                            </td>
                            <td colspan="2" class="diabetes-input">
                                <div class="input-group input-group-sm">
                                  <span class="input-group-addon" id="basic-addon2">A</span>
                                  <input type="text" name="a" class="form-control" placeholder="" value="{{ $diabetesInfo ? $diabetesInfo->a ? $diabetesInfo->a : '' : '' }}" aria-describedby="basic-addon2">
                                </div>
                            </td>
                            <td colspan="2" class="diabetes-input">
                                <div class="input-group input-group-sm">
                                  <span class="input-group-addon" id="basic-addon2">I</span>
                                  <input type="text" name="i" class="form-control" placeholder="" value="{{ $diabetesInfo ? $diabetesInfo->i ? $diabetesInfo->i : '' : '' }}" aria-describedby="basic-addon2">
                                  <span class="input-group-addon" id="basic-addon2">)</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <label class="radioLabel2" name="e-Diabetes" for="dka">No. of babies &ge; 8lbs </label> <input type="checkbox" name="babiesNolower8lbs" id="e-Diabetes" value="{{ $diabetesInfo ? $diabetesInfo->babiesNolower8lbs == 'yes' ? 'yes' : 'no' : 'no' }}" {{ $diabetesInfo ? $diabetesInfo->babiesNolower8lbs == 'yes' ? 'checked' : '' : '' }}>
                            </td>
                            <td colspan="4" class="diabetes-input">
                                <div class="input-group input-group-sm">
                                  <span class="input-group-addon" id="basic-addon2">No. of babies with congenital anomalies</span>
                                  <input type="number" name="babiesNocongenitalanomalies" class="form-control" value="{{ $diabetesInfo ? $diabetesInfo->babiesNocongenitalanomalies ? $diabetesInfo->babiesNocongenitalanomalies : '' : '' }}" aria-describedby="basic-addon2">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <label class="radioLabel2" for="e-no">Menopause: no </label> <input type="radio" name="menopause" id="e-no" value="no" {{ $diabetesInfo ? $diabetesInfo->menopause == 'no' ? 'checked' : '' : '' }}>&nbsp; <label class="radioLabel2" for="e-yes">yes </label> <input type="radio" name="menopause" id="e-yes" value="yes" {{ $diabetesInfo ? $diabetesInfo->menopause == 'yes' ? 'checked' : '' : '' }}>
                            </td>
                            <td colspan="2" class="diabetes-input">
                                <div class="input-group input-group-sm">
                                  <span class="input-group-addon" id="basic-addon2">Date:</span>
                                <input type="text" class="form-control date_picker input-sm" name="menopausedate" 
                                value="{{ $diabetesInfo ? $diabetesInfo->menopausedate ? Carbon::parse($diabetesInfo->menopausedate)->format('m/d/Y') : '' : '' }}">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-right" style="vertical-align: middle;">
                                <label class="radioLabel2" name="e-Diabetes" for="dka">PCOS (Date diagnosed):</label>
                            </td>
                            <td colspan="3" class="diabetes-input">
                                <input type="text" name="pcosdatediagnosed" class="form-control date_picker input-sm"
                                value="{{ $diabetesInfo ? $diabetesInfo->pcosdatediagnosed ? Carbon::parse($diabetesInfo->pcosdatediagnosed)->format('m/d/Y') : '' : '' }}">
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-7" style="padding-left: 0px;padding-right: 0px;">
                    <table class="table table-bordered table-condensed">
                        <tr>
                            <td colspan="12" class="IPersonalHistory">I. Personal History</td>
                        </tr>
                        <tr>
                            <td colspan="4" width="80">
                                <input type="checkbox" class="iSmoking" name="smoking" id="iSmoking" 
                                value="{{ $diabetesInfo ? $diabetesInfo->smoking == 'yes' ? 'yes' : 'no' : 'no' }}" 
                                {{ $diabetesInfo ? $diabetesInfo->smoking == 'yes' ? 'checked' : '' : '' }}>
                                <label class="radioLabel2" for="iSmoking">Smoking</label>
                            </td>
                            <td colspan="2" width="120" class="text-right" style="vertical-align: middle">
                                <label class="radioLabel2">(How much & duration)</label>
                            </td>
                            <td colspan="2" width="130" class="diabetes-input">
                                <input type="text" name="smokingduration" 
                                value="{{ $diabetesInfo ? $diabetesInfo->smokingduration ? $diabetesInfo->smokingduration : '' : '' }}" class="form-control input-sm" 
                                {{ $diabetesInfo ? $diabetesInfo->smoking == 'yes' ? '' : 'disabled' : 'disabled' }}>
                            </td>
                            <td colspan="2" width="80">
                                <input type="checkbox" name="smokingquit" id="iSmokingquit" 
                                value="{{ $diabetesInfo ? $diabetesInfo->smokingquit == 'yes' ? 'yes' : 'no' : 'no' }}" 
                                {{ $diabetesInfo ? $diabetesInfo->smokingquit == 'yes' ? 'checked' : '' : '' }} 
                                {{ $diabetesInfo ? $diabetesInfo->smoking == 'yes' ? '' : 'disabled' : 'disabled' }}>
                                <label class="radioLabel2" for="iSmokingquit">Quit (When)</label>
                            </td>
                            <td colspan="2" width="90" class="diabetes-input">
                                <input type="text" name="smokingwhen" class="form-control date_picker input-sm"
                                value="{{ $diabetesInfo ? $diabetesInfo->smokingwhen ? Carbon::parse($diabetesInfo->smokingwhen)->format('m/d/Y') : '' : '' }}" 
                                {{ $diabetesInfo ? $diabetesInfo->smoking == 'yes' ? '' : 'disabled' : 'disabled' }}>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6" width="210">
                                <input type="checkbox" class="iAlcolholbeverage" name="alcolholbeverage" id="iAlcolholbeverage" 
                                value="{{ $diabetesInfo ? $diabetesInfo->alcolholbeverage == 'yes' ? 'yes' : 'no' : 'no' }}" 
                                {{ $diabetesInfo ? $diabetesInfo->alcolholbeverage == 'yes' ? 'checked' : '' : '' }}>
                                <label class="radioLabel2" for="iAlcolholbeverage">Alcolhol beverage (How much & duration)</label>
                            </td>
                            <td colspan="2" width="130" class="diabetes-input">
                                <input type="text" name="alcolholbeverageduration" class="form-control input-sm" 
                                value="{{ $diabetesInfo ? $diabetesInfo->alcolholbeverageduration ? $diabetesInfo->alcolholbeverageduration : '' : '' }}" 
                                {{ $diabetesInfo ? $diabetesInfo->alcolholbeverage == 'yes' ? '' : 'disabled' : 'disabled' }}>
                            </td>
                            <td colspan="2" width="80"><input type="checkbox" name="alcolholbeveragequit" id="iBeveragequit"
                                value="{{ $diabetesInfo ? $diabetesInfo->smokingquit == 'yes' ? 'yes' : 'no' : 'no' }}" 
                                {{ $diabetesInfo ? $diabetesInfo->alcolholbeveragequit == 'yes' ? 'checked' : '' : '' }} 
                                {{ $diabetesInfo ? $diabetesInfo->alcolholbeverage == 'yes' ? '' : 'disabled' : 'disabled' }}>
                                <label class="radioLabel2" for="iBeveragequit">Quit (When)</label>
                            </td>
                            <td colspan="2" width="90" class="diabetes-input">
                                <input type="text" name="alcolholbeveragewhen" class="form-control date_picker input-sm"
                                value="{{ $diabetesInfo ? $diabetesInfo->alcolholbeveragewhen ? Carbon::parse($diabetesInfo->alcolholbeveragewhen)->format('m/d/Y') : '' : '' }}" 
                                {{ $diabetesInfo ? $diabetesInfo->smoking == 'yes' ? '' : 'disabled' : 'disabled' }}></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-7" style="padding-left: 0px;padding-right: 0px;">
                    <table class="table table-bordered table-condensed">
                        <tr>
                            <td colspan="12" class="JSignsandSymptoms">J. Signs and Symptoms and other pertinent review of system:</td>
                        </tr>
                        <tr>
                            <td colspan="3" width="60">
                                <input type="checkbox" name="polyuria_j" id="Polyuria" value="{{ $diabetesInfo ? $diabetesInfo->polyuria_j == 'yes' ? 'yes' : 'no' : 'no' }}" {{ $diabetesInfo ? $diabetesInfo->polyuria_j == 'yes' ? 'checked' : '' : '' }}>
                                <label class="radioLabel2" for="Polyuria">Polyuria</label>
                            </td>
                            <td colspan="3" width="60">
                                <input type="checkbox" name="weightloss_j" id="WeightLoss" value="{{ $diabetesInfo ? $diabetesInfo->weightloss_j == 'yes' ? 'yes' : 'no' : 'no' }}" {{ $diabetesInfo ? $diabetesInfo->weightloss_j == 'yes' ? 'checked' : '' : '' }}>
                                <label class="radioLabel2" for="WeightLoss">Weight Loss</label>
                            </td>
                            <td colspan="1" width="200">
                                <input type="checkbox" name="others_j" class="j_Other" id="jOther" value="{{ $diabetesInfo ? $diabetesInfo->others_j == 'yes' ? 'yes' : 'no' : 'no' }}" {{ $diabetesInfo ? $diabetesInfo->others_j == 'yes' ? 'checked' : '' : '' }}>
                                <label class="radioLabel2" for="jOther">Other, (Specify)</label>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" width="60">
                                <input type="checkbox" name="polydipsia_j" id="Polydipsia" 
                                value="{{ $diabetesInfo ? $diabetesInfo->polydipsia_j == 'yes' ? 'yes' : 'no' : 'no' }}" 
                                {{ $diabetesInfo ? $diabetesInfo->polydipsia_j == 'yes' ? 'checked' : '' : '' }}>
                                <label class="radioLabel2" for="Polydipsia">Polydipsia</label>
                            </td>
                            <td colspan="3" width="60">
                                <input type="checkbox" name="tinglingsensation_j" id="TinglingSensation" 
                                value="{{ $diabetesInfo ? $diabetesInfo->tinglingsensation_j == 'yes' ? 'yes' : 'no' : 'no' }}" 
                                {{ $diabetesInfo ? $diabetesInfo->tinglingsensation_j == 'yes' ? 'checked' : '' : '' }}>
                                <label class="radioLabel2" for="TinglingSensation">Tingling Sensation</label>
                            </td>
                            <td colspan="3" rowspan="2" width="200">
                                <textarea name="otherscontent_j" class="form-control input-sm" {{ $diabetesInfo ? $diabetesInfo->others_j == 'yes' ? '' : 'disabled' : 'disabled' }}>{{ $diabetesInfo ? $diabetesInfo->otherscontent_j ? $diabetesInfo->otherscontent_j : '' : '' }}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" width="80">
                                <input type="checkbox" name="polyphagia_j" id="Polyphagia" 
                                value="{{ $diabetesInfo ? $diabetesInfo->polyphagia_j == 'yes' ? 'yes' : 'no' : 'no' }}" 
                                {{ $diabetesInfo ? $diabetesInfo->polyphagia_j == 'yes' ? 'checked' : '' : '' }}>
                                <label class="radioLabel2" for="Polyphagia">Polyphagia</label></td>
                            <td colspan="2" width="80">
                                <input type="checkbox" name="nonhealingwound_j" id="Nonhealingwound" 
                                value="{{ $diabetesInfo ? $diabetesInfo->nonhealingwound_j == 'yes' ? 'yes' : 'no' : 'no' }}" 
                                {{ $diabetesInfo ? $diabetesInfo->nonhealingwound_j == 'yes' ? 'checked' : '' : '' }}> 
                                <label class="radioLabel2" for="Nonhealingwound">Non-healing wound</label>
                            </td>
                        </tr>
                    </table>
                </div>
              </div>
                            
              <h3>II. INITIAL PHYSICAL EXAMINATION</h3>
              <div style="padding: 10px;">
                <div class="col-md-6" style="padding-left: 0px;">
                    <table class="table table-bordered table-condensed" style="margin-bottom: 0px">
                        <!-- <tr>
                            <th colspan="3" class="IIINITIALPHYSICALEXAMINATION">
                                <h4>II. INITIAL PHYSICAL EXAMINATION</h4>
                            </th>
                        </tr> -->
                        <tr>
                            <td colspan="" class="diabetes-input">
                                <div class="input-group input-group-sm">
                                  <span class="input-group-addon" id="basic-addon2">Pulse</span>
                                  <input type="text" name="pulse1" class="form-control" value="{{ $diabetesInfo ? $diabetesInfo->pulse1 ? $diabetesInfo->pulse1 : '' : '' }}" aria-describedby="basic-addon2">
                                  <span class="input-group-addon" id="basic-addon2">/min</span>
                                </div>
                            </td>
                            <td colspan="" class="diabetes-input">
                                <div class="input-group input-group-sm">
                                  <span class="input-group-addon" id="basic-addon2">RR</span>
                                  <input type="text" name="rr" class="form-control" value="{{ $diabetesInfo ? $diabetesInfo->rr ? $diabetesInfo->rr : '' : '' }}" aria-describedby="basic-addon2">
                                  <span class="input-group-addon" id="basic-addon2">/min</span>
                                </div>
                            </td>
                            <td colspan="" class="diabetes-input">
                                <div class="input-group input-group-sm">
                                  <span class="input-group-addon" id="basic-addon2">T:</span>
                                  <input type="text" name="tc" class="form-control" value="{{ $diabetesInfo ? $diabetesInfo->tc ? $diabetesInfo->tc : '' : '' }}" aria-describedby="basic-addon2">
                                  <span class="input-group-addon" id="basic-addon2">&#8451;</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="" class="diabetes-input">
                                <div class="input-group input-group-sm">
                                  <span class="input-group-addon" id="basic-addon2">Weight</span>
                                  <input type="text" name="weight" class="form-control" value="{{ $diabetesInfo ? $diabetesInfo->weight ? $diabetesInfo->weight : '' : '' }}" aria-describedby="basic-addon2">
                                  <span class="input-group-addon" id="basic-addon2">kg</span>
                                </div>
                            </td>
                            <td colspan="" class="diabetes-input">
                                <div class="input-group input-group-sm">
                                  <span class="input-group-addon" id="basic-addon2">Height</span>
                                  <input type="text" name="height" class="form-control" value="{{ $diabetesInfo ? $diabetesInfo->height ? $diabetesInfo->height : '' : '' }}" aria-describedby="basic-addon2">
                                  <span class="input-group-addon" id="basic-addon2">m</span>
                                </div>
                            </td>
                            <td colspan="" class="diabetes-input">
                                <div class="input-group input-group-sm">
                                  <span class="input-group-addon" id="basic-addon2">BMI</span>
                                  <input type="text" name="bmi" class="form-control" value="{{ $diabetesInfo ? $diabetesInfo->bmi ? $diabetesInfo->bmi : '' : '' }}" aria-describedby="basic-addon2">
                                  <span class="input-group-addon" id="basic-addon2">kg/&#x33a1;</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="" class="diabetes-input">
                                <div class="input-group input-group-sm">
                                  <span class="input-group-addon" id="basic-addon2">WC</span>
                                  <input type="text" name="wc" class="form-control" value="{{ $diabetesInfo ? $diabetesInfo->wc ? $diabetesInfo->wc : '' : '' }}" aria-describedby="basic-addon2">
                                  <span class="input-group-addon" id="basic-addon2">cm</span>
                                </div>
                            </td>
                            <td colspan="" class="diabetes-input">
                                <div class="input-group input-group-sm">
                                  <span class="input-group-addon" id="basic-addon2">HC</span>
                                  <input type="text" name="hc" class="form-control" value="{{ $diabetesInfo ? $diabetesInfo->hc ? $diabetesInfo->hc : '' : '' }}" aria-describedby="basic-addon2">
                                  <span class="input-group-addon" id="basic-addon2">cm</span>
                                </div>
                            </td>
                            <td colspan="2" class="diabetes-input">
                                <div class="input-group input-group-sm">
                                  <span class="input-group-addon" id="basic-addon2">WHR</span>
                                  <input type="text" name="whr" class="form-control" value="{{ $diabetesInfo ? $diabetesInfo->whr ? $diabetesInfo->whr : '' : '' }}" aria-describedby="basic-addon2">
                                </div>
                            </td>
                        </tr>
                    </table>
                    <table class="table table-bordered table-condensed">
                        <tr>
                            <td colspan="" class="diabetes-input">
                                <div class="input-group input-group-sm">
                                  <span class="input-group-addon" id="basic-addon2">BP: Brachial*</span>
                                  <input type="text" name="brachial" class="form-control" value="{{ $diabetesInfo ? $diabetesInfo->brachial ? $diabetesInfo->brachial : '' : '' }}" aria-describedby="basic-addon2">
                                  <span class="input-group-addon" id="basic-addon2">mmHg</span>
                                </div>
                            </td>
                            <td colspan="" class="diabetes-input">
                                <div class="input-group input-group-sm">
                                  <span class="input-group-addon" id="basic-addon2">Time taken</span>
                                  <input type="text" name="timetaken" class="form-control {{ $diabetesInfo ? '' : 'time_taken' }}" {{ $diabetesInfo ? 'readonly' : '' }}
                                  value="{{ $diabetesInfo ? $diabetesInfo->timetaken ? Carbon::parse($diabetesInfo->timetaken)->format('h : i A') : '' : '' }}" aria-describedby="basic-addon2">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="" class="diabetes-input">
                                <div class="input-group input-group-sm">
                                  <span class="input-group-addon" id="basic-addon2">Ankle</span>
                                  <input type="text" name="ancle" class="form-control" value="{{ $diabetesInfo ? $diabetesInfo->ancle ? $diabetesInfo->ancle : '' : '' }}" aria-describedby="basic-addon2">
                                  <span class="input-group-addon" id="basic-addon2">mmHg</span>
                                </div>
                                <div class="input-group input-group-sm">
                                  <span class="input-group-addon" id="basic-addon2">Ratio</span>
                                  <input type="text" name="ratio" class="form-control" value="{{ $diabetesInfo ? $diabetesInfo->ratio ? $diabetesInfo->ratio : '' : '' }}" aria-describedby="basic-addon2">
                                </div>
                            </td>
                            <td colspan="3" rowspan="2" width="">
                                <i>*branchial & ankle BP should be taken on same side</i>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="" class="diabetes-input">
                                <div class="input-group input-group-sm">
                                  <span class="input-group-addon" id="basic-addon2">Pulse:</span>
                                  <input type="text" name="pulse2" class="form-control" value="{{ $diabetesInfo ? $diabetesInfo->pulse2 ? $diabetesInfo->pulse2 : '' : '' }}" aria-describedby="basic-addon2">
                                  <span class="input-group-addon" id="basic-addon2">/min</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="">
                                <label class="radioLabel2" for="LowerExtremity">Lower Extremity:</label>
                                <input type="checkbox" name="ulcer" id="Ulcer" 
                                value="{{ $diabetesInfo ? $diabetesInfo->ulcer == 'yes' ? 'yes' : 'no' : 'no' }}"
                                {{ $diabetesInfo ? $diabetesInfo->ulcer == 'yes' ? 'checked' : '' : '' }}>
                                <label class="radioLabel2" for="Ulcer">Ulcer</label>
                            </td>
                            <td colspan="">
                                <input type="checkbox" name="stasisdiscoloration" id="LowerExtremity" 
                                value="{{ $diabetesInfo ? $diabetesInfo->stasisdiscoloration == 'yes' ? 'yes' : 'no' : 'no' }}"
                                {{ $diabetesInfo ? $diabetesInfo->stasisdiscoloration == 'yes' ? 'checked' : '' : '' }}>
                                <label class="radioLabel2" for="LowerExtremity">Stasis discoloration</label>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6" style="padding-left: 0px;padding-right: 0px;">
                    <table class="table table-bordered table-condensed">
                        <!-- <tr>
                            <th colspan="3" class="IIINITIALPHYSICALEXAMINATION">
                                <h4>II.</h4>
                            </th>
                        </tr> -->
                        <tr>
                            <td colspan="" class="text-right" style="vertical-align: middle">
                                <label class="radioLabel2" for="LowerExtremity">Deep Tendon Reflex:</label>
                            </td>
                            <td colspan="">
                                <input type="checkbox" name="achillestendon" id="AchillesTendon" 
                                value="{{ $diabetesInfo ? $diabetesInfo->achillestendon == 'yes' ? 'yes' : 'no' : 'no' }}"
                                {{ $diabetesInfo ? $diabetesInfo->achillestendon == 'yes' ? 'checked' : '' : '' }}>
                                <label class="radioLabel2" for="AchillesTendon">Achilles Tendon:</label>
                            </td>
                            <td colspan="">
                                <input type="checkbox" name="knee" id="Knee" value="{{ $diabetesInfo ? $diabetesInfo->knee == 'yes' ? 'yes' : 'no' : 'no' }}"
                                {{ $diabetesInfo ? $diabetesInfo->knee == 'yes' ? 'checked' : '' : '' }}>
                                <label class="radioLabel2" for="Knee">Knee</label>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="" class="diabetes-input">
                                <div class="input-group input-group-sm">
                                  <span class="input-group-addon" id="basic-addon2">Pulse: DP*</span>
                                  <input type="text" name="dp" class="form-control" 
                                  value="{{ $diabetesInfo ? $diabetesInfo->dp ? $diabetesInfo->dp : '' : '' }}" aria-describedby="basic-addon2">
                                </div>
                            </td>
                            <td colspan="" class="diabetes-input">
                                <div class="input-group input-group-sm">
                                  <span class="input-group-addon" id="basic-addon2">PT*</span>
                                  <input type="text" name="pt" class="form-control" 
                                  value="{{ $diabetesInfo ? $diabetesInfo->pt ? $diabetesInfo->pt : '' : '' }}" aria-describedby="basic-addon2">
                                </div>
                            </td>
                            <td colspan="" class="diabetes-input">
                                <div class="input-group input-group-sm">
                                  <span class="input-group-addon" id="basic-addon2">Pop*</span>
                                  <input type="text" name="pop" class="form-control" 
                                  value="{{ $diabetesInfo ? $diabetesInfo->pop ? $diabetesInfo->pop : '' : '' }}" aria-describedby="basic-addon2">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-center">
                                <i>Pulse should be taken on the same side</i>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="diabetes-input">
                                <div class="input-group input-group-sm">
                                  <span class="input-group-addon" id="basic-addon2">Vibratory sense:</span>
                                  <input type="text" name="vibratorypresent" class="form-control" 
                                  value="{{ $diabetesInfo ? $diabetesInfo->vibratorypresent ? $diabetesInfo->vibratorypresent : '' : '' }}" aria-describedby="basic-addon2">
                                  <span class="input-group-addon" id="basic-addon2">Present</span>
                                </div>
                            </td>
                            <td colspan="" class="diabetes-input">
                                <div class="input-group input-group-sm">
                                  <input type="text" name="vibratoryabsent" class="form-control" 
                                  value="{{ $diabetesInfo ? $diabetesInfo->vibratoryabsent ? $diabetesInfo->vibratoryabsent : '' : '' }}" aria-describedby="basic-addon2">
                                  <span class="input-group-addon" id="basic-addon2">Absent</span>
                                </div>
                            </td>
                        <tr>
                            <td colspan="3">
                                Pertinent Physical Examination Findings:
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <textarea name="ppef" class="form-control input-sm" rows="4">{{ $diabetesInfo ? $diabetesInfo->ppef ? $diabetesInfo->ppef : '' : '' }}</textarea>
                            </td>
                        </tr>
                    </table>
                </div>
              </div>
              <h3>III. CONFIRMED DIABETIC COMPLICATIONS*</h3>
              <div style="padding: 10px;">
                <div class="clearfix visible-lg-block"></div>
                <div class="col-md-6" style="padding-left: 0px;">
                    <table class="table table-bordered table-condensed">
                        <!-- <tr>
                            <th colspan="8" class="IVCONFIRMEDDIABETICCOMPLICATIONS">
                                <h4>IV. CONFIRMED DIABETIC COMPLICATIONS*</h4>
                            </th>
                        </tr> -->
                        <tr>
                            <td colspan="8" class=>
                                *To be filled only when confirmed at any time during the surveillance period,<br><kbd>(check the satisfied criteria)</kbd>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" width="50">
                                <input type="checkbox" name="retinopathy" id="Retinopathy" 
                                value="{{ $diabetesInfo ? $diabetesInfo->retinopathy == 'yes' ? 'yes' : 'no' : 'no' }}"
                                {{ $diabetesInfo ? $diabetesInfo->retinopathy == 'yes' ? 'checked' : '' : '' }}>
                                <label class="radioLabel2" for="Retinopathy">Retinopathy</label>(indirect ophthalmoscopy)
                            </td>
                            <td colspan="4" width="100">
                                <input type="checkbox" name="nephropathy" id="Neuropathyspot" 
                                value="{{ $diabetesInfo ? $diabetesInfo->nephropathy == 'yes' ? 'yes' : 'no' : 'no' }}"
                                {{ $diabetesInfo ? $diabetesInfo->nephropathy == 'yes' ? 'checked' : '' : '' }}>
                                <label class="radioLabel2" for="Neuropathyspot">Nephropathy</label><br><span>(spot / 24-hr / timed urine collection / + micral / albuminuria on routine urinalysis)</span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" width="50">
                                <input type="checkbox" name="neuropathysensory" id="Neuropathy" 
                                value="{{ $diabetesInfo ? $diabetesInfo->neuropathysensory == 'yes' ? 'yes' : 'no' : 'no' }}"
                                {{ $diabetesInfo ? $diabetesInfo->neuropathysensory == 'yes' ? 'checked' : '' : '' }}>
                                <label class="radioLabel2" for="Neuropathy">Neuropathy</label><span>(sensory / motor deficits / &#8595; NCV )</span>
                            </td>
                            <td colspan="4" width="100">
                                <input type="checkbox" name="coronaryarterydisease" id="Coronary" 
                                value="{{ $diabetesInfo ? $diabetesInfo->coronaryarterydisease == 'yes' ? 'yes' : 'no' : 'no' }}"
                                {{ $diabetesInfo ? $diabetesInfo->coronaryarterydisease == 'yes' ? 'checked' : '' : '' }}>
                                <label class="radioLabel2" for="Coronary">Coronary artery disease (CAD)</label><br><span>(+ chest pain w/ or w/o diaphoresis / AbN ECG / + angiography)</span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" width="50">
                                <input type="checkbox" name="peripheralvasculardisease" id="Peripheral" 
                                value="{{ $diabetesInfo ? $diabetesInfo->peripheralvasculardisease == 'yes' ? 'yes' : 'no' : 'no' }}"
                                {{ $diabetesInfo ? $diabetesInfo->peripheralvasculardisease == 'yes' ? 'checked' : '' : '' }}>
                                <label class="radioLabel2" for="Peripheral">Peripheral vascular disease (PVD)</label><span>(sensory / motor deficits / )</span>
                            </td>
                            <td colspan="8" width="50">
                                <input type="checkbox" name="cerebrovasculardisease" id="Cerebrovascular" 
                                value="{{ $diabetesInfo ? $diabetesInfo->cerebrovasculardisease == 'yes' ? 'yes' : 'no' : 'no' }}"
                                {{ $diabetesInfo ? $diabetesInfo->cerebrovasculardisease == 'yes' ? 'checked' : '' : '' }}>
                                <label class="radioLabel2" for="Cerebrovascular">Cerebrovascular disease (CVD)</label><span>(+ paralysis /+ infarct on CT Scan)</span>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6" style="padding-right: 0px;padding-left: 0px;">
                    <table class="table table-bordered table-condensed">
                        <tr>
                            <td colspan="3" class="">Referrals</td>
                        </tr>
                        <tr>
                            <td colspan="" width="">
                                <input type="checkbox" name="cardiologist" id="Cardiologist" 
                                value="{{ $diabetesInfo ? $diabetesInfo->cardiologist == 'yes' ? 'yes' : 'no' : 'no' }}"
                                {{ $diabetesInfo ? $diabetesInfo->cardiologist == 'yes' ? 'checked' : '' : '' }}>
                                <label class="radioLabel2" for="Cardiologist">Cardiologist</label>
                            </td>
                            <td colspan="" width="">
                                <input type="checkbox" name="nutritionistdietician" id="NutritionistDietician" 
                                value="{{ $diabetesInfo ? $diabetesInfo->nutritionistdietician == 'yes' ? 'yes' : 'no' : 'no' }}"
                                {{ $diabetesInfo ? $diabetesInfo->nutritionistdietician == 'yes' ? 'checked' : '' : '' }}>
                                <label class="radioLabel2" for="NutritionistDietician">Nutritionist Dietician</label>
                            </td>
                            <td colspan="" width="">
                                <input type="checkbox" name="endocrinologist" id="Endocrinologist" 
                                value="{{ $diabetesInfo ? $diabetesInfo->endocrinologist == 'yes' ? 'yes' : 'no' : 'no' }}"
                                {{ $diabetesInfo ? $diabetesInfo->endocrinologist == 'yes' ? 'checked' : '' : '' }}>
                                <label class="radioLabel2" for="Endocrinologist">Endocrinologist</label>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="" width="">
                                <input type="checkbox" name="nephrologist" id="Nephrologist" 
                                value="{{ $diabetesInfo ? $diabetesInfo->nephrologist == 'yes' ? 'yes' : 'no' : 'no' }}"
                                {{ $diabetesInfo ? $diabetesInfo->nephrologist == 'yes' ? 'checked' : '' : '' }}>
                                <label class="radioLabel2" for="Nephrologist">Nephrologist</label>
                            </td>
                            <td colspan="" width="">
                                <input type="checkbox" name="neurologist" id="Neurologist" 
                                value="{{ $diabetesInfo ? $diabetesInfo->neurologist == 'yes' ? 'yes' : 'no' : 'no' }}"
                                {{ $diabetesInfo ? $diabetesInfo->neurologist == 'yes' ? 'checked' : '' : '' }}>
                                <label class="radioLabel2" for="Neurologist">Neurologist</label>
                            </td>
                            <td colspan="" width="">
                                <input type="checkbox" name="ophthalmologist" id="Ophthalmologist" 
                                value="{{ $diabetesInfo ? $diabetesInfo->ophthalmologist == 'yes' ? 'yes' : 'no' : 'no' }}"
                                {{ $diabetesInfo ? $diabetesInfo->ophthalmologist == 'yes' ? 'checked' : '' : '' }}>
                                <label class="radioLabel2" for="Ophthalmologist">Ophthalmologist</label>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="" width="">
                                <input type="checkbox" name="orthopedicssurgeon" id="OrthopedicsSurgeon" 
                                value="{{ $diabetesInfo ? $diabetesInfo->orthopedicssurgeon == 'yes' ? 'yes' : 'no' : 'no' }}"
                                {{ $diabetesInfo ? $diabetesInfo->orthopedicssurgeon == 'yes' ? 'checked' : '' : '' }}>
                                <label class="radioLabel2" for="OrthopedicsSurgeon">Orthopedics Surgeon</label>
                            </td>
                            <td colspan="" width="">
                                <input type="checkbox" name="vascularsurgeon" id="VascularSurgeon" 
                                value="{{ $diabetesInfo ? $diabetesInfo->vascularsurgeon == 'yes' ? 'yes' : 'no' : 'no' }}"
                                {{ $diabetesInfo ? $diabetesInfo->vascularsurgeon == 'yes' ? 'checked' : '' : '' }}>
                                <label class="radioLabel2" for="VascularSurgeon">Vascular Surgeon</label>
                            </td>
                            <td colspan="" width="">
                                <input type="checkbox" name="physicaltherapist" id="PhysicalTherapist" 
                                value="{{ $diabetesInfo ? $diabetesInfo->physicaltherapist == 'yes' ? 'yes' : 'no' : 'no' }}"
                                {{ $diabetesInfo ? $diabetesInfo->physicaltherapist == 'yes' ? 'checked' : '' : '' }}>
                                <label class="radioLabel2" for="PhysicalTherapist">Physical Therapist</label>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" width="">
                                <input type="checkbox" class="iv_Others" name="referralsothers" id="ReferralsOthers" 
                                value="{{ $diabetesInfo ? $diabetesInfo->referralsothers == 'yes' ? 'yes' : 'no' : 'no' }}"
                                {{ $diabetesInfo ? $diabetesInfo->referralsothers == 'yes' ? 'checked' : '' : '' }}>
                                <label class="radioLabel2" for="ReferralsOthers">Others:</label>
                                <textarea name="referralsotherscontent" class="form-control input-sm" 
                                {{ $diabetesInfo ? $diabetesInfo->referralsothers == 'yes' ? '' : 'disabled' : 'disabled' }}>{{ $diabetesInfo ? $diabetesInfo->referralsotherscontent ? $diabetesInfo->referralsotherscontent : '' : '' }}</textarea>
                            </td>
                        </tr>
                    </table>
                </div>
            </form>
         </div>
        </div>
        <br>
                <div class="clearfix visible-lg-block"></div>
                <div class="col-md-12" style="padding-left: 0px; padding-right: 0px;">
                    <div class="panel panel-default">
                      <div class="panel-heading" style="background-color: #626567; color: white">
                        <h3 class="panel-title PATIENTRECORD-FOLLOW-UPASSESSMENTFORM">PATIENT RECORD - FOLLOW - UP ASSESSMENT FORM</h3>
                      </div>
                      <div class="panel-body">
                        <div class="table-scroll" id="table-scroll">
                        <form class="follow-up">
                            <table class="table table-bordered table-condensed main-table" id="main-table">
                                <tr>
                                    <input type="hidden" class="hidden-did" name="did" value="{{ $diabetesFollowup ? $diabetesInfo->id ? $diabetesInfo->id : '' : '' }}">
                                    @if($diabetesFollowup)
                                        @if(Carbon::parse($lastfollowup->created_at)->format('m/d/Y') == Carbon::now()->format('m/d/Y'))
                                            <input type="hidden" class="" name="id" value="{{ $diabetesFollowup ? $lastfollowup->id ? $lastfollowup->id : '' : '' }}">
                                        @endif
                                    @endif
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle">Date <kbd>(mm/dd/yy)</kbd></td>
                                    @if($diabetesFollowup)
                                        @foreach($diabetesFollowup as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; @endphp
                                            <td class="diabetes-input">
                                                <input type="text" name="" class="form-control input-sm {{ $disabled != 'readonly' ? 'date_picker' : '' }}  date_followUp" 
                                                value="{{ Carbon::parse($info->created_at)->format('m/d/Y') }}" {{ $disabled }}>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" 
                                                class="form-control input-sm {{ $disabled == 'readonly' ? $counter2 == 0 ? 'date_picker' : '' : ''}}"
                                                value="{{ $disabled == 'readonly' ? $counter2 == 0 ? Carbon::now()->format('m/d/Y') : '' : ''}}">
                                            </td>
                                            @php $counter2++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm {{ $counter3 == 0 ? 'date_picker' : '' }}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle">Blood Sugar <kbd>(FBS/RBS)</kbd></td>
                                    @if($diabetesFollowup)
                                        @foreach($diabetesFollowup as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; @endphp
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? '' : 'bloodsugar' }}" 
                                                value="{{ $diabetesFollowup ? $info->bloodsugar ? $info->bloodsugar : '' : '' }}" {{ $disabled }}>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'bloodsugar' : '' : ''}}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $counter3 == 0 ? 'bloodsugar' : '' }}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td colspan="5" class="medicalHistoryAlphabeth">Progress notes</td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle">Polyuria</td>
                                    @if($diabetesFollowup)
                                        @foreach($diabetesFollowup as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'disabled'; $counter3 = 0; @endphp
                                            <td class="diabetes-input text-center">
                                                <input type="checkbox" name="{{ $disabled == 'disabled' ? '' : 'polyuria' }}" 
                                                value="{{ $diabetesFollowup ? $info->polyuria == 'yes' ? 'yes' : 'no' : 'no' }}"
                                                {{ $diabetesFollowup ? $info->polyuria == 'yes' ? 'checked' : '' : '' }}>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input text-center">
                                                <input type="checkbox" name="{{ $disabled == 'disabled' ? $counter3 == 0 ? 'polyuria' : '' : ''}}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input text-center">
                                                <input type="checkbox" name="{{ $counter3 == 0 ? 'polyuria' : '' }}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle">Polydipsia</td>
                                    @if($diabetesFollowup)
                                        @foreach($diabetesFollowup as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'disabled'; $counter3 = 0; @endphp
                                            <td class="diabetes-input text-center">
                                                <input type="checkbox" name="{{ $disabled == 'disabled' ? '' : 'polydipsia' }}" 
                                                value="{{ $diabetesFollowup ? $info->polydipsia == 'yes' ? 'yes' : 'no' : 'no' }}"
                                                {{ $diabetesFollowup ? $info->polydipsia == 'yes' ? 'checked' : '' : '' }}>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input text-center">
                                                <input type="checkbox" name="{{ $disabled == 'disabled' ? $counter3 == 0 ? 'polydipsia' : '' : ''}}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input text-center">
                                                <input type="checkbox" name="{{ $counter3 == 0 ? 'polydipsia' : '' }}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle">Weight loss</td>
                                    @if($diabetesFollowup)
                                        @foreach($diabetesFollowup as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'disabled'; $counter3 = 0; @endphp
                                            <td class="diabetes-input text-center">
                                                <input type="checkbox" name="{{ $disabled == 'disabled' ? '' : 'weightloss' }}" 
                                                value="{{ $diabetesFollowup ? $info->weightloss == 'yes' ? 'yes' : 'no' : 'no' }}"
                                                {{ $diabetesFollowup ? $info->weightloss == 'yes' ? 'checked' : '' : '' }}>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input text-center">
                                                <input type="checkbox" name="{{ $disabled == 'disabled' ? $counter3 == 0 ? 'weightloss' : '' : ''}}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input text-center">
                                                <input type="checkbox" name="{{ $counter3 == 0 ? 'weightloss' : '' }}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle">Tengling sensation</td>
                                    @if($diabetesFollowup)
                                        @foreach($diabetesFollowup as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'disabled'; $counter3 = 0; @endphp
                                            <td class="diabetes-input text-center">
                                                <input type="checkbox" name="{{ $disabled == 'disabled' ? '' : 'tenglingsensation' }}" 
                                                value="{{ $diabetesFollowup ? $info->tenglingsensation == 'yes' ? 'yes' : 'no' : 'no' }}"
                                                {{ $diabetesFollowup ? $info->tenglingsensation == 'yes' ? 'checked' : '' : '' }}>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input text-center">
                                                <input type="checkbox" name="{{ $disabled == 'disabled' ? $counter3 == 0 ? 'tenglingsensation' : '' : ''}}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input text-center">
                                                <input type="checkbox" name="{{ $counter3 == 0 ? 'tenglingsensation' : '' }}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle">Non-healing wound</td>
                                    @if($diabetesFollowup)
                                        @foreach($diabetesFollowup as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'disabled'; $counter3 = 0; @endphp
                                            <td class="diabetes-input text-center">
                                                <input type="checkbox" name="{{ $disabled == 'disabled' ? '' : 'nonhealingwound' }}" 
                                                value="{{ $diabetesFollowup ? $info->nonhealingwound == 'yes' ? 'yes' : 'no' : 'no' }}"
                                                {{ $diabetesFollowup ? $info->nonhealingwound == 'yes' ? 'checked' : '' : '' }}>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input text-center">
                                                <input type="checkbox" name="{{ $disabled == 'disabled' ? $counter3 == 0 ? 'nonhealingwound' : '' : ''}}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input text-center">
                                                <input type="checkbox" name="{{ $counter3 == 0 ? 'nonhealingwound' : '' }}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle">Others</b> <kbd>(Specify)</</td>
                                    @if($diabetesFollowup)
                                        @foreach($diabetesFollowup as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td>
                                                <textarea class="form-control input-sm notes_others" name="{{ $disabled == 'readonly' ? '' : 'notes_others' }}" {{ $disabled }}>{{ $diabetesFollowup ? $info->notes_others ? $info->notes_others : '' : '' }}</textarea>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td>
                                                <textarea class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'notes_others' : '' : ''}}"></textarea>
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td>
                                                <textarea class="form-control input-sm" name="{{ $counter3 == 0 ? 'notes_others' : '' }}"></textarea>
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td colspan="5" class="medicalHistoryAlphabeth">Physical Examination</td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle">Waist & Hip circ</td>
                                    @if($diabetesFollowup)
                                        @foreach($diabetesFollowup as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? '' : 'waist' }}" 
                                                value="{{ $diabetesFollowup ? $info->waist ? $info->waist : '' : '' }}" {{ $disabled }}>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'waist' : '' : ''}}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $counter3 == 0 ? 'waist' : '' }}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle">Weight</td>
                                    @if($diabetesFollowup)
                                        @foreach($diabetesFollowup as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? '' : 'weight' }}" 
                                                value="{{ $diabetesFollowup ? $info->weight ? $info->weight : '' : '' }}" {{ $disabled }}>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'weight' : '' : ''}}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $counter3 == 0 ? 'weight' : '' }}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle">BP</td>
                                    @if($diabetesFollowup)
                                        @foreach($diabetesFollowup as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? '' : 'bp' }}" 
                                                value="{{ $diabetesFollowup ? $info->bp ? $info->bp : '' : '' }}" {{ $disabled }}>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'bp' : '' : ''}}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $counter3 == 0 ? 'bp' : '' }}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle">Heart rate</td>
                                    @if($diabetesFollowup)
                                        @foreach($diabetesFollowup as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'disabled' ? '' : 'heartrate' }}" 
                                                value="{{ $diabetesFollowup ? $info->heartrate ? $info->heartrate : '' : '' }}" {{ $disabled }}>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'heartrate' : '' : ''}}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $counter3 == 0 ? 'heartrate' : '' }}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle">Respiratory</td>
                                    @if($diabetesFollowup)
                                        @foreach($diabetesFollowup as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? '' : 'respiratory' }}" 
                                                value="{{ $diabetesFollowup ? $info->respiratory ? $info->respiratory : '' : '' }}" {{ $disabled }}>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'respiratory' : '' : ''}}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $counter3 == 0 ? 'respiratory' : '' }}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle">Temperature</td>
                                    @if($diabetesFollowup)
                                        @foreach($diabetesFollowup as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? '' : 'temperature' }}" 
                                                value="{{ $diabetesFollowup ? $info->temperature ? $info->temperature : '' : '' }}" {{ $disabled }}>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'temperature' : '' : ''}}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $counter3 == 0 ? 'temperature' : '' }}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle">HEENT & Neck</td>
                                    @if($diabetesFollowup)
                                        @foreach($diabetesFollowup as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? '' : 'heent' }}"
                                                value="{{ $diabetesFollowup ? $info->heent ? $info->heent : '' : '' }}" {{ $disabled }}>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'heent' : '' : ''}}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $counter3 == 0 ? 'heent' : '' }}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle">Chest & Lungs</td>
                                    @if($diabetesFollowup)
                                        @foreach($diabetesFollowup as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? '' : 'chest' }}" 
                                                value="{{ $diabetesFollowup ? $info->chest ? $info->chest : '' : '' }}" {{ $disabled }}>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'chest' : '' : ''}}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $counter3 == 0 ? 'chest' : '' }}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle">Heart</td>
                                    @if($diabetesFollowup)
                                        @foreach($diabetesFollowup as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? '' : 'heart' }}" 
                                                value="{{ $diabetesFollowup ? $info->heart ? $info->heart : '' : '' }}" {{ $disabled }}>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'heart' : '' : ''}}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $counter3 == 0 ? 'heart' : '' }}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle">Abdomen</td>
                                    @if($diabetesFollowup)
                                        @foreach($diabetesFollowup as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? '' : 'abdomen' }}"
                                                value="{{ $diabetesFollowup ? $info->abdomen ? $info->abdomen : '' : '' }}" {{ $disabled }}>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'abdomen' : '' : ''}}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $counter3 == 0 ? 'abdomen' : '' }}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle">Skin Extremities</td>
                                    @if($diabetesFollowup)
                                        @foreach($diabetesFollowup as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? '' : 'skinextermity' }}"
                                                value="{{ $diabetesFollowup ? $info->skinextermity ? $info->skinextermity : '' : '' }}" {{ $disabled }}>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'skinextermity' : '' : ''}}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $counter3 == 0 ? 'skinextermity' : '' }}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle">Foot Exam</td>
                                    @if($diabetesFollowup)
                                        @foreach($diabetesFollowup as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? '' : 'footexam' }}"
                                                value="{{ $diabetesFollowup ? $info->footexam ? $info->footexam : '' : '' }}" {{ $disabled }}>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'footexam' : '' : ''}}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $counter3 == 0 ? 'footexam' : '' }}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle">Neurological findings</td>
                                    @if($diabetesFollowup)
                                        @foreach($diabetesFollowup as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? '' : 'neurologicalfinding' }}"
                                                value="{{ $diabetesFollowup ? $info->neurologicalfinding ? $info->neurologicalfinding : '' : '' }}" {{ $disabled }}>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'neurologicalfinding' : '' : ''}}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $counter3 == 0 ? 'neurologicalfinding' : '' }}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle">PLANS:</td>
                                    @if($diabetesFollowup)
                                        @foreach($diabetesFollowup as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? '' : 'plans' }}"
                                                value="{{ $diabetesFollowup ? $info->plans ? $info->plans : '' : '' }}" {{ $disabled }}>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'plans' : '' : ''}}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $counter3 == 0 ? 'plans' : '' }}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td colspan="5" class="medicalHistoryAlphabeth">Medications</td>
                                </tr>
                                <tr>
                                    <td><b>A. Oral antidiabetic</b></td>
                                    @if($diabetesFollowup)
                                        @foreach($diabetesFollowup as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td>
                                                <input type="checkbox" name="{{ $disabled == 'readonly' ? '' : 'sameregimenOral' }}" id="{{ $info->id.'sameregimen' }}"
                                                 value="{{ $diabetesFollowup ? $info->sameregimenOral == 'yes' ? 'yes' : 'no' : 'no' }}" 
                                                 {{ $diabetesFollowup ? $info->sameregimenOral == 'yes' ? 'checked' : '' : '' }}>
                                                <label class="radioLabel2" for="{{ $info->id.'sameregimen' }}">Same regimen</label>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td>
                                                <input type="checkbox" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'sameregimenOral' : '' : ''}}" 
                                                id="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'Sameregimen' : '' : ''}}" value="no">
                                                <label class="radioLabel2" for="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'Sameregimen' : '' : ''}}">Same regimen</label>
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td>
                                                <input type="checkbox" name="{{ $counter3 == 0 ? 'sameregimenOral' : ''}}" 
                                                id="{{ $counter3 == 0 ? 'Sameregimen' : ''}}" value="no">
                                                <label class="radioLabel2" for="{{ $counter3 == 0 ? 'Sameregimen' : ''}}">Same regimen</label>
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" name="sulfonylureaOral" id="sulfonylureaOral" value="{{ $diabetesFollowup ? $diabetesFollowup[count($diabetesFollowup)-1]->sulfonylureaOral == 'yes' ? 'yes' : 'no' : 'no' }}" {{ $diabetesFollowup ? $diabetesFollowup[count($diabetesFollowup)-1]->sulfonylureaOral == 'yes' ? 'checked' : '' : '' }}>
                                        <label class="radioLabel2" for="sulfonylureaOral">Sulfonylurea</label>
                                    </td>
                                    @if($diabetesFollowup)
                                        @foreach($diabetesFollowup as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td rowspan="3">
                                                <input type="checkbox" name="{{ $disabled == 'readonly' ? '' : 'changetoSulfonylurea' }}" id="{{ $info->id.'sulfonylurea' }}" 
                                                value="{{ $diabetesFollowup ? $info->changetoSulfonylurea == 'yes' ? 'yes' : 'no' : 'no' }}"
                                                {{ $diabetesFollowup ? $info->changetoSulfonylurea == 'yes' ? 'checked' : '' : '' }}>

                                                <label class="radioLabel2" for="{{ $info->id.'sulfonylurea' }}">change to</label>
                                                <textarea class="form-control input-sm txtareaSulfonylurea" rows="3" name="{{ $disabled == 'readonly' ? '' : 'txtareaSulfonylurea' }}"
                                                {{ $disabled }}>{{ $diabetesFollowup ? $info->txtareaSulfonylurea ? $info->txtareaSulfonylurea : '' : '' }}</textarea>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td rowspan="3">
                                                <input type="checkbox" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'changetoSulfonylurea' : '' : ''}}" 
                                                id="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'changeto2Sulfonylurea' : '' : ''}}" value="no">
                                                <label class="radioLabel2" for="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'changeto2Sulfonylurea' : '' : ''}}">change to</label>
                                                <textarea class="form-control input-sm" rows="3" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'txtareaSulfonylurea' : '' : '' }}"></textarea>
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td rowspan="3">
                                                <input type="checkbox" name="{{ $counter3 == 0 ? 'changetoSulfonylurea' : ''}}" 
                                                id="{{ $counter3 == 0 ? 'changeto2Sulfonylurea' : ''}}" value="no">
                                                <label class="radioLabel2" for="{{ $counter3 == 0 ? 'changeto2Sulfonylurea' : ''}}">change to</label>
                                                <textarea class="form-control input-sm" rows="3" name="{{ $counter3 == 0 ? 'txtareaSulfonylurea' : '' }}"></textarea>
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td><input type="checkbox" name="metforminOral" id="metforminOral" value="{{ $diabetesFollowup ? $diabetesFollowup[count($diabetesFollowup)-1]->metforminOral == 'yes' ? 'yes' : 'no' : 'no' }}" {{ $diabetesFollowup ? $diabetesFollowup[count($diabetesFollowup)-1]->metforminOral == 'yes' ? 'checked' : '' : '' }}> <label class="radioLabel2" for="metforminOral">Metformin</label></td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" name="acarboseOral" id="acarboseOral" value="{{ $diabetesFollowup ? $diabetesFollowup[count($diabetesFollowup)-1]->acarboseOral == 'yes' ? 'yes' : 'no' : 'no' }}" {{ $diabetesFollowup ? $diabetesFollowup[count($diabetesFollowup)-1]->acarboseOral == 'yes' ? 'checked' : '' : '' }}> <label class="radioLabel2" for="acarboseOral">Acarbose</label></td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" name="tzdOral" class="tzdOral" id="TZDOral" value="{{ $diabetesFollowup ? $diabetesFollowup[count($diabetesFollowup)-1]->tzdOral == 'yes' ? 'yes' : 'no' : 'no' }}" {{ $diabetesFollowup ? $diabetesFollowup[count($diabetesFollowup)-1]->tzdOral == 'yes' ? 'checked' : '' : '' }}> <label class="radioLabel2" for="TZDOral">TZD</label></td>
                                    @if($diabetesFollowup)
                                        @foreach($diabetesFollowup as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td rowspan="2">
                                                <input type="checkbox" name="{{ $disabled == 'readonly' ? '' : 'addMetformin' }}" class="addMetformin" id="{{ $info->id.'metformin' }}" 
                                                value="{{ $diabetesFollowup ? $info->addMetformin == 'yes' ? 'yes' : 'no' : 'no' }}"
                                                {{ $diabetesFollowup ? $info->addMetformin == 'yes' ? 'checked' : '' : '' }}>

                                                <label class="radioLabel2" for="{{ $info->id.'metformin' }}">Add</label>
                                                <textarea rows="4" class="form-control input-sm txtareaMetformin" name="{{ $disabled == 'readonly' ? '' : 'txtareaMetformin' }}" 
                                                {{ $disabled }}>{{ $diabetesFollowup ? $info->txtareaMetformin ? $info->txtareaMetformin : '' : '' }}</textarea>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td rowspan="2">
                                                <input type="checkbox" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'addMetformin' : '' : ''}}" 
                                                id="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'add2Metformin' : '' : ''}}" value="no">
                                                <label class="radioLabel2" for="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'add2Metformin' : '' : ''}}">Add</label>
                                                <textarea rows="4" class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'txtareaMetformin' : '' : '' }}"></textarea>
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td rowspan="2">
                                                <input type="checkbox" name="{{ $counter3 == 0 ? 'addMetformin' : ''}}" 
                                                id="{{ $counter3 == 0 ? 'add2Metformin' : ''}}" value="no">
                                                <label class="radioLabel2" for="{{ $counter3 == 0 ? 'add2Metformin' : ''}}">Add</label>
                                                <textarea rows="4" class="form-control input-sm" name="{{ $counter3 == 0 ? 'txtareaMetformin' : '' }}"></textarea>
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" name="tzdOthersOral" class="tzdOthersOral" id="TZDOthersOral" value="{{ $diabetesFollowup ? $diabetesFollowup[count($diabetesFollowup)-1]->tzdOthersOral == 'yes' ? 'yes' : 'no' : 'no' }}" {{ $diabetesFollowup ? $diabetesFollowup[count($diabetesFollowup)-1]->tzdOthersOral == 'yes' ? 'checked' : '' : '' }}>
                                        <label class="radioLabel2" for="TZDOthersOral">Others: Specify</label>
                                        <textarea name="txtareaTzdOthersOral" class="form-control input-sm txtareaTzdOthersOral">{{ $diabetesFollowup ? $diabetesFollowup[count($diabetesFollowup)-1]->txtareaTzdOthersOral ? $diabetesFollowup[count($diabetesFollowup)-1]->txtareaTzdOthersOral : '' : '' }}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>B. Insulin</b> (units/day)</td>
                                    @if($diabetesFollowup)
                                        @foreach($diabetesFollowup as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td>
                                                <input type="checkbox" name="{{ $disabled == 'readonly' ? '' : 'sameregimenInsulin' }}" id="{{ $info->id.'sameregimen2' }}" 
                                                value="{{ $diabetesFollowup ? $info->sameregimenInsulin == 'yes' ? 'yes' : 'no' : 'no' }}"
                                                {{ $diabetesFollowup ? $info->sameregimenInsulin == 'yes' ? 'checked' : '' : '' }}>
                                                <label class="radioLabel2" for="{{ $info->id.'sameregimen2' }}">Same regimen</label>
                                                <textarea class="form-control input-sm txtareaInsulin" rows="3" name="{{ $disabled == 'readonly' ? '' : 'txtareaInsulin' }}" 
                                                {{ $disabled }}>{{ $diabetesFollowup ? $info->txtareaInsulin ? $info->txtareaInsulin : '' : '' }}</textarea>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td>
                                                <input type="checkbox" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'sameregimenInsulin' : '' : ''}}" 
                                                id="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'Sameregimen2' : '' : ''}}" value="no">
                                                <label class="radioLabel2" for="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'Sameregimen2' : '' : ''}}">Same regimen</label>
                                                <textarea class="form-control input-sm" rows="3" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'txtareaInsulin' : '' : ''}}"></textarea>
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td>
                                                <input type="checkbox" name="{{ $counter3 == 0 ? 'sameregimenInsulin' : ''}}" 
                                                id="{{ $counter3 == 0 ? 'Sameregimen2' : '' }}" value="no">
                                                <label class="radioLabel2" for="{{ $counter3 == 0 ? 'Sameregimen2' : '' }}">Same regimen</label>
                                                <textarea class="form-control input-sm" rows="3" name="{{ $counter3 == 0 ? 'txtareaInsulin' : '' }}"></textarea>
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" name="regularInsulin" id="regularInsulin" value="{{ $diabetesFollowup ? $diabetesFollowup[count($diabetesFollowup)-1]->regularInsulin == 'yes' ? 'yes' : 'no' : 'no' }}" {{ $diabetesFollowup ? $diabetesFollowup[count($diabetesFollowup)-1]->regularInsulin == 'yes' ? 'checked' : '' : '' }}> <label class="radioLabel2" for="regularInsulin">Regular</label>
                                    </td>
                                    @if($diabetesFollowup)
                                        @foreach($diabetesFollowup as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td rowspan="3">
                                                <input type="checkbox" name="{{ $disabled == 'readonly' ? '' : 'changetoRegular' }}" class="changetoRegular" id="{{ $info->id.'regular' }}"
                                                value="{{ $diabetesFollowup ? $info->changetoRegular == 'yes' ? 'yes' : 'no' : 'no' }}"
                                                {{ $diabetesFollowup ? $info->changetoRegular == 'yes' ? 'checked' : '' : '' }}>
                                                <label class="radioLabel2" for="{{ $info->id.'regular' }}">change to</label>
                                                <textarea class="form-control input-sm txtareaRegular" rows="3" name="{{ $disabled == 'readonly' ? '' : 'txtareaRegular' }}" 
                                                {{ $disabled }}>{{ $diabetesFollowup ? $info->txtareaRegular ? $info->txtareaRegular : '' : '' }}</textarea>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td rowspan="3">
                                                <input type="checkbox" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'changetoRegular' : '' : ''}}" 
                                                id="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'changeto2Regular' : '' : ''}}" value="no">
                                                <label class="radioLabel2" for="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'changeto2Regular' : '' : ''}}">change to</label>
                                                <textarea class="form-control input-sm" rows="3" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'txtareaRegular' : '' : ''}}"></textarea>
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td rowspan="3">
                                                <input type="checkbox" name="{{ $counter3 == 0 ? 'changetoRegular' : '' }}" 
                                                id="{{ $counter3 == 0 ? 'changeto2Regular' : '' }}" value="no">
                                                <label class="radioLabel2" for="{{ $counter3 == 0 ? 'changeto2Regular' : '' }}">change to</label>
                                                <textarea class="form-control input-sm" rows="3" name="{{ $counter3 == 0 ? 'txtareaRegular' : '' }}"></textarea>
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" name="intermediateRegular" id="intermediateRegular" value="{{ $diabetesFollowup ? $diabetesFollowup[count($diabetesFollowup)-1]->intermediateRegular == 'yes' ? 'yes' : 'no' : 'no' }}" {{ $diabetesFollowup ? $diabetesFollowup[count($diabetesFollowup)-1]->intermediateRegular == 'yes' ? 'checked' : '' : '' }}> <label class="radioLabel2" for="intermediateRegular">Intermediate</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" name="mixedInsulin" id="mixedInsulin" value="{{ $diabetesFollowup ? $diabetesFollowup[count($diabetesFollowup)-1]->mixedInsulin == 'yes' ? 'yes' : 'no' : 'no' }}" {{ $diabetesFollowup ? $diabetesFollowup[count($diabetesFollowup)-1]->mixedInsulin == 'yes' ? 'checked' : '' : '' }}> <label class="radioLabel2" for="mixedInsulin">Mixed</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" name="longActing" class="LongActing" id="LongActing" value="{{ $diabetesFollowup ? $diabetesFollowup[count($diabetesFollowup)-1]->longActing == 'yes' ? 'yes' : 'no' : 'no' }}" {{ $diabetesFollowup ? $diabetesFollowup[count($diabetesFollowup)-1]->longActing == 'yes' ? 'checked' : '' : '' }}> <label class="radioLabel2" for="LongActing">Long Acting</label>
                                    </td>
                                    @if($diabetesFollowup)
                                        @foreach($diabetesFollowup as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td rowspan="2">
                                                <input type="checkbox" name="{{ $disabled == 'readonly' ? '' : 'addIntermediate' }}" id="{{ $info->id.'Add1Intermediate' }}" 
                                                value="{{ $diabetesFollowup ? $info->addIntermediate == 'yes' ? 'yes' : 'no' : 'no' }}"
                                                {{ $diabetesFollowup ? $info->addIntermediate == 'yes' ? 'checked' : '' : '' }}>
                                                <label class="radioLabel2" for="{{ $info->id.'Add1Intermediate' }}">Add</label>
                                                <textarea class="form-control input-sm txtareaIntermediate" rows="4" name="{{ $disabled == 'readonly' ? '' : 'txtareaIntermediate' }}"
                                                {{ $disabled }}>{{ $diabetesFollowup ? $info->txtareaIntermediate ? $info->txtareaIntermediate : '' : '' }}</textarea>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td rowspan="2">
                                                <input type="checkbox" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'addIntermediate' : '' : ''}}" 
                                                id="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'Add2Intermediate' : '' : ''}}" value="no">
                                                <label class="radioLabel2" for="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'Add2Intermediate' : '' : ''}}">Add</label>
                                                <textarea class="form-control input-sm" rows="4" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'txtareaIntermediate' : '' : ''}}"></textarea>
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td rowspan="2">
                                                <input type="checkbox" name="{{ $counter3 == 0 ? 'addIntermediate' : '' }}" 
                                                id="{{ $counter3 == 0 ? 'Add2Intermediate' : ''}}" value="no">
                                                <label class="radioLabel2" for="{{ $counter3 == 0 ? 'Add2Intermediate' : '' }}">Add</label>
                                                <textarea class="form-control input-sm" rows="4" name="{{ $counter3 == 0 ? 'txtareaIntermediate' : '' }}"></textarea>
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" name="antihypertensiveOthers" class="antihypertensiveOthers" id="antihypertensiveOthers" value="{{ $diabetesFollowup ? $diabetesFollowup[count($diabetesFollowup)-1]->antihypertensiveOthers == 'yes' ? 'yes' : 'no' : 'no' }}" {{ $diabetesFollowup ? $diabetesFollowup[count($diabetesFollowup)-1]->antihypertensiveOthers == 'yes' ? 'checked' : '' : '' }}>
                                        <label class="radioLabel2" for="antihypertensiveOthers">Others: Specify</label>
                                        <textarea name="txtareaAntihypertensiveOthers" class="form-control input-sm txtareaAntihypertensiveOthers input-sm">{{ $diabetesFollowup ? $diabetesFollowup[count($diabetesFollowup)-1]->txtareaAntihypertensiveOthers ? $diabetesFollowup[count($diabetesFollowup)-1]->txtareaAntihypertensiveOthers : '' : '' }}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>C. Antihypertensive</b></td>
                                    @if($diabetesFollowup)
                                        @foreach($diabetesFollowup as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td>
                                                <input type="checkbox" name="{{ $disabled == 'readonly' ? '' : 'sameregimenAntihypertensive' }}" id="{{ $info->id.'sameregimen1' }}" 
                                                value="{{ $diabetesFollowup ? $info->sameregimenAntihypertensive == 'yes' ? 'yes' : 'no' : 'no' }}"
                                                {{ $diabetesFollowup ? $info->sameregimenAntihypertensive == 'yes' ? 'checked' : '' : '' }}>
                                                <label class="radioLabel2" for="{{ $info->id.'sameregimen1' }}">Same regimen</label>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td>
                                                <input type="checkbox" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'sameregimenAntihypertensive' : '' : ''}}" 
                                                id="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'Sameregimen3' : '' : ''}}" value="no">
                                                <label class="radioLabel2" for="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'Sameregimen3' : '' : ''}}">Same regimen</label>
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td>
                                                <input type="checkbox" name="{{ $counter3 == 0 ? 'sameregimenAntihypertensive' : '' }}" 
                                                id="{{ $counter3 == 0 ? 'Sameregimen3' : '' }}" value="no">
                                                <label class="radioLabel2" for="{{ $counter3 == 0 ? 'Sameregimen3' : '' }}">Same regimen</label>
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" name="aceInhibitor" id="antihypertensiveACEinhibitora" value="{{ $diabetesFollowup ? $diabetesFollowup[count($diabetesFollowup)-1]->aceInhibitor == 'yes' ? 'yes' : 'no' : 'no' }}" {{ $diabetesFollowup ? $diabetesFollowup[count($diabetesFollowup)-1]->aceInhibitor == 'yes' ? 'checked' : '' : '' }}> <label class="radioLabel2" for="antihypertensiveACEinhibitora">ACE inhibitor</label>
                                    </td>
                                    @if($diabetesFollowup)
                                        @foreach($diabetesFollowup as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td rowspan="2">
                                                <input type="checkbox" name="{{ $disabled == 'readonly' ? '' : 'acechangeto' }}" id="{{ $info->id.'ACEchangeto1' }}" 
                                                value="{{ $diabetesFollowup ? $info->acechangeto == 'yes' ? 'yes' : 'no' : 'no' }}"
                                                {{ $diabetesFollowup ? $info->acechangeto == 'yes' ? 'checked' : '' : '' }}>
                                                <label class="radioLabel2" class="ACEchangeto1" for="{{ $info->id.'ACEchangeto1' }}">change to</label>
                                                <textarea class="form-control input-sm txtareaACE" name="{{ $disabled == 'readonly' ? '' : 'txtareaACE' }}"
                                                {{ $disabled }}>{{ $diabetesFollowup ? $info->txtareaACE ? $info->txtareaACE : '' : '' }}</textarea>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td rowspan="2">
                                                <input type="checkbox" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'acechangeto' : '' : ''}}" 
                                                id="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'ACEchangeto2' : '' : ''}}" value="no">
                                                <label class="radioLabel2" class="ACEchangeto2" for="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'ACEchangeto2' : '' : ''}}">change to</label>
                                                <textarea class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'txtareaACE' : '' : ''}}"></textarea>
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td>
                                                <input type="checkbox" name="{{ $counter3 == 0 ? 'acechangeto' : '' }}" 
                                                id="{{ $counter3 == 0 ? 'ACEchangeto2' : '' }}" value="no">
                                                <label class="radioLabel2" class="ACEchangeto2" for="{{ $counter3 == 0 ? 'ACEchangeto2' : '' }}">change to</label>
                                                <textarea class="form-control input-sm" name="{{ $counter3 == 0 ? 'txtareaACE' : '' }}"></textarea>
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" name="arbAntihypertensive" id="antihypertensiveARB" value="{{ $diabetesFollowup ? $diabetesFollowup[count($diabetesFollowup)-1]->arbAntihypertensive == 'yes' ? 'yes' : 'no' : 'no' }}" {{ $diabetesFollowup ? $diabetesFollowup[count($diabetesFollowup)-1]->arbAntihypertensive == 'yes' ? 'checked' : '' : '' }}> <label class="radioLabel2" for="antihypertensiveARB">ARB</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" name="othersAntihypertensive" id="antihypertensiveOthersInsulin" value="{{ $diabetesFollowup ? $diabetesFollowup[count($diabetesFollowup)-1]->othersAntihypertensive == 'yes' ? 'yes' : 'no' : 'no' }}" {{ $diabetesFollowup ? $diabetesFollowup[count($diabetesFollowup)-1]->othersAntihypertensive == 'yes' ? 'checked' : '' : '' }}>
                                        <label class="radioLabel2" for="antihypertensiveOthersInsulin">Others: Specify</label>
                                        <textarea name="txtareaAntihypertensiveOthers2" class="form-control txtareaAntihypertensiveOthers2 input-sm">{{ $diabetesFollowup ? $diabetesFollowup[count($diabetesFollowup)-1]->txtareaAntihypertensiveOthers2 ? $diabetesFollowup[count($diabetesFollowup)-1]->txtareaAntihypertensiveOthers2 : '' : '' }}</textarea>
                                    </td>
                                    @if($diabetesFollowup)
                                        @foreach($diabetesFollowup as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td>
                                                <input type="checkbox" name="{{ $disabled == 'readonly' ? '' : 'addARB' }}" class="addARB" id="{{ $info->id.'Add1ARB' }}" 
                                                value="{{ $diabetesFollowup ? $info->addARB == 'yes' ? 'yes' : 'no' : 'no' }}"
                                                {{ $diabetesFollowup ? $info->addARB == 'yes' ? 'checked' : '' : '' }}>
                                                <label class="radioLabel2" for="{{ $info->id.'Add1ARB' }}">Add</label>
                                                <textarea class="form-control input-sm txtareaARB" name="{{ $disabled == 'readonly' ? '' : 'txtareaARB' }}"
                                                {{ $disabled }}>{{ $diabetesFollowup ? $info->txtareaARB ? $info->txtareaARB : '' : '' }}</textarea>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td>
                                                <input type="checkbox" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'addARB' : '' : ''}}" 
                                                id="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'Add2ARB' : '' : ''}}" value="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'no' : '' : ''}}">
                                                <label class="radioLabel2" for="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'Add2ARB' : '' : ''}}">Add</label>
                                                <textarea class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'txtareaARB' : '' : ''}}"></textarea>
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td>
                                                <input type="checkbox" name="{{ $counter3 == 0 ? 'addARB' : '' }}" 
                                                id="{{ $counter3 == 0 ? 'Add2ARB' : '' }}" value="{{ $counter3 == 0 ? 'no' : '' }}">
                                                <label class="radioLabel2" for="{{ $counter3 == 0 ? 'Add2ARB' : '' }}">Add</label>
                                                <textarea class="form-control input-sm" name="{{ $counter3 == 0 ? 'txtareaARB' : '' }}"></textarea>
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle"><label class="radioLabel2" for="Lipid-controldrugs">Lipid - control drugs</label></td>
                                    @if($diabetesFollowup)
                                        @foreach($diabetesFollowup as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td>
                                                <input type="checkbox" name="{{ $disabled == 'readonly' ? '' : 'sameregimenLipidControl' }}" id="{{ $info->id.'sameregimenLipidControl' }}" 
                                                value="{{ $diabetesFollowup ? $info->sameregimenLipidControl == 'yes' ? 'yes' : 'no' : 'no' }}"
                                                {{ $diabetesFollowup ? $info->sameregimenLipidControl == 'yes' ? 'checked' : '' : '' }}>
                                                <label class="radioLabel2" for="{{ $info->id.'sameregimenLipidControl' }}">Same regimen</label>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td>
                                                <input type="checkbox" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'sameregimenLipidControl' : '' : ''}}" 
                                                id="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'sameregimenLipidControl' : '' : ''}}" value="no">
                                                <label class="radioLabel2" for="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'sameregimenLipidControl' : '' : ''}}">Same regimen</label>
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td>
                                                <input type="checkbox" name="{{ $counter3 == 0 ? 'sameregimenLipidControl' : '' }}" 
                                                id="{{ $counter3 == 0 ? 'sameregimenLipidControl' : '' }}" value="no">
                                                <label class="radioLabel2" for="{{ $counter3 == 0 ? 'sameregimenLipidControl' : '' }}">Same regimen</label>
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" name="satinAntihypertensiveLipid" id="satinAntihypertensiveLipid" value="{{ $diabetesFollowup ? $diabetesFollowup[count($diabetesFollowup)-1]->satinAntihypertensiveLipid == 'yes' ? 'yes' : 'no' : 'no' }}" {{ $diabetesFollowup ? $diabetesFollowup[count($diabetesFollowup)-1]->satinAntihypertensiveLipid == 'yes' ? 'checked' : '' : '' }}> <label class="radioLabel2" for="satinAntihypertensiveLipid">Statin</label>
                                    </td>
                                    @if($diabetesFollowup)
                                        @foreach($diabetesFollowup as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td rowspan="2">
                                                <input type="checkbox" name="{{ $disabled == 'readonly' ? '' : 'changetoLipid'}}" id="{{ $info->id.'changeto1Lipid' }}" 
                                                value="{{ $diabetesFollowup ? $info->changetoLipid == 'yes' ? 'yes' : 'no' : 'no' }}"
                                                {{ $diabetesFollowup ? $info->changetoLipid == 'yes' ? 'checked' : '' : '' }}>
                                                <label class="radioLabel2" for="{{ $info->id.'changeto1Lipid' }}">change to</label>
                                                <textarea class="form-control input-sm txtareaLipid" name="{{ $disabled == 'readonly' ? '' : 'txtareaLipid' }}"
                                                {{ $disabled }}>{{ $diabetesFollowup ? $info->txtareaLipid ? $info->txtareaLipid : '' : '' }}</textarea>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td rowspan="2">
                                                <input type="checkbox" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'changetoLipid' : '' : ''}}" 
                                                id="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'changeto2Lipid' : '' : ''}}" value="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'no' : '' : ''}}">
                                                <label class="radioLabel2" for="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'changeto2Lipid' : '' : ''}}">change to</label>
                                                <textarea class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'txtareaLipid' : '' : ''}}"></textarea>
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td rowspan="2">
                                                <input type="checkbox" name="{{ $counter3 == 0 ? 'changetoLipid' : '' }}" 
                                                id="{{ $counter3 == 0 ? 'changeto2Lipid' : '' }}" value="{{ $counter3 == 0 ? 'no' : ''}}">
                                                <label class="radioLabel2" for="{{ $counter3 == 0 ? 'changeto2Lipid' : ''}}">change to</label>
                                                <textarea class="form-control input-sm" name="{{ $counter3 == 0 ? 'txtareaLipid' : '' }}"></textarea>
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td><input type="checkbox" name="fibrateAntihypertensive" id="antihypertensiveFibrate" value="{{ $diabetesFollowup ? $diabetesFollowup[count($diabetesFollowup)-1]->fibrateAntihypertensive == 'yes' ? 'yes' : 'no' : 'no' }}" {{ $diabetesFollowup ? $diabetesFollowup[count($diabetesFollowup)-1]->fibrateAntihypertensive == 'yes' ? 'checked' : '' : '' }}> <label class="radioLabel2" for="antihypertensiveFibrate">Fibrate</label></td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" name="othersSpecifyAntihypertensive" id="OthersSpecify" value="{{ $diabetesFollowup ? $diabetesFollowup[count($diabetesFollowup)-1]->othersSpecifyAntihypertensive == 'yes' ? 'yes' : 'no' : 'no' }}" {{ $diabetesFollowup ? $diabetesFollowup[count($diabetesFollowup)-1]->othersSpecifyAntihypertensive == 'yes' ? 'checked' : '' : '' }}>
                                        <label class="radioLabel2" for="OthersSpecify">Others: Specify</label>
                                        <textarea name="txtareaothersSpecifyAntihypertensive" class="form-control input-sm txtareaOthersSpecifyAntihypertensive">{{ $diabetesFollowup ? $diabetesFollowup[count($diabetesFollowup)-1]->txtareaothersSpecifyAntihypertensive ? $diabetesFollowup[count($diabetesFollowup)-1]->txtareaothersSpecifyAntihypertensive : '' : '' }}</textarea>
                                    </td>
                                    @if($diabetesFollowup)
                                        @foreach($diabetesFollowup as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td>
                                                <input type="checkbox" name="{{ $disabled == 'readonly' ? '' : 'addFibrate'}}" id="{{ $info->id.'Add1Fibrate' }}" class="addFibrate" 
                                                value="{{ $diabetesFollowup ? $info->addFibrate == 'yes' ? 'yes' : 'no' : 'no' }}"
                                                {{ $diabetesFollowup ? $info->addFibrate == 'yes' ? 'checked' : '' : '' }}>
                                                <label class="radioLabel2" for="{{ $info->id.'Add1Fibrate' }}">Add</label>
                                                <textarea class="form-control input-sm txtAddFibrate" name="{{ $disabled == 'readonly' ? '' : 'txtAddFibrate' }}"
                                                {{ $disabled }}>{{ $diabetesFollowup ? $info->txtAddFibrate ? $info->txtAddFibrate : '' : '' }}</textarea>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td>
                                                <input type="checkbox" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'addFibrate' : '' : ''}}" 
                                                id="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'Add2Fibrate' : '' : ''}}" value="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'no' : '' : ''}}">
                                                <label class="radioLabel2" for="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'Add2Fibrate' : '' : ''}}">Add</label>
                                                <textarea class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'txtAddFibrate' : '' : ''}}"></textarea>
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td>
                                                <input type="checkbox" name="{{ $counter3 == 0 ? 'addFibrate' : '' }}" 
                                                id="{{ $counter3 == 0 ? 'Add2Fibrate' : '' }}" value="{{ $counter3 == 0 ? 'no' : '' }}">
                                                <label class="radioLabel2" for="{{ $counter3 == 0 ? 'Add2Fibrate' : '' }}">Add</label>
                                                <textarea class="form-control input-sm" name="{{ $counter3 == 0 ? 'txtAddFibrate' : '' }}"></textarea>
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle">Other medication</td>
                                    @if($diabetesFollowup)
                                        @foreach($diabetesFollowup as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td rowspan="2">
                                                <textarea rows="3" class="form-control input-sm" name="{{ $disabled == 'readonly' ? '' : 'txtareaOtherMedication' }}"
                                                {{ $disabled }}>{{ $diabetesFollowup ? $info->txtareaOtherMedication ? $info->txtareaOtherMedication : '' : '' }}</textarea>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td rowspan="2">
                                                <textarea rows="3" class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'txtareaOtherMedication' : '' : ''}}"></textarea>
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td rowspan="2">
                                                <textarea rows="3" class="form-control input-sm" name="{{ $counter3 == 0 ? 'txtareaOtherMedication' : '' }}"></textarea>
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td><input type="checkbox" name="antihypertensiveAspirin" id="antihypertensiveAspirin" class="antihypertensiveAspirin" value="{{ $diabetesFollowup ? $diabetesFollowup[count($diabetesFollowup)-1]->antihypertensiveAspirin == 'yes' ? 'yes' : 'no' : 'no' }}" {{ $diabetesFollowup ? $diabetesFollowup[count($diabetesFollowup)-1]->antihypertensiveAspirin == 'yes' ? 'checked' : '' : '' }}> <label class="radioLabel2" for="antihypertensiveAspirin">Aspirin</label></td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="medicalHistoryAlphabeth">B. Medical Nutrition Therapy</td>
                                </tr>
                                <tr>
                                    <td rowspan="3" style="z-index: 100">TCR<br>CHO<br>CHON<br>Fats</td>
                                    @if($diabetesFollowup)
                                        @foreach($diabetesFollowup as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td>
                                                <input type="checkbox" name="{{ $disabled == 'readonly' ? '' : 'sameregimenTcr'}}" id="{{ $info->id.'sameregimenTcr' }}" 
                                                value="{{ $diabetesFollowup ? $info->sameregimenTcr == 'yes' ? 'yes' : 'no' : 'no' }}"
                                                {{ $diabetesFollowup ? $info->sameregimenTcr == 'yes' ? 'checked' : '' : '' }}>
                                                <label class="radioLabel2" for="{{ $info->id.'sameregimenTcr' }}">Same regimen</label>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td>
                                                <input type="checkbox" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'sameregimenTcr' : '' : ''}}" 
                                                id="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'sameregimenTcr' : '' : ''}}" value="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'no' : '' : ''}}">
                                                <label class="radioLabel2" for="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'sameregimenTcr' : '' : ''}}">Same regimen</label>
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td>
                                                <input type="checkbox" name="{{ $counter3 == 0 ? 'sameregimenTcr' : ''}}" 
                                                id="{{ $counter3 == 0 ? 'sameregimenTcr' : ''}}" value="{{ $counter3 == 0 ? 'no' : ''}}">
                                                <label class="radioLabel2" for="{{ $counter3 == 0 ? 'sameregimenTcr' : '' }}">Same regimen</label>
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                </tr>
                                    @if($diabetesFollowup)
                                        @foreach($diabetesFollowup as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td>
                                                <input type="checkbox" name="{{ $disabled == 'readonly' ? '' : 'changetoTcr'}}" id="{{ $info->id.'changeto1TCR' }}" 
                                                value="{{ $diabetesFollowup ? $info->changetoTcr == 'yes' ? 'yes' : 'no' : 'no' }}"
                                                {{ $diabetesFollowup ? $info->changetoTcr == 'yes' ? 'checked' : '' : '' }}>
                                                <label class="radioLabel2" for="{{ $info->id.'changeto1TCR' }}">change to</label>
                                                <textarea class="form-control input-sm txtareaChangetoTCR" name="{{ $disabled == 'readonly' ? '' : 'txtareaChangetoTcr' }}"
                                                {{ $disabled }}>{{ $diabetesFollowup ? $info->txtareaChangetoTcr ? $info->txtareaChangetoTcr : '' : '' }}</textarea>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td>
                                                <input type="checkbox" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'changetoTcr' : '' : ''}}" 
                                                id="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'changetoTCR' : '' : ''}}" value="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'no' : '' : ''}}">
                                                <label class="radioLabel2" for="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'changetoTCR' : '' : ''}}">change to</label>
                                                <textarea class="form-control" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'txtareaChangetoTcr' : '' : ''}}"></textarea>
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td>
                                                <input type="checkbox" name="{{ $counter3 == 0 ? 'changetoTcr' : '' }}" 
                                                id="{{ $counter3 == 0 ? 'changetoTCR' : '' }}" value="{{ $counter3 == 0 ? 'no' : '' }}">
                                                <label class="radioLabel2" for="{{ $counter3 == 0 ? 'changetoTCR' : '' }}">change to</label>
                                                <textarea class="form-control" name="{{ $counter3 == 0 ? 'txtareaChangetoTcr' : '' }}"></textarea>
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    @if($diabetesFollowup)
                                        @foreach($diabetesFollowup as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td>
                                                <input type="checkbox" name="{{ $disabled == 'readonly' ? '' : 'addTcr'}}" id="{{ $info->id.'Add1TCR' }}" 
                                                value="{{ $diabetesFollowup ? $info->addTcr == 'yes' ? 'yes' : 'no' : 'no' }}"
                                                {{ $diabetesFollowup ? $info->addTcr == 'yes' ? 'checked' : '' : '' }}>
                                                <label class="radioLabel2" for="{{ $info->id.'Add1TCR' }}">Add</label>
                                                <textarea class="form-control input-sm txtareaAddTCR" name="{{ $disabled == 'readonly' ? '' : 'txtareaAddTcr' }}"
                                                {{ $disabled }}>{{ $diabetesFollowup ? $info->txtareaAddTcr ? $info->txtareaAddTcr : '' : '' }}</textarea>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td>
                                                <input type="checkbox" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'addTcr' : '' : ''}}" 
                                                id="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'Add2TCR' : '' : ''}}" value="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'no' : '' : ''}}">
                                                <label class="radioLabel2" for="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'Add2TCR' : '' : ''}}">Add</label>
                                                <textarea class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'txtareaAddTcr' : '' : ''}}"></textarea>
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td>
                                                <input type="checkbox" name="{{ $counter3 == 0 ? 'addTcr' : ''}}" 
                                                id="{{ $counter3 == 0 ? 'Add2TCR' : ''}}" value="{{ $counter3 == 0 ? 'no' : '' }}">
                                                <label class="radioLabel2" for="{{ $counter3 == 0 ? 'Add2TCR' : '' }}">Add</label>
                                                <textarea class="form-control input-sm" name="{{ $counter3 == 0 ? 'txtareaAddTcr' : '' }}"></textarea>
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td colspan="5" class="medicalHistoryAlphabeth">C. Exercise</td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle;">Min/day<br>Frequency/week</td>
                                    @if($diabetesFollowup)
                                        @foreach($diabetesFollowup as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td>
                                                <textarea class="form-control input-sm" name="{{ $disabled == 'readonly' ? '' : 'txtareaFrequency' }}"
                                                {{ $disabled }}>{{ $diabetesFollowup ? $info->txtareaFrequency ? $info->txtareaFrequency : '' : '' }}</textarea>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td>
                                                <textarea class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'txtareaFrequency' : '' : ''}}"></textarea>
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td>
                                                <textarea class="form-control input-sm" name="{{ $counter3 == 0 ? 'txtareaFrequency' : '' }}"></textarea>
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td colspan="5" class="medicalHistoryAlphabeth">D. Examination</td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" name="influenza" id="Influenza" value="{{ $diabetesFollowup ? $diabetesFollowup[count($diabetesFollowup)-1]->influenza == 'yes' ? 'yes' : 'no' : 'no' }}" {{ $diabetesFollowup ? $diabetesFollowup[count($diabetesFollowup)-1]->influenza == 'yes' ? 'checked' : '' : '' }}> <label class="radioLabel2" for="Influenza">Influenza</label>
                                    </td>
                                    @if($diabetesFollowup)
                                        @foreach($diabetesFollowup as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td rowspan="2">
                                                <textarea rows="3" class="form-control input-sm txtareaInfluenza" name="{{ $disabled == 'readonly' ? '' : 'txtareaInfluenza' }}"
                                                {{ $disabled }}>{{ $diabetesFollowup ? $info->txtareaInfluenza ? $info->txtareaInfluenza : '' : '' }}</textarea>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td rowspan="2">
                                                <textarea rows="3" class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'txtareaInfluenza' : '' : ''}}"></textarea>
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td rowspan="2">
                                                <textarea rows="3" class="form-control input-sm" name="{{ $counter3 == 0 ? 'txtareaInfluenza' : '' }}"></textarea>
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" name="pneumoccocal" id="Pneumoccocal" value="{{ $diabetesFollowup ? $diabetesFollowup[count($diabetesFollowup)-1]->pneumoccocal == 'yes' ? 'yes' : 'no' : 'no' }}" {{ $diabetesFollowup ? $diabetesFollowup[count($diabetesFollowup)-1]->pneumoccocal == 'yes' ? 'checked' : '' : '' }}> <label class="radioLabel2" for="Pneumoccocal">Pneumoccocal</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="medicalHistoryAlphabeth">E. Laboratories to be done</td>
                                </tr>
                                <tr>
                                    <td rowspan="1">SMBG<br>Aic<br>Lipid Profile<br>Micral Test<br>ECG<br>Others specify</td>
                                    @if($diabetesFollowup)
                                        @foreach($diabetesFollowup as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td rowspan="2">
                                                <textarea rows="5" class="form-control input-sm" name="{{ $disabled == 'readonly' ? '' : 'txtareaSMBG' }}"
                                                {{ $disabled }}>{{ $diabetesFollowup ? $info->txtareaSmbg ? $info->txtareaSmbg : '' : '' }}</textarea>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td rowspan="2">
                                                <textarea rows="5" class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'txtareaSmbg' : '' : ''}}"></textarea>
                                            </td>

                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td rowspan="2">
                                                <textarea rows="3" class="form-control input-sm" name="{{ $counter3 == 0 ? 'txtareaSmbg' : '' }}"></textarea>
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td colspan="5" class="medicalHistoryAlphabeth">F. Referrals to be done</td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle;">Diabetes Education</label></td>
                                    @if($diabetesFollowup)
                                        @foreach($diabetesFollowup as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td>
                                                <textarea rows="3" class="form-control input-sm" name="{{ $disabled == 'readonly' ? '' : 'txtareaDiabetes' }}"
                                                {{ $disabled }}>{{ $diabetesFollowup ? $info->txtareaDiabetes ? $info->txtareaDiabetes : '' : '' }}</textarea>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td>
                                                <textarea rows="3" class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'txtareaDiabetes' : '' : ''}}"></textarea>
                                            </td>

                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td>
                                                <textarea rows="3" class="form-control input-sm" name="{{ $counter3 == 0 ? 'txtareaDiabetes' : '' }}"></textarea>
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle;">Other Specialists:<br>Pls. specify</label></td>
                                    @if($diabetesFollowup)
                                        @foreach($diabetesFollowup as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td>
                                                <textarea rows="3" class="form-control input-sm" name="{{ $disabled == 'readonly' ? '' : 'txtareaOtherSpecialists' }}"
                                                {{ $disabled }}>{{ $diabetesFollowup ? $info->txtareaOtherSpecialists ? $info->txtareaOtherSpecialists : '' : '' }}</textarea>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td>
                                                <textarea rows="3" class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'txtareaOtherSpecialists' : '' : ''}}"></textarea>
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td>
                                                <textarea rows="3" class="form-control input-sm" name="{{ $counter3 == 0 ? 'txtareaOtherSpecialists' : '' }}"></textarea>
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle;">Assessment</label></td>
                                    @if($diabetesFollowup)
                                        @foreach($diabetesFollowup as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; $disabled2 = $disabled @endphp
                                            <td>
                                                <textarea rows="10" class="form-control input-sm {{ $disabled == 'readonly' ? 'txtareaAssessment2' : 'txtareaAssessment' }}" name="{{ $disabled == 'readonly' ? '' : 'txtareaAssessment' }}"
                                                {{ $disabled }}>{{ $diabetesFollowup ? $info->txtareaAssessment ? str_replace('```','&nbsp;',$info->txtareaAssessment) : '' : '' }}</textarea>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td>
                                                <textarea rows="10" class="form-control input-sm {{ $disabled == 'readonly' ? $counter3 == 0 ? 'txtareaAssessment' : 'txtareaAssessment2' : 'txtareaAssessment2'}}" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'txtareaAssessment' : '' : ''}}"></textarea>
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                        <td>
                                            <textarea rows="10" class="form-control input-sm txtareaAssessment2" name=""></textarea>
                                        </td>
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td>
                                                <textarea rows="10" class="form-control input-sm txtareaAssessment" name="{{  $counter3 == 0 ? 'txtareaAssessment' : '' }}"></textarea>
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                        <td>
                                            <textarea rows="10" class="form-control input-sm txtareaAssessment" name="{{  $counter3 == 0 ? 'txtareaAssessment' : '' }}"></textarea>
                                        </td>
                                    @endif
                                </tr>
                            </table>
                        </form>
                        </div>
                      </div>
                    </div>
                </div>

                <div class="col-md-12" style="padding-left: 0px; padding-right: 0px;margin-top: 10px;">


                    <div class="panel panel-default">
                      <div class="panel-heading" style="background-color: #626567; color: white">
                        <h3 class="panel-title">PATIENT RECORD - LABORATORY RESULTS</h3>
                      </div>
                      <div class="panel-body">
                        <div class="table-scroll" id="table-scroll">
                        <form class="laboratory-result">
                            <table class="table table-bordered table-condensed main-table">
                                <tr>
                                    <input type="hidden" class="hidden-did" name="did" value="{{ $diabetesLaboratory ? $diabetesInfo->id ? $diabetesInfo->id : '' : '' }}">
                                    @if($diabetesLaboratory)
                                        @foreach($diabetesLaboratory as $info)
                                            @if(Carbon::parse($info->created_at)->format('m/d/Y') == Carbon::now()->format('m/d/Y'))
                                                <input type="hidden" class="follow_up_id" name="id" value="{{ $diabetesLaboratory ? $info->id ? $info->id : '' : '' }}">
                                            @endif
                                        @endforeach
                                    @endif
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle">Date <kbd>(mm/dd/yy)</kbd></td>
                                    @if($diabetesLaboratory)
                                        @foreach($diabetesLaboratory as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td class="diabetes-input input-width">
                                                <input type="text" class="form-control input-sm {{ $disabled != 'readonly' ? 'date_picker' : '' }}" name="{{ $disabled == 'readonly' ? '' : 'laboratory_test_date' }}"
                                                value="{{ Carbon::parse($info->laboratory_test_date)->format('m/d/Y') }}" {{ $disabled }}>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm {{ $disabled == 'readonly' ? $counter3 == 0 ? 'date_picker' : '' : ''}}" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'laboratory_test_date' : '' : ''}}" value="{{ $disabled == 'readonly' ? $counter2 == 0 ? Carbon::now()->format('m/d/Y') : '' : ''}}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm {{ $counter3 == 0 ? 'date_picker' : '' }}" name="{{ $counter3 == 0 ? 'laboratory_test_date' : '' }}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td colspan="5" class="medicalHistoryAlphabeth">Progress notes</td>
                                </tr>
                                <tr>
                                    <td>Hemoglobin A1c</td>
                                    @if($diabetesLaboratory)
                                        @foreach($diabetesLaboratory as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td class="diabetes-input input-width">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? '' : 'hemoglobinA1c' }}"
                                                value="{{ $diabetesLaboratory ? $info->hemoglobinA1c ? $info->hemoglobinA1c : '' : '' }}" {{ $disabled }}>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'hemoglobinA1c' : '' : ''}}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $counter3 == 0 ? 'hemoglobinA1c' : '' }}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td>FBS</td>
                                    @if($diabetesLaboratory)
                                        @foreach($diabetesLaboratory as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? '' : 'fbs' }}"
                                                value="{{ $diabetesLaboratory ? $info->fbs ? $info->fbs : '' : '' }}" {{ $disabled }}>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'fbs' : '' : ''}}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $counter3 == 0 ? 'fbs' : '' }}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td>Cholesterol</td>
                                    @if($diabetesLaboratory)
                                        @foreach($diabetesLaboratory as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? '' : 'cholesterol' }}"
                                                value="{{ $diabetesLaboratory ? $info->cholesterol ? $info->cholesterol : '' : '' }}" {{ $disabled }}>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'cholesterol' : '' : ''}}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $counter3 == 0 ? 'cholesterol' : '' }}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td>HDL</td>
                                    @if($diabetesLaboratory)
                                        @foreach($diabetesLaboratory as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? '' : 'hdl' }}"
                                                value="{{ $diabetesLaboratory ? $info->hdl ? $info->hdl : '' : '' }}" {{ $disabled }}>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'hdl' : '' : ''}}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $counter3 == 0 ? 'hdl' : '' }}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td>LDL</td>
                                    @if($diabetesLaboratory)
                                        @foreach($diabetesLaboratory as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? '' : 'ldl' }}"
                                                value="{{ $diabetesLaboratory ? $info->ldl ? $info->ldl : '' : '' }}" {{ $disabled }}>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'ldl' : '' : ''}}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $counter3 == 0 ? 'ldl' : '' }}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td>Triglyceride</td>
                                    @if($diabetesLaboratory)
                                        @foreach($diabetesLaboratory as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? '' : 'triglyceride' }}"
                                                value="{{ $diabetesLaboratory ? $info->triglyceride ? $info->triglyceride : '' : '' }}" {{ $disabled }}>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'triglyceride' : '' : ''}}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $counter3 == 0 ? 'triglyceride' : '' }}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td>Creatinine</td>
                                    @if($diabetesLaboratory)
                                        @foreach($diabetesLaboratory as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? '' : 'creatinine' }}"
                                                value="{{ $diabetesLaboratory ? $info->creatinine ? $info->creatinine : '' : '' }}" {{ $disabled }}>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'creatinine' : '' : ''}}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $counter3 == 0 ? 'creatinine' : '' }}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td>BUN</td>
                                    @if($diabetesLaboratory)
                                        @foreach($diabetesLaboratory as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? '' : 'bun' }}"
                                                value="{{ $diabetesLaboratory ? $info->bun ? $info->bun : '' : '' }}" {{ $disabled }}>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'bun' : '' : ''}}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $counter3 == 0 ? 'bun' : '' }}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td>Uric Acid</td>
                                    @if($diabetesLaboratory)
                                        @foreach($diabetesLaboratory as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? '' : 'uricacid' }}"
                                                value="{{ $diabetesLaboratory ? $info->uricacid ? $info->uricacid : '' : '' }}" {{ $disabled }}>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'uricacid' : '' : ''}}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $counter3 == 0 ? 'uricacid' : '' }}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td>SGPT</td>
                                    @if($diabetesLaboratory)
                                        @foreach($diabetesLaboratory as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? '' : 'sgpt' }}"
                                                value="{{ $diabetesLaboratory ? $info->sgpt ? $info->sgpt : '' : '' }}" {{ $disabled }}>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'sgpt' : '' : ''}}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $counter3 == 0 ? 'sgpt' : '' }}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td class="text-center"><span><b>CBC</b></span></td>
                                    <td class="diabetes-input"></td>
                                    <td class="diabetes-input"></td>
                                    <td class="diabetes-input"></td>
                                    <td class="diabetes-input"></td>
                                    <!-- <td class="diabetes-input"></td> -->
                                </tr>
                                <tr>
                                    <td>Hemoglobin</td>
                                    @if($diabetesLaboratory)
                                        @foreach($diabetesLaboratory as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? '' : 'hemoglobin' }}"
                                                value="{{ $diabetesLaboratory ? $info->hemoglobin ? $info->hemoglobin : '' : '' }}" {{ $disabled }}>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'hemoglobin' : '' : ''}}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $counter3 == 0 ? 'hemoglobin' : '' }}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td>Hematocrit</td>
                                    @if($diabetesLaboratory)
                                        @foreach($diabetesLaboratory as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? '' : 'hematocrit' }}"
                                                value="{{ $diabetesLaboratory ? $info->hematocrit ? $info->hematocrit : '' : '' }}" {{ $disabled }}>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'hematocrit' : '' : ''}}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $counter3 == 0 ? 'hematocrit' : '' }}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td>WBC</td>
                                    @if($diabetesLaboratory)
                                        @foreach($diabetesLaboratory as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? '' : 'wbc' }}"
                                                value="{{ $diabetesLaboratory ? $info->wbc ? $info->wbc : '' : '' }}" {{ $disabled }}>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'wbc' : '' : ''}}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $counter3 == 0 ? 'wbc' : '' }}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td>Neutrophils</td>
                                    @if($diabetesLaboratory)
                                        @foreach($diabetesLaboratory as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? '' : 'neutrophils' }}"
                                                value="{{ $diabetesLaboratory ? $info->neutrophils ? $info->neutrophils : '' : '' }}" {{ $disabled }}>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'neutrophils' : '' : ''}}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $counter3 == 0 ? 'neutrophils' : '' }}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td>Lymphocytes</td>
                                    @if($diabetesLaboratory)
                                        @foreach($diabetesLaboratory as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? '' : 'lymphocytes' }}"
                                                value="{{ $diabetesLaboratory ? $info->lymphocytes ? $info->lymphocytes : '' : '' }}" {{ $disabled }}>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'lymphocytes' : '' : ''}}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $counter3 == 0 ? 'lymphocytes' : '' }}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td class="text-center"><span><b>Urinalysis</b></span></td>
                                    <td class="diabetes-input"></td>
                                    <td class="diabetes-input"></td>
                                    <td class="diabetes-input"></td>
                                    <td class="diabetes-input"></td>
                                    <!-- <td class="diabetes-input"></td> -->
                                </tr>
                                <tr>
                                    <td>Urine pH</td>
                                    @if($diabetesLaboratory)
                                        @foreach($diabetesLaboratory as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? '' : 'urineph' }}"
                                                value="{{ $diabetesLaboratory ? $info->urineph ? $info->urineph : '' : '' }}" {{ $disabled }}>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'urineph' : '' : ''}}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $counter3 == 0 ? 'urineph' : '' }}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td>Specific Gravity</td>
                                    @if($diabetesLaboratory)
                                        @foreach($diabetesLaboratory as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? '' : 'specificgravity' }}"
                                                value="{{ $diabetesLaboratory ? $info->specificgravity ? $info->specificgravity : '' : '' }}" {{ $disabled }}>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'specificgravity' : '' : ''}}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $counter3 == 0 ? 'specificgravity' : '' }}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td>Sugar</td>
                                    @if($diabetesLaboratory)
                                        @foreach($diabetesLaboratory as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? '' : 'sugar' }}"
                                                value="{{ $diabetesLaboratory ? $info->sugar ? $info->sugar : '' : '' }}" {{ $disabled }}>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'sugar' : '' : ''}}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $counter3 == 0 ? 'sugar' : '' }}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td>Albumin</td>
                                    @if($diabetesLaboratory)
                                        @foreach($diabetesLaboratory as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? '' : 'albumin' }}"
                                                value="{{ $diabetesLaboratory ? $info->albumin ? $info->albumin : '' : '' }}" {{ $disabled }}>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'albumin' : '' : ''}}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $counter3 == 0 ? 'albumin' : '' }}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td>Pus Cells</td>
                                    @if($diabetesLaboratory)
                                        @foreach($diabetesLaboratory as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? '' : 'puscells' }}"
                                                value="{{ $diabetesLaboratory ? $info->puscells ? $info->puscells : '' : '' }}" {{ $disabled }}>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'puscells' : '' : ''}}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $counter3 == 0 ? 'puscells' : '' }}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td>RBC</td>
                                    @if($diabetesLaboratory)
                                        @foreach($diabetesLaboratory as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? '' : 'rbc' }}"
                                                value="{{ $diabetesLaboratory ? $info->rbc ? $info->rbc : '' : '' }}" {{ $disabled }}>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'rbc' : '' : ''}}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $counter3 == 0 ? 'rbc' : '' }}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td>Cast</td>
                                    @if($diabetesLaboratory)
                                        @foreach($diabetesLaboratory as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? '' : 'cast' }}"
                                                value="{{ $diabetesLaboratory ? $info->cast ? $info->cast : '' : '' }}" {{ $disabled }}>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'cast' : '' : ''}}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $counter3 == 0 ? 'cast' : '' }}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td>Crystals</td>
                                    @if($diabetesLaboratory)
                                        @foreach($diabetesLaboratory as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? '' : 'crystals' }}"
                                                value="{{ $diabetesLaboratory ? $info->crystals ? $info->crystals : '' : '' }}" {{ $disabled }}>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'crystals' : '' : ''}}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $counter3 == 0 ? 'crystals' : '' }}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td>Bacteria</td>
                                    @if($diabetesLaboratory)
                                        @foreach($diabetesLaboratory as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? '' : 'bacteria' }}"
                                                value="{{ $diabetesLaboratory ? $info->bacteria ? $info->bacteria : '' : '' }}" {{ $disabled }}>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'bacteria' : '' : ''}}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{  $counter3 == 0 ? 'bacteria' : '' }}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td>Yeast</td>
                                    @if($diabetesLaboratory)
                                        @foreach($diabetesLaboratory as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? '' : 'yeast' }}"
                                                value="{{ $diabetesLaboratory ? $info->yeast ? $info->yeast : '' : '' }}" {{ $disabled }}>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'yeast' : '' : ''}}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $counter3 == 0 ? 'yeast' : '' }}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td style="height: 30px"></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Micral Test</td>
                                    @if($diabetesLaboratory)
                                        @foreach($diabetesLaboratory as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? '' : 'micraltest' }}"
                                                value="{{ $diabetesLaboratory ? $info->micraltest ? $info->micraltest : '' : '' }}" {{ $disabled }}>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'micraltest' : '' : ''}}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $counter3 == 0 ? 'micraltest' : '' }}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td>24 H Creatinine Clearance</td>
                                    @if($diabetesLaboratory)
                                        @foreach($diabetesLaboratory as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? '' : 'hcreatinine' }}"
                                                value="{{ $diabetesLaboratory ? $info->hcreatinine ? $info->hcreatinine : '' : '' }}" {{ $disabled }}>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'hcreatinine' : '' : ''}}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $counter3 == 0 ? 'hcreatinine' : '' }}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td>24 H Urinary Protein</td>
                                    @if($diabetesLaboratory)
                                        @foreach($diabetesLaboratory as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? '' : 'hurinaryprotein' }}"
                                                value="{{ $diabetesLaboratory ? $info->hurinaryprotein ? $info->hurinaryprotein : '' : '' }}" {{ $disabled }}>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'hurinaryprotein' : '' : ''}}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $counter3 == 0 ? 'hurinaryprotein' : ''}}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td>GFR</td>
                                    @if($diabetesLaboratory)
                                        @foreach($diabetesLaboratory as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? '' : 'gfr' }}"
                                                value="{{ $diabetesLaboratory ? $info->gfr ? $info->gfr : '' : '' }}" {{ $disabled }}>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'gfr' : '' : ''}}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $counter3 == 0 ? 'gfr' : '' }}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td>Chest X-ray</td>
                                    @if($diabetesLaboratory)
                                        @foreach($diabetesLaboratory as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? '' : 'chestxray' }}"
                                                value="{{ $diabetesLaboratory ? $info->chestxray ? $info->chestxray : '' : '' }}" {{ $disabled }}>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'chestxray' : '' : ''}}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $counter3 == 0 ? 'chestxray' : '' }}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td>ECG</td>
                                    @if($diabetesLaboratory)
                                        @foreach($diabetesLaboratory as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? '' : 'ecg' }}"
                                                value="{{ $diabetesLaboratory ? $info->ecg ? $info->ecg : '' : '' }}" {{ $disabled }}>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'ecg' : '' : ''}}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $counter3 == 0 ? 'ecg' : ''}}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td>2D echo</td>
                                    @if($diabetesLaboratory)
                                        @foreach($diabetesLaboratory as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? '' : 'decho' }}"
                                                value="{{ $diabetesLaboratory ? $info->decho ? $info->decho : '' : '' }}" {{ $disabled }}>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'decho' : '' : ''}}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $counter3 == 0 ? 'decho' : '' }}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td>Ultrasound</td>
                                    @if($diabetesLaboratory)
                                        @foreach($diabetesLaboratory as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? '' : 'ultrasound' }}"
                                                value="{{ $diabetesLaboratory ? $info->ultrasound ? $info->ultrasound : '' : '' }}" {{ $disabled }}>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'ultrasound' : '' : ''}}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $counter3 == 0 ? 'ultrasound' : '' }}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                                <tr>
                                    <td>Others</td>
                                    @if($diabetesLaboratory)
                                        @foreach($diabetesLaboratory as $info)
                                            @php $disabled = ($info->created_at ? Carbon::parse($info->created_at)->format('m/d/Y') : Carbon::now()->format('d/m/Y')) 
                                                            == Carbon::now()->format('m/d/Y') ? '' : 'readonly'; $counter3 = 0; @endphp
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm" name="{{ $disabled == 'readonly' ? '' : 'laboratoryothers' }}"
                                                value="{{ $diabetesLaboratory ? $info->laboratoryothers ? $info->laboratoryothers : '' : '' }}" {{ $disabled }}>
                                            </td>
                                        @endforeach
                                        @php $counter1 = $counter @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm laboratoryothers" value="" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'laboratoryothers' : '' : ''}}">
                                            </td>
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm laboratoryothers" value="" name="{{ $disabled == 'readonly' ? $counter3 == 0 ? 'laboratoryothers' : '' : ''}}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @else
                                        @php $counter1 = $counter; $counter3 = 0; @endphp
                                        @for($i=0;$i<$counter1;$i++)
                                            <td class="diabetes-input">
                                                <input type="text" class="form-control input-sm laboratoryothers" value="" name="{{ $counter3 == 0 ? 'laboratoryothers' : '' }}">
                                            </td>
                                            @php $counter3++ @endphp
                                        @endfor
                                    @endif
                                </tr>
                            </table>
                        </form>
                        </div>
                      </div>
                    </div>



                        
                </div>

            </div>

            <div class="panel-footer text-right">
                <button type="button" class="btn btn-sm btn-primary btnStatus {{ $diabetesInfo ? $disabled2 != 'readonly' ? 'btnUpdateDiabetesInfo' : 'btnSaveDiabetesInfo2' : 'btnSaveDiabetesInfo' }}">
                    <i class="fa fa-save"></i> Save
                </button>
                <button type="button" class="btn btn-sm btn-warning btn-icd-codes" data-toggle="modal" data-target=".bs-example-modal-lg">ICD Codes</button>
            </div>

            <div class="modal bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-center">International Classification of Diseases</h4>   
                    </div>
                    <div class="modal-body">
                        <div class="input-group">
                          <input type="text" class="form-control search_icd" placeholder="Search here..." aria-describedby="basic-addon2">
                          <span class="input-group-addon" style="background-color: #7DCEA0; border-color: #52BE80; color: white">ICD Codes</span>
                        </div>
                        <br>
                        <div class="icd_codes_list">
                            <table class="table table-bordered table-condensed table-icd table-striped">
                                <tr style="background-color: #626567; color: white">
                                    <td class="text-center"><span class="fa fa-exclamation-circle"></span></td>
                                    <td class="text-center"><b>Code</b></td>
                                    <td class="text-center"><b>Description</b></td>
                                </tr>
                                @foreach($icd_codes as $icd)
                                    <tr class='icds'>
                                        <td class="text-center"><input type='checkbox' class='icd_codes' id="{{ $icd->id }}" patient-id="{{ $pid }}"
                                        icd-id="{{ $icd->id }}"></td>
                                        <td>{{ $icd->code }}</td>
                                        <td>{{ $icd->description }}</td>
                                    </tr>
                                @endforeach
                            </table>
                            <!-- <h3>List of your ICD Codes</h3> -->
                            <div class="icd-input-list">
                                @foreach($icds as $icd)
                                    <div class="row">
                                      <div class="col-sm-12">
                                        <div class="input-group">
                                          <input type="text" class="form-control" value="{{ $icd->description }}" readonly>
                                          <span class="input-group-btn">
                                            <button class="btn btn-danger remove-icd" type="button" id="id{{ $icd->icd }}" remove-icd="{{ $icd->icd }}"><span class="fa fa-trash"></span></button>
                                          </span>
                                        </div>
                                      </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
              </div>
            </div>

        </div>
    </div>

@endsection
@endcomponent
@endsection





@section('footer')
@stop



@section('pagescript')
    <script src="{{ asset('public/plugins/js/form.js') }}"></script>
    <script src="{{ asset('public/plugins/wickedpicker/dist/wickedpicker.min.js') }}"></script>
    <script src="{{ asset('public/plugins/js/modernizr.js') }}"></script>
    <script src="{{ asset('public/plugins/js/jquery.menu-aim.js') }}"></script>
    <script src="{{ asset('public/js/doctors/diabetic.js') }}"></script>
    <script src="{{ asset('public/js/doctors/main.js') }}"></script>
    <script src="{{ asset('public/plugins/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('public/plugins/js/tinymce/tinymce.min.js') }}"></script>

@stop


@endcomponent
