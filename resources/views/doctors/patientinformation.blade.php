@component('partials/header')

    @slot('title')
        PIS | Patient Information
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
                    <h3 class="text-center text-warning">You are currently serving this patient....</h3>
                    <br>

                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table patientInformation">
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



                    @if(count($refferals) > 0)
                    <div class="col-md-12">
                        <hr>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <p class="text-danger text-center"><strong>This patient has a pending refferal to this clinic.</strong></p>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>ASSIGNED TO DOCTOR</th>
                                            <th>CLINIC</th>
                                            <th>REASONS</th>
                                            <th>STATUS</th>
                                            <th>CREATED DATE</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                            @foreach($refferals as $refferal)
                                                <tr>
                                                    <td>{{ ($refferal->doctorsname)? $refferal->doctorsname : 'Unassigned' }}</td>
                                                    <td>{{ $refferal->name }}</td>
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
                        <hr>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <p class="text-danger text-center"><strong>This patient has a pending followup schedule to this clinic.</strong></p>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>ASSIGNED DOCTOR</th>
                                            <th>CLINIC</th>
                                            <th>REASONS</th>
                                            <th>STATUS</th>
                                            <th>FOLLOW-UP DATE</th>
                                            <th>CREATED DATE</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                            @foreach($followups as $followup)
                                                <tr>
                                                    <td>{{ (!empty($followup->doctorsname))? $followup->doctorsname : 'N/A' }}</td>
                                                    <td>{{ $followup->name }}</td>
                                                    <td>{{ $followup->reason }}</td>
                                                    <td>{!! ($followup->status == 'P')? '<span class="text-danger">Pending</span>' : '<span class="text-success">Finished</span>' !!}</td>
                                                    <td>{{ Carbon::parse($followup->followupdate)->toFormattedDateString() }}</td>
                                                    <td>{{ Carbon::parse($followup->created_at)->toFormattedDateString() }}</td>
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
