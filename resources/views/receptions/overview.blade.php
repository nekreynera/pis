@component('partials/header')

    @slot('title')
        PIS | Overview
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/plugins/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/patients/register.css?v1.0.1') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/doctors/patientlist.css?v1.0.1') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/receptions/designation.css?v1.0.1') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/receptions/status.css?v1.0.1') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/requisition/medicines.css?v1.0.1') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/ancillary/charging.css?v1.0.2') }}" rel="stylesheet" />
    <!-- <link href="{{ asset('public/css/medicalcertificate/medicalcertificate.css') }}" rel="stylesheet" /> -->
@stop


@section('header')
    @include('receptions.navigation')
@stop



@section('content')
    <br>
    <div class="container-fluid" id="overviewWrapper">

        @include('doctors.medicalRecords')
        @include('doctors.ajaxConsultationList')
        @include('doctors.ajaxRequisitionList')
        @include('doctors.ajaxRefferals')
        @include('doctors.ajaxFollowup')
        @include('doctors.requisition.medsWatch')
        @include('doctors.records.radiology')
        @include('ancillary.chargingmodal')
        @include('ancillary.patientinfo')
        @include('ancillary.vitalsigns')
        @include('ancillary.chiefcomplaint')
        @include('ancillary.nursenotes')
        @include('ancillary.loader')
        @include('ancillary.loaderbackground')
        @include('nurse.pedia.form_records')
        @include('partials.alert')
        @include('doctors.laboratory_result')



        @php
            $chrgingClinics = array(3,5,8,24,32,34,10,48,22,21,25,11,26,52,17);
            $noDoctorsClinic = array(48,22,21);
        @endphp

        <div class="">

            @if(!in_array(Auth::user()->clinic, $noDoctorsClinic))
                @include('receptions.overview.doctors')
            @endif

            <div class="{{ (!in_array(Auth::user()->clinic, $noDoctorsClinic))? 'col-md-8' : 'container' }} patientsWrapper">
                <br>

                @include('receptions.overview.title')

                    @if(in_array(Auth::user()->clinic, $noDoctorsClinic))
                        <div class="status" id="{{ $status }}">
                        <hr>
                        @include('receptions.ancillary.status')
                    @else
                        <div class="status overviewstatus" id="{{ $status }}">
                        @include('receptions.overview.status')
                    @endif
                </div>

                <br>
                <div class="table-responsive patientsOverview">
                    <table class="table" id="patientsTable">

                        @include('receptions.overview.thead')

                        <tbody class="loadPatients" id="{{ Request::is('overview') }}" data-id="{{ Request::is('rcptnLogs/*/*/*') }}" charoff="{{ url()->current() }}">
                            {{ csrf_field() }}
                            
                        </tbody>
                    </table>

                </div>

                @include('partials.legend')


            </div>
        </div>

    </div>

@endsection



@section('footer')
@stop



@section('pagescript')

    @include('message.toaster')
    <script>
           // $('#modal-medical-records').modal("toggle");
       var dateToday = '{{ Carbon::today()->format("m/d/Y") }}';
   </script>

    <script src="{{ asset('public/plugins/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/plugins/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/js/receptions/overview.js?v1.0.2') }}"></script>
    <script src="{{ asset('public/js/doctors/ajaxRecords.js?v1.0.3') }}"></script>
    <script src="{{ asset('public/js/receptions/consultation.js?v1.0.4') }}"></script>
    <script src="{{ asset('public/js/results/master.js?v1.0.3') }}"></script>
    <script src="{{ asset('public/js/results/medsWatch.js?v1.0.2') }}"></script>
    <script src="{{ asset('public/js/results/ultrasound.js?v1.0.9') }}"></script>
    <script src="{{ asset('public/js/results/radiologyQuickView.js?v1.0.2') }}"></script>
    <script src="{{ asset('public/js/ancillary/charging.js?v1.0.4') }}"></script>
    <script src="{{ asset('public/js/nurse/pedia/form_records.js?v1.0.2') }}"></script>
    <script src="{{ asset('public/js/receptions/queuercode.js?v1.0.1') }}"></script>
    <script src="{{ asset('public/js/doctors/filemanager.js?v1.0.0') }}"></script>
    <script src="{{ asset('public/js/doctors/preview.js?v1.0.0') }}"></script>

    @if($status == 'P' || $status == 'S' || $status == 'C' || $status == 'F' || $status == 'H' || $status == 'T')
        <script src="{{ asset('public/js/receptions/loadReceptions2.js?v1.0.3') }}"></script>
    @else
        <script src="{{ asset('public/js/receptions/loadReceptions.js?v1.0.3') }}"></script>
    @endif

    <script src="{{ asset('public/js/receptions/patientinfo.js?v1.0.1') }}"></script>

    @include('receptions.message.notify')

@stop


@endcomponent