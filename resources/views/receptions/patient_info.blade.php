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




            <div class="row notificationsWrapper">


            @if(count($refferals) > 0)
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <p class="text-danger text-center"><strong>This patient has a pending &nbsp; <b style="color: red;font-size: 25px"> Referral </b> &nbsp; to this clinic.</strong></p>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>PATIENT</th>
                                        <th>FROM_CLINIC</th>
                                        <th>REFFERED_BY</th>
                                        <th>TO_CLINIC</th>
                                        <th>REFFERED_TO</th>
                                        <th>REASON</th>
                                        <th>STATUS</th>
                                        <th>DATE</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($refferals as $refferal)
                                        <tr>
                                            <td>{{ $refferal->name }}</td>
                                            <td>{{ ($refferal->fromClinic)? $refferal->fromClinic : 'N/A' }}</td>
                                            <td>{{ ($refferal->fromDoctor)? 'Dr. '.$refferal->fromDoctor : 'N/A' }}</td>
                                            <td>{{ ($refferal->toClinic)? $refferal->toClinic : 'N/A' }}</td>
                                            <td>{{ ($refferal->toDoctor)? $refferal->toDoctor : 'Unassigned' }}</td>
                                            <td>{{ ($refferal->reason)? $refferal->reason : 'N/A' }}</td>
                                            <td>{!! ($refferal->status == 'P')? '<span class="text-danger">Pending</span>' : '<span class="text-success">Finished</span>' !!}</td>
                                            <td>{{ Carbon::parse($refferal->created_at)->toFormattedDateString() }}</td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            @endif



            @if(count($followups) > 0)
            <div class="col-md-12">
                
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <p class="text-danger text-center"><strong>This patient has a pending &nbsp; <b style="color: red;font-size: 25px"> Followup </b> &nbsp; schedule to this clinic.</strong></p>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>TO_DOCTOR</th>
                                    <th>CLINIC</th>
                                    <th>REASONS</th>
                                    <th>STATUS</th>
                                    <th>FF DATE</th>
                                    {{--<th>CREATED DATE</th>--}}
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($followups as $followup)
                                    <tr>
                                        <td>{{ (!empty($followup->doctorsname))? $followup->doctorsname : 'N/A' }}</td>
                                        <td>{{ $followup->name }}</td>
                                        <td>{!! ($followup->reason)? $followup->reason : 'N/A' !!}</td>
                                        <td>{!! ($followup->status == 'P')? '<span class="text-danger">Pending</span>' : '<span class="text-success">Finished</span>' !!}</td>
                                        <td>{{ Carbon::parse($followup->followupdate)->toFormattedDateString() }}</td>
                                        {{--<td>{{ Carbon::parse($followup->created_at)->toFormattedDateString() }}</td>--}}
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            </div>









            <div class="row">
                
            
            <div class="col-md-8">
                <h2 class="text-center">PATIENT INFORMATION</h2>
                <br>
                <div class="col-md-12">
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
                                    {{ App\Patient::age($patient->birthday) }}
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
                                <td>MSS CLASSIFICATION</td>
                                <td>{{ ($patient->label)? $patient->label.' '.($patient->discount * 100).'%' : 'Unclassified' }}</td>
                            </tr>
                            <tr>
                                <td>DATE REGISTERED:</td>
                                <td>{{ Carbon::parse($patient->created_at)->format('jS \o\f F, Y') }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <h2 class="text-center">VITAL SIGNS</h2>
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
                    <tr>
                        <td>BMI(metric):</td>
                        <td>
                            @if(count($vital_signs) > 0)
                                @if($vital_signs[0]->weight && $vital_signs[0]->height)
                                    @php
                                        $w = $vital_signs[0]->weight;
                                        $h = $vital_signs[0]->height / 100;
                                        $th = $h * $h;
                                        $bmi = $w / $th;
                                    @endphp
                                    {{ number_format($bmi, 3, '.', '') }} 
                                @endif
                            @endif
                        </td>
                    </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            @if(isset($vital_signs[0]->created_at))
                                <th class="text-right" colspan="2">
                                    {{ 'Date examined : '. Carbon::parse($vital_signs[0]->created_at)->toDateTimeString() }}
                                </th>
                            @else
                                <th class="text-right" colspan="2">
                                    <span class='text-danger'>Todays Vital Signs is Unavailable!</span>
                                    <br>
                                    Click this to insert vital signs
                                    <a href="{{ url('vitalSigns/'.$patient->id) }}" class="btn btn-danger btn-circle">
                                        <i class="fa fa-heartbeat"></i>
                                    </a>
                                </th>
                            @endif
                        </tr>
                    </tfoot>
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
