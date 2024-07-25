<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPD | Consultation Logs
    <?php $__env->endSlot(); ?>

<?php $__env->startSection('pagestyle'); ?>
    <link href="<?php echo e(asset('public/plugins/css/jquery-ui.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/doctors/reset.css')); ?>" rel="stylesheet" />
    <?php if(Auth::user()->theme == 2): ?>
        <link href="<?php echo e(asset('public/css/doctors/darkstyle.css')); ?>" rel="stylesheet" />
    <?php else: ?>
        <link href="<?php echo e(asset('public/css/doctors/greenstyle.css')); ?>" rel="stylesheet" />
    <?php endif; ?>
    <link href="<?php echo e(asset('public/plugins/css/dataTables.bootstrap.min.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/receptions/designation.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/doctors/patientlist.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/receptions/status.css')); ?>" rel="stylesheet" />
    <style>
        #patientListWrapper{
            font-family: Raleway-Medium;
        }
    </style>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('doctors.navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('doctors.dashboard'); ?>
<?php $__env->startSection('main-content'); ?>


    <div class="content-wrapper" style="padding: 50px 0px">
        <br/>
        <div class="container-fluid" id="patientListWrapper">

            <?php echo $__env->make('doctors.medicalRecords', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php echo $__env->make('doctors.ajaxConsultationList', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php echo $__env->make('doctors.ajaxRequisitionList', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php echo $__env->make('doctors.ajaxRefferals', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php echo $__env->make('doctors.ajaxFollowup', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php echo $__env->make('doctors.records.consultation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php echo $__env->make('doctors.requisition.medsWatch', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


            

            <div class="col-md-12">



                <?php echo $__env->make('doctors.logs.searchLogs', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


                <?php if($patients): ?>
                <?php echo $__env->make('doctors.logs.status', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                <br>

                <div class="">
                    <table class="table" id="patientListTable">

                        <?php echo $__env->make('doctors.logs.thead', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                        <tbody>
                        
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
                                    switch ($patient->status){
                                        case 'P':
                                            $status =  'pending';
                                            $statusColor = 'text-warning';
                                            break;
                                            $pen++;
                                        case 'S':
                                            $status =  'serving';
                                            $statusColor = 'text-success';
                                            $serv++;
                                            break;
                                        case 'F':
                                            $status =  'finished';
                                            $statusColor = 'text-primary';
                                            $fin++;
                                            break;
                                        case 'C':
                                            $status =  'canceled';
                                            $statusColor = 'text-danger';
                                            $can++;
                                            break;
                                        case 'H':
                                            $status =  'paused';
                                            $statusColor = 'text-warning';
                                            $pau++;
                                            break;
                                        default:
                                            $status =  'unassigned';
                                            $statusColor = 'text-danger';
                                            $unassgned++;
                                            break;
                                    }

                                    $refferal = App\Refferal::countAllRefferals($patient->pid);
                                    $followups = App\Followup::countAllFollowup($patient->pid);
                                    $totalNotification = $refferal + $followups;

                                ?>

                                <?php echo $__env->make('doctors.logs.content', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        
                        </tbody>

                    </table>

                </div>


                <?php else: ?>

                    <?php echo $__env->make('doctors.logs.noResult', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                <?php endif; ?>


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
    <script src="<?php echo e(asset('public/plugins/js/jquery-ui.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/dataTables.bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/form.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/modernizr.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/jquery.menu-aim.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/jquery-ui.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/doctors/main.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/doctors/ajaxRecords.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/results/consultation.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/results/master.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/results/medsWatch.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/results/ultrasound.js')); ?>"></script>
    <script>
        $( function() {
            $( ".datepicker" ).datepicker({
                dateFormat: 'yy-mm-dd'
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#patientListTable').DataTable();
        });
    </script>

<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>
