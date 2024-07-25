<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPD | Nurse Notes
    <?php $__env->endSlot(); ?>

<?php $__env->startSection('pagestyle'); ?>
    <link href="<?php echo e(asset('public/css/receptions/nursenotes.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>


<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('receptions.navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>

    <div class="container-fluid">
        <div class="container">

            <div class="row">
                <div class="col-md-6">
                    <h3>
                        <small>Patient Name:</small>
                        <?php echo e($consultation->patient); ?>

                    </h3>
                </div>
                <div class="col-md-6">
                    <h3 class="text-right titleWrapper">
                        Write Nurse Notes
                        <button type="submit" form="consultationForm" onclick="return confirm('Save this nurse notes?')"
                                class="btn btn-default iconsNurse" data-placement="top" data-toggle="tooltip" title="Click to save nurse notes" >
                            <i class="fa fa-save text-danger"></i>
                        </button>
                        <a href="<?php echo e(url('printNurseNotes/'.$consultation->id)); ?>" target="_blank" class="btn btn-default iconsNurse"
                           data-placement="top" data-toggle="tooltip" title="Print this consultation" >
                            <i class="fa fa-print text-success"></i>
                        </a>
                    </h3>
                </div>
            </div>

            <form action="<?php echo e(url('nurseNotes')); ?>" method="post" enctype="multipart/form-data" id="consultationForm">
                <?php echo e(csrf_field()); ?>

                <input type="hidden" name="cid" value="<?php echo e($consultation->id); ?>">
                <div class="form-group">
                    <textarea name="consultation" id="diagnosis" class="my-editor" rows="40"><?php echo isset($doctorsConsultation) ? $doctorsConsultation : ''; ?></textarea>
                </div>
            </form>

        </div>
    </div>


<?php $__env->stopSection(); ?>



<?php $__env->startSection('footer'); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('pagescript'); ?>
    <?php echo $__env->make('message.toaster', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <script src="<?php echo e(asset('public/plugins/js/tinymce/tinymce.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/doctors/richtexteditorpreview.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/preventDelete.js')); ?>"></script>
<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>
