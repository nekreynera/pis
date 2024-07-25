@component('partials/header')

    @slot('title')
        PIS | Patient Status
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/plugins/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/doctors/patientlist.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/receptions/designation.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/ancillary/charging.css') }}" rel="stylesheet" />
@stop


@section('header')
    @include('receptions.navigation')
@stop



@section('content')

    <div class="container-fluid">


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
        

        <?php
            $chrgingClinics = array(3,5,8,24,32,34,10,48,22,21,25);
            $noDoctorsClinic = array(10,48,22,21);
        ?>


        <div class="container">

            @include('doctors.medicalRecords')
            @include('doctors.ajaxConsultationList')
            @include('doctors.ajaxRequisitionList')
            @include('doctors.ajaxRefferals')
            @include('doctors.ajaxFollowup')
            @include('doctors.requisition.medsWatch')

            <h1 class="text-right">DR. {{ $doctor->first_name.' '.$doctor->middle_name[0].'. '.$doctor->last_name }}</h1>
            <hr>

            @if($status == 'P')
                <h3 class="text-left text-warning">PENDING PATIENTS... <i class="fa fa-feed"></i></h3>
            @elseif($status == 'C')
                <h3 class="text-left text-danger">NAWC PATIENTS <i class="fa fa-remove"></i></h3>
            @elseif($status == 'F')
                <h3 class="text-left text-primary">FINISHED PATIENTS <i class="fa fa-check"></i></h3>
            @elseif($status == 'H')
                <h3 class="text-left text-warning">PAUSED PATIENTS... <i class="fa fa-pause"></i></h3>
            @else
                <h3 class="text-left text-success">SERVING PATIENT <i class="fa fa-stethoscope"></i></h3>
            @endif

            <br>
            <div class="">
                <table class="table" id="pendingsTable">

                    @include('receptions.overview.thead')

                    <tbody class="loadPatients" charoff="{{ url()->current() }}">
                    @if(count($patients) > 0)
                        <?php
                            $fin = 0;
                            $can = 0;
                            $pau = 0;
                            $unassgned = 0;
                            $pen = 0;
                            $serv = 0;
                        ?>
                        @foreach($patients as $patient)
                            <?php
                            if($patient->status == 'P'){
                            $asgn = 'disabled onclick="return false"';
                            $reasgn = '';
                            $cancel = '';
                            $status = 'pending';
                            $pen++;
                            }
                            elseif($patient->status == 'S'){
                            $asgn = 'disabled onclick="return false"';
                            $reasgn = 'disabled onclick="return false"';
                            $cancel = 'disabled onclick="return false"';
                            $status = 'serving';
                            $serv++;
                            }
                            elseif($patient->status == 'F'){
                            $asgn = '';
                            $reasgn = 'disabled onclick="return false"';
                            $cancel = 'disabled onclick="return false"';
                            $status = 'finished';
                            $fin++;
                            }
                            elseif($patient->status == 'C'){
                            $asgn = '';
                            $reasgn = 'disabled onclick="return false"';
                            $cancel = 'disabled onclick="return false"';
                            $status = 'cancel';
                            $can++;
                            }
                            elseif($patient->status == 'H'){
                            $asgn = '';
                            $reasgn = 'disabled onclick="return false"';
                            $cancel = 'disabled onclick="return false"';
                            $status = 'paused';
                            $pau++;
                            }
                            else{
                            $asgn = '';
                            $reasgn = 'disabled onclick="return false"';
                            $cancel = '';
                            $status = 'unassigned';
                            $unassgned++;
                            }
                            ?>
                            <tr>

                                @include('receptions.overview.patient')

                                @include('receptions.overview.info')


                                <?php
                                    if($patient->ff + $patient->rf > 0){
                                        $assignedDoctor = App\Refferal::countAllNotifications($patient->id);
                                    }else{
                                        $assignedDoctor = array();
                                    }
                                ?>


                                @if(in_array(Auth::user()->clinic, $chrgingClinics))
                                    <?php
                                    $charging = App\Ancillaryrequist::otherCharging($patient->id);
                                    ?>
                                @endif


                                @include('receptions.overview.records')

                                @include('receptions.overview.assign')

                                @include('receptions.overview.reassign')


                                @include('receptions.overview.cancel')

                                @include('receptions.overview.charging')


                            </tr>
                        @endforeach
                    @else

                        @include('receptions.overview.noPatient')

                    @endif
                    </tbody>
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
    <script src="{{ asset('public/js/ancillary/charging.js') }}"></script>
    <script src="{{ asset('public/js/nurse/pedia/form_records.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#pendingsTable').dataTable();
        });
    </script>
@stop


@endcomponent
