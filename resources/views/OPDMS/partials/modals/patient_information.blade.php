<div class="modal" id="patient_information_modal">





    <div class="modal-dialog modal-lg">


        @include('OPDMS.partials.loader') {{-- loader icon --}}


        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">


                <div class="row">

                    <div class="col-md-8">
                        <h4 class="text-primary text-center">
                            Patient Information
                            <i class="fa fa-user-circle-o"></i>
                        </h4>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <tbody>
                                <tr>
                                    <td>Full Name:</td>
                                    <td><strong ref="patient_full_name"></strong></td>
                                </tr>
                                <tr>
                                    <td>Hospital No:</td>
                                    <td ref="hospital_no"></td>
                                </tr>
                                <tr>
                                    <td>QR-Code:</td>
                                    <td ref="patient_qrcode"></td>
                                </tr>
                                <tr>
                                    <td>Birthday:</td>
                                    <td ref="patient_birthday"></td>
                                </tr>
                                <tr>
                                    <td>Address:</td>
                                    <td ref="patient_address" class="text-uppercase"></td>
                                </tr>
                                <tr>
                                    <td>Sex:</td>
                                    <td ref="patient_sex"></td>
                                </tr>
                                <tr>
                                    <td>Civil Status:</td>
                                    <td ref="patient_civil_status"></td>
                                </tr>
                                <tr>
                                    <td>MSS Classification:</td>
                                    <td ref="patient_mss"></td>
                                </tr>
                                <tr>
                                    <td>Date Registered:</td>
                                    <td ref="patient_date_reg"></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>


                    <div class="col-md-4">
                        <h4 class="text-center text-red">
                            Vital Signs
                            <i class="fa fa-heartbeat"></i>
                        </h4>
                        <div class="table-responsive">

                            <table class="table table-bordered table-striped table-hover">
                                <tbody>
                                    <tr>
                                        <td>Blood Pressure:</td>
                                        <td ref="bp">></td>
                                    </tr>
                                    <tr>
                                        <td>Pulse Rate:</td>
                                        <td ref="pr"></td>
                                    </tr>
                                    <tr>
                                        <td>Respiration Rate:</td>
                                        <td ref="rr"></td>
                                    </tr>
                                    <tr>
                                        <td>Body Temperature:</td>
                                        <td ref="bt"></td>
                                    </tr>
                                    <tr>
                                        <td>Weight:</td>
                                        <td ref="weight"></td>
                                    </tr>
                                    <tr>
                                        <td>Height:</td>
                                        <td ref="height"></td>
                                    </tr>
                                </tbody>
                            </table>

                            <a href="" class="btn pull-right btn-sm btn-flat bg-red">
                                Measure Vital Signs
                            </a>
                        </div>
                    </div>

                </div>




            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-flat btn-default pull-left" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>