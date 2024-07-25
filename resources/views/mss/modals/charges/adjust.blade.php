<div id="patient-adjust-charges" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modal-title">PATIENT PENDING CHARGES</label>
            </div>
            <div class="modal-body">
                @include('OPDMS.partials.loader')
                <form class="form-horizontal" method="POST" id="form-patient-adjust-charges" action="{{ url('saveadjustedcharges') }}">
                    <table class="table table-striped table-hover" id="ancillary-discounts">
                        <thead>
                            <tr>
                                <th>Clinic/Section</th>
                                <th>Service Name</th>
                                <th>Amount</th>
                                <th class="bg-success">Mss <br> Classification</th>
                                <th class="bg-success">Remaining <br> Amount</th>
                                <th class="bg-info">Guarantor</th>
                                <th class="bg-info"></th>
                                <th class="bg-info">Granted <br> Amount</th>
                                <th class="bg-warning">Payable</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                        <tfoot>
                            <th colspan="4" class="text-right">Total <i><small>(php)</small></i></th>
                            <th class="text-right bg-success total_remaining_amount text-right"></th>
                            <th colspan="3" class="text-right bg-info total_grandted_amount text-right"></th>
                            <th class="text-right bg-warning total_payable text-right"></th>
                        </tfoot>
                    </table>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm pull-left" data-dismiss="modal"><span class=" fa fa-remove"></span> Cancel</button>
                <button type="submit" class="btn btn-success btn-sm" form="form-patient-adjust-charges"><span class="fa fa-save"></span> Save</button>
            </div>
        </div>
    </div>
</div>