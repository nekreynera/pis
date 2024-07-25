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
    <!-- <link href="{{ asset('public/css/doctors/patientlist.css') }}" rel="stylesheet" /> -->
    <!-- <link href="{{ asset('public/css/receptions/designation.css') }}" rel="stylesheet" /> -->
    <!-- <link href="{{ asset('public/plugins/css/jquery-ui.css') }}" rel="stylesheet" /> -->
    <link href="{{ asset('public/css/pharmacy/logs.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/pharmacy/report.css') }}" rel="stylesheet" />

    
@endsection




@section('content')
 

            <div class="container-fluid logs">
                <br>
                <div class="container">
                  <div class="banner">
                      <h3 class="text-left"> <i class="fa fa-bar-chart-o" style="color: #2db22d;"></i> CENSUS</h3>
                  </div>
                  <div class="col-md-12" style="padding-top: 10px;">
                    @include('message.loader')
                      <form class="form census-form" method="GET">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>TYPE</label>
                                <select class="form-control type" name="type" required>
                                  <option value="1000" hidden>--TYPE--</option>
                                 
                                  <option value="CHARGE" @if($request->type == "CHARGE") selected @endif>CHARGE TO FUND</option>
                                  <option value="DISPENSED" @if($request->type == "DISPENSED") selected @endif>10 DISPENSED MEDICINES</option>
                                  <option value="DEMOGRAPHIC" @if($request->type == "DEMOGRAPHIC") selected @endif>DEMOGRAPHIC REPORT</option>
                                
                                </select>
                            </div>
                        </div>
                        <div class="dual_month" @if($request->month != "")) hidden @endif>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="">FROM(MONTH)</label>
                                    <select class="form-control start_month" name="start_month">
                                        @foreach($month as $list)
                                         <option value="{{$list->months}}" @if($request->start_month == $list->months) selected @endif>{{ Carbon::parse($list->dates)->format('F') }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>TO(MONTH)</label>
                                    <select class="form-control end_month" name="end_month">
                                        @foreach($month as $list)
                                         <option value="{{$list->months}}" @if($request->end_month == $list->months) selected @endif>{{ Carbon::parse($list->dates)->format('F') }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                        </div>
                        <div class="single_month" @if($request->month == "")) hidden @endif>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="">CHOOSED MONTH</label>
                                    <select class="form-control month" name="month">
                                        <option value="" hidden>SELECT</option>
                                        @foreach($month as $list)
                                         <option value="{{$list->months}}" @if($request->month == $list->months) selected @endif>{{ Carbon::parse($list->dates)->format('F') }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>YEAR</label>
                                <!-- <input type="text" name="to" class="form-control datepicker" placeholder="Ending Date" aria-describedby="endingDate" id="to" required> -->
                                <select class="form-control" name="year">
                                    @foreach($year as $list)
                                        <option value="{{$list->years}}">{{$list->years}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1 text-center">
                            <br>
                            <button type="submit" class="btn btn-success btn-sm"><span class="fa fa-cogs"></span> GENERATE</button>
                        </div>
                      </form>
                  </div> 
                </div> 
                @if($request->type == "CHARGE")
                  @include('pharmacy.census.chargetofund')
                @elseif($request->type == "DISPENSED")
                  @include('pharmacy.census.dispensedmeds')
                @elseif($request->type == "DEMOGRAPHIC")
                  @include('pharmacy.census.demographic')
                @endif
               
            </div> 

@endsection

@section('footer')
@stop

@section('pagescript')
    @include('message.toaster')
   <!--  <script src="{{ asset('public/plugins/js/form.js') }}"></script>
    <script src="{{ asset('public/plugins/js/modernizr.js') }}"></script>
    <script src="{{ asset('public/plugins/js/jquery.menu-aim.js') }}"></script>
    <script src="{{ asset('public/js/pharmacy/main.js') }}"></script> -->
    <!-- <script src="{{ asset('public/plugins/js/jquery-ui.min.js') }}"></script> -->
    <script src="{{ asset('public/js/pharmacy/report.js') }}"></script>
@stop


@endcomponent
