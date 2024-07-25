<td>
<?php if($patient->pid == Session::get('pid') && $patient->status == 'S'): ?>
    <a href="<?php echo e(url('endConsultation')); ?>" class="btn btn-success btn-sm"
     title="Click to end this patient's consultation">
        END CONSULTATION
    </a>
<?php elseif($patient->status == 'H'): ?>
    <a href="<?php echo e(url('cancelPatient/'.$patient->id)); ?>" class="btn btn-danger btn-sm"
       onclick="return confirm('Stop this patients consultation?')"
       title="Click to stop this patient's consultation">
        STOP CONSULTATION
    </a>
<?php else: ?>
    <?php if($status != 'finished' && $status != 'nawc' && $patient->status != 'H'): ?>
        <a href="<?php echo e(url('startConsultation/'.$patient->pid)); ?>" class="btn btn-warning btn-sm"
           <?php echo (Session::has('pid'))? 'disabled onclick="return false"' : ''; ?>

           title="Click to start patient consultation">
            START CONSULTATION
        </a>
    <?php elseif($status == 'finished'): ?>
        
    <?php endif; ?>
<?php endif; ?>    
</td>
