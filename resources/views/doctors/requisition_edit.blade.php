@component('partials/header')

    @slot('title')
        PIS | Requisition Edit
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/css/doctors/reset.css') }}" rel="stylesheet" />
    @if(Auth::user()->theme == 2)
        <link href="{{ asset('public/css/doctors/darkstyle.css') }}" rel="stylesheet" />
    @else
        <link href="{{ asset('public/css/doctors/greenstyle.css') }}" rel="stylesheet" />
    @endif
    <link href="{{ asset('public/css/doctors/requisition.css') }}" rel="stylesheet" />
@endsection



@section('header')
    @include('doctors.navigation')
@stop



@section('content')
    @component('doctors/dashboard')
@section('main-content')






    <div class="content-wrapper">
        <div class="container-fluid">
            <h2 class="text-center" style="display: inline">
                <small>Patient Name: {{ $patient->last_name.', '.$patient->first_name.' '.$middlename=($patient->middle_name)? $patient->middle_name[0].'.' : '' }}</small>
            </h2>
            <br/>
            <div class="col-md-12 requsitionWrapper">
                <div class="row">
                    <h5 class="text-center"><strong class="text-default">REQUISITION</strong></h5>
                    <div class="col-md-3 departmentWrapper">
                        <form onsubmit="return false">
                            <div class="form-group">
                                <input type="text" name="" class="form-control" placeholder="Search Department..." />
                            </div>
                        </form>
                        <div class="list-group">
                            <h6 class="text-center">DEPARTMENTS</h6>
                            <a href="" clinic-code="103299" class="list-group-item">OPD LABORATORY</a>
                            <a href="" clinic-code="1031" class="list-group-item" style="background-color: #ccc">OPD PHARMACY</a>
                            <a href="" clinic-code="103399" class="list-group-item">OPD ULTRASOUND</a>
                            <a href="" clinic-code="103499" class="list-group-item">OPD XRAY</a>
                            <a href="" clinic-code="102699" class="list-group-item">RADIOLOGY</a>
                            <a href="" clinic-code="103699" class="list-group-item">BLOOD BANK</a>
                            <a href="" clinic-code="103799" class="list-group-item">CTSCAN</a>
                        </div>
                    </div>
                    <div class="col-md-9 requsitionSelection">
                        <div>
                            <form class="form-inline" onsubmit="return false">
                                <input type="text" name="" class="form-control" data-search="description" onkeyup="search($(this))" placeholder="Search By Description..." />
                                <input type="text" name="" class="form-control" data-search="item" onkeyup="search($(this))" placeholder="Search By Item Id..." />
                                <input type="text" name="" class="form-control" data-search="price" onkeyup="search($(this))" placeholder="Search By Price..." />
                                <small class="text-right"> &nbsp; Showing <strong id="countResults">{{ count($medicines) }}</strong> Results</small>
                            </form>
                        </div>
                        <br/>
                        <div class="table-responsive tableWrapper">
                            <div class="loaderWrapper">
                                <img src="{{ asset('public/images/loader.svg') }}" alt="loader" class="img-responsive" />
                                <p>Loading...</p>
                            </div>
                            <table class="table" id="itemsDeptTable">
                                <thead>
                                <tr>
                                    <th><i class="fa fa-question"></i></th>
                                    <th>ITEM ID</th>
                                    <th>ITEM DESCRIPTION</th>
                                    <th>BRAND</th>
                                    <th>UNIT</th>
                                    <th>PRICE</th>
                                    <th>STOCKS</th>
                                    <th>STATUS</th>
                                </tr>
                                </thead>
                                <tbody class="selectitemsTbody">
                                @if(count($medicines))
                                    @foreach($medicines as $medicine)
                                        @php
                                            $checkifinArray = (in_array($medicine->id, $checkIfInArray))? 'checked status="on"' : 'status="off"';
                                            $checkQuantityifinArray = (in_array($medicine->id, $requisitionQty))? 'disabled' : '';
                                        @endphp
                                        <tr class="{{ ($medicine->status == 'Y' && $medicine->stock)? 'bg-success' : 'bg-danger' }}">
                                            <td>
                                                <input {!! $checkQuantityifinArray !!} {!! $checkifinArray !!} type="checkbox" data-id="{{ $medicine->id }}" name="" onclick="chooseItem($(this))" />
                                            </td>
                                            <td class="item_id">
                                                {{ $medicine->item_id }}
                                            </td>
                                            <td class="item_description">
                                                {{ $medicine->item_description }}
                                            </td>
                                            <td class="item_brand">
                                                {!! ($medicine->brand)? $medicine->brand : '<span class="text-danger">N/A</span>' !!}
                                            </td>
                                            <td class="unitofmeasure">
                                                {!! ($medicine->unitofmeasure)? $medicine->unitofmeasure : '<span class="text-danger">N/A</span>' !!}
                                            </td>
                                            <td class="price">
                                                {{ $medicine->price }}
                                            </td>
                                            <td class="stocks">
                                                {!! ($medicine->stock)? $medicine->stock : '<span class="text-danger">Out</span>' !!}
                                            </td>
                                            <td>
                                                {!! ($medicine->status == 'Y' && $medicine->stock)? '<span class="text-success">Available</span>' : '<span class="text-danger">Unavailable</span>' !!}
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
                        <strong class="text-default">SELECTED ITEMS</strong>
                        <span class="pull-right">MSS Classification <b class="classificationLabel"></b> (<b class="classificationDisc"></b>)</span>
                    </h5>
                    <div class="table-responsive tableSelectedItems">
                        <form action="{{ url('requisitionUpdate') }}" method="post" id="requisitionform">
                            {{ csrf_field() }}
                            @if(count($requisitions) > 0)
                                <input type="hidden" name="modifier" value="{{ $requisitions[0]->modifier }}" />
                                <input type="hidden" name="patientID" value="{{ $forApproval->patients_id }}" />
                                <input type="hidden" name="doctors_id" value="{{ $forApproval->users_id }}" />
                            @endif
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th><i class="fa fa-question"></i></th>
                                    <th>ITEM ID</th>
                                    <th>ITEM DESCRIPTION</th>
                                    <th>PRICE</th>
                                    <th>QTY</th>
                                    <th>AMOUNT</th>
                                    <th>DISCOUNT</th>
                                    <th>TOTAL</th>
                                    <th>UNIT</th>
                                </tr>
                                </thead>

                                <tbody class="selectedItemsTbody">

                                @if(count($requisitions) > 0)
                                    @php $grandtotal = 0; @endphp
                                    @foreach($requisitions as $requisition)
                                        @php
                                            $amount = $requisition->price * $requisition->qty;
                                            $discount = ($patientClassification)? $patientClassification->discount * $amount : '0';
                                            $total = $discount - $amount;
                                            //$minQty = (abs($requisition->quantity - $requisition->qty) <= 0)? $requisition->qty : abs($requisition->quantity - $requisition->qty);
                                            $disbleCheckbox = ($requisition->quantity != null)? 'onclick="$(this).click()"' : 'onclick="removeItem($(this))"';
                                            $minQty = ($requisition->quantity != null)? $requisition->quantity : 1;
                                            $disableQty = ($requisition->quantity == $requisition->qty)? 'readonly style="background-color:#ccc"' : '';
                                            $unableCheckbox = ($requisition->quantity != null)? 'data_disabled' : '' ;
                                        @endphp
                                        <tr style="{{ ($requisition->quantity != null)? 'background-color:#f2dede' : '' }}">
                                            <td>
                                                <input class="{!! $unableCheckbox !!}" {!! $disbleCheckbox !!} type="checkbox" name="item[]" value="{{ $requisition->rid.'_item' }}" data-id="{{ $requisition->id }}"  checked />
                                            </td>
                                            <td>{{ $requisition->item_id }}</td>
                                            <td>{{ $requisition->item_description }}</td>
                                            <td class="tdprice">{{ $requisition->price }}</td>
                                            <td>
                                                <input type="number" {!! $disableQty !!} value="{{ $requisition->qty }}" min="{{ $minQty }}" name="qty[]" class="qty" onchange="changeqty($(this))">
                                            </td>
                                            <td class="tdamount">{{ $amount }}</td>
                                            <td class="tddiscount">
                                                -{{ $discount }}
                                            </td>
                                            <td class="tdtotal">{{ abs($total) }}</td>
                                            <td>{!! ($requisition->unitofmeasure)? $requisition->unitofmeasure : '<span class="text-danger">N/A</span>' !!}</td>
                                        </tr>
                                        @php
                                            $grandtotal += $total;
                                        @endphp
                                    @endforeach
                                @else
                                    <tr class="noSelectedTRwrapper">
                                        <td colspan="9" class="text-center">
                                            <strong class="text-danger">NO SELETECD ITEMS.</strong>
                                        </td>
                                    </tr>
                                @endif
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <td colspan="9" align="right">
                                            <h4>&#8369; <strong id="grndTotal">{{ number_format(abs($grandtotal), 2) }}</strong> Grand Total</h4>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </form>
                    </div>
                </div>
            </div>


            <div class="col-md-12" align="right">
                <br>
                <button type="button" name="button" class="btn btn-default cancel">CANCEL</button>
                <button type="submit" name="button" form="requisitionform" class="btn btn-success">UPDATE REQUISITION</button>
            </div>

        </div>
    </div> <!-- .content-wrapper -->







@endsection
@endcomponent
@endsection





@section('footer')
@stop



@section('pagescript')
    @include('message.toaster')
    <script src="{{ asset('public/plugins/js/modernizr.js') }}"></script>
    <script src="{{ asset('public/plugins/js/jquery.menu-aim.js') }}"></script>
    <script src="{{ asset('public/js/doctors/main.js') }}"></script>
    <script src="{{ asset('public/js/doctors/requisition.js') }}"></script>
    <script>
        $('.submitRequisition').fadeIn(0);
    </script>
    <script>
        $('tfoot').fadeIn('fast');
    </script>
@stop


@endcomponent
