@component('partials/header')

    @slot('title')
        PIS | Medical Records
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
                        <h2 class="text-left">Medical Records</h2>
                        <br>
                        <br>
                    </div>

                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table medicalHistory">
                                <tbody>
                                <tr>
                                    <td><b>PATIENT NAME :</b></td>
                                    <td><h3>{{ $history[0]->name }}</h3></td>
                                </tr>
                                <tr>
                                    <td><b>CONSULTATIONS :</b></td>
                                    <td>
                                        <a href="{{ url('consultation_list/'.$history[0]->id) }}" class="btn {{ ($history[0]->consultations)? 'btn-success' : 'btn-danger' }}  btn-circle" data-placement="right" data-toggle="tooltip" title="Click to view">
                                            {{ $history[0]->consultations or 0 }}
                                        </a>
                                        <small class="text-warning"> &nbsp; consultation records retrieved for this patient.</small>
                                    </td>
                                </tr>
                                {{--<tr>
                                    <td>DIAGNOSIS</td>
                                    <td>
                                        <a href="{{ url('diagnosis_list/'.$history[0]->id) }}" class="btn {{ ($history[0]->diagnosis)? 'btn-success' : 'btn-danger' }} btn-circle" data-placement="right" data-toggle="tooltip" title="Click to view">
                                            {{ $history[0]->diagnosis or 0 }}
                                        </a>
                                        <small class="text-warning"> &nbsp; diagnosis records retrieved for this patient.</small>
                                    </td>
                                </tr>--}}
                                <tr>
                                    <td><b>REFFERALS :</b></td>
                                    <td>
                                        <a href="{{ url('refferal_list/'.$history[0]->id) }}" class="btn {{ ($history[0]->refferals)? 'btn-success' : 'btn-danger' }} btn-circle" data-placement="right" data-toggle="tooltip" title="Click to view">
                                            {{ $history[0]->refferals or 0 }}
                                        </a>
                                        <small class="text-warning"> &nbsp; refferal records retrieved for this patient.</small>
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>FOLLOW UP :</b></td>
                                    <td>
                                        <a href="{{ url('followup_list/'.$history[0]->id) }}" class="btn {{ ($history[0]->followups)? 'btn-success' : 'btn-danger' }} btn-circle" data-placement="right" data-toggle="tooltip" title="Click to view">
                                            {{ $history[0]->followups or 0 }}
                                        </a>
                                        <small class="text-warning"> &nbsp; follow up records retrieved for this patient.</small>
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
                                    <td><b>REQUISITIONS :</b></td>
                                    <td>
                                       <a href="{{ url('requisitions_list/'.$history[0]->id) }}" class="btn {{ ($history[0]->requisitions)? 'btn-success' : 'btn-danger' }} btn-circle" data-placement="right" data-toggle="tooltip" title="Click to view">
                                            {{ $history[0]->requisitions or 0 }}
                                        </a>
                                        <small class="text-warning"> &nbsp; requisition records retrieved for this patient.</small>
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
