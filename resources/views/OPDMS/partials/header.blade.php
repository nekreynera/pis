<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta http-equiv="Expires" CONTENT="0">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="Pragma" CONTENT="no-cache">

    <title>{{ $title or 'OPDMS'  }}</title>

{{--    <link href="{{ asset('public/css/app.css') }}" rel="stylesheet" />--}}

    <!-- Styles -->
    <link href="{{ asset('public/OPDMS/plugins/bootstrap/bootstrap.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/OPDMS/plugins/font-awesome/font-awesome.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/OPDMS/plugins/toastr/toastr.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('public/OPDMS/plugins/jquery-ui/jquery-ui.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/AdminLTE/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/AdminLTE/bower_components/Ionicons/css/ionicons.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/AdminLTE/plugins/iCheck/all.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/AdminLTE/bower_components/select2/dist/css/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/AdminLTE/dist/css/AdminLTE.min.css') }}"> <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('public/AdminLTE/dist/css/skins/_all-skins.min.css') }}" />




    <link href="{{ asset('public/OPDMS/css/master.css') }}" rel="stylesheet" />

    <!-- Load page style -->
    @yield('pagestyle')


</head>


<body class="hold-transition skin-green sidebar-mini fixed">

    <div class="wrapper">


        @include('OPDMS.partials.full_window_loader') {{-- full window loader --}}


        {{-- vue element where id as attach start of div --}}
        @yield('vue-container-start')


        @yield('navigation')


        @yield('dashboard')


        @yield('content')


        @yield('footer')


        @yield('aside')

        {{-- vue element where id as attach end of div --}}
        @yield('vue-container-end')



    </div>


        <!-- Scripts -->

{{--        <script src="{{ asset('public/js/app.js') }}"></script>--}}

        
        <script src="{{ asset('public/OPDMS/plugins/jquery/jquery.js') }}"></script>
        <script src="{{ asset('public/OPDMS/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
        <script src="{{ asset('public/OPDMS/plugins/toastr/toastr.min.js') }}"></script>
        <script src="{{ asset('public/OPDMS/plugins/bootstrap/bootstrap.js') }}"></script>
        <script src="{{ asset('public/AdminLTE/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>

        <script src="{{ asset('public/AdminLTE/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('public/AdminLTE/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
        <script src="{{ asset('public/AdminLTE/plugins/iCheck/icheck.min.js') }}"></script>
        <script src="{{ asset('public/AdminLTE/bower_components/select2/dist/js/select2.full.min.js') }}"></script>

        {{-- Vue JS here--}}
        <script src="{{ asset('public/OPDMS/plugins/vue/vue.js') }}"></script>

        {{-- insert plugins script here --}}
        @yield('pluginscript')

        <script src="{{ asset('public/AdminLTE/dist/js/adminlte.min.js') }}"></script>
        <script src="{{ asset('public/AdminLTE/dist/js/demo.js') }}"></script>



        <script src="{{ asset('public/OPDMS/js/master.js') }}"></script>

        @include('OPDMS.message.toastr')

        {{-- insert custom script here --}}
        @yield('pagescript')

        <script src="{{ asset('public/OPDMS/js/partials/toaster.js') }}"></script>

        <script>
            var authenticate = {{ Auth::user()->id }}
            var auth_role = {{ Auth::user()->role }}
            
        </script>


</body>

</html>
