<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPD | Logs
    <?php $__env->endSlot(); ?>

<?php $__env->startSection('pagestyle'); ?>
    <link href="<?php echo e(asset('public/plugins/css/dataTables.bootstrap.min.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/plugins/css/jquery-ui.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/receptions/status.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/doctors/patientlist.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/receptions/designation.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/requisition/medicines.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>


<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('receptions.navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>
    <br>
    <div class="container-fluid" id="overviewWrapper">

        <div class="container">
            
            <?php echo $__env->make('doctors.medicalRecords', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php echo $__env->make('doctors.ajaxConsultationList', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php echo $__env->make('doctors.ajaxRequisitionList', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php echo $__env->make('doctors.ajaxRefferals', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php echo $__env->make('doctors.ajaxFollowup', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php echo $__env->make('doctors.requisition.medsWatch', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php echo $__env->make('doctors.records.radiology', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <?php
                $chrgingClinics = array(3,32,10,48,22,21,8);
                $noDoctorsClinic = array(10,48,22,21);
            ?>

            <div class="">

                <div class="col-md-12 patientsWrapper" style="border-left: none">


                    <?php echo $__env->make('receptions.logs.logsForm', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


                    <hr>



                    <?php if($patients): ?>

                    <div class="patientsOverview">
                        <table class="table" id="patientsTable">


                            <?php echo $__env->make('receptions.logs.thead', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                            <tbody>

                                <?php

                                    /*-- For assignation status --*/
                                        $fin = 0;
                                        $can = 0;
                                        $pau = 0;
                                        $unassgned = 0;
                                        $pen = 0;
                                        $serv = 0;

                                    /*-- For queue status --*/
                                        $queueCanceled = 0;
                                        $queuePending = 0;
                                        $queueDone = 0;
                                        $queueFinished = 0;
                                ?>
                                <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $noDoctorsClinic = array(10,48,22,21);
                                        if (!in_array(Auth::user()->clinic, $noDoctorsClinic)){

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
                                            /*$asgn = 'disabled onclick="return false"';*/
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
                                        }else{
                                            switch ($patient->queue_status){
                                                case 'P':
                                                    $queuePending++;
                                                    $status = 'pending';
                                                    break;
                                                case 'C':
                                                    $queueCanceled++;
                                                    $status = 'cancel';
                                                    break;
                                                case 'F':
                                                    $queueDone++;
                                                    $status = 'finished';
                                                    break;
                                                default:
                                                    $queueFinished++;
                                                    $status = 'serving';
                                                    break;
                                            }
                                        }

                                    ?>

                                    <tr>

                                        <?php echo $__env->make('receptions.logs.info', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                                        <?php
                                            if($patient->ff + $patient->rf > 0){
                                                $assignedDoctor = App\Refferal::countAllNotifications($patient->id);
                                            }else{
                                                $assignedDoctor = array();
                                            }
                                        ?>


                                        <?php if(in_array(Auth::user()->clinic, $noDoctorsClinic)): ?>
                                            <?php echo $__env->make('receptions.logs.done', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                        <?php endif; ?>

                                        <?php echo $__env->make('receptions.logs.records', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


                                    


                                        <?php if(in_array(Auth::user()->clinic, $chrgingClinics)): ?>
                                                <?php
                                                    $charging = App\Ancillaryrequist::otherCharging($patient->id);
                                                ?>

                                                <?php echo $__env->make('receptions.overview.charging', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                        <?php endif; ?>



                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>

                            <?php if(count($patients) > 0): ?>
                                <tfoot>
                                <div class="text-center">
                                    <?php echo $__env->make('receptions.logs.status', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                </div>
                                <hr>
                                </tfoot>
                            <?php endif; ?>

                        </table>




                    </div>


                    <?php else: ?>

                        <?php echo $__env->make('receptions.logs.noResult', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                    <?php endif; ?>






                </div>
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
    <script src="<?php echo e(asset('public/plugins/js/jquery-ui.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/receptions/overview.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/doctors/ajaxRecords.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/receptions/consultation.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/results/master.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/results/medsWatch.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/results/ultrasound.js')); ?>"></script>
    <script>
        $(document).ready(function() {
            $('#patientsTable').dataTable();
           
        });
    </script>
    <script>
        $( function() {
            $( ".datepicker" ).datepicker({
                dateFormat: 'yy-mm-dd'
            });
        });
    </script>

<?php $__env->stopSection(); ?>



<?php echo $__env->renderComponent(); ?>
