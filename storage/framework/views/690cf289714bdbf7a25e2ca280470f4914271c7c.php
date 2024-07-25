<div class="modal" id="modal-info-list">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                Service Information
            </div>
            <div class="modal-body">
                <?php echo $__env->make('OPDMS.partials.loader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <div class="table-responisve">
                    <table class="table table-striped table-hover" id="list-information-table">
                        <tbody>
                            <tr>
                                <td class="bg-gray">Pathology</td>
                                <td class="pathology text-uppercase"></td>
                            </tr>
                            <tr>
                                <td class="bg-gray">Group</td>
                                <td class="group text-capitalize"></td>
                            </tr>
                            <tr>
                                <td class="bg-gray">Service Name</td>
                                <td class="service"></td>
                            </tr>
                            <tr>
                                <td class="bg-gray">Price</td>
                                <td class="text-right price"><font>₱ 0.00</font></td>
                            </tr>
                            <tr>
                                <td class="bg-gray">Status</td>
                                <td class="status"> <small class="label bg-green"> Active </small> </td>
                            </tr>
                            <tr>
                                <td class="bg-gray">Created At</td>
                                <td class="created">12/14/2018 8:43 PM</td>
                            </tr>
                            <tr>
                                <td class="bg-gray">Updated At</td>
                                <td class="updated">12/14/2018 8:43 PM</td>
                            </tr>
                            
                        </tbody>
                    </table>
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