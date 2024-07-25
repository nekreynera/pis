<div class="modal" id="modal-edit-patient">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    @include('OPDMS.partials.loader')
                    <form class="form-horizontal" id="edit-form" method="POST" action="#">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <label>PATIENT INFORMATION</label>
                                    <div class="box-tools pull-right">
                                        <small>
                                            <span class="fa fa-info-circle"></span>
                                            Fields mark with <b class="text-red">*</b> are required
                                        </small>
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <div class="col-md-12 col-sm-12 divider">
                                        <div class="row">
                                            <div class="col-md-4 col-sm-4">
                                                <label>Hospital No</label>
                                                <input type="number" name="hospital_no" class="form-control hospital_no text-uppercase" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4 divider">
                                        <label>Last Name <b class="text-red">*</b></label>
                                        <input type="text" name="last_name" class="form-control last_name text-uppercase" placeholder="Enter Last Name">
                                    </div>

                                    <div class="col-md-4 col-sm-4 divider">
                                        <label>First Name <b class="text-red">*</b></label>
                                        <input type="text" name="first_name" class="form-control first_name text-uppercase" placeholder="Enter First Name">
                                    </div>

                                    <div class="col-md-2 col-sm-2 divider" style="padding-right: 0px;">
                                        <label>Middle Name</label>
                                        <input type="text" name="middle_name" class="form-control middle_name text-uppercase" placeholder="Enter Middle Name">
                                    </div>

                                    <div class="col-md-2 col-sm-2 divider">
                                        <label>Suffix</label>
                                        <select name="suffix" class="form-control suffix">
                                            <option value="">--</option>
                                            <option>Jr</option>
                                            <option>Sr</option>
                                            <option>Sra</option>
                                            <option>II</option>
                                            <option>III</option>
                                            <option>IV</option>
                                            <option>V</option>
                                            <option>VI</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 col-sm-3 divider" style="padding-right: 0px;">
                                        <label>Birth Date <b class="text-red">*</b></label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" name="birthday" class="form-control birthday asdasd" id="datemask1" data-inputmask="'alias': 'mm/dd/yyyy'" data-mask>
                                        </div>
                                    </div>
                                    <div class="col-md-1 col-sm-1 divider">
                                        <label>Age</label>
                                        <input type="text" name="age" class="form-control calculated-age text-center" readonly>
                                    </div>
                                    <div class="col-md-2 col-sm-2 divider" id="sexdiv">
                                        <label>Sex <b class="text-red">*</b></label>
                                        <select name="sex" class="form-control sex">
                                            <option value="" hidden>--</option>
                                            <option value="M">Male</option>
                                            <option value="F">Female</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 col-sm-2 divider" id="statusdiv">
                                        <label>Civil Status</label>
                                        <select name="civil_status" class="form-control civil_status">
                                            <option value="" hidden>--</option>
                                            <option>New Born</option>
                                            <option>Child</option>
                                            <option>Single</option>
                                            <option>Married</option>
                                            <option>Common Law</option>
                                            <option>Widow</option>
                                            <option>Separated</option>
                                            <option>Divorce</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 col-sm-4 divider">
                                        <label>Contact No</label>
                                        <input type="text" name="contact_no" class="form-control contact_no" placeholder="Enter Contact Number">
                                    </div>
                                    <div class="col-md-8 col-sm-8 divider"> 
                                        <label>Permanent Address <b class="text-red">*</b></label>
                                        <input type="text" name="address" class="form-control address edit-address" action="edit" id="address" placeholder="Enter Patient Address">
                                    </div>
                                    <div class="col-md-4 col-sm-4 divider">
                                        <label>Referral</label>
                                        <select name="referral" class="form-control referral">
                                            <option value="no">No</option>
                                            <option value="yes">Yes</option>
                                        </select>
                                    </div>
                                    <input type="hidden" name="city_municipality" class="city_municipality_modal">
                                    <input type="hidden" name="brgy" class="brgy_modal">
                                </div>
                            </div>
                        </div>
                       
                        <div class="col-md-12 vital-signs-coontainer">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <label>VITAL SIGNS AND ASSIGNATION</label>
                                    <div class="box-tools pull-right">
                                        <small>
                                            <span class="fa fa-info-circle"></span>
                                            This form is only visible if the patient is currently registering or registered today.
                                        </small>
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="col-md-12 col-sm-12 divider">
                                        <label class="">Assign Clinic</label>
                                        <select name="clinic_code" class="form-control select2 clinic_code" style="width: 100%">
                                            <option value="" hidden=>--</option>
                                        </select>
                                    </div>

                                   
                                    <div class="col-md-4 col-sm-4 divider">
                                        <label>Blood Pressure</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                BP
                                            </div>
                                            <input type="text" name="blood_pressure" class="form-control blood_pressure">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4 divider">
                                        <label>Pulse Rate</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                BPM
                                            </div>
                                            <input type="text" name="pulse_rate" class="form-control pulse_rate">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4 divider">
                                        <label>Respiration Rate</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                RM
                                            </div>
                                            <input type="text" name="respiration_rate" class="form-control respiration_rate">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4 divider">
                                        <label>Body Temperature</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                °C
                                            </div>
                                            <input type="text" name="body_temperature" class="form-control body_temperature">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4 divider">
                                        <label>Weight</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                KG.
                                            </div>
                                            <input type="text" name="weight" class="form-control weight">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4 divider">
                                        <label>Height</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                CM.
                                            </div>
                                            <input type="text" name="height" class="form-control height">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left btn-sm" data-dismiss="modal"><span class="fa fa-close"></span> Close</button>
                <button type="submit" class="btn btn-success btn-sm" form="edit-form"><span class="fa fa-save"></span> Update</button>
            </div>
        </div>
    <!-- /.modal-content -->
    </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->