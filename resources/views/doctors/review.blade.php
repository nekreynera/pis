@component('partials/header')

    @slot('title')
        PIS | Review
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/css/doctors/reset.css') }}" rel="stylesheet" />
    @if(Auth::user()->theme == 2)
        <link href="{{ asset('public/css/doctors/darkstyle.css') }}" rel="stylesheet" />
    @else
        <link href="{{ asset('public/css/doctors/greenstyle.css') }}" rel="stylesheet" />
    @endif
    <link href="{{ asset('public/plugins/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/doctors/patientinfo.css') }}" rel="stylesheet" />
@endsection



@section('header')
    @include('doctors.navigation')
@stop



@section('content')
    @component('doctors.dashboard')
@section('main-content')


    <div class="content-wrapper">
        <br>
        <div class="container-fluid">

            <div class="">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="text-left">Review Consulted Patient</h2>
                        <br>
                        <br>
                    </div>

                    <div class="col-md-10">
                        <div class="table-responsive">
                            <table class="table medicalHistory">
                                <tbody>
                                <tr>
                                    <td>PATIENT NAME</td>
                                    <td>{{ $review[0]->name }}</td>
                                </tr>
                                <tr>
                                    <td>CONSULTATIONS:</td>
                                    <td>
                                        <a href="{{ url('review_consultation_list/'.$review[0]->id) }}" class="btn {{ ($review[0]->consultations)? 'btn-success' : 'btn-danger' }} btn-circle" data-placement="top" data-toggle="tooltip" title="Click to view">
                                            {{ $review[0]->consultations or 0 }}
                                        </a>
                                        {!! ($review[0]->consultations)? '<small class="text-success">Submitted consultation</small>' : ' <small class="text-danger">Unsubmitted consultation</small>' !!}
                                    </td>
                                </tr>
                                {{--<tr>
                                    <td>DIAGNOSIS</td>
                                    <td>
                                        <a href="{{ url('diagnosis_list/'.$review[0]->id) }}" class="btn {{ ($review[0]->diagnosis)? 'btn-success' : 'btn-danger' }} btn-circle" data-placement="top" data-toggle="tooltip" title="Click to view">
                                            {{ $review[0]->diagnosis or 0 }}
                                        </a>
                                        {!! ($review[0]->diagnosis)? '<small class="text-success">Submitted diagnosis</small>' : ' <small class="text-danger">Unsubmitted diagnosis</small>' !!}
                                    </td>
                                </tr>--}}
                                <tr>
                                    <td>REFFERALS:</td>
                                    <td>
                                        <a href="{{ url('review_refferal/'.$review[0]->id) }}" class="btn {{ ($review[0]->refferals)? 'btn-success' : 'btn-danger' }} btn-circle" data-placement="top" data-toggle="tooltip" title="Click to view">
                                            {{ $review[0]->refferals or 0 }}
                                        </a>
                                        {!! ($review[0]->refferals)? '<small class="text-success">Submitted refferals</small>' : ' <small class="text-danger">Unsubmitted refferals</small>' !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td>FOLLOW UP:</td>
                                    <td>
                                        <a href="{{ url('review_followup/'.$review[0]->id) }}" class="btn {{ ($review[0]->followups)? 'btn-success' : 'btn-danger' }} btn-circle" data-placement="top" data-toggle="tooltip" title="Click to view">
                                            {{ $review[0]->followups or 0 }}
                                        </a>
                                        {!! ($review[0]->followups)? '<small class="text-success">Submitted follow-up</small>' : ' <small class="text-danger">Unsubmitted follow-up</small>' !!}
                                    </td>
                                </tr>
                                {{--<tr>
                                    <td>LABORATORIES:</td>
                                    <td>
                                        <a href="" class="btn btn-success btn-circle" data-placement="right" data-toggle="tooltip" title="Click to view">
                                            {{ $history[0]->consultations or 0 }}
                                        </a>
                                    </td>
                                </tr>--}}
                                <tr>
                                    <td>REQUISITIONS:</td>
                                    <td>
                                        <a href="{{ url('requisitions_list/'.$review[0]->id) }}" class="btn {{ ($review[0]->requisitions)? 'btn-success' : 'btn-danger' }} btn-circle" data-placement="top" data-toggle="tooltip" title="Click to view">
                                            {{ $review[0]->requisitions or 0 }}
                                        </a>
                                        {!! ($review[0]->requisitions)? '<small class="text-success">Submitted requisitions</small>' : ' <small class="text-danger">Unsubmitted requisitions</small>' !!}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

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
    <script src="{{ asset('public/plugins/js/form.js') }}"></script>
    <script src="{{ asset('public/plugins/js/modernizr.js') }}"></script>
    <script src="{{ asset('public/plugins/js/jquery.menu-aim.js') }}"></script>
    <script src="{{ asset('public/js/doctors/main.js') }}"></script>
@stop


@endcomponent
