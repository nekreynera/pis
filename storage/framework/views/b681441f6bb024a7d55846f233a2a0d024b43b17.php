<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPD | Overview
    <?php $__env->endSlot(); ?>

<?php $__env->startSection('pagestyle'); ?>
    <link href="<?php echo e(asset('public/plugins/css/dataTables.bootstrap.min.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/patients/register.css?v1.0.1')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/doctors/patientlist.css?v1.0.1')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/receptions/designation.css?v1.0.1')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/receptions/status.css?v1.0.1')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/requisition/medicines.css?v1.0.1')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/ancillary/charging.css?v1.0.2')); ?>" rel="stylesheet" />
    <!-- <link href="<?php echo e(asset('public/css/medicalcertificate/medicalcertificate.css')); ?>" rel="stylesheet" /> -->
<?php $__env->stopSection(); ?>


<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('receptions.navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>
    <br>
    <div class="container-fluid" id="overviewWrapper">

        <?php echo $__env->make('doctors.medicalRecords', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('doctors.ajaxConsultationList', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('doctors.ajaxRequisitionList', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('doctors.ajaxRefferals', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('doctors.ajaxFollowup', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('doctors.requisition.medsWatch', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('doctors.records.radiology', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('ancillary.chargingmodal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('ancillary.patientinfo', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('ancillary.vitalsigns', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('ancillary.chiefcomplaint', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('ancillary.nursenotes', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('ancillary.loader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('ancillary.loaderbackground', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('nurse.pedia.form_records', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('partials.alert', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('doctors.laboratory_result', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>



        <?php
            $chrgingClinics = array(3,5,8,24,32,34,10,48,22,21,25,11,26,52,17);
            $noDoctorsClinic = array(48,22,21);
        ?>

        <div class="">

            <?php if(!in_array(Auth::user()->clinic, $noDoctorsClinic)): ?>
                <?php echo $__env->make('receptions.overview.doctors', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php endif; ?>

            <div class="<?php echo e((!in_array(Auth::user()->clinic, $noDoctorsClinic))? 'col-md-8' : 'container'); ?> patientsWrapper">
                <br>

                <?php echo $__env->make('receptions.overview.title', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                    <?php if(in_array(Auth::user()->clinic, $noDoctorsClinic)): ?>
                        <div class="status" id="<?php echo e($status); ?>">
                        <hr>
                        <?php echo $__env->make('receptions.ancillary.status', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    <?php else: ?>
                        <div class="status overviewstatus" id="<?php echo e($status); ?>">
                        <?php echo $__env->make('receptions.overview.status', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    <?php endif; ?>
                </div>

                <br>
                <div class="table-responsive patientsOverview">
                    <table class="table" id="patientsTable">

                        <?php echo $__env->make('receptions.overview.thead', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                        <tbody class="loadPatients" id="<?php echo e(Request::is('overview')); ?>" data-id="<?php echo e(Request::is('rcptnLogs/*/*/*')); ?>" charoff="<?php echo e(url()->current()); ?>">
                            <?php echo e(csrf_field()); ?>

                            
                        </tbody>
                    </table>

                </div>

                <?php echo $__env->make('partials.legend', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


            </div>
        </div>

    </div>

<?php $__env->stopSection(); ?>



<?php $__env->startSection('footer'); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('pagescript'); ?>

    <?php echo $__env->make('message.toaster', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <script>
           // $('#modal-medical-records').modal("toggle");
       var dateToday = '<?php echo e(Carbon::today()->format("m/d/Y")); ?>';
   </script>

    <script src="<?php echo e(asset('public/plugins/js/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/dataTables.bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/receptions/overview.js?v1.0.2')); ?>"></script>
    <script src="<?php echo e(asset('public/js/doctors/ajaxRecords.js?v1.0.3')); ?>"></script>
    <script src="<?php echo e(asset('public/js/receptions/consultation.js?v1.0.4')); ?>"></script>
    <script src="<?php echo e(asset('public/js/results/master.js?v1.0.3')); ?>"></script>
    <script src="<?php echo e(asset('public/js/results/medsWatch.js?v1.0.2')); ?>"></script>
    <script src="<?php echo e(asset('public/js/results/ultrasound.js?v1.0.9')); ?>"></script>
    <script src="<?php echo e(asset('public/js/results/radiologyQuickView.js?v1.0.2')); ?>"></script>
    <script src="<?php echo e(asset('public/js/ancillary/charging.js?v1.0.4')); ?>"></script>
    <script src="<?php echo e(asset('public/js/nurse/pedia/form_records.js?v1.0.2')); ?>"></script>
    <script src="<?php echo e(asset('public/js/receptions/queuercode.js?v1.0.1')); ?>"></script>
    <script src="<?php echo e(asset('public/js/doctors/filemanager.js?v1.0.0')); ?>"></script>
    <script src="<?php echo e(asset('public/js/doctors/preview.js?v1.0.0')); ?>"></script>

    <?php if($status == 'P' || $status == 'S' || $status == 'C' || $status == 'F' || $status == 'H' || $status == 'T'): ?>
        <script src="<?php echo e(asset('public/js/receptions/loadReceptions2.js?v1.0.3')); ?>"></script>
    <?php else: ?>
        <script src="<?php echo e(asset('public/js/receptions/loadReceptions.js?v1.0.3')); ?>"></script>
    <?php endif; ?>

    <script src="<?php echo e(asset('public/js/receptions/patientinfo.js?v1.0.1')); ?>"></script>

    <?php echo $__env->make('receptions.message.notify', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>