<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        PIS | Register
    <?php $__env->endSlot(); ?>

    <?php $__env->startSection('pagestyle'); ?>
    <?php $__env->stopSection(); ?>



    <?php $__env->startSection('header'); ?>
        <?php echo $__env->make('admin/navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php $__env->stopSection(); ?>



    <?php $__env->startSection('content'); ?>
        <form action="<?php echo e(url('users')); ?>" method="post" id="register">
            <div class="container">
                <div class="col-md-4 col-md-offset-4">
                    <div class="row">
                        <h3 class="text-center">CREATE USER</h3>
                        <br/>

                            <?php echo $__env->make('message.msg', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                            <?php echo e(csrf_field()); ?>


                            <div class="form-group <?php if($errors->has('last_name')): ?> has-error <?php endif; ?>">
                                <label>Last Name</label>
                                <input type="text" name="last_name" value="<?php echo e(old('last_name')); ?>" class="form-control" placeholder="Enter Last Name" />
                                <?php if($errors->has('last_name')): ?>
                                    <span class="help-block">
                                        <strong class=""><?php echo e($errors->first('last_name')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="form-group <?php if($errors->has('first_name')): ?> has-error <?php endif; ?>">
                                <label>First Name</label>
                                <input type="text" name="first_name" value="<?php echo e(old('first_name')); ?>" class="form-control" placeholder="Enter First Name" />
                                <?php if($errors->has('first_name')): ?>
                                    <span class="help-block">
                                        <strong class=""><?php echo e($errors->first('first_name')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="form-group">
                                <label>Middle Name</label>
                                <input type="text" name="middle_name" value="<?php echo e(old('middle_name')); ?>" class="form-control" placeholder="Enter Middle Name" />
                            </div>

                            <div class="form-group">
                                <label>Clinic / Department / Ward</label>
                                <select class="form-control" name="clinic">
                                    <option value="">--Select Clinic--</option>
                                    <?php $__currentLoopData = $clinics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $clinic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php $oldClinic = (old('clinic') == $clinic->id)? "selected" : "" ;  ?>
                                        <option <?php echo e($oldClinic); ?> value="<?php echo e($clinic->id); ?>"><?php echo e($clinic->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="form-group <?php if($errors->has('role')): ?> has-error <?php endif; ?>">
                                <label>Role</label>
                                <select class="form-control" name="role">
                                    <option value="">--Select Role--</option>
                                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php $oldRole = (old('role') == $role->id)? "selected" : "" ;  ?>
                                        <option <?php echo e($oldRole); ?> value="<?php echo e($role->id); ?>"><?php echo e($role->description); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php if($errors->has('role')): ?>
                                    <span class="help-block">
                                        <strong class=""><?php echo e($errors->first('role')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                            <div class="form-group <?php if($errors->has('med_interns')): ?> has-error <?php endif; ?>">
                                <label>Medical Clerk(Intern)</label>
                                <select class="form-control" name="med_interns">
                                    <option value="no">No</option>
                                    <option value="yes">Yes</option>
                                </select>
                                <?php if($errors->has('med_internse')): ?>
                                    <span class="help-block">
                                        <strong class=""><?php echo e($errors->first('med_interns')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="form-group <?php if($errors->has('username')): ?> has-error <?php endif; ?>">
                                <label>Username</label>
                                <input type="text" name="username" value="<?php echo e(old('username')); ?>" class="form-control" placeholder="Enter Username" />
                                <?php if($errors->has('username')): ?>
                                    <span class="help-block">
                                        <strong class=""><?php echo e($errors->first('username')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="form-group <?php if($errors->has('password')): ?> has-error <?php endif; ?>">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Enter Password" />
                                <?php if($errors->has('password')): ?>
                                    <span class="help-block">
                                        <strong class=""><?php echo e($errors->first('password')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" />
                            </div>

                            <div class="form-group">
                                <br/>
                                <button type="submit" class="btn btn-block btn-success">Submit&nbsp; <i class="fa fa-arrow-right"></i></button>
                            </div>

                    </div>
                </div>
            </div>

        </form>

        <br><br>
            

        
    <?php $__env->stopSection(); ?>





    <?php $__env->startSection('footer'); ?>
    <?php $__env->stopSection(); ?>



    <?php $__env->startSection('pagescript'); ?>
        <?php echo $__env->make('message.toaster', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>
