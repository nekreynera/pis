<div class="modal" id="modal-patients-list">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> -->
                Central Database Lookup Window
            </div>
            <div class="modal-body">
                <?php echo $__env->make('OPDMS.partials.loader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <div class="form-group has-feedback" style="margin-bottom: 5px;">
                    <div>
                        <input type="text" name="" class="form-control search-print-patient" id="search-print-patient" placeholder="Search Patient..." onkeydown="updatetablecontent(this)">
                        <span class="fa fa-search text-muted form-control-feedback"></span>
                    </div>
                </div>
                <div class="text-center">
                    <small class="text-red">Input value and hit [Enter] Key </small>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="print-table">
                        <thead>
                            <tr class="bg-gray">
                                <th><input type="checkbox" name="" id="selectall" style="height: 16px!important;margin-top: 0px;"></th>
                                <th>ID no</th>
                                <th>Patient Name</th>
                                <th>Service</th>
                                <th>Datetime <br>Done</th>
                                <th>Datetime <br>Request</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody class="print-tbody">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left btn-sm" data-dismiss="modal"><span class="fa fa-reply"></span> Cancel</button>
                <button type="button" class="btn btn-default btn-sm" id="print-selected-record" data-id="#"><span class="fa fa-print"></span> Print </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->