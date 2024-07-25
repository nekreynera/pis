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
     <link href="{{ asset('public/css/ancillary/scan.css') }}" rel="stylesheet" />

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
                <div class="table-responsive">
                   <table class="table table-bordered">
                       <tr class="success">
                           <th colspan="3">PATIENT INFORMATION</th>
                       </tr>
                       <tr>
                           <td><b>NAME:</b> {{ $patient->last_name.', '.$patient->first_name.' '.$patient->middle_name }}</td>
                           <td><b>HOSPITAL NO:</b> {{ $patient->hospital_no }}</td>
                           <td><b>CLASSIFICATION: </b> {{ $patient->label.' - '.$patient->description }}</td>
                       </tr>
                        <tr>
                           <td colspan="3">TRANSACTION STATUS: PAID</td>
                       </tr>
                   </table>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-stripped" id="particularstable">
                        <thead>
                            <tr class="success">
                                <th colspan="6">PATIENT PAID TRANSACTION</th>
                            </tr>
                            <tr id="particulars">
                               <th>PATICULAR</th> 
                               <th>PRICE</th> 
                               <th>QTY</th> 
                               <th>STATUS</th> 
                               <th>ACTION</th> 
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $list)
                            <tr>
                                <td>{{ $list->sub_category }}</td>
                                <td align="right">{{ $list->price }}</td>
                                <td align="center">{{ $list->qty }}</td>
                                @if($list->get == 'N')
                                 <td class="bg-warning" align="center">{{ "PENDING" }}</td>
                                @else
                                 <td class="bg-success" align="center">{{ "DONE" }}</td>
                                @endif
                                @if($list->get == 'N')
                                    <td align="center"><a href="{{ url('markparticularasdone/'.$list->id.'') }}" class="btn btn-default btn-sm" onclick="$(this).css('cursor', 'wait')">DONE</a></td>
                                @else
                                    <td align="center"><a href="{{ url('markparticularaspending/'.$list->id.'') }}" class="btn btn-default btn-sm" onclick="$(this).css('cursor', 'wait')">REVERT</a></td>
                                @endif
                                
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
               
                    
                
                
            </div> 
            <!-- .content-wrapper -->
            <style>
                #particulars th{
                    text-align: center;
                }
                #particularstable td:nth-child(4),
                #particularstable td:nth-child(3){
                    width: 90px;
                }
                #particularstable td:nth-child(5),
                #particularstable td:nth-child(6){
                    width: 100px;
                }
                #particularstable td a{
                    font-size: 12px;

                    height: 30px;
                    margin-left: 10px;
                    background: linear-gradient(rgba(231,236,241,1), rgba(173,188,209,1));
                }

            </style>

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
    <!-- <script src="{{ asset('public/js/pharmacy/logs.js') }}"></script> -->
@stop


@endcomponent
