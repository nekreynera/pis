<?php if(in_array(Auth::user()->clinic, $chrgingClinics)): ?>
    <td align="center">

        <?php
            $undoneItems = App\Cashincome::getAllUndonedItems($patient->id);
            $allServiceDone = (count($undoneItems) > 0)? '' : 'disabled';
        ?>




            <div class="btn-group">
                <a href="#" class="btn btn-info <?php if(Request::is('rcptnLogs/*/*/*')): ?> disabled <?php endif; ?>)"
                   onclick="chargeuser($(this))" data-id="<?php echo e($patient->id); ?>"
                   data-placement="top" data-toggle="tooltip" title="Proceed to charging">
                    &#8369;
                </a>
                <button type="button" class="btn btn-primary dropdown-toggle <?php echo e($allServiceDone); ?>" data-toggle="dropdown">
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu dropdown-menu-right" role="menu">
                    <?php $__currentLoopData = $undoneItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="<?php echo e(($row->get == 'N')? 'bg-success' : 'bg-danger'); ?>">
                            <?php if($row->get == 'N'): ?>
                                <a href="<?php echo e(url('done/'.$row->id.'/Y')); ?>" data-placement="left" data-toggle="tooltip" title="Click to Done this service">
                                    <i class="fa fa-check text-success"></i> &nbsp; <?php echo $row->sub_category.' | <label class="label label-default">'.Carbon::parse($row->created_at)->toDateString().'</label>'; ?>

                                </a>
                            <?php else: ?>
                                <a href="<?php echo e(url('done/'.$row->id.'/N')); ?>" data-placement="left" data-toggle="tooltip" title="Click to Revert this service">
                                    <i class="fa fa-refresh text-danger"></i> &nbsp; <?php echo $row->sub_category.' | <label class="label label-default">'.Carbon::parse($row->created_at)->toDateString().'</label>'; ?>

                                </a>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>




        <?php if(in_array(Auth::user()->clinic, $chrgingClinics)): ?>
            <?php if(count($charging) > 0): ?>
                <?php $__currentLoopData = $charging; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($row->request > 0): ?>
                        <label class="label label-primary"
                               data-placement="top" data-toggle="tooltip" title="Requests"><?php echo $row->request; ?></label>
                        <label class="label <?php echo e(($row->paid == 0)? 'label-danger' : 'label-success'); ?>"
                               data-placement="top" data-toggle="tooltip" title="Paid"><?php echo $row->paid; ?></label>
                        
                    <?php else: ?>
                        <label class="label label-danger">No Pending Request</label>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <label class="label label-danger" data-placement="top" data-toggle="tooltip" title="Requests">No Pending Request</label>
            <?php endif; ?>
        <?php endif; ?>




        <?php if(Request::is('overview')): ?>
        <form id="charging<?php echo e($patient->id); ?>" action="<?php echo e(url('scandirect')); ?>" method="POST" style="display: none;">
            <?php echo e(csrf_field()); ?>

            <input type="hidden" name="barcode" value="<?php echo e($patient->barcode); ?>">
        </form>
        <?php endif; ?>


    </td>
<?php endif; ?>