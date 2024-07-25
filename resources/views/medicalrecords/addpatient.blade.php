
<div id="addpatient-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <form class="form-horizontal" method="POST" action="{{ url('addpatient') }}">
        {{ csrf_field() }}
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title"><i class="fa fa-user"></i> SCAN OR INPUT PATIENT QRCODE/HOSPITAL NO</h5>
            </div>
            <div class="modal-body">
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <input type="text" name="credentials" class="form-control credentials" minlength="6" placeholder="QRCODE/HOSPITAL NO">
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><span class="fa fa-remove"></span> Close</button>
            </div>
        </div>
    </form>
  </div>
</div>