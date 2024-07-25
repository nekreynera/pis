@component('partials/header')

    @slot('title')
        PIS | History
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/plugins/css/jquery-ui.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/plugins/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('public/css/patients/searchpatient.css') }}" />
@stop


@section('header')
    @include('triage.navigation')
@stop



@section('content')
    <div class="container">
        <h2 class="text-center">Triage History</h2>
        @include('message.msg')

        <div class="table-responsive">
            <table class="table table-responsive">
                <table class="table">
                    <thead>
                        <tr style="background-color: #eee">
                            <th>PATIENT NAME</th>
                            <th>CLINIC</th>
                            <th>DOCTOR</th>
                            <th>STATUS</th>
                            <th>DATE/TIME</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($history) > 0)
                            @foreach($history as $historya)
                                @php
                                    if($historya->status == 'S')
                                        $status = '<span class="text-success">Serving</span>';
                                    elseif($historya->status == 'P')
                                        $status = '<span class="text-warning">Pending</span>';
                                    elseif($historya->status == 'F')
                                        $status = '<span class="text-primary">Finished</span>';
                                    elseif($historya->status == 'C')
                                        $status = '<span class="text-danger">Canceled</span>';
                                    else
                                        $status = '<span class="text-danger">N/A</span>';
                                @endphp
                                <tr>
                                    <td>{{ $historya->name }}</td>
                                    <td>{{ $historya->clinic }}</td>
                                    <td>{{ $historya->doctor }}</td>
                                    <td>{!! $status !!}</td>
                                    <td>{{ Carbon::parse($historya->created_at)->toDateString() }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center">
                                    <strong class="text-danger">NO RESULTS FOUND!</strong>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </table>
        </div>
    </div>

    <br><br>
@endsection




@section('pagescript')
    @include('message.toaster')
    <script src="{{ asset('public/plugins/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('public/plugins/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/plugins/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/js/patients/unprinted.js') }}"></script>
@stop


@endcomponent
