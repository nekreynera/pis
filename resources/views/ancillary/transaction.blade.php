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
     <link href="{{ asset('public/css/ancillary/transaction.css') }}" rel="stylesheet" />
     <link href="{{ asset('public/plugins/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />

@endsection



@section('header')
    @include('ancillary.navigation')
@stop



@section('content')
    @component('ancillary/dashboard')
        @section('main-content')


            <div class="content-wrapper">
                <br>
                <br>
                <div class="banner">
                    <h3>TRANSACTION LIST<i>(PAID)</i></h3>
                </div>
                <div class="col-md-12 sortingresult">
                    <form method="GET" >
                        <div class="col-md-3 col-md-offset-4">
                            FROM
                            <input type="date" name="from" class="form-control">
                        </div>
                        <div class="col-md-3">
                            TO
                            <input type="date" name="to" class="form-control">
                        </div>
                        <div class="col-md-2 text-center">
                            <br>
                            <button type="submit" class="btn btn-default" onclick="$(this).css('cursor', 'wait')"> Search <span class="fa fa-search"></span></button>
                        </div>
                    </form>
                    
                </div>
                <br>
                <br>
                <div class="table table-responsive">
                   <table class="table table-striped table-bordered" id="requestbygroup">
                    <thead>
                        <tr class="success">
                            <th hidden></th>
                           <th>CLASSIFICATION & OR</th>
                           <th>PATIENT</th>
                           <th>RENDERED BY</th>
                           <th>RENDERED DATE/TIME</th>
                           <th style="text-align: center;">EDIT</th>
                           <th style="text-align: center;">CANCEL</th>
                           <th style="text-align: center;">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $list)
                        <tr>
                            <td hidden></td>
                            @if($list->label)
                                @if(is_numeric($list->description) && $list->discount != '1')
                                <td align="center" class="success">{{ $list->label.' '.$list->description.'% - '.$list->or_no }}</td>
                                @else
                                <td align="center" class="info">{{ $list->label.'-'.$list->description }}</td>
                                @endif
                            @else
                                <td align="center" class="danger">NOT CLASSIFIED - {{ $list->or_no }}</td>
                            @endif
                            
                            
                            <td>{{ $list->last_name.', '.$list->first_name.' '.substr($list->middle_name,0,1) }}</td>
                            <td>{{ $list->users }}</td>
                            <td align="center">{{ Carbon::parse($list->created_at)->format('m/d/Y g:ia') }}</td>
                           

                            @if($list->id >=9 && $list->id <= 13)
                            
                            <td align="center">
                                <a href="{{ url('viewpaidrequisition/'.$list->or_no.'/'.$list->patient_id.'') }}" class="btn btn-default btn-sm" onclick="$(this).css('cursor', 'wait')"><span class="fa fa-eye"></span> EDIT </a>
                            </td>
                            @else
                            <td align="center">
                                <a href="#" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="PAID IN CASHIER, CANNOT BE EDIT" disabled><span class="fa fa-eye"></span> EDIT </a>
                            </td>
                            @endif

                            @if($list->id >=9 && $list->id <= 13)
                            <td align="center"><a href="{{ url('removepaidrequisition/'.$list->or_no.'') }}" class="btn btn-default btn-sm" onclick="$(this).css('cursor', 'wait')"><span class="fa fa-remove"></span> CANCEL </a></td>
                            @else
                            <td align="center"><a href="#" class="btn btn-default btn-sm" disabled data-toggle="tooltip" data-placement="top" title="PAID IN CASHIER, CANNOT BE CANCEL"> CANCEL <span class="fa fa-remove"></span></a></td>
                            @endif
                            <td align="center"><a href="{{ url('maskasdonerequistion/'.$list->or_no.'/'.$list->patient_id.'') }}" class="btn btn-default btn-sm" onclick="$(this).css('cursor', 'wait')"> <i class="fa fa-info"></i> VIEW </a></td>
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
    <script src="{{ asset('public/js/ancillary/transaction.js') }}"></script>
@stop


@endcomponent
