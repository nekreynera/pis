<div id="quickViewModal" class="modal" role="dialog">
    <div class="modal-dialog modal-xl">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-center">Radiology Requests</h4>
            </div>

            <div class="modal-body">


                @include('message.loader')


                <div class="text-right">
                    <a href="#" class="btn btn-success" id="editResultAnchor" target="_blank">
                        Edit <i class="fa fa-pencil"></i></a>
                    </a>
                    <a href="#" class="btn btn-primary" id="printResultAnchor" target="_blank">
                        Print <i class="fa fa-print"></i></a>
                    </a>
                </div>


                <div class="tab-content">

                    <div id="quickViewContent" class="tab-pane fade in active">
                    </div>

                </div>





            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>