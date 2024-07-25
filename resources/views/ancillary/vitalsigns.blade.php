
<link href="{{ asset('public/css/patients/register.css') }}" rel="stylesheet" />
<link href="{{ asset('public/css/triage/triage_support.css') }}" rel="stylesheet" />

<div id="vitalsigns-modal" class="modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content" style="text-align: left!important;">
      <div class="modal-body">
        <div class="row">

            <div class="col-md-6 patient_info">
                <h2 class="text-center">PATIENT INFO</h2>
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                        <tr>
                            <td>Name:</td>
                            <td class="v-name v-text"></td>
                        </tr>
                        <tr>
                            <td>Hospital:</td>
                            <td class="v-hospital v-text"></td>
                        </tr>
                        <tr>
                            <td>Barcode:</td>
                            <td class="v-barcode v-text"></td>
                        </tr>
                        <tr>
                            <td>Birthday:</td>
                            <td class="v-birthday v-text">
                                
                            </td>
                        </tr>
                        <tr>
                            <td>Age:</td>
                            <td class="v-age v-text">25</td>
                        </tr>
                        <tr>
                            <td>Address:</td>
                            <td class="v-address v-text"></td>
                        </tr>
                        <tr>
                            <td>Civil Status:</td>
                            <td class="v-status v-text"></td>
                        </tr>
                        <tr>
                            <td>Sex:</td>
                            <td class="v-sex v-text"></td>
                        </tr>
                        <tr>
                            <td>Contact No:</td>
                            <td class="v-contact v-text"></td>
                        </tr>
                        <tr>
                            <td>DateRegistered:</td>
                            <td class="v-date v-text"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>



            <div class="col-md-6">
                <h2 class="text-center">VITAL SIGNS</h2>
                <form>

                    <input type="hidden" class="v-patients_id" name="patients_id" />

                    <div class="form-group @if ($errors->has('clinic_code')) has-error @endif" style="display: none;">
                        <label>Assign Clinic</label>
                        <select name="clinic_code" readonly="" class="form-control select">
                            <option value="">--Select Clinic--</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Blood Pressure</label>
                                <div class="input-group">
                                    <input type="text" name="blood_pressure" class="form-control blood_pressure vital-input" value=""
                                           placeholder="Enter Blood Pressure" />
                                    <div class="input-group-addon">BP</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Pulse Rate</label>
                                <div class="input-group">
                                    <input type="text" name="pulse_rate" class="form-control pulse_rate vital-input" value="" placeholder="Enter Pulse Rate" />
                                    <div class="input-group-addon">BPM</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Respiration Rate</label>
                                <div class="input-group">
                                    <input type="text" name="respiration_rate" class="form-control respiration_rate vital-input" value=""
                                           placeholder="Enter Respiration Rate" />
                                    <div class="input-group-addon">RM</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Body Temperature</label>
                                <div class="input-group">
                                    <input type="text" name="body_temperature" class="form-control body_temperature vital-input" value=""
                                           placeholder="Enter Body Temperature" />
                                    <div class="input-group-addon">°C</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Weight</label>
                                <div class="input-group">
                                    <input type="text" name="weight" class="form-control weight vital-input" value="" placeholder="Enter Weight" />
                                    <div class="input-group-addon">KG.</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Height</label>
                                <div class="input-group">
                                    <input type="text" name="height" class="form-control height vital-input" value="" placeholder="Enter Height" />
                                    <div class="input-group-addon">CM.</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group text-right">
                        <br/>
                        <button type="button" class="btn btn-success btn-vital-sign">
                            Submit <i class="fa fa-arrow-right"></i>
                        </button>
                    </div>

                </form>
            </div>
          </div>
          <div class="modal-footer">
            
            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><span class="fa fa-remove"></span> Close</button>
          </div>
        </div>

      </div>
    </div>
</div>
