@component('partials/header')

    @slot('title')
        PIS | Doctors Consultation Status
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/plugins/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/receptions/designation.css') }}" rel="stylesheet" />
@stop


@section('header')
    @include('receptions.navigation')
@stop



@section('content')

    <div class="container-fluid">
        <div class="container">
            <h2 class="text-center">DOCTORS CONSULTATION STATUS</h2>
            <br>
            <div class="table-responsive">
                <table class="table" id="doctors">
                    <thead>
                        <tr>
                            <th>DOCTOR</th>
                            <th>SERVING PATIENT</th>
                            <th>PENDING PATIENTS</th>
                            <th>FINISHED PATIENTS</th>
                            <th>PAUSED PATIENTS</th>
                            <th>CANCELED PATIENTS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($doctors))
                            @foreach($doctors as $doctor)
                                <tr>
                                    <td>
                                        @if(App\User::isActive($doctor->id))
                                            {!! "<div class='online'></div> <span class='text-default'>Dr. $doctor->name</span>" !!}
                                        @else
                                            {!! "<div class='offline'></div> <span class='text-default'>Dr. $doctor->name</span>" !!}
                                        @endif
                                    </td>
                                    <td>
                                        <a href='{{ url("status/$doctor->id/S") }}' class="btn {{ ($doctor->serving)? 'btn-success' : 'btn-default' }}">
                                            Serving {{ ($doctor->serving)? $doctor->serving : '0' }}
                                        </a>
                                    </td>
                                    <td>
                                        <a href='{{ url("status/$doctor->id/P") }}' class="btn {{ ($doctor->pending)? 'btn-warning' : 'btn-default' }}">
                                            Pending {{ $doctor->pending or 0 }}
                                        </a>
                                    </td>
                                    <td>
                                        <a href='{{ url("status/$doctor->id/F") }}' class="btn {{ ($doctor->finished)? 'btn-info' : 'btn-default' }}">
                                            Finished {{ $doctor->finished or 0 }}
                                        </a>
                                    </td>
                                    <td>
                                        <a href='{{ url("status/$doctor->id/H") }}' class="btn {{ ($doctor->paused)? 'btn-warning' : 'btn-default' }}">
                                            Paused {{ ($doctor->paused)? $doctor->paused : '0' }}
                                        </a>
                                    </td>
                                    <td>
                                        <a href='{{ url("status/$doctor->id/C") }}' class="btn {{ ($doctor->cancel)? 'btn-danger' : 'btn-default' }}">
                                            Canceled {{ ($doctor->cancel)? $doctor->cancel : '0' }}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
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
    <script>
        $(document).ready(function() {
            $('#doctors').dataTable();
        });
    </script>
@stop


@endcomponent
