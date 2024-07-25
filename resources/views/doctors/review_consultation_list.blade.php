@component('partials/header')

    @slot('title')
        PIS | Consultation List
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
                    <h3 class="text-left">REVIEW TODAYS CONSULTATION LIST</h3>
                </div>
                <br>
                <br>
                <br>

                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table consultationList">
                            <thead>
                            <tr>
                                <th>PATIENT NAME</th>
                                <th>CLINIC</th>
                                <th>CONSULTED BY</th>
                                <th>CONSULTATION DATE</th>
                                <th>EVENT</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($consultations) > 0)
                                @foreach($consultations as $consultation)
                                    <tr>
                                        <td>{{ $consultation->name }}</td>
                                        <td>{{ $consultation->clinic }}</td>
                                        <td>{{ ($consultation->doctor)? "DR. $consultation->doctor" : 'N/A' }}</td>
                                        <td>{{ Carbon::parse($consultation->created_at)->toDayDateTimeString() }}</td>
                                        <td>
                                            <a href="{{ url('medical/'.$consultation->id) }}" class="btn btn-default"
                                               data-placement="right" data-toggle="tooltip" title="Click to view">
                                                <i class="fa fa-file-text-o text-danger"></i> <span class="text-danger">View</span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center">
                                        <strong class="text-danger">THERE IS CURRENTLY, NO CONSULTATIONS FOR THIS PATIENT!</strong>
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
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip({container: "body"});
        });
    </script>
@stop


@endcomponent
