<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPD | Patient Information
    <?php $__env->endSlot(); ?>

<?php $__env->startSection('pagestyle'); ?>
    <link href="<?php echo e(asset('public/css/receptions/patient_info.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>



<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('receptions.navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>

    <div class="container-fluid">
        <div class="container">




            <div class="row notificationsWrapper">


            <?php if(count($refferals) > 0): ?>
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <p class="text-danger text-center"><strong>This patient has a pending &nbsp; <b style="color: red;font-size: 25px"> Referral </b> &nbsp; to this clinic.</strong></p>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
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
                    </div>

                </div>
            <?php endif; ?>



            <?php if(count($followups) > 0): ?>
            <div class="col-md-12">
                
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <p class="text-danger text-center"><strong>This patient has a pending &nbsp; <b style="color: red;font-size: 25px"> Followup </b> &nbsp; schedule to this clinic.</strong></p>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
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
                                        <td><?php echo ($followup->reason)? $followup->reason : 'N/A'; ?></td>
                                        <td><?php echo ($followup->status == 'P')? '<span class="text-danger">Pending</span>' : '<span class="text-success">Finished</span>'; ?></td>
                                        <td><?php echo e(Carbon::parse($followup->followupdate)->toFormattedDateString()); ?></td>
                                        
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            </div>









            <div class="row">
                
            
            <div class="col-md-8">
                <h2 class="text-center">PATIENT INFORMATION</h2>
                <br>
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table patientInfo">
                            <tbody>
                            <tr>
                                <td>HOSPITAL NO:</td>
                                <td><?php echo e($patient->hospital_no); ?></td>
                            </tr>
                            <tr>
                                <td>BARCODE:</td>
                                <td><?php echo e($patient->barcode); ?></td>
                            </tr>
                            <tr>
                                <td>NAME:</td>
                                <td><?php echo e($patient->last_name.', '.$patient->first_name.' '.$patient->suffix.' '.$patient->middle_name); ?></td>
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
                                <td><?php echo e(($patient->label)? $patient->label.' '.($patient->discount * 100).'%' : 'Unclassified'); ?></td>
                            </tr>
                            <tr>
                                <td>DATE REGISTERED:</td>
                                <td><?php echo e(Carbon::parse($patient->created_at)->format('jS \o\f F, Y')); ?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <h2 class="text-center">VITAL SIGNS</h2>
                <br>
                <table class="table vitalSigns">

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
                                <th class="text-right" colspan="2">
                                    <?php echo e('Date examined : '. Carbon::parse($vital_signs[0]->created_at)->toDateTimeString()); ?>

                                </th>
                            <?php else: ?>
                                <th class="text-right" colspan="2">
                                    <span class='text-danger'>Todays Vital Signs is Unavailable!</span>
                                    <br>
                                    Click this to insert vital signs
                                    <a href="<?php echo e(url('vitalSigns/'.$patient->id)); ?>" class="btn btn-danger btn-circle">
                                        <i class="fa fa-heartbeat"></i>
                                    </a>
                                </th>
                            <?php endif; ?>
                        </tr>
                    </tfoot>
                </table>
            </div>

        </div>

        </div>
    </div>

<?php $__env->stopSection(); ?>





<?php $__env->startSection('footer'); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('pagescript'); ?>
    <?php echo $__env->make('message.toaster', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>
