<div id="consultationDetailsModal" class="modal" role="dialog">
    <div class="modal-dialog modal-xl">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-center" id="recordsHeader">Consultation Details</h4>
            </div>
            <div class="modal-body">

                <?php echo $__env->make('message.loader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                <div class="">

                    

                    <a href="" target="_blank" class="btn btn-sm btn-primary consultationFormEdit">
                        <i class="fa fa-pencil"></i> Edit
                    </a>
                    <a href="" target="_blank" class="btn btn-sm btn-success consultationFormPrint">
                        <i class="fa fa-print"></i> Print
                    </a>
                </div>

                <div class="consultationContent">
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
