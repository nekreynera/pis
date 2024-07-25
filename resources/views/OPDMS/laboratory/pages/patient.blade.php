@component('OPDMS.partials.header')


@slot('title')
    PIS | LABORATORY
@endslot


@section('pagestyle')
    <link href="{{ asset('public/OPDMS/css/patients/main.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/OPDMS/css/laboratory/main.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/OPDMS/css/laboratory/patient/action.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/OPDMS/css/patients/medical_records.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/OPDMS/css/laboratory/patient/new.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/OPDMS/css/laboratory/patient/logs.css') }}" rel="stylesheet" />

    <!-- for transaction modal -->
    <link href="{{ asset('public/OPDMS/css/laboratory/laboratory/sub.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/OPDMS/css/laboratory/laboratory/infolist.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/OPDMS/css/patients/patient_information.css') }}" rel="stylesheet" />
    <!-- <link href="{{ asset('public/OPDMS/css/patients/print_patient.css') }}" rel="stylesheet" /> -->
    
@endsection


@section('navigation')
    @include('OPDMS.partials.boilerplate.navigation')
@endsection


@section('dashboard')
    @component('OPDMS.partials.boilerplate.dashboard')
    @endcomponent
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" id="main-page">

        @include('OPDMS.partials.boilerplate.header',
        ['header' => 'Patients List', 'sub' => 'All queued patients will be shown here.'])

        <!-- Main content -->
        <section class="content">

            <div class="box">
                <div class="box-header with-border">
                  <div class="row action-div">
                    @include('OPDMS.laboratory.action.patient')
                  </div>
                </div>
                <div class="box-body">
                    @include('OPDMS.partials.loader')
                    @php 
                        $pending=0;
                        $done=0;
                        $removed=0;
                    @endphp
                    @foreach($patients as $list)
                        @if($list->status == 'P')
                            @php $pending+=1 @endphp
                        @endif
                        @if($list->status == 'F')
                            @php $done+=1 @endphp
                        @endif
                        @if($list->status == 'R')
                            @php $removed+=1 @endphp
                        @endif
                    @endforeach
                    <div class="text-right queing-status-button">
                        <button class="btn btn-warning btn-flat btn-xs" id="selected" data="P"><small class="label bg-black" id="pending-badge">{{ $pending }}</small>&nbsp; Pending</button>
                        <button class="btn btn-info btn-flat btn-xs" data="F"><small class="label bg-black" id="done-badge">{{ $done }}</small>&nbsp; Done</button>
                        <button class="btn btn-danger btn-flat btn-xs" data="R"><small class="label bg-black" id="removed-badge">{{ $removed }}</small>&nbsp; Removed</button>
                        <button class="btn btn-default btn-flat btn-xs" data="ALL"><small class="label bg-black" id="all-badge">{{ count($patients) }}</small>&nbsp; All</button>
                    </div>
                    <div class="table-responsive" style="max-height: 350px;">
                        <table class="table table-striped table-hover" id="patient-table">
                            <thead>
                                <tr class="bg-gray">
                                    <th></th>
                                    <th><span class="fa fa-user-o"></span></th>
                                    <th>ID No</th>
                                    <th>Patient Name</th>
                                    <th>Age</th>
                                    <th>Gender</th>
                                    <th>Status</th>
                                    <th>Datetime Queued</th>
                                </tr>
                            </thead>
                            <tbody class="queued-patient-tbody">
                                @if(count($patients) > 0)
                                    <!-- @foreach($patients as $patient)

                                        <tr data-id="{{ $patient->id }}">
                                            <td><span class="fa fa-caret-right"></span></td>
                                            <td class="text-center"><span class="fa fa-user-o"></span></td>
                                            <td class="text-center">{{ $patient->hospital_no }}</td>
                                            <td>{{ $patient->last_name.', '.$patient->first_name.' '.substr($patient->middle_name, 0, 1).'.' }}</td>
                                            <td class="text-center @if(App\Patient::age($patient->birthday) > 59) text-red text-bold @endif">{{ App\Patient::age($patient->birthday) }}</td>
                                            <td class="text-center">{{ ($patient->sex == 'M')?'Male':'Female' }}</td>
                                            <?php 
                                            $color = 'bg-yellow';
                                            $status = 'Pending';
                                            if($patient->status == 'F'):
                                            $status = 'Done';
                                            $color = 'bg-aqua';
                                            elseif($patient->status == 'R'):
                                            $status = 'Removed';
                                            $color = 'bg-red';
                                            endif
                                            ?>


                                            <td class="text-center"><span class="label {{$color}} active">{{ $status }}</span></td>
                                            <td class="text-center">{{ Carbon::parse($patient->created_at)->format('m/d/Y h:i a') }}</td>
                                        </tr>
                                    @endforeach -->
                                @else
                                    <tr>
                                        <td height></td>
                                        <td></td>
                                        <td colspan="6" class="text-center"><span class="fa fa-warning"></span> EMPTY DATA</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                </div>

                <div class="box-footer">
                    <small>
                        <em class="text-muted">
                            @if (count($request->post()) > 0)
                              Showing <b> {{ count($patients) }} search result(s).</b> 
                            @else  
                              Showing <b> {{ count($patients) }} </b>
                            @endif
                            of {{ count(App\LaboratoryQueues::whereDate('created_at', '=', Carbon::today())->get()) }} queued patient(s) today.
                        </em>
                    </small>
                </div>
            </div>

        </section>
        <!-- /.content -->
    </div>
    @include('OPDMS.laboratory.modals.patient.scan')
    @include('OPDMS.laboratory.modals.patient.new')
    @include('OPDMS.laboratory.modals.patient.undone')
    @include('OPDMS.laboratory.modals.patient.patients')
    @include('OPDMS.laboratory.modals.patient.request_form')
    @include('OPDMS.laboratory.modals.patient.doctor')
    @include('OPDMS.laboratory.modals.patient.new_doctor')
    @include('OPDMS.laboratory.modals.alert')
    @include('OPDMS.patients.modals.patient_information')
    @include('OPDMS.patients.modals.medical_records')

    <!-- /.content-wrapper -->
@endsection



{{--@section('footer')
    @include('OPDMS.partials.boilerplate.footer')
@endsection--}}

@section('aside')
    @include('OPDMS.partials.boilerplate.aside')
@endsection


@section('pluginscript')
  
@endsection
<?php 
    // 
 ?>

@section('pagescript')
    @if(!$alert)
    <script>
            $("#alertModal").modal({backdrop: "static"});
    </script>
    @else
        <script>
            $("#alertModal").modal('hide');
        </script>
    @endif
    <script>
        var dateToday = '{{ Carbon::today()->format("m/d/Y") }}';
    </script>
    <script src="{{ asset('public/OPDMS/js/laboratory/main.js?v2.0.1') }}"></script>
    <script src="{{ asset('public/OPDMS/js/laboratory/patient/main.js?v2.0.1') }}"></script>
    <script src="{{ asset('public/OPDMS/js/laboratory/patient/action.js') }}"></script>
    <script src="{{ asset('public/OPDMS/js/laboratory/patient/scan.js') }}"></script>
    <script src="{{ asset('public/OPDMS/js/laboratory/patient/transaction.js?v1.0.7') }}"></script>
    <script src="{{ asset('public/OPDMS/js/laboratory/patient/list.js') }}"></script>
    <script src="{{ asset('public/OPDMS/js/laboratory/patient/sub.js') }}"></script>
    <script src="{{ asset('public/OPDMS/js/patients/table.js?v2.0.1') }}"></script>
    <script src="{{ asset('public/OPDMS/js/laboratory/patient/table.js?v2.0.1') }}"></script>
    <script src="{{ asset('public/OPDMS/js/laboratory/patient/view.js') }}"></script>
    <script src="{{ asset('public/OPDMS/js/laboratory/patient/search.js') }}"></script>
    <script src="{{ asset('public/OPDMS/js/laboratory/patient/logs.js') }}"></script>
    <script src="{{ asset('public/OPDMS/js/patients/patient_information.js') }}"></script>
    <script src="{{ asset('public/OPDMS/js/patients/medical_record.js') }}"></script>

   
    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2();

            $(window).load(function(){
                $('body').attr('oncontextmenu', 'return false');
            })

        });
        var patient_queued = '{{ json_encode($patients) }}';
        var json_patient_queued = JSON.parse(patient_queued.replace(/&quot;/g, '"'));
        appendqueuedpatientstotable(json_patient_queued, status = 'ALL');

    </script>

@endsection


@endcomponent