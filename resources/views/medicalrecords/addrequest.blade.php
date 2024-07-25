@component('partials/header')

  @slot('title')
    PIS | MEDICAL RECORDS
  @endslot

  @section('pagestyle')
    <link href="{{ asset('public/css/medicalrecords/addrequest.css') }}" rel="stylesheet" />
  @endsection

  @section('header')
    @include('medicalrecords/navigation')
  @endsection

  @section('content')
    <div class="container">
        <br><br>
         <div class="table-responsive" id="patientinfo-table">
                <table class="table table-bordered">
                    <thead>
                        <tr style="background-color: #e6e6e6;">
                          <th colspan="2" class="text-center" width="50%"><span class="fa fa-user-o"></span> PATIENT INFORMATION</th>
                          <th class="text-center" width="50%"><span class="fa fa-level-down"></span> REQUEST</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>HOSPITAL NO:</td>
                            <td class="hosp_no">{{ $pt->hospital_no }}</td>
                            <td rowspan="9">
                                <form class="form-horizontal" method="POST" action="{{ url('addrequest') }}">
                                  {{ csrf_field() }}
                                  <button type="submit" class="btn btn-success btn-sm"><span class="fa fa-save"></span> Save and Charge</button>
                                  <button type="button" class="btn btn-default btn-sm" id="add-request"><span class="fa fa-plus"></span> Add</button>
                                  <input type="hidden" name="ptid" value="{{ $pt->patients_id }}">
                                  <div class="request-section">
                                      <br>
                                      <div class="request-row">
                                        <div class="form-group">
                                           <div class="col-md-12">
                                              <div class="input-group">
                                                <select class="form-control" name="ptrequest[]" style="font-size: 12px;">
                                                  <option value="" hidden>Select</option>
                                                  <option value="187">Medico Legal Report</option>
                                                  <option value="188">Medical Certificate</option>
                                                </select>
                                                <span class="input-group-addon fa fa-remove" id="remove-request" style="cursor: pointer;"></span>
                                              </div>
                                           </div>
                                        </div>
                                      </div>
                                  </div>
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <td>BARCODE:</td>
                            <td class="barcode">{{ $pt->barcode }}</td>
                        </tr>
                        <tr>
                            <td>NAME:</td>
                            <td class="ptname">{{ $pt->last_name.', '.$pt->first_name.' '.substr($pt->middle_name, 0,1) }}</td>
                        </tr>
                        <tr>
                            <td>BIRTHDAY:</td>
                            <td class="ptbday">{{ Carbon::parse($pt->birthday)->format('m/d/Y') }}</td>
                        </tr>
                        <tr>
                            <td>ADDRESS:</td>
                            <td class="ptaddress">{{ $pt->address }}</td>
                        </tr>
                        <tr>
                            <td>SEX:</td>
                            <td class="ptsex">{{ $pt->sex }}</td>
                        </tr>
                        <tr>
                            <td>CIVIL STATUS:</td>
                            <td class="ptcvstatus">{{ $pt->civil_status }}</td>
                        </tr>
                        <tr>
                            <td>MSS CLASSIFICATION</td>
                            <td class="ptmss">{{ $pt->label.'-'.$pt->description }}</td>
                        </tr>
                        <tr>
                            <td>DATE REGISTERED:</td>
                            <td class="ptcreated">{{ Carbon::parse($pt->created)->format('m/d/Y') }}</td>
                        </tr>
                      
                    </tbody>
                    
                </table>
            </div>
    </div>
    
  @endsection

  @section('pagescript')
    @include('message/toaster')
   
    <script src="{{ asset('public/js/medicalrecords/addrequest.js') }}"></script>

  @endsection

@endcomponent
