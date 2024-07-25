@component('partials/header')

    @slot('title')
        PIS | Dignosis List
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
                <h2 class="text-center">Diagnosis List</h2>
                <br><br>

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
                                        <a href="{{ url('rcptn_diagnosisShow/'.$diagnosed->id) }}" class="btn btn-info btn-circle"
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

@endsection



@section('footer')
@stop



@section('pagescript')
    @include('message.toaster')
@stop


@endcomponent
