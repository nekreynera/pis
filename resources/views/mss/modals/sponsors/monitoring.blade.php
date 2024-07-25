<div class="modal" id="modal-monitoring-mss-guarantor">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Guarantor transactions monitoring window
                <small class="pull-right">
                    <span class="fa fa-info-circle"></span>
                    Fields mark with <b class="text-red">*</b> are required
                </small>
            </div>
            <div class="modal-body">
                @include('OPDMS.partials.loader')
                <form class="form-inline" method="post" id="form-monitoring-mss-guarantor" action="#">
                    <div class="form-group" hidden style="display: none;">
                        <label>Summary for</label>
                        <select class="form-control" name="summaray_for" required>
                            <option value="1">Availed Patient</option>
                            <option value="2">Services used</option>
                            <option value="3">Ancillary/Clinic used</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Guarantor</label>
                        <select class="form-control mss_id" name="mss_id" required>
                            <option value="">--</option>
                            @foreach($data as $list)
                                <option value="{{ $list->id }}">{{ $list->label.' '.((is_numeric($list->description))? $list->description.'%' : $list->description) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Start Date</label>
                        <input type="date" name="start_date" class="form-control start_date" required>
                    </div>
                    <div class="form-group">
                        <label>End Date</label>
                        <input type="date" name="end_date" class="form-control end_date" required>
                    </div>
                    
                    <button type="submit" class="btn btn-success btn-sm" form="form-monitoring-mss-guarantor"><span class="fa fa-send"></span> Submit</button>
                </form>
                <hr>
                <div class="row">
                    <div class="col-sm-9">
                        <div class="table-responsive" style="max-height: 400px;overflow-y: auto;">
                            <table class="table table-stripped table-hover" id="guarantor-detailed">
                                <thead class="avialed-patient-header">
                                    <tr class="success">
                                        <th>Patient Name</th>
                                        <th>Ancillary/Clinic</th>
                                        <th>Services Availed</th>
                                        <th>Total Amount </th>
                                    </tr>
                                </thead>
                                <thead class="service-used">
                                    <tr class="success">
                                        <th>Services</th>
                                        <th>Ancillarys/Clinics</th>
                                        <th># Patient Availed</th>
                                        <th>Total Amount </th>
                                    </tr>
                                </thead>
                                <thead class="ancillary-used">
                                    <tr class="success">
                                        <th>Ancillarys/clinics</th>
                                        <th># Service used</th>
                                        <th># Patient Availed</th>
                                        <th>Total Amount </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="guarantor-summary">
                                <tr>
                                    <th colspan="2">SUMMARY</th>
                                </tr>
                                <tr>
                                    <th>Guarantor</th>
                                    <td class="guarantor text-capitalized"></td>
                                </tr>
                                <tr>
                                    <th>Number of patient</th>
                                    <td class="pateint_total text-center"></td>
                                </tr>
                                <tr>
                                    <th>Total Amount</th>
                                    <td class="amount_total text-right"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
               
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