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
                        <h2 class="text-left">Consultation List</h2>
                            <br>
                            <br>
                    </div>

                    <div class="col-md-12">
                        <div class="">
                            <table class="table consultationList">
                                <thead>
                                    <tr>
                                        <th>PATIENT NAME</th>
                                        <th>CLINIC</th>
                                        <th>CONSULTED BY</th>
                                        <th>CONSULTATION DATE</th>
                                        <th>EVENT</th>
                                        {{--<th>TAG</th>--}}
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
                                                    <a href="{{ url('medical/'.$consultation->id) }}" class="btn btn-default text-danger"
                                                        data-placement="top" data-toggle="tooltip" title="Click to view this consultation">
                                                        <i class="fa fa-file-text-o text-danger"></i> <span class="text-danger">View</span>
                                                    </a>
                                                </td>
                                                {{--<td>
                                                    <div class="dropdown">
                                                        <a href="#" class="btn btn-danger btn-circle dropdown-toggle" data-toggle="dropdown" title="Tag a clinic">
                                                            <i class="fa fa-tag"></i>
                                                        </a>
                                                        <ul class="dropdown-menu dropdown-menu-right tagClinics" >
                                                            <li class="dropdown-header">-- Tag a clinic --</li>
                                                            <li>
                                                                @foreach($clinics as $clinic)
                                                                    <a href="{{ url('consultation_tag/'.$consultation->id.'/'.$clinic->id) }}"
                                                                       onclick="return confirm('Tag consultation to this clinic?')">
                                                                        {{ $clinic->name }}
                                                                    </a>
                                                                @endforeach
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>--}}
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
