@component('partials/header')

    @slot('title')
        PIS | Overview
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/plugins/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/patients/register.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/doctors/patientlist.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/receptions/designation.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/receptions/status.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/requisition/medicines.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/ancillary/charging.css') }}" rel="stylesheet" />
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
        @include('ancillary.loader')
        @include('nurse.pedia.form_records')
        @include('partials.alert')



        @php
            $chrgingClinics = array(3,5,8,24,32,34,10,48,22,21,25,11,26,52,17);
            $noDoctorsClinic = array(10,48,22,21);
        @endphp

        <div class="">

            @if(!in_array(Auth::user()->clinic, $noDoctorsClinic))
                @include('receptions.overview.doctors')
            @endif

            <div class="{{ (!in_array(Auth::user()->clinic, $noDoctorsClinic))? 'col-md-8' : 'container' }} patientsWrapper">
                <br>

                @include('receptions.overview.title')

                    @if(in_array(Auth::user()->clinic, $noDoctorsClinic))
                        <div id="{{ $status }}">
                        <hr>
                        @include('receptions.ancillary.status')
                    @else
                        <div class="status" id="{{ $status }}">
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

        <!-- <div class="loader-field2">
          <div class="lds-css2 ng-scope2">
            <div class="lds-spinner3" style="100%;height:100%">
              <div></div>
              <div></div>
              <div></div>
              <div></div>
              <div></div>
              <div></div>
              <div></div>
              <div></div>
              <div></div>
              <div></div>
              <div></div>
              <div></div>
            </div>
          </div>
        </div> -->
    </div>

@endsection



@section('footer')
@stop



@section('pagescript')

    @include('message.toaster')
    @if(!$alert)
    <script>
            $("#alertModal").modal({backdrop: "static"});
    </script>
    @endif
    <script src="{{ asset('public/plugins/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/plugins/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/js/receptions/overview.js') }}"></script>
    <script src="{{ asset('public/js/doctors/ajaxRecords.js') }}"></script>
    <script src="{{ asset('public/js/receptions/consultation.js') }}"></script>
    <script src="{{ asset('public/js/results/master.js') }}"></script>
    <script src="{{ asset('public/js/results/medsWatch.js') }}"></script>
    <script src="{{ asset('public/js/results/ultrasound.js') }}"></script>
    <script src="{{ asset('public/js/results/radiologyQuickView.js') }}"></script>
    <script src="{{ asset('public/js/ancillary/charging.js') }}"></script>
    <script src="{{ asset('public/js/nurse/pedia/form_records.js') }}"></script>

    @if($status == 'P' || $status == 'S' || $status == 'C' || $status == 'F' || $status == 'H' || $status == 'T')
        <script src="{{ asset('public/js/receptions/loadReceptions2.js') }}"></script>
    @else
        <script src="{{ asset('public/js/receptions/loadReceptions.js') }}"></script>
    @endif

    @include('receptions.message.notify')

@stop


@endcomponent