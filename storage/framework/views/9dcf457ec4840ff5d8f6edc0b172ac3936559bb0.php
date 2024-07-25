<div class="modal modal-medical-records" id="modal-medical-records">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            Patient Medical Records
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-3 col-sm-3 side-bar-container">
                        
                        <ul class="sidebar-menu sidebar-special" data-widget="tree">

                            <li class="header">
                                CONSULTATION
                            </li>
                            <li data-id="consultation">
                                <a href="#">
                                    <i class="fa fa-file-text-o"></i>
                                    <span>Consultation</span>
                                    <span class="label bg-primary pull-right" id="consultation"></span>
                                </a>
                            </li>
                           
                            <li class="header">ANCILLARY</li>

                            <li data-id="10">
                                <a href="#">
                                    <i class="fa fa-flask"></i>
                                    <span>Laboratory</span>
                                    <span class="label bg-green pull-right" id="laboratory"></span>
                                </a>
                            </li>
                            <li data-id="11">
                                <a href="#">
                                    <i class="fa fa-universal-access"></i>
                                    <span>X-Ray</span>
                                    <span class="label bg-orange pull-right" id="x-ray"></span>
                                </a>
                            </li>
                            <li data-id="6">
                                <a href="#">
                                    <i class="fa fa-feed"></i>
                                    <span>Ultrasound</span>
                                    <span class="label bg-red pull-right" id="ultrasound"></span>
                                </a>
                            </li>
                            <li data-id="12">
                                <a href="#">
                                    <i class="fa fa-heartbeat"></i>
                                    <span>Electrocardiogram (ECG)</span>
                                    <span class="label label-info pull-right" id="ecg"></span>

                                </a>
                            </li>
                            <li data-id="1,2,3,4,5,7,8,9,13,14,15,17,18,19">
                                <a href="#">
                                    <i class="fa fa-circle-o"></i>
                                    <span>Others</span>
                                    <span class="label label-danger pull-right" id="others"></span>

                                </a>
                            </li>
                            <li class="header">APPOINTMENT</li>
                            <li data-id="referral">
                               <a href="#">
                                    <i class="fa fa-arrow-right"></i>
                                    <span>Referral</span>
                                    <span class="label label-warning pull-right" id="referral"></span>
                               </a> 
                            </li>
                            <li data-id="followup">
                                <a href="#">
                                    <i class="fa fa-undo"></i>
                                    <span>Follow-Up</span>
                                    <span class="label bg-teal pull-right" id="follow-up"></span>
                                </a> 
                            </li>

                        </ul>
                    </div>
                    <div class="col-md-9 col-sm-9 content-container">
                        <div class="mid-content-header">
                            <div class="col-md-9 col-sm-9">
                                <label>Patient Name:</label>
                                <font class="patient_name">loading...</font>
                            </div>
                            <div class="col-md-3 col-sm-3">
                                <label>Hospital No: </label>
                                <font class="hospital_no">loading...</font>
                            </div>
                        </div>
                        <div class="mid-content-body">
                            <div class="box box-primary">
                                <div class="box-body">
                                    <?php echo $__env->make('OPDMS.partials.loader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                    <div class="table-responsive" style="max-height: 370px;">
                                        <table class="table table-striped table-hover" id="medical-records-table">
                                            <thead class="medical-records-thead">
                                                
                                            </thead>
                                            <tbody class="medical-records-tbody">
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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




