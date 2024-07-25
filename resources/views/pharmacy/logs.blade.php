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
    <link href="{{ asset('public/plugins/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />
@endsection



@section('header')
    @include('pharmacy.navigation')
@stop



@section('content')
    @component('pharmacy/dashboard')
        @section('main-content')


            <div class="content-wrapper logs">
              <div id="mySidenav" class="sidenav">
                <a href="javascript:void(0)" class="closebtn" >&times;</a>
                <div>
                  <br>
                  <br>
                  <br>
                </div>
                <div class="table-responsive" style="margin: 10px;">
                  <table class="table table-bordered">
                    <tr>
                      <th>EMPLOTYEE NAME:</th>
                    </tr>
                    <tr>
                      <td class="names"></td>
                    </tr>
                  </table>
                </div>
                <div class="bg-success bannersidenav">
                  <p class="actions"></p>
                </div>
                <div class="table-responsive" style="margin: 10px;">
                    <table class="table table-bordered">
                      <tr>
                        <th colspan="2" style="text-align: center;"><span class="fa fa-info"></span> ITEM INFORMATIONS</th>
                      </tr>
                      <tr>
                        <th>ITEM CODE</th>
                        <td class="itemcodes"></td>
                      </tr>
                      <tr>
                        <th>BRAND</th>
                        <td class="brands"></td>
                      </tr>
                      <tr>
                        <th>GENERIC NAME</th>
                        <td class="genericnames"></td>
                      </tr>
                       <tr>
                        <th>EXPIRE DATE</th>
                        <td class="expires"></td>
                      </tr>
                      <tr>
                        <th>STOCK</th>
                        <td class="stocks"></td>
                      </tr>
                      <tr>
                        <th>STATUS</th>
                        <td class="statuss"></td>
                      </tr>
                      
                    </table>
                </div>
              </div>
                <br>
                <br>
                <div class="banner">
                    <h3 class="text-left"> <i class="fa fa-book"></i> LOGS</h3>

                </div>
                <div>
                  <br>
                </div>

                <div class="col-md-12 select-date">
                    <form class="form" method="GET">
                      <div class="col-md-3 col-md-offset-2">
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
                      <div class="col-md-3">
                          <br>
                          <button type="submit" class="btn btn-default btn-sm"><span class="fa fa-cogs"></span> PROCEED</button>
                      </div>
                    </form>
                   
                </div>  

                <div class="table table-responsive content-logs">
                    <table class="table table-striped table-bordered" id="logs">
                        <thead>
                            <tr>
                                <th hidden></th>
                                <th id="infos"><i class="fa fa-info-circle" data-toggle="tooltip" data-placement="right" title="CLICK BY ROW TO VIEW FULL DETAILS"></i> </th>
                                <th class="info">LOG</th>
                                <th class="danger">REMARKS</th>
                                <th>BRAND</th>
                                <th>NAME/DESCRIPTION</th>
                               
                                <th>USER</th>
                                <th>DATETIME</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logs as $list)
                            <tr class="logs-info">
                              <td hidden></td>
                              <td><i class="fa fa-info-circle info-icon" id="{{ $list->id }}" data-toggle="tooltip" data-placement="right" title="CLICK BY ROW TO VIEW FULL DETAILS"></i></td>
                              <td class="info">{{ $list->action }}</td>
                              <td class="danger">{{ $list->remarks }}</td>
                              <td>{{ $list->brand }}</td>
                              <td>{{ $list->item_description }}</td>
                             
                              <td>{{ $list->user_name }}</td>
                              <td>{{ Carbon::parse($list->created_at)->toDayDateTimeString() }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
    <script src="{{ asset('public/plugins/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/plugins/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/js/pharmacy/logs.js') }}"></script>
@stop


@endcomponent
