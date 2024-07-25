@component('partials/header')

    @slot('title')
        PIS | Follow Up List
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
                    <h3 class="text-left">REVIEW TODAYS FOLLLOW-UP</h3>
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
                                <th>CLINIC / DEPARTMENT</th>
                                <th>CONSULTED BY DOCTOR</th>
                                <th>REFFERED TO DOCTOR</th>
                                <th>REASON OF FOLLOW UP</th>
                                <th>STATUS</th>
                                <th>FOLLOW UP DATE</th>
                                <th>EDIT</th>
                                <th>DELETE</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($followups) > 0)
                                @foreach($followups as $followup)
                                    <tr>
                                        <td>{{ $followup->name }}</td>
                                        <td>{{ $followup->clinic }}</td>
                                        <td>{{ ($followup->fromDoctor)? "DR. $followup->fromDoctor" : 'N/A' }}</td>
                                        <td>{!! ($followup->toDoctor)? "DR. $followup->toDoctor" : '<span class="text-danger">N/A</span>' !!}</td>
                                        <td>{!! ($followup->reason)? $followup->reason : '<span class="text-danger">N/A</span>' !!}</td>
                                        <td>{!! ($followup->status == 'P')? '<span class="text-danger">Pending</span>' : '<span class="text-success">Finished</span>' !!}</td>
                                        <td>{{ Carbon::parse($followup->created_at)->toDayDateTimeString() }}</td>
                                        <td>
                                            <a href="{{ url('followup/'.$followup->id.'/edit') }}" class="btn btn-info btn-circle">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ url('delete_followup/'.$followup->id) }}" class="btn btn-danger btn-circle" onclick="return confirm('Delete this followup?')">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="9" class="text-center">
                                        <strong class="text-danger">THERE IS CURRENTLY, NO FOLLOW UP FOR THIS PATIENT!</strong>
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
