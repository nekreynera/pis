<td>
    <?php
        $checkIfForRefferal = App\Refferal::checkIfForRefferal($patient->pid);
    ?>
    <?php if($checkIfForRefferal > 0): ?>
        <a href='<?php echo e(url("patientinfo/$patient->pid")); ?>' class="btn btn-info btn-circle" title="Patient Information">
            <i class="fa fa-user-o"></i>
        </a>
    <?php else: ?>
        <a href='<?php echo e(url("patientinfo/$patient->pid")); ?>' class="btn btn-default btn-circle" title="Patient Information">
            <i class="fa fa-user-o text-primary"></i>
        </a>
    <?php endif; ?>

    <?php if($refferal > 0): ?>
        <span class="notifyBadgeNumber badge"><?php echo e($refferal); ?></span>
    <?php endif; ?>
    <?php if($followups > 0): ?>
        <span class="notifyFollowUpBadgeNumber badge"><?php echo e($followups); ?></span>
    <?php endif; ?>

</td>
