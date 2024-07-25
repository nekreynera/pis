@component('partials/header')

    @slot('title')
        PIS | ANCILLARY
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/css/ancillary/list.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/plugins/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />
@endsection



@section('header')
    @include('receptions/navigation')
@stop

@section('content')
            <div class="container">
                <div class="col-md-12 census-form">
                    <br>
                    <form class="form-inline pull-right" method="GET" target="_blank">
                            <label>TYPE</label>
                            <select class="form-control" name="type" required>
                                <option value="" hidden>Select</option>
                                <option value="all">ISSUANCE ALL</option>
                                <option value="c">MSS ISSUANCE CLASS-C</option>
                                <option value="d">MSS ISSUANCE CLASS-D</option>
                                <!-- <option value="d">SERVICES</option> -->
                            </select>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <label>FROM</label>
                            <div class="input-group">
                                <span class="input-group-addon fa fa-calendar"></span>
                                <input type="date" name="from" class="form-control" @if(isset($_GET['to'])) value="{{  $_GET['from'] }}" @endif required>
                            </div>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <label> <span class="fa fa-arrow-right"></span> TO</label>
                            <div class="input-group">
                                <span class="input-group-addon fa fa-calendar"></span>
                                <input type="date" name="to" class="form-control" @if(isset($_GET['to'])) value="{{  $_GET['to']  }}" @endif required>
                            </div>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <button type="submit" class="btn btn-success btn-md"><span class="fa fa-cog"></span> GENERATE </button>
                    </form>
                </div>
     
            </div> 
            <!-- .content-wrapper -->
@endsection



@section('footer')
@stop



@section('pagescript')
    @include('message.toaster')
    
    <script src="{{ asset('public/plugins/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/plugins/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/js/ancillary/list.js') }}"></script>
@stop


@endcomponent
