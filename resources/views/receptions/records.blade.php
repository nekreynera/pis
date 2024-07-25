@component('partials/header')

    @slot('title')
        PIS | Medical Records
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/css/doctors/patientinfo.css') }}" rel="stylesheet" />
@stop


@section('header')
    @include('receptions.navigation')
@stop



@section('content')

    <div class="container-fluid">

            <div class="container">
                <div class="">
                    <h2 class="text-center">Medical Records</h2>
                    <br><br>
                    <div class="table-responsive">
                        <table class="table medicalHistory">
                            <tbody>
                            <tr>
                                <td><b>PATIENT NAME</b></td>
                                <td><b>{{ $history[0]->name }}</b></td>
                            </tr>
                            <tr>
                                <td><b>CONSULTATIONS:</b></td>
                                <td>
                                    <a href="{{ url('rcptn_consultation_list/'.$history[0]->id) }}" class="btn {{ ($history[0]->consultations)? 'btn-success' : 'btn-danger' }}  btn-circle" data-placement="right" data-toggle="tooltip" title="Click to view">
                                        {{ $history[0]->consultations or 0 }}
                                    </a>
                                    <small class="text-warning"> &nbsp; consultation records retrieved for this patient.</small>
                                </td>
                            </tr>
                            {{--<tr>
                                <td>DIAGNOSIS</td>
                                <td>
                                    <a href="{{ url('rcptn_diagnosisList/'.$history[0]->id) }}" class="btn {{ ($history[0]->diagnosis)? 'btn-success' : 'btn-danger' }} btn-circle" data-placement="right" data-toggle="tooltip" title="Click to view">
                                        {{ $history[0]->diagnosis or 0 }}
                                    </a>
                                    <small class="text-warning"> &nbsp; diagnosis records retrieved for this patient.</small>
                                </td>
                            </tr>--}}
                            <tr>
                                <td><b>REFFERALS:</b></td>
                                <td>
                                    <a href="{{ url('rcptn_refferalList/'.$history[0]->id) }}" class="btn {{ ($history[0]->refferals)? 'btn-success' : 'btn-danger' }} btn-circle" data-placement="right" data-toggle="tooltip" title="Click to view">
                                        {{ $history[0]->refferals or 0 }}
                                    </a>
                                    <small class="text-warning"> &nbsp; refferal records retrieved for this patient.</small>
                                </td>
                            </tr>
                            <tr>
                                <td><b>FOLLOW UP:</b></td>
                                <td>
                                    <a href="{{ url('rcptn_followupList/'.$history[0]->id) }}" class="btn {{ ($history[0]->followups)? 'btn-success' : 'btn-danger' }} btn-circle" data-placement="right" data-toggle="tooltip" title="Click to view">
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
                                <td><b>REQUISITIONS:</b></td>
                                <td>
                                    <a href="{{ url('receptions_reqList/'.$history[0]->id) }}" class="btn {{ ($history[0]->requisitions)? 'btn-success' : 'btn-danger' }} btn-circle" data-placement="right" data-toggle="tooltip" title="Click to view">
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

@endsection



@section('footer')
@stop



@section('pagescript')
    @include('message.toaster')
@stop


@endcomponent
