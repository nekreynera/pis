<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <meta http-equiv="Expires" CONTENT="0">
        <meta http-equiv="cache-control" content="no-cache">
        <meta http-equiv="Pragma" CONTENT="no-cache">

        <title>{{ $title or 'PIS'  }}</title>

        <!-- Styles -->
        <link href="{{ asset('public/plugins/css/font-awesome.min.css') }}" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('public/plugins/css/bootstrap.css') }}">
        <link href="{{ asset('public/plugins/css/toastr.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('public/css/master.css') }}" rel="stylesheet" />
        <link href="{{ asset('public/css/partials/navigation.css?v2.0.1') }}" rel="stylesheet" />
        <link rel="shortcut icon" href="{{ asset('public/images/evrmc-logo.png') }}">
        <!-- Load page style -->

        <!-- Load page style -->
        @yield('pagestyle')

    </head>

    <body>
        <?php 
              // dd(Auth::user());
         ?>
        @yield('header')


        @yield('content')

        @include('partials.clinics')


        @yield('footer')

        <input type="hidden" id="baseurl-tinymce" value="{{ url('') }}">

        <!-- Scripts -->
        <script src="{{ asset('public/plugins/js/jquery.js') }}"></script>
        <script src="{{ asset('public/plugins/js/bootstrap.js') }}"></script>
        <script src="{{ asset('public/plugins/js/toastr.min.js') }}"></script>
        <script src="{{ asset('public/js/master.js?v1.0.1') }}"></script>

        @yield('pagescript')
        


        <script src="{{ asset('public/js/patients/watcher.js') }}"></script>
        <!-- <script>
            $('#navigationMenus .opd-nav').click(function(){
                $('#navigationMenus .opd-nav .opd-sub-nav').css('background-color','#028046');
                $('#navigationMenus .opd-nav2 .opd-sub-nav2').css('background-color','#00a65a');
                $('.dropdown-menu .reporst-li').css('background-color','#fff')
                $('.dropdown-menu .reporst-li .dropdown-menu li').css('background-color','#fff')
            });
            $('#navigationMenus .opd-nav2').click(function(){
                $('#navigationMenus .opd-nav2 .opd-sub-nav2').css('background-color','#028046');
                $('#navigationMenus .opd-nav .opd-sub-nav').css('background-color','#00a65a');
                $('.dropdown-menu .reporst-li2').css('background-color','#fff')
            });
        </script> -->

    </body>
</html>
