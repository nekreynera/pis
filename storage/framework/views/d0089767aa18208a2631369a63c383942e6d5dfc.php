<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPD | Edit Account
    <?php $__env->endSlot(); ?>

<?php $__env->startSection('pagestyle'); ?>
    <link href="<?php echo e(asset('public/css/partials/account.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>



<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('triage.navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>

    <div class="container-fluid">

        <div class="container">
            <h1>Edit Account</h1>
            <br>
            <div class="row">
                <div class="col-md-6 row">
                    <div class="profileWrapper">
                        <?php if($user->profile): ?>
                            <img src="<?php echo e(asset('public/users/'.$user->profile)); ?>" alt="" class="img-responsive center-block">
                        <?php else: ?>
                            <i class="fa fa-user-o"></i>
                        <?php endif; ?>
                    </div>
                    <br>
                    <label>Upload Profile</label>
                    <div class="form-group <?php if($errors->has('image')): ?> has-error <?php endif; ?>">
                        <label class="btn btn-default btn-file" title="Upload image">
                            Choose Image <i class="fa fa-image"></i>
                            <input type="file" name="image" class="upVolunteerImage" form="accountForm" style="display: none;">
                        </label>
                        <span class="fileShowingImage"></span>
                        <p class="maxUpload">Maximum upload file size: 20 MB</p>
                        <?php if($errors->has('image')): ?>
                            <span class="help-block">
                                    <strong class=""><?php echo e($errors->first('image')); ?></strong>
                            </span>
                        <?php endif; ?>
                    </div>

                </div>
                <div class="col-md-6">
                    <form action="<?php echo e(url('update_account')); ?>" method="post" enctype="multipart/form-data" id="accountForm">
                        <?php echo e(csrf_field()); ?>

                        <div class="form-group <?php if($errors->has('last_name')): ?> has-error <?php endif; ?>">
                            <label for="">Last Name *</label>
                            <div class="input-group">
                                <input type="text" name="last_name" value="<?php echo e(isset($user->last_name) ? $user->last_name : old('last_name')); ?>" class="form-control"
                                       placeholder="Enter Last Name" />
                                <span class="input-group-addon addonIcon" id="usernameaddon">
                                    <i class="fa fa-user"></i>
                                </span>
                            </div>
                            <?php if($errors->has('last_name')): ?>
                                <span class="help-block">
                                    <strong class=""><?php echo e($errors->first('last_name')); ?></strong>
                                </span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group <?php if($errors->has('first_name')): ?> has-error <?php endif; ?>">
                            <label for="">First Name *</label>
                            <div class="input-group">
                                <input type="text" name="first_name" value="<?php echo e(isset($user->first_name) ? $user->first_name : old('first_name')); ?>" class="form-control"
                                       placeholder="Enter First Name" />
                                <span class="input-group-addon addonIcon" id="usernameaddon">
                                    <i class="fa fa-user"></i>
                                </span>
                            </div>
                            <?php if($errors->has('first_name')): ?>
                                <span class="help-block">
                                    <strong class=""><?php echo e($errors->first('first_name')); ?></strong>
                                </span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group <?php if($errors->has('middle_name')): ?> has-error <?php endif; ?>">
                            <label for="">Middle Name *</label>
                            <div class="input-group">
                                <input type="text" name="middle_name" value="<?php echo e(isset($user->middle_name) ? $user->middle_name : old('middle_name')); ?>" class="form-control"
                                       placeholder="Enter Middle Name" />
                                <span class="input-group-addon addonIcon" id="usernameaddon">
                                    <i class="fa fa-user"></i>
                                </span>
                            </div>
                            <?php if($errors->has('middle_name')): ?>
                                <span class="help-block">
                                    <strong class=""><?php echo e($errors->first('middle_name')); ?></strong>
                                </span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group <?php if($errors->has('username')): ?> has-error <?php endif; ?>">
                            <label for="">Username *</label>
                            <div class="input-group">
                                <input type="text" name="username" value="<?php echo e(isset($user->username) ? $user->username : old('username')); ?>" class="form-control"
                                       placeholder="Enter Username" />
                                <span class="input-group-addon addonIcon" id="usernameaddon">
                                    <i class="fa fa-user"></i>
                                </span>
                            </div>
                            <?php if($errors->has('username')): ?>
                                <span class="help-block">
                                    <strong class=""><?php echo e($errors->first('username')); ?></strong>
                                </span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group <?php if($errors->has('password')): ?> has-error <?php endif; ?>">
                            <label for="">New Password *</label>
                            <div class="input-group">
                                <input type="password" name="password" class="form-control"
                                       placeholder="Enter Your New Password" />
                                <span class="input-group-addon addonIcon" id="usernameaddon">
                                    <i class="fa fa-lock"></i>
                                </span>
                            </div>
                            <?php if($errors->has('password')): ?>
                                <span class="help-block">
                                    <strong class=""><?php echo e($errors->first('password')); ?></strong>
                                </span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group <?php if($errors->has('password_confirmation')): ?> has-error <?php endif; ?>">
                            <label for="">Confirm Password *</label>
                            <div class="input-group">
                                <input type="password" name="password_confirmation" class="form-control"
                                       placeholder="Enter Your Confirmation Password" />
                                <span class="input-group-addon addonIcon" id="usernameaddon">
                                    <i class="fa fa-lock"></i>
                                </span>
                            </div>
                            <?php if($errors->has('password_confirmation')): ?>
                                <span class="help-block">
                                    <strong class=""><?php echo e($errors->first('password_confirmation')); ?></strong>
                                </span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group <?php if($errors->has('oldPassword')): ?> has-error <?php endif; ?>">
                            <label for="">Old Password *</label>
                            <div class="input-group">
                                <input type="password" name="oldPassword" class="form-control"
                                       placeholder="Enter Your Old Password" />
                                <span class="input-group-addon addonIcon" id="usernameaddon">
                                    <i class="fa fa-lock"></i>
                                </span>
                            </div>
                            <?php if($errors->has('oldPassword')): ?>
                                <span class="help-block">
                                    <strong class=""><?php echo e($errors->first('oldPassword')); ?></strong>
                                </span>
                            <?php endif; ?>
                        </div>

                        <div class="text-right">
                            <button class="btn btn-default">UPDATE ACCOUNT</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </div>

<?php $__env->stopSection(); ?>





<?php $__env->startSection('footer'); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('pagescript'); ?>
    <?php echo $__env->make('message.toaster', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>
