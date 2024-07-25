<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPD | Refferal
    <?php $__env->endSlot(); ?>

<?php $__env->startSection('pagestyle'); ?>
    <link href="<?php echo e(asset('public/css/doctors/reset.css')); ?>" rel="stylesheet" />
    <?php if(Auth::user()->theme == 2): ?>
        <link href="<?php echo e(asset('public/css/doctors/darkstyle.css')); ?>" rel="stylesheet" />
    <?php else: ?>
        <link href="<?php echo e(asset('public/css/doctors/greenstyle.css')); ?>" rel="stylesheet" />
    <?php endif; ?>
    <link href="<?php echo e(asset('public/css/doctors/followup.css?v2.0.1')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/doctors/requisition.css?v2.0.1')); ?>" rel="stylesheet" />
    <style media="screen">
    @media  only screen and (max-width: 500px) {
         .historyWrapper{
             padding: 0;
        }
    }
    </style>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('doctors.navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('doctors/dashboard'); ?>
<?php $__env->startSection('main-content'); ?>


    <div class="content-wrapper" style="padding: 55px 10px 0px 10px;">
        <div class="container-fluid followupWrapper">
            
            <?php echo $__env->make('doctors.requisition.patientName', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                <div class="col-md-4 col-sm-4 bg-danger followUpContainer">
                    <h3 class="text-center">Referral <i class="fa fa-share-square-o text-success"></i></h3>
                    <br>
                    <br>
                    <form action="<?php echo e((isset($refferal))? url('refferal/'.$refferal->id) : url('refferal')); ?>" method="post">
                        <?php echo e(csrf_field()); ?>

                        <?php if(isset($refferal)): ?>
                            <?php echo e(method_field('PATCH')); ?>

                        <?php endif; ?>

                        <div class="form-group">
                            <label for="">Reasons for Refferal</label>
                            <small class="pull-right text-warning" style="font-size: 10px">(Optional Field)</small>
                            <textarea name="reason" id="" cols="30" rows="5" class="form-control" placeholder="Type your reasons here..."><?php echo e((isset($refferal))? $refferal->reason : ''); ?></textarea>
                        </div>

                        <div class="form-group <?php if($errors->has('to_clinic')): ?> has-error <?php endif; ?>">
                            <label for="">Medical Clinic / Department *</label>
                            <small class="pull-right text-danger" style="font-size: 10px">(Required Field)</small>
                            <select name="to_clinic" id="clinic" class="form-control clinic_code" <?php if($errors->has('to_clinic')): ?> style="border: 1px solid red" <?php endif; ?>>
                                <option value="">--Select A Clinic / Department--</option>
                                <?php $__currentLoopData = $clinics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $clinic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($clinic->id); ?>" <?php echo e((isset($refferal) && $refferal->to_clinic == $clinic->id)? 'selected' : ''); ?>><?php echo e($clinic->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php if($errors->has('to_clinic')): ?>
                                <span class="help-block">
                                    <small class=""><?php echo e($errors->first('to_clinic')); ?></small>
                                </span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="">Assign to Specific Doctor</label>
                            <small class="pull-right text-warning" style="font-size: 10px">(Optional Field)</small>
                            <select name="assignedTo" id="doctor" class="form-control selectDoctor">
                                <option value="" class="">--Select A Doctor--</option>
                                <?php if(isset($users)): ?>
                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option class="" <?php echo e((isset($refferal) && $refferal->assignedTo == $user->id)? 'selected value="'.$user->id.'"' : ''); ?>>
                                            <?php echo e($user->last_name.', '.$user->first_name.' '.$user->middle_name[0].'.'); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </select>
                            <small class="text-danger errorshow">Please select a clinic / department first.</small>
                        </div>

                        <br>

                        <div class="form-group text-right">
                            <button class="btn btn-success">Submit & Save</button>
                        </div>

                    </form>
                </div>

                <div class="col-md-8 col-sm-8 historyWrapper">
                    <h3 class="text-center">Referral History <i class="fa fa-history text-success"></i></h3>
                    <br>

                    <div class="table-responsive">
                        <table class="table consultationList">
                            <thead>
                            <tr>
                                <th>FROM_CLINIC</th>
                                <th>FROM_DOCTOR</th>
                                <th>TO_CLINIC</th>
                                <th>TO_DOCTOR</th>
                                <th>REASON</th>
                                <th>STATUS</th>
                                <th>DATE</th>
                                <th>EDIT</th>
                                <th>DELETE</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(count($refferals) > 0): ?>
                                <?php $__currentLoopData = $refferals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $refferal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $action = ($refferal->users_id == Auth::user()->id && $refferal->status == 'P')? '' : 'disabled onclick="event.preventDefault()"';
                                        $activateEdit = ($refferal->users_id == Auth::user()->id && $refferal->status == 'P')? 'onclick="return confirm('."'Edit this refferal?'".')"' : '';
                                        $activateDelete = ($refferal->users_id == Auth::user()->id && $refferal->status == 'P')? 'onclick="return confirm('."'Delete this refferal?'".')"' : '';
                                    ?>
                                    <tr>
                                        <td><?php echo e($refferal->fromClinic); ?></td>
                                        <td><?php echo e(($refferal->fromDoctor)? "DR. $refferal->fromDoctor" : 'N/A'); ?></td>
                                        <td><?php echo e(($refferal->toClinic)? $refferal->toClinic : 'N/A'); ?></td>
                                        <td><?php echo ($refferal->toDoctor)? "DR. $refferal->toDoctor" : '<span class="text-danger">N/A</span>'; ?></td>
                                        <td><?php echo ($refferal->reason)? $refferal->reason : '<span class="text-danger">N/A</span>'; ?></td>
                                        <td><?php echo ($refferal->status == 'P')? '<span class="text-danger">Pending</span>' : '<span class="text-success">Finished</span>'; ?></td>
                                        <td><?php echo e(Carbon::parse($refferal->created_at)->toFormattedDateString()); ?></td>
                                        <td>
                                            <a href="<?php echo e(url('refferal/'.$refferal->id.'/edit')); ?>" <?php echo $action; ?> <?php echo $activateEdit; ?> class="btn btn-info btn-circle"
                                               data-placement="top" data-toggle="tooltip" title="Click to edit" >
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="<?php echo e(url('delete_refferal/'.$refferal->id)); ?>" <?php echo $action; ?> <?php echo $activateDelete; ?> class="btn btn-danger btn-circle"
                                               data-placement="top" data-toggle="tooltip" title="Click to delete" >
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="10" class="text-center">
                                        <strong class="text-danger">THERE IS CURRENTLY, NO REFFERALS FOR THIS PATIENT!</strong>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- .content-wrapper -->




<?php $__env->stopSection(); ?>
<?php echo $__env->renderComponent(); ?>
<?php $__env->stopSection(); ?>





<?php $__env->startSection('footer'); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('pagescript'); ?>
    <?php echo $__env->make('message.toaster', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <script src="<?php echo e(asset('public/plugins/js/modernizr.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/jquery.menu-aim.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/doctors/main.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/doctors/refferal.js')); ?>"></script>
<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>
