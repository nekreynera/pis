@component('partials/header')

    @slot('title')
        PIS | Receptions List
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
                    <h2 class="text-center">Requisition List</h2>
                    <br><br>
                    <div class="table-responsive">
                        <table class="table consultationList">
                            <thead>
                            <tr>
                                <th>PATIENT NAME</th>
                                <th>CLINIC</th>
                                <th>PHARMACIST</th>
                                <th>REQUISITION DATE</th>
                                <th>VIEW</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($requisitions) > 0)
                                @foreach($requisitions as $requisition)
                                    <tr>
                                        <td>{{ $requisition->name }}</td>
                                        <td>{{ $requisition->clinic }}</td>
                                        <td>{{ ($requisition->doctor)? "$requisition->doctor" : 'N/A' }}</td>
                                        <td>{{ Carbon::parse($requisition->created_at)->toDayDateTimeString() }}</td>
                                        <td>
                                            <a href="{{ url('receptions_reqShow/'.$requisition->id) }}" class="btn btn-default"
                                               data-placement="right" data-toggle="tooltip" title="Click to view">
                                                <i class="fa fa-file-text-o text-danger"></i> <span class="text-danger">VIEW</span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center">
                                        <strong class="text-danger">THERE IS CURRENTLY, NO REQUISITION FOR THIS PATIENT!</strong>
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
