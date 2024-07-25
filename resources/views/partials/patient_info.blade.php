<!-- Modal -->
<div id="patient_infoModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">


        <div class="loaderRefresh" style="position: fixed">
            <div class="loaderWaiting">
                <i class="fa fa-spinner fa-spin"></i>
                <span> Please Wait...</span>
            </div>
        </div>


        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">


                <div class="row">
                    <div class="col-md-7">
                        <h5 class="text-center">Patient Information <i class="fa fa-user-circle-o"></i></h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <td>HOSPITAL NO.:</td>
                                    <td id="hosp_noTD"></td>
                                </tr>
                                <tr>
                                    <td>BARCODE:</td>
                                    <td id="barTD"></td>
                                </tr>
                                <tr>
                                    <td>NAME:</td>
                                    <td id="nameTD"></td>
                                </tr>
                                <tr>
                                    <td>BIRTHDAY:</td>
                                    <td id="birtTD"></td>
                                </tr>
                                <tr>
                                    <td>ADDRESS:</td>
                                    <td id="addressTD"></td>
                                </tr>
                                <tr>
                                    <td>SEX:</td>
                                    <td id="sexTD"></td>
                                </tr>
                                <tr>
                                    <td>CIVIL STATUS:</td>
                                    <td id="cvTD"></td>
                                </tr>
                                <tr>
                                    <td>MSS CLASSIFICATION:</td>
                                    <td id="mssTD"></td>
                                </tr>
                                <tr>
                                    <td>DATE REGISTERED:</td>
                                    <td id="dateTD"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <h5 class="text-center">Vital Signs <i class="fa fa-heartbeat text-danger"></i></h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <td>Blood Pressure</td>
                                    <td id="bpTD"></td>
                                </tr>
                                <tr>
                                    <td>Pulse Rate</td>
                                    <td id="prTD"></td>
                                </tr>
                                <tr>
                                    <td>Respiration Rate</td>
                                    <td id="rrTD"></td>
                                </tr>
                                <tr>
                                    <td>Body Temperature</td>
                                    <td id="btTD"></td>
                                </tr>
                                <tr>
                                    <td>Weight</td>
                                    <td id="weightTD"></td>
                                </tr>
                                <tr>
                                    <td>Height</td>
                                    <td id="heightTD"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>