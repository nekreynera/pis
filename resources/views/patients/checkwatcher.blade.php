@component('partials/header')

    @slot('title')
        PIS | Admitted Patients
    @endslot

    @section('pagestyle')
        <link href="{{ asset('public/plugins/css/jquery-ui.css') }}" rel="stylesheet" />
        <link href="{{ asset('public/plugins/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('public/css/patients/searchpatient.css') }}" />
        <link rel="stylesheet" href="{{ asset('public/css/patients/admitted.css') }}" />
    @stop


    @section('header')
        @include('patients/navigation')
    @stop



    @section('content')
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                <h3 class="text-left"><small>PLEASE CHECK IF THE PERSON YOU WANT TO REGISTER IS ALREADY ON THE LIST</small></h3>
                </div>
                <div class="col-md-4">
                    <br>
                    <form class="text-right" action="{{ url('ignorepatients') }}" method="post">
                         {{ csrf_field() }}
                        <input type="hidden" name="last_name" value="{{ $request->last_name }}">
                        <input type="hidden" name="first_name" value="{{ $request->first_name }}">
                        <button type="submit" class="btn btn-success btn-sm"><span class="fa fa-user-times"></span> Ignore All</button>
                        <a href="{{ url('admittedpatient') }}" type="submit" class="btn btn-success btn-sm"><span class="fa fa-mail-reply"></span> Cancel Registration</a>
                    </form>
                </div>
            </div>
            <br>
            <div class="table-responsive checkpatient">
                <table class="table table-striped" id="watchertable">
                    <thead>
                        <tr>
                            <th hidden></th>
                            <th>Hospital No</th>
                            <th>Last Name</th>
                            <th>First Name</th>
                            <th>Middle Name</th>
                            <th>Birthday</th>
                            <th>Age</th>
                            <th>Sex</th>
                            <th>Address</th>
                            <th>REGISTERED <br>DATETIME</th>
                            <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach($patient as $list)
                        <tr>
                            <td hidden></td>
                            <td class="bg-info text-center"><b>{{ $list->hospital_no }}</b></td>
                            <td>{{ $list->last_name }}</td>
                            <td>{{ $list->first_name }}</td>
                            <td>{{ $list->middle_name }}</td>
                            <td width="100">{{ Carbon::parse($list->birthday)->format('M d, Y') }}</td>
                             @php
                              $agePatient = App\Patient::age($list->birthday)
                            @endphp
                            <td align="center">{{ $agePatient }}</td>
                            <td>{{ $list->sex }}</td>
                            <td>{{ $list->address }}</td>
                            @php
                                $inpatient = App\Inpatient::checkInpatient($list->id);
                            @endphp
                            <td align="center">
                                @if($inpatient)
                                IN-PATIENT <br>
                                {{ Carbon::parse($inpatient->updated_at)->format('M d, Y') }}
                                    <br>
                                {{ Carbon::parse($inpatient->updated_at)->format('h:i a') }}
                                @else
                                OUT-PATIENT <br>
                                {{ Carbon::parse($list->addate)->format('M d, Y') }}
                                    <br>
                                {{ Carbon::parse($list->addate)->format('h:i a') }}
                                @endif
                            </td>
                            <td align="center">
                                <a href="{{ url('selectwatcher') }}/{{$request->ptid}}/{{ $list->id }}" class="btn btn-success btn-sm"><span class="fa fa-arrow-right"></span> Select</a>
                            </td>
                                
                        </tr>
                        @endforeach
                    </tbody>
                    
                </table>
            </div>
           
        </div>
        
    @endsection




    @section('pagescript')
        @include('message.toaster')
        <script src="{{ asset('public/plugins/js/jquery-ui.min.js') }}"></script>
        <script src="{{ asset('public/plugins/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('public/plugins/js/dataTables.bootstrap.min.js') }}"></script>
        <script src="{{ asset('public/js/patients/unprinted.js') }}"></script>
        <script src="{{ asset('public/js/patients/admitted.js') }}"></script>
    @stop


@endcomponent
{{-- <td>
    @if($list->status)
        @if($list->status == 'A')
        <a href="{{ url('dischargedpatient') }}/{{$list->inid}}" class="btn btn-success btn-sm"><span class="fa fa-user-plus"></span> Discharge Patient</a>
        @else
        <a href="{{ url('admitpatient') }}/{{$list->id}}" class="btn btn-success btn-sm"><span class="fa fa-user-times"></span> Admit Patient</a>
        @endif
    @else
        <a href="{{ url('admitpatient') }}/{{$list->id}}" class="btn btn-success btn-sm"><span class="fa fa-user-times"></span> Admit Patient</a>
    @endif
</td> --}}
