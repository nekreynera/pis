<div class="modal" id="modal-new-opd-doctor">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                New doctor entry form
            </div>
            <div class="modal-body">
                <?php echo $__env->make('OPDMS.partials.loader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <div class="text-right">
                    <small>
                        <span class="fa fa-info-circle"></span>
                        Fields mark with <b class="text-red">*</b> are required
                    </small>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <form class="form-horizontal laboratory_new_doctor" method="POST" id="laboratory_new_doctor" action="<?php echo e(url('laboratory_new_doctor')); ?>">
                            <?php echo e(csrf_field()); ?>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Last name: <b class="text-red">*</b></label>
                                    <input type="text" name="last_name" class="form-control last_name text-capitalize" placeholder="Doctor last name...">
                                </div>
                                <div class="form-group">
                                    <label>First name: <b class="text-red">*</b></label>
                                    <input type="text" name="first_name" class="form-control first_name text-capitalize" placeholder="Doctor first name...">
                                </div>
                                <div class="form-group">
                                    <label>Middle name/initial: </label>
                                    <input type="text" name="middle_name" class="form-control middle_name text-capitalize" placeholder="Doctor middle name/initial...">
                                </div>
                                <div class="form-group">
                                    <label>OPD Clinic name</label>
                                    <select name="clinic" class="form-control clinic select2" style="width: 100%;">
                                        
                                    </select>
                                </div>
                            </div>
                        </form>                            
                    </div>
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left btn-sm" data-dismiss="modal"><span class="fa fa-close"></span> Close</button>
                <button type="submit" class="btn btn-success btn-sm" form="laboratory_new_doctor"><span class="fa fa-save"></span> Save</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->