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
                    <h3 class="text-left"> <i class="fa fa-user-md"></i> EDIT PAID REQUISITION</h3>
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
                                                        @if($list->req_id)
                                                        <input type="checkbox" data-id="{{ $list->id }}" class="check-item" checked />
                                                        @else
                                                        <input type="checkbox" data-id="{{ $list->id }}" class="check-item" />
                                                        @endif
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
                                                        {{ number_format($list->price, 2, '.', ',') }}
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
                                <form action="{{ url('updatepaidrequisition') }}" method="post" id="requisitionpharform">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="patient_id" class="patient_id" value="{{ $patient->patient_id }}">
                                    <input type="hidden" name="mss_id" class="mss_id" value="{{ $patient->mss_id }}">
                                    <input type="hidden" name="modifier" class="modifier" value="{{ $modifier }}">
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
                                            @foreach($requisition as $list)
                                                <tr>
                                                    <td><input type="checkbox" name="item_id[]" value="{{ $list->id }}" data-id="{{ $list->id }}" class="uncheck-item" style="margin-top: 0px;" checked/></td>
                                                    <td>{{ $list->brand }}</td>
                                                    <td>{{ $list->item_description }}</td>
                                                    <td align="center">{{ $list->unitofmeasure }}</td>
                                                    <td class="selprice">{{ number_format($list->price, 2, '.', '') }}</td>
                                                    <td>
                                                        <input type="number" class="form-control qtyreq" name="qtyreq[]" value="{{ $list->qty }}"/>
                                                        <input type="hidden" class="form-control pricereq" name="pricereq[]" value="{{ $list->price }}"/>
                                                    </td>
                                                    <td><input type="number" class="form-control qtyman" name="qtyman[]" value="{{ $list->qty }}"/></td>
                                                    @php
                                                        $amount = $list->price * $list->qty;
                                                    @endphp
                                                    <td align="right" class="selamount">{{ number_format($amount, 2, '.', '') }}</td>
                                                    @php
                                                        $discount = $amount * $patient->discount ;
                                                    @endphp
                                                    <td align="right" class="seldiscount">{{ number_format($discount, 2, '.', '') }}</td>
                                                    @php
                                                        $netamount = $amount - $discount ;
                                                    @endphp
                                                    <td align="right" class="selnetamount">{{ number_format($netamount, 2, '.', '') }}</td>
                                                </tr>
                                            @endforeach
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
