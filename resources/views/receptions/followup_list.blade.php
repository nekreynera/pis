@component('partials/header')

    @slot('title')
        PIS | Follow-Up List
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
                <h2 class="text-center">Follow-Up List</h2>
                <br>
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
                        </thead>
                        <tbody>
                        @if(count($followups) > 0)
                            @foreach($followups as $followup)
                                @php
                                    $action = ($followup->users_id == Auth::user()->id)? '' : 'disabled onclick="event.preventDefault()"';
                                    $activateEdit = ($followup->users_id == Auth::user()->id)? 'onclick="return confirm('."'Edit this follow-up?'".')"' : '';
                                    $activateDelete = ($followup->users_id == Auth::user()->id)? 'onclick="return confirm('."'Delete this follow-up?'".')"' : '';
                                @endphp
                                <tr>
                                    <td>{{ $followup->name }}</td>
                                    <td>{{ $followup->clinic }}</td>
                                    <td>{{ ($followup->fromDoctor)? "DR. $followup->fromDoctor" : 'N/A' }}</td>
                                    <td>{!! ($followup->toDoctor)? "DR. $followup->toDoctor" : '<span class="text-danger">N/A</span>' !!}</td>
                                    <td>{!! ($followup->reason)? $followup->reason : '<span class="text-danger">N/A</span>' !!}</td>
                                    <td>{!! ($followup->status == 'P')? '<span class="text-danger">Pending</span>' : '<span class="text-success">Finished</span>' !!}</td>
                                    <td>{{ Carbon::parse($followup->created_at)->toDayDateTimeString() }}</td>
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

@endsection



@section('footer')
@stop



@section('pagescript')
    @include('message.toaster')
@stop


@endcomponent
