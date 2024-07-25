<div class="modal" id="modal-remove-patient">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        Deletion of Patient
      </div>
      <div class="modal-body">
        @include('OPDMS.partials.loader')
        <form class="form-horizontal" id="remove-form" method="POST" action="#">
            <input type="hidden" name="_method" value="DELETE">
            {{ csrf_field() }}
            <div class="form-group has-feedback">
                <label class="col-md-3 col-sm-3">ID. No</label>
                <div class="col-md-5 col-sm-5">
                    <input type="number" name="id_no" class="form-control id_no" readonly>
                    <span class="fa fa-address-card-o form-control-feedback"></span>
                </div>
            </div>

            <div class="form-group has-feedback">
                <label class="col-md-3 col-sm-3">Last Name</label>
                <div class="col-md-9 col-sm-9">
                    <input type="text" name="last_name" class="form-control last_name text-capitalize" readonly>
                    <span class="fa fa-user form-control-feedback"></span>
                </div>
            </div>

            <div class="form-group has-feedback">
                <label class="col-md-3 col-sm-3">First Name</label>
                <div class="col-md-9 col-sm-9">
                    <input type="text" name="first_name" class="form-control first_name text-capitalize" readonly>
                    <span class="fa fa-user form-control-feedback"></span>
                </div>
            </div>

             <div class="form-group has-feedback">
                <label class="col-md-3 col-sm-3">Request By</label>
                <div class="col-md-9 col-sm-9">
                    <input type="text" name="request_by" class="form-control request_by text-capitalize" readonly>
                    <span class="fa fa-user-secret form-control-feedback"></span>
                </div>
            </div>
            <div class="form-group has-feedback">
                <label class="col-md-3 col-sm-3">Remarks</label>
                <div class="col-md-9 col-sm-9">
                    <textarea name="remark" class="form-control remark"></textarea>
                </div>
            </div>
             <div class="form-group has-feedback">
                <label class="col-md-3 col-sm-3">Date Request</label>
                <div class="col-md-5 col-sm-5">
                    <input type="text" name="date_request" class="form-control date_request text-capitalize" readonly>
                    <span class="fa fa-calendar form-control-feedback"></span>
                </div>
            </div>
            <div class="bg-default text-center note-header">
                <label>Important</label>
            </div>
            <div class="bg-default note-body">
               Please take note that this request will not be automatically delete the patient from the records list. it will be verified first by the system administrator and will be deleted if the said record is suitable/allowed for deletion.
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left btn-sm" data-dismiss="modal"><span class="fa fa-close"></span> Close</button>
        <button type="submit" class="btn btn-success btn-sm" form="remove-form"><span class="fa fa-send"></span> Submit</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->