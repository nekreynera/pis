<div id="refincome-modal" class="modal" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title">REFLECT O.R SERIES <strong>(VOIDED)</strong></h5>
      </div>
      <div class="modal-body">
        <?php if(count($errors) > 0): ?>
            <div class="alert alert-danger">
                <strong><i class="fa fa-ban"></i> Whoops! looks like something went wrong.</strong>
                <br/>
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>
        <form class="form-horizontal" id="storeincomeor" method="post" action="<?php echo e(url('storeincomeor')); ?>">
           <?php echo e(csrf_field()); ?>

          <div class="form-group <?php if($errors->has('date')): ?> has-error <?php endif; ?>">
            <label class="col-sm-3 control-label">Date:</label>
            <div class="col-sm-5">
              <div class="input-group">
                <input type="date" name="date" class="form-control text-center" value="<?php if(old('date')): ?><?php echo e(old('date')); ?><?php else: ?><?php echo e(date('Y-m-d')); ?><?php endif; ?>">
                <span class="fa fa-calendar input-group-addon"></span>
              </div>
              <?php if($errors->has('date')): ?>
                <span class="help-inline text-danger"><?php echo e($errors->first('date')); ?></span>
              <?php endif; ?>
            </div>
          </div>
          <div class="form-group <?php if($errors->has('or_no')): ?> has-error <?php endif; ?>">
            <label class="col-sm-3 control-label">O.R Series:</label>
            <div class="col-sm-5">
              <input type="text" name="or_no" class="form-control text-center" placeholder="0000000" value="<?php echo e(old('or_no')); ?>">
              <?php if($errors->has('or_no')): ?>
                <span class="help-inline text-danger"><?php echo e($errors->first('or_no')); ?></span>
              <?php endif; ?>
            </div>
            <div class="col-md-4">
              <select class="form-control" name="or_type">
                <option value="" hidden>O.R Type</option>
                <option value="i">INCOME</option>
                <option value="m">MEDS</option>
              </select>
               <?php if($errors->has('or_type')): ?>
                <span class="help-inline text-danger"><?php echo e($errors->first('or_type')); ?></span>
                <?php endif; ?>
            </div>
            
          </div>
          <div class="form-group <?php if($errors->has('hospital_no')): ?> has-error <?php endif; ?>">
            <label class="col-sm-3 control-label">Patient Hospital no:</label>
            <div class="col-sm-5">
              <div class="input-group">
                <input type="text" name="hospital_no" class="form-control text-center hospital_no" value="<?php echo e(old('hospital_no')); ?>">
                <span class="input-group-addon" id="search-patient">Search <i class="fa fa-search"></i></span>
              </div>
              <?php if($errors->has('hospital_no')): ?>
                <span class="help-inline text-danger"><?php echo e($errors->first('hospital_no')); ?></span>
              <?php endif; ?>
              <span class="help-inline text-danger hospital_no-error"></span>
            </div>
          </div>
          <div class="form-group <?php if($errors->has('ptname')): ?> has-error <?php endif; ?>">
            <label class="col-sm-3 control-label">Patient Name:</label>
            <div class="col-sm-9">
              <div class="input-group">
              <input type="text" name="ptname" class="form-control ptname" value="<?php echo e(old('ptname')); ?>" readonly>
                <span class="fa fa-user input-group-addon"></span>
              </div>
              <small>firstname middlename lastname</small><br>
              <?php if($errors->has('ptname')): ?>
                <span class="help-inline text-danger"><?php echo e($errors->first('ptname')); ?></span>
              <?php endif; ?>
              <input type="hidden" name="ptid" class="ptid" value="<?php echo e(old('ptid')); ?>">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-remove"></span> Close</button>
        <button type="submit" class="btn btn-default" form="storeincomeor"><span class="fa fa-save"></span> Save & Submit</button>
      </div>
    </div>

  </div>
</div>