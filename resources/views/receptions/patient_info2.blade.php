@component('partials/header')

    @slot('title')
        PIS | Patient Information
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/css/receptions/patient_info.css') }}" rel="stylesheet" />
@stop



@section('header')
    @include('receptions.navigation')
@stop



@section('content')

        <div class="container-fluid">
            <div class="container">
                <div class="row col-md-8">
                    <h2 class="text-center">PATIENT INFORMATION</h2>
                    <br>
                    <br>
                    <div class="col-md-3 notificationsWrapper">
                        <a href="" class="btn btn-default">5 Consultations</a>
                        <a href="" class="btn btn-default">5 Requisitions</a>
                        <a href="" class="btn btn-default">5 Diagnosis</a>

                        <br>
                        @if(isset($consultationStatus->status) && $consultationStatus->status == 'P')
                            <p class="text-center">Consultation Status:</p>
                            <h4 class="text-center text-primary">PENDING...<i class="fa fa-cog fa-spin"></i></h4>
                            <div class="dropdown patient_infoAssign">
                                <a href="" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                                    RE-ASSIGN
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="dropdown-header">--Assign to Doctor--</li>
                                    @if(count($allDoctors) > 0)
                                        @foreach($allDoctors as $allDoctor)
                                            <li class="{{ ($allDoctor->id == $consultationStatus->doctors_id)? 'disabled' : '' }}">
                                                <a href='{{ url("reassign/$allDoctor->id/$consultationStatus->id") }}'>
                                                    Dr. {{ $allDoctor->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                            <a href='{{ url("cancelAssignation/$consultationStatus->id") }}' class="btn btn-danger">CANCEL</a>

                        @elseif(isset($consultationStatus->status) && $consultationStatus->status == 'S')
                            <p class="text-center">Consultation Status:</p>
                            <h4 class="text-center text-success">NOW SERVING <i class="fa fa-heartbeat"></i></h4>
                            <h5>Assigned To:</h5>
                            <h5><a href="">DR. MARK JOSEPH DAGAMI</a></h5>

                        @elseif(isset($consultationStatus->status) && $consultationStatus->status == 'C')
                            <p class="text-center">Consultation Status:</p>
                            <h4 class="text-center text-danger">CANCELED <i class="fa fa-exclamation"></i></h4>
                            <div class="dropdown patient_infoAssign">
                                <a href="" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                                    RE-ASSIGN
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="dropdown-header">--Assign to Doctor--</li>
                                    @if(count($allDoctors) > 0)
                                        @foreach($allDoctors as $allDoctor)
                                            <li class="{{ ($allDoctor->id == $consultationStatus->doctors_id)? 'disabled' : '' }}">
                                                <a href='{{ url("reassign/$allDoctor->id/$consultationStatus->id") }}'>
                                                    Dr. {{ $allDoctor->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>

                        @elseif(isset($consultationStatus->status) && $consultationStatus->status == 'F')
                            <p class="text-center">Consultation Status:</p>
                            <h4 class="text-center text-success">FINISHED <i class="fa fa-check"></i></h4>

                        @else
                            <p class="text-center">Consultation Status:</p>
                            <h4 class="text-center text-danger">UNASSIGNED <i class="fa fa-feed"></i></h4>
                            <div class="dropdown patient_infoAssign">
                                <a href="" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                                    ASSIGN
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="dropdown-header">--Assign to Doctor--</li>
                                    @if(count($allDoctors) > 0)
                                        @foreach($allDoctors as $allDoctor)
                                            <li>
                                                <a href='{{ url("assign/$patient->id/$allDoctor->id") }}'>
                                                    Dr. {{ $allDoctor->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                            <a href='{{ url("cancelUnassigned/$patient->id") }}' class="btn btn-danger">CANCEL</a>
                        @endif
                        

                    </div>
                    <div class="col-md-9">
                        <div class="table-responsive">
                            <table class="table patientInfo">
                                <tbody>
                                    <tr>
                                        <td>HOSPITAL NO:</td>
                                        <td>{{ $patient->hospital_no }}</td>
                                    </tr>
                                    <tr>
                                        <td>BARCODE:</td>
                                        <td>{{ $patient->barcode }}</td>
                                    </tr>
                                    <tr>
                                        <td>NAME:</td>
                                        <td>{{ $patient->last_name.', '.$patient->first_name.' '.$patient->suffix.' '.$patient->middle_name }}</td>
                                    </tr>
                                    <tr>
                                        <td>BIRTHDAY:</td>
                                        <td>{{ Carbon::parse($patient->birthday)->format('F d, Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td>AGE:</td>
                                        <td>
                                            {{
                                                Carbon::createFromDate(
                                                Carbon::parse($patient->birthday)->year,
                                                Carbon::parse($patient->birthday)->month,
                                                Carbon::parse($patient->birthday)->day
                                                )->age
                                            }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>ADDRESS:</td>
                                        <td>{{ $patient->address }}</td>
                                    </tr>
                                    <tr>
                                        <td>SEX:</td>
                                        <td>
                                            @php
                                                switch($patient->sex)
                                                {
                                                    case 'M':
                                                        echo 'Male';
                                                        break;
                                                    case 'F':
                                                        echo 'Female';
                                                        break;
                                                }
                                            @endphp
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>CIVIL STATUS:</td>
                                        <td>{{ $patient->civil_status }}</td>
                                    </tr>
                                    <tr>
                                        <td>DATE REGISTERED:</td>
                                        <td>{{ Carbon::parse($patient->creatsed_at)->format('jS \o\f F, Y') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <h2 class="text-center">VITAL SIGNS</h2>
                    <br>
                    <br>
                    <table class="table vitalSigns">

                                <tbody>
                                    <tr>
                                        <td>Blood Pressure:</td>
                                        <td>{{ (isset($vital_signs[0]->blood_pressure))? $vital_signs[0]->blood_pressure : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Pulse Rate:</td>
                                        <td>{{ (isset($vital_signs[0]->pulse_rate))? $vital_signs[0]->pulse_rate : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Respiration Rate:</td>
                                        <td>{{ (isset($vital_signs[0]->respiration_rate))? $vital_signs[0]->respiration_rate : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Body Temperature:</td>
                                        <td>{{ (isset($vital_signs[0]->body_temperature))? $vital_signs[0]->body_temperature : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Weight:</td>
                                        <td>{{ (isset($vital_signs[0]->weight))? $vital_signs[0]->weight : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Height:</td>
                                        <td>{{ (isset($vital_signs[0]->height))? $vital_signs[0]->height : '' }}</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-right" colspan="2">
                                            {!! (isset($vital_signs[0]->created_at))? 'Date examined :' . Carbon::parse($vital_signs[0]->created_at)->format('jS \o\f F, Y') : "<span class='text-danger'>Todays Vital Signs is Unavailable!</span>" !!}
                                        </th>
                                    </tr>
                                </tfoot>
                    </table>
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
