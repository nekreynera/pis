<div id="patient-charges" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <label class="modal-title">PATIENT CHARGES</label>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive patient-information">
                    <table class="table table-bordered">
                        <tr>
                            <td>Patient: <strong class="patient-name"></strong></td>
                            <td>Birth Date: <font class="patient-birth-date"></font></td>
                            <td>Age: <font class="patient-age"></font></td>
                            <td>C.Status: <font class="patient-c-status"></font></td>
                        </tr>
                        <tr>
                            <td>Hospital ID: <strong class="patient-hospital-no"></strong></td>
                            <td colspan="2" style="max-width: 500px;">Address: <font class="patient-address"></font></td>
                            <td>Sex: <font class="patient-sex"></font></td>
                        </tr>
                        <tr>
                            <td>QR-Code: <font class="patient-qr-code"></font></td>
                            <td colspan="2">Mss Classification: <strong class="patient-mss" data-discount=""></strong></td>
                            <td>Registered: <font class="patient-regestered"></font></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form method="post" id="pendingrequesrform" action="{{ url('laboratorypatients') }}">
                    {{ csrf_field() }}
                    <div class="table-responsive table-responsive-ancillary-request">
                        <table class="table table-striped table-hover" id="ancillary-request">
                            <thead>
                                <tr class="bg-gray">
                                    <th></th>
                                    <th hidden></th>
                                    <th>Service Name</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Amount</th>
                                    <th>Discount</th>
                                    <th>Net Amount</th>
                                    <th>Payment <br>Status</th>
                                    <th>Process <br> Status</th>
                                </tr>
                            </thead>
                            <tbody class="ancillary-request-tbody">
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4">Total</th>
                                    <th class="text-right">0.00</th>
                                    <th class="text-right">0.00</th>
                                    <th class="text-right">0.00</th>
                                    <th colspan="2"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </form>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><span class=" fa fa-remove"></span> Close</button>
        <button type="button" class="btn btn-success btn-sm" data-dismiss="modal"><span class="fa fa-save"></span> Save</button>
      </div>
    </div>

  </div>
</div>