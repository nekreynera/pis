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
     <link href="{{ asset('public/plugins/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />

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
                    <h3 class="text-left"> <i class="fa fa-user-md"></i> MANAGED REQUEST</h3>
                </div>
                <div class="">
                    <br>
                    <br>
                    <br>
                </div>
                <div class="col-md-12 tables">
                   <!--  <div class="table-banner">
                        <h4> <i class="fa fa-list"> List of Managed Request</i> </h4>
                    </div> -->
                    <div class="table table-responsive">
                       <table class="table table-striped table-bordered" id="tablemanagebygroup">
                        <thead>
                            <tr>
                               <th>PATIENT</th>
                               <th>PHARMACIST</th>
                               <th>NET AMOUNT(php)</th>
                               <th>CREATED</th>
                               <th>UPDATED</th>
                               <th style="text-align: center;">EDIT</th>
                               <th style="text-align: center;">CANCEL</th>
                            </tr>
                        </thead>
                        <tbody>

                            <!-- @if(count($transaction)  > 0) -->
                            @foreach($transaction as $list)
                            <tr>

                                <td>{{ $list->patient_name }}</td>
                                <td>{{ $list->users_name }}</td>
                                <td align="right">{{ number_format($list->netamount, 2, '.', ',') }}</td>
                                <td align="center">{{ Carbon::parse($list->created_at)->format('m/d/Y g:ia') }}</td>
                                <td align="center">{{ Carbon::parse($list->updated_at)->format('m/d/Y g:ia') }}</td>
                                <td align="center"><a href="{{ url('editmanagereqeust/'.$list->modifier.'') }}" class="btn btn-success btn-xs"> Edit <span class="fa fa-pencil"></span></a></td>
                                <td align="center"><a href="{{ url('cancelmanagerequest/'.$list->modifier.'') }}" class="btn btn-danger btn-xs"> Cancel <span class="fa fa-backward"></span></a></td>
                            </tr>
                            @endforeach
                           <!--  @else
                            <tr>
                                <td colspan="6" class="danger" align="center">no managed request found</td>
                            </tr>
                            @endif -->
                            
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
    <script src="{{ asset('public/plugins/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/plugins/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/js/pharmacy/managerequestbygroup.js') }}"></script>
@stop
@endcomponent