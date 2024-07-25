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
     <link href="{{ asset('public/css/pharmacy/managerequest.css') }}" rel="stylesheet" />

@endsection



@section('header')
    @include('pharmacy.navigation')
@stop



@section('content')
    @component('pharmacy/dashboard')
        @section('main-content')


            <div class="content-wrapper">
                <br>
                <div class="banner">
                    <h3 class="text-left"> <i class="fa fa-user-md"></i> SERVE REQUEST</h3>
                </div>
                <div class="">
                    <br>
                    <br>
                    <br>
                </div>
                <div class="col-md-6" style="padding: 0px;">
                    <table class="table table-condensed">
                        <tr>
                            <td><b>NAME: </b> {{ $patient->first_name.' '.$patient->middle_name.' '.$patient->last_name }}</td>

                        </tr>
                        <tr>
                            <td><b>AGE: </b> {{ $patient->age }}</td>
                            
                        </tr>
                        <tr>
                           @if(is_numeric($patient->description))
                           <td><b>CLASSIFICATION: </b> {{ $patient->label.'-'.$patient->description }}%</td>
                           @else
                           <td><b>CLASSIFICATION: </b> {{ $patient->label.'-'.$patient->description }}</td>
                           @endif
                            
                        </tr>
                    </table>
                </div>
                <div class="col-md-6" style="padding: 0px;">
                    <table class="table table-condensed">
                        <tr>
                            <td><b>GENDER: </b> {{ ($patient->sex=='M')? 'MALE':'FEMALE' }}</td>

                        </tr>
                        <tr>
                            <td><b>ADDRESS: </b> {{ $patient->address }}</td>
                            
                        </tr>
                        <tr>
                            <td><b>REQUEST BY: </b> </td>
                            
                        </tr>
                    </table>
                </div>
                <div class="col-md-12 tables">
                    <form method="post" action="{{ url('markasdone') }}">
                    {{ csrf_field() }}
                        @foreach($medicine as $id)
                        <input type="hidden" name="id[]" value="{{ $id->id }}">
                        @endforeach
                
                        <div class="table-banner text-right">
                           <h4 class="pull-left"><i class="fa fa-list"></i> List of Request</h4>
                           <a href="{{ url('patientrequest') }}" class="btn btn-default btn-sm">Cancel <i class="fa fa-backward"></i></a>
                           @if(count($medicine) > 0) 
                           <button type="submit" class="btn btn-success">Mark as Done <span class="fa fa-tag"></span></button>
                           @else
                           <button type="submit" class="btn btn-success" disabled>Mark as Done <span class="fa fa-tag"></span></button>
                           @endif
                        </div>
                    </form>
                    <div class="table-responsive">
                       <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ITEM BRAND</th>
                                <th>ITEM NAME</th>
                                <th style="text-align: center;">UNIT OF MEASURE</th>
                                <th>PRICING(php)</th>
                                <th width="120px" style="text-align: center;">QTY</th>
                                <th>AMOUNT</th>
                                <th>DISCOUNT(php)</th>
                                 <th>NET AMOUNT</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($medicine) > 0)
                            @foreach($medicine as $list)
                            <tr>
                                <td>{{ $list->brand }}</td>
                                <td>{{ $list->item_description }}</td>
                                <td align="center">{{ $list->unitofmeasure }}</td>
                                <td align="right">{{ number_format($list->price, 2, '.', ',') }}</td>
                                <td align="center">{{ $list->qty }}</td>
                                <td align="right" style="text-align: right;" class="amountc">{{ number_format($list->amount, 2, '.', '') }}</td>
                          
                                <td align="right" class="discountc">{{ number_format($list->discount, 2, '.', '') }}</td>
                                <td align="right" class="netamountc">{{ number_format($list->netamount, 2, '.', '') }}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <th colspan="5">TOTAL</th>
                                <th class="total_amount"></th>
                                <th class="total_discount"></th>
                                <th class="total_netamount"></th>

                            </tr>
                            @else
                            <tr>
                                <td colspan="8" class="danger" align="center" height="100px">NO PAID REQUISITION FOUND</td>
                            </tr>
                            @endif
                            
                        </tbody>
                           
                            
                           
                       </table> 
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
    <script src="{{ asset('public/js/pharmacy/request.js') }}"></script>  
@stop


@endcomponent
