@component('partials/header')

    @slot('title')
        PIS | ANCILLARY
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/css/doctors/reset.css') }}" rel="stylesheet" />
    @if(Auth::user()->theme == 2)
        <link href="{{ asset('public/css/doctors/darkstyle.css') }}" rel="stylesheet" />
    @else
        <link href="{{ asset('public/css/doctors/greenstyle.css') }}" rel="stylesheet" />
    @endif
    <link href="{{ asset('public/css/ancillary/manualrequest.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/doctors/requisition.css') }}" rel="stylesheet" />


@endsection



@section('header')
    @include('ancillary.navigation')
@stop



@section('content')
    @component('ancillary/dashboard')
@section('main-content')


    <div class="content-wrapper" style="margin-left: 150px;padding-right: 20px;">
        <br>
        <div class="banner">
            <h3 class="text-left"> <i class="fa fa-user-md"></i> PAID REQUISITION</h3>

        </div>
        <div class="">
            <br>
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
                                    <td><b>CLASSIFICATION: </b> {{ $patient->label.'-'.$patient->description }}% </td>
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
                                <input type="text" name="" class="form-control" data-search="description" id="description" placeholder="Search By Description..." />
                                <small class="text-right"> &nbsp; Showing <strong id="countResults">{{ count($services) }}</strong> Results</small>
                            </form>
                        </div>
                        <br/>
                        <div class="table-responsive tableWrapper">
                            <div class="loaderWrapper">
                                <img src="{{ asset('public/images/loader.svg') }}" alt="loader" class="img-responsive" />
                                <p>Loading...</p>
                            </div>

                            <table class="table table-hover" id="itemsDeptTable">
                                <thead>
                                <tr>
                                    <th><i class="fa fa-info-circle"></i></th>
                                    <th>PARTICULAR</th>
                                    <th>PRICE</th>
                                </tr>
                                </thead>
                                <tbody class="selectitemsTbody">
                                @if(count($services))
                                        @foreach($services as $list)
                                                <tr style="cursor: pointer;">
                                                    <td>
                                                        <input type="checkbox" data-id="{{ $list->id }}" class="check-item" @if($list->category_id) {{ 'checked' }} @endif/>
                                                    </td>
                                                    <td class="item_description">
                                                        {{ $list->sub_category }}
                                                    </td>
                                                    <td class="price" align="center">
                                                        {{ number_format($list->price, 2, '.', '') }}

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
                        SELECTED ITEMS <b class="pull-right">CLASSIFICATION: {{ $patient->label.'-'.$patient->description }} </b> 
                    </h5>
                    <div class="table-responsive tableSelectedItems">
                        <form action="{{ url('updateancillaryrequisition') }}" method="post" id="requisitionformlab">
                            {{ csrf_field() }}
                            <input type="hidden" name="patient_id" class="patient_id" value="{{ $patient->id }}">
                            <input type="hidden" name="mss_id" class="mss_id" value="{{ $patient->mss_id }}">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th><i class="fa fa-info-circle"></i></th>
                                    <th>PARTICULAR</th>
                                    <th>PRICE</th>
                                    <th>QTY</th>
                                    <th>AMOUNT</th>
                                    <th>DISCOUNT</th>
                                    <th>NET AMOUNT</th>
                                </tr>
                                </thead>
                                <tbody class="selectedItemsTbody" id="{{ $patient->discount }}" >
                                    @php
                                        $total = 0;
                                    @endphp
                                    @foreach ($data as $orl)
                                    <input type="hidden" name="income_or_no" value="{{ $orl->or_no }}">
                                        <tr>
                                            <td>
                                                
                                                <input type="checkbox" name="particular_id[]" value="{{ $orl->sub_id }}" status="off" data-id="{{ $orl->sub_id }}" class="check-item2" style="margin-top: 0px;" checked="">
                                               
                                            </td>
                                            <td>
                                                {{ $orl->sub_category }}
                                            </td>
                                            <td class="selprice">
                                                {{ number_format($orl->price, 2, '.', ',') }}
                                            </td>
                                            <td>
                                                <input type="number" class="form-control qtypart" name="qty[]" value="{{ $orl->qty }}"><input type="hidden" class="form-control pricepart" name="price[]" value="{{ $orl->price }}">
                                            </td>
                                            <td class="selamount">
                                                {{ number_format($orl->amount, 2, '.', ',') }}
                                            </td>
                                            <td class="seldiscount">
                                                {{ number_format($orl->discount, 2, '.', ',') }}
                                            </td>
                                            <td class="selnetamount">
                                                @php
                                                $total += $orl->netamount;
                                                @endphp
                                                {{ number_format($orl->netamount, 2, '.', ',') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                 <tr>
                                    <td colspan="7" class="text-right">
                                          <h4>&#8369; <strong id="grndTotal"> {{ number_format($total, 2, '.', ',') }} </strong> Total(php) &nbsp;</h4>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                    <div class="col-md-12 grandtotalinfo">
                       
                        <div class="col-md-4 col-md-offset-8 text-right">
                            @if ($patient->mss_id >= 9 && $patient->mss_id <= 13)
                             <button type="button" class="btn btn-default btn-sm" id="saverequisition" onclick="$(this).css('cursor', 'wait')">UPDATE</button>
                             <a href="{{ url('paidtransaction') }}" class="btn btn-default btn-sm" onclick="$(this).css('cursor', 'wait')">CANCEL UPDATE</a>
                            @else
                            <p>Transaction is paid in Cashier, Cannot Edit</p>   
                            @endif
                           
                        </div>



                    </div>
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
    <script src="{{ asset('public/js/ancillary/updatemanualinput.js') }}"></script>
@stop


@endcomponent
