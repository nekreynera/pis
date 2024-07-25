<div class="modal" id="modal-new-sub">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        New Pathology Entry Form
      </div>
      <div class="modal-body">
        @include('OPDMS.partials.loader')
        <form class="form-horizontal" id="new-sub-form" method="POST" action="{{ url('laboratorysub') }}">
            {{ csrf_field() }}

            <div class="form-group select-search">
                <label class="col-md-3 col-sm-3">Pathology</label>
                <div class="col-md-9 col-sm-9">
                    <select class="form-control type select2" id="laboratory_id" name="laboratory_id" required style="width: 100%;">
                    </select>
                </div>
            </div>

            <div class="form-group has-feedback">
                <label class="col-md-3 col-sm-3">Category</label>
                <div class="col-md-9 col-sm-9">
                    <input type="text" name="name" class="form-control category text-capitalize" required>
                    <span class="fa fa-flask form-control-feedback"></span>
                </div>
            </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left btn-sm" data-dismiss="modal"><span class="fa fa-close"></span> Close</button>
        <button type="submit" class="btn btn-success btn-sm" form="new-sub-form"><span class="fa fa-save"></span> Save</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->