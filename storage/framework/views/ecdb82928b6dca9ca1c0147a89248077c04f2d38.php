<?php $__env->startComponent('partials/header'); ?>

  <?php $__env->slot('title'); ?>
    OPD | REPORT
  <?php $__env->endSlot(); ?>

  <?php $__env->startSection('pagestyle'); ?>
    <link href="<?php echo e(asset('public/css/mss/report.css?v2.0.1')); ?>" rel="stylesheet" />
  <?php $__env->stopSection(); ?>

  <?php $__env->startSection('header'); ?>
    <?php echo $__env->make('mss/navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php $__env->stopSection(); ?>

  <?php $__env->startSection('content'); ?>
    <div class="container mainWrapper" id="wrapper">
        <div class="submitclassificationgenerate">
            <img src="public/images/loader.svg">
        </div>
            <h3 class="text-center">MSS REPORT <i class="fa fa-file-text-o"></i></h3>
            <form class="form-horizontal generatemssreport" method="post" action="<?php echo e(url('genaratedreport')); ?>">
                 <?php echo e(csrf_field()); ?>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>TYPE</th>
                            <th>EMPLOYEE NAME</th>
                            <th colspan="2">DATE OF TRANSACTION</th>
                        </tr>
                        <tr>
                            <td rowspan="2">
                              <br><br>
                              <select name="type" class="form-control">
                                <option value="1">STATISTICAL REPORT</option>
                                <option value="2">CLASSIFIED PATIENT REPORT</option>
                                <option value="3">SPONSORED PATIENT REPORT</option>
                              </select>
                            </td>
                            <td rowspan="2">
                                <br><br>
                                <select name="users_id" class="form-control text-capitalize" required>
                                    <option value="" hidden>--choose--</option>
                                    <?php if(Auth::user()->id == 41): ?>
                                      <?php $__currentLoopData = $employee; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>;
                                      <option value="<?php echo e($list->id); ?>" class="text-capitalize"><?php echo e(strtolower($list->last_name).' '.strtolower($list->first_name)); ?></option>
                                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                      <option value="ALL">All</option>
                                    <?php else: ?>
                                    <option value="<?php echo e(Auth::user()->id); ?>" class="text-capitalize" selected><?php echo e(strtolower(Auth::user()->last_name).' '.strtolower(Auth::user()->first_name)); ?></option>
                                    <?php endif; ?>
                                    
                                </select>
                            </td>
                            <td>FROM(start of date transacted)</td>
                            <td>TO(end of date transacted)</td>
                        </tr>
                        <tr>
                            <td><input type="date" name="from" class="form-control text-center" required></td>
                            <td><input type="date" name="to" class="form-control text-center" required></td>
                        </tr>
                    </table>
                </div>
                <div class="pull-right">
                    <button type="submit" class="btn btn-success">GENERATE <i class="fa fa-cog"></i></button>
                </div>
            </form>
    </div>
  <?php $__env->stopSection(); ?>
  <?php $__env->startSection('pagescript'); ?>
    <?php echo $__env->make('message/toaster', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <script src="<?php echo e(asset('public/js/mss/report.js?v2.0.1')); ?>"></script>
  <?php $__env->stopSection(); ?>
<?php echo $__env->renderComponent(); ?>
