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
                    <h3 class="text-left"> <i class="fa fa-user-md"></i> MANAGE REQUEST</h3>
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
                   <div class="tobesubmit">
                    <div class="contents">
                    </div>
                   </div>
                <div class="col-md-12 tables">
                    <div class="table-banner">
                        <h4> <i class="fa fa-list"> List of Requesition</i> </h4>
                    </div>
                    <div class="table-responsive">
                       <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                               <th>CLINIC</th>
                               <th>CONSULTED BY</th>
                               <th>REQUISITION DATE</th>
                               <th>UPDATED</th>
                               <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>

                            @if(count($requisition)  > 0)
                            @foreach($requisition as $list)
                            <tr>

                                <td>{{ $list->name }}</td>
                                <td>{{ $list->doctor }}</td>
                                <td align="center">{{ Carbon::parse($list->created_at)->format('m/d/Y g:ia') }}</td>
                                <td align="center">{{ Carbon::parse($list->updated_at)->format('m/d/Y g:ia') }}</td>
                                <td>
                                    <form method="post" action="{{ url('scancontrol') }}">
                                         {{ csrf_field() }}
                                        <input type="hidden" name="patient_id" value="{{ $patient->id }}"> 
                                        <input type="hidden" name="modifier" value="{{ $list->modifier }}"> 
                                        <input type="hidden" name="doctor" value="{{ $list->doctor }}"> 
                                        <button type="submit" class="btn btn-success btn-sm">MANAGE</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="5" class="danger" align="center">no requisition found</td>
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
    <script src="{{ asset('public/js/pharmacy/managerequest.js') }}"></script>
@stop
@endcomponent