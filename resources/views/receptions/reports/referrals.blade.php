@component('partials/header')

@slot('title')
PIS | Referrals Report
@endslot

@section('pagestyle')
    <link href="{{ asset('public/plugins/css/jquery-ui.css') }}" rel="stylesheet" />
@stop



@section('header')
    @include('receptions.navigation')
@stop



@section('content')

    <div class="container-fluid">
        <div class="container">

            <div class="col-md-4">
                <h3><span class="text-muted">Refferals</span> <b class="text-success"></h3>
            </div>

            <div class="col-md-8" style="padding-top: 20px;">


                <form action="{{ url('refferalsReport') }}" method="post" class="form-inline">

                    {{ csrf_field() }}
                    <div class="form-group @if ($errors->has('type')) has-error @endif">
                        <div class="input-group">
                            <select class="form-control" name="type">
                                <option value="out" @if($type == 'out') selected @endif>From this clinic</option>
                                <option value="in" @if($type == 'in') selected @endif>From other clinics</option>
                            </select>
                        </div>
                        @if ($errors->has('type'))
                            <span class="help-block">
                                <strong class="">{{ $errors->first('type') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group @if ($errors->has('starting')) has-error @endif">
                        <div class="input-group">
                            <span class="input-group-addon" id="startingDate" onclick="document.getElementById('starting').focus()">
                                <i class="fa fa-calendar"></i>
                            </span>
                            <input type="text" name="starting" class="form-control datepicker" value="{{ $starting or '' }}"
                                   placeholder="Starting Date" aria-describedby="startingDate" id="starting" required />
                        </div>
                        @if ($errors->has('starting'))
                            <span class="help-block">
                                <strong class="">{{ $errors->first('starting') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group @if ($errors->has('ending')) has-error @endif">
                        <div class="input-group">
                            <span class="input-group-addon" id="endingDate" onclick="document.getElementById('ending').focus()">
                                <i class="fa fa-calendar"></i>
                            </span>
                            <input type="text" name="ending" class="form-control datepicker" value="{{ $ending or '' }}"
                                   placeholder="Ending Date" aria-describedby="endingDate" id="ending">
                        </div>
                        @if ($errors->has('ending'))
                            <span class="help-block">
                                <strong class="">{{ $errors->first('ending') }}</strong>
                            </span>
                        @endif
                    </div>


                    <div class="form-group">
                        <button class="btn btn-success" type="submit">Submit</button>
                    </div>

                </form>


                <br/>
                <br/>

            </div>




            <div class="col-md-12">

                @if($starting)
                @if(!$refferals->isEmpty())
                    @php $total = 0; @endphp
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="bg-primary">
                                    <th>Total</th>
                                    <th>Referred {{ ($type == 'in')?'by':'to' }} Clinic</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($refferals as $row)
                                <tr>
                                    <td>{{ $row->total }}</td>
                                    <td>{{ $row->name }}</td>
                                </tr>
                                    @php $total+=$row->total @endphp
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="bg-primary">
                                    <td>{{ $total }}</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                @else
                    <div class="alert alert-danger text-center">
                        <h5>No Results Found!</h5>
                    </div>
                @endif
                    @else

                    <hr/>
                    <h4 class="text-center text-danger">Please select a date to retrieve data</h4>
                    <hr/>

                @endif
            </div>


        </div>



    </div>

@endsection





@section('footer')
@stop



@section('pagescript')
    @include('message.toaster')
    <script src="{{ asset('public/plugins/js/jquery-ui.min.js') }}"></script>

    <script>
        $(function() {
            $( ".datepicker" ).datepicker({
                dateFormat: 'yy-mm-dd',
            });
        });
    </script>
@stop


@endcomponent
