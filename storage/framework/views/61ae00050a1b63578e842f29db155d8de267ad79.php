<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPD | Follow Up
    <?php $__env->endSlot(); ?>

<?php $__env->startSection('pagestyle'); ?>
    <link href="<?php echo e(asset('public/plugins/css/jquery-ui.css')); ?>" rel="stylesheet" />
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
                            <h3 class="text-center">Follow-Up <i class="fa fa-calendar text-success"></i></h3>
                            <br>
                            <br>
                            <form action="<?php echo e((isset($followup))? url('followup/'.$followup->id) : url('followup')); ?>" method="post">
                                <?php echo e(csrf_field()); ?>

                                <?php if(isset($followup)): ?>
                                    <?php echo e(method_field('PATCH')); ?>

                                <?php endif; ?>

                                <div class="form-group">
                                    <label for="">Reasons for Follow-Up</label>
                                    <small class="pull-right text-warning" style="font-size: 10px">(Optional Field)</small>
                                    <textarea name="reason" id="" cols="30" rows="4" class="form-control" placeholder="Type your reasons here..."><?php echo e((isset($followup))? $followup->reason : ''); ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="">Medical Clinic / Department *</label>
                                    <small class="pull-right text-danger" style="font-size: 10px">(Required Field)</small>
                                    <input type="hidden" name="clinic_code" value="<?php echo e($clinic->id); ?>" />
                                    <input type="text" class="form-control" value="<?php echo e($clinic->name); ?>" disabled />
                                </div>

                                <div class="form-group">
                                    <label for="">Assign to Specific Doctor</label>
                                    <small class="pull-right text-warning" style="font-size: 10px">(Optional Field)</small>
                                    <select name="assignedTo" id="" class="form-control">
                                        <option value="">--Select A Doctor--</option>
                                        <?php if(!empty($doctors)): ?>
                                            <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option <?php echo e((isset($followup) && $followup->users_id == $doctor->id)? 'selected' : ''); ?> value="<?php echo e($doctor->id); ?>">Dr. <?php echo e($doctor->last_name.', '.$doctor->first_name.' '.$doctor->middle_name[0].'.'); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </select>
                                    <small class="text-muted" style="font-size: 10px">* Doctors that appear in here are within this clinic only.</small>
                                    <br>
                                </div>

                                <div class="form-group <?php if($errors->has('followupdate')): ?> has-error <?php endif; ?>">
                                    <label for="">Follow-Up Date *</label>
                                    <small class="pull-right text-danger" style="font-size: 10px">(Required Field)</small>
                                    <input type="text" name="followupdate" class="form-control" id="datepicker" value="<?php echo e(isset($followup->followupdate) ? $followup->followupdate : old('followupdate')); ?>" placeholder="Select a follow-up date"
                                           <?php if($errors->has('followupdate')): ?> style="border: 1px solid red" <?php endif; ?> />
                                    <?php if($errors->has('followupdate')): ?>
                                        <span class="help-block">
                                            <small class=""><?php echo e($errors->first('followupdate')); ?></small>
                                        </span>
                                    <?php endif; ?>
                                </div>

                                <br>
                                <div class="form-group text-right">
                                    <button type="submit" class="btn btn-success">Submit & Save</button>
                                </div>
                            </form>
                        </div>

                        <div class="col-md-8 col-sm-8 historyWrapper">
                            <h3 class="text-center">Follow-Up History <i class="fa fa-history text-success"></i></h3>
                            <br>
                            <div class="table-responsive">
                                <table class="table consultationList">
                                    <thead>
                                        <tr>
                                            <th>PATIENT</th>
                                            <th>CLINIC</th>
                                            <th>FROM_DOCTOR</th>
                                            <th>TO_DOCTOR</th>
                                            <th>REASON</th>
                                            <th>STATUS</th>
                                            <th>FF_DATE</th>
                                            <th>EDIT</th>
                                            <th>DELETE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(count($followups) > 0): ?>
                                        <?php $__currentLoopData = $followups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $followup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $action = ($followup->users_id == Auth::user()->id)? '' : 'disabled onclick="event.preventDefault()"';
                                                $activateEdit = ($followup->users_id == Auth::user()->id)? 'onclick="return confirm('."'Edit this follow-up?'".')"' : '';
                                                $activateDelete = ($followup->users_id == Auth::user()->id)? 'onclick="return confirm('."'Delete this follow-up?'".')"' : '';
                                            ?>
                                            <tr>
                                                <td><?php echo e($followup->name); ?></td>
                                                <td><?php echo e($followup->clinic); ?></td>
                                                <td><?php echo e(($followup->fromDoctor)? "DR. $followup->fromDoctor" : 'N/A'); ?></td>
                                                <td><?php echo ($followup->toDoctor)? "DR. $followup->toDoctor" : '<span class="text-danger">N/A</span>'; ?></td>
                                                <td><?php echo ($followup->reason)? $followup->reason : '<span class="text-danger">N/A</span>'; ?></td>
                                                <td><?php echo ($followup->status == 'P')? '<span class="text-danger">Pending</span>' : '<span class="text-success">Finished</span>'; ?></td>
                                                <td><?php echo e(Carbon::parse($followup->followupdate)->toFormattedDateString()); ?></td>
                                                <td>
                                                    <a href="<?php echo e(url('followup/'.$followup->id.'/edit')); ?>" class="btn btn-info btn-circle" <?php echo $action; ?> <?php echo $activateEdit; ?>

                                                    data-placement="top" data-toggle="tooltip" title="Click to edit">
                                                    <i class="fa fa-pencil"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="<?php echo e(url('delete_followup/'.$followup->id)); ?>" class="btn btn-danger btn-circle" <?php echo $action; ?> <?php echo $activateDelete; ?> data-placement="top" data-toggle="tooltip" title="Click to delete">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="9" class="text-center">
                                                <strong class="text-danger">THERE IS CURRENTLY, NO FOLLOW UP FOR THIS PATIENT!</strong>
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
    <script src="<?php echo e(asset('public/plugins/js/jquery-ui.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/modernizr.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/jquery.menu-aim.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/doctors/main.js')); ?>"></script>

    <script>
        $( function() {
            $( "#datepicker" ).datepicker({
                dateFormat: 'yy-mm-dd',
                minDate: new Date()
            });
        });
    </script>

<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>
