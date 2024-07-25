<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPD | Consultation
    <?php $__env->endSlot(); ?>

<?php $__env->startSection('pagestyle'); ?>
    <link href="<?php echo e(asset('public/plugins/css/jquery-ui.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/doctors/reset.css')); ?>" rel="stylesheet" />
    <?php if(Auth::user()->theme == 2): ?>
        <link href="<?php echo e(asset('public/css/doctors/darkstyle.css')); ?>" rel="stylesheet" />
    <?php else: ?>
        <link href="<?php echo e(asset('public/css/doctors/greenstyle.css')); ?>" rel="stylesheet" />
    <?php endif; ?>
    <link href="<?php echo e(asset('public/css/doctors/consultation.css?v2.0.1')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/doctors/diagnosis.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/doctors/patientinfo.css?v2.0.1')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/doctors/requisition.css?v2.0.1')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/doctors/industrialForm.css')); ?>" rel="stylesheet" />

    <link href="<?php echo e(asset('public/css/doctors/patientlist.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/receptions/designation.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/requisition/medicines.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/receptions/status.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>



<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('doctors.navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('doctors/dashboard'); ?>
        <?php $__env->startSection('main-content'); ?>


            <div class="content-wrapper" style="padding: 55px 10px 0px 10px;">
                <div class="container-fluid">




                    <div class="loaderRefresh">
                        <div class="loaderWaiting">
                            <i class="fa fa-spinner fa-spin"></i>
                            <span> Please Wait...</span>
                        </div>
                    </div>





                    <?php echo $__env->make('doctors.medicalRecords', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    <?php echo $__env->make('doctors.ajaxConsultationList', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    <?php echo $__env->make('doctors.ajaxRequisitionList', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    <?php echo $__env->make('doctors.ajaxRefferals', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    <?php echo $__env->make('doctors.ajaxFollowup', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    <?php echo $__env->make('doctors.records.consultation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    <?php echo $__env->make('doctors.requisition.medsWatch', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    <?php echo $__env->make('doctors.records.radiology', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    <?php echo $__env->make('doctors.laboratory_result', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


                    <?php echo $__env->make('doctors.industrial.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                    <?php echo $__env->make('doctors.consultation_patientinfo', ['patient'=>$patient], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                    <?php echo $__env->make('doctors.consultation_notification', ['refferals'=>$refferals, 'followups'=>$followups], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    
                    <?php echo $__env->make('nurse.pedia.form_records', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                    <?php echo $__env->make('doctors.requisition.patientName', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                    <?php echo $__env->make('doctors.consultation_icon', ['patient'=>$patient, 'smoke'=>$smoke], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <form class="form-horizontal" action="<?php echo e(url('consultation')); ?>" method="post" enctype="multipart/form-data" id="consultationForm">
                                <?php echo e(csrf_field()); ?>

                                <div class="form-group">
                                    <textarea name="consultation" id="diagnosis" class="my-editor" rows="65"><?php echo isset($consultation->consultation) ? $consultation->consultation : ''; ?></textarea>
                                </div>

                                <?php echo $__env->make('doctors.filemanager', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                                <?php echo $__env->make('doctors.icdCodeAttachments', ['icds'=>$icdcodes], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                            </form>
                        </div>
                    </div>
                </div>

                <!-- icd code button -->

                <?php echo $__env->make('doctors.icd10codes', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


            </div> <!-- .content-wrapper -->


        <?php $__env->stopSection(); ?>
    <?php echo $__env->renderComponent(); ?>
<?php $__env->stopSection(); ?>




<?php $__env->startSection('footer'); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('pagescript'); ?>
    <?php echo $__env->make('message.toaster', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <script src="<?php echo e(asset('public/plugins/js/jquery-ui.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/form.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/modernizr.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/jquery.menu-aim.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/doctors/main.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/doctors/filemanager.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/tinymce/tinymce.min.js')); ?>"></script>

    <script src="<?php echo e(asset('public/js/doctors/bp.js')); ?>"></script>

    <?php if(Session::has('cid')): ?>
        <script src="<?php echo e(asset('public/js/doctors/richtexteditorpreview.js')); ?>"></script>
    <?php else: ?>
        <script src="<?php echo e(asset('public/js/doctors/richtexteditor.js')); ?>"></script>
    <?php endif; ?>

    <script src="<?php echo e(asset('public/plugins/js/preventDelete.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/doctors/consultation.js?v1.0.1')); ?>"></script>

    <script src="<?php echo e(asset('public/js/doctors/ajaxRecords.js?v1.0.1')); ?>"></script>
    <script src="<?php echo e(asset('public/js/results/consultation.js?2')); ?>"></script>
    <script src="<?php echo e(asset('public/js/results/master.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/results/medsWatch.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/results/ultrasound.js?v1.0.9')); ?>"></script>
    <script src="<?php echo e(asset('public/js/results/radiologyQuickView.js')); ?>"></script>



    <!-- smoke inceasation -->
    <script src="<?php echo e(asset('public/js/doctors/smokeInceasation.js')); ?>"></script>



    <script src="<?php echo e(asset('public/js/industrial/form.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/nurse/pedia/form_records.js')); ?>"></script>

    <script>
        $( function() {
            $( ".dateOfConsult" ).datepicker({
                dateFormat: 'yy-mm-dd'
            });
        });
    </script>
    <?php if($industrialConsultations): ?>
        <script>
            $('.printIConIndustrial').fadeIn('fast');
        </script>
    <?php endif; ?>

<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>
