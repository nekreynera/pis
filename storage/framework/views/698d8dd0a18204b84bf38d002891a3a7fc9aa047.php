<td class="<?php echo e($status); ?>">
    <?php echo e($loop->index + 1); ?>

</td>
<td>
    <?php echo e($patient->name); ?>

</td>
<td>
    <?php
        $agePatient = App\Patient::age($patient->birthday);
    ?>
    <?php echo ($agePatient > 59)? '<strong style="color:red">'.$agePatient.'</strong>' : $agePatient; ?>

</td>