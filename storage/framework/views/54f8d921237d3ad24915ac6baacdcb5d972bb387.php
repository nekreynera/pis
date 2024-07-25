<?php $__env->startComponent('OPDMS.partials.header'); ?>


<?php $__env->slot('title'); ?>
    OPD | LABORATORY
<?php $__env->endSlot(); ?>


<?php $__env->startSection('pagestyle'); ?>
    <link href="<?php echo e(asset('public/OPDMS/css/patients/main.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/OPDMS/css/laboratory/main.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>


<?php $__env->startSection('navigation'); ?>
    <?php echo $__env->make('OPDMS.partials.boilerplate.navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('dashboard'); ?>
    <?php $__env->startComponent('OPDMS.partials.boilerplate.dashboard'); ?>
    <?php echo $__env->renderComponent(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" id="main-page">

        <?php echo $__env->make('OPDMS.partials.boilerplate.header',
        ['header' => 'Reports', 'sub' => ''], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <!-- Main content -->
        <section class="content">

            <div class="box">
                <div class="box-header with-border">
                  <div class="row action-div">
                    <?php echo $__env->make('OPDMS.laboratory.action.report', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                  </div>
                    <br>

                </div>
                <div class="box-body">
                    <?php echo $__env->make('OPDMS.partials.loader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    <?php if(count($column) > 0): ?>

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="bg-gray">
                                        <?php for($i=0;$i< count($column);$i++): ?>
                                        <th class="text-center"><?php echo e($column[$i]); ?></th>
                                        <?php endfor; ?>
                                    </tr>
                                    
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <?php $__currentLoopData = $data_call; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <td><?php echo e($list->$row); ?></td>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="box-footer">
                    <small>
                        <em class="text-muted">
                            <!-- Choose your desired reports -->
                        </em>
                    </small>
                </div>
            </div>

        </section>
        <!-- /.content -->
    </div>
   

    <!-- /.content-wrapper -->
<?php $__env->stopSection(); ?>





<?php $__env->startSection('aside'); ?>
    <?php echo $__env->make('OPDMS.partials.boilerplate.aside', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('pluginscript'); ?>
    <script src="<?php echo e(asset('public/AdminLTE/plugins/input-mask/jquery.inputmask.js')); ?>"></script>
    <script src="<?php echo e(asset('public/AdminLTE/plugins/input-mask/jquery.inputmask.date.extensions.js')); ?>"></script>
    <script src="<?php echo e(asset('public/AdminLTE/plugins/input-mask/jquery.inputmask.extensions.js')); ?>"></script>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('pagescript'); ?>
    <script>
        var dateToday = '<?php echo e(Carbon::today()->format("m/d/Y")); ?>';
    </script>
    <script src="<?php echo e(asset('public/OPDMS/js/laboratory/main.js')); ?>"></script>
    
   
    <script>
        $('[data-mask]').inputmask();
        
    </script>

<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>