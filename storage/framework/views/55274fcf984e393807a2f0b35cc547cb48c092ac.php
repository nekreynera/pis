<?php if($intern): ?>
    <td>
        <div class="dropdown">
            <?php
                $approvalStatus = App\Approval::checkApprovalStatus($patient->pid);
                if ($approvalStatus){
                    if ($approvalStatus->approved == 'N'){
                          $apprvltatus = '<span class="text-danger">Declined</span>';
                    }elseif ($approvalStatus->approved == 'Y'){
                          $apprvltatus = '<span class="text-success">Approved</span>';
                    }else{
                          $apprvltatus = '<span class="text-info">Pending</span>';
                    }
                }else{
                      $apprvltatus = '<span class="text-warning">For Approval</span>';
                }
            ?>
            <?php echo $apprvltatus; ?>

            <a href="" class="btn btn-default btn-circle dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-arrow-right text-success"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-right">
                <li class="dropdown-header">--Approving Doctor--</li>
                <?php if(count($allDoctors) > 0): ?>
                    <?php $__currentLoopData = $allDoctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allDoctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($allDoctor->id != Auth::user()->id): ?>
                            <?php
                                if ($approvalStatus){
                                    $checkStst = ($allDoctor->id == $approvalStatus->approved_by)? 'class="disabled" onclick="return false"' : '';
                                }else{
                                    $checkStst = '';
                                }
                            ?>
                            <li <?php echo $checkStst; ?>>
                                <a href='<?php echo e(url("approval/$patient->pid/$allDoctor->id")); ?>'>
                                    <div class='<?php if(App\User::isActive($allDoctor->id)): ?> online <?php else: ?> offline <?php endif; ?>'></div> <span class='text-default'>Dr. <?php echo e(ucwords(strtolower($allDoctor->name))); ?></span>
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </ul>
        </div>
    </td>
<?php endif; ?>