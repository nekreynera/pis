<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">

            <div class="pull-left image">
                <?php
                    if(Auth::user()->profile){
                        $avatar = asset('public/users/'.Auth::user()->profile);
                    }else{
                        $avatar = asset('/public/OPDMS/images/avatar.png');
                    }
                ?>
                {{-- dashboard user image --}}
                <img src="{{ $avatar }}" class="img-circle img-responsive userAvatarDashboard" alt="User Image">
            </div>


            <div class="pull-left info">

                <p class="text-ellipsis">
                    {{ Auth::user()->first_name.' '.Auth::user()->last_name }}
                </p>

                {{---- chcek if user is online --}}
                <small><i class="fa fa-circle text-green"></i> Online</small>
                {{--@include('partials.connectivity')--}}

            </div>
        </div>



        <!-- search form (Optional) -->



        @yield('search_form')



        <!-- /.search form -->


        @if(Auth::user()->role == 5) {{-- Reception --}}
            @include('OPDMS.reception.roles')
        @elseif(Auth::user()->role == 1) {{-- roles --}}
            @include('OPDMS.patients.roles')
        @elseif(Auth::user()->role == 4 && Auth::user()->clinic == 47) {{-- laboratory --}}
            @include('OPDMS.laboratory.roles')
        @endif




        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>