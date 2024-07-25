<?php $__env->startComponent('partials/header'); ?>

  <?php $__env->slot('title'); ?>
    OPD | MSS
  <?php $__env->endSlot(); ?>

  <?php $__env->startSection('pagestyle'); ?>
    <link href="<?php echo e(asset('public/css/mss/scan.css')); ?>" rel="stylesheet" />
  <?php $__env->stopSection(); ?>

  <?php $__env->startSection('header'); ?>
    <?php echo $__env->make('mss/navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php $__env->stopSection(); ?>

  <?php $__env->startSection('content'); ?>
    <div class="container">
      <form class="form-horizontal" action="<?php echo e(url('classification')); ?>" method="post">
        <?php echo e(csrf_field()); ?>

          <h3 class="text-center">MSWD Assessment Tool <i class="fa fa-check-square-o"></i></h3>
          <div class="col-md-6 col-md-offset-3">
            <div class="form-group scaninput">
              <label for="">SCAN BARCODE</label>
              <div class="input-group">
                <input type="text" name="barcode" value="" class="form-control inputbarcode" autofocus placeholder="Barcode/Hospital no">
                <span class="input-group-addon spanbarcode"><i class="fa fa-barcode"></i></span>
              </div>
            </div>
          </div>
      </form>
    </div>
  <?php $__env->stopSection(); ?>

  <?php $__env->startSection('pagescript'); ?>
    <?php echo $__env->make('message/toaster', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <script src="<?php echo e(asset('public/js/mss/scan.js')); ?>"></script>

  <?php $__env->stopSection(); ?>

<?php echo $__env->renderComponent(); ?>
