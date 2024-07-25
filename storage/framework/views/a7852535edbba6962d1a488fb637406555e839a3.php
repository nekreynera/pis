<td class="text-center">
    <?php if($patient->status == 'P'): ?>
        <a href="<?php echo e(url('cancelPatient/'.$patient->id)); ?>" class="btn btn-default btn-circle"
           onclick="return confirm('Cancel this patient?')" title="This patient was not around when called.">
            <i class="fa fa-remove text-danger"></i>
        </a>
    <?php elseif($patient->status == 'C'): ?>
        <a href="<?php echo e(url('restorePatient/'.$patient->id)); ?>" class="btn btn-default btn-circle"
           onclick="return confirm('Restore this patient?')" title="Restore this patient">
            <i class="fa fa-arrow-left text-success"></i>
        </a>
    <?php elseif($patient->status == 'S'): ?>
        <a href="<?php echo e(url('pausePatient/'.$patient->id)); ?>" class="btn btn-default btn-circle"
           onclick="return confirm('Pause the consultation of this patient?')" title="Pause Consultation">
            <i class="fa fa-pause text-warning"></i>
        </a>
    <?php elseif($patient->status == 'F'): ?>
        <a href="<?php echo e(url('reConsult/'.$patient->id)); ?>" class="btn btn-default btn-circle"
           onclick="return confirm('Re-Consult this patient?')" title="Re-Consult this patient">
            <i class="fa fa-recycle text-success"></i>
        </a>
    <?php elseif($patient->status == 'H'): ?>
        <a href="<?php echo e(url('continueServing/'.$patient->id)); ?>" class="btn btn-default btn-circle"
           onclick="return confirm('Continue the consultation of this patient?')" title="Serve this patient">
            <i class="fa fa-stethoscope text-info"></i>
        </a>
    <?php endif; ?>
</td>