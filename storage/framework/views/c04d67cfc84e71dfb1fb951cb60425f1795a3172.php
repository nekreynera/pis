<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPD | Patient Information
    <?php $__env->endSlot(); ?>

<?php $__env->startSection('pagestyle'); ?>
    <link href="<?php echo e(asset('public/css/doctors/reset.css')); ?>" rel="stylesheet" />
    <?php if(Auth::user()->theme == 2): ?>
        <link href="<?php echo e(asset('public/css/doctors/darkstyle.css')); ?>" rel="stylesheet" />
    <?php else: ?>
        <link href="<?php echo e(asset('public/css/doctors/greenstyle.css')); ?>" rel="stylesheet" />
    <?php endif; ?>
    <link href="<?php echo e(asset('public/plugins/css/dataTables.bootstrap.min.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/doctors/patientinfo.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>



<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('doctors.navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('doctors.dashboard'); ?>
<?php $__env->startSection('main-content'); ?>


    <div class="content-wrapper" style="padding: 55px 10px 0px 10px;">
        <br>
        <div class="container-fluid">
            <div class="notificationsWrapper">
                <?php if(count($refferals) > 0): ?>
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th colspan="8"><strong>This patient has a pending <span style="color: red;font-size: 18px"> Refferal </span> to this clinic.</strong></th>
                            </tr>
                            <tr>
                                <th>PATIENT</th>
                                <th>FROM_CLINIC</th>
                                <th>REFFERED_BY</th>
                                <th>TO_CLINIC</th>
                                <th>REFFERED_TO</th>
                                <th>REASON</th>
                                <th>STATUS</th>
                                <th>DATE</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php $__currentLoopData = $refferals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $refferal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($refferal->name); ?></td>
                                    <td><?php echo e(($refferal->fromClinic)? $refferal->fromClinic : 'N/A'); ?></td>
                                    <td><?php echo e(($refferal->fromDoctor)? 'Dr. '.$refferal->fromDoctor : 'N/A'); ?></td>
                                    <td><?php echo e(($refferal->toClinic)? $refferal->toClinic : 'N/A'); ?></td>
                                    <td><?php echo e(($refferal->toDoctor)? $refferal->toDoctor : 'Unassigned'); ?></td>
                                    <td><?php echo e(($refferal->reason)? $refferal->reason : 'N/A'); ?></td>
                                    <td><?php echo ($refferal->status == 'P')? '<span class="text-danger">Pending</span>' : '<span class="text-success">Finished</span>'; ?></td>
                                    <td><?php echo e(Carbon::parse($refferal->created_at)->toFormattedDateString()); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </tbody>
                        </table>
                    </div>
                </div>
                <?php endif; ?>

                <?php if(count($followups) > 0): ?>
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr style="background-color: #ccc;">
                                    <th colspan="5"><strong>This patient has a <span style="color: red;font-size: 18px"> Followup </span> schedule to this clinic.</strong></th>
                                </tr>
                                <tr>
                                    <th>TO_DOCTOR</th>
                                    <th>CLINIC</th>
                                    <th>REASONS</th>
                                    <th>STATUS</th>
                                    <th>FF DATE</th>
                                    
                                </tr>
                                </thead>
                                <tbody>

                                <?php $__currentLoopData = $followups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $followup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e((!empty($followup->doctorsname))? $followup->doctorsname : 'N/A'); ?></td>
                                        <td><?php echo e($followup->name); ?></td>
                                        <td><?php echo e($followup->reason); ?></td>
                                        <td><?php echo ($followup->status == 'P')? '<span class="text-danger">Pending</span>' : '<span class="text-success">Finished</span>'; ?></td>
                                        <td><?php echo e(Carbon::parse($followup->followupdate)->toFormattedDateString()); ?></td>
                                        
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

                <div class="col-md-7 col-sm-7">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr style="background-color: #ccc!important;">
                                <th colspan="2">
                                    <h4 class="text-center">Patient Information</h4>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>PATIENT NAME:</td>
                                <td><h4 class="text-danger"><?php echo e($patient->last_name.', '.$patient->first_name.' '.$patient->suffix.' '.$patient->middle_name); ?></h4></td>
                            </tr>
                            <tr>
                                <td>HOSPITAL NO:</td>
                                <td><?php echo e($patient->hospital_no); ?></td>
                            </tr>
                            <tr>
                                <td>BARCODE:</td>
                                <td><?php echo e($patient->barcode); ?></td>
                            </tr>
                            <tr>
                                <td>BIRTHDAY:</td>
                                <td><?php echo e(Carbon::parse($patient->birthday)->format('F d, Y')); ?></td>
                            </tr>
                            <tr>
                                <td>AGE:</td>
                                <td>
                                    <?php echo e(App\Patient::age($patient->birthday)); ?>

                                </td>
                            </tr>
                            <tr>
                                <td>ADDRESS:</td>
                                <td><?php echo e($patient->address); ?></td>
                            </tr>
                            <tr>
                                <td>SEX:</td>
                                <td>
                                    <?php
                                        switch($patient->sex)
                                        {
                                            case 'M':
                                                echo 'Male';
                                                break;
                                            case 'F':
                                                echo 'Female';
                                                break;
                                        }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>CIVIL STATUS:</td>
                                <td><?php echo e($patient->civil_status); ?></td>
                            </tr>
                            <tr>
                                <td>MSS CLASSIFICATION</td>
                                <!-- <td><?php echo e(($patient->label)? $patient->label.' '.($patient->discount * 100).'%' : 'Unclassified'); ?></td> -->
                                <td>N/A</td>
                            </tr>
                            <tr>
                                <td>DATE REGISTERED:</td>
                                <td><?php echo e(Carbon::parse($patient->created_at)->format('jS \o\f F, Y')); ?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-md-5 col-sm-5">
                    <table class="table table-bordered vitalSigns">
                        <thead>
                        <tr style="background-color: #ccc;">
                            <th colspan="2">
                                <h4 class="text-center">Vital Signs</h4>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Blood Pressure:</td>
                            <td><?php echo e((isset($vital_signs[0]->blood_pressure))? $vital_signs[0]->blood_pressure : ''); ?></td>
                        </tr>
                        <tr>
                            <td>Pulse Rate:</td>
                            <td><?php echo e((isset($vital_signs[0]->pulse_rate))? $vital_signs[0]->pulse_rate : ''); ?></td>
                        </tr>
                        <tr>
                            <td>Respiration Rate:</td>
                            <td><?php echo e((isset($vital_signs[0]->respiration_rate))? $vital_signs[0]->respiration_rate : ''); ?></td>
                        </tr>
                        <tr>
                            <td>Body Temperature:</td>
                            <td><?php echo e((isset($vital_signs[0]->body_temperature))? $vital_signs[0]->body_temperature : ''); ?></td>
                        </tr>
                        <tr>
                            <td>Weight:</td>
                            <td><?php echo e((isset($vital_signs[0]->weight))? $vital_signs[0]->weight : ''); ?></td>
                        </tr>
                        <tr>
                            <td>Height:</td>
                            <td><?php echo e((isset($vital_signs[0]->height))? $vital_signs[0]->height : ''); ?></td>
                        </tr>
                        <tr>
                            <td>BMI(metric):</td>
                            <td>
                                <?php if(count($vital_signs) > 0): ?>
                                    <?php if($vital_signs[0]->weight && $vital_signs[0]->height): ?>
                                        <?php
                                            $w = $vital_signs[0]->weight;
                                            $h = $vital_signs[0]->height / 100;
                                            $th = $h * $h;
                                            $bmi = $w / $th;
                                        ?>
                                        <?php echo e(number_format($bmi, 3, '.', '')); ?> 
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <?php if(isset($vital_signs[0]->created_at)): ?>
                                <td class="text-right" colspan="2" style="background-color: #fff">
                                    <?php echo e('Date examined : '. Carbon::parse($vital_signs[0]->created_at)->format('jS \o\f F, Y')); ?>

                                </td>
                            <?php else: ?>
                                <td class="text-right" colspan="2" style="background-color: #fff">
                                    <span class='text-danger'>Todays Vital Signs is Unavailable!</span>
                                </td>
                            <?php endif; ?>
                        </tr>
                        </tfoot>
                    </table>
                </div>
        </div>
    </div> <!-- .content-wrapper -->




<?php $__env->stopSection(); ?>
<?php echo $__env->renderComponent(); ?>
<?php $__env->stopSection(); ?>





<?php $__env->startSection('footer'); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('pagescript'); ?>
    <?php echo $__env->make('message.toaster', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <script src="<?php echo e(asset('public/plugins/js/form.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/modernizr.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/jquery.menu-aim.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/doctors/main.js')); ?>"></script>


<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>
