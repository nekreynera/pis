<div class="modal" id="modal-check-result">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                Central Database Lookup Window
            </div>
            <div class="modal-body">
                <?php echo $__env->make('OPDMS.partials.loader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <div class="form-group has-feedback">
                    <div>
                        <input type="text" name="" class="form-control search-patient-input" id="search-patient-input" placeholder="hospital no last name first name middle name">
                        <span class="fa fa-search text-muted form-control-feedback"></span>
                    </div>
                </div>
                <div class="search-header">
                    <span><span class="result-count"></span> Records found</span>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="result-table">
                        <thead>
                            <tr class="bg-gray">
                                <th></th>
                                <th>ID no</th>
                                <th>Last Name</th>
                                <th>First Name</th>
                                <th>Middle Name</th>
                                <th>Birth Date</th>
                                <th>Gender</th>
                            </tr>
                        </thead>
                        <tbody class="result-tbody">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left btn-sm" data-dismiss="modal"><span class="fa fa-remove"></span> Close</button>
                <button type="button" class="btn btn-success btn-sm" data-dismiss="modal" id="back-to-search"><span class="fa fa-angle-double-left"></span> Back to Search Criteria Window</button>
                <button type="button" class="btn btn-success btn-sm" data-dismiss="modal" id="ignore-and-create"> Ignore and Create New</button>
                <button type="button" class="btn btn-success btn-sm" id="select-active-record" data-id="#"> Select Active Record</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->