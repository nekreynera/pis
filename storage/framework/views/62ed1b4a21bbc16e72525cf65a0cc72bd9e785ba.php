<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPD | ANCILLARY
    <?php $__env->endSlot(); ?>

<?php $__env->startSection('pagestyle'); ?>
    <link href="<?php echo e(asset('public/css/doctors/reset.css')); ?>" rel="stylesheet" />
    <?php if(Auth::user()->theme == 2): ?>
        <link href="<?php echo e(asset('public/css/doctors/darkstyle.css')); ?>" rel="stylesheet" />
    <?php else: ?>
        <link href="<?php echo e(asset('public/css/doctors/greenstyle.css')); ?>" rel="stylesheet" />
    <?php endif; ?>
     <link href="<?php echo e(asset('public/css/ancillary/scan.css')); ?>" rel="stylesheet" />

<?php $__env->stopSection(); ?>



<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('ancillary.navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('ancillary/dashboard'); ?>
        <?php $__env->startSection('main-content'); ?>


            <div class="content-wrapper">
                <br>
                <br>
                <div class="">
                    <h3 class="text-center"> PATIENT REQUISITION</h3>
                </div>
                <div class="">
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                </div>

                <div class="scannerform">
                    <form class="form-horizontal" action="<?php echo e(url('scandirect')); ?>" method="post">
                      <?php echo e(csrf_field()); ?>

                        <div class="col-md-6 col-md-offset-3">
                          <div class="form-group scaninput">
                            <label for="">for direct requistion</label>
                            <div class="input-group">
                              <input type="text" name="barcode" value="" class="form-control inputbarcode" placeholder="BARCODE/HOSPITAL NO" autofocus required>
                              <span class="input-group-addon spanbarcode"><i class="fa fa-barcode"></i></span>
                            </div>
                          </div>
                        </div>
                    </form>
                </div>
                    
                
                
            </div> 
            <!-- .content-wrapper -->

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
    <script src="<?php echo e(asset('public/js/pharmacy/main.js')); ?>"></script>
    <!-- <script src="<?php echo e(asset('public/js/pharmacy/logs.js')); ?>"></script> -->
<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>
