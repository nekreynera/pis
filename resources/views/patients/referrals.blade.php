<!-- Modal -->
<div id="referralModal" class="modal" role="dialog">
    <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">REFERRAL FORM <i class="fa fa-file-o"></i></h4>
        </div>
        <div class="modal-body" id="addressWrapper">
              
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="">Referring Facility</label>
                            <div class="input-group">
                                <!-- <input type="" name="facility" class="form-control" placeholder="Enter Hospital/Facility"> -->
                                <select class="form-control" name="facility">
                                    <option value="0" hidden>Select</option>
                                    @foreach($facility as $list)
                                     <option value="{{ $list->id }}">{{ $list->hospital }}</option>
                                    @endforeach
                                </select>
                                <span class="input-group-addon"><i class="fa fa-hospital-o"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                         <div class="form-group">
                            @php
                                $date = Carbon::now()->format('m/d/Y h:i:a');
                            @endphp
                            <label class="">Date and Time of Referral</label>
                            <input type="" name="datetime" class="form-control" value="{{ $date }}" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                         <div class="form-group">
                            <label class="">Referring Physician</label>
                            <div class="input-group">
                                 <input type="" name="physician" class="form-control" placeholder="Enter Physician Name">
                                <span class="input-group-addon"><i class="fa fa-user-md"></i></span>   
                            </div>
                        </div>
                    </div>
                     <div class="col-md-6">
                         <div class="form-group">
                            <label class="">In Patient/ Out Patient</label>
                            <select name="ward" class="form-control referral-ward">
                                <option value="out">Out - Patient</option>
                                <option value="in">In - Patient</option>
                               
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="">Chief Complaint</label>
                            <textarea name="complaint" class="form-control" placeholder="Enter Chief Complaint..."></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                         <div class="form-group">
                            <label class="">Specific Reason for Referral</label>
                            <textarea name="reason" class="form-control" placeholder="Enter Reason why Patient was referred..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="">Initial Diagnosis</label>
                    <textarea name="initial" class="form-control input-diagnosis"  placeholder="Enter Initial Diagnosis"></textarea>
                    <div class="diagnosis">
                        <div class="table-responsive table-diagnosis" >
                            <table class="table table-striped table-bordered">
                                
                                <tbody>
                                    @foreach($diagnosis as $list)
                                        <tr>
                                            <td align="center"><input type="checkbox" class="select-id" name="initial_id[]" style="height: 13px; width: 13px;" value="{{ $list->id }}"></td>
                                            <td class="select-diagnosis">{{ $list->diagnosis }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <button type="button" class="btn btn-success btn-close" style="position: absolute;z-index: 2;right: 35px;">Close <span class="fa fa-remove"></span></button>
                    </div>
                </div>
                <div class="out-patient">
                     <div class="form-group">
                        <label class="">Clinic where patient was consulted</label>
                        <select name="refclinic" class="form-control">
                            <option value="0">Select</option>
                            @foreach($clinics as $list)
                            <option value="{{ $list->id }}">{{ $list->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="in-patient" hidden>
                    <div class="form-group">
                        <label class="">Admitting Diagnosis</label>
                        <textarea name="admitting" class="form-control input-admitting-diagnosis"  placeholder="Enter Admitting Diagnosis"></textarea>
                        <div class="admitting">
                            <div class="table-responsive table-admitting-diagnosis">
                                <table class="table table-striped table-bordered">
                                    
                                    <tbody>
                                        @foreach($diagnosis as $list)
                                            <tr>
                                                <td align="center"><input type="checkbox" class="select-admitting-id" name="admitting_id[]" style="height: 13px; width: 13px;" value="{{ $list->id }}"></td>
                                                <td class="select-admitting">{{ $list->diagnosis }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <button type="button" class="btn btn-success btn-admitting-close" style="position: absolute;z-index: 2;right: 35px;">Close <span class="fa fa-remove"></span></button>
                        </div>
                    </div>
                     <div class="form-group">
                        <label class="">Area where patient is admitted</label>
                        <select name="area" class="form-control">
                            <option value="0" hidden>Select</option>
                            @foreach($ward as $list)
                            <option value="{{ $list->id }}">{{ $list->ward }}</option>
                            @endforeach

                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-md-offset-6">
                        <div class="form-group">
                            <label>Accompanying personnel during the referral</label>
                            <input name="accompanying" type="text" name="" class="form-control" placeholder="Enter Companion's Name">
                        </div>
                        
                    </div>
                </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success" data-dismiss="modal">
                OK <i class="fa fa-check"></i>
            </button>
        </div>
    </div>
    </div>
</div>