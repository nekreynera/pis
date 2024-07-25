@component('partials/header')

    @slot('title')
        PIS | CASHIER
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/css/doctors/reset.css') }}" rel="stylesheet" />
    @if(Auth::user()->theme == 2)
        <link href="{{ asset('public/css/doctors/darkstyle.css') }}" rel="stylesheet" />
    @else
        <link href="{{ asset('public/css/doctors/greenstyle.css') }}" rel="stylesheet" />
    @endif
        <link href="{{ asset('public/css/cashier/main.css') }}" rel="stylesheet" />
        <link href="{{ asset('public/css/cashier/manual.css') }}" rel="stylesheet" />
        <link href="{{ asset('public/css/cashier/income.css') }}" rel="stylesheet" />

@endsection



@section('header')
    @include('cashier.navigation')
@stop



@section('content')
    @component('cashier/dashboard')
        @section('main-content')
            <div class="container-fluid cashier-container" style="margin-top: 70px;">
                <div class="col-md-9">
                        <div class="col-md-12">
                            <input type="hidden" name="mss_discount" class="mss_discount" value="">
                            <div class="row patient-information">
                                <div class="col-sm-3">
                                    <div class="form-group ">
                                    <label class="">NAME</label>
                                    <div class="form-group" >
                                        <input type="text" name="" class="form-control patient_name">
                                    </div>
                                </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group ">
                                        <label class="">CLASSIFICATION</label>
                                        <div class="formgroup">
                                            <input type="text" name="" class="form-control patient_classification">
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="">SEX</label>
                                        <div class="formgroup">
                                            <input type="text" name="" class="form-control patient_sex">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="">CONTACT NO</label>
                                        <div class="form-group">
                                            <input type="text" name="" class="form-control patient_contact">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                    <div class="col-md-12">
                                        
                        <div class="row text-center cashier-banner">
                            <div class="addbutton pull-left">
                                <label>Number of Request.</label>
                                <select id="participants" class="input-mini required-entry">
                                    <?php for ($i=1; $i <= 15 ; $i++): ?>
                                    <option id="lineno" value="<?php echo $i ?>"><?php echo $i ?></option>
                                    <?php endfor; ?>
                                </select>
                                <button class="btn btn-default add" type="button"><span class="glyphicon glyphicon-plus"></span></button>
                            </div>
                            <div class="addbuttonincome pull-left">
                                <label>Number of Request.</label>
                                <select id="participantsincome" class="input-mini required-entryincome">
                                    <?php for ($i=1; $i <= 15 ; $i++): ?>
                                    <option id="lineno" value="<?php echo $i ?>"><?php echo $i ?></option>
                                    <?php endfor; ?>
                                </select>
                                <button class="btn btn-default addincome" type="button"><span class="glyphicon glyphicon-plus"></span></button>
                            </div>
                            PATIENT REQUEST
                        </div>
                        <form class="submittransaction" method="post" target="_blank" action="{{ url('submittransaction') }}">
                        <div class="row forrequest">
                            <div class="table-responsive requestarea">
                                <table class="table table-hover table-striped table-bordered">
                                    <thead>
                                        <tr id="thead">
                                            <th>entry</th>
                                            <th>Pricing<b>(php)</b></th>
                                            <th>Qty</th>
                                            <th>Amount</th>
                                            <th class="th-discount" id="">Discount<b>(php)</b></th>
                                            <th>Net Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody class="itemsbody">
                                        @for($i=1;$i<=20;$i++)
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td width="100px;"></td>
                                                <td width="50"></td>
                                                <td width="100px;"></td>
                                                <td width="100px;"></td>
                                                <td width="100px;"></td>
                                            </tr>
                                        @endfor
                                      
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row cashier-footer text-right">
                           
                                {{ csrf_field() }}
                                <div class="transaction-content">
                                    
                                </div>
                                <a href="{{ url('cashier') }}" class="btn btn-default"><span class="fa fa-arrow-left"></span> CANCEL</a>
                               
                                <button type="submit" class="btn btn-default">PROCEED <span class="fa fa-arrow-right"></span></button> 
                                <a href="www.facebook.com" target="_blank" class="printthistrans" hidden>print</a>
                            
                        </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="row reciept-number">
                        <h3>O.R no. <br><b class="invoicno"></b></h3>    
                    </div>
                    <div class="row patient-payment">
                        <div class="header">
                            PAYMENT
                        </div>
                        <div class="form-group ">
                        <label class="col-sm-4">AMOUNT</label>
                            <div class="col-sm-8 formgroup">
                                <input type="text" name="tot_amount" class="form-control tot_amount" readonly> 
                            </div>
                        </div>
                        <div class="form-group ">
                        <label class="col-sm-4">DISCOUNT</label>
                            <div class="col-sm-8 formgroup">
                                <input type="text" name="tot_discount" class="form-control tot_discount" readonly> 
                            </div>
                        </div>
                        <div class="form-group ">
                        <label class="col-sm-3">TOTAL<b>(php)</b></label>
                            <div class="col-sm-9 formgroup">
                                <input type="text" name="tot_payment" class="form-control tot_payment" style="height: 50px;font-size: 20px;" readonly>   
                            </div>
                        </div>
                        <div class="form-group ">
                        <label class="col-sm-4">CASH<b>(php)</b></label>
                            <div class="col-sm-8 formgroup">
                                <input type="text" name="cash" class="form-control cash">
                            </div>
                                        </div>
                        <div class="form-group ">
                        <label class="col-sm-4">CHANGE</label>
                            <div class="col-sm-8 formgroup">
                                <input type="text" name="change" class="form-control change" readonly> 
                            </div>
                        </div>
                    </div>

                    <div class="row button-payment">
                        <div class="button-banner">
                            <label>TRANSACTIONS</label>
                        </div>
                        <div class="button-body">
                            <a class="btn btn-default printid" data-toggle="modal" data-target="#searchpatient-modal"><span class="fa fa-id-card"></span> HOSPITAL-ID</a>
                            <a class="btn btn-default printid" data-toggle="modal" data-target="#reprint-modal"><span class="fa fa-id-card"></span> RE-PRINT HOSPITAL-ID</a>
                            <a class="btn btn-default modal-button" id="income"><span class="fa fa-money"></span> INCOME</a>
                            <a class="btn btn-default modal-button" id="medicine"><span class="fa fa-medkit"></span> MEDICINE</a>
                            <a class="btn btn-default modal-button" id="manual"><span class="fa fa-keyboard-o"></span> MANUAL</a>
                            <a href="{{ url('transaction') }}" class="btn btn-default" target="_blank"><span class="fa fa-list-alt"></span> TRANSACTION</a>
                            <a data-toggle="modal" data-target="#editreciept-modal" class="btn btn-default"><span class="fa fa-list-alt"></span> EDIT O.R NO</a>
                            <a class="btn btn-default" data-toggle="modal" data-target="#setreciept-modal"><span class="fa fa-wpforms"></span> REPORT</a>
                        </div>
                        
                    </div>
                </div>
                
            </div>
            <div id="searchpatient-modal" class="modal" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            SELECT PATIENT
                        </div>
                        <div class="modal-body">
                            <div class="submitclassificationloader">
                              <img src="public/images/loader.svg">
                            </div>
                           <div class="row search-section">
                              <div class="col-md-9">
                                <div class="input-group">
                                  <input type="text" id="names" onkeyup="names()" class="form-control" placeholder="search by name..">
                                  <span class="input-group-addon fa fa-search"></span>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="input-group">
                                  <input type="text" id="hospital" onkeyup="hospital()" class="form-control" placeholder="hosp no..">
                                  <span class="input-group-addon fa fa-search"></span>
                                </div>
                              </div>
                              <div class="col-md-12 calendar">
                                  <a href="#" class="dropdown-toggle btn btn-default" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                      CHOOSE MONTH 
                                      <span class="caret"></span>
                                  </a>
                                  <ul class="dropdown-menu">
                                      @foreach($months as $list)
                                      <li><a href="#" class="choosemonth" id="{{ $list->months }}">{{ Carbon::parse($list->months)->format('M-Y') }}</a></li>
                                      @endforeach
                                     
                                  </ul>
                              </div>
                              <div class="col-md-12 table-th">
                                <div class="col-md-1">
                                  
                                </div>
                                <div class="col-md-3">
                                  Hosp No 
                                </div>
                                <div class="col-md-6">
                                  Name
                                </div>
                                <div class="col-md-2">
                                  Age
                                </div>
                                <div class="col-md-12 table-responsive">
                                  <table class="table table-hover table-striped" id="myTable">
                                    <tbody class="tablebody">
                                      @foreach($patients as $list)
                                      <tr >
                                        <td><input type="radio" name="names" id="not" class="radio check-patient" value="{{ $list->id }}" style="height:12px"></td>
                                        <td>{{ $list->hospital_no }}</td>
                                        <td>{{ $list->name }}</td>
                                        <td>{{ $list->age }}</td>
                                      </tr>
                                      @endforeach
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                           </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="" class="hidden_id">
                            <button type="button" class="btn btn-default cancelselect" data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-default selectpatient">Select</button>
                        </div>
                    </div>
              </div>
            </div>


            <div id="reprint-modal" class="modal" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            SELECT PATIENT &nbsp;(RE-PRINT PATIENT ID)
                        </div>
                        <div class="modal-body">
                            <div class="submitclassificationloader">
                              <img src="public/images/loader.svg">
                            </div>
                           <div class="row search-section">
                              <div class="col-md-9">
                                <div class="input-group">
                                  <input type="text" id="namess" onkeyup="namess()" class="form-control" placeholder="search by name..">
                                  <span class="input-group-addon fa fa-search"></span>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="input-group">
                                  <input type="text" id="hospitals" onkeyup="hospitals()" class="form-control" placeholder="hosp no..">
                                  <span class="input-group-addon fa fa-search"></span>
                                </div>
                              </div>
                              <div class="col-md-12 calendar">
                                  <a href="#" class="dropdown-toggle btn btn-default" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                      CHOOSE MONTH 
                                      <span class="caret"></span>
                                  </a>
                                  <ul class="dropdown-menu reprintmonths">
                                      
                                      
                                      
                                     
                                  </ul>
                              </div>
                              <div class="col-md-12 table-th">
                                <div class="col-md-1">
                                  
                                </div>
                                <div class="col-md-3">
                                  Hosp No 
                                </div>
                                <div class="col-md-6">
                                  Name
                                </div>
                                <div class="col-md-2">
                                  Age
                                </div>
                                <div class="col-md-12 table-responsive">
                                  <table class="table table-hover table-striped" id="myTables">
                                    <tbody class="tablebodys">
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                           </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="" class="hidden_id">
                            <button type="button" class="btn btn-default cancelselect" data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-default selectpatient">Select</button>
                        </div>
                    </div>
              </div>
            </div>


            <div id="scan-modal" class="modal" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            SCAN QRcode/Barcode
                        </div>
                        <div class="modal-body">
                            <form class="scanbarcode">
                                <div class="form-group">
                                    <input type="text" name="barcode" class="form-control barcodeinput" 
                                    placeholder="Scan or Enter Patient QRcode/Barcode" autofocus required />
                                   
                                </div>
                                <label class="error_msg" style="color: red;font-size: 12px;display: none;">patient classification expired 
                                    <a href="#" class="continue"> &nbsp;&nbsp;continue </a> 
                                </label>
                                <label class="error_msgs" style="color: red;font-size: 12px;display: none;">patient is not classified 
                                    <a href="#" class="continue"> &nbsp;&nbsp;continue </a> 
                                </label>
                                <label class="error_ms" style="color: red;font-size: 12px;display: none;">
                                </label>
                            </form>
                            <br/>
                            <br/>
                            <p class="text-center">
                                <strong>“ Credential for patients transactions ”</strong>
                            </p>
                            <p class="text-center">
                                Please scan/input patient barcode/QRcode so that the patient  <br>
                                requisition will be properly transact.
                            </p>
                            
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="" class="hidden_id">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
              </div>
            </div>
            <div id="editreciept-modal" class="modal" role="dialog">
                <div class="modal-dialog">
                    <form class="submitreciept">
                        <div class="modal-content">
                            <div class="modal-header">
                                EDIT RECIEPT NO
                            </div>
                            <div class="modal-body">
                                    <div class="form-group">
                                        <div class="bg-success text-center reciept-msg">
                                            <p>O.R number updated</p>
                                        </div>
                                        <div class="row">
                                            <br>
                                            <br>
                                             <div class="col-md-8" style="padding-right: 5px;">
                                                <input type="number" name="barcode" class="form-control input-reciept" 
                                            placeholder="" autofocus required /> 
                                            </div>
                                            <div class="col-md-4" style="padding-left: 5px;">
                                                <select class="form-control select-reciept" required>
                                                    <option value="" hidden>CHOOSE</option>
                                                    <option value="INCOME">INCOME</option>
                                                    <option value="MEDICINE">MEDICINE</option>
                                                </select>   
                                            </div>
                                            <br>
                                            <br>
                                        </div>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="" class="hidden_id">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-default">Save</button>
                            </div>
                        </div>
                    </form>
              </div>
            </div>
            <!-- .content-wrapper -->
        @endsection
    @endcomponent
@endsection




@section('footer')
@stop



@section('pagescript')
    @include('message.toaster')
    <script src="{{ asset('public/plugins/js/form.js') }}"></script>
    <script src="{{ asset('public/plugins/js/modernizr.js') }}"></script>
    <script src="{{ asset('public/plugins/js/jquery.menu-aim.js') }}"></script>
    <script src="{{ asset('public/js/pharmacy/main.js') }}"></script>
    <script src="{{ asset('public/js/cashier/main.js') }}"></script>
    <script src="{{ asset('public/js/cashier/id.js') }}"></script>
    <script src="{{ asset('public/js/cashier/medicine.js') }}"></script>
    <script src="{{ asset('public/js/cashier/manual.js') }}"></script>
    <script src="{{ asset('public/js/cashier/income.js') }}"></script>
@stop


@endcomponent
