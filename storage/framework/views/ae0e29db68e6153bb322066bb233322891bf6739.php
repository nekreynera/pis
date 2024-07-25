<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPD | ANCILLARY
    <?php $__env->endSlot(); ?>

<?php $__env->startSection('pagestyle'); ?>
    <link href="<?php echo e(asset('public/css/ancillary/list.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/plugins/css/dataTables.bootstrap.min.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>



<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('receptions/navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
            <div class="container">
                <div class="col-md-12 census-form">
                    <br>
                    <form class="form-inline pull-right" method="GET" target="_blank">
                            <label>TYPE</label>
                            <select class="form-control" name="type" required>
                                <option value="" hidden>Select</option>
                                <option value="all">ISSUANCE ALL</option>
                                <option value="c">MSS ISSUANCE CLASS-C</option>
                                <option value="d">MSS ISSUANCE CLASS-D</option>
                                <!-- <option value="d">SERVICES</option> -->
                            </select>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <label>FROM</label>
                            <div class="input-group">
                                <span class="input-group-addon fa fa-calendar"></span>
                                <input type="date" name="from" class="form-control" <?php if(isset($_GET['to'])): ?> value="<?php echo e($_GET['from']); ?>" <?php endif; ?> required>
                            </div>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <label> <span class="fa fa-arrow-right"></span> TO</label>
                            <div class="input-group">
                                <span class="input-group-addon fa fa-calendar"></span>
                                <input type="date" name="to" class="form-control" <?php if(isset($_GET['to'])): ?> value="<?php echo e($_GET['to']); ?>" <?php endif; ?> required>
                            </div>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <button type="submit" class="btn btn-success btn-md"><span class="fa fa-cog"></span> GENERATE </button>
                    </form>
                </div>
     
            </div> 
            <!-- .content-wrapper -->
<?php $__env->stopSection(); ?>



<?php $__env->startSection('footer'); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('pagescript'); ?>
    <?php echo $__env->make('message.toaster', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    
    <script src="<?php echo e(asset('public/plugins/js/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/dataTables.bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/ancillary/list.js')); ?>"></script>
<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>
