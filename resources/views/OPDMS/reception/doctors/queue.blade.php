@component('OPDMS.partials.header')


    @slot('title')
        Doctors Queue
    @endslot


@section('pagestyle')
    <link rel="stylesheet" href="{{ asset('public/OPDMS/css/reception/patient_queue.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/OPDMS/css/partials/patient_information.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/OPDMS/css/reception/patient_assignation.css') }}" />
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
            ['header' => 'Doctors Queue', 'sub' => 'Showing the queuing status of doctors.'])

            <!-- Main content -->
                <section class="content container-fluid">

                    <div class="box box-default bg-danger">



                        {{-- modals goes here --}}

                        @include('OPDMS.partials.modals.patient_information') {{-- patient information --}}
                        @include('OPDMS.reception.modals.patient_assignation') {{-- patient assignation --}}
                        @include('OPDMS.reception.modals.patient_re_assignation') {{-- patient re_assignation --}}


                        <div class="box-body">



                            {{-- patient queued goes here --}}
                            <div class="table-responsive selectable_table">
                                <table class="table table-bordered table-striped table-hover" id="dataTable2">
                                    <thead>
                                    <tr>
                                        <th>No#</th>
                                        <th>Connectivity</th>
                                        <th>Doctors Name</th>
                                        <th>Pending</th>
                                        <th>Paused</th>
                                        <th>NAWC</th>
                                        <th>Serving</th>
                                        <th>Finished</th>
                                        <th>All</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($doctors))
                                        @php $count_doctors = 1; @endphp
                                        @foreach($doctors as $doctor)
                                            @if(Cache::has('active_'.$doctor->id) || $doctor->pending || $doctor->paused
                                            || $doctor->nawc || $doctor->serving || $doctor->finished )
                                                <tr>
                                                    <td>{{ $count_doctors++ }}</td>
                                                    <td>
                                                        @if(Cache::has('active_'.$doctor->id))
                                                            <i class="fa fa-circle text-green"></i>
                                                            Online
                                                        @else
                                                            <i class="fa fa-circle text-muted"></i>
                                                            Offline
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{-- patient name --}}
                                                        <strong class="text-primary text-uppercase">
                                                            {{ $doctor->last_name.', '.$doctor->first_name.' '.
                                                            $doctor->middle_name }}
                                                        </strong>
                                                    </td>
                                                    <td>
                                                        <a href="{{ url('status_filtering/'.$doctor->id.'/P') }}" class="btn btn-circle
                                                            @if($doctor->pending) bg-orange @else btn-default disabled @endif"
                                                           onclick="full_window_loader()">
                                                            {{ $doctor->pending or 0 }}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="{{ url('status_filtering/'.$doctor->id.'/H') }}" class="btn btn-circle
                                                             @if($doctor->paused) bg-brown @else btn-default disabled @endif"
                                                           onclick="full_window_loader()">
                                                            {{ $doctor->paused or 0 }}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="{{ url('status_filtering/'.$doctor->id.'/C') }}" class="btn btn-circle
                                                            @if($doctor->nawc) bg-red @else btn-default disabled @endif"
                                                           onclick="full_window_loader()">
                                                            {{ $doctor->nawc or 0 }}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="{{ url('status_filtering/'.$doctor->id.'/S') }}" class="btn btn-circle
                                                            @if($doctor->serving) bg-green @else btn-default disabled @endif"
                                                           onclick="full_window_loader()">
                                                            {{ $doctor->serving or 0 }}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="{{ url('status_filtering/'.$doctor->id.'/F') }}" class="btn btn-circle
                                                            @if($doctor->finished) bg-blue @else btn-default disabled @endif"
                                                           onclick="full_window_loader()">
                                                            {{ $doctor->finished or 0}}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <?php $count_all = $doctor->pending + $doctor->paused + $doctor->nawc +
                                                            $doctor->serving + $doctor->finished; ?>
                                                        <a href="{{ url('status_filtering/'.$doctor->id.'/A') }}" class="btn btn-circle
                                                            @if($count_all) bg-black @else btn-default disabled @endif"
                                                           onclick="full_window_loader()">
                                                            {{ $count_all }}
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>

                        </div>

                        <div class="box-footer">
                            <small>
                                <em class="text-muted">
                                    Showing the today`s queue status of online and offline doctors.
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




@section('pagescript')
    <script src="{{ asset('public/OPDMS/vue/reception/queue.js') }}"></script>

    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2();
        });
    </script>
@endsection


@endcomponent