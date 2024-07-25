<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPD | Patient Status
    <?php $__env->endSlot(); ?>

<?php $__env->startSection('pagestyle'); ?>
    <link href="<?php echo e(asset('public/plugins/css/dataTables.bootstrap.min.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/doctors/patientlist.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/receptions/designation.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/ancillary/charging.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>


<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('receptions.navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>

    <div class="container-fluid">


        <?php echo $__env->make('doctors.medicalRecords', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('doctors.ajaxConsultationList', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('doctors.ajaxRequisitionList', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('doctors.ajaxRefferals', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('doctors.ajaxFollowup', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('doctors.requisition.medsWatch', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('doctors.records.radiology', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('ancillary.chargingmodal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('ancillary.loader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('nurse.pedia.form_records', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        

        <?php
            $chrgingClinics = array(3,5,8,24,32,34,10,48,22,21,25);
            $noDoctorsClinic = array(48,22,21);
        ?>


        <div class="container">

            <?php echo $__env->make('doctors.medicalRecords', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php echo $__env->make('doctors.ajaxConsultationList', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php echo $__env->make('doctors.ajaxRequisitionList', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php echo $__env->make('doctors.ajaxRefferals', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php echo $__env->make('doctors.ajaxFollowup', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php echo $__env->make('doctors.requisition.medsWatch', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <h1 class="text-right">DR. <?php echo e($doctor->first_name.' '.$doctor->middle_name[0].'. '.$doctor->last_name); ?></h1>
            <hr>

            <?php if($status == 'P'): ?>
                <h3 class="text-left text-warning">PENDING PATIENTS... <i class="fa fa-feed"></i></h3>
            <?php elseif($status == 'C'): ?>
                <h3 class="text-left text-danger">NAWC PATIENTS <i class="fa fa-remove"></i></h3>
            <?php elseif($status == 'F'): ?>
                <h3 class="text-left text-primary">FINISHED PATIENTS <i class="fa fa-check"></i></h3>
            <?php elseif($status == 'H'): ?>
                <h3 class="text-left text-warning">PAUSED PATIENTS... <i class="fa fa-pause"></i></h3>
            <?php else: ?>
                <h3 class="text-left text-success">SERVING PATIENT <i class="fa fa-stethoscope"></i></h3>
            <?php endif; ?>

            <br>
            <div class="">
                <table class="table" id="pendingsTable">

                    <?php echo $__env->make('receptions.overview.thead', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                    <tbody class="loadPatients" charoff="<?php echo e(url()->current()); ?>">
                    <?php if(count($patients) > 0): ?>
                        <?php
                            $fin = 0;
                            $can = 0;
                            $pau = 0;
                            $unassgned = 0;
                            $pen = 0;
                            $serv = 0;
                        ?>
                        <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                            if($patient->status == 'P'){
                            $asgn = 'disabled onclick="return false"';
                            $reasgn = '';
                            $cancel = '';
                            $status = 'pending';
                            $pen++;
                            }
                            elseif($patient->status == 'S'){
                            $asgn = 'disabled onclick="return false"';
                            $reasgn = 'disabled onclick="return false"';
                            $cancel = 'disabled onclick="return false"';
                            $status = 'serving';
                            $serv++;
                            }
                            elseif($patient->status == 'F'){
                            $asgn = '';
                            $reasgn = 'disabled onclick="return false"';
                            $cancel = 'disabled onclick="return false"';
                            $status = 'finished';
                            $fin++;
                            }
                            elseif($patient->status == 'C'){
                            $asgn = '';
                            $reasgn = 'disabled onclick="return false"';
                            $cancel = 'disabled onclick="return false"';
                            $status = 'cancel';
                            $can++;
                            }
                            elseif($patient->status == 'H'){
                            $asgn = '';
                            $reasgn = 'disabled onclick="return false"';
                            $cancel = 'disabled onclick="return false"';
                            $status = 'paused';
                            $pau++;
                            }
                            else{
                            $asgn = '';
                            $reasgn = 'disabled onclick="return false"';
                            $cancel = '';
                            $status = 'unassigned';
                            $unassgned++;
                            }
                            ?>
                            <tr>

                                <?php echo $__env->make('receptions.overview.patient', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                                <?php echo $__env->make('receptions.overview.info', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


                                <?php
                                    if($patient->ff + $patient->rf > 0){
                                        $assignedDoctor = App\Refferal::countAllNotifications($patient->id);
                                    }else{
                                        $assignedDoctor = array();
                                    }
                                ?>


                                <?php if(in_array(Auth::user()->clinic, $chrgingClinics)): ?>
                                    <?php
                                    $charging = App\Ancillaryrequist::otherCharging($patient->id);
                                    ?>
                                <?php endif; ?>


                                <?php echo $__env->make('receptions.overview.records', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                                <?php echo $__env->make('receptions.overview.assign', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                                <?php echo $__env->make('receptions.overview.reassign', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


                                <?php echo $__env->make('receptions.overview.cancel', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                                <?php echo $__env->make('receptions.overview.charging', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>

                        <?php echo $__env->make('receptions.overview.noPatient', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                    <?php endif; ?>
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
    <script src="<?php echo e(asset('public/plugins/js/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/dataTables.bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/doctors/ajaxRecords.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/receptions/consultation.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/results/master.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/results/medsWatch.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/results/ultrasound.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/ancillary/charging.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/nurse/pedia/form_records.js')); ?>"></script>
    <script>
        $(document).ready(function() {
            $('#pendingsTable').dataTable();
        });
    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>
