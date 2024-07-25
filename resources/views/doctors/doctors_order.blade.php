@component('partials/header')

    @slot('title')
        PIS | Doctors Order
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/css/doctors/reset.css') }}" rel="stylesheet" />
    @if(Auth::user()->theme == 2)
        <link href="{{ asset('public/css/doctors/darkstyle.css') }}" rel="stylesheet" />
    @else
        <link href="{{ asset('public/css/doctors/greenstyle.css') }}" rel="stylesheet" />
    @endif
    <link href="{{ asset('public/css/partials/account.css') }}" rel="stylesheet" />
@endsection



@section('header')
    @include('doctors.navigation')
@stop



@section('content')
    @component('doctors/dashboard')
@section('main-content')


    <div class="content-wrapper">
        <br/>
        <br/>

        <div class="container-fluid">
            <div class="col-md-12 row">
                <h4><small>PATIENT NAME:</small> {{ $patient->last_name.', '.$patient->first_name.' '.$patient->middle_name }}</h4>
                <h4><small>ADDRESS:</small> {{ $patient->address }}</h4>
                <hr>
            </div>
            <div class="col-md-4 doctorsOrderWrapper">
                <h3 class="text-center">Disposition <i class="fa fa-gavel"></i></h3>
                <br>
                <br>
                <form action="{{ url('doctors_order') }}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="">Reason</label>
                        <textarea name="reason" id="" cols="30" rows="10" class="form-control" placeholder="Enter Your Reasons Here..."></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Order *</label>
                        <select name="disposition" id="" class="form-control" required>
                            <option value="">--Select Order--</option>
                            <option value="Discharge">Discharge</option>
                            <option value="Admition">Admition</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success" style="background-color: #4cae4c" >Submit Order</button>
                    </div>
                </form>
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
    <script src="{{ asset('public/js/doctors/main.js') }}"></script>
@stop


@endcomponent
