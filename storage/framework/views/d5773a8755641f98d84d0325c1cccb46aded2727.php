<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPD | Demographic Summary
    <?php $__env->endSlot(); ?>

<?php $__env->startSection('pagestyle'); ?>
    <link href="<?php echo e(asset('public/css/receptions/demographic.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/plugins/css/jquery-ui.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>


<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('receptions.navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>


    <div class="container-fluid">
        <div class="demographic col-md-12">


            <br>

            <div class="row">
                <div class="col-md-3">
                    <h3 style="margin: 5px 0 0 0 "><?php echo e($clinic->name); ?></h3>
                </div>
                <div class="col-md-9">
                    <form action="<?php echo e(url('demographicSummary')); ?>" method="post" class="form-inline" style="display: inline">
                        <?php echo e(csrf_field()); ?>

                        <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            <input type="text" required name="starting" class="form-control datepicker" required placeholder="Starting date">
                        </div>
                        <div class="form-group" style="margin: 0 10px 0 10px">
                            <i class="fa fa-arrow-right"></i>
                        </div>
                        <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            <input type="text" required name="ending" class="form-control datepicker" required placeholder="Ending date">
                        </div>
                        <div class="form-group" style="margin-left:15px">
                            <button class="btn btn-success" type="submit">Submit</button>
                        </div>
                    </form>
                </div>

            </div>

            <br>


            <div class="row">

            <?php if($final): ?>

            <div class="col-md-4">

            <div class="table-responsive demographicSummary">
                <table class="table table-bordered">
                    <thead>
                        <th>CITY/MUNICIPALITY</th>
                        <th>NEW</th>
                        <th>OLD</th>
                    </thead>
                    <tbody>

                    

                    <tr class="leyte">
                        <td colspan="3" class="text-center"><strong>LEYTE</strong></td>
                    </tr>
                    <tr class="leyte">
                        <td>TACLOBAN</td>
                        <td><?php echo e($final['TN']); ?></td>
                        <td><?php echo e($final['TO']); ?></td>
                    </tr>
                    <?php for($i=1;$i<6;$i++): ?>
                        <?php
                            if($i == 1){
                                $dis = '1st';
                            }elseif($i == 2){
                                $dis = '2nd';
                            }elseif($i == 3){
                                $dis = '3rd';
                            }elseif($i == 4){
                                $dis = '4th';
                            }else{
                                $dis = '5th';
                            }
                        ?>
                        <tr class="leyte">
                            <td><?php echo e($dis); ?></td>
                            <td><?php echo e($final['LN'.$i]); ?></td>
                            <td><?php echo e($final['LO'.$i]); ?></td>
                        </tr>
                    <?php endfor; ?>
                    <tr class="wsamar">
                        <td colspan="3" class="text-center"><strong>W-SAMAR</strong></td>
                    </tr>
                    <?php for($i=1;$i<3;$i++): ?>
                        <?php
                            if($i == 1){
                                $dis = '1st';
                            }elseif($i == 2){
                                $dis = '2nd';
                            }
                        ?>
                        <tr class="wsamar">
                            <td><?php echo e($dis); ?></td>
                            <td><?php echo e($final['WSN'.$i]); ?></td>
                            <td><?php echo e($final['WSO'.$i]); ?></td>
                        </tr>
                    <?php endfor; ?>
                    <tr class="esamar">
                        <td colspan="3" class="text-center"><strong>E-SAMAR</strong></td>
                    </tr>
                    <?php for($i=1;$i<3;$i++): ?>
                        <?php
                            if($i == 1){
                                $dis = '1st';
                            }elseif($i == 2){
                                $dis = '2nd';
                            }
                        ?>
                        <tr class="esamar">
                            <td><?php echo e($dis); ?></td>
                            <td><?php echo e($final['ESN'.$i]); ?></td>
                            <td><?php echo e($final['ESO'.$i]); ?></td>
                        </tr>
                    <?php endfor; ?>
                    <tr class="nsamar">
                        <td colspan="3" class="text-center"><strong>N-SAMAR</strong></td>
                    </tr>
                    <?php for($i=1;$i<3;$i++): ?>
                        <?php
                            if($i == 1){
                                $dis = '1st';
                            }elseif($i == 2){
                                $dis = '2nd';
                            }
                        ?>
                        <tr class="nsamar">
                            <td><?php echo e($dis); ?></td>
                            <td><?php echo e($final['NSN'.$i]); ?></td>
                            <td><?php echo e($final['NSO'.$i]); ?></td>
                        </tr>
                    <?php endfor; ?>
                    <tr class="sleyte">
                        <td colspan="3" class="text-center"><strong>S-LEYTE</strong></td>
                    </tr>
                    <?php for($i=1;$i<3;$i++): ?>
                        <?php
                            if($i == 1){
                                $dis = '1st';
                            }elseif($i == 2){
                                $dis = '2nd';
                            }
                        ?>
                        <tr class="sleyte">
                            <td><?php echo e($dis); ?></td>
                            <td><?php echo e($final['SLN'.$i]); ?></td>
                            <td><?php echo e($final['SLO'.$i]); ?></td>
                        </tr>
                    <?php endfor; ?>
                    <tr class="biliran">
                        <td colspan="3" class="text-center"><strong>BILIRAN</strong></td>
                    </tr>
                    <?php for($i=1;$i<3;$i++): ?>
                        <?php
                            if($i == 1){
                                $dis = '1st';
                            }elseif($i == 2){
                                $dis = '2nd';
                            }
                        ?>
                        <tr class="biliran">
                            <td><?php echo e($dis); ?></td>
                            <td><?php echo e($final['BN'.$i]); ?></td>
                            <td><?php echo e($final['BO'.$i]); ?></td>
                        </tr>
                    <?php endfor; ?>
                    <tr class="totalSum">
                        <td>TOTAL</td>
                        <td><?php echo e($new); ?></td>
                        <td><?php echo e($old); ?></td>
                    </tr>
                    <tr class="totalSum">
                        <td>GRAND TOTAL</td>
                        <td colspan="2" class="text-center"><?php echo e($new + $old); ?></td>
                    </tr>

                    
                    </tbody>
                </table>
            </div>

            </div>


                    <?php else: ?>
                        <hr>
                        <?php if(!$starting): ?>
                            <h4 class="text-center text-danger">Please select a date to be retrieve. <i class="fa fa-calendar"></i></h4>
                        <?php else: ?>
                            <h4 class="text-center text-danger">No results found <i class="fa fa-exclamation"></i></h4>
                        <?php endif; ?>
                        <hr>
                    <?php endif; ?>


            <?php if($final): ?>
            <div class="col-md-4">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <th></th>
                            <th>NEW</th>
                            <th>OLD</th>
                            <th>TOTAL</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>SENIOR CITIZEN</td>
                                <td><?php echo e($csn); ?></td>
                                <td><?php echo e($cso); ?></td>
                                <td><strong class="text-danger"><?php echo e($csn + $cso); ?></strong></td>
                            </tr>
                            <tr>
                                <td>GERIA</td>
                                <td><?php echo e($geriaN); ?></td>
                                <td><?php echo e($geriaO); ?></td>
                                <td><strong class="text-danger"><?php echo e($geriaN + $geriaO); ?></strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
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
    <script src="<?php echo e(asset('public/plugins/js/jquery-ui.min.js')); ?>"></script>
    <script>
        $( function() {
            $( ".datepicker" ).datepicker({
                dateFormat: 'yy-mm-dd'
            });
        });
    </script>
    
<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>