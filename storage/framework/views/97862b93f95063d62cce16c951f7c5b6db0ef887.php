<td hidden>
    <?php echo e($loop->index + 1); ?>

</td>

<?php if(in_array(Auth::user()->clinic, $noDoctorsClinic)): ?>
    <?php
        if ($patient->queue_status == 'C'){
            $queueStatus = 'nawc';
        }elseif ($patient->queue_status == 'F'){
            $queueStatus = 'finished';
        }elseif ($patient->queue_status == 'D'){
            $queueStatus = 'serving';
        }else{
            $queueStatus = 'pending';
        }
    ?>
    <td class="<?php echo e($queueStatus); ?>">
        <?php echo e($loop->index + 1); ?>

    </td>
<?php else: ?>
    <td class="<?php echo e($status); ?>">
        <?php echo e($loop->index + 1); ?>

    </td>
<?php endif; ?>

<td><?php echo e($patient->name); ?></td>
<?php
    $agePatient = App\Patient::age($patient->birthday)
?>
<td><?php echo ($agePatient >= 60)? '<strong style="color: red">'.$agePatient.'</strong>' : '<span class="text-default">'.$agePatient.'</span>'; ?></td>





<?php if(Auth::user()->clinic != 31): ?>
    <td>
        <?php if($patient->status == 'S' || $patient->status == 'P' || $patient->status == 'F' || $patient->status == 'H'): ?>
            <?php if(App\User::isActive($patient->doctors_id)): ?>
                <?php echo "<div class='online'></div> <span class='text-default'>Dr. $patient->doctorsname</span>"; ?>

            <?php else: ?>
                <?php echo "<div class='offline'></div> <span class='text-default'>Dr. $patient->doctorsname</span>"; ?>

            <?php endif; ?>
        <?php else: ?>
            <span class="text-danger">N/A</span>
        <?php endif; ?>
    </td>
<?php endif; ?>