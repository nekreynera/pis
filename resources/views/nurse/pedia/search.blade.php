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

        <br>

        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <form action="{{ url('pediaSearchPatient') }}" method="get" id="pediaSearchPatient">
                    {{ csrf_field() }}
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" value="{{ $data['search'] }}" placeholder="Search Patient..." aria-describedby="basic-addon1">
                        <span class="input-group-addon" id="basic-addon1"
                              onclick="document.getElementById('pediaSearchPatient').submit()"
                              title="Click to search">
                        <i class="fa fa-search"></i>
                    </span>
                    </div>
                    <small><em class="text-muted"> Enter patient name, hospital no, barcode or date registered. Ex: Santos Juan</em></small>
                </form>
            </div>
        </div>


        <hr>



        @if(!$data['search'])
            <div class="alert alert-info text-center">
                <strong>Please use the search form to retrieve patients.</strong>
            </div>
        @else


            @if($data['queuings']->isEmpty())

                <div class="alert alert-danger text-center">
                    <strong>Sorry! No Patients Found.</strong>
                </div>


            @else


                <div class="row">



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
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($data['queuings'] as $row)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>
                                        <strong class="text-capitalize text-info">
                                            {{ $row->last_name.', '.$row->first_name.' '.$row->suffix.' '.$row->middle_name }}
                                        </strong>
                                    </td>
                                    <td>
                                        @php $age = App\Patient::age($row->birthday); @endphp
                                        @if($age >= 60)
                                            <strong class="text-danger">
                                                {{ $age }}
                                            </strong>
                                        @else
                                            {{ $age }}
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-default btn-circle patient_info" data-pid="{{ $row->id }}">
                                            <i class="fa fa-user-o"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn btn-default btn-circle" onclick="showPediaForms({{ $row->id }})">
                                            <i class="fa fa-file-o"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn btn-default btn-circle"
                                                onclick="medicalRecords({{ $row->id }})" title="View medical record's">
                                            <i class="fa fa-file-text-o text-primary"></i>
                                        </button>
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
                                                    <a href="{{ url('otpc_homepage/'.$row->id) }}" target="_blank">
                                                        Therapeutic Care
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ url('childhood_care/'.$row->id) }}" target="_blank">
                                                        Childhood Care
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ url('kmc/'.$row->id) }}" target="_blank">
                                                        KMC (Kangaroo Mother Care Program)
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>

                            <tfoot>
                                <tr>
                                    <td colspan="9" class="text-center">
                                        {{ $data['queuings']->appends(['search' => $data['search'] ])->links() }}
                                    </td>
                                </tr>
                            </tfoot>

                        </table>
                    </div>

                </div>

            @endif






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
