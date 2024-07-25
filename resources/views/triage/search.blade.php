@component('partials/header')

    @slot('title')
        PIS | Unprinted Cards
    @endslot

    @section('pagestyle')
        <link href="{{ asset('public/plugins/css/jquery-ui.css') }}" rel="stylesheet" />
        <link href="{{ asset('public/plugins/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('public/css/patients/searchpatient.css') }}" />
    @stop


    @section('header')
        @include('triage.navigation')
    @stop



    @section('content')
        <div class="container">
            <br/>
            <div class="row searchpatient">
                <form action="{{ url('triagesearch') }}" method="post">
                    {{ csrf_field() }}
                    <div class="col-md-8 col-md-offset-2">
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

            <br/>
                <h3 class="text-center">Search Results</h3>
            <br/>

            @include('message.msg')

            <div class="table-responsive">
                <table class="table table-striped table-hover" id="unprintedTable">
                    <thead>
                        <tr>
                            <th>HOSPITAL#</th>
                            <th>BARCODE</th>
                            <th>FULLNAME</th>
                            <th>ADDRESS</th>
                            <th>BIRTHDAY</th>
                            <th>AGE</th>
                            <th>SEX</th>
                            <th>STATUS</th>
                            <th>HISTORY</th>
                            <th>REG.DATE</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(isset($patients))
                        @foreach($patients as $patient)
                            <tr>
                                <td>{{ $patient->hospital_no }}</td>
                                <td>{{ $patient->barcode }}</td>
                                <td>{{ $patient->last_name.' '.$patient->first_name.' '.$patient->middle_name }}</td>
                                <td>{{ $patient->address }}</td>
                                <td>{{ Carbon::parse($patient->birthday)->toFormattedDateString() }}</td>
                                <td>
                                    {{ App\Patient::age($patient->birthday) }}
                                </td>
                                <td>{{ $patient->sex }}</td>
                                <td>{{ $patient->civil_status }}</td>
                                <td>
                                    <a href="{{ url('triage_history/'.$patient->id) }}" class="btn btn-info btn-circle">
                                        <i class="fa fa-history"></i>
                                    </a>
                                </td>
                                <td>{{ Carbon::parse($patient->created_at)->toFormattedDateString() }}</td>
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
