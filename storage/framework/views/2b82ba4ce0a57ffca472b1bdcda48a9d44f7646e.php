<div id="notification" class="modal" role="dialog">
    <div class="modal-dialog modal-xxl">

        <!-- Modal content-->
        <div class="modal-content">
            
            <div class="modal-body">

                <?php if(((count($refferals) + count($followups)) > 0)): ?>
                <div class="row">

                    <?php if(count($refferals) > 0): ?>
                    <div class="col-md-12">
                            <br>
                                <br>
                                <div class="table-responsive">
                                    <p class="text-danger text-center hidden-xs">
                                        <strong>This patient has a pending <b style="color: red;font-size: 25px">Referral</b> to this clinic.</strong>
                                    </p>
                                    <br>
                                    <p class="text-danger text-center visible-xs">
                                         This patient has a pending <b style="color: red;">Referral</b> to this clinic.
                                    </p>
                                    <br>
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>PATIENT</th>
                                            <th>FROM_CLINIC</th>
                                            <th>REFFERED_BY</th>
                                            <th>TO_CLINIC</th>
                                            <th>REFFERED_TO</th>
                                            <th>REASON</th>
                                            <th>STATUS</th>
                                            <th>DATE</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <?php if(count($refferals)): ?>
                                            <?php $__currentLoopData = $refferals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $refferal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($refferal->name); ?></td>
                                                    <td><?php echo e(($refferal->fromClinic)? $refferal->fromClinic : 'N/A'); ?></td>
                                                    <td><?php echo e(($refferal->fromDoctor)? 'Dr. '.$refferal->fromDoctor : 'N/A'); ?></td>
                                                    <td><?php echo e(($refferal->toClinic)? $refferal->toClinic : 'N/A'); ?></td>
                                                    <td><?php echo e(($refferal->toDoctor)? $refferal->toDoctor : 'Unassigned'); ?></td>
                                                    <td><?php echo e(($refferal->reason)? $refferal->reason : 'N/A'); ?></td>
                                                    <td><?php echo ($refferal->status == 'P')? '<span class="text-danger">Pending</span>' : '<span class="text-success">Finished</span>'; ?></td>
                                                    <td><?php echo e(Carbon::parse($refferal->created_at)->toFormattedDateString()); ?></td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="5" class="text-center">
                                                    <strong class="text-danger">
                                                        NO REFFERALS FOUND.
                                                    </strong>
                                                </td>
                                            </tr>
                                        <?php endif; ?>

                                        </tbody>

                                    </table>

                                </div>
                    </div>

                    <?php endif; ?>





                    <?php if(count($followups) > 0): ?>
                    <div class="col-md-12">

                            <hr>
                            <div class="table-responsive">
                                <p class="text-danger text-center hidden-xs">
                                    <strong>This patient has a pending <b style="color: red;font-size: 25px">Follow-Up</b>  to this clinic.</strong>
                                </p>
                                <br>
                                <p class="text-danger text-center visible-xs">
                                     This patient has a pending <b style="color: red;">Follow-Up</b> to this clinic.
                                </p>
                                <br>
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>TO_DOCTOR</th>
                                        <th>CLINIC</th>
                                        <th>REASON</th>
                                        <th>FF_DATE</th>
                                        <th>STATUS</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(count($followups) > 0): ?>
                                        <?php $__currentLoopData = $followups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $followup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e((!empty($followup->doctorsname))? $followup->doctorsname : 'N/A'); ?></td>
                                                <td><?php echo e($followup->name); ?></td>
                                                <td><?php echo e($followup->reason); ?></td>
                                                <td><?php echo e(Carbon::parse($followup->followupdate)->toFormattedDateString()); ?></td>
                                                <td><?php echo ($followup->status == 'P')? '<span class="text-danger">Pending</span>' : '<span class="text-success">Finished</span>'; ?></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center">
                                                <strong class="text-danger">
                                                    NO FOLLOW-UP FOUND.
                                                </strong>
                                            </td>
                                        </tr>
                                    <?php endif; ?>

                                    </tbody>
                                </table>
                            </div>
                    </div>
                        <?php endif; ?>


                </div>


                <?php else: ?>
                    <h3 class="text-center text-danger"><b>NO NOTIFICATIONS TO BE DISPLAYED <i class="fa fa-exclamation"></i></b></h3>
                <?php endif; ?>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
