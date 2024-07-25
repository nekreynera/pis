<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPD | For Approvals
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
    <link href="<?php echo e(asset('public/css/requisition/medicines.css')); ?>" rel="stylesheet" />
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
                    <br>
                    <h3 class="text-center">Patients For Approval</h3>
                    <hr>
                    <div class="">
                        <table class="table" id="patientListTable">

                            <?php echo $__env->make('doctors.approvals.thead', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                            <tbody>
                            <?php if(count($approvals) > 0): ?>
                                <?php $__currentLoopData = $approvals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $approval): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>

                                        <?php echo $__env->make('doctors.approvals.patientName', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                                        <?php echo $__env->make('doctors.approvals.records', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                                        <?php echo $__env->make('doctors.approvals.status', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>

                                <?php echo $__env->make('doctors.approvals.notFound', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
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

    <script src="<?php echo e(asset('public/js/doctors/ajaxRecords.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/results/consultation.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/results/master.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/results/medsWatch.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/results/ultrasound.js')); ?>"></script>

<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>
