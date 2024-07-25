@component('partials/header')

    @slot('title')
        PIS | Patients
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/css/doctors/reset.css') }}" rel="stylesheet" />
    @if(Auth::user()->theme == 2)
        <link href="{{ asset('public/css/doctors/darkstyle.css') }}" rel="stylesheet" />
    @else
        <link href="{{ asset('public/css/doctors/greenstyle.css') }}" rel="stylesheet" />
    @endif
    <link href="{{ asset('public/plugins/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/doctors/patientlist.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/receptions/designation.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/requisition/medicines.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/receptions/status.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/partials/slider.css') }}" rel="stylesheet" />

    {{--<link href="{{ asset('public/css/consultation/viewer.css') }}" rel="stylesheet" />--}}
@endsection



@section('header')
    @include('doctors.navigation')
@stop



@section('content')
    @component('doctors.dashboard')
        @section('main-content')


        <div class="content-wrapper" style="padding: 50px 0px" id="contentPatientList">
            <br/>
            <div class="container-fluid" id="patientListWrapper">



               {{-- @include('doctors.consultation.viewer') --}}



                @include('doctors.medicalRecords')
                @include('doctors.ajaxConsultationList')
                @include('doctors.ajaxRequisitionList')
                @include('doctors.ajaxRefferals')
                @include('doctors.ajaxFollowup')
                @include('doctors.records.consultation')
                @include('doctors.requisition.medsWatch')
                @include('doctors.records.radiology')
                @include('partials.alert')
                @include('doctors.laboratory_result')



                @include('nurse.pedia.form_records')

                <div class="col-md-12 row">

                    <br>

                    @include('doctors.patients.status')



                    {{--@include('partials.consultationStatus')--}}

                    <br><br>

                    @if($patients && count($patients) > 0)
                    <div class="">
                        <table class="table" id="patientListTable">
                            <thead>
                            @include('doctors.patients.thead')
                            </thead>
                            <tbody>

                                @php
                                    $fin = 0;$can = 0;$pau = 0;$unassgned = 0;$pen = 0;$serv = 0;
                                @endphp
                                @foreach($patients as $patient)
                                    @php
                                        switch ($patient->status){
                                            case 'P':
                                                $status =  'pending';
                                                $statusColor = 'text-warning';
                                                $pen++;
                                                break;
                                            case 'S':
                                                $status =  'serving';
                                                $statusColor = 'text-success';
                                                $serv++;
                                                break;
                                            case 'F':
                                                $status =  'finished';
                                                $statusColor = 'text-primary';
                                                $fin++;
                                                break;
                                            case 'C':
                                                $status =  'nawc';
                                                $statusColor = 'text-danger';
                                                $can++;
                                                break;
                                            case 'H':
                                                $status =  'paused';
                                                $statusColor = 'text-warning';
                                                $pau++;
                                                break;
                                            default:
                                                $status =  'unassigned';
                                                $statusColor = 'text-danger';
                                                $unassgned++;
                                                break;
                                        }
                                        $refferal = App\Refferal::countAllRefferals($patient->pid);
                                        $followups = App\Followup::countAllFollowup($patient->pid);
                                        $totalNotification = $refferal + $followups;
                                    @endphp

                                    <tr>

                                        @include('doctors.patients.patientName')
                                        @include('doctors.patients.info')
                                        @include('doctors.patients.records')
                                        @include('doctors.patients.medical_certificate')
                                        @include('doctors.patients.action')
                                        @include('doctors.patients.event')
                                        @include('doctors.patients.intern')

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else

                        @include('doctors.patients.noResults')

                    @endif
                </div>


                {{--@include('partials.legend')--}}



            </div>
        </div> <!-- .content-wrapper -->




        @endsection
    @endcomponent
@endsection





@section('footer')
@stop



@section('pagescript')
    @include('message.toaster')
    @if(!$alert)
    <script>
            $("#alertModal").modal({backdrop: "static"});
    </script>
    @else
        @if($request->alert)
        <script>
            $("#alertModal").modal('hide');
        </script>
        @endif
    @endif
   
    <script src="{{ asset('public/plugins/js/form.js') }}"></script>
    <script src="{{ asset('public/plugins/js/modernizr.js') }}"></script>
    <script src="{{ asset('public/plugins/js/jquery.menu-aim.js') }}"></script>
    <script src="{{ asset('public/plugins/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('public/js/doctors/main.js?v1.0.1') }}"></script>

    <script src="{{ asset('public/js/nurse/pedia/form_records.js') }}"></script>

    <script src="{{ asset('public/js/doctors/ajaxRecords.js?v1.0.1') }}"></script>
    <script src="{{ asset('public/js/results/consultation.js?v1.0.1') }}"></script>
    <script src="{{ asset('public/js/results/master.js') }}"></script>
    <script src="{{ asset('public/js/results/medsWatch.js') }}"></script>
    <script src="{{ asset('public/js/results/ultrasound.js?v1.0.9') }}"></script>
    <script src="{{ asset('public/js/results/radiologyQuickView.js') }}"></script>
    <script src="{{ asset('public/js/partials/slider.js') }}"></script>



    {{--<script src="{{ asset('public/js/consultation/viewer.js') }}"></script>--}}

@stop


@endcomponent
