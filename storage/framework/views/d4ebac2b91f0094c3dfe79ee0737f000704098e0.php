<?php

use App\User;

?>

<?php $__env->startComponent('partials/header'); ?>



  <?php $__env->slot('title'); ?>
    OPD | classification
  <?php $__env->endSlot(); ?>



  <?php $__env->startSection('pagestyle'); ?>
    <link href="<?php echo e(asset('public/plugins/css/jquery-ui.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/mss/classification.css')); ?>" rel="stylesheet" />
  <?php $__env->stopSection(); ?>



  <?php $__env->startSection('header'); ?>
    <?php echo $__env->make('mss/navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php $__env->stopSection(); ?>



  <?php $__env->startSection('content'); ?>
  <div class="container mainWrapper">
  	<div class="panel" id="classification_panel">
  		<div class="panel-default">
  			<div class="panel-heading">
  				<h3>MSWD Assessment Tool <i class="fa fa-file-o"></i></h3>
  			</div>
  			<div class="panel-body table-responsive">
          <?php if($view->validity < Carbon::now()->format('Y-m-d')): ?>
            <div class="bg-info information-panel">
              <div class="info-header">
                <label><span class="fa fa-info-circle"></span> INFORMATION</label>
              </div>
              <div class="info-body">
                <p>The Patient Classification Validity Already Reached the Limit at Date: <b><?php echo e(Carbon::parse($view->validity)->format('m/d/Y')); ?></b></p>
                <p>Classified by:
                  <?php
                    $user = User::find($view->users_id);
                  ?>
                 <b><?php echo e($user->last_name.', '.$user->first_name.' '.substr($user->middle_name, 0,1).'.'); ?></b> at datetime <b><?php echo e(Carbon::parse($view->created_at)->format('m/d/Y g:ia')); ?></b></p>
                <label>KINDLY</label>
                <ul>
                  <li>Check Patient information</li>
                  <li>Update Patient Classification and Information</li>
                </ul>
              </div>
            </div>
          <?php endif; ?>
          <div class="submitclassificationloader">
            <img src="/opd/public/images/loader.svg">
          </div>
  				<form class="mssformsubmit" method="post" action='<?php echo e(url("mss/$ids")); ?>'>
            <?php echo e(csrf_field()); ?>

           <?php echo e(method_field('PATCH')); ?> 
  				<table class="table table-bordered" id="PgovStatus">
  					<tr style="text-align: center;">
  						<td width="25%" >DATE OF INTERVIEW <br><?php echo e($view->created_at); ?><br>
  						</td>
              <input type="hidden" name="patients_id" value="<?php echo e($view->patients_id); ?>" />

              <input type="hidden" name="users_id" value="<?php echo e($view->users_id); ?>">

  						<td width="25%"><input type="text" name="date_admission" class="form-control" placeholder="DATE OF ADMISSION/CONSULTATION:" id="date_of_adm" style="height: 100%!important" value="<?php echo e($view->date_admission); ?>"></td>
  						<td width="17%" align="center">OPD</td>
  						<td width="17%">HOSP NO <br> <font id="hosp_no"><?php echo e($view->hospital_no); ?></font></td>
  						<td width="16%"><input type="text" name="mswd" class="form-control required" placeholder="MSWD NO:*" id="mswd_no" required style="height: 100%!important" value="<?php echo e($view->mswd); ?>"></td>
  					</tr>
  					<tr>
  						<td colspan="2">
  						<select name="referral" class="form-control" id="referral" required style="first:color: red">
  							<option value="<?php echo e($view->referral); ?>" <?php if($view->referral == ""): ?> <?php echo e("selected"); ?> <?php endif; ?>><?php echo e($view->referral); ?></option>
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
  						<td colspan="2"><input type="text" name="referral_addrress" placeholder="ADDRESS:" class="form-control" id="referral_address" value="<?php echo e($view->referral_addrress); ?>"></td>
  						<td><input type="text" name="referral_telno" placeholder="TEL. NO.:" class="form-control" id="referral_tel_no" value="<?php echo e($view->referral_telno); ?>"></td>
  					</tr>
  					<tr>
  						<th colspan="5">&nbsp;I. DEMOGRAPHIC DATA: </th>

  					</tr>
  					<tr>
  						<td colspan="2"><input type="text" name="religion" placeholder="RELIGION:" class="form-control" id="religion" value="<?php echo e($view->religion); ?>"></td>
  						<td colspan="3"><input type="text" name="companion" placeholder="COMPANION UPON ADMISSION:" class="form-control" id="companion" value="<?php echo e($view->companion); ?>"></td>
  					</tr>
  					<tr align="center">
  						<td>PATIENTS NAME</td>
  						<td>AGE</td>
  						<td>SEX</td>
  						<td>GENDER</td>
  						<td>CIVIL STATUS</td>
  					</tr>
  					<tr align="center">
  						<td><?php echo e($view->last_name.', '.$view->first_name.' '.$view->middle_name); ?></td>
  						 <?php
                  $agePatient = App\Patient::age($view->birthday)
                ?>
              <td><?php echo e($agePatient); ?></td>
              <td><?php echo e(($view->sex == 'M')?"MALE":"FEMALE"); ?></td>
  						<td>
  							<select class="form-control" style="text-align: center;" name="gender" id="gender">
  								<option value="" <?php if($view->gender ==""): ?> <?php echo e("selected"); ?> <?php endif; ?>>-- choose --</option>
  								<option value="F" <?php if($view->gender =="F"): ?> <?php echo e("selected"); ?> <?php endif; ?>>FEMININE</option>
  								<option value="M" <?php if($view->gender =="M"): ?> <?php echo e("selected"); ?> <?php endif; ?>>MASCULINE</option>
  							</select>
  						</td>
  						<td>
  							<select class="form-control" style="text-align: center;" name="civil_statuss" id="civil_status">
  								<option value="" <?php if($view->civil_statuss == ""): ?> <?php echo e("selected"); ?> <?php endif; ?>>--choose--</option>
                  <option value="child" <?php if($view->civil_statuss == "Infant"): ?> <?php echo e("selected"); ?> <?php endif; ?>>Infant</option>
  								<option value="child" <?php if($view->civil_statuss == "child"): ?> <?php echo e("selected"); ?> <?php endif; ?>>Child</option>
  								<option value="minor" <?php if($view->civil_statuss == "minor"): ?> <?php echo e("selected"); ?> <?php endif; ?>>Minor</option>
  								<option value="Common-law" <?php if($view->civil_statuss == "Common-law"): ?> <?php echo e("selected"); ?> <?php endif; ?>>Common law</option>
  								<option value="Married" <?php if($view->civil_statuss == "Married"): ?> <?php echo e("selected"); ?> <?php endif; ?>>Married</option>
                  <option value="Sep-fact" <?php if($view->civil_statuss == "Unwed"): ?> <?php echo e("selected"); ?> <?php endif; ?>>Unwed</option>
                  <option value="Sep-fact" <?php if($view->civil_statuss == "Sep-fact"): ?> <?php echo e("selected"); ?> <?php endif; ?>>Separated - infact</option>
  								<option value="Sep-legal" <?php if($view->civil_statuss == "Sep-legal"): ?> <?php echo e("selected"); ?> <?php endif; ?>>Separated - legal</option>
  								<option value="Single" <?php if($view->civil_statuss == "Single"): ?> <?php echo e("selected"); ?> <?php endif; ?>>Single</option>
  								<option value="Widow" <?php if($view->civil_statuss == "Widow"): ?> <?php echo e("selected"); ?> <?php endif; ?>>Widow</option>
  								<option value="Divorce" <?php if($view->civil_statuss == "Divorce"): ?> <?php echo e("selected"); ?> <?php endif; ?>>Divorce</option>
  							</select>
  						</td>
  					</tr>
  					<tr>
  						<td colspan="2" style="padding: 3px!important;">PERMANET ADDRESSS: <br><br><?php echo e($view->address); ?></td>
  						<td colspan="2" style="padding: 3px!important;">
  							TEMPORARY ADDRESS: <br><br>
  							<input type="text" name="temp_address" id="address" class="form-control address" placeholder="Enter Address" value="<?php echo e($view->temp_address); ?>">
  						</td>
  												<td style="padding: 3px!important;text-align:center">DATE/PLACE OF BIRTH: <br><?php echo e($view->birthday); ?><br>
  						<input type="text" name="pob" id="placeofBirth" data-toggle="modal" data-target="#birthplace" class="form-control paddress" placeholder="Enter Address" value="<?php echo e($view->pob); ?>">
  						</td>
  					</tr>
  					<tr>
  						<td colspan="2">
  							<div class="col-sm-6" style="padding: 0px;">
  								&nbsp;KIND OF LIVING ARRANGEMENT: &nbsp;
  							</div>
  							<div class="col-sm-6" style="padding: 0px;">
  								<select class="form-control" name="living_arrangement" id="livingArrangement">
  									<option value="" <?php if($view->living_arrangement == ""): ?> <?php echo e("selected"); ?> <?php endif; ?>>-- choose --</option>
  									<option value="O" <?php if($view->living_arrangement == "O"): ?> <?php echo e("selected"); ?> <?php endif; ?>>OWNED</option>
  									<option value="R" <?php if($view->living_arrangement == "R"): ?> <?php echo e("selected"); ?> <?php endif; ?>>RENTED</option>
  									<option value="S" <?php if($view->living_arrangement == "S"): ?> <?php echo e("selected"); ?> <?php endif; ?>>SHARED</option>
  									<option value="I" <?php if($view->living_arrangement == "I"): ?> <?php echo e("selected"); ?> <?php endif; ?>>INSTITUTION</option>
  									<option value="H" <?php if($view->living_arrangement == "H"): ?> <?php echo e("selected"); ?> <?php endif; ?>>HOMELESS</option>
  								</select>
  							</div>
  						</td>
  						<td colspan="3"></td>
  					</tr>
  					<tr>
  						<td colspan="2"><input type="text" name="education" placeholder="EDUCATIONAL ATTAINMENT: *" class="form-control required" id="P_educational_atm" required value="<?php echo e($view->education); ?>"></td>
  						<td rowspan="2">EMPLOYER: <br><input type="text" name="employer" class="form-control" id="employeer" value="<?php echo e($view->employer); ?>"></td>
  						<td rowspan="2">INCOME: <br><input type="text" name="income" class="form-control" id="income" value="<?php echo e($view->income); ?>"></td>
  						<td rowspan="2">PER CAPITA INCOME <br><input type="text" name="capita_income" class="form-control" id="per_cap_income" value="<?php echo e($view->capita_income); ?>"></td>
  					</tr>
  					<tr>
  						<td colspan="2"><input type="text" name="occupation" placeholder="OCCUPATION: *" class="form-control required" id="p_occupation" required value="<?php echo e($view->occupation); ?>"></td>
  					</tr>
  					<tr align="center">
  						<td>
  							<div class="col-sm-5" style="padding: 0px">
  								PHILHEALTH: &nbsp;
  							</div>
  							<div class="col-sm-7" style="padding: 0px;">
  								<select class="form-control" name="philhealth" id="philhealth">
  									<option value="" <?php if($view->philhealth == ""): ?> <?php echo e("selected"); ?> <?php endif; ?>>-- choose --</option>
  									<option value="M" <?php if($view->philhealth == "M"): ?> <?php echo e("selected"); ?> <?php endif; ?>>MEMBER</option>
  									<option value="D" <?php if($view->philhealth == "D"): ?> <?php echo e("selected"); ?> <?php endif; ?>>DEPENDENT</option>
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

  							    <option value="<?php echo e($view->membership); ?>"><?php echo e($view->membership); ?></option>

  							</select>
  						</td>
  						<td>
  							<select class="form-control" name="category" style="text-align: center;" id="patient_type" required>
  								<option value="" <?php if($view->category == ""): ?> <?php echo e("selected"); ?> <?php endif; ?>>-- choose --</option>
  								<option value="O" <?php if($view->category == "O"): ?> <?php echo e("selected"); ?> <?php endif; ?>>OLD PATIENT</option>
  								<option value="N" <?php if($view->category == "N"): ?> <?php echo e("selected"); ?> <?php endif; ?>>NEW PATIENT</option>
  								<option value="C" <?php if($view->category == "C"): ?> <?php echo e("selected"); ?> <?php endif; ?>>CASES FORWARD</option>
  							</select>
  						</td>
  						<td>
  							<select class="form-control" name="fourpis" style="text-align: center;" id="4ps" required>
  								<option value="" <?php if($view->fourpis == ""): ?> <?php echo e("selected"); ?> <?php endif; ?>>-- choose --</option>
  								<option value="N" <?php if($view->fourpis == "N"): ?> <?php echo e("selected"); ?> <?php endif; ?>>NO</option>
  								<option value="Y" <?php if($view->fourpis == "Y"): ?> <?php echo e("selected"); ?> <?php endif; ?>>YES</option>
  							</select>
  						</td>
  						<td  colspan="2">
  							<select class="form-control" name="mss_id" id="classification" style="text-align: center;" required>
  									<option value="">-- choose --</option>
                    <?php $__currentLoopData = $mss; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <?php if($view->mss_id == $row->id): ?>
                    <option value="<?php echo e($row->id); ?>" <?php echo e("selected"); ?>><?php echo e($row->label.'-'.$row->description); ?></option>
                      <?php else: ?>
                     <option value="<?php echo e($row->id); ?>"><?php echo e($row->label.'-'.$row->description); ?></option>
                      <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                    <option value="<?php echo e($view->sectorial); ?>"><?php echo e($view->sectorial); ?></option>
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
            <?php $__currentLoopData = $family; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td hidden><input type="" name="id[]" value="<?php echo e($list->id); ?>"></td>
                        <td><input type="text" name="name[]" class="form-control" id="F_name" value="<?php echo e($list->name); ?>"></td>
                        <td><input type="text" name="age[]" class="form-control" id="F_age[]" style="text-align: center;" value="<?php echo e($list->age); ?>"></td>
                        <td>
                          <select class="form-control" style="text-align: center;" name="status[]" id="F_cstatus[]">
                            <option value="" <?php if($list->status == ""): ?> <?php echo e("selected"); ?> <?php endif; ?>></option>
                            <option value="child" <?php if($list->status == "child"): ?> <?php echo e("selected"); ?> <?php endif; ?>>Child</option>
                            <option value="minor" <?php if($list->status == "minor"): ?> <?php echo e("selected"); ?> <?php endif; ?>>Minor</option>
                            <option value="Common-law" <?php if($list->status == "Common-law"): ?> <?php echo e("selected"); ?> <?php endif; ?>>Common law</option>
                            <option value="Married" <?php if($list->status == "Married"): ?> <?php echo e("selected"); ?> <?php endif; ?>>Married</option>
                            <option value="Sep-fact" <?php if($list->status == "Sep-fact"): ?> <?php echo e("selected"); ?> <?php endif; ?>>Separated - infact</option>
                            <option value="Sep-legal" <?php if($list->status == "Sep-legal"): ?> <?php echo e("selected"); ?> <?php endif; ?>>Separated - legal</option>
                            <option value="Single" <?php if($list->status == "Single"): ?> <?php echo e("selected"); ?> <?php endif; ?>>Single</option>
                            <option value="Widow" <?php if($list->status == "Widow"): ?> <?php echo e("selected"); ?> <?php endif; ?>>Widow</option>
                            <option value="Divorce" <?php if($list->status == "Divorce"): ?> <?php echo e("selected"); ?> <?php endif; ?>>Divorce</option>
                          </select>
                        </td>
                        <td><input type="text" name="relationship[]" class="form-control" id="F_rel2patient[]" value="<?php echo e($list->relationship); ?>"></td>
                        <td><input type="text" name="feducation[]" class="form-control" id="F_edatnmnt[]" value="<?php echo e($list->feducation); ?>"></td>
                        <td><input type="text" name="foccupation[]" class="form-control" id="F_occupationn[]" value="<?php echo e($list->foccupation); ?>"></td>
                        <td><input type="text" name="fincome[]" class="form-control" id="F_Mincome[]" value="<?php echo e($list->fincome); ?>"></td>
                    </tr>
            <?php $count++; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php for($i = $count; $i<=8;$i++): ?>
  					<tr>
              <td hidden><input type="" name="id[]" value=""></td>
  						<td><input type="text" name="name[]" class="form-control" placeholder="<?php echo e($i); ?>" id="F_name"></td>
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
            <?php endfor; ?>

  					<tr>
  						<td colspan="3"><input type="text" name="source_income" class="form-control" placeholder="OTHER SOURCES OF INCOME" id="souces_of_income" value="<?php echo e($view->source_income); ?>" ></td>
  						<td colspan="4"><input type="text" name="household" class="form-control required" placeholder="HOUSEHOLD SIZE: *" id="household_size" required value="<?php echo e($view->household); ?>"></td>
  					</tr>
  					<tr>
  						<td colspan="3"><input type="text" name="monthly_expenses" class="form-control" placeholder="MONHTLY EXPENSES" id="monthly_expenses" value="<?php echo e($view->monthly_expenses); ?>"></td>
  						<td colspan="4"><input type="text" name="monthly_expenditures" class="form-control" placeholder="TOTAL MONTHLY EXPENDITURES " id="monthl_expenditures" value="<?php echo e($view->monthly_expenditures); ?>" ></td>
  					</tr>
  					<tr>
  						<td>
  							<div class="col-sm-7" style="padding: 0px;">
  								<select class="form-control" name="houselot" id="house_lot">
                    <?php $house = explode('-',trim($view->houselot));?>
  									<option value="" <?php if($house[0] == ""): ?> <?php echo e("selected"); ?> <?php endif; ?>>-- HOUSE AND LOT --</option>
  									<option value="owned" <?php if($house[0] == "owned"): ?> <?php echo e("selected"); ?> <?php endif; ?>>OWNED</option>
  									<option value="rented" <?php if($house[0] == "rented"): ?> <?php echo e("selected"); ?> <?php endif; ?>>RENTED</option>
  									<option value="free" <?php if($house[0] == "free"): ?> <?php echo e("selected"); ?> <?php endif; ?>>FREE</option>
  								</select>
  							</div>
  							<div class="col-sm-5" style="padding: 0px;">
  								<input type="text" name="H_php" class="form-control" placeholder="Php" id="H_php" <?php if(isset($house[1])): ?> value="<?php echo e($house[1]); ?>" <?php endif; ?>>
  							</div>
  						</td>
  						<td colspan="2">
  							<div class="col-sm-8" style="padding: 0px;">
  								<select class="form-control" name="light" id="light_source">
                    <?php $light = explode('-',trim($view->light));?>
  									<option value="" <?php if($light[0] == ""): ?> <?php echo e("selected"); ?> <?php endif; ?>>-- LIGHT SOURCE --</option>
  									<option value="candle" <?php if($light[0] == "candle"): ?> <?php echo e("selected"); ?> <?php endif; ?>>CANDLE</option>
  									<option value="electric" <?php if($light[0] == "electric"): ?> <?php echo e("selected"); ?> <?php endif; ?>>ELECTRIC</option>
  									<option value="kerosene" <?php if($light[0] == "kerosene"): ?> <?php echo e("selected"); ?> <?php endif; ?>>KEROSENE</option>
  								</select>
  							</div>
  							<div class="col-sm-4" style="padding: 0px;">
  								<input type="text" name="L_php" class="form-control" placeholder="Php" id="L_php" <?php if(isset($light[1])): ?> value="<?php echo e($light[1]); ?>" <?php endif; ?>>
  							</div>
  						</td>
  						<td colspan="2">
  							<div class="col-sm-8" style="padding: 0px;">
  								<select class="form-control" name="water" id="water_source">
                    <?php $water = explode('-',trim($view->water));?>
  									<option value="" <?php if($water[0] == ""): ?> <?php echo e("selected"); ?> <?php endif; ?>>-- WATER SOURCE --</option>
  									<option value="water_distric" <?php if($water[0] == "water_distric"): ?> <?php echo e("selected"); ?> <?php endif; ?>>WATER DISTRICT</option>
  									<option value="public" <?php if($water[0] == "public"): ?> <?php echo e("selected"); ?> <?php endif; ?>>PUBLIC</option>
  									<option value="owned" <?php if($water[0] == "owned"): ?> <?php echo e("selecte"); ?> <?php endif; ?>>OWNED</option>
  									<option value="deep_well" <?php if($water[0] == "deep_well"): ?> <?php echo e("selected"); ?> <?php endif; ?>>DEEP WELL</option>
  									<option value="pump" <?php if($water[0] == "pump"): ?> <?php echo e("selected"); ?> <?php endif; ?>>PUMP</option>
  								</select>
  							</div>
  							<div class="col-sm-4" style="padding: 0px;">
  								<input type="text" name="W_php" class="form-control" placeholder="Php" id="W_php"<?php if(isset($water[1])): ?>  value="<?php echo e($water[1]); ?>" <?php endif; ?>>
  							</div>
  						</td>
  						<td colspan="2">
  							<div class="col-sm-7" style="padding: 0px;">
  								<select class="form-control" name="fuel" id="fuel_source">
                     <?php $fuel = explode('-',trim($view->fuel));?>
  									<option value="" <?php if($fuel[0] == ""): ?> <?php echo e("selected"); ?> <?php endif; ?>>-- FUEL SOURCE --</option>
  									<option value="gas" <?php if($fuel[0] == "gas"): ?> <?php echo e("selected"); ?> <?php endif; ?>>GAS</option>
  									<option value="charcoal" <?php if($fuel[0] == "charcoal"): ?> <?php echo e("selected"); ?> <?php endif; ?>>CHARCOAL</option>
  									<option value="firewood" <?php if($fuel[0] == "firewood"): ?> <?php echo e("selected"); ?> <?php endif; ?>>FIREWOOD</option>
  								</select>
  							</div>
  							<div class="col-sm-5" style="padding: 0px;">
  								<input type="text" name="F_php" class="form-control" placeholder="Php" id="F_php" <?php if(isset($fuel[1])): ?> value="<?php echo e($fuel[1]); ?>" <?php endif; ?>>
  							</div>
  						</td>
  					</tr>
  					<tr>
  						<td><input type="text" name="food" class="form-control" placeholder="FOOD: Php" id="food_php" value="<?php echo e($view->food); ?>"></td>
  						<td colspan="2"><input type="text" name="educationphp" class="form-control" placeholder="EDUCATIO: Php" id="education_php" value="<?php echo e($view->educationphp); ?>"></td>
  						<td colspan="2"><input type="text" name="clothing" class="form-control" placeholder="CLOTHING: Php" id="clothing_php" value="<?php echo e($view->clothing); ?>"></td>
  						<td colspan="2"><input type="text" name="transportation" class="form-control" placeholder="TRANSPORATION: Php" id="transportation_php" value="<?php echo e($view->transportation); ?>"></td>
  					</tr>
  					<tr>
  						<td><input type="text" name="house_help" class="form-control" placeholder="HOUSE HELP: Php" id="house_help_php" value="<?php echo e($view->house_help); ?>"></td>
  						<td colspan="2"><input type="text" name="expinditures" class="form-control" placeholder="MEDICAL EXPENDITURES: Php" id="med_exp_php" value="<?php echo e($view->expinditures); ?>"></td>
  						<td colspan="2"><input type="text" name="insurance" class="form-control" placeholder="INSURANCE PREMIUM: Php" id="ins_prem_php" value="<?php echo e($view->insurance); ?>"></td>
  						<td colspan="2"><input type="text" name="other_expenses" class="form-control" placeholder="OTHERS:" id="others_php" value="<?php echo e($view->other_expenses); ?>"></td>
  					</tr>
  					<tr>
  						<td colspan="3"><input type="text" name="internet" class="form-control" placeholder="INTERNET CONNECTION: Php" id="internet_php" value="<?php echo e($view->internet); ?>"></td>
  						<td colspan="4"><input type="text" name="cable" class="form-control" placeholder="CABLE: Php" id="cable_php" value="<?php echo e($view->cable); ?>"></td>
  					</tr>
  					<tr>
  						<th colspan="7">II. MEDICAL RECORD</th>
  					</tr>
  					<tr>
  						<td>
  							<textarea name="medical"  class="form-control" id="medical_data" placeholder="MEDICAL DATA:" ><?php echo e($view->medical); ?></textarea>
  						</td>
  						<td colspan="3">
  							<textarea name="admitting" class="form-control" id="admitting_diagnosis" placeholder="ADMITTING DIAGNOSIS:" ><?php echo e($view->admitting); ?></textarea>
  						</td>
  						<td colspan="3">
  							<textarea name="final" class="form-control" id="final_diagnosis"  placeholder="FINAL DIAGNOSIS:" ><?php echo e($view->final); ?></textarea
  						></td>
  					</tr>
  					<tr>
  						<td colspan="7">
  							<input type="text" name="duration" class="form-control required" placeholder="DURATION OF PROBLEM/ SYMPTOMS: *" id="duration_symptoms" required value="<?php echo e($view->duration); ?>">
  						</td>
  					</tr>
  					<tr>
  						<td colspan="7">
  							<input type="text" name="previus" class="form-control" placeholder="PREVIOUS TREATMENT DURATION:" id="previous_treatment" value="<?php echo e($view->previus); ?>">
  						</td>
  					</tr>
  					<tr>
  						<td colspan="7">
  							<input type="text" name="present" class="form-control" placeholder="PRESENT TREATMENT PLAN:" id="treatment_plan" value="<?php echo e($view->present); ?>">
  						</td>
  					</tr><tr>
  						<td colspan="7">
  							<input type="text" name="health" class="form-control" placeholder="HEALTH ACCESSIBILITY PROBLEM:" id="health_accessibilty" value="<?php echo e($view->health); ?>">
  						</td>
  					</tr>
  					<tr>
  						<td colspan="3">
  							<input type="text" name="findings" class="form-control" placeholder="ASSESSMENT FINDINGS:" id="assesment_findings" value="<?php echo e($view->findings); ?>">
  						</td>
  						<td colspan="4">
  							<input type="text" name="interventions" class="form-control" placeholder="RECOMMENDED INTERVENTIONS:" id="recommended_intervention" value="<?php echo e($view->interventions); ?>">
  						</td>
  					</tr>
  					<tr>
  						<td colspan="3">
  							<input type="text" name="admision" class="form-control" placeholder="PRE-ADMISSION PLANNING:" id="pre_admission" value="<?php echo e($view->admision); ?>">
  						</td>
  						<td colspan="4">
  							<input type="text" name="planning" class="form-control" placeholder="DISCHARGE PLANNING:" id="discharge_planning" value="<?php echo e($view->planning); ?>">
  						</td>
  					</tr>
  					<tr>
  						<td colspan="7"><input type="text" name="counseling" class="form-control" placeholder="COUNSELING:" id="counseling" value="<?php echo e($view->counseling); ?>"></td>
  					</tr>

  				</table>
          <div class="col-sm-3 n nameofinterviewed" style="padding: 0px;margin-bottom: 5px;margin-top: -15px;">
              <input type="text" name="interviewed" class="form-control" placeholder="Name of interviewee" value="<?php echo e($view->interviewed); ?>" style="height: 33px;">
          </div>
          <div class="col-sm-3 n nameofinterviewed" style="padding: 0px;margin-bottom: 5px;margin-top: -15px;">
              <input type="text" name="relpatient" class="form-control" placeholder="Relationship to patient" value="<?php echo e($view->relpatient); ?>" style="height: 33px;">
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

  <?php $__env->stopSection(); ?>
  <?php $__env->startSection('pagescript'); ?>
    <script src="<?php echo e(asset('public/plugins/js/jquery-ui.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/mss/classification.js')); ?>"></script>

  <?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>
