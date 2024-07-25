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
    <link href="{{ asset('public/css/pharmacy/transaction.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/plugins/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />

@endsection



@section('header')
    @include('pharmacy.navigation')
@stop



@section('content')
    @component('pharmacy/dashboard')
        @section('main-content')


            <div class="content-wrapper transaction">
              <div id="mySidenav" class="sidenav">
                <a href="javascript:void(0)" class="closebtn" >&times;</a>
                <div class="row" style="margin: 10px;">
                  <table class="table table-bordered">
                    <tr>
                      <th>NAME</th>
                      <th>AGE</th>
                    </tr>
                    <tr>
                      <td class="names"></td>
                      <td class="ages"></td>
                    </tr>
                    <tr>
                      <th colspan="2">CLASSIFICATION & OR:</th>
                    </tr>
                    <tr>
                      <td colspan="2" class="classifications"></td>
                    </tr>
                    <tr>
                      <th colspan="2">ADDRESS</th>
                    </tr>
                    <tr>
                      <td colspan="2" class="addresss"></td>
                    </tr>
                  </table>
                </div>
                <div class="bg-success bannersidenav">
                  <p><i class="fa fa-exchange"></i> Patient Transaction</p>
                </div>
                <div class="table-responsive tablesidenav">
                  <table class="table table-bordered">
                    <thead>
                        <tr>
                          <th>BRAND</th>
                          <th>GENIRIC NAME</th>
                          <th>UNIT</th>
                          <th>PRICE</th>
                          <th>QTY</th>
                          <th>DISCOUNT</th>
                          <th>NET AMOUNT</th>
                        </tr>
                    </thead>
                    <tbody class="tbodysidenav">
                        
                    </tbody>
                  </table>
                </div>
              </div>
                <br>
                <div class="banner">
                    <h3 class="text-left"> <i class="fa fa-exchange"></i> ISSUED TRANSACTIONS</h3>
                </div>
                <div class="">
                    <br>
                </div>
                <div class="col-md-12 select-date">
                    <form class="form" method="GET">
                      <div class="col-md-3 col-md-offset-2">
                          <div class="form-group">
                              <label>FROM</label>
                              <input type="date" name="from" class="form-control frominput" value="@if(isset($_GET['from'])){{$_GET['from']}}@endif" required>
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="form-group">
                              <label>TO</label>
                              <input type="date" name="to" class="form-control toinput" value="@if(isset($_GET['to'])){{$_GET['to']}}@endif" required>
                          </div>
                      </div>
                      <div class="col-md-3">
                          <br>
                          <button type="submit" class="btn btn-success btn-sm"><span class="fa fa-cogs"></span> PROCEED</button>
                      </div>
                    </form>
                </div>

                <div class="table table-responsive content-medicine">
                    <table class="table table-hover table-bordered" id="transaction">
                        <thead>
                            <tr>
                                <th hidden></th>
                                <th id="infos"><i class="fa fa-info-circle" data-toggle="tooltip" data-placement="right" title="CLICK BY ROW TO VIEW FULL DETAILS"></i></th>
                                <th>CLASSIFICATION & OR#</th>
                                <th>NAME OF PATIENT</th>
                                <th>ADDRESS</th>
                                <th>AMOUNT</th>
                                <th>DISCOUNT(PHP)</th>
                                <th>NET AMOUNT</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaction as $list)
                            <tr class="logs-info">
                              <td hidden></td>
                              <td><i class="fa fa-info-circle info-icon" id="{{ $list->or_no }}" modifier="{{ $list->modifier }}" data-toggle="tooltip" data-placement="right" title="CLICK BY ROW TO VIEW FULL DETAILS"></i></td>
                              <td align="center">{{ $list->label.'-'.$list->description}}@if(is_numeric($list->description)){{'%'}}@endif<br>{{ $list->or_no }}</td>
                              <td>{{ $list->patient_name }}</td>
                              <td>{{ $list->address }}</td>
                              <td class="text-right">{{ number_format($list->total_amount, 2, '.', ',') }}</td>
                              <td class="text-right">{{ number_format($list->discount_price, 2, '.', ',') }}</td>
                              <td class="text-right">{{ number_format($list->paid, 2, '.', ',') }}</td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
            </div> 

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
    <script src="{{ asset('public/plugins/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/plugins/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/js/pharmacy/transaction.js') }}"></script>
@stop


@endcomponent
