<!-- Main Header -->
<header class="main-header">



  <!-- Logo -->
  <a href="index2.html" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b>PIS</b></span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>PIS</b></span>
  </a>




  <!-- Header Navbar -->
  <nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>


    <!-- Navbar Right Menu -->
    <div class="navbar-custom-menu">

      <ul class="nav navbar-nav">





        {{-- notification goes here --}}
        @if(Auth::user()->role == 5) {{-- Reception --}}
          @include('OPDMS.reception.notification')
        @endif




        {{-- User Account Here --}}

        <?php
          if(Auth::user()->profile){
            $avatar = asset('public/users/'.Auth::user()->profile);
          }else{
            $avatar = asset('/public/OPDMS/images/avatar.png');
          }
        ?>


        <!-- User Account Menu -->
        <li class="dropdown user user-menu">

          <!-- Menu Toggle Button -->
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <!-- The user image in the navbar-->

            <img src="{{ $avatar }}" class="user-image img-circle" alt="User Image">
            <!-- hidden-xs hides the username on small devices so only the image appears. -->
            <span class="hidden-xs">{{ Auth::user()->username }}</span>
          </a>
          <ul class="dropdown-menu">

            <!-- The user image in the menu -->



            <li class="user-header">
              <img src="{{ $avatar }}" class="img-circle" alt="User Image">
              <p class="text-ellipsis3">
                {{ Auth::user()->first_name.' '.Auth::user()->last_name }}
              </p>
              <small class="text-muted small">
                {{-- your role goes here --}}
                <!-- Receptionist -->
              </small>
            </li>



            {{--<!-- Menu Body -->
            <li class="user-body">
              <div class="row">
                <div class="col-xs-4 text-center">
                  <a href="#">Followers</a>
                </div>
                <div class="col-xs-4 text-center">
                  <a href="#">Sales</a>
                </div>
                <div class="col-xs-4 text-center">
                  <a href="#">Friends</a>
                </div>
              </div>
              <!-- /.row -->
            </li>--}}


            <!-- Menu Footer-->
            <li class="user-footer">
              <!-- <div class="pull-left">
                <a href="#" class="btn btn-info btn-flat disabled">
                  Profile <i class="fa fa-user-circle-o"></i>
                </a>
              </div> -->
              <div class="pull-right">
                <a href="{{ url('logout') }}" class="btn btn-danger btn-flat"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                  Logout &nbsp;<i class="fa fa-sign-out"></i>
                </a>
                <form id="logout-form" action="{{ url('logout') }}" method="post" style="display: none;">
                  {{ csrf_field() }}
                </form>
              </div>
            </li>
          </ul>
        </li>


        {{-- End of User Account --}}





        <!-- Control Sidebar Toggle Button -->
        <li>
          <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears fa-spin"></i></a>
        </li>


      </ul>
    </div>
  </nav>
</header>