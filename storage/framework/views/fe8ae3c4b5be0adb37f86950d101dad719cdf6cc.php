<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPD | ANCILLARY
    <?php $__env->endSlot(); ?>

<?php $__env->startSection('pagestyle'); ?>
    <link href="<?php echo e(asset('public/css/ancillary/census.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/plugins/css/dataTables.bootstrap.min.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>



<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('receptions/navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>


            <div class="container">
                <div class="col-md-12">
                    <br>
                    <form class="form-inline text-right" method="GET">
                        <div class="form-group">
                            <label>FILTER </label>
                            <select class="form-control" name="top" required>
                                <option value="" hidden>CHOOSE</option>
                                <?php if(isset($_GET['top'])): ?>
                                <option value="10"  <?php if($_GET['top'] == '10'): ?> selected <?php endif; ?>>TOP 10</option>
                                <option value="20"  <?php if($_GET['top'] == '20'): ?> selected <?php endif; ?>>TOP 20</option>
                                <option value="30"  <?php if($_GET['top'] == '30'): ?> selected <?php endif; ?>>TOP 30</option>
                                <option value="ALL" <?php if($_GET['top'] == 'ALL'): ?> selected <?php endif; ?>>ALL</option>
                                <?php else: ?>
                                <option value="10">TOP 10</option>
                                <option value="20">TOP 20</option>
                                <option value="30">TOP 30</option>
                                <option value="ALL">ALL</option>
                                <?php endif; ?>
                            </select>
                        </div>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <div class="form-group">
                            <label>FROM </label>
                            <div class="input-group">
                                <input type="date" name="from" class="form-control" <?php if(isset($_GET['to'])): ?> value="<?php echo e($_GET['from']); ?>" <?php endif; ?> required>
                                <span class="input-group-addon fa fa-calendar"></span>
                            </div>
                        </div>
                         &nbsp;&nbsp;&nbsp;&nbsp;<span class="fa fa-arrow-right"></span> &nbsp;&nbsp;&nbsp;&nbsp;
                        <div class="form-group">
                            <label>TO </label>
                            <div class="input-group">
                                <input type="date" name="to" class="form-control" <?php if(isset($_GET['to'])): ?> value="<?php echo e($_GET['to']); ?>" <?php endif; ?> required>
                                <span class="input-group-addon fa fa-calendar"></span>
                            </div>
                        </div>
                         &nbsp;&nbsp;&nbsp;&nbsp;
                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-sm"> SUBMIT <span class="fa fa-cog"></span></button>
                        </div>
                    </form>
                </div>
                <div class="col-md-12">
                    <br><br>
                    <?php if(isset($_GET['from'])): ?>
                    <label>TOTAL NUMBER OF PATIENT PER SERVICES - DATE: <?php echo e(Carbon::parse($_GET['from'])->format('M-d-Y').' to '.Carbon::parse($_GET['to'])->format('M-d-Y')); ?></label>
                     <?php endif; ?>
                </div>
                <div class="col-md-12">
                    <div class="table-responsive" id="rankindiv">
                        <table class="table table-bordered table-stripped">
                            <thead>
                                
                                <tr>
                                    <th>RANKING</th>
                                    <th>PARTICULAR</th>
                                    <th>FEMALE</th>
                                    <th>MALE</th>
                                    <th>TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $l = 1;
                                $total = 0;
                                $female = 0;
                                $male = 0;
                                ?>

                                <?php if(count($census) > 0): ?>
                                <?php $__currentLoopData = $census; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td align="center"><?php echo e($l); ?></td>
                                    <td><?php echo e($list->sub_category); ?></td>
                                    <td align="center" class=""><?php echo e($list->female); ?></td>
                                    <td align="center" class=""><?php echo e($list->male); ?></td>
                                    <td align="center" class=""><?php if(Auth::user()->clinic == "3"): ?> <?php echo e($list->person); ?> <?php else: ?> <?php echo e($list->result); ?> <?php endif; ?></td>

                                </tr>

                                <?php

                                $l++;

                                $female += $list->female;
                                $male += $list->male;

                                if(Auth::user()->clinic == "3"):
                                $total += $list->person;
                                else:
                                $total += $list->result;
                                endif;
                                
                                ?>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <?php
                                $m = 0; 
                                $f = 0; 
                                ?>

                                <?php if(Auth::user()->clinic == "3"): ?>
                                    <?php $__currentLoopData = $consultation; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($list->sex == "M"): ?>
                                                <?php
                                                    $m++
                                                ?>
                                            <?php endif; ?>
                                            <?php if($list->sex == "F"): ?>
                                                <?php
                                                    $f++
                                                ?>
                                            <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td colspan="5" class=""></td>
                                       
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="success text-right"><b>TOTAL SERVICES:</b></td>
                                        <td align="center" class="success"><b><?php echo e($female); ?></b></td>
                                        <td align="center" class="success"><b><?php echo e($male); ?></b></td>
                                        <td align="center" class="success"><b><?php echo e($total); ?></b></td>
                                    </tr>
                                     <tr>
                                        <td colspan="5" class=""></td>
                                      
                                    </tr>
                                     <tr>
                                        <td colspan="2" class="success text-right">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<b>TOTAL CONSULTATION:</b></td>
                                        <td align="center" class="success"><b><?php echo e($f - $female); ?></b></td>
                                        <td align="center" class="success"><b><?php echo e($m - $male); ?></b></td>
                                        <td align="center" class="success"><b><?php echo e(count($consultation) - $total); ?></b></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class=""></td>
                                      
                                    </tr>
                                    <tr>
                                        <th colspan="2" style="text-align: right;">GRAND TOTAL:</th>
                                        <th><?php echo e($female + ($f - $female)); ?></th>
                                        <th><?php echo e($male + ($m - $male)); ?></th>
                                        <th><?php echo e(count($consultation)); ?></th>
                                    </tr>
                                <?php else: ?>
                                    <tr>
                                        <th colspan="2" style="text-align: right;">GRAND TOTAL:</th>
                                        <th colspan=""><?php echo e($female); ?></th>
                                        <th colspan=""><?php echo e($male); ?></th>
                                        <th colspan=""><?php echo e($total); ?></th>
                                    </tr>
                                <?php endif; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="default" align="center" >NO RESULT FOUND</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

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
