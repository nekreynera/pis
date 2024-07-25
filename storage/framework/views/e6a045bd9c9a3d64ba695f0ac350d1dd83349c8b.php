<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPD | Scan Barcode
    <?php $__env->endSlot(); ?>

    <?php $__env->startSection('pagestyle'); ?>
         <link href="<?php echo e(asset('public/css/patients/register.css')); ?>" rel="stylesheet" />
         <link href="<?php echo e(asset('public/css/triage/triage_support.css')); ?>" rel="stylesheet" />
    <?php $__env->stopSection(); ?>



    <?php $__env->startSection('header'); ?>
        <?php echo $__env->make('triage.navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php $__env->stopSection(); ?>



    <?php $__env->startSection('content'); ?>
        
        <div class="container">
            <div class="col-md-6 col-md-offset-3">
                <h2 class="text-center">TRIAGE SUPPORT</h2>
                <br/>
                <br/>
                <br/>

                <form action="<?php echo e(url('triagebarcode')); ?>" method="post">
                    <?php echo e(csrf_field()); ?>

                    <div class="form-group <?php if($errors->has('barcode')): ?> has-error <?php endif; ?>">
                        <input type="text" name="barcode" class="form-control" value="<?php echo e(old('barcode')); ?>" 
                        placeholder="Scan QRCODE / Enter Hospital #" autofocus />
                        <?php if($errors->has('barcode')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('barcode')); ?></strong>
                            </span>
                        <?php endif; ?>
                    </div>
                </form>

                <br/>
                <br/>
                <p class="text-center">
                    <strong>“ Prioritization of patients for medical treatment ”</strong>
                </p>
                <p class="text-muted text-center">
                    Medicine is a science of uncertainty and an art of probabality.
                </p>
            </div>
        </div>
        
    <?php $__env->stopSection(); ?>





    <?php $__env->startSection('footer'); ?>
    <?php $__env->stopSection(); ?>



    <?php $__env->startSection('pagescript'); ?>
        <?php echo $__env->make('message.toaster', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>
