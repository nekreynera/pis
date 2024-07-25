<div id="requisitionModal" class="modal" role="dialog">
    <div class="modal-dialog modal-xl">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-center">Medicine Records</h4>
            </div>
            <div class="modal-body">
                <br>

                <div class="loaderWrapper col-md-1 bg-danger text-center">
                    <img src="{{ asset('public/images/loader.svg') }}" alt="loader" class="img-responsive" />
                    <p>Please Wait...</p>
                </div>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>PATIENT NAME</th>
                            <th>CLINIC/DEPARTMENT</th>
                            <th>PHARMACIST/DOCTOR</th>
                            <th>REQUISITION DATE</th>
                            <th>ACTION</th>
                        </tr>
                        </thead>
                        <tbody class="requisitionListTbody">
                        </tbody>
                    </table>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>