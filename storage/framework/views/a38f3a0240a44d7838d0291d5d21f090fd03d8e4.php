<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPD | ANCILLARY
    <?php $__env->endSlot(); ?>

<?php $__env->startSection('pagestyle'); ?>
    <link href="<?php echo e(asset('public/css/doctors/reset.css')); ?>" rel="stylesheet" />
    <?php if(Auth::user()->theme == 2): ?>
        <link href="<?php echo e(asset('public/css/doctors/darkstyle.css')); ?>" rel="stylesheet" />
    <?php else: ?>
        <link href="<?php echo e(asset('public/css/doctors/greenstyle.css')); ?>" rel="stylesheet" />
    <?php endif; ?>
     <link href="<?php echo e(asset('public/css/ancillary/transaction.css')); ?>" rel="stylesheet" />
     <link href="<?php echo e(asset('public/plugins/css/dataTables.bootstrap.min.css')); ?>" rel="stylesheet" />

<?php $__env->stopSection(); ?>



<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('ancillary.navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('ancillary/dashboard'); ?>
        <?php $__env->startSection('main-content'); ?>


            <div class="content-wrapper">
                <br>
                <br>
                <div class="banner">
                    <h3>TRANSACTION LIST<i>(PAID)</i></h3>
                </div>
                <div class="col-md-12 sortingresult">
                    <form method="GET" >
                        <div class="col-md-3 col-md-offset-4">
                            FROM
                            <input type="date" name="from" class="form-control">
                        </div>
                        <div class="col-md-3">
                            TO
                            <input type="date" name="to" class="form-control">
                        </div>
                        <div class="col-md-2 text-center">
                            <br>
                            <button type="submit" class="btn btn-default" onclick="$(this).css('cursor', 'wait')"> Search <span class="fa fa-search"></span></button>
                        </div>
                    </form>
                    
                </div>
                <br>
                <br>
                <div class="table table-responsive">
                   <table class="table table-striped table-bordered" id="requestbygroup">
                    <thead>
                        <tr class="success">
                            <th hidden></th>
                           <th>CLASSIFICATION & OR</th>
                           <th>PATIENT</th>
                           <th>RENDERED BY</th>
                           <th>RENDERED DATE/TIME</th>
                           <th style="text-align: center;">EDIT</th>
                           <th style="text-align: center;">CANCEL</th>
                           <th style="text-align: center;">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td hidden></td>
                            <?php if($list->label): ?>
                                <?php if(is_numeric($list->description) && $list->discount != '1'): ?>
                                <td align="center" class="success"><?php echo e($list->label.' '.$list->description.'% - '.$list->or_no); ?></td>
                                <?php else: ?>
                                <td align="center" class="info"><?php echo e($list->label.'-'.$list->description); ?></td>
                                <?php endif; ?>
                            <?php else: ?>
                                <td align="center" class="danger">NOT CLASSIFIED - <?php echo e($list->or_no); ?></td>
                            <?php endif; ?>
                            
                            
                            <td><?php echo e($list->last_name.', '.$list->first_name.' '.substr($list->middle_name,0,1)); ?></td>
                            <td><?php echo e($list->users); ?></td>
                            <td align="center"><?php echo e(Carbon::parse($list->created_at)->format('m/d/Y g:ia')); ?></td>
                           

                            <?php if($list->id >=9 && $list->id <= 13): ?>
                            
                            <td align="center">
                                <a href="<?php echo e(url('viewpaidrequisition/'.$list->or_no.'/'.$list->patient_id.'')); ?>" class="btn btn-default btn-sm" onclick="$(this).css('cursor', 'wait')"><span class="fa fa-eye"></span> EDIT </a>
                            </td>
                            <?php else: ?>
                            <td align="center">
                                <a href="#" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="PAID IN CASHIER, CANNOT BE EDIT" disabled><span class="fa fa-eye"></span> EDIT </a>
                            </td>
                            <?php endif; ?>

                            <?php if($list->id >=9 && $list->id <= 13): ?>
                            <td align="center"><a href="<?php echo e(url('removepaidrequisition/'.$list->or_no.'')); ?>" class="btn btn-default btn-sm" onclick="$(this).css('cursor', 'wait')"><span class="fa fa-remove"></span> CANCEL </a></td>
                            <?php else: ?>
                            <td align="center"><a href="#" class="btn btn-default btn-sm" disabled data-toggle="tooltip" data-placement="top" title="PAID IN CASHIER, CANNOT BE CANCEL"> CANCEL <span class="fa fa-remove"></span></a></td>
                            <?php endif; ?>
                            <td align="center"><a href="<?php echo e(url('maskasdonerequistion/'.$list->or_no.'/'.$list->patient_id.'')); ?>" class="btn btn-default btn-sm" onclick="$(this).css('cursor', 'wait')"> <i class="fa fa-info"></i> VIEW </a></td>
                        </tr>
                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        
                        
                    </tbody>
                   </table> 
                </div>
            </div> 
            <!-- .content-wrapper -->

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
    <script src="<?php echo e(asset('public/js/pharmacy/main.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/dataTables.bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/ancillary/transaction.js')); ?>"></script>
<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>
