@component('partials/header')

    @slot('title')
        PIS | Patients
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/plugins/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('public/css/radiology/master.css') }}">
    <link href="{{ asset('public/css/doctors/patientlist.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/requisition/medicines.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('public/css/radiology/patients.css') }}">
    <link href="{{ asset('public/css/receptions/status.css') }}" rel="stylesheet" />
@stop



@section('header')
    @include('radiology/navigation')
@stop



@section('content')

    <div class="container-fluid">
        <div class="container">

            @include('doctors.medicalRecords')
            @include('doctors.ajaxConsultationList')
            @include('doctors.ajaxRequisitionList')
            @include('doctors.ajaxRefferals')
            @include('doctors.ajaxFollowup')
            @include('doctors.requisition.medsWatch')
            @include('doctors.records.radiology')



            @include('radiology.modal')

            @include('radiology.quickView')


            <h3 class="text-center">Patients</h3>
            <br>

            @include('radiology.store.status')


            <br>


            <div class="table-responsive">
                <table class="table" id="radiologyTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Patient Name</th>
                            <th>Age</th>
                            <th>Information</th>
                            <th>Records</th>
                            <th>Action</th>
                            <th>Event</th>
                            {{--<th>Cashier</th>--}}
                            {{--<th>Done</th>--}}
                            <th>Timestamp</th>
                        </tr>
                    </thead>

                    @if(count($patients) > 0)
                        @foreach($patients as $patient)
                            <tr>
                                @php
                                    switch ($patient->queue_status){
                                        case 'F':
                                            $stats = 'finishedTabActive';
                                            break;
                                        default:
                                            $stats = 'servingTabActive';
                                            break;
                                    }
                                    $age = App\Patient::age($patient->birthday);
                                @endphp
                                <td class="{{ $stats }}">{{ $loop->index + 1 }}</td>
                                <td>{{ $patient->patient }}</td>
                                <td>
                                    {!! ( $age >= 60)? '<strong>'.$age.'</strong>' : $age !!}
                                </td>
                                <td>
                                    <a href="{{ url('radiology/'.$patient->pid) }}" class="btn btn-default btn-circle">
                                        <i class="fa fa-user-o"></i>
                                    </a>
                                </td>
                                <td>
                                    <button class="btn btn-primary btn-circle"
                                            onclick="medicalRecords({{ $patient->patients_id }})" title="View medical record's">
                                        <i class="fa fa-file-text-o"></i>
                                    </button>
                                </td>
                                <td>
                                    <button class="btn btn-sm {{ ($patient->get == null)? 'btn-default' : 'btn-warning' }}"
                                       data-toggle="modal" data-target="#radiologyModal"
                                       onclick="manageRequest({{ $patient->patients_id }})">
                                        <i class="fa fa-cog fa-spin"></i> Result
                                    </button>
                                </td>
                                <td>
                                    @if($patient->queue_status == 'F')
                                        <a href="{{ url('markedDone/'.$patient->id.'/D') }}" class="btn btn-circle btn-success"
                                           data-toggle="tooltip" data-placement="top" title="Click to marked as finished?">
                                            <i class="fa fa-check"></i>
                                        </a>
                                    @else
                                        <a href="{{ url('markedDone/'.$patient->id.'/F') }}" class="btn btn-circle btn-danger"
                                           data-toggle="tooltip" data-placement="top" title="Revert this patient?">
                                            <i class="fa fa-refresh"></i>
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    {{ Carbon::parse($patient->created_at)->format('M d, h:i:s a') }}
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="8" class="text-center">
                                <div class="alert alert-danger">
                                    <strong class="text-danger">
                                        No Patients Found <i class="fa fa-warning"></i>
                                    </strong>
                                </div>
                            </td>
                        </tr>
                    @endif

                </table>
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

    <script src="{{ asset('public/js/doctors/ajaxRecords.js') }}"></script>
    <script src="{{ asset('public/js/receptions/consultation.js') }}"></script>
    <script src="{{ asset('public/js/results/master.js') }}"></script>
    <script src="{{ asset('public/js/results/medsWatch.js') }}"></script>
    <script src="{{ asset('public/js/results/ultrasound.js') }}"></script>
    <script src="{{ asset('public/js/results/radiologyQuickView.js') }}"></script>

    <script src="{{ asset('public/js/radiology/manage.js') }}"></script>
    <script src="{{ asset('public/js/radiology/quickView.js') }}"></script>
    <script src="{{ asset('public/js/results/master.js') }}"></script>
@stop


@endcomponent
