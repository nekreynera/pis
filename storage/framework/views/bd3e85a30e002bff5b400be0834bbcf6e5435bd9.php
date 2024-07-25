<div class="modal" id="modal-edit-sub">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        Edit Pathology Entry Form
      </div>
      <div class="modal-body">
        <?php echo $__env->make('OPDMS.partials.loader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <form class="form-horizontal" id="edit-sub-form" method="POST" action="#">
            <?php echo e(csrf_field()); ?>

            <?php echo e(method_field('PATCH')); ?>

            <div class="form-group select-search">
                <label class="col-md-3 col-sm-3">Pathology</label>
                <div class="col-md-9 col-sm-9">
                    <select class="form-control laboratory_id select2" id="laboratory_id" name="laboratory_id" required style="width: 100%;">
                    </select>
                </div>
            </div>

            <div class="form-group has-feedback">
                <label class="col-md-3 col-sm-3">Category</label>
                <div class="col-md-9 col-sm-9">
                    <input type="text" name="name" class="form-control name text-capitalize" required>
                    <span class="fa fa-flask form-control-feedback"></span>
                </div>
            </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left btn-sm" data-dismiss="modal"><span class="fa fa-close"></span> Close</button>
        <button type="submit" class="btn btn-success btn-sm" form="edit-sub-form"><span class="fa fa-save"></span> Update</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->