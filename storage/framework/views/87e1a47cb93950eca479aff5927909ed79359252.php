<?php if(in_array(Auth::user()->clinic, $noDoctorsClinic)): ?>

    <td>

        <?php if($patient->queue_status == 'F'): ?>



                <a href="<?php echo e(url('queueStatus/'.$patient->qid.'/P')); ?>"
                   data-placement="top" data-toggle="tooltip" title="Click to revert"
                   class="btn btn-warning btn-circle" data-toggle=""
                   onclick="return confirm('Do you really want to revert this patient?')">
                    <i class="fa fa-refresh"></i>
                </a>

        <?php else: ?>

                <a href="<?php echo e(url('queueStatus/'.$patient->qid.'/F')); ?>"
                   data-placement="top" data-toggle="tooltip" title="Click to mark as done"
                   class="btn btn-circle btn-primary"
                   onclick="return confirm('Do you really want to marked this patient as done?')">
                    <i class="fa fa-check"></i>
                </a>


        <?php endif; ?>

    </td>

<?php endif; ?>