@component('partials/header')

    @slot('title')
        PIS | Search
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/plugins/css/jquery-ui.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/plugins/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('public/css/patients/searchpatient.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/css/radiology/master.css') }}">
    <link rel="stylesheet" href="{{ asset('public/css/radiology/patients.css') }}">
@stop


@section('header')
    @include('radiology.navigation')
@stop



@section('content')
    <div class="container">

        @include('radiology.modal')

        @include('radiology.quickView')

        <br/>
        <div class="row searchpatient">
            <form action="{{ url('radiologySearch') }}" method="post">
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
        <h3 class="text-center">SEARCH RESULTS</h3>
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
                    <th>SEX</th>
                    <th>REG.DATE</th>
                    <th>VIEW</th>
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
                            <td>{{ $patient->sex }}</td>
                            <td>{{ Carbon::parse($patient->created_at)->toFormattedDateString() }}</td>
                            @if($patient->rid)
                                <td>
                                    <button class="btn btn-success btn-sm"
                                            data-toggle="modal" data-target="#radiologyModal"
                                            onclick="manageRequest({{ $patient->id }})">
                                        <i class="fa fa-file-text-o"></i> Request
                                    </button>
                                </td>
                            @else
                                <td>
                                    <label class="label label-danger">No Request</label>
                                </td>
                            @endif
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
    <script src="{{ asset('public/js/radiology/manage.js') }}"></script>
    <script src="{{ asset('public/js/radiology/quickView.js') }}"></script>
    <script src="{{ asset('public/js/results/master.js') }}"></script>
@stop


@endcomponent
