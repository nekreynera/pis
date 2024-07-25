@component('OPDMS.partials.header')


@slot('title')
    PIS | LABORATORY
@endslot


@section('pagestyle')
    <link href="{{ asset('public/OPDMS/css/patients/main.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/OPDMS/css/laboratory/main.css') }}" rel="stylesheet" />
@endsection


@section('navigation')
    @include('OPDMS.partials.boilerplate.navigation')
@endsection


@section('dashboard')
    @component('OPDMS.partials.boilerplate.dashboard')
    @endcomponent
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" id="main-page">

        @include('OPDMS.partials.boilerplate.header',
        ['header' => 'History', 'sub' => 'Queuing history'])

        <!-- Main content -->
        <section class="content">

            <div class="box">
                <div class="box-header with-border">
                  <div class="row action-div">
                    @include('OPDMS.laboratory.action.history')
                  </div>
                    <br>

                </div>
                <div class="box-body">
                    @include('OPDMS.partials.loader')
                    
                </div>

                <div class="box-footer">
                    <small>
                        <em class="text-muted">
                            <!-- Choose your desired reports -->
                        </em>
                    </small>
                </div>
            </div>

        </section>
        <!-- /.content -->
    </div>
   

    <!-- /.content-wrapper -->
@endsection



{{--@section('footer')
    @include('OPDMS.partials.boilerplate.footer')
@endsection--}}

@section('aside')
    @include('OPDMS.partials.boilerplate.aside')
@endsection


@section('pluginscript')
    <script src="{{ asset('public/AdminLTE/plugins/input-mask/jquery.inputmask.js') }}"></script>
    <script src="{{ asset('public/AdminLTE/plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
    <script src="{{ asset('public/AdminLTE/plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
@endsection


@section('pagescript')
    <script>
        var dateToday = '{{ Carbon::today()->format("m/d/Y") }}';
    </script>
    <script src="{{ asset('public/OPDMS/js/laboratory/main.js') }}"></script>
    
   
    <script>
        $('[data-mask]').inputmask();
        
    </script>

@endsection


@endcomponent