@php

use App\User;

@endphp

@component('partials/header')



  @slot('title')
    PIS | classification
  @endslot



  @section('pagestyle')
    <link href="{{ asset('public/plugins/css/jquery-ui.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/mss/classification.css') }}" rel="stylesheet" />
  @endsection



  @section('header')
    @include('mss/navigation')
  @endsection



  @section('content')
  <div class="container mainWrapper">
  	<div class="panel" id="classification_panel">
  		<div class="panel-default">
  			<div class="panel-heading">
  				<h3>MSWD Assessment Tool <i class="fa fa-file-o"></i></h3>
  			</div>
  			<div class="panel-body table-responsive">
          @if($view->validity < Carbon::now()->format('Y-m-d'))
            <div class="bg-info information-panel">
              <div class="info-header">
                <label><span class="fa fa-info-circle"></span> INFORMATION</label>
              </div>
              <div class="info-body">
                <p>The Patient Classification Validity Already Reached the Limit at Date: <b>{{ Carbon::parse($view->validity)->format('m/d/Y') }}</b></p>
                <p>Classified by:
                  @php
                    $user = User::find($view->users_id);
                  @endphp
                 <b>{{$user->last_name.', '.$user->first_name.' '.substr($user->middle_name, 0,1).'.'}}</b> at datetime <b>{{ Carbon::parse($view->created_at)->format('m/d/Y g:ia') }}</b></p>
                <label>KINDLY</label>
                <ul>
                  <li>Check Patient information</li>
                  <li>Update Patient Classification and Information</li>
                </ul>
              </div>
            </div>
          @endif
          <div class="submitclassificationloader">
            <img src="/opd/public/images/loader.svg">
          </div>
  				<form class="mssformsubmit" method="post" action='{{ url("mss/$ids") }}'>
            {{ csrf_field() }}
           {{ method_field('PATCH') }} 
  				<table class="table table-bordered" id="PgovStatus">
  					<tr style="text-align: center;">
  						<td width="25%" >DATE OF INTERVIEW <br>{{ $view->created_at }}<br>
  						</td>
              <input type="hidden" name="patients_id" value="{{ $view->patients_id }}" />

              <input type="hidden" name="users_id" value="{{ $view->users_id }}">

  						<td width="25%"><input type="text" name="date_admission" class="form-control" placeholder="DATE OF ADMISSION/CONSULTATION:" id="date_of_adm" style="height: 100%!important" value="{{ $view->date_admission }}"></td>
  						<td width="17%" align="center">OPD</td>
  						<td width="17%">HOSP NO <br> <font id="hosp_no">{{ $view->hospital_no }}</font></td>
  						<td width="16%"><input type="text" name="mswd" class="form-control required" placeholder="MSWD NO:*" id="mswd_no" required style="height: 100%!important" value="{{ $view->mswd }}"></td>
  					</tr>
  					<tr>
  						<td colspan="2">
  						<select name="referral" class="form-control" id="referral" required style="first:color: red">
  							<option value="{{ $view->referral }}" @if ($view->referral == "") {{ "selected" }} @endif>{{ $view->referral }}</option>
  							<option value="GH">GH</option>
  							<option value="PH/PC">PH/PC</option>
  							<option value="POLITICIAN">POLITICIAN</option>
  							<option value="MEDIA">MEDIA</option>
  							<option value="HCT/RHU/TACRU">HCT/RHU/TACRU</option>
  							<option value="NGO/PRIVATE WELFARE AGENCIES">NGO/PRIVATE WELFARE AGENCIES</option>
  							<option value="GOVT AGENCIES">GOV'T AGENCIES</option>
  							<option value="WALK-IN">WALK-IN</option>
  							<option value="others">OTHERS</option>
  						</select>
  						</td>
  						<td colspan="2"><input type="text" name="referral_addrress" placeholder="ADDRESS:" class="form-control" id="referral_address" value="{{ $view->referral_addrress }}"></td>
  						<td><input type="text" name="referral_telno" placeholder="TEL. NO.:" class="form-control" id="referral_tel_no" value="{{ $view->referral_telno }}"></td>
  					</tr>
  					<tr>
  						<th colspan="5">&nbsp;I. DEMOGRAPHIC DATA: </th>

  					</tr>
  					<tr>
  						<td colspan="2"><input type="text" name="religion" placeholder="RELIGION:" class="form-control" id="religion" value="{{ $view->religion }}"></td>
  						<td colspan="3"><input type="text" name="companion" placeholder="COMPANION UPON ADMISSION:" class="form-control" id="companion" value="{{ $view->companion }}"></td>
  					</tr>
  					<tr align="center">
  						<td>PATIENTS NAME</td>
  						<td>AGE</td>
  						<td>SEX</td>
  						<td>GENDER</td>
  						<td>CIVIL STATUS</td>
  					</tr>
  					<tr align="center">
  						<td>{{ $view->last_name.', '.$view->first_name.' '.$view->middle_name }}</td>
  						 @php
                  $agePatient = App\Patient::age($view->birthday)
                @endphp
              <td>{{ $agePatient }}</td>
              <td>{{ ($view->sex == 'M')?"MALE":"FEMALE" }}</td>
  						<td>
  							<select class="form-control" style="text-align: center;" name="gender" id="gender">
  								<option value="" @if ($view->gender =="") {{ "selected" }} @endif>-- choose --</option>
  								<option value="F" @if ($view->gender =="F") {{ "selected" }} @endif>FEMININE</option>
  								<option value="M" @if ($view->gender =="M") {{ "selected" }} @endif>MASCULINE</option>
  							</select>
  						</td>
  						<td>
  							<select class="form-control" style="text-align: center;" name="civil_statuss" id="civil_status">
  								<option value="" @if ($view->civil_statuss == "") {{ "selected" }} @endif>--choose--</option>
                  <option value="child" @if ($view->civil_statuss == "Infant") {{ "selected" }} @endif>Infant</option>
  								<option value="child" @if ($view->civil_statuss == "child") {{ "selected" }} @endif>Child</option>
  								<option value="minor" @if ($view->civil_statuss == "minor") {{ "selected" }} @endif>Minor</option>
  								<option value="Common-law" @if ($view->civil_statuss == "Common-law") {{ "selected" }} @endif>Common law</option>
  								<option value="Married" @if ($view->civil_statuss == "Married") {{ "selected" }} @endif>Married</option>
                  <option value="Sep-fact" @if ($view->civil_statuss == "Unwed") {{ "selected" }} @endif>Unwed</option>
                  <option value="Sep-fact" @if ($view->civil_statuss == "Sep-fact") {{ "selected" }} @endif>Separated - infact</option>
  								<option value="Sep-legal" @if ($view->civil_statuss == "Sep-legal") {{ "selected" }} @endif>Separated - legal</option>
  								<option value="Single" @if ($view->civil_statuss == "Single") {{ "selected" }} @endif>Single</option>
  								<option value="Widow" @if ($view->civil_statuss == "Widow") {{ "selected" }} @endif>Widow</option>
  								<option value="Divorce" @if ($view->civil_statuss == "Divorce") {{ "selected" }} @endif>Divorce</option>
  							</select>
  						</td>
  					</tr>
  					<tr>
  						<td colspan="2" style="padding: 3px!important;">PERMANET ADDRESSS: <br><br>{{ $view->address }}</td>
  						<td colspan="2" style="padding: 3px!important;">
  							TEMPORARY ADDRESS: <br><br>
  							<input type="text" name="temp_address" id="address" class="form-control address" placeholder="Enter Address" value="{{ $view->temp_address }}">
  						</td>
  												<td style="padding: 3px!important;text-align:center">DATE/PLACE OF BIRTH: <br>{{ $view->birthday }}<br>
  						<input type="text" name="pob" id="placeofBirth" data-toggle="modal" data-target="#birthplace" class="form-control paddress" placeholder="Enter Address" value="{{ $view->pob }}">
  						</td>
  					</tr>
  					<tr>
  						<td colspan="2">
  							<div class="col-sm-6" style="padding: 0px;">
  								&nbsp;KIND OF LIVING ARRANGEMENT: &nbsp;
  							</div>
  							<div class="col-sm-6" style="padding: 0px;">
  								<select class="form-control" name="living_arrangement" id="livingArrangement">
  									<option value="" @if ($view->living_arrangement == "") {{ "selected" }} @endif>-- choose --</option>
  									<option value="O" @if ($view->living_arrangement == "O") {{ "selected" }} @endif>OWNED</option>
  									<option value="R" @if ($view->living_arrangement == "R") {{ "selected" }} @endif>RENTED</option>
  									<option value="S" @if ($view->living_arrangement == "S") {{ "selected" }} @endif>SHARED</option>
  									<option value="I" @if ($view->living_arrangement == "I") {{ "selected" }} @endif>INSTITUTION</option>
  									<option value="H" @if ($view->living_arrangement == "H") {{ "selected" }} @endif>HOMELESS</option>
  								</select>
  							</div>
  						</td>
  						<td colspan="3"></td>
  					</tr>
  					<tr>
  						<td colspan="2"><input type="text" name="education" placeholder="EDUCATIONAL ATTAINMENT: *" class="form-control required" id="P_educational_atm" required value="{{ $view->education }}"></td>
  						<td rowspan="2">EMPLOYER: <br><input type="text" name="employer" class="form-control" id="employeer" value="{{ $view->employer }}"></td>
  						<td rowspan="2">INCOME: <br><input type="text" name="income" class="form-control" id="income" value="{{ $view->income }}"></td>
  						<td rowspan="2">PER CAPITA INCOME <br><input type="text" name="capita_income" class="form-control" id="per_cap_income" value="{{ $view->capita_income }}"></td>
  					</tr>
  					<tr>
  						<td colspan="2"><input type="text" name="occupation" placeholder="OCCUPATION: *" class="form-control required" id="p_occupation" required value="{{ $view->occupation }}"></td>
  					</tr>
  					<tr align="center">
  						<td>
  							<div class="col-sm-5" style="padding: 0px">
  								PHILHEALTH: &nbsp;
  							</div>
  							<div class="col-sm-7" style="padding: 0px;">
  								<select class="form-control" name="philhealth" id="philhealth">
  									<option value="" @if ($view->philhealth == "") {{ "selected" }} @endif>-- choose --</option>
  									<option value="M" @if ($view->philhealth == "M") {{ "selected" }} @endif>MEMBER</option>
  									<option value="D" @if ($view->philhealth == "D") {{ "selected" }} @endif>DEPENDENT</option>
  								</select>
  							</div>
  						</td>
  						<td>CATEGORY</td>
  						<td>4P's</td>
  						<td colspan="2">CLASSIFICATION </td>
  					</tr>
  					<tr>
  						<td>
  							<select  class="form-control" name="membership" id="phil_member" style="text-align: center;">

  							    <option value="{{ $view->membership }}">{{ $view->membership }}</option>

  							</select>
  						</td>
  						<td>
  							<select class="form-control" name="category" style="text-align: center;" id="patient_type" required>
  								<option value="" @if ($view->category == "") {{ "selected" }} @endif>-- choose --</option>
  								<option value="O" @if ($view->category == "O") {{ "selected" }} @endif>OLD PATIENT</option>
  								<option value="N" @if ($view->category == "N") {{ "selected" }} @endif>NEW PATIENT</option>
  								<option value="C" @if ($view->category == "C") {{ "selected" }} @endif>CASES FORWARD</option>
  							</select>
  						</td>
  						<td>
  							<select class="form-control" name="fourpis" style="text-align: center;" id="4ps" required>
  								<option value="" @if ($view->fourpis == "") {{ "selected" }} @endif>-- choose --</option>
  								<option value="N" @if ($view->fourpis == "N") {{ "selected" }} @endif>NO</option>
  								<option value="Y" @if ($view->fourpis == "Y") {{ "selected" }} @endif>YES</option>
  							</select>
  						</td>
  						<td  colspan="2">
  							<select class="form-control" name="mss_id" id="classification" style="text-align: center;" required>
  									<option value="">-- choose --</option>
                    @foreach ($mss as $row)
                      @if ($view->mss_id == $row->id)
                    <option value="{{ $row->id }}" {{ "selected" }}>{{ $row->label.'-'.$row->description }}</option>
                      @else
                     <option value="{{ $row->id }}">{{ $row->label.'-'.$row->description }}</option>
                      @endif
                    @endforeach
  							</select>
  						</td>
  					</tr>
  					<tr>
  						<td colspan="2">
  							<div class="col-sm-6" style="padding: 0px;">
  								SECTORIAL MEMBERSHIP:
  							</div>
  							<div class="col-sm-6" style="padding: 0px;">
  								<select class="form-control" name="sectorial" id="sect_membership" required>
                    <option value="{{ $view->sectorial }}">{{ $view->sectorial }}</option>
  									<option value="BRGY">BRGY. OFFICIAL</option>
  									<option value="PWD">PWD</option>
  									<option value="BHW">BHW</option>
  									<option value="INDIGENOUS PEOPLE">INDIGENOUS PEOPLE</option>
  									<option value="VETERANS">VETERANS</option>
  									<option value="VAWC/IN INSTITUTION">VAWC/IN INSTITUTION</option>
  									<option value="ELDERLY">ELDERLY</option>
  									<option value="OTHERS">OTHERS:</option>
  								</select>
  							</div>

  						</td>
  						<td colspan="3"></td>
  					</tr>
  				</table>
  				<table class="table table-bordered" id="PgovStatus">
  					<tr align="center">
  						<td colspan="7">FAMILY COMPOSITION</td>
  					</tr>
  					<tr align="center">
  						<td width="30%">NAME</td>
  						<td width="10%">AGE</td>
  						<td>CIVIL STATUS</td>
  						<td>RELATION TO PATIENT</td>
  						<td>EDUC'L ATTAINMENT</td>
  						<td>OCCUPATION</td>
  						<td>MONTHLY INCOME</td>
  					</tr>
            <?php $count = 1; ?> 
            @foreach($family as $list)
                    <tr>
                        <td hidden><input type="" name="id[]" value="{{ $list->id }}"></td>
                        <td><input type="text" name="name[]" class="form-control" id="F_name" value="{{ $list->name }}"></td>
                        <td><input type="text" name="age[]" class="form-control" id="F_age[]" style="text-align: center;" value="{{ $list->age }}"></td>
                        <td>
                          <select class="form-control" style="text-align: center;" name="status[]" id="F_cstatus[]">
                            <option value="" @if ($list->status == "") {{ "selected" }} @endif></option>
                            <option value="child" @if ($list->status == "child") {{ "selected" }} @endif>Child</option>
                            <option value="minor" @if ($list->status == "minor") {{ "selected" }} @endif>Minor</option>
                            <option value="Common-law" @if ($list->status == "Common-law") {{ "selected" }} @endif>Common law</option>
                            <option value="Married" @if ($list->status == "Married") {{ "selected" }} @endif>Married</option>
                            <option value="Sep-fact" @if ($list->status == "Sep-fact") {{ "selected" }} @endif>Separated - infact</option>
                            <option value="Sep-legal" @if ($list->status == "Sep-legal") {{ "selected" }} @endif>Separated - legal</option>
                            <option value="Single" @if ($list->status == "Single") {{ "selected" }} @endif>Single</option>
                            <option value="Widow" @if ($list->status == "Widow") {{ "selected" }} @endif>Widow</option>
                            <option value="Divorce" @if ($list->status == "Divorce") {{ "selected" }} @endif>Divorce</option>
                          </select>
                        </td>
                        <td><input type="text" name="relationship[]" class="form-control" id="F_rel2patient[]" value="{{ $list->relationship }}"></td>
                        <td><input type="text" name="feducation[]" class="form-control" id="F_edatnmnt[]" value="{{ $list->feducation }}"></td>
                        <td><input type="text" name="foccupation[]" class="form-control" id="F_occupationn[]" value="{{ $list->foccupation }}"></td>
                        <td><input type="text" name="fincome[]" class="form-control" id="F_Mincome[]" value="{{ $list->fincome }}"></td>
                    </tr>
            <?php $count++; ?>
            @endforeach
            @for($i = $count; $i<=8;$i++)
  					<tr>
              <td hidden><input type="" name="id[]" value=""></td>
  						<td><input type="text" name="name[]" class="form-control" placeholder="{{ $i }}" id="F_name"></td>
  						<td><input type="text" name="age[]" class="form-control" id="F_age[]" style="text-align: center;"></td>
  						<td>
  							<select class="form-control" style="text-align: center;" name="status[]" id="F_cstatus[]">
  								<option value=""></option>
                  <option value="child">Child</option>
                  <option value="minor">Minor</option>
                  <option value="Common-law">Common law</option>
                  <option value="Married">Married</option>
                  <option value="Sep-fact">Separated - infact</option>
                  <option value="Sep-legal">Separated - legal</option>
                  <option value="Single">Single</option>
                  <option value="Widow">Widow</option>
                  <option value="Divorce">Divorce</option>
  							</select>
  						</td>
  						<td><input type="text" name="relationship[]" class="form-control" id="F_rel2patient[]"></td>
  						<td><input type="text" name="feducation[]" class="form-control" id="F_edatnmnt[]"></td>
  						<td><input type="text" name="foccupation[]" class="form-control" id="F_occupationn[]"></td>
  						<td><input type="text" name="fincome[]" class="form-control" id="F_Mincome[]"></td>
  					</tr>
            @endfor

  					<tr>
  						<td colspan="3"><input type="text" name="source_income" class="form-control" placeholder="OTHER SOURCES OF INCOME" id="souces_of_income" value="{{ $view->source_income }}" ></td>
  						<td colspan="4"><input type="text" name="household" class="form-control required" placeholder="HOUSEHOLD SIZE: *" id="household_size" required value="{{ $view->household }}"></td>
  					</tr>
  					<tr>
  						<td colspan="3"><input type="text" name="monthly_expenses" class="form-control" placeholder="MONHTLY EXPENSES" id="monthly_expenses" value="{{ $view->monthly_expenses }}"></td>
  						<td colspan="4"><input type="text" name="monthly_expenditures" class="form-control" placeholder="TOTAL MONTHLY EXPENDITURES " id="monthl_expenditures" value="{{ $view->monthly_expenditures }}" ></td>
  					</tr>
  					<tr>
  						<td>
  							<div class="col-sm-7" style="padding: 0px;">
  								<select class="form-control" name="houselot" id="house_lot">
                    <?php $house = explode('-',trim($view->houselot));?>
  									<option value="" @if ($house[0] == "") {{ "selected" }} @endif>-- HOUSE AND LOT --</option>
  									<option value="owned" @if ($house[0] == "owned") {{ "selected" }} @endif>OWNED</option>
  									<option value="rented" @if ($house[0] == "rented") {{ "selected" }} @endif>RENTED</option>
  									<option value="free" @if ($house[0] == "free") {{ "selected" }} @endif>FREE</option>
  								</select>
  							</div>
  							<div class="col-sm-5" style="padding: 0px;">
  								<input type="text" name="H_php" class="form-control" placeholder="Php" id="H_php" @if (isset($house[1])) value="{{ $house[1] }}" @endif>
  							</div>
  						</td>
  						<td colspan="2">
  							<div class="col-sm-8" style="padding: 0px;">
  								<select class="form-control" name="light" id="light_source">
                    <?php $light = explode('-',trim($view->light));?>
  									<option value="" @if ($light[0] == "") {{ "selected" }} @endif>-- LIGHT SOURCE --</option>
  									<option value="candle" @if ($light[0] == "candle") {{ "selected" }} @endif>CANDLE</option>
  									<option value="electric" @if ($light[0] == "electric") {{ "selected" }} @endif>ELECTRIC</option>
  									<option value="kerosene" @if ($light[0] == "kerosene") {{ "selected" }} @endif>KEROSENE</option>
  								</select>
  							</div>
  							<div class="col-sm-4" style="padding: 0px;">
  								<input type="text" name="L_php" class="form-control" placeholder="Php" id="L_php" @if (isset($light[1])) value="{{ $light[1] }}" @endif>
  							</div>
  						</td>
  						<td colspan="2">
  							<div class="col-sm-8" style="padding: 0px;">
  								<select class="form-control" name="water" id="water_source">
                    <?php $water = explode('-',trim($view->water));?>
  									<option value="" @if ($water[0] == "") {{ "selected" }} @endif>-- WATER SOURCE --</option>
  									<option value="water_distric" @if ($water[0] == "water_distric") {{ "selected" }} @endif>WATER DISTRICT</option>
  									<option value="public" @if ($water[0] == "public") {{ "selected" }} @endif>PUBLIC</option>
  									<option value="owned" @if ($water[0] == "owned") {{ "selecte" }} @endif>OWNED</option>
  									<option value="deep_well" @if ($water[0] == "deep_well") {{ "selected" }} @endif>DEEP WELL</option>
  									<option value="pump" @if ($water[0] == "pump") {{ "selected" }} @endif>PUMP</option>
  								</select>
  							</div>
  							<div class="col-sm-4" style="padding: 0px;">
  								<input type="text" name="W_php" class="form-control" placeholder="Php" id="W_php"@if (isset($water[1]))  value="{{ $water[1] }}" @endif>
  							</div>
  						</td>
  						<td colspan="2">
  							<div class="col-sm-7" style="padding: 0px;">
  								<select class="form-control" name="fuel" id="fuel_source">
                     <?php $fuel = explode('-',trim($view->fuel));?>
  									<option value="" @if ($fuel[0] == "") {{ "selected" }} @endif>-- FUEL SOURCE --</option>
  									<option value="gas" @if ($fuel[0] == "gas") {{ "selected" }} @endif>GAS</option>
  									<option value="charcoal" @if ($fuel[0] == "charcoal") {{ "selected" }} @endif>CHARCOAL</option>
  									<option value="firewood" @if ($fuel[0] == "firewood") {{ "selected" }} @endif>FIREWOOD</option>
  								</select>
  							</div>
  							<div class="col-sm-5" style="padding: 0px;">
  								<input type="text" name="F_php" class="form-control" placeholder="Php" id="F_php" @if (isset($fuel[1])) value="{{ $fuel[1] }}" @endif>
  							</div>
  						</td>
  					</tr>
  					<tr>
  						<td><input type="text" name="food" class="form-control" placeholder="FOOD: Php" id="food_php" value="{{ $view->food }}"></td>
  						<td colspan="2"><input type="text" name="educationphp" class="form-control" placeholder="EDUCATIO: Php" id="education_php" value="{{ $view->educationphp }}"></td>
  						<td colspan="2"><input type="text" name="clothing" class="form-control" placeholder="CLOTHING: Php" id="clothing_php" value="{{ $view->clothing }}"></td>
  						<td colspan="2"><input type="text" name="transportation" class="form-control" placeholder="TRANSPORATION: Php" id="transportation_php" value="{{ $view->transportation }}"></td>
  					</tr>
  					<tr>
  						<td><input type="text" name="house_help" class="form-control" placeholder="HOUSE HELP: Php" id="house_help_php" value="{{ $view->house_help }}"></td>
  						<td colspan="2"><input type="text" name="expinditures" class="form-control" placeholder="MEDICAL EXPENDITURES: Php" id="med_exp_php" value="{{ $view->expinditures }}"></td>
  						<td colspan="2"><input type="text" name="insurance" class="form-control" placeholder="INSURANCE PREMIUM: Php" id="ins_prem_php" value="{{ $view->insurance }}"></td>
  						<td colspan="2"><input type="text" name="other_expenses" class="form-control" placeholder="OTHERS:" id="others_php" value="{{ $view->other_expenses }}"></td>
  					</tr>
  					<tr>
  						<td colspan="3"><input type="text" name="internet" class="form-control" placeholder="INTERNET CONNECTION: Php" id="internet_php" value="{{ $view->internet }}"></td>
  						<td colspan="4"><input type="text" name="cable" class="form-control" placeholder="CABLE: Php" id="cable_php" value="{{ $view->cable }}"></td>
  					</tr>
  					<tr>
  						<th colspan="7">II. MEDICAL RECORD</th>
  					</tr>
  					<tr>
  						<td>
  							<textarea name="medical"  class="form-control" id="medical_data" placeholder="MEDICAL DATA:" >{{ $view->medical }}</textarea>
  						</td>
  						<td colspan="3">
  							<textarea name="admitting" class="form-control" id="admitting_diagnosis" placeholder="ADMITTING DIAGNOSIS:" >{{ $view->admitting }}</textarea>
  						</td>
  						<td colspan="3">
  							<textarea name="final" class="form-control" id="final_diagnosis"  placeholder="FINAL DIAGNOSIS:" >{{ $view->final }}</textarea
  						></td>
  					</tr>
  					<tr>
  						<td colspan="7">
  							<input type="text" name="duration" class="form-control required" placeholder="DURATION OF PROBLEM/ SYMPTOMS: *" id="duration_symptoms" required value="{{ $view->duration }}">
  						</td>
  					</tr>
  					<tr>
  						<td colspan="7">
  							<input type="text" name="previus" class="form-control" placeholder="PREVIOUS TREATMENT DURATION:" id="previous_treatment" value="{{ $view->previus }}">
  						</td>
  					</tr>
  					<tr>
  						<td colspan="7">
  							<input type="text" name="present" class="form-control" placeholder="PRESENT TREATMENT PLAN:" id="treatment_plan" value="{{ $view->present }}">
  						</td>
  					</tr><tr>
  						<td colspan="7">
  							<input type="text" name="health" class="form-control" placeholder="HEALTH ACCESSIBILITY PROBLEM:" id="health_accessibilty" value="{{ $view->health }}">
  						</td>
  					</tr>
  					<tr>
  						<td colspan="3">
  							<input type="text" name="findings" class="form-control" placeholder="ASSESSMENT FINDINGS:" id="assesment_findings" value="{{ $view->findings }}">
  						</td>
  						<td colspan="4">
  							<input type="text" name="interventions" class="form-control" placeholder="RECOMMENDED INTERVENTIONS:" id="recommended_intervention" value="{{ $view->interventions }}">
  						</td>
  					</tr>
  					<tr>
  						<td colspan="3">
  							<input type="text" name="admision" class="form-control" placeholder="PRE-ADMISSION PLANNING:" id="pre_admission" value="{{ $view->admision }}">
  						</td>
  						<td colspan="4">
  							<input type="text" name="planning" class="form-control" placeholder="DISCHARGE PLANNING:" id="discharge_planning" value="{{ $view->planning }}">
  						</td>
  					</tr>
  					<tr>
  						<td colspan="7"><input type="text" name="counseling" class="form-control" placeholder="COUNSELING:" id="counseling" value="{{ $view->counseling }}"></td>
  					</tr>

  				</table>
          <div class="col-sm-3 n nameofinterviewed" style="padding: 0px;margin-bottom: 5px;margin-top: -15px;">
              <input type="text" name="interviewed" class="form-control" placeholder="Name of interviewee" value="{{ $view->interviewed }}" style="height: 33px;">
          </div>
          <div class="col-sm-3 n nameofinterviewed" style="padding: 0px;margin-bottom: 5px;margin-top: -15px;">
              <input type="text" name="relpatient" class="form-control" placeholder="Relationship to patient" value="{{ $view->relpatient }}" style="height: 33px;">
          </div>
          <div class="col-md-12">
            <div class="btn-group submit_classification">
                <button type="submit" class="btn btn-success btn-fab" id="submit_classification" onclick="return confirm('Submit this Classification?')"><i class="fa fa-check"></i></button>
            </div>
          </div>
  				</form>
  			</div>
  		</div>
  	</div>
  </div>
  <div class="modal fade" id="inputmodal" role="dialog">
    <div class="modal-dialog modal-sm">
    <form class="form-horizontal">
        <div class="modal-content">
          <div class="modal-body">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">please specify:</h4>
          <div class="col-sm-12">
            <div class="form-group">
              <label class=""></label>
              <input type="text" name="" id="inputToOthers" class="form-control inputToOthers">
              <input type="text" name="" id="philinputToOthers" class="form-control philinputToOthers">
              <input type="text" name="" id="sectinputToOthers" class="form-control sectinputToOthers">
            </div>
           </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
      </div>
    </form>
    </div>
  </div>

  @endsection
  @section('pagescript')
    <script src="{{ asset('public/plugins/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('public/js/mss/classification.js') }}"></script>

  @endsection


@endcomponent
