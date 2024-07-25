@component('partials/header')

    @slot('title')
        PIS | Information
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/plugins/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('public/css/radiology/master.css') }}">
    <link rel="stylesheet" href="{{ asset('public/css/radiology/information.css') }}">
@stop



@section('header')
    @include('radiology/navigation')
@stop



@section('content')

    <div class="container-fluid">
        <div class="container">

            <br>

            <ul class="nav nav-pills nav-justified">
                <li class="active">
                    <a data-toggle="tab" href="#home">
                        Personal Information <i class="fa fa-user-o"></i>
                    </a>
                </li>
                <li>
                    <a data-toggle="tab" href="#menu1">
                        Vital Signs <i class="fa fa-heartbeat"></i>
                    </a>
                </li>
            </ul>

            <div class="tab-content">


                @include('radiology.personalInfo')

                @include('radiology.vitalSigns')


            </div>



        </div>
    </div>

@endsection




@section('footer')
@stop



@section('pagescript')
    @include('message.toaster')
    <script src="{{ asset('public/plugins/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/plugins/js/dataTables.bootstrap.min.js') }}"></script>
@stop


@endcomponent
