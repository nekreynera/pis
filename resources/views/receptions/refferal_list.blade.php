@component('partials/header')

    @slot('title')
        PIS | Refferals List
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
                <h2 class="text-center">Refferal List</h2>
                <br>
                <div class="table-responsive">
                    <table class="table consultationList">
                        <thead>
                        <tr>
                            <th>PATIENT NAME</th>
                            <th>FROM CLINIC</th>
                            <th>REFFERED BY DOCTOR</th>
                            <th>REFFERED TO CLINIC</th>
                            <th>REFFERED TO DOCTOR</th>
                            <th>REASON</th>
                            <th>STATUS</th>
                            <th>REFFERED DATE</th>
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

@endsection



@section('footer')
@stop



@section('pagescript')
    @include('message.toaster')
@stop


@endcomponent
