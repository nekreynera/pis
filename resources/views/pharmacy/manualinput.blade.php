@component('partials/header')

    @slot('title')
        PIS | Pharmacy
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/css/doctors/reset.css') }}" rel="stylesheet" />
    @if(Auth::user()->theme == 2)
        <link href="{{ asset('public/css/doctors/darkstyle.css') }}" rel="stylesheet" />
    @else
        <link href="{{ asset('public/css/doctors/greenstyle.css') }}" rel="stylesheet" />
    @endif
     <link href="{{ asset('public/css/pharmacy/manualrequest.css') }}" rel="stylesheet" />
     

@endsection



@section('header')
    @include('pharmacy.navigation')
@stop



@section('content')
    @component('pharmacy/dashboard')
        @section('main-content')


            <div class="content-wrapper" style="margin-left: 150px;padding-right: 20px;">
                <div class="banner">
                    <h3 class="text-left"> <i class="fa fa-user-md"></i> REQUISITION</h3>
                    @if(COUNT($requisition) > 0 || COUNT($managed) > 0 || COUNT($paid) > 0)
                       <body onload="$('#pendingtransaction-modal').modal('toggle')"></body>
                    @endif
                    
                </div>
                <div class="">
                    <br>
                </div>
                <div class="container-fluid">
                   
                    <div class="col-md-12 requsitionWrapper">
                        <div class="row">
                            <div class="col-md-3 departmentWrapper">
                                <table class="table table-condensed table-bordered">
                                    <tr>
                                        <th>PATIENT INFORMATION</th>
                                    </tr>
                                    <tr>
                                        <td><b>NAME: </b> {{ $patient->first_name.' '.$patient->middle_name.' '.$patient->last_name }}</td>
                                    </tr>
                                    <tr>
                                        @php
                                            $agePatient = App\Patient::age($patient->birthday)
                                        @endphp
                                        <td><b>AGE: </b> {{ $agePatient }}</td>
                                    </tr>
                                    <tr>
                                       @if(is_numeric($patient->description))
                                       <td><b>CLASSIFICATION: </b> {{ $patient->label.'-'.$patient->description }}%</td>
                                       @else
                                       <td><b>CLASSIFICATION: </b> {{ $patient->label.'-'.$patient->description }}</td>
                                       @endif
                                        
                                    </tr>
                                    <tr>
                                        <td><b>GENDER: </b> {{ ($patient->sex=='M')? 'MALE':'FEMALE' }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>ADDRESS: <br></b> {{ $patient->address }}</td>
                                        
                                    </tr>
                                </table>

                            </div>
                            <div class="col-md-9 requsitionSelection">
                                <div class="search-header">
                                    <form class="form-inline" onsubmit="return false">
                                        <div class="input-group">
                                            <input type="text" name="" class="form-control" id="searchbrand" placeholder="Search By Brand..." />
                                            <span class="input-group-addon fa fa-search"></span>
                                        </div>
                                        <div class="input-group">
                                            <input type="text" name="" class="form-control" id="searchdescription" placeholder="Search By Description..." />
                                            <span class="input-group-addon fa fa-search"></span>
                                        </div>
                                        <small class="pull-right"> &nbsp; Showing <strong id="countResults">{{ count($medicines) }}</strong> Results</small>
                                    </form>
                                </div>
                                <br/>
                                <div class="table-responsive tableWrapper">
                                    <div class="loaderWrapper">
                                        <img src="{{ asset('public/images/loader.svg') }}" alt="loader" class="img-responsive" />
                                        <p>Loading...</p>
                                    </div>
                                    
                                    <table class="table table-striped" id="itemsDeptTable">
                                        <thead>
                                            <tr>
                                                <th><i class="fa fa-info-circle"></i></th>
                                                <th>ITEM DESCRIPTION</th>
                                                <th>BRAND</th>
                                                <th>UNIT</th>
                                                <th>PRICE</th>
                                                <th>STOCKS</th>
                                            </tr>
                                        </thead>
                                        <tbody class="selectitemsTbody">
                                            @if(count($medicines))
                                                @foreach($medicines as $list)
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" data-id="{{ $list->id }}" class="check-item" />
                                                    </td>
                                                    <td class="item_description">
                                                        {{ $list->item_description }}
                                                    </td>
                                                    <td class="item_brand">
                                                        {!! ($list->brand)? $list->brand : '<span class="text-danger">N/A</span>' !!}
                                                    </td>
                                                    <td align="center" class="unitofmeasure">
                                                        {!! ($list->unitofmeasure)? $list->unitofmeasure : '<span class="text-danger">N/A</span>' !!}
                                                    </td>
                                                    <td align="right" class="price">
                                                        {{ number_format($list->price, 2, '.', '') }}
                                                    </td>
                                                    <td align="center" class="stocks">
                                                        {{ ($list->stock) }}
                                                    </td>
                                                </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="5" class="text-center">
                                                        <strong class="text-danger">NO RESULTS FOUND.</strong>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <br>
                        <div class="row seletecItemsWrapper">
                            <h5 class="text-center">
                                <b>SELECTED ITEMS</b>
                                @if(is_numeric($patient->description))
                                <b class="pull-right">CLASSIFICATION:  {{ $patient->label.'-'.$patient->description }}%</b>
                                @else
                                <b class="pull-right">CLASSIFICATION:  {{ $patient->label.'-'.$patient->description }}</b>
                                @endif
                            </h5>
                            <div class="table-responsive tableSelectedItems">
                                <form action="{{ url('pharmacystore') }}" method="post" id="requisitionpharform">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="patient_id" class="patient_id" value="{{ $patient->id }}">
                                    <input type="hidden" name="mss_id" class="mss_id" value="{{ $patient->mss_id }}">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th><i class="fa fa-info-circle"></i></th>
                                            <th>BRAND</th>

                                            <th>ITEM DESCRIPTION</th>
                                             <th>UNIT</th>
                                            <th>PRICE</th>
                                            <th>REQUISITION</th>
                                            <th>CONTROL</th>
                                            <th>AMOUNT</th>
                                            <th>DISCOUNT</th>
                                            <th>NET AMOUNT</th>
                                           
                                        </tr>
                                    </thead>

                                        <tbody class="selectedItemsTbody" id="{{ $patient->discount }}">
                                            <tr class="noSelectedTRwrapper">
                                                <td colspan="10" class="text-center">
                                                    <strong class="text-danger">NO SELETECD ITEMS.</strong>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tr>
                                            <th colspan="9">TOTAL</th>
                                            <th id="grndTotal"></th>
                                        </tr>
                                </table>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 requisition-footer" align="right">
                      <button type="button" class="btn btn-default btn-sm cancel">CANCEL</button>
                      <button type="button" id="saverequisition" class="btn btn-default btn-sm">SAVE REQUISITION</button>
                    </div>
                </div>               
            </div> 



            <!-- ======================pinding modal========================== -->

            <div id="pendingtransaction-modal" class="modal" role="dialog">
              <div class="modal-dialog">

                <!-- Modal content-->

                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"> PENDING TRANSACTIONS</h4>
                      </div>
                      <div class="modal-body">
                        <div class="table-responsive" style="max-height: 250px;">
                            <br>
                            <span class="count-badge">{{ count($requisition) }}</span>
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="success">
                                        <th colspan="4">REQUISITION</th>
                                    </tr>
                                    <tr>
                                        <th>REQUESTED BY</th>
                                        <th>TOTAL ITEM</th>
                                        <th>DATETIME</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody class="requisitionbody">
                                    @foreach($requisition as $list)
                                    <tr>
                                        <td>{{ $list->user_name }}</td>
                                        <td align="center">{{ $list->many }}</td>
                                        <td align="center">{{ $list->updated_at }}</td>
                                        <td align="center"><button class="btn btn-default btn-sm" id="viewpendingrequisition" orno="{{ $list->modifier }}" status="requisition">View <span class=" fa fa-eye"></span></button></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="table-responsive" style="max-height: 250px;">
                            <br>
                            <span class="count-badge">{{ count($managed) }}</span>
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="success">
                                        <th colspan="5">MANAGED</th>
                                    </tr>
                                    <tr>
                                        <th>PHARMACIST</th>
                                        <th>REQUESTED BY</th>
                                        <th>TOTAL ITEM</th>
                                        <th>DATETIME</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody class="managedbody">
                                    @foreach($managed as $list)
                                    <tr class="{{ $list->modifier }}">
                                        <td>{{ $list->user_name }}</td>
                                        <td>{{ $list->reqby }}</td>
                                        <td align="center">{{ $list->many }}</td>
                                        <td align="center">{{ $list->updated_at }}</td>
                                        <td align="center"><button class="btn btn-default btn-sm" id="viewmanagedrequisition" orno="{{ $list->modifier }}" status="unpaid">View <span class=" fa fa-eye"></span></button></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="table-responsive" style="max-height: 250px;">
                            <br>
                            <span class="count-badge">{{ count($paid) }}</span>
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="success">
                                        <th colspan="5">PAID/FREE</th>
                                    </tr>
                                    <tr>
                                        <th>CASHIER</th>
                                        <th>PHARMACIST</th>
                                        <th>TOTAL ITEM</th>
                                        <th>DATETIME</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($paid as $list)
                                    <tr>
                                        <td>@if($list->mss_id >= 9 && $list->mss_id <= 13){{ "CHARITY" }} @else {{ $list->user_name }} @endif</td>
                                        <td>{{ $list->pharmacist }}</td>
                                        <td align="center">{{ $list->many }}</td>
                                        <td align="center">{{ $list->updated_at }}</td>
                                        <td align="center"><button class="btn btn-default btn-sm" id="viewpaidrequisition" orno="{{ $list->or_no }}" status="paid">View <span class=" fa fa-eye"></span></button></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    

                        
                        
                      </div>
                      <div class="modal-footer">
                        
                         <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><span class="fa fa-remove"></span> Close</button>
                      </div>
                    </div>
              </div>
            </div>


            <div id="pendingusermedtransaction-modal" class="modal" role="dialog">
              <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">PATIENT PENDING TRANSACTION (<b class="status"></b>)</h4>
                      </div>
                      <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    
                                    <tr class="success">
                                        <th>BRAND</th>
                                        <th>GENERIC NAME</th>
                                        <th>PRICE</th>
                                        <th>QTY</th>
                                        
                                    </tr>
                                </thead>
                                <tbody class="tbodypendingmeds">
                                   
                                </tbody>
                            </table>
                        </div>
                      </div>
                      <div class="modal-footer">
                         <a href="" class="btn btn-default btn-sm" id="managerequistion"> Manage </a>
                          <a href="" class="btn btn-default btn-sm" id="editmanagerequistion"> Edit </a>   
                          <a href="#" class="btn btn-default btn-sm" id="removemanagerequistion" orno=""> Remove </a>   
                          <a href="#" class="btn btn-default btn-sm" id="editpaidrequistion" orno="" disabled data-toggle="" data-placement="" title=""> Edit </a>   
                          <a href="#" class="btn btn-default btn-sm" id="markasissuedrequistion" orno=""> Mark as Issued </a>   
                         <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><span class="fa fa-remove"></span> Close</button>
                      </div>
                    </div>
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
    <script src="{{ asset('public/js/pharmacy/manualinput.js') }}"></script> 
@stop


@endcomponent
