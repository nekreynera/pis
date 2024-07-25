<td>
    <?php if($patient->cid == null): ?>
        <button class="btn btn-default btn-circle" onclick="medicalRecords(<?php echo e($patient->id); ?>)" title="View medical record's">
            <i class="fa fa-file-text-o text-primary"></i>
        </button>
    <?php else: ?>
        <button class="btn btn-primary btn-circle" onclick="medicalRecords(<?php echo e($patient->id); ?>)" title="View medical record's">
            <i class="fa fa-file-text-o text-default"></i>
        </button>
    <?php endif; ?>
</td>

<td>
    <?php echo e(Carbon::parse($patient->created_at)->toDayDateTimeString()); ?>

</td>