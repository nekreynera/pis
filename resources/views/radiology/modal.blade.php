<div id="radiologyModal" class="modal" role="dialog">
    <div class="modal-dialog modal-xxl">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-center">Radiology Requests</h4>
            </div>
            <div class="modal-body">

                <h4 class="text-danger">
                    <small>Patient Name: </small><strong id="patientName">JUAN TAMAD SANTOS</strong>
                </h4>

                <br>

                @include('message.loader')

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Requested By</th>
                                <th>Clinic</th>
                                <th>Category</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Transaction</th>
                                <th>Date</th>
                                <th>Print</th>
                                <th>Edit</th>
                                <th>Add</th>
                            </tr>
                        </thead>
                        <tbody id="radiologyModalBody">
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