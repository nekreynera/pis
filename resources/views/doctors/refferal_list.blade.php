@component('partials/header')

    @slot('title')
        PIS | Refferal List
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
                    <h2 class="text-left">Refferal List</h2>
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
                                <th>FROM CLINIC</th>
                                <th>REFFERED BY DOCTOR</th>
                                <th>REFFERED TO CLINIC</th>
                                <th>REFFERED TO DOCTOR</th>
                                <th>REASON OF REFFERAL</th>
                                <th>STATUS</th>
                                <th>REFFERED DATE</th>
                                <th>EDIT</th>
                                <th>DELETE</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($refferals) > 0)
                                @foreach($refferals as $refferal)
                                    @php
                                        $action = ($refferal->users_id == Auth::user()->id && $refferal->status == 'P')? '' : 'disabled onclick="event.preventDefault()"';
                                        $activateEdit = ($refferal->users_id == Auth::user()->id && $refferal->status == 'P')? 'onclick="return confirm('."'Edit this refferal?'".')"' : '';
                                        $activateDelete = ($refferal->users_id == Auth::user()->id && $refferal->status == 'P')? 'onclick="return confirm('."'Delete this refferal?'".')"' : '';
                                    @endphp
                                    <tr>
                                        <td>{{ $refferal->name }}</td>
                                        <td>{{ $refferal->fromClinic }}</td>
                                        <td>{{ ($refferal->fromDoctor)? "DR. $refferal->fromDoctor" : 'N/A' }}</td>
                                        <td>{{ ($refferal->toClinic)? $refferal->toClinic : 'N/A' }}</td>
                                        <td>{!! ($refferal->toDoctor)? "DR. $refferal->toDoctor" : '<span class="text-danger">N/A</span>' !!}</td>
                                        <td>{!! ($refferal->reason)? $refferal->reason : '<span class="text-danger">N/A</span>' !!}</td>
                                        <td>{!! ($refferal->status == 'P')? '<span class="text-danger">Pending</span>' : '<span class="text-success">Finished</span>' !!}</td>
                                        <td>{{ Carbon::parse($refferal->created_at)->toDayDateTimeString() }}</td>
                                        <td>
                                            <a href="{{ url('refferal/'.$refferal->id.'/edit') }}" {!! $action !!} {!! $activateEdit !!} class="btn btn-info btn-circle"
                                               data-placement="top" data-toggle="tooltip" title="Click to edit" >
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ url('delete_refferal/'.$refferal->id) }}" {!! $action !!} {!! $activateDelete !!} class="btn btn-danger btn-circle"
                                               data-placement="top" data-toggle="tooltip" title="Click to delete" >
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="10" class="text-center">
                                        <strong class="text-danger">THERE IS CURRENTLY, NO REFFERALS FOR THIS PATIENT!</strong>
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
