<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPD | Chief Complaint
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
                        <?php echo e($patient->last_name.', '.$patient->first_name); ?>

                    </h3>
                </div>
            </div>

            <form action="<?php echo e(url('saveChiefComplaint')); ?>" method="post" enctype="multipart/form-data" id="consultationForm">
                <?php echo e(csrf_field()); ?>

                <input type="hidden" name="pid" value="<?php echo e($patient->id); ?>" />
                <div class="form-group">
                    <textarea name="consultation" id="diagnosis" class="my-editor" rows="65"><?php echo isset($consultation->consultation) ? $consultation->consultation : ''; ?></textarea>
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

    <script src="<?php echo e(asset('public/js/doctors/richtexteditor.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/preventDelete.js')); ?>"></script>
<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>
