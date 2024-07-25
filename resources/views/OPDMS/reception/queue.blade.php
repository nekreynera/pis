@component('OPDMS.partials.header')


@slot('title')
    Patients Queue
@endslot


@section('pagestyle')
    <link rel="stylesheet" href="{{ asset('public/OPDMS/css/reception/patient_queue.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/OPDMS/css/partials/patient_information.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/OPDMS/css/reception/patient_assignation.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/OPDMS/css/reception/notification.css') }}" />
@endsection



{{-- vue element start of div --}}
@section('vue-container-start')
    <div id="vue-queue">
@endsection





@section('navigation')
    @include('OPDMS.partials.boilerplate.navigation')
@endsection


@section('dashboard')
    @component('OPDMS.partials.boilerplate.dashboard')
        @section('search_form')
            @include('OPDMS.partials.boilerplate.search_form', ['redirector' => 'admin.search'])
        @endsection
    @endcomponent
@endsection



@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper patient_queue_wrapper">

        @include('OPDMS.partials.boilerplate.header',
        ['header' => 'Patients Queue', 'sub' => 'All patients that was been queued will be shown here.'])

        <!-- Main content -->
        <section class="content container-fluid">

            <div class="box box-default bg-danger">



                {{-- modals goes here --}}

                @include('OPDMS.partials.modals.patient_information') {{-- patient information --}}
                @include('OPDMS.reception.modals.patient_assignation') {{-- patient assignation --}}
                @include('OPDMS.reception.modals.patient_re_assignation') {{-- patient re_assignation --}}
                @include('OPDMS.partials.modals.medical_records') {{-- medical records --}}
                @include('OPDMS.partials.modals.consultation_show') {{-- consultation show records --}}
                @include('OPDMS.partials.modals.nurse_notes') {{-- nurse notes --}}




                @include('OPDMS.reception.queue.header_status'){{-- patient status goes here --}}
                @include('OPDMS.partials.modals.notifications'){{-- notification status goes here --}}

                <div class="box-body">


                    {{-- patient queued goes here --}}
                    <div class="table-responsive selectable_table" id="queue_table">
                        <table class="table table-bordered table-striped table-hover" id="dataTable2">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>No#</th>
                                    {{--<th>Notifications</th>--}}
                                    <th>Patient Name</th>
                                    <th>Age</th>
                                    <th>Assigned to Doctor</th>
                                    <th>Status</th>
                                    {{--<th>Charging</th>--}}
                                    <th>Time Queued</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!$queues->isEmpty())
                                    @php $loop_count = $queues->perPage() * ($queues->currentPage() - 1) + 1; @endphp
                                    @foreach($queues as $queue)
                                        <tr v-on:dblclick.prevent="patient_check($event, {{ $queue->pid }})">
                                            <td class="selected_icon">
                                                <i class="fa fa-circle-o fa-lg text-muted"></i>
                                            </td>
                                            <td>{{ $loop_count++ }}</td>


                                            {{-- notification for last consultation, referral, follow-up please uncomment
                                             if notification needed --}}

                                            {{--<td>
                                                @if($queue->ls_date)
                                                    <div class="text-green small">
                                                        Last consultation: {{ Carbon::parse($queue->ls_date)->toFormattedDateString() }} <br>
                                                        Consulted by:
                                                        <span class="text-uppercase">
                                                            DR. {{ $queue->ls_last_name.' '.$queue->ls_first_name }}
                                                        </span>
                                                    </div>
                                                @endif
                                                @if($queue->followupdate)
                                                    <div class="text-info small">
                                                        Scheduled today for follow-up <br>
                                                        Follow-up to:
                                                        <span class="text-uppercase">
                                                            DR. {{ $queue->ff_last_name.' '.$queue->ff_first_name }}
                                                        </span>
                                                    </div>
                                                @endif
                                                @if($queue->rpid)
                                                    <div class="text-orange small">
                                                        Referral from: {{ $queue->rf_clinic }} <br>
                                                        Referred by:
                                                        <span class="text-uppercase">
                                                            DR. {{ $queue->rb_last_name.' '.$queue->rb_first_name }}
                                                        </span> <br>
                                                        @if($queue->rt_last_name)
                                                            Referred to:
                                                            <span class="text-uppercase">
                                                                DR. {{ $queue->rt_last_name.' '.$queue->rt_first_name }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                @endif
                                                @if(!$queue->ls_date && !$queue->followupdate && !$queue->rpid)
                                                    <strong class="text-muted">None</strong>
                                                @endif
                                            </td>--}}



                                            <td>
                                                {{-- patient name --}}
                                                <strong class="text-primary text-uppercase">
                                                    {{ $queue->last_name.', '.$queue->first_name.' '.
                                                $queue->suffix.' '.$queue->middle_name }}
                                                </strong>
                                            </td>
                                            <td>
                                                {{-- patient age --}}
                                                @php $age = App\Patient::age($queue->birthday) @endphp
                                                @if($age >= 60)
                                                    <strong class="text-red">
                                                        {{ $age }}
                                                    </strong>
                                                @else
                                                    {{ $age }}
                                                @endif
                                            </td>
                                            <td>
                                                {{-- assigned to doctor --}}
                                                @if($queue->doctors_id)
                                                    <strong class="text-primary text-uppercase">
                                                        DR. {{ $queue->dr_last_name.', '.$queue->dr_first_name.' '.
                                                    $queue->dr_middle_name }}
                                                    </strong>
                                                @else
                                                    <strong class="text-muted">
                                                        None
                                                    </strong>
                                                @endif

                                            </td>


                                            {{-- queue status --}}
                                            @include('OPDMS.reception.queue.queue_status')


                                            {{-- Charging Notification please uncomment if charging needed --}}
                                            {{--<td>
                                                @if($queue->request_total)
                                                    <span class="label label-info">Request {{ $queue->request_total or 0 }}</span> <br>
                                                    <span class="label label-success">Paid {{ $queue->paid_total or 0 }}</span>
                                                @else
                                                    <strong class="text-muted">None</strong>
                                                @endif
                                            </td>--}}



                                            <td>Today {{ Carbon::parse($queue->queue_time)->format('h:i a') }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="7" class="text-center">
                                        {{ $queues->links() }}
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                </div>

                <div class="box-footer">
                    <small>
                        <em class="text-muted">
                            Showing todays queued patients.
                        </em>
                    </small>
                </div>

            </div>



        </section>
        <!-- /.content -->

    </div>
    <!-- /.content-wrapper -->
@endsection



@section('footer')
    @include('OPDMS.partials.boilerplate.footer')
@endsection



@section('aside')
    @include('OPDMS.partials.boilerplate.aside')
@endsection



{{-- vue element end of div --}}
@section('vue-container-end')
    </div>
@endsection


@section('pluginscript')
    <script src="{{ asset('public/plugins/js/tinymce/tinymce.min.js') }}"></script>
@endsection


@section('pagescript')
    <script src="{{ asset('public/OPDMS/vue/reception/queue.js') }}"></script>
    <script src="{{ asset('public/OPDMS/js/reception/notification.js') }}"></script>


    <script src="{{ asset('public/OPDMS/js/partials/texteditor.js') }}"></script>
    <script>
        $('#nurse_notes_modal').modal()
    </script>
    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2();
        });
    </script>
@endsection


@endcomponent