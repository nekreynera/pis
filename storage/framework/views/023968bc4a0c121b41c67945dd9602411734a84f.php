<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        PIS | Smoke Cessation
    <?php $__env->endSlot(); ?>

<?php $__env->startSection('pagestyle'); ?>
    <link href="<?php echo e(asset('public/css/doctors/reset.css')); ?>" rel="stylesheet" />
    <?php if(Auth::user()->theme == 2): ?>
        <link href="<?php echo e(asset('public/css/doctors/darkstyle.css')); ?>" rel="stylesheet" />
    <?php else: ?>
        <link href="<?php echo e(asset('public/css/doctors/greenstyle.css')); ?>" rel="stylesheet" />
    <?php endif; ?>
    <link href="<?php echo e(asset('public/plugins/css/dataTables.bootstrap.min.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/plugins/css/jquery-ui.css')); ?>" rel="stylesheet" />

<?php $__env->stopSection(); ?>



<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('doctors.navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('doctors.dashboard'); ?>
        <?php $__env->startSection('main-content'); ?>


        <div class="content-wrapper" style="padding: 50px 0px">
            
            <div class="col-md-10 col-md-offset-1">
                <br/>
                <br/>



                <div class="text-right">
                    <form action='<?php echo e(url("smoke_store")); ?>' method="post" class="form-inline">
                        <?php echo e(csrf_field()); ?>

                        <div class="form-group">
                            <strong class="text-success"><?php echo e(Carbon::parse($start)->diffForHumans()); ?></strong>
                        </div>
                        <div class="form-group <?php if($errors->has('start')): ?> has-error <?php endif; ?>">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" name="start" class="form-control datepicker" value="<?php echo e(isset($start) ? $start : ''); ?>"
                                       placeholder="Enter Starting Date" required="">
                            </div>
                            <?php if($errors->has('start')): ?>
                                <span class="help-block">
                                    <?php echo e($errors->first('start')); ?>

                                </span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group <?php if($errors->has('end')): ?> has-error <?php endif; ?>">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" name="end" class="form-control datepicker" value="<?php echo e(isset($end) ? $end : ''); ?>"
                                       placeholder="Enter Ending Date" required="">
                            </div>
                            <?php if($errors->has('end')): ?>
                                <span class="help-block">
                                    <?php echo e($errors->first('end')); ?>

                                </span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-flat">Submit</button>
                        </div>
                    </form>
                </div>


                <hr>


                <h4>Patients Consulted at Smoke Cessation Clinic 
                    <?php if(!is_null($smokes)): ?>
                        <span class="badge" style="background-color: #ff8080">
                            <?php echo e(count($smokes)); ?>

                        </span>
                    <?php else: ?>
                        <span class="badge" style="background-color: #ff8080">
                            <?php echo e(0); ?>

                        </span>
                    <?php endif; ?>
                </h4>
                <br>
                <h4 class="text-info">
                    <span class="text-muted">Consulted by:</span>
                    DR. <?php echo e(Auth::user()->last_name.', '.Auth::user()->first_name.' '.Auth::user()->suffix.' '.Auth::user()->middle_name); ?>

                </h4>

                <hr>

                <div class="table-responsive" style="font-size: 12px;">
                    <table class="table table-bordered table-striped" id="searchTable">
                        <thead>
                            <tr>
                                <th>No#</th>
                                <th>Patient</th>
                                <th>Date Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($start && $end): ?>
                                <?php if(!$smokes->isEmpty()): ?>
                                    <?php $__currentLoopData = $smokes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $smoke): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($loop->index + 1); ?></td>
                                        <td><?php echo e($smoke->last_name.', '.$smoke->first_name.' '.$smoke->suffix.' '.$smoke->middle_name); ?></td>
                                        <td><?php echo e(Carbon::parse($smoke->created_at)->toFormattedDateString()); ?></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3" class="bg-danger text-center text-danger">
                                            No Results Found <i class="fa fa-warning"></i>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="bg-danger text-center text-danger">
                                        Please select a date to retreive data <i class="fa fa-calendar"></i>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            
                        </tbody>
                    </table>
                </div>
            </div>
            
            

        </div> <!-- .content-wrapper -->




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
    <script src="<?php echo e(asset('public/plugins/js/jquery-ui.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/doctors/main.js')); ?>"></script>


    <script src="<?php echo e(asset('public/plugins/js/jquery-ui.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/AdminLTE/bower_components/datatables.net/js/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/AdminLTE/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')); ?>"></script>
    <script>
        $(function () {
            $('#searchTable').DataTable();
        });
    </script>

    <script>
        $( ".datepicker" ).datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd'
            });
    </script>

<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>
