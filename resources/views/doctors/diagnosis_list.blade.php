@component('partials/header')

    @slot('title')
        PIS | Daignosis List
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/css/doctors/reset.css') }}" rel="stylesheet" />
    @if(Auth::user()->theme == 2)
        <link href="{{ asset('public/css/doctors/darkstyle.css') }}" rel="stylesheet" />
    @else
        <link href="{{ asset('public/css/doctors/greenstyle.css') }}" rel="stylesheet" />
    @endif
    <link href="{{ asset('public/plugins/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/doctors/patientinfo.css') }}" rel="stylesheet" />
@endsection



@section('header')
    @include('doctors.navigation')
@stop



@section('content')
    @component('doctors.dashboard')
@section('main-content')


    <div class="content-wrapper">
        <br>
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-left">Diagnosis List</h2>
                    <br>
                    <br>
                </div>

                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table consultationList">
                            <thead>
                            <tr>
                                <th>PATIENT NAME</th>
                                <th>CLINIC</th>
                                <th>CONSULTED BY</th>
                                <th>DIAGNOSIS DATE</th>
                                <th>VIEW</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($diagnosis) > 0)
                                @foreach($diagnosis as $diagnosed)
                                    <tr>
                                        <td>{{ $diagnosed->name }}</td>
                                        <td>{{ $diagnosed->clinic }}</td>
                                        <td>{{ ($diagnosed->doctor)? "DR. $diagnosed->doctor" : 'N/A' }}</td>
                                        <td>{{ Carbon::parse($diagnosed->created_at)->toDayDateTimeString() }}</td>
                                        <td>
                                            <a href="{{ url('diagnosis/'.$diagnosed->id) }}" class="btn btn-info btn-circle"
                                               data-placement="right" data-toggle="tooltip" title="Click to view">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center">
                                        <strong class="text-danger">THERE IS CURRENTLY, NO DIAGNOSIS FOR THIS PATIENT!</strong>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
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
    <script src="{{ asset('public/plugins/js/form.js') }}"></script>
    <script src="{{ asset('public/plugins/js/modernizr.js') }}"></script>
    <script src="{{ asset('public/plugins/js/jquery.menu-aim.js') }}"></script>
    <script src="{{ asset('public/js/doctors/main.js') }}"></script>
@stop


@endcomponent
