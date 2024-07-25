<div id="walk-in-modal" class="modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Register Walk-In Patient
            </div>
            <div class="modal-body">
                <?php echo $__env->make('OPDMS.partials.loader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <form class="form-horizontal walk-in-form" id="walk-in-form" method="POST" action="<?php echo e(url('walkinpatient')); ?>"> 
                    <?php echo e(csrf_field()); ?>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <div class="text-right">
                                    <small>
                                        <span class="fa fa-info-circle"></span>
                                        Fields mark with <b class="text-red">*</b> are required
                                    </small>
                                </div>
                                <div class="form-group">
                                    <label>Last Name <b class="text-red">*</b></label>
                                    <input type="text" name="last_name" class="form-control last_name" placeholder="Enter Last Name" required>
                                </div>
                                <div class="form-group">
                                    <label>First Name <b class="text-red">*</b></label>
                                    <input type="text" name="first_name" class="form-control first_name" placeholder="Enter First Name" required>
                                </div>
                                 <div class="form-group">
                                    <div class="row">
                                        <div class="col-xs-8">
                                            <label>Middle Name</label>
                                            <input type="text" name="middle_name" class="form-control middle_name" placeholder="Enter Middle Name">
                                        </div>
                                        <div class="col-xs-4">
                                            <label>Suffix</label>
                                            <select name="suffix" class="form-control suffix">
                                                <option value="">--</option>
                                                <option>Jr</option>
                                                <option>Sr</option>
                                                <option>Sra</option>
                                                <option>II</option>
                                                <option>III</option>
                                                <option>IV</option>
                                                <option>V</option>
                                                <option>VI</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <label>Birth Date <b class="text-red">*</b></label>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" name="birthday" class="form-control birthday" id="datemask2" data-inputmask="'alias': 'mm/dd/yyyy'" data-mask required>
                                            </div>
                                        </div>
                                        <div class="col-xs-6">
                                             <label>Sex <b class="text-red">*</b></label>
                                             <select name="sex" class="form-control sex" required>
                                                 <option value="" hidden>--</option>
                                                 <option value="M">Male</option>
                                                 <option value="F">Female</option>
                                             </select>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <label>Civil Status</label>
                                            <select name="civil_status" class="form-control civil_status">
                                                <option value="" hidden>--</option>
                                                <option>New Born</option>
                                                <option>Child</option>
                                                <option>Single</option>
                                                <option>Married</option>
                                                <option>Common Law</option>
                                                <option>Widow</option>
                                                <option>Separated</option>
                                                <option>Divorce</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-6">
                                            <label>Contact No</label>
                                            <input type="text" name="contact_no" class="form-control contact_no" placeholder="Enter Contact Number">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <label>Region <b class="text-red">*</b></label>
                                            <select name="region" class="form-control region select2" style="width: 100%;" required>
                                                <option value="" hidden>--</option>
                                                <?php $__currentLoopData = $regions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $region): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                    <option value="<?php echo e($region->regCode); ?>" <?php if($region->regCode == '08'): ?> selected <?php endif; ?>><?php echo e($region->regDesc); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                        <div class="col-xs-6">
                                            <label>Province <b class="text-red">*</b></label>
                                            <select name="province" class="form-control province select2" style="width: 100%;" required>
                                                <option value="" hidden>--</option>
                                                <?php $__currentLoopData = $provinces; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $province): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                    <option value="<?php echo e($province->provCode); ?>" <?php if($province->provCode == '0837'): ?> selected <?php endif; ?>><?php echo e($province->provDesc); ?></option>

                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <label>City/Municipality <b class="text-red">*</b></label>
                                            <select name="city_municipality" class="form-control city_municipality select2" style="width: 100%;" required>
                                                <option value="" hidden>--</option>
                                                <?php $__currentLoopData = $citys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($city->citymunCode); ?>" <?php if($city->citymunCode == '083747'): ?> selected <?php endif; ?>><?php echo e($city->citymunDesc); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                        <div class="col-xs-6">
                                            <label>Brgy</label>
                                            <select name="brgy" class="form-control brgy select2" style="width: 100%;">
                                                <option value="" hidden>--</option>
                                                 <?php $__currentLoopData = $brgys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brgy): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($brgy->id); ?>"><?php echo e($brgy->brgyDesc); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success btn-sm" form="walk-in-form">Save</button>
            </div>
        </div>
  </div>
</div>