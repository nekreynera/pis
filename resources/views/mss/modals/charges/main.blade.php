<div id="patient-pending-charges" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modal-title">PATIENT CHARGES</label>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive patient-information">
                            <table class="table table-bordered" id="patient-table">
                                <tr>
                                    <td colspan="2"><label>Patient: </label> <font class="patient-info"><!-- name (birtday/age/status) --></font></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><label>Address: </label> <font class="patient-address"><!-- address --></font></td>
                                </tr>
                                <tr>
                                    <td><label>Hospital no: </label> <b class="patient-hospital-no"><!-- hospital_no --></b></td>
                                    <td><label>Mss Classification: </label> <font class="patient-classification"></font></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
              
                <div class="row">
                    <!-- <div class="col-md-12 text-right request-action-button">
                        <button class="btn bg-unpaid btn-sm" id="unpaid">Unpaid <small class="label bg-default request-number unpaid">0</small></button>
                        <button class="btn btn-primary btn-sm" id="paid">Paid <small class="label bg-default request-number paid" >0</small></button>
                        <button class="btn btn-default btn-sm" id="all">All <small class="label bg-default request-number all" >0</small></button>
                    </div> -->
                    <div class="col-md-12">
                        @include('OPDMS.partials.loader')
                       <!--  <form method="post" id="patient-pending-charges-form" action="{{ url('pushtopaid') }}">
                            {{ csrf_field() }} -->
                            <div class="table-responsive table-responsive-ancillary-request" style="max-height: 340px;overflow-y: auto;">
                                <table class="table table-striped table-hover" id="ancillary-request">
                                    <thead>
                                        <tr>
                                            <th><i class="fa fa-check"></i></th>
                                            <th>Clinic/Section</th>
                                            <th>Service Name</th>
                                            <th>Datetime <br> Requested</th>
                                            <th>Price</th>
                                            <th>Qty</th>
                                            <th>Amount</th>
                                            <th class="bg-success">MSS <br>Classification</th>
                                            <th class="bg-success">Remaining <br> Amount</th>
                                            <th class="bg-info">Guarantor</th>
                                            <th class="bg-info">Granted <br> Amount</th>
                                            <th class="bg-info">Datetime <br> Granted</th>
                                            <th class="bg-warning">Payable <br> Amount</th>
                                            <th>Transaction <br> Status</th>
                                            <th>Datetime <br> Paid</th>
                                        </tr>
                                    </thead>
                                    <tbody class="ancillary-request-tbody">
                                    </tbody>
                                </table>
                            </div>
                        <!-- </form> -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm pull-left" data-dismiss="modal"><span class=" fa fa-remove"></span> Close</button>
                <button type="button" class="btn btn-success btn-sm select-charges"><span class="fa fa-check"></span> Select</button>
            </div>
        </div>
    </div>
</div>