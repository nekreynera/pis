<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPD | Patients
    <?php $__env->endSlot(); ?>

<?php $__env->startSection('pagestyle'); ?>
    <link href="<?php echo e(asset('public/css/doctors/reset.css')); ?>" rel="stylesheet" />
    <?php if(Auth::user()->theme == 2): ?>
        <link href="<?php echo e(asset('public/css/doctors/darkstyle.css')); ?>" rel="stylesheet" />
    <?php else: ?>
        <link href="<?php echo e(asset('public/css/doctors/greenstyle.css')); ?>" rel="stylesheet" />
    <?php endif; ?>
    <link href="<?php echo e(asset('public/plugins/css/dataTables.bootstrap.min.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/doctors/patientlist.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/receptions/designation.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/requisition/medicines.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/receptions/status.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/partials/slider.css')); ?>" rel="stylesheet" />

    
<?php $__env->stopSection(); ?>



<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('doctors.navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('doctors.dashboard'); ?>
        <?php $__env->startSection('main-content'); ?>


        <div class="content-wrapper" style="padding: 50px 0px" id="contentPatientList">
            <br/>
            <div class="container-fluid" id="patientListWrapper">



               



                <?php echo $__env->make('doctors.medicalRecords', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <?php echo $__env->make('doctors.ajaxConsultationList', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <?php echo $__env->make('doctors.ajaxRequisitionList', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <?php echo $__env->make('doctors.ajaxRefferals', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <?php echo $__env->make('doctors.ajaxFollowup', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <?php echo $__env->make('doctors.records.consultation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <?php echo $__env->make('doctors.requisition.medsWatch', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <?php echo $__env->make('doctors.records.radiology', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <?php echo $__env->make('partials.alert', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <?php echo $__env->make('doctors.laboratory_result', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>



                <?php echo $__env->make('nurse.pedia.form_records', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                <div class="col-md-12 row">

                    <br>

                    <?php echo $__env->make('doctors.patients.status', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>



                    

                    <br><br>

                    <?php if($patients && count($patients) > 0): ?>
                    <div class="">
                        <table class="table" id="patientListTable">
                            <thead>
                            <?php echo $__env->make('doctors.patients.thead', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                            </thead>
                            <tbody>

                                <?php
                                    $fin = 0;$can = 0;$pau = 0;$unassgned = 0;$pen = 0;$serv = 0;
                                ?>
                                <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        switch ($patient->status){
                                            case 'P':
                                                $status =  'pending';
                                                $statusColor = 'text-warning';
                                                $pen++;
                                                break;
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
                                                $status =  'nawc';
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

                                    <tr>

                                        <?php echo $__env->make('doctors.patients.patientName', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                        <?php echo $__env->make('doctors.patients.info', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                        <?php echo $__env->make('doctors.patients.records', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                        <?php echo $__env->make('doctors.patients.medical_certificate', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                        <?php echo $__env->make('doctors.patients.action', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                        <?php echo $__env->make('doctors.patients.event', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                        <?php echo $__env->make('doctors.patients.intern', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>

                        <?php echo $__env->make('doctors.patients.noResults', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

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
    <?php if(!$alert): ?>
    <script>
            $("#alertModal").modal({backdrop: "static"});
    </script>
    <?php else: ?>
        <?php if($request->alert): ?>
        <script>
            $("#alertModal").modal('hide');
        </script>
        <?php endif; ?>
    <?php endif; ?>
   
    <script src="<?php echo e(asset('public/plugins/js/form.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/modernizr.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/jquery.menu-aim.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/jquery-ui.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/doctors/main.js?v1.0.1')); ?>"></script>

    <script src="<?php echo e(asset('public/js/nurse/pedia/form_records.js')); ?>"></script>

    <script src="<?php echo e(asset('public/js/doctors/ajaxRecords.js?v1.0.1')); ?>"></script>
    <script src="<?php echo e(asset('public/js/results/consultation.js?v1.0.1')); ?>"></script>
    <script src="<?php echo e(asset('public/js/results/master.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/results/medsWatch.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/results/ultrasound.js?v1.0.9')); ?>"></script>
    <script src="<?php echo e(asset('public/js/results/radiologyQuickView.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/partials/slider.js')); ?>"></script>



    

<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>
