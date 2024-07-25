<div id="changept-modal" class="modal" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><i class="fa fa-user-o"></i>CHANGE PATIENT </h5>
      </div>
      <div class="modal-body">
        <form class="form-horizontal changepatientform" id="changepatientform" method="post" action="#">
            <?php echo e(csrf_field()); ?>

          <div class="form-group">
            <label class="col-sm-3 control-label">Patient Hospital no:</label>
            <div class="col-sm-5">
              <div class="input-group">
                <input type="text" name="patient_hospital_no" class="form-control text-center pth_no">
                <span class="input-group-addon" id="searchhn-patient">Search <i class="fa fa-search"></i></span>
              </div>
              <span class="help-inline text-danger hospital_no-error"></span>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Patient Name:</label>
            <div class="col-sm-9">
              <div class="input-group">
              <input type="text" name="patient_name" class="form-control pthname" readonly>
                <span class="fa fa-user input-group-addon"></span>
              </div>
              <small>lastname, firstname middlename </small><br>
              <input type="hidden" name="pthid" class="pthid">
              <input type="hidden" name="pthtype" class="pthtype">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-default" form="changepatientform"><span class="fa fa-save"></span> Update & Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-remove"></span> Close</button>
      </div>
    </div>

  </div>
</div>