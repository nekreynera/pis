@component('partials/header')

    @slot('title')
        PIS | Diseases
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/plugins/css/jquery-ui.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/doctors/reset.css') }}" rel="stylesheet" />
    @if(Auth::user()->theme == 2)
        <link href="{{ asset('public/css/doctors/darkstyle.css') }}" rel="stylesheet" />
    @else
        <link href="{{ asset('public/css/doctors/greenstyle.css') }}" rel="stylesheet" />
    @endif
    <link href="{{ asset('public/plugins/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/main.css') }}" rel="stylesheet" />
@endsection



@section('header')
    @include('doctors.navigation')
@stop
@section('content')
    @component('doctors/dashboard')
@section('main-content')


    <div class="content-wrapper" style="padding: 50px 0px;">
        <br>
        <div class="container-fluid">

            <div id="pintor-container" ></div>



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
    <script src="{{ asset('js/constants.js') }}"></script>
    <script src="{{ asset('js/utility.js') }}"></script>
    <script src="{{ asset('js/pintor.js') }}"></script>
    <script src="{{ asset('js/scratch.js') }}"></script>
    <script src="{{ asset('js/thumbnails.js') }}"></script>
    <script src="{{ asset('js/handlers.js') }}"></script>
    <script src="{{ asset('js/toolbox.js') }}"></script>
    <script src="{{ asset('js/drawing.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
@stop


@endcomponent
