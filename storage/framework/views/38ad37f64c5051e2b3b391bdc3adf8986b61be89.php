<div class="modal" id="modal-edit-list">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        Edit Service Entry Form
        
      </div>
      <div class="modal-body">
        <div class="text-right">
            <small>
                <span class="fa fa-info-circle"></span>
                Fields mark with <b class="text-red">*</b> are required
            </small>
        </div>
        <?php echo $__env->make('OPDMS.partials.loader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <form class="form-horizontal ancillary-form" id="edit-list-form" method="POST" action="#">
            <?php echo e(csrf_field()); ?>

            <?php echo e(method_field('PATCH')); ?>

            <div class="form-group select-search">
                <label class="col-md-3 col-sm-3">Pathology <b class="text-red">*</b></label>
                <div class="col-md-9 col-sm-9">
                    <select class="form-control select2 laboratory_id" id="laboratory_id" name="laboratory_id" required style="width: 100%;">
                    </select>
                </div>
            </div>
            <div class="form-group has-feedback">
                <label class="col-md-3 col-sm-3">Category <b class="text-red">*</b></label>
                <div class="col-md-9 col-sm-9">
                    <select class="form-control select2 laboratory_sub_id" name="laboratory_sub_id" required style="width: 100%;">
                        
                    </select>
                </div>
            </div>

            <div class="form-group has-feedback">
                <label class="col-md-3 col-sm-3">Ancillary <b class="text-red">*</b></label>
                <div class="col-md-9 col-sm-9">
                    <input type="text" name="name" class="form-control name text-capitalize" placeholder="Ancillary Name" required>
                    <span class="fa fa-check form-control-feedback"></span>
                </div>
            </div>

            <div class="form-group has-feedback">
                <label class="col-md-3 col-sm-3">Price <b class="text-red">*</b></label> 
                <div class="col-md-4 col-sm-4">
                    <input type="text" name="price" class="form-control price text-right" placeholder="0.00" required>
                    <span class="fa fa-check form-control-feedback"></span>
                </div>
            </div>

            <div class="form-group has-feedback">
                <label class="col-md-3 col-sm-3">Status <b class="text-red">*</b></label>
                <div class="col-md-4 col-sm-4">
                    <select class="form-control select2 status" id="status" name="status" style="width: 100%;">
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left btn-sm" data-dismiss="modal"><span class="fa fa-close"></span> Close</button>
        <button type="submit" class="btn btn-success btn-sm" form="edit-list-form"><span class="fa fa-save"></span> Update</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->