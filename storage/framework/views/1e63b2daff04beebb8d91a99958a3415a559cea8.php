<td class="text-center">
    <?php if($patient->pcid): ?>
        <button class="btn btn-primary btn-circle" onclick="medicalRecords(<?php echo e($patient->pid); ?>)" title="View medical record's">
            <i class="fa fa-file-text-o text-default"></i>
        </button>


        <!-- smoke -->
        <?php if($patient->smoke): ?>
            <i class="fa fa-fire text-danger" title="Advised with smoke cessation"></i>
        <?php endif; ?>


    <?php else: ?>
        <button class="btn btn-default btn-circle" onclick="medicalRecords(<?php echo e($patient->pid); ?>)" title="View medical record's">
            <i class="fa fa-file-text-o text-primary"></i>
        </button>
    <?php endif; ?>
</td>




<td>
    <?php echo e(Carbon::parse($patient->created_at)->format('h:i:s a')); ?>

</td>