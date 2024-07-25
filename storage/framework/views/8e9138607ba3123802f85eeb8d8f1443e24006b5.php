<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPD | Edit Consultation
    <?php $__env->endSlot(); ?>

<?php $__env->startSection('pagestyle'); ?>
    <link href="<?php echo e(asset('public/css/doctors/reset.css')); ?>" rel="stylesheet" />
    <?php if(Auth::user()->theme == 2): ?>
        <link href="<?php echo e(asset('public/css/doctors/darkstyle.css')); ?>" rel="stylesheet" />
    <?php else: ?>
        <link href="<?php echo e(asset('public/css/doctors/greenstyle.css')); ?>" rel="stylesheet" />
    <?php endif; ?>
    <link href="<?php echo e(asset('public/css/doctors/consultation.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/doctors/diagnosis.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>



<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('doctors.navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('doctors/dashboard'); ?>
        <?php $__env->startSection('main-content'); ?>


            <div class="content-wrapper" style="padding: 50px 20px">
                <div class="container-fluid">

                    <?php echo $__env->make('doctors.consultation_patientinfo', ['patient'=>$patient], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                    <?php echo $__env->make('doctors.consultation_notification', ['refferals'=>$refferals, 'followups'=>$followups], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                    <div class="row diagnosisWrapper">
                        <br>
                        
                        <div class="row">

                            <div class="col-md-8">
                                <h1 class="text-center" style="display: inline">
                                    <small class="text-danger"><?php echo e($patient->last_name.', '.$patient->first_name.' '.($patient->middle_name ? $patient->middle_name[0].'.' : '')); ?></small>
                                </h1>
                                <button class="btn btn-default menusConsultations" title="Click to view patient information" data-toggle="modal" data-target="#patientInfo">
                                    <i class="fa fa-user-o text-primary"></i>
                                </button>
                                <button class="btn btn-default menusConsultations" data-toggle="modal" data-target="#notification" title="Click to view patients notification">
                                    <i class="fa fa-bell-o text-primary"></i>
                                    <?php echo ((count($refferals) + count($followups)) > 0)? '<span class="badgeIcon">'.(count($refferals) + count($followups)).'</span>' : ''; ?>

                                </button>
                            </div>

                            <div class="col-md-4 text-right icd10codes">
                                    <a href="#" class="btn btn-default saveButton menusConsultations"
                                       data-placement="top" data-toggle="tooltip" title="Click to Save this consultation"">
                                        <i class="fa fa-save text-danger"></i>
                                    </a>
                                    <a href="<?php echo e(url('print/'.$consultation->id)); ?>" class="btn btn-default menusConsultations"
                                    data-placement="top" data-toggle="tooltip" title="Print this consultation form"
                                    onclick="return confirm('Print this consultation?')" target="_blank">
                                        <i class="fa fa-print text-success"></i>
                                    </a>
                                    
                                <a href="#" class="btn btn-success icdCodesBtn" data-toggle="modal" data-target="#icd10CodeModal">ICD 10 CODES</a>
                            </div>
                        </div>

                        <form action="<?php echo e(url('consultation/'.$consultation->id)); ?>" method="post" enctype="multipart/form-data" id="consultationForm">
                            <?php echo e(csrf_field()); ?>

                            <?php echo e(method_field('PUT')); ?>

                            <div class="form-group">
                                <textarea name="consultation" id="diagnosis" class="my-editor" rows="65"><?php echo $consultation->consultation; ?></textarea>
                            </div>

                            <?php echo $__env->make('doctors.filemanager', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                            <?php echo $__env->make('doctors.icdCodeAttachments', ['icds'=>$icdcodes], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

                        </form>
                    </div>

                    <?php echo $__env->make('doctors.icd10codes', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            </div>

        </div><!-- .content-wrapper -->


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
    <script src="<?php echo e(asset('public/js/doctors/filemanager.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/tinymce/tinymce.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/doctors/richtexteditorpreview.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/preventDelete.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/doctors/consultation.js')); ?>"></script>
<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>
