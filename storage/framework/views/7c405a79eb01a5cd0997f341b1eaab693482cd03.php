<?php $__env->startComponent('partials/header'); ?>

<?php $__env->slot('title'); ?>
OPD | Referrals Report
<?php $__env->endSlot(); ?>

<?php $__env->startSection('pagestyle'); ?>
    <link href="<?php echo e(asset('public/plugins/css/jquery-ui.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>



<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('receptions.navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>

    <div class="container-fluid">
        <div class="container">

            <div class="col-md-4">
                <h3><span class="text-muted">Refferals</span> <b class="text-success"></h3>
            </div>

            <div class="col-md-8" style="padding-top: 20px;">


                <form action="<?php echo e(url('refferalsReport')); ?>" method="post" class="form-inline">

                    <?php echo e(csrf_field()); ?>

                    <div class="form-group <?php if($errors->has('type')): ?> has-error <?php endif; ?>">
                        <div class="input-group">
                            <select class="form-control" name="type">
                                <option value="out" <?php if($type == 'out'): ?> selected <?php endif; ?>>From this clinic</option>
                                <option value="in" <?php if($type == 'in'): ?> selected <?php endif; ?>>From other clinics</option>
                            </select>
                        </div>
                        <?php if($errors->has('type')): ?>
                            <span class="help-block">
                                <strong class=""><?php echo e($errors->first('type')); ?></strong>
                            </span>
                        <?php endif; ?>
                    </div>
                    <div class="form-group <?php if($errors->has('starting')): ?> has-error <?php endif; ?>">
                        <div class="input-group">
                            <span class="input-group-addon" id="startingDate" onclick="document.getElementById('starting').focus()">
                                <i class="fa fa-calendar"></i>
                            </span>
                            <input type="text" name="starting" class="form-control datepicker" value="<?php echo e(isset($starting) ? $starting : ''); ?>"
                                   placeholder="Starting Date" aria-describedby="startingDate" id="starting" required />
                        </div>
                        <?php if($errors->has('starting')): ?>
                            <span class="help-block">
                                <strong class=""><?php echo e($errors->first('starting')); ?></strong>
                            </span>
                        <?php endif; ?>
                    </div>

                    <div class="form-group <?php if($errors->has('ending')): ?> has-error <?php endif; ?>">
                        <div class="input-group">
                            <span class="input-group-addon" id="endingDate" onclick="document.getElementById('ending').focus()">
                                <i class="fa fa-calendar"></i>
                            </span>
                            <input type="text" name="ending" class="form-control datepicker" value="<?php echo e(isset($ending) ? $ending : ''); ?>"
                                   placeholder="Ending Date" aria-describedby="endingDate" id="ending">
                        </div>
                        <?php if($errors->has('ending')): ?>
                            <span class="help-block">
                                <strong class=""><?php echo e($errors->first('ending')); ?></strong>
                            </span>
                        <?php endif; ?>
                    </div>


                    <div class="form-group">
                        <button class="btn btn-success" type="submit">Submit</button>
                    </div>

                </form>


                <br/>
                <br/>

            </div>




            <div class="col-md-12">

                <?php if($starting): ?>
                <?php if(!$refferals->isEmpty()): ?>
                    <?php $total = 0; ?>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="bg-primary">
                                    <th>Total</th>
                                    <th>Referred <?php echo e(($type == 'in')?'by':'to'); ?> Clinic</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $refferals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($row->total); ?></td>
                                    <td><?php echo e($row->name); ?></td>
                                </tr>
                                    <?php $total+=$row->total ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                            <tfoot>
                                <tr class="bg-primary">
                                    <td><?php echo e($total); ?></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-danger text-center">
                        <h5>No Results Found!</h5>
                    </div>
                <?php endif; ?>
                    <?php else: ?>

                    <hr/>
                    <h4 class="text-center text-danger">Please select a date to retrieve data</h4>
                    <hr/>

                <?php endif; ?>
            </div>


        </div>



    </div>

<?php $__env->stopSection(); ?>





<?php $__env->startSection('footer'); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('pagescript'); ?>
    <?php echo $__env->make('message.toaster', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <script src="<?php echo e(asset('public/plugins/js/jquery-ui.min.js')); ?>"></script>

    <script>
        $(function() {
            $( ".datepicker" ).datepicker({
                dateFormat: 'yy-mm-dd',
            });
        });
    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>
