@component('partials/header')

    @slot('title')
        PIS | Patients Consultation Status
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/plugins/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/receptions/designation.css') }}" rel="stylesheet" />
@stop


@section('header')
    @include('receptions.navigation')
@stop



@section('content')

    <div class="container-fluid">
        <div class="container">
            <h2 class="text-center">Patients Consultation Status</h2>
            <br>
            <div class="">
                <table class="table" id="patientsTable">
                    <thead>
                    <tr>
                        <th hidden></th>
                        <th>#</th>
                        <th>PATIENTS NAME</th>
                        <th>AGE</th>
                        <th>ASSIGNED TO</th>
                        <th data-placement="top" data-toggle="tooltip" title="Information">INFO</th>
                        <th data-placement="top" data-toggle="tooltip" title="Medical Records">RCRD</th>
                        <th data-placement="top" data-toggle="tooltip" title="Assign to Doctor">ASGN</th>
                        <th data-placement="top" data-toggle="tooltip" title="Re-Assign">RASN</th>
                        <th data-placement="top" data-toggle="tooltip" title="Cancel">CNCL</th>
                        <th data-placement="top" data-toggle="tooltip" title="Time Scanned">DATE/TIME</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($patients) > 0)
                        @foreach($patients as $patient)
                            @php
                                if($patient->status == 'P'){
                                    $asgn = 'disabled onclick="return false"';
                                    $reasgn = '';
                                    $cancel = '';
                                    $status = 'pending';
                                    }
                                elseif($patient->status == 'S'){
                                    $asgn = 'disabled onclick="return false"';
                                    $reasgn = 'disabled onclick="return false"';
                                    $cancel = 'disabled onclick="return false"';
                                    $status = 'serving';
                                    }
                                elseif($patient->status == 'F'){
                                    /*$asgn = 'disabled onclick="return false"';*/
                                    $asgn = '';
                                    $reasgn = 'disabled onclick="return false"';
                                    $cancel = 'disabled onclick="return false"';
                                    $status = 'finished';
                                    }
                                elseif($patient->status == 'C'){
                                    $asgn = '';
                                    $reasgn = 'disabled onclick="return false"';
                                    $cancel = 'disabled onclick="return false"';
                                    $status = 'cancel';
                                    }
                                elseif($patient->status == 'H'){
                                    $asgn = '';
                                    $reasgn = 'disabled onclick="return false"';
                                    $cancel = 'disabled onclick="return false"';
                                    $status = 'paused';
                                    }
                                else{
                                    $asgn = '';
                                    $reasgn = 'disabled onclick="return false"';
                                    $cancel = '';
                                    $status = 'unassigned';
                                    }
                            @endphp
                            <tr>
                                <td hidden>
                                    {{ $loop->index + 1 }}
                                </td>
                                <td class="{{ $status }}">
                                    {{ count($patients) - $loop->index }}
                                </td>
                                <td>{{ $patient->name }}</td>
                                @php
                                    $agePatient = App\Patient::age($patient->birthday)
                                @endphp
                                <td>{!! ($agePatient >= 60)? '<strong style="color: red">'.$agePatient.'</strong>' : '<span class="text-default">'.$agePatient.'</span>' !!}</td>
                                <td>
                                    @if($patient->status == 'S' || $patient->status == 'P' || $patient->status == 'F' || $patient->status == 'H')
                                        @if(App\User::isActive($patient->doctors_id))
                                            {!! "<div class='online'></div> <span class='text-default'>Dr. $patient->doctorsname</span>" !!}
                                        @else
                                            {!! "<div class='offline'></div> <span class='text-default'>Dr. $patient->doctorsname</span>" !!}
                                        @endif
                                    @else
                                        <span class="text-danger">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    <a href='{{ url("patient_info/$patient->id") }}' class="btn btn-default btn-circle">
                                        <i class="fa fa-user-o text-primary"></i>
                                    </a>
                                    @if($patient->ff + $patient->rf > 0)
                                        <span class="badge notifyBadgeNumber">{{ $patient->ff + $patient->rf }}</span>
                                    @endif
                                </td>



                                @php
                                    if($patient->ff + $patient->rf > 0){
                                        $assignedDoctor = App\Refferal::countAllNotifications($patient->id);
                                    }else{
                                        $assignedDoctor = array();
                                    }
                                @endphp




                                <td>
                                    @if($patient->cid == null)
                                        <a href="{{ url('receptions_records/'.$patient->id) }}" class="btn btn-default btn-circle">
                                            <i class="fa fa-file-text-o text-info"></i>
                                        </a>
                                    @else
                                        <a href="{{ url('receptions_records/'.$patient->id) }}" class="btn btn-primary btn-circle">
                                            <i class="fa fa-file-text-o text-default"></i>
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <a href="" class="btn btn-default btn-circle dropdown-toggle" {!! (empty($asgn))? 'data-toggle="dropdown"' : $asgn !!}>
                                            <i class="fa fa-arrow-left text-success"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li class="dropdown-header">--Assign to Doctor--</li>
                                            @if(count($allDoctors) > 0)
                                                @foreach($allDoctors as $allDoctor)
                                                    @php
                                                        $checkAssigned = (in_array($allDoctor->id, $assignedDoctor))? '#adebad' : '';
                                                    @endphp
                                                    <li>
                                                        <a href='{{ url("assign/$patient->id/$allDoctor->id") }}' style="background-color: {!! $checkAssigned !!}">
                                                            @if(App\User::isActive($allDoctor->id))
                                                                {!! "<div class='online'></div> <span class='text-default'>Dr. $allDoctor->name</span>" !!}
                                                            @else
                                                                {!! "<div class='offline'></div> <span class='text-default'>Dr. $allDoctor->name</span>" !!}
                                                            @endif
                                                        </a>
                                                    </li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <a href="" class="btn btn-default btn-circle dropdown-toggle" {!! (empty($reasgn))? 'data-toggle="dropdown"' : $reasgn !!} >
                                            <i class="fa fa-refresh text-primary"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li class="dropdown-header">-- Re-assign to Doctor --</li>
                                            @if(count($allDoctors) > 0)
                                                @foreach($allDoctors as $allDoctor)
                                                    <li class="{{ ($allDoctor->id == $patient->doctors_id)? 'disabled' : '' }}">
                                                        <a href='{{ url("reassign/$allDoctor->id/$patient->asgnid") }}' {!! ($allDoctor->id == $patient->doctors_id)? 'onclick="return false"' : 'onclick="return confirm('."'Re-assign this patient?'".')"' !!}>
                                                            @if(App\User::isActive($allDoctor->id))
                                                                {!! "<div class='online'></div> <span class='text-default'>Dr. $allDoctor->name</span>" !!}
                                                            @else
                                                                {!! "<div class='offline'></div> <span class='text-default'>Dr. $allDoctor->name</span>" !!}
                                                            @endif
                                                        </a>
                                                    </li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                                <td>
                                    <a href='{!! ($patient->status == null)? url("cancelUnassigned/$patient->id") : url("cancelAssignation/$patient->asgnid") !!}' class="btn btn-default btn-circle" {!! $cancel !!} onclick="return confirm('Cancel this patient?')">
                                        <i class="fa fa-remove text-danger"></i>
                                    </a>
                                </td>
                                <td>
                                    {{ Carbon::parse($patient->created_at)->format('H:i:s a') }}
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="9">
                                <p class="text-danger text-center">No patient on the list!</p>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>

            <div class="dropup legendDropdown">
                <button class="btn btn-circle btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                    <i class="fa fa-fire"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-right">
                    <li class="dropdown-header">-- Color Legend --</li>
                    <li><div class="legendDiv"><p class="legendUnassigned"></p> Unassigned</div></li>
                    <li><div class="legendDiv"><p class="legendPending"></p> Pending</div></li>
                    <li><div class="legendDiv"><p class="legendServing"></p> Serving</div></li>
                    <li><div class="legendDiv"><p class="legendFinished"></p> Finished</div></li>
                    <li><div class="legendDiv"><p class="legendPaused"></p> Paused</div></li>
                    <li><div class="legendDiv"><p class="legendCanceled"></p> Canceled</div></li>
                </ul>
            </div>

        </div>
    </div>

@endsection



@section('footer')
@stop



@section('pagescript')
    @include('message.toaster')
    <script src="{{ asset('public/plugins/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/plugins/js/dataTables.bootstrap.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#patientsTable').dataTable();
        });
    </script>
@stop


@endcomponent
