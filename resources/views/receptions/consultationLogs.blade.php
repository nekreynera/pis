@component('partials/header')

    @slot('title')
        PIS | Logs
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/plugins/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/plugins/css/jquery-ui.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/receptions/status.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/doctors/patientlist.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/receptions/designation.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/requisition/medicines.css') }}" rel="stylesheet" />
@stop


@section('header')
    @include('receptions.navigation')
@stop



@section('content')
    <br>
    <div class="container-fluid" id="overviewWrapper">

        <div class="container">
            
            @include('doctors.medicalRecords')
            @include('doctors.ajaxConsultationList')
            @include('doctors.ajaxRequisitionList')
            @include('doctors.ajaxRefferals')
            @include('doctors.ajaxFollowup')
            @include('doctors.requisition.medsWatch')
            @include('doctors.records.radiology')

            @php
                $chrgingClinics = array(3,32,10,48,22,21,8);
                $noDoctorsClinic = array(10,48,22,21);
            @endphp

            <div class="">

                <div class="col-md-12 patientsWrapper" style="border-left: none">


                    @include('receptions.logs.logsForm')


                    <hr>



                    @if($patients)

                    <div class="patientsOverview">
                        <table class="table" id="patientsTable">


                            @include('receptions.logs.thead')

                            <tbody>

                                @php

                                    /*-- For assignation status --*/
                                        $fin = 0;
                                        $can = 0;
                                        $pau = 0;
                                        $unassgned = 0;
                                        $pen = 0;
                                        $serv = 0;

                                    /*-- For queue status --*/
                                        $queueCanceled = 0;
                                        $queuePending = 0;
                                        $queueDone = 0;
                                        $queueFinished = 0;
                                @endphp
                                @foreach($patients as $patient)
                                    @php
                                        $noDoctorsClinic = array(10,48,22,21);
                                        if (!in_array(Auth::user()->clinic, $noDoctorsClinic)){

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
                                            /*$asgn = 'disabled onclick="return false"';*/
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
                                        }else{
                                            switch ($patient->queue_status){
                                                case 'P':
                                                    $queuePending++;
                                                    $status = 'pending';
                                                    break;
                                                case 'C':
                                                    $queueCanceled++;
                                                    $status = 'cancel';
                                                    break;
                                                case 'F':
                                                    $queueDone++;
                                                    $status = 'finished';
                                                    break;
                                                default:
                                                    $queueFinished++;
                                                    $status = 'serving';
                                                    break;
                                            }
                                        }

                                    @endphp

                                    <tr>

                                        @include('receptions.logs.info')

                                        @php
                                            if($patient->ff + $patient->rf > 0){
                                                $assignedDoctor = App\Refferal::countAllNotifications($patient->id);
                                            }else{
                                                $assignedDoctor = array();
                                            }
                                        @endphp


                                        @if(in_array(Auth::user()->clinic, $noDoctorsClinic))
                                            @include('receptions.logs.done')
                                        @endif

                                        @include('receptions.logs.records')


                                    


                                        @if(in_array(Auth::user()->clinic, $chrgingClinics))
                                                @php
                                                    $charging = App\Ancillaryrequist::otherCharging($patient->id);
                                                @endphp

                                                @include('receptions.overview.charging')
                                        @endif



                                    </tr>
                                @endforeach
                            </tbody>

                            @if(count($patients) > 0)
                                <tfoot>
                                <div class="text-center">
                                    @include('receptions.logs.status')
                                </div>
                                <hr>
                                </tfoot>
                            @endif

                        </table>




                    </div>


                    @else

                        @include('receptions.logs.noResult')

                    @endif






                </div>
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
    <script src="{{ asset('public/plugins/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('public/js/receptions/overview.js') }}"></script>
    <script src="{{ asset('public/js/doctors/ajaxRecords.js') }}"></script>
    <script src="{{ asset('public/js/receptions/consultation.js') }}"></script>
    <script src="{{ asset('public/js/results/master.js') }}"></script>
    <script src="{{ asset('public/js/results/medsWatch.js') }}"></script>
    <script src="{{ asset('public/js/results/ultrasound.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#patientsTable').dataTable();
           
        });
    </script>
    <script>
        $( function() {
            $( ".datepicker" ).datepicker({
                dateFormat: 'yy-mm-dd'
            });
        });
    </script>

@stop



@endcomponent
