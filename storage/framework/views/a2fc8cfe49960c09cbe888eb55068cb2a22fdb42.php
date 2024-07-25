<td hidden>
    <?php echo e($loop->index + 1); ?>

</td>
<td class="<?php echo e($status); ?>">
    <?php echo e(count($patients) - $loop->index); ?>

</td>
<td><?php echo e($patient->name); ?></td>
<?php
    $agePatient = App\Patient::age($patient->birthday)
?>
<td><?php echo ($agePatient >= 60)? '<strong style="color: red">'.$agePatient.'</strong>' : '<span class="text-default">'.$agePatient.'</span>'; ?></td>

<td>
    <?php if($patient->status != null): ?>
        <?php if(App\User::isActive($patient->doctors_id)): ?>
            <?php echo "<div class='online'></div> <span class='text-default'>Dr. $patient->doctorsname</span>"; ?>

        <?php else: ?>
            <?php echo "<div class='offline'></div> <span class='text-default'>Dr. $patient->doctorsname</span>"; ?>

        <?php endif; ?>
    <?php else: ?>
        <span class="text-danger">N/A</span>
    <?php endif; ?>
</td>

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