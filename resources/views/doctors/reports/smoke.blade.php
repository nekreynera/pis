@component('partials/header')

    @slot('title')
        PIS | Smoke Cessation
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/css/doctors/reset.css') }}" rel="stylesheet" />
    @if(Auth::user()->theme == 2)
        <link href="{{ asset('public/css/doctors/darkstyle.css') }}" rel="stylesheet" />
    @else
        <link href="{{ asset('public/css/doctors/greenstyle.css') }}" rel="stylesheet" />
    @endif
    <link href="{{ asset('public/plugins/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/plugins/css/jquery-ui.css') }}" rel="stylesheet" />

@endsection



@section('header')
    @include('doctors.navigation')
@stop



@section('content')
    @component('doctors.dashboard')
        @section('main-content')


        <div class="content-wrapper" style="padding: 50px 0px">
            
            <div class="col-md-10 col-md-offset-1">
                <br/>
                <br/>



                <div class="text-right">
                    <form action='{{ url("smoke_store") }}' method="post" class="form-inline">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <strong class="text-success">{{ Carbon::parse($start)->diffForHumans() }}</strong>
                        </div>
                        <div class="form-group @if($errors->has('start')) has-error @endif">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" name="start" class="form-control datepicker" value="{{ $start or '' }}"
                                       placeholder="Enter Starting Date" required="">
                            </div>
                            @if ($errors->has('start'))
                                <span class="help-block">
                                    {{ $errors->first('start') }}
                                </span>
                            @endif
                        </div>
                        <div class="form-group @if($errors->has('end')) has-error @endif">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" name="end" class="form-control datepicker" value="{{ $end or '' }}"
                                       placeholder="Enter Ending Date" required="">
                            </div>
                            @if ($errors->has('end'))
                                <span class="help-block">
                                    {{ $errors->first('end') }}
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-flat">Submit</button>
                        </div>
                    </form>
                </div>


                <hr>


                <h4>Patients Consulted at Smoke Cessation Clinic 
                    @if (!is_null($smokes))
                        <span class="badge" style="background-color: #ff8080">
                            {{ count($smokes) }}
                        </span>
                    @else
                        <span class="badge" style="background-color: #ff8080">
                            {{ 0 }}
                        </span>
                    @endif
                </h4>
                <br>
                <h4 class="text-info">
                    <span class="text-muted">Consulted by:</span>
                    DR. {{ Auth::user()->last_name.', '.Auth::user()->first_name.' '.Auth::user()->suffix.' '.Auth::user()->middle_name }}
                </h4>

                <hr>

                <div class="table-responsive" style="font-size: 12px;">
                    <table class="table table-bordered table-striped" id="searchTable">
                        <thead>
                            <tr>
                                <th>No#</th>
                                <th>Patient</th>
                                <th>Date Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($start && $end)
                                @if(!$smokes->isEmpty())
                                    @foreach($smokes as $smoke)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $smoke->last_name.', '.$smoke->first_name.' '.$smoke->suffix.' '.$smoke->middle_name }}</td>
                                        <td>{{ Carbon::parse($smoke->created_at)->toFormattedDateString() }}</td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3" class="bg-danger text-center text-danger">
                                            No Results Found <i class="fa fa-warning"></i>
                                        </td>
                                    </tr>
                                @endif
                            @else
                                <tr>
                                    <td colspan="3" class="bg-danger text-center text-danger">
                                        Please select a date to retreive data <i class="fa fa-calendar"></i>
                                    </td>
                                </tr>
                            @endif
                            
                        </tbody>
                    </table>
                </div>
            </div>
            
            

        </div> <!-- .content-wrapper -->




        @endsection
    @endcomponent
@endsection





@section('footer')
@stop



@section('pagescript')
    @include('message.toaster')
    <script src="{{ asset('public/plugins/js/form.js') }}"></script>
    <script src="{{ asset('public/plugins/js/modernizr.js') }}"></script>
    <script src="{{ asset('public/plugins/js/jquery.menu-aim.js') }}"></script>
    <script src="{{ asset('public/plugins/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('public/js/doctors/main.js') }}"></script>


    <script src="{{ asset('public/plugins/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('public/AdminLTE/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/AdminLTE/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script>
        $(function () {
            $('#searchTable').DataTable();
        });
    </script>

    <script>
        $( ".datepicker" ).datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd'
            });
    </script>

@stop


@endcomponent
