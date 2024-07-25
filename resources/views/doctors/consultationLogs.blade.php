@component('partials/header')

    @slot('title')
        PIS | Consultation Logs
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/plugins/css/jquery-ui.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/doctors/reset.css') }}" rel="stylesheet" />
    @if(Auth::user()->theme == 2)
        <link href="{{ asset('public/css/doctors/darkstyle.css') }}" rel="stylesheet" />
    @else
        <link href="{{ asset('public/css/doctors/greenstyle.css') }}" rel="stylesheet" />
    @endif
    <link href="{{ asset('public/plugins/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/receptions/designation.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/doctors/patientlist.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/receptions/status.css') }}" rel="stylesheet" />
    <style>
        #patientListWrapper{
            font-family: Raleway-Medium;
        }
    </style>
@endsection



@section('header')
    @include('doctors.navigation')
@stop



@section('content')
    @component('doctors.dashboard')
@section('main-content')


    <div class="content-wrapper" style="padding: 50px 0px">
        <br/>
        <div class="container-fluid" id="patientListWrapper">

            @include('doctors.medicalRecords')
            @include('doctors.ajaxConsultationList')
            @include('doctors.ajaxRequisitionList')
            @include('doctors.ajaxRefferals')
            @include('doctors.ajaxFollowup')
            @include('doctors.records.consultation')
            @include('doctors.requisition.medsWatch')


            

            <div class="col-md-12">



                @include('doctors.logs.searchLogs')


                @if($patients)
                @include('doctors.logs.status')

                <br>

                <div class="">
                    <table class="table" id="patientListTable">

                        @include('doctors.logs.thead')

                        <tbody>
                        
                            @php
                                $fin = 0;
                                $can = 0;
                                $pau = 0;
                                $unassgned = 0;
                                $pen = 0;
                                $serv = 0;
                            @endphp
                            @foreach($patients as $patient)
                                @php
                                    switch ($patient->status){
                                        case 'P':
                                            $status =  'pending';
                                            $statusColor = 'text-warning';
                                            break;
                                            $pen++;
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
                                            $status =  'canceled';
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

                                @include('doctors.logs.content')

                            @endforeach
                        
                        </tbody>

                    </table>

                </div>


                @else

                    @include('doctors.logs.noResult')

                @endif


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
    <script src="{{ asset('public/plugins/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('public/plugins/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/plugins/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/plugins/js/form.js') }}"></script>
    <script src="{{ asset('public/plugins/js/modernizr.js') }}"></script>
    <script src="{{ asset('public/plugins/js/jquery.menu-aim.js') }}"></script>
    <script src="{{ asset('public/plugins/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('public/js/doctors/main.js') }}"></script>
    <script src="{{ asset('public/js/doctors/ajaxRecords.js') }}"></script>
    <script src="{{ asset('public/js/results/consultation.js') }}"></script>
    <script src="{{ asset('public/js/results/master.js') }}"></script>
    <script src="{{ asset('public/js/results/medsWatch.js') }}"></script>
    <script src="{{ asset('public/js/results/ultrasound.js') }}"></script>
    <script>
        $( function() {
            $( ".datepicker" ).datepicker({
                dateFormat: 'yy-mm-dd'
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#patientListTable').DataTable();
        });
    </script>

@stop


@endcomponent
