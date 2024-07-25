@component('partials/header')

    @slot('title')
        PIS | Census
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/plugins/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/plugins/css/jquery-ui.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('public/css/patients/unprinted.css') }}" />
@stop



@section('header')
    @include('patients/navigation')
@stop



@section('content')
    <div class="container">
        <h2 class="text-right">Patient Census</h2>
        <form action="{{ url('census') }}" method="post" class="form-inline">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="">Starting Date</label>
                <input type="text" id="datepicker" name="from" class="form-control" placeholder="Enter Starting Date..." />
            </div>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <i class="fa fa-arrow-right"></i>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <div class="form-group">
                <label for="">Ending Date</label>
                <input type="text" id="endingDate" name="to" class="form-control" placeholder="Enter Starting Date..." />
            </div>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <div class="form-group">
                <button class="btn btn-success">Submit</button>
            </div>
        </form>
        <hr>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr style="background-color: #ccc">
                        <th>NAME</th>
                        <th class="text-center">REGISTERED PATIENTS</th>
                        <th class="text-center">REGISTERED DATE</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($registered) > 0)
                        @php
                            $total = 0;
                        @endphp
                        @foreach($registered as $register)
                            <tr>
                                <td>{{ $register->name }}</td>
                                <td class="text-center">{{ $register->total }}</td>
                                <td class="text-center">{{ Carbon::parse($register->created_at)->toDateString() }}</td>
                            </tr>
                            @php $total += $register->total @endphp
                        @endforeach
                    @else
                        <tr>
                            <td colspan="3" class="text-center">
                                <strong class="text-danger">
                                    No Results Found!
                                </strong>
                            </td>
                        </tr>
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <td class="text-center">{!! (isset($total))? '<strong class="text-danger">Total: '.$total.'</strong>' : '' !!}</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>

    </div>

    <br><br>
@endsection




@section('pagescript')
    @include('message.toaster')
    <script src="{{ asset('public/plugins/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/plugins/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/plugins/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('public/js/patients/register.js') }}"></script>
@stop


@endcomponent
