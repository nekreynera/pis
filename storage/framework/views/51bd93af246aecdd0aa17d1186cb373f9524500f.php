<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPD | History
    <?php $__env->endSlot(); ?>

<?php $__env->startSection('pagestyle'); ?>
    <link href="<?php echo e(asset('public/plugins/css/jquery-ui.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/plugins/css/dataTables.bootstrap.min.css')); ?>" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo e(asset('public/css/patients/searchpatient.css')); ?>" />
<?php $__env->stopSection(); ?>


<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('triage.navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>
    <div class="container">
        <h2 class="text-center">Triage History</h2>
        <?php echo $__env->make('message.msg', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <div class="table-responsive">
            <table class="table table-responsive">
                <table class="table">
                    <thead>
                        <tr style="background-color: #eee">
                            <th>PATIENT NAME</th>
                            <th>CLINIC</th>
                            <th>DOCTOR</th>
                            <th>STATUS</th>
                            <th>DATE/TIME</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($history) > 0): ?>
                            <?php $__currentLoopData = $history; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $historya): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    if($historya->status == 'S')
                                        $status = '<span class="text-success">Serving</span>';
                                    elseif($historya->status == 'P')
                                        $status = '<span class="text-warning">Pending</span>';
                                    elseif($historya->status == 'F')
                                        $status = '<span class="text-primary">Finished</span>';
                                    elseif($historya->status == 'C')
                                        $status = '<span class="text-danger">Canceled</span>';
                                    else
                                        $status = '<span class="text-danger">N/A</span>';
                                ?>
                                <tr>
                                    <td><?php echo e($historya->name); ?></td>
                                    <td><?php echo e($historya->clinic); ?></td>
                                    <td><?php echo e($historya->doctor); ?></td>
                                    <td><?php echo $status; ?></td>
                                    <td><?php echo e(Carbon::parse($historya->created_at)->toDateString()); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">
                                    <strong class="text-danger">NO RESULTS FOUND!</strong>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </table>
        </div>
    </div>

    <br><br>
<?php $__env->stopSection(); ?>




<?php $__env->startSection('pagescript'); ?>
    <?php echo $__env->make('message.toaster', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <script src="<?php echo e(asset('public/plugins/js/jquery-ui.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/dataTables.bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/patients/unprinted.js')); ?>"></script>
<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>
