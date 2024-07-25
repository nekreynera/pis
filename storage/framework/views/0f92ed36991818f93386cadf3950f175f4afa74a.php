<td>
    <?php echo e($loop->index + 1); ?>

</td>
<td>
    <span><?php echo e($approval->name); ?></span>
</td>
<td>
    <?php echo e(App\Patient::age($approval->birthday)); ?>

</td>
<td>
    <span><?php echo e($approval->doctorsname); ?></span>
</td>
<td class="text-center">
    <a href="<?php echo e(url('patientinfo/'.$approval->pid)); ?>" class="btn btn-circle btn-default"
       data-placement="top" data-toggle="tooltip" title="Patient's information">
        <i class="fa fa-user-o text-primary"></i>
    </a>
</td>