<?php 

use App\MODEL\Admin\GeographicCensus;

?> 

<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPDRMS | REPORT-Geographic
    <?php $__env->endSlot(); ?>

<?php $__env->startSection('pagestyle'); ?>
    <link href="<?php echo e(asset('public/plugins/css/jquery-ui.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/mss/report.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>



<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('admin.navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>

    <div class="container-fluid">
        <div class="container">
        	<form class="form-inline" method="GET">
                <div class="form-group">
                    <label>CLINIC</label>
                    <select class="form-control" name="clinic_id">
                        <option value="" hidden>--</option>
                        <?php $__currentLoopData = $clinics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $clinic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($clinic->id); ?>"><?php echo e($clinic->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
        		<div class="form-group">
        			<label>FROM <small><i>(date started)</i></small></label>
        			<input type="date" name="from" class="form-control" value="<?php echo e((isset($request->from) || $request->from)?Carbon::parse($request->from)->format('Y-m-d'):''); ?>">
        		</div>
        		<div class="form-group">
        			<label>TO <small><i>(date end)</i></small></label>
        			<input type="date" name="to" class="form-control" value="<?php echo e((isset($request->to) || $request->to)?Carbon::parse($request->to)->format('Y-m-d'):''); ?>">
        		</div>
        		<button type="submit" class="btn btn-success btn-sm"><span class="fa fa-cog"></span> Generate</button>
        	</form>
        	<div class="table-responsive">
        		<table class="table table-bordered" id="geographic-table">
        			<thead>
        				<tr>
        					<th rowspan="3">PLACE</th>
        					<th colspan="2">MALE</th>
        					<th colspan="2">FEMALE</th>
        					<th colspan="8">SENIOR CITIZEN</th>
        					<th rowspan="4">TOTAL</th>
        				</tr>
        				<tr>
        					<th rowspan="3">NEW</th>
        					<th rowspan="3">REVISIT</th>
        					<th rowspan="3">NEW</th>
        					<th rowspan="3">REVISIT</th>
        					<th colspan="4">60-65</th>
        					<th colspan="4">66 and greater</th>
        				</tr>
        				<tr>
        					<th colspan="2">M</th>
        					<th colspan="2">F</th>
        					<th colspan="2">M</th>
        					<th colspan="2">F</th>
        				</tr>
                        <tr>
                            <th>NEW</th>
                            <th>NEW</th>
                            <th>REVISIT</th>
                            <th>NEW</th>
                            <th>REVISIT</th>
                            <th>NEW</th>
                            <th>REVISIT</th>
                            <th>NEW</th>
                            <th>REVISIT</th>
                        </tr>
        			</thead>
        				<?php 
        				$district = 'TACLOBAN,1ST,2ND,3RD,4TH,5TH,SO. LEYTE,BILIRAN,WESTERN SAMAR,1ST,2ND,EASTERN SAMAR,1ST,2ND,NORTHERN SAMAR,1ST,2ND, OUTSIDE R08';/*,SO. LEYTE,BILIRAN,OUTSIDE R08*/
        				$content = '1004-
                                967,969,970,973,975,977,978,983,985,996,1000,1001,1005,1006-
        				      976,987,989,993,998,1003,1007-
        				      974,988,999,1002,1008-
        				      968,982,986,991,994,997,995-
        				      966,971,972,979,980,981,984,990,992-
        				      1059,1060,1061,1062,1063,1064,1065,1066,1067,1068,1069,1070,1071,1072,1073,1074,1075,1076,1077-
        				      1078,1079,1080,1081,1082,1083,1084,1085-
        				      122333434-
        				      1033,1035,1039,1043,1057,1054,1048,1050,1056,1052,1058-
        				      1034,1042,1036,1037,1038,1041,1045,1055,1044,1046,1051,1053,1040,1047,1049-
        				      122333434-
        				      943,946,947,948,953,956,959,962,963,964,965-
        				      944,945,949,950,951,952,954,955,957,958,960,961-
        				      122333434-
        				      1009,1010,1011,1012,1013,1019,1021,1024,1025,1026,1027,1029,1031,1032-
        				      1014,1015,1016,1017,1018,1020,1022,1023,1028,1030-
        				      08';
        				$districts = explode(',', $district);
        				$contents = explode('-', $content);
        				?>

        			<tbody>
        				<?php
        				$totalmalenew = 0;
        				?>
        				<?php $__currentLoopData = $districts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $district): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        				<tr>
        					<td><?php echo e($districts[$index]); ?></td>
        					<?php

                                $totals = 0;

                                $male = 0;
                                $revisitmale = 0;

                                $revisitfemale = 0;
                                $female = 0;

                                $revisitoldmale = 0;
                                $oldmale = 0;

                                $revisitoldfemale = 0;
                                $oldfemale = 0;

                                $revisitoldermale = 0;
                                $oldermale = 0;

                                $revisitolderfemale = 0;
                                $olderfemale = 0;


                                $male_patient_id = [];
                                $female_patient_id = [];

                                $old_male_patient_id = [];
                                $old_female_patient_id = [];

                                $older_male_patient_id = [];
                                $older_female_patient_id = [];

                                foreach($patients as $patient){
                                    if(in_array($patient->refcitymun_id, explode(',', $contents[$index]))){
                                        $totals++;
                                        if(Carbon::parse($patient->birthday)->age < 60){
                                            if($patient->sex == 'M'){
                                                $male++;
                                                if (!in_array($patient->patients_id, $male_patient_id)){
                                                    array_push($male_patient_id, $patient->patients_id);
                                                    $checkmale = GeographicCensus::checkifnewvisit($request, $patient->patients_id, Carbon::parse($patient->created_at)->format('Y-m-d'));
                                                    if ($checkmale) {
                                                        $revisitmale++;
                                                    }
                                                }else{
                                                    $revisitmale++;
                                                }
                                            }elseif($patient->sex == 'F'){
                                                $female++;
                                                if (!in_array($patient->patients_id, $female_patient_id)){
                                                    array_push($female_patient_id, $patient->patients_id);
                                                    $checkfemale = GeographicCensus::checkifnewvisit($request, $patient->patients_id, Carbon::parse($patient->created_at)->format('Y-m-d'));
                                                    if ($checkfemale) {
                                                        $revisitfemale++;
                                                    }
                                                }else{
                                                    $revisitfemale++;
                                                }
                                            }
                                        }elseif(Carbon::parse($patient->birthday)->age >= 60 && Carbon::parse($patient->birthday)->age <= 65){
                                            if($patient->sex == 'M'){
                                                $oldmale++;
                                                if (!in_array($patient->patients_id, $old_male_patient_id)){
                                                    array_push($old_male_patient_id, $patient->patients_id);
                                                    $checkoldmale = GeographicCensus::checkifnewvisit($request, $patient->patients_id, Carbon::parse($patient->created_at)->format('Y-m-d'));
                                                    if ($checkoldmale) {
                                                        $revisitoldmale++;
                                                    }
                                                }else{
                                                    $revisitoldmale++;
                                                }
                                            }elseif($patient->sex == 'F'){
                                                $oldfemale++;
                                                if (!in_array($patient->patients_id, $old_female_patient_id)){
                                                    array_push($old_female_patient_id, $patient->patients_id);
                                                    $checkoldfemale = GeographicCensus::checkifnewvisit($request, $patient->patients_id, Carbon::parse($patient->created_at)->format('Y-m-d'));
                                                    if ($checkoldfemale) {
                                                        $revisitoldfemale++;
                                                    }
                                                }else{
                                                    $revisitoldfemale++;
                                                }
                                            }
                                        }
                                        elseif(Carbon::parse($patient->birthday)->age > 65){
                                            if($patient->sex == 'M'){
                                                $oldermale++;
                                                if (!in_array($patient->patients_id, $older_male_patient_id)){
                                                    array_push($older_male_patient_id, $patient->patients_id);
                                                    $checkoldermale = GeographicCensus::checkifnewvisit($request, $patient->patients_id, Carbon::parse($patient->created_at)->format('Y-m-d'));
                                                    if ($checkoldermale) {
                                                        $revisitoldermale++;
                                                    }
                                                }else{
                                                    $revisitoldermale++;
                                                }
                                            }elseif($patient->sex == 'F'){
                                                $olderfemale++;
                                                if (!in_array($patient->patients_id, $older_female_patient_id)){
                                                    array_push($older_female_patient_id, $patient->patients_id);
                                                    $checkolderfemale = GeographicCensus::checkifnewvisit($request, $patient->patients_id, Carbon::parse($patient->created_at)->format('Y-m-d'));
                                                    if ($checkolderfemale) {
                                                        $revisitolderfemale++;
                                                    }
                                                }else{
                                                    $revisitolderfemale++;
                                                }
                                            }
                                        }
                                    }
                                }
                            ?>
        					<td class="text-center"><?php echo e(($male > 0)?($male-$revisitmale):''); ?></td>
        					<td class="text-center"><?php echo e(($revisitmale > 0)?$revisitmale:''); ?></td>

        					<td class="text-center"><?php echo e(($female > 0)?($female-$revisitfemale):''); ?></td>
                            <td class="text-center"><?php echo e(($revisitfemale > 0)?$revisitfemale:''); ?></td>
                            
                            <td class="text-center"><?php echo e(($oldmale > 0)?($oldmale - $revisitoldmale):''); ?></td>
        					<td class="text-center"><?php echo e(($revisitoldmale > 0)?$revisitoldmale:''); ?></td>

                            <td class="text-center"><?php echo e(($oldfemale > 0)?($oldfemale - $revisitoldfemale):''); ?></td>
        					<td class="text-center"><?php echo e(($revisitoldfemale > 0)?$revisitoldfemale:''); ?></td>

                            <td class="text-center"><?php echo e(($oldermale > 0)?($oldermale - $revisitoldermale):''); ?></td>
        					<td class="text-center"><?php echo e(($revisitoldermale > 0)?$revisitoldermale:''); ?></td>

                            <td class="text-center"><?php echo e(($olderfemale > 0)?($olderfemale - $revisitolderfemale):''); ?></td>
        					<td class="text-center"><?php echo e(($revisitolderfemale > 0)?$revisitolderfemale:''); ?></td>

        					<td class="text-center"><?php echo e(($totals > 0)?$totals:''); ?></td>
        				</tr>
        				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        			</tbody>
        			

        		</table>
        	</div>


        </div>
    </div>

<?php $__env->stopSection(); ?>





<?php $__env->startSection('footer'); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('pagescript'); ?>
    <?php echo $__env->make('message.toaster', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <script src="<?php echo e(asset('public/plugins/js/jquery-ui.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/receptions/reports.js')); ?>"></script>


    <?php if(Session::has('census') && Session::get('census') == 'monthly'): ?>
        <script>
            $(document).ready(function () {
               $('.monthlyBtn').click();
            });
        </script>
    <?php endif; ?>


<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>
