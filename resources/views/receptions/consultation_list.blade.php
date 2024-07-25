@component('partials/header')

    @slot('title')
        PIS | Consultations List
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/css/doctors/patientinfo.css') }}" rel="stylesheet" />
@stop


@section('header')
    @include('receptions.navigation')
@stop



@section('content')

    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <h2 class="text-center">Consultations List</h2>
                <br>
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
                                        <a href="{{ url('rcptn_consultationDetails/'.$consultation->id) }}" class="btn btn-default"
                                           data-placement="right" data-toggle="tooltip" title="Click to view">
                                            <i class="fa fa-file-text-o text-danger"></i> <span class="text-danger">VIEW</span>
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


@endsection



@section('footer')
@stop



@section('pagescript')
    @include('message.toaster')
@stop


@endcomponent
