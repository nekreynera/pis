@component('partials/header')



  @slot('title')
    PIS | Classification
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
          <div class="submitclassificationloader">
            <img src="public/images/loader.svg">
          </div>
  				<form class="mssformsubmit" method="post" action="{{ url('mss') }}">
          {{ csrf_field() }}
  				<table class="table table-bordered" id="PgovStatus">
  					<tr style="text-align: center;">
  						<td width="25%" >DATE OF INTERVIEW <br>{{ Carbon::parse()->now()->format('Y/m/d h:i:a') }}<br>
  						</td>

  						<input type="hidden" name="validity" value="{{  Carbon::now()->addYear()->format('Y-m-d') }}" id="validity" />
  						<input type="hidden" name="patients_id" value="{{ $patient->id }}" id="patient_id" />
              <input type="hidden" name="users_id" value="{{ Auth::user()->id }}">

  						<td width="25%"><input type="text" name="date_admission" class="form-control" placeholder="DATE OF ADMISSION/CONSULTATION:" id="date_of_adm" style="height: 100%!important"></td>
  						<td width="17%" align="center">PEMAT<input type="hidden" name="building" value="OPD" id="building"></td>
  						<td width="17%">HOSP NO <br> <font id="hosp_no">{{ $patient->hospital_no }}</font></td>
  						<td width="16%"><input type="text" name="mswd" class="form-control required" placeholder="MSWD NO:*" id="mswd_no" required style="height: 100%!important"></td>
  					</tr>
  					<tr>
  						<td colspan="2">
  						<select name="referral" class="form-control selectrequired" id="referral" required style="first:color: red">
  							<option value="">-- REFERRAL --</option>
  							<option value="GH">GH</option>
  							<option value="PH/PC">PH/PC</option>
  							<option value="POLITICIAN">POLITICIAN</option>
  							<option value="MEDIA">MEDIA</option>
  							<option value="HCT/RHU/TACRU">HCT/RHU/TACRU</option>
  							<option value="NGO/PRIVATE WELFARE AGENCIES">NGO/PRIVATE WELFARE AGENCIES</option>
  							<option value="GOVT AGENCIES">GOV'T AGENCIES</option>
  							<option value="WALK-IN">WALK-IN</option>
  							<option value="others">OTHERS:</option>
  						</select>
  						</td>
  						<td colspan="2"><input type="text" name="referral_addrress" placeholder="ADDRESS:" class="form-control" id="referral_address"></td>
  						<td><input type="text" name="referral_telno" placeholder="TEL. NO.:" class="form-control" id="referral_tel_no"></td>
  					</tr>
  					<tr>
  						<th colspan="5">&nbsp;I. DEMOGRAPHIC DATA: </th>

  					</tr>
  					<tr>
  						<td colspan="2"><input type="text" name="religion" placeholder="RELIGION:" class="form-control" id="religion"></td>
  						<td colspan="3"><input type="text" name="companion" placeholder="COMPANION UPON ADMISSION:" class="form-control" id="companion"></td>
  					</tr>
  					<tr align="center">
  						<td>PATIENTS NAME</td>
  						<td>AGE</td>
  						<td>SEX</td>
  						<td>GENDER</td>
  						<td>CIVIL STATUS</td>
  					</tr>
  					<tr align="center">
  						<td>{{ $patient->last_name.', '.$patient->first_name.' '.$patient->middle_name }}</td>
                @php
                  $agePatient = App\Patient::age($patient->birthday)
                @endphp
  						<td>{{ $agePatient }}</td>
              <td>{{ ($patient->sex == 'M')?"MALE":"FEMALE" }}</td>
  						<td>
  							<select class="form-control" style="text-align: center;" name="gender" id="gender">
  								<option value="">-- choose --</option>
  								<option value="F">FEMININE</option>
  								<option value="M">MASCULINE</option>
  							</select>
  						</td>
  						<td>
  							<select class="form-control" style="text-align: center;" name="civil_statuss" id="civil_status">
  								<option value="">--choose--</option>
                  <option value="Infant">Infant</option>
  								<option value="child">Child</option>
  								<option value="minor">Minor</option>
  								<option value="Common-law">Common law</option>
  								<option value="Married">Married</option>
                  <option value="Unwed">Unwed</option>
                  <option value="Sep-fact">Separated - infact</option>
  								<option value="Sep-legal">Separated - legal</option>
  								<option value="Single">Single</option>
  								<option value="Widow">Widow</option>
  								<option value="Divorce">Divorce</option>
  							</select>
  						</td>
  					</tr>
  					<tr>
  						<td colspan="2" style="padding: 3px!important;">PERMANET ADDRESSS: <br><br>{{ $patient->address }}</td>
  						<td colspan="2" style="padding: 3px!important;">
  							TEMPORARY ADDRESS: <br><br>
  							<input type="text" name="temp_address" id="address" data-toggle="modal" data-target="#myModal" class="form-control address" placeholder="Enter Address">
  						</td>
  												<td style="padding: 3px!important;text-align:center">DATE/PLACE OF BIRTH: <br>{{ $patient->birthday }}<br>
  						<input type="text" name="pob" id="placeofBirth" data-toggle="modal" data-target="#birthplace" class="form-control paddress" placeholder="Enter Address">
  						</td>
  					</tr>
  					<tr>
  						<td colspan="2">
  							<div class="col-sm-6" style="padding: 0px;">
  								&nbsp;KIND OF LIVING ARRANGEMENT: &nbsp;
  							</div>
  							<div class="col-sm-6" style="padding: 0px;">
  								<select class="form-control" name="living_arrangement" id="livingArrangement">
  									<option value="">-- choose --</option>
  									<option value="O">OWNED</option>
  									<option value="R">RENTED</option>
  									<option value="S">SHARED</option>
  									<option value="I">INSTITUTION</option>
  									<option value="H">HOMELESS</option>
  								</select>
  							</div>
  						</td>
  						<td colspan="3"></td>
  					</tr>
  					<tr>
  						<td colspan="2"><input type="text" name="education" placeholder="EDUCATIONAL ATTAINMENT: *" class="form-control required" id="P_educational_atm" required></td>
  						<td rowspan="2">EMPLOYER: <br><input type="text" name="employer" class="form-control" id="employeer"></td>
  						<td rowspan="2">INCOME: <br><input type="text" name="income" class="form-control" id="income"></td>
  						<td rowspan="2">PER CAPITA INCOME <br><input type="text" name="capita_income" class="form-control" id="per_cap_income"></td>
  					</tr>
  					<tr>
  						<td colspan="2"><input type="text" name="occupation" placeholder="OCCUPATION: *" class="form-control required" id="p_occupation" required></td>
  					</tr>
  					<tr align="center">
  						<td>
  							<div class="col-sm-5" style="padding: 0px">
  								PHILHEALTH: &nbsp;
  							</div>
  							<div class="col-sm-7" style="padding: 0px;">
  								<select class="form-control" name="philhealth" id="philhealth">
  									<option value="">-- choose --</option>
  									<option value="M">MEMBER</option>
  									<option value="D">DEPENDENT</option>
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
  							    <option value="">-- select one -- </option>

  							</select>
  						</td>
  						<td>
  							<select class="form-control selectrequired" name="category" style="text-align: center;" id="patient_type" required>
  								<option value="">-- choose --</option>
  								<option value="O">OLD PATIENT</option>
  								<option value="N">NEW PATIENT</option>
  								<option value="C">CASES FORWARD</option>
  							</select>
  						</td>
  						<td>
  							<select class="form-control selectrequired" name="fourpis" style="text-align: center;" id="4ps" required>
  								<option value="">-- choose --</option>
  								<option value="N">NO</option>
  								<option value="Y">YES</option>
  							</select>
  						</td>
  						<td  colspan="2">
  							<select class="form-control selectrequired" name="mss_id" id="classification" style="text-align: center;" required>
  									<option value="">-- choose --</option>
                    @foreach ($mss as $row)
                    <option value="{{ $row->id }}">{{ $row->label.'-'.$row->description }}</option>
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
  								<select class="form-control selectrequired" name="sectorial" id="sect_membership" required>
  									<option value="">-- choose --</option>
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
            
            @for($i = 1; $i<=8;$i++)
  					<tr>
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
  						<td colspan="3"><input type="text" name="source_income" class="form-control" placeholder="OTHER SOURCES OF INCOME" id="souces_of_income"></td>
  						<td colspan="4"><input type="text" name="household" class="form-control required" placeholder="HOUSEHOLD SIZE: *" id="household_size" required ></td>
  					</tr>
  					<tr>
  						<td colspan="3"><input type="text" name="monthly_expenses" class="form-control" placeholder="MONHTLY EXPENSES" id="monthly_expenses"></td>
  						<td colspan="4"><input type="text" name="monthly_expenditures" class="form-control" placeholder="TOTAL MONTHLY EXPENDITURES " id="monthl_expenditures"></td>
  					</tr>
  					<tr>
  						<td>
  							<div class="col-sm-7" style="padding: 0px;">
  								<select class="form-control" name="houselot" id="house_lot">
  									<option value="">-- HOUSE AND LOT --</option>
  									<option value="owned">OWNED</option>
  									<option value="rented">RENTED</option>
  									<option value="free">FREE</option>
  								</select>
  							</div>
  							<div class="col-sm-5" style="padding: 0px;">
  								<input type="text" name="H_php" class="form-control" placeholder="Php" id="H_php">
  							</div>
  						</td>
  						<td colspan="2">
  							<div class="col-sm-8" style="padding: 0px;">
  								<select class="form-control" name="light" id="light_source">
  									<option value="">-- LIGHT SOURCE --</option>
  									<option value="candle">CANDLE</option>
  									<option value="electric">ELECTRIC</option>
  									<option value="kerosene">KEROSENE</option>
  								</select>
  							</div>
  							<div class="col-sm-4" style="padding: 0px;">
  								<input type="text" name="L_php" class="form-control" placeholder="Php" id="L_php">
  							</div>
  						</td>
  						<td colspan="2">
  							<div class="col-sm-8" style="padding: 0px;">
  								<select class="form-control" name="water" id="water_source">
  									<option value="">-- WATER SOURCE --</option>
  									<option value="water_distric">WATER DISTRICT</option>
  									<option value="public">PUBLIC</option>
  									<option value="owned">OWNED</option>
  									<option value="deep_well">DEEP WELL</option>
  									<option value="pump">PUMP</option>
  								</select>
  							</div>
  							<div class="col-sm-4" style="padding: 0px;">
  								<input type="text" name="W_php" class="form-control" placeholder="Php" id="W_php">
  							</div>
  						</td>
  						<td colspan="2">
  							<div class="col-sm-7" style="padding: 0px;">
  								<select class="form-control" name="fuel" id="fuel_source">
  									<option value="">-- FUEL SOURCE --</option>
  									<option value="gas">GAS</option>
  									<option value="charcoal">CHARCOAL</option>
  									<option value="firewood">FIREWOOD</option>
  								</select>
  							</div>
  							<div class="col-sm-5" style="padding: 0px;">
  								<input type="text" name="F_php" class="form-control" placeholder="Php" id="F_php">
  							</div>
  						</td>
  					</tr>
  					<tr>
  						<td><input type="text" name="food" class="form-control" placeholder="FOOD: Php" id="food_php"></td>
  						<td colspan="2"><input type="text" name="educationphp" class="form-control" placeholder="EDUCATIO: Php" id="education_php"></td>
  						<td colspan="2"><input type="text" name="clothing" class="form-control" placeholder="CLOTHING: Php" id="clothing_php"></td>
  						<td colspan="2"><input type="text" name="transportation" class="form-control" placeholder="TRANSPORATION: Php" id="transportation_php"></td>
  					</tr>
  					<tr>
  						<td><input type="text" name="house_help" class="form-control" placeholder="HOUSE HELP: Php" id="house_help_php"></td>
  						<td colspan="2"><input type="text" name="expinditures" class="form-control" placeholder="MEDICAL EXPENDITURES: Php" id="med_exp_php"></td>
  						<td colspan="2"><input type="text" name="insurance" class="form-control" placeholder="INSURANCE PREMIUM: Php" id="ins_prem_php"></td>
  						<td colspan="2"><input type="text" name="other_expenses" class="form-control" placeholder="OTHERS:" id="others_php"></td>
  					</tr>
  					<tr>
  						<td colspan="3"><input type="text" name="internet" class="form-control" placeholder="INTERNET CONNECTION: Php" id="internet_php"></td>
  						<td colspan="4"><input type="text" name="cable" class="form-control" placeholder="CABLE: Php" id="cable_php"></td>
  					</tr>
  					<tr>
  						<th colspan="7">II. MEDICAL RECORD</th>
  					</tr>
  					<tr>
  						<td>
  							<textarea name="medical"  class="form-control" id="medical_data" placeholder="MEDICAL DATA:"></textarea>
  						</td>
  						<td colspan="3">
  							<textarea name="admitting" class="form-control" id="admitting_diagnosis" placeholder="ADMITTING DIAGNOSIS:"></textarea>
  						</td>
  						<td colspan="3">
  							<textarea name="final" class="form-control" id="final_diagnosis"  placeholder="FINAL DIAGNOSIS:"></textarea
  						></td>
  					</tr>
  					<tr>
  						<td colspan="7">
  							<input type="text" name="duration" class="form-control required" placeholder="DURATION OF PROBLEM/ SYMPTOMS: *" id="duration_symptoms" required>
  						</td>
  					</tr>
  					<tr>
  						<td colspan="7">
  							<input type="text" name="previus" class="form-control" placeholder="PREVIOUS TREATMENT DURATION:" id="previous_treatment">
  						</td>
  					</tr>
  					<tr>
  						<td colspan="7">
  							<input type="text" name="present" class="form-control" placeholder="PRESENT TREATMENT PLAN:" id="treatment_plan">
  						</td>
  					</tr><tr>
  						<td colspan="7">
  							<input type="text" name="health" class="form-control" placeholder="HEALTH ACCESSIBILITY PROBLEM:" id="health_accessibilty">
  						</td>
  					</tr>
  					<tr>
  						<td colspan="3">
  							<input type="text" name="findings" class="form-control" placeholder="ASSESSMENT FINDINGS:" id="assesment_findings">
  						</td>
  						<td colspan="4">
  							<input type="text" name="interventions" class="form-control" placeholder="RECOMMENDED INTERVENTIONS:" id="recommended_intervention">
  						</td>
  					</tr>
  					<tr>
  						<td colspan="3">
  							<input type="text" name="admision" class="form-control" placeholder="PRE-ADMISSION PLANNING:" id="pre_admission">
  						</td>
  						<td colspan="4">
  							<input type="text" name="planning" class="form-control" placeholder="DISCHARGE PLANNING:" id="discharge_planning">
  						</td>
  					</tr>
  					<tr>
  						<td colspan="7"><input type="text" name="counseling" class="form-control" placeholder="COUNSELING:" id="counseling"></td>
  					</tr>

  				</table>
          <div class="col-sm-3 n nameofinterviewed" style="padding: 0px;margin-bottom: 5px;margin-top: -15px;">
              <input type="text" name="interviewed" class="form-control" placeholder="Name of interviewee" style="height: 33px;">
          </div>
          <div class="col-sm-3 n nameofinterviewed" style="padding: 0px;margin-bottom: 5px;margin-top: -15px;">
              <input type="text" name="relpatient" class="form-control" placeholder="Relationship to patient" style="height: 33px;">
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
