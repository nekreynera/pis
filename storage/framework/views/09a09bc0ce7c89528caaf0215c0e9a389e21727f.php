
<div id="patientinfo-modal" class="modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content" style="text-align: left!important;">
      <div class="modal-body">

            <div class="row notificationsWrapper">

                    <div class="col-md-12 refferal-info" style="display: none">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <p class="text-danger text-center"><strong>This patient has a pending &nbsp; <b style="color: red;font-size: 25px"> Referral </b> &nbsp; to this clinic.</strong></p>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>PATIENT</th>
                                            <th>FROM_CLINIC</th>
                                            <th>REFFERED_BY</th>
                                            <th>TO_CLINIC</th>
                                            <th>REFFERED_TO</th>
                                            <th>REASON</th>
                                            <th>STATUS</th>
                                            <th>DATE</th>
                                        </tr>
                                        </thead>
                                        <tbody class="referraltbody">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>



                <div class="col-md-12 pending-info" style="display: none">
                    
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <p class="text-danger text-center"><strong>This patient has a pending &nbsp; <b style="color: red;font-size: 25px"> Followup </b> &nbsp; schedule to this clinic.</strong></p>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>TO_DOCTOR</th>
                                        <th>CLINIC</th>
                                        <th>REASONS</th>
                                        <th>STATUS</th>
                                        <th>FF DATE</th>
                                        
                                    </tr>
                                    </thead>
                                    <tbody class="pendingtbody">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        <div class="row">
            
            <div class="col-md-8">
                <h2 class="text-center">PATIENT INFORMATION</h2>
                <br>
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table patientInfo">
                            <tbody>
                            <tr>
                                <td>HOSPITAL NO:</td>
                                <td class="hospitalno d-text"></td>
                            </tr>
                            <tr>
                                <td>BARCODE:</td>
                                <td class="barcode d-text"></td>
                            </tr>
                            <tr>
                                <td>NAME:</td>
                                <td class="name d-text"></td>
                            </tr>
                            <tr>
                                <td>BIRTHDAY:</td>
                                <td class="birhtday d-text"></td>
                            </tr>
                            <tr>
                                <td>AGE:</td>
                                <td class="age d-text">
                                    
                                </td>
                            </tr>
                            <tr>
                                <td>ADDRESS:</td>
                                <td class="address d-text"></td>
                            </tr>
                            <tr>
                                <td>SEX:</td>
                                <td class="sex d-text">
                                </td>
                            </tr>
                            <tr>
                                <td>CIVIL STATUS:</td>
                                <td class="civilstat d-text"></td>
                            </tr>
                            <tr>
                                <td>MSS CLASSIFICATION</td>
                                <!-- <td class="mssclass d-text"></td> -->
                                <td>N/A</td>
                            </tr>
                            <tr>
                                <td>DATE REGISTERED:</td>
                                <td class="datereg d-text"></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <h2 class="text-center">VITAL SIGNS</h2>
                <br>
                <table class="table vitalSigns">

                    <tbody>
                    <tr>
                        <td>Blood Pressure:</td>
                        <td class="bloodpressure d-text"></td>
                    </tr>
                    <tr>
                        <td>Pulse Rate:</td>
                        <td class="pulserate d-text"></td>
                    </tr>
                    <tr>
                        <td>Respiration Rate:</td>
                        <td class="resprate d-text"></td>
                    </tr>
                    <tr>
                        <td>Body Temperature:</td>
                        <td class="btemp d-text"></td>
                    </tr>
                    <tr>
                        <td>Weight:</td>
                        <td class="weight d-text"></td>
                    </tr>
                    <tr>
                        <td>Height:</td>
                        <td class="height d-text"></td>
                    </tr>
                    <tr>
                        <td>BMI(metric):</td>
                        <td class="bmi d-text">
                        </td>
                    </tr>
                    </tbody>
                    <tfoot>
                        <tr class="dateexamined">
                        </tr>
                    </tfoot>
                </table>
            </div>

        </div>
      </div>
      <div class="modal-footer">
        
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><span class="fa fa-remove"></span> Close</button>
      </div>
    </div>

  </div>
</div>
 
