<div class="modal" id="modal-patient-transaction">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        Patient Transaction
      </div>
      <div class="modal-body">
        @include('OPDMS.partials.loader')
        <!-- <div class="row">
          <div class="patient-information col-md-12">
              <div class="col-md-4">
                <label>Hospital no: </label>
                <font class="font-hospital-no"></font>
              </div>
              <div class="col-md-8">
                <label>Patient Name: </label>
                <font class="font-patient-name"></font>
              </div>
          </div>
        </div> -->
        <!-- Horizontal Form -->
        <div class="box box-info">
          <div class="box-header with-border">
            <label>PAID ID</label>
          </div>
          <!-- /.box-header -->
            <div class="box-body">
                <div class="table table-responsive" style="max-height: 200px;">
                    <table class="table table-hover table-striped" id="paid-id-table">
                        <thead>
                            <tr class="bg-gray">
                                <th hidden></th>
                                <th>PRICE</th>
                                <th>OR</th>
                                <th>CASHIER</th>
                                <th>DATE</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->

        <div class="box box-info">
          <div class="box-header with-border">
            <label>PRINTED ID</label>
            <div class="box-tools pull-right">
                <small>
                    <span class="fa fa-info-circle"></span>
                    The data that is showed here are started from date 11/14/2018 to Present
                </small>
            </div>
          </div>
          <!-- /.box-header -->
            <div class="box-body">
                <div class="table table-responsive" style="max-height: 200px;">
                    <table class="table table-hover table-striped" id="printed-id-table">
                        <thead>
                            <tr class="bg-gray">
                                <th hidden></th>
                                <th>USER</th>
                                <th>DATE</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
        
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left btn-sm" data-dismiss="modal"><span class="fa fa-close"></span> Close</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->