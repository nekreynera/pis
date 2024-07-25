<div class="modal" id="modal-opd-doctor">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                OPD Doctors
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <label>Please select a requesting physician with the assigned clinic. </label> <br>
                    <label style="margin-left: 10px;">Click <button type="button" class="btn btn-default btn-flat btn-sm add-new-doctor" title="Click me to add doctor"><span class="fa fa-plus"></span></button>
                     to add doctor name to the list of requesting physician</label> <br>
                    <label style="margin-left: 10px;">Choose <b> N/A</b> if the name of the doctor is not applicable/not readable</label>

                    <div class="row">
                        <div class="col-md-10 col-sm-10 col-xs-10">
                            <select name="user_id" class="form-control doctor_id select2" style="width: 100%">
                                
                            </select>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-2">
                            <button type="button" class="btn btn-default btn-flat  add-new-doctor" title="Click me to add doctor"><span class="fa fa-plus"></span></button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left btn-sm" data-dismiss="modal"><span class="fa fa-close"></span> Close</button>
                <button type="submit" class="btn btn-success btn-sm" form="pendingrequesrform" id="save"><span class="fa fa-save"></span> Save</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->