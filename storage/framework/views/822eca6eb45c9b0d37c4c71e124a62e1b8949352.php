<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPD | Register
    <?php $__env->endSlot(); ?>

<?php $__env->startSection('pagestyle'); ?>
    <link href="<?php echo e(asset('public/plugins/css/dataTables.bootstrap.min.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>



<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('admin/navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>
    <div class="container">
        <h2 class="text-center">USERLIST</h2>
        <br>
        <div class="table-responsive">
            <table class="table" id="userlistTable">
                <thead>
                    <tr class="bg-default">
                        <th>#</th>
                        <th>STATUS</th>
                        <th>NAME</th>
                        <th>USERNAME</th>
                        <th>CLINIC</th>
                        <th>ROLE</th>
                        <th>EDIT</th>
                        <th>TRASH</th>
                        <th>DECRYPT</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($loop->index + 1); ?></td>
                            <td>
                                <?php echo (App\User::isActive($user->id))? '<div class="online"><font hidden>online</font></div>' : '<div class="offline"></div>'; ?>

                            </td>
                            <td><?php echo e($user->name); ?></td>
                            <td><?php echo e($user->username); ?></td>
                            <td><?php echo e($user->clinicname); ?></td>
                            <td align="center"><?php echo e($user->roledesc); ?>

                                <?php if($user->med_interns): ?>
                                <br>
                                Medical Clerk(Intern)
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?php echo e(url('editUser/'.$user->id)); ?>" class="btn btn-circle text-info">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            </td>
                            <td>
                                <a href="#" class="btn btn-circle text-danger">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo e(url('decrypt/'.$user->id)); ?>" class="btn btn-circle text-warning" onclick="decryptPassword($(this))">
                                    <i class="fa fa-key"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>

    <br><br>



<?php $__env->stopSection(); ?>





<?php $__env->startSection('footer'); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('pagescript'); ?>
    <?php echo $__env->make('message.toaster', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <script src="<?php echo e(asset('public/plugins/js/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/dataTables.bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/admin/decrypt.js')); ?>"></script>
<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>
