<div class="modal" id="modal-undone-transaction">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                Undone | Move Back to Pending Transaction
            </div>
            <div class="modal-body">
                <div class="text-right">
                    <small class="">
                        <span class="fa fa-info-circle"></span>
                        Fields mark with <b class="text-red">*</b> are required
                    </small>
                </div>
                <?php echo $__env->make('OPDMS.partials.loader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="remove-table">
                        <thead>
                            <tr class="bg-gray">
                                <th hidden></th>
                                <th>Services</th>
                                <th>Done By</th>
                                <th>Done Datetime</th>
                            </tr>
                        </thead>
                        <tbody id="remove-tbody">
                        </tbody>
                    </table>
                </div>
                <form class="form-horizontal" id="undone-form" method="POST" action="<?php echo e(url('markedlaboratoryrequestasundone')); ?>">
                    <?php echo e(csrf_field()); ?>

                    <label>Remarks <b class="text-red">*</b></label>
                    <textarea class="form-control remarks" placeholder="Input your reason(s) here.." rows="5"></textarea>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left btn-sm" data-dismiss="modal"><span class="fa fa-close"></span> Close</button>
                <button type="submit" class="btn btn-success btn-sm" form="undone-form"><span class="fa fa-angle-double-right"></span> Proceed</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->