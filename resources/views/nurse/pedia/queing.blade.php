@component('partials/header')

    @slot('title')
        PIS | Pedia Queuing
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/plugins/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/doctors/patientlist.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/nurse/pedia/queuingTable.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/partials/patient_info.css') }}" rel="stylesheet" />
@stop


@section('header')
    @include('nurse.pedia.navigation')
@stop



@section('content')


    <div class="container">


        @include('doctors.medicalRecords')
        @include('doctors.ajaxConsultationList')
        @include('doctors.ajaxRequisitionList')
        @include('doctors.ajaxRefferals')
        @include('doctors.ajaxFollowup')
        @include('doctors.requisition.medsWatch')
        @include('doctors.records.radiology')
        @include('ancillary.chargingmodal')
        @include('ancillary.loader')




        @include('partials.patient_info')

        @include('nurse.pedia.form_records')


        @if($queuings->isEmpty())

            <br>
            <br>
            <br>
            <div class="alert alert-danger text-center">
                <strong>
                    No Patients On Queued <i class="fa fa-warning"></i>
                </strong>
            </div>


        @else

            <br>

        <div class="table-responsive">
            <table class="table table-bordered table-condensed" id="queuingTable">
                <thead>
                    <tr>
                        <th>No. #</th>
                        <th>Patient Name</th>
                        <th>Age</th>
                        <th>Patient Info</th>
                        <th>Forms</th>
                        <th>Records</th>
                        <th>Assigned Doctor</th>
                        <th>Action</th>
                        <th>Status</th>
                        <th>Timestamp</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($queuings as $queuing)
                    <tr>
                        <td>
                            {{ $loop->index + 1 }}
                        </td>
                        <td class="text-uppercase">
                            <strong class="text-info">{{ $queuing->ptLastName.', '.$queuing->ptFirstName.' '.$queuing->ptSuffix.' '.$queuing->ptMiddleName }}</strong>
                        </td>
                        <td>
                            @php $age = App\Patient::age($queuing->birthday); @endphp
                                @if($age >= 60)
                                    <strong class="text-danger">
                                        {{ $age }}
                                    </strong>
                                @else
                                    {{ $age }}
                                @endif
                        </td>
                        <td>
                            <button class="btn btn-default btn-circle patient_info" data-pid="{{ $queuing->patients_id }}">
                                <i class="fa fa-user-o"></i>
                            </button>
                        </td>
                        <?php
                        if ($queuing->status == 'F'){
                            $className = 'bg-blue';
                            $statusText = 'Finished';
                        }elseif ($queuing->status == 'P'){
                            $className = 'bg-orange';
                            $statusText = 'Pending';
                        }elseif ($queuing->status == 'H'){
                            $className = 'bg-brown';
                            $statusText = 'Paused';
                        }elseif ($queuing->status == 'C'){
                            $className = 'bg-red';
                            $statusText = 'NAWC';
                        }elseif ($queuing->status == 'S'){
                            $className = 'bg-green';
                            $statusText = 'Serving';
                        }else{
                            $className = 'bg-purple';
                            $statusText = 'Unassigned';
                        }
                        ?>
                        <td>
                            <button class="btn btn-default btn-circle" onclick="showPediaForms({{ $queuing->patients_id }})">
                                <i class="fa fa-file-o"></i>
                            </button>
                        </td>
                        <td>
                            <button class="btn btn-default btn-circle"
                                    onclick="medicalRecords({{ $queuing->patients_id }})" title="View medical record's">
                                <i class="fa fa-file-text-o text-primary"></i>
                            </button>
                        </td>
                        <td class="text-uppercase">
                            @if($queuing->doctors_id)
                                <strong class="text-info">
                                    DR. {{ $queuing->last_name.', '.$queuing->first_name.' '.$queuing->suffix.' '.$queuing->middle_name }}
                                </strong>
                            @else
                                <strong class="text-danger">
                                    None
                                </strong>
                            @endif
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-default dropdown-toggle" type="button" id="dropdownMenu1"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    Pediatric Forms
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li>
                                        <a href="{{ url('otpc_homepage/'.$queuing->patients_id) }}" target="_blank">
                                            Therapeutic Care
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('childhood_care/'.$queuing->patients_id) }}" target="_blank">
                                            Childhood Care
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('kmc/'.$queuing->patients_id) }}" target="_blank">
                                            KMC (Kangaroo Mother Care Program)
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                        <td class="{{ $className }}">
                            {{ $statusText }}
                        </td>
                        <td>
                            Today {{ Carbon::parse($queuing->created_at)->format('h:i:s') }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="10" class="text-center">
                            {{ $queuings->links() }}
                        </td>
                    </tr>
                </tfoot>
            </table>

        </div>


        @endif

    </div>

@endsection



@section('footer')
@stop



@section('pagescript')

    @include('message.toaster')
    <script src="{{ asset('public/plugins/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/plugins/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/js/partials/patient_info.js') }}"></script>
    <script src="{{ asset('public/js/nurse/pedia/form_records.js') }}"></script>

    <script src="{{ asset('public/js/doctors/ajaxRecords.js') }}"></script>
    <script src="{{ asset('public/js/receptions/consultation.js') }}"></script>
    <script src="{{ asset('public/js/results/master.js') }}"></script>
    <script src="{{ asset('public/js/results/medsWatch.js') }}"></script>
    <script src="{{ asset('public/js/results/ultrasound.js') }}"></script>
    <script src="{{ asset('public/js/results/radiologyQuickView.js') }}"></script>

    <script>
        $('#queuingTable').dataTable({
            language: {
                searchPlaceholder: "Filter Patients"
            },
            bPaginate: false,
            bInfo: false
        });
    </script>
    @include('receptions.message.notify')

@stop


@endcomponent
