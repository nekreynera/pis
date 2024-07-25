@component('partials/header')

    @slot('title')
        PIS | Search Patients
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/plugins/css/jquery-ui.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/plugins/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/doctors/patientlist.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/receptions/designation.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/receptions/status.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/requisition/medicines.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('public/css/patients/searchpatient.css') }}" />
@stop


@section('header')
    @include('receptions.navigation')
@stop



@section('content')
    <div class="container">

        @include('doctors.medicalRecords')
        @include('doctors.ajaxConsultationList')
        @include('doctors.ajaxRequisitionList')
        @include('doctors.ajaxRefferals')
        @include('doctors.ajaxFollowup')
        @include('doctors.requisition.medsWatch')
        @include('nurse.pedia.form_records')
        

        <br/>
        <div class="row searchpatient">
            <form action="{{ url('patientsearch') }}" method="post">
                {{ csrf_field() }}
                <div class="col-md-8 col-md-offset-2">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-default dropdown-toggle"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Filter By <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a href="" class="name">Patient Name</a></li>
                                    <li><a href=""  class="birthday">Patient Birthday</a></li>
                                    <li><a href="" class="barcode">Patient Barcode</a></li>
                                    <li><a href="" class="hospital_no">Patient Hospital No.</a></li>
                                    <li><a href="" class="created_at">Date Registered</a></li>
                                </ul>
                            </div><!-- /btn-group -->
                            <input type="text" name="name" id="searchInput" class="form-control" placeholder="Search For Patient Name..." autofocus />
                            <span class="input-group-btn">
                                        <button class="btn btn-success" type="submit">
                                            <i class="fa fa-search"></i> Search
                                        </button>
                                    </span>
                        </div><!-- /input-group -->
                    </div>
                </div>
            </form>
        </div>

        <br/>
        <h3 class="text-center">SEARCH RESULTS</h3>
        <br/>

        @include('message.msg')

        <div class="table-responsive">
            <table class="table table-striped table-hover" id="unprintedTable">
                <thead>
                <tr>
                    <th>HOSPITAL#</th>
                    <th>BARCODE</th>
                    <th>FULLNAME</th>
                    <th>ADDRESS</th>
                    <th>BIRTHDAY</th>
                    <th>SEX</th>
                    <th>VIEW</th>
                </tr>
                </thead>
                <tbody>
                @if(isset($patients))
                    @foreach($patients as $patient)
                        <tr>
                            <td>{{ $patient->hospital_no }}</td>
                            <td>{{ $patient->barcode }}</td>
                            <td>{{ $patient->last_name.' '.$patient->first_name.' '.$patient->middle_name }}</td>
                            <td>{{ $patient->address }}</td>
                            <td>{{ Carbon::parse($patient->birthday)->toFormattedDateString() }}</td>
                            <td>{{ $patient->sex }}</td>
                            <td>
                                @if($patient->cid == null)
                                    <button class="btn btn-default btn-circle"
                                            onclick="medicalRecords({{ $patient->id }})" title="View medical record's">
                                        <i class="fa fa-file-text-o text-primary"></i>
                                    </button>
                                @else
                                    <button class="btn btn-primary btn-circle"
                                            onclick="medicalRecords({{ $patient->id }})" title="View medical record's">
                                        <i class="fa fa-file-text-o text-default"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>

    <br><br>
@endsection




@section('pagescript')
    @include('message.toaster')
    <script src="{{ asset('public/plugins/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('public/plugins/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/plugins/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/js/patients/unprinted.js') }}"></script>
    <script src="{{ asset('public/js/doctors/ajaxRecords.js') }}"></script>
    <script src="{{ asset('public/js/receptions/consultation.js') }}"></script>
    <script src="{{ asset('public/js/results/master.js') }}"></script>
    <script src="{{ asset('public/js/results/medsWatch.js') }}"></script>
    <script src="{{ asset('public/js/results/ultrasound.js') }}"></script>
    <script src="{{ asset('public/js/nurse/pedia/form_records.js') }}"></script>
@stop


@endcomponent
