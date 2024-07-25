@component('partials/header')

    @slot('title')
        PIS | Search Patients
    @endslot

    @section('pagestyle')
        <link href="{{ asset('public/plugins/css/jquery-ui.css') }}" rel="stylesheet" />
        <link href="{{ asset('public/plugins/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('public/css/patients/searchpatient.css') }}" />
    @stop


    @section('header')
        @include('patients/navigation')
    @stop



    @section('content')
        <div class="container">
            <br/>
            <div class="row searchpatient">
                <form action="{{ url('search') }}" method="post">
                    {{ csrf_field() }}
                    <div class="col-md-6">
                        <a href="{{ url('patients') }}" class="btn btn-success btn-sm"
                            data-toggle="tooltip"
                            title="Register new out-patient">
                            <span class="fa fa-user-plus"></span> ADD PATIENT</a>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-default dropdown-toggle" 
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Filter By <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a href="" class="name">Patient Name</a></li>
                                            <li><a href=""  class="birthday">Patient Birthday</a></li>
                                            <li><a href="" class="barcode">Patient Barcode</a></li>
                                            <li><a href="" class="hospital_no">Patient Hospital No.</a></li>
                                            <li><a href="" class="created_at">Date Registered</a></li>
                                        </ul>
                                    </div><!-- /btn-group -->
                                    <input type="text" name="name" id="searchInput" class="form-control" placeholder="Search For Patient Name..." autofocus />
                                    <span class="input-group-btn">
                                        <button class="btn btn-success" type="submit">
                                            <i class="fa fa-search"></i> Search
                                        </button>
                                    </span>
                                </div><!-- /input-group -->
                        </div>
                    </div>
                </form>
            </div>

            <br>
            @include('message.msg')

            <div class="table-responsive">
                <table class="table table-striped table-hover" id="unprintedTable">
                    <thead>
                        <tr>
                            <th hidden></th>
                            <th>HOSPITAL#</th>
                            <th>BARCODE</th>
                            <th>FULLNAME</th>
                            <th>ADDRESS</th>
                            <th>BIRTHDAY</th>
                            <th>AGE</th>
                            <th>SEX</th>
                            <th>REG.DATE</th>
                            <th>PRINTED</th>
                            <th>PAID</th>
                            <th>PRINT</th>
                            <th>EDIT</th>
                            <!-- <th>WATCHER</th> -->
                        </tr>
                    </thead>
                    <tbody>
                    @if(isset($patients))
                        @foreach($patients as $patient)
                           
                            <tr>
                                <td hidden></td>
                                <td align="center">{{ $patient->hospital_no }}</td>
                                <td align="center">{{ $patient->barcode }}</td>
                                <td>{{ $patient->last_name.' '.$patient->first_name.' '.$patient->middle_name }}</td>
                                <td>{{ $patient->address }}</td>
                                <td align="center">{{ Carbon::parse($patient->birthday)->toFormattedDateString() }}</td>
                                 @php
                                  $agePatient = App\Patient::age($patient->birthday)
                                @endphp
                                <td align="center">{{ $agePatient }}</td>
                                <td align="center">{{ $patient->sex }}</td>
                                <td align="center">{{ Carbon::parse($patient->created_at)->toFormattedDateString() }}</td>
                                <td>
                                    @if($patient->printed == 'Y')
                                    <span class="label label-success">Printed </span>
                                    @endif
                                </td>

                                <td>
                                    @if($patient->paid > 0)
                                    <span class="label label-success">Paid: &nbsp; {{ $patient->paid }} </span>
                                    @else
                                    <span class="label label-danger">Unpaid</span>
                                    @endif
                                </td>
                                <td align="center">
                                    <a 
                                            href="{{ url('hospitalcard/'.$patient->id) }}"
                                       target="_blank" data-id="{{ $patient->id }}" class="btn btn-primary btn-circle">
                                        <i class="fa fa-print"></i>
                                    </a>
                                </td>
                                <td align="center">
                                    <a href="{{ url('patients/'.$patient->id.'/edit') }}" class="btn btn-info btn-circle edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                </td>
                             
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>

        <br><br>
    @endsection




    @section('pagescript')
        @include('message.toaster')
        <script src="{{ asset('public/plugins/js/jquery-ui.min.js') }}"></script>
        <script src="{{ asset('public/plugins/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('public/plugins/js/dataTables.bootstrap.min.js') }}"></script>
        <script src="{{ asset('public/js/patients/unprinted.js') }}"></script>
    @stop


@endcomponent
