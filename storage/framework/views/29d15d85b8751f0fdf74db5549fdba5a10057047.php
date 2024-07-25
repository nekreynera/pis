<td>
    <div class="dropdown">
        <a href="" class="btn btn-default btn-circle dropdown-toggle" <?php echo (empty($asgn))? 'data-toggle="dropdown"' : $asgn; ?>>
            <i class="fa fa-arrow-left text-success"></i>
        </a>
        <ul class="dropdown-menu dropdown-menu-right">
            <li class="dropdown-header">--Assign to Doctor--</li>
            <?php if(count($allDoctors) > 0): ?>
                <?php $__currentLoopData = $allDoctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allDoctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $checkAssigned = (in_array($allDoctor->id, $assignedDoctor))? '#adebad' : '';
                    ?>
                    <?php if(App\User::isActive($allDoctor->id)): ?>
                    <li>
                        <a href='<?php echo e(url("assign/$patient->id/$allDoctor->id")); ?>' style="background-color: <?php echo $checkAssigned; ?>">
                            <?php echo "<div class='online'></div> <span class='text-uppercase'>Dr. $allDoctor->name</span>"; ?>

                        </a>
                    </li>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </ul>
    </div>
</td>