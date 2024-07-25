@component('partials/header')

    @slot('title')
        PIS | Unprinted Cards
    @endslot

    @section('pagestyle')
         <link href="{{ asset('public/plugins/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />
         <link rel="stylesheet" href="{{ asset('public/css/patients/unprinted.css') }}" />
    @stop



    @section('header')
        @include('patients/navigation')
    @stop



    @section('content')
        <div class="container">
            <h3 class="text-center">UNPRINTED CARDS</h3>
            <div class="table-responsive" id="unprintedTableWrapper">
                <table class="table table-hover" id="unprintedTable">
                    <thead>
                        <tr>
                            <th hidden>#</th>
                            <th>HOSPITAL#</th>
                            <th>BARCODE</th>
                            <th>FULLNAME</th>
                            <th>ADDRESS</th>
                            <th>BIRTHDAY</th>
                            <th>SEX</th>
                            <th>PAYMENT</th>
                            <th>REG.DATE</th>
                            <th>PRINT</th>
                            <th>EDIT</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($patients as $patient)
                            @php
                                $action = ($patient->cid != null && $patient->activated != null && $patient->activated != 'N')? 'onclick="printcard($(this))"' : 'disabled onclick="return false"';
                            @endphp
                            <tr>
                                <td hidden></td>
                                <td>{{ $patient->hospital_no }}</td>
                                <td>{{ $patient->barcode }}</td>
                                <td>{{ $patient->last_name.' '.$patient->first_name.' '.$patient->middle_name }}</td>
                                <td>{{ $patient->address }}</td>
                                <td>{{ Carbon::parse($patient->birthday)->toFormattedDateString() }}</td>
                                <td>{{ $patient->sex }}</td>
                                <td>{!! ($patient->activated != null)? '<span class="text-success">Paid</span>' : '<span class="text-danger">Unpaid</span>' !!}</td>
                                <td>{{ Carbon::parse($patient->created_at)->toFormattedDateString() }}</td>
                                <td>
                                    <a 
                                            href="{{ url('hospitalcard/'.$patient->id) }}"
                                      
                                        target="_blank" data-id="{{ $patient->id }}" class="btn btn-primary btn-circle printcard">
                                        <i class="fa fa-print"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ url('patients/'.$patient->id.'/edit') }}" class="btn btn-info btn-circle edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <br><br>
    @endsection




    @section('pagescript')
        @include('message.toaster')
        <script src="{{ asset('public/plugins/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('public/plugins/js/dataTables.bootstrap.min.js') }}"></script>
        <script src="{{ asset('public/js/patients/unprinted.js') }}"></script>
    @stop


@endcomponent
