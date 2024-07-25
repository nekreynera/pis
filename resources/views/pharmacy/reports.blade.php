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
     <link href="{{ asset('public/css/pharmacy/logs.css') }}" rel="stylesheet" />
@endsection



@section('header')
    @include('pharmacy.navigation')
@stop



@section('content')
    @component('pharmacy/dashboard')
        @section('main-content')


            <div class="content-wrapper logs">
                <br>
                <br>
                <div class="banner">
                    <h3 class="text-left"> <i class="fa fa-book"></i> REPORTS</h3>
                </div>
                
                <div class="col-md-12" style="padding-top: 10px;">
                    <form class="form" method="GET" target="_blank">
                      <div class="col-md-3">
                          <div class="form-group">
                              <label>TYPE</label>
                              <select class="form-control" name="filter" required>
                                <option value="" hidden>--FILTER BY--</option>
                                <option value="class-c">MSS CLASS-C</option>
                                <option value="class-d">MSS CLASS-D</option>
                                <option value="full-pay">FULL PAY</option>
                                <option value="free-meds">FREE MEDS</option>
                                <option value="all">ALL</option>
                                <!-- <option>INVENTORY</option> -->
                              </select>
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="form-group">
                              <label>FROM</label>
                              <input type="date" name="from" class="form-control" value="@if(isset($_GET['from'])){{$_GET['from']}}@endif" required>
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="form-group">
                              <label>TO</label>
                              <input type="date" name="to" class="form-control" value="@if(isset($_GET['to'])){{$_GET['to']}}@endif" required>
                          </div>
                      </div>
                      <div class="col-md-3 text-center">
                          <br>
                          <button type="submit" class="btn btn-success btn-sm"><span class="fa fa-cogs"></span> GENERATE</button>
                      </div>
                    </form>
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
@stop


@endcomponent
