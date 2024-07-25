<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPD | Vital Signs
    <?php $__env->endSlot(); ?>

<?php $__env->startSection('pagestyle'); ?>
    <link href="<?php echo e(asset('public/css/patients/register.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/triage/triage_support.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>



<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('receptions.navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>
    <div class="container">
        <br/>
        <div class="row">

            <div class="col-md-6 patient_info">
                <h2 class="text-center">PATIENT INFO</h2>
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                        <tr>
                            <td>Name:</td>
                            <td><?php echo e($patient->last_name.' '.$patient->first_name.' '.$patient->middle_name.' '.$patient->suffix); ?></td>
                        </tr>
                        <tr>
                            <td>Hospital:</td>
                            <td><?php echo e($patient->hospital_no); ?></td>
                        </tr>
                        <tr>
                            <td>Barcode:</td>
                            <td><?php echo e($patient->barcode); ?></td>
                        </tr>
                        <tr>
                            <td>Birthday:</td>
                            <td>
                                <?php if($patient->birthday): ?>
                                    <?php echo e(Carbon::parse($patient->birthday)->format('F d, Y')); ?>

                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Age:</td>
                            <td>25</td>
                        </tr>
                        <tr>
                            <td>Address:</td>
                            <td><?php echo e($patient->address); ?></td>
                        </tr>
                        <tr>
                            <td>Civil Status:</td>
                            <td><?php echo e($patient->civil_status); ?></td>
                        </tr>
                        <tr>
                            <td>Sex:</td>
                            <td><?php echo e(($patient->sex == 'M')? 'Male' : 'Female'); ?></td>
                        </tr>
                        <tr>
                            <td>Contact No:</td>
                            <td><?php echo e(($patient->contact_no)? $patient->contact_no : 'None'); ?></td>
                        </tr>
                        <tr>
                            <td>DateRegistered:</td>
                            <td><?php echo e(Carbon::parse($patient->created_at)->format('F d, Y')); ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>



            <div class="col-md-6">
                <h2 class="text-center">VITAL SIGNS</h2>
                <form action="<?php echo e(url('storeVitalSigns')); ?>" method="post">

                    <?php echo e(csrf_field()); ?>


                    <input type="hidden" name="patients_id" value="<?php echo e($patient->id); ?>" />

                    <div class="form-group <?php if($errors->has('clinic_code')): ?> has-error <?php endif; ?>" style="display: none;">
                        <label>Assign Clinic</label>
                        <select name="clinic_code" readonly="" class="form-control select">
                            <option value="">--Select Clinic--</option>
                            <?php $__currentLoopData = $clinics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $clinic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option <?php echo e(($clinic->code == $clinicID->code) ? 'selected' : ''); ?> value="<?php echo e($clinic->code); ?>"><?php echo e($clinic->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php if($errors->has('clinic_code')): ?>
                            <span class="help-block">
                                    <strong class=""><?php echo e($errors->first('clinic_code')); ?></strong>
                                </span>
                        <?php endif; ?>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Blood Pressure</label>
                                <div class="input-group">
                                    <input type="text" name="blood_pressure" class="form-control" value="<?php echo e(old('blood_pressure')); ?>"
                                           placeholder="Enter Blood Pressure" />
                                    <div class="input-group-addon">BP</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Pulse Rate</label>
                                <div class="input-group">
                                    <input type="text" name="pulse_rate" class="form-control" value="<?php echo e(old('pulse_rate')); ?>" placeholder="Enter Pulse Rate" />
                                    <div class="input-group-addon">BPM</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Respiration Rate</label>
                                <div class="input-group">
                                    <input type="text" name="respiration_rate" class="form-control" value="<?php echo e(old('respiration_rate')); ?>"
                                           placeholder="Enter Respiration Rate" />
                                    <div class="input-group-addon">RM</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Body Temperature</label>
                                <div class="input-group">
                                    <input type="text" name="body_temperature" class="form-control" value="<?php echo e(old('body_temperature')); ?>"
                                           placeholder="Enter Body Temperature" />
                                    <div class="input-group-addon">°C</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Weight</label>
                                <div class="input-group">
                                    <input type="text" name="weight" class="form-control" value="<?php echo e(old('weight')); ?>" placeholder="Enter Weight" />
                                    <div class="input-group-addon">KG.</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Height</label>
                                <div class="input-group">
                                    <input type="text" name="height" class="form-control" value="<?php echo e(old('height')); ?>" placeholder="Enter Height" />
                                    <div class="input-group-addon">CM.</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group text-right">
                        <br/>
                        <button type="submit" class="btn btn-success">
                            Submit <i class="fa fa-arrow-right"></i>
                        </button>
                    </div>

                </form>
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
