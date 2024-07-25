<div class="modal" id="modal-scan-patient">
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
                <form class="form-horizontal" id="search-form" method="POST" action="<?php echo e(url('laboratorypatientscheck')); ?>">
                    <?php echo e(csrf_field()); ?>

                    <div class="form-group has-feedback">
                        <div class="col-md-12 text-right">
                            <label><i class="fa fa-barcode"></i> Qrcode / Hospital. No</label>
                        </div>
                        <div class="col-md-12">
                            <input type="text" name="hospital_no" class="form-control patient text-center">
                            <span class="fa fa-check form-control-feedback" id="scan-check"></span>
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <div class="col-md-12">
                            <label>Scan patient I.D. or input hospital no.</label>
                        </div>
                    </div>
                    <div class="alert alert-info alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-info"></i> Info!</h4>
                        If the patient is <b>walk-in</b>, manually type the unique walk-in number located at the upper right corner of the <b>EVRMC official receipt</b>. <br>
                        Example: <b>WALK-IN-000001</b> <br>

                        <p>Flow for the walk-in patient: </p>
                            <ol>
                                <li>Triage</li>
                                <li>Cashier</li>
                                <li>Diagnostics Center</li>
                            </ol>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left btn-sm" data-dismiss="modal"><span class="fa fa-close"></span> Close</button>
                <button type="submit" class="btn btn-success btn-sm" form="search-form"><span class="fa fa-search"></span> Search</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->