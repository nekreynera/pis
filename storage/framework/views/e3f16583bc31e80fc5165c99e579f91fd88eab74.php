<div class="modal" id="modal-check-patient">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        Central Database Lookup Window
      </div>
      <div class="modal-body">
        <?php echo $__env->make('OPDMS.partials.loader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <form class="form-horizontal" id="search-form" method="POST" action="<?php echo e(url('registersearch')); ?>">
            <?php echo e(csrf_field()); ?>

            <div class="form-group has-feedback">
                <label class="col-md-3 col-sm-3">ID. No</label>
                <div class="col-md-9 col-sm-9">
                    <input type="number" name="id_no" class="form-control id_no" readonly>
                    <span class="fa fa-check text-muted form-control-feedback"></span>
                </div>
            </div>

            <div class="form-group has-feedback">
                <label class="col-md-3 col-sm-3">Last Name</label>
                <div class="col-md-9 col-sm-9">
                    <input type="text" name="l_name" class="form-control l_name text-capitalize" required>
                    <span class="fa fa-check text-muted form-control-feedback"></span>
                </div>
            </div>

            <div class="form-group has-feedback">
                <label class="col-md-3 col-sm-3">First Name</label>
                <div class="col-md-9 col-sm-9">
                    <input type="text" name="f_name" class="form-control f_name text-capitalize" required>
                    <span class="fa fa-check text-muted form-control-feedback"></span>
                </div>
            </div>

            <div class="form-group select-search">
                <label class="col-md-3 col-sm-3">Search Options</label>
                <div class="col-md-9 col-sm-9">
                    <select class="form-control search-option" name="option">
                        <option value="1">Both Last Name and First Name</option>
                        <option value="2" disabled>Patient ID. No</option>
                    </select>
                </div>
            </div>
            <div class="bg-default text-center note-header">
                <label>Important</label>
            </div>
            <div class="bg-default note-body">
                Please take note that a comma, a period, and other special characters included in the search keywords (in any of the search text boxes) affects the desired output of the search boxes. <br>
                If search proccess is completed and there is no record found on the search keywords, the system will redirect you to register form that will allow you to input data entry.
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left btn-sm" data-dismiss="modal"><span class="fa fa-close"></span> Close</button>
        <button type="submit" class="btn btn-success btn-sm" form="search-form"><span class="fa fa-search"></span> Search</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->