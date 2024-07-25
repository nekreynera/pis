<td>
    <?php
        $checkIfForRefferal = App\Refferal::checkIfForRefferal($patient->id);
    ?>
    <?php if($checkIfForRefferal > 0): ?>
        <a href='<?php echo e(url("patient_info/$patient->id")); ?>' class="btn btn-info btn-circle">
            <i class="fa fa-user-o"></i>
        </a>
    <?php else: ?>
        <a href='<?php echo e(url("patient_info/$patient->id")); ?>' class="btn btn-default btn-circle">
            <i class="fa fa-user-o text-primary"></i>
        </a>
    <?php endif; ?>

    <?php if($patient->rf > 0): ?>
        <span class="notifyBadgeNumber badge"><?php echo e($patient->rf); ?></span>
    <?php endif; ?>
    <?php if($patient->ff > 0): ?>
        <span class="notifyFollowUpBadgeNumber badge"><?php echo e($patient->ff); ?></span>
    <?php endif; ?>
</td>