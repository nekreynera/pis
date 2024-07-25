<div class="modal" id="modal-print-patient">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                Central Database Lookup Window
            </div>
            <div class="modal-body">
                @include('OPDMS.partials.loader')
                <div class="form-group has-feedback" style="margin-bottom: 5px;">
                    <div>
                        <input type="text" name="" class="form-control search-print-patient" id="search-print-patient" placeholder="Search Record...">
                        <span class="fa fa-search text-muted form-control-feedback"></span>
                    </div>
                </div>
                <div class="text-center">
                    <small class="text-red">Input value and hit [Enter] Key </small>
                </div>
                <div class="search-header text-right" style="background: #ccc">
                    <span class="search-print pull-left"><span class="search-count"></span> Search Result</span>
                    <span><input type="number" name="" class="text-center print-count" value="50" min="1" onkeydown="updatetablecontent(this)"> Latest Registered Patient</span>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="print-table">
                        <thead>
                            <tr class="bg-gray">
                                <th><input type="checkbox" name="" id="selectall"></th>
                                <th>ID no</th>
                                <th>Last Name</th>
                                <th>First Name</th>
                                <th>Middle Name</th>
                                <th>Birth Date</th>
                                <th>Gender</th>
                                <th>Printed?</th>
                            </tr>
                        </thead>
                        <tbody class="print-tbody">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left btn-sm" data-dismiss="modal"><span class="fa fa-remove"></span> Close</button>
                <button type="button" class="btn btn-success btn-sm" id="print-selected-record" data-id="#"><span class="fa fa-print"></span> Print </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->