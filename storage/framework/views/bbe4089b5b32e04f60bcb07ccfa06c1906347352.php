<tr>
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
    <td>
        <a href="<?php echo e(url('patientinfo/'.$patient->pid)); ?>" class="btn btn-circle btn-default"
           data-placement="top" data-toggle="tooltip" title="Patient's information">
            <i class="fa fa-user-o text-primary"></i>
        </a>
        <?php if($totalNotification > 0): ?>
            <span class="notifyBadge badge"><?php echo e($totalNotification); ?></span>
        <?php endif; ?>
    </td>
    <td class="text-center">
        <?php if($patient->pcid): ?>
            <button class="btn btn-primary btn-sm btn-circle"
                    onclick="medicalRecords(<?php echo e($patient->pid); ?>)" title="View medical record's">
                <i class="fa fa-file-text-o"></i>
            </button>
        <?php else: ?>
            <button class="btn btn-default btn-sm btn-circle"
                    onclick="medicalRecords(<?php echo e($patient->pid); ?>)" title="View medical record's">
                <i class="fa fa-file-text-o text-primary"></i>
            </button>
        <?php endif; ?>
    </td>
    <td>
        <p class="<?php echo e($statusColor); ?>"><?php echo e(strtoupper($status)); ?></p>
    </td>
    <td>
        <?php echo e(Carbon::parse($patient->updated_at)->toDayDateTimeString()); ?>

    </td>
</tr>