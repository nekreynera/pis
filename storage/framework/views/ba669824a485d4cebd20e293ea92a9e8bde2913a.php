<td>
    <div class="dropdown">
        <a href="" class="btn btn-default btn-circle dropdown-toggle" <?php echo (empty($reasgn))? 'data-toggle="dropdown"' : $reasgn; ?> >
            <i class="fa fa-refresh text-primary"></i>
        </a>
        <ul class="dropdown-menu dropdown-menu-right">
            <li class="dropdown-header">-- Re-assign to Doctor --</li>
            <?php if(count($allDoctors) > 0): ?>
                <?php $__currentLoopData = $allDoctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allDoctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $checkAssigned = (in_array($allDoctor->id, $assignedDoctor))? '#adebad' : '';
                    ?>
                    <?php if(App\User::isActive($allDoctor->id)): ?>
                    <li class="<?php echo e(($allDoctor->id == $patient->doctors_id)? 'disabled' : ''); ?>">
                        <a href='<?php echo e(url("reassign/$allDoctor->id/$patient->asgnid")); ?>' style="background-color: <?php echo $checkAssigned; ?>" <?php echo ($allDoctor->id == $patient->doctors_id)? 'onclick="return false"' : 'onclick="return confirm('."'Re-assign this patient?'".')"'; ?>>
                            <?php echo "<div class='online'></div> <span class='text-uppercase'>Dr. $allDoctor->name</span>"; ?>

                        </a>
                    </li>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </ul>
    </div>
</td>