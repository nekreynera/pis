<style>
    .dropdown-submenu {
        position: relative;
    }
    .dropdown-submenu .dropdown-menu {
        top: 0;
        left: 100%;
        margin-top: -1px;
        width: 250px;
    }
</style>


@include('receptions.qrcode.scan')

<nav class="navbar navbar-inverse navigation">

    <div class="container">

        <div class="navbar-header">
            <div class="navbar-toggle collapsed hamburger" data-toggle="collapse" data-target="#navigationMenus"
                 aria-expanded="false" onclick="openHamburger(this)">
                <div class="bar1"></div>
                <div class="bar2"></div>
                <div class="bar3"></div>
            </div>
            <a class="navbar-brand" href="{{ url('overview') }}">
                <!-- <i class="fa fa-stethoscope"></i> -->
                <label class="longBrandName">PIS | RECEPTION</label>
                <label class="shortHandName">PIS</label>
            </a>
        </div>


        <div class="collapse navbar-collapse" id="navigationMenus">
            <ul class="nav navbar-nav navbar-right">
                {{--<li class="">
                    <a href="{{ url('receptions') }}">QRCode <i class="fa fa-qrcode"></i></a>
                </li>--}}

                <li class="nav-li li-nav">
                    <a class="opd-sub-nav" id="qcodeModal" href="#" data-toggle="modal" data-target="#qrcodeModal">
                        QRCode <i class="fa fa-qrcode"></i>
                    </a>
                </li>

                <li class="nav-li li-nav">
                    <a class="opd-sub-nav" href="{{ url('overview') }}">Overview <i class="fa fa-list"></i></a>
                </li>
                {{--<li class="">
                    <a href="{{ url('doctorsStatus') }}">DOCTORS <i class="fa fa-user-md"></i></a>
                </li>
                <li class="">
                    <a href="{{ url('patientsStatus') }}">PATIENTS <i class="fa fa-wheelchair"></i></a>
                </li>--}}

                @if(Auth::user()->clinic != 31)
                <li class="nav-li li-nav">
                    <a class="opd-sub-nav" href="{{ url('vs_scanbarcode') }}">Vital Signs <i class="fa fa-heartbeat"></i></a>
                </li>
                @endif

               
                <li class="nav-li li-nav">
                    <a class="opd-sub-nav" href="{{ url('ancillary') }}">Services | Supplies <i class="fa fa-wrench"></i></a>
                </li>
               

                <li class="nav-li li-nav">
                    <a class="opd-sub-nav" href="{{ url('patientsearch') }}">Search <i class="fa fa-search"></i></a>
                </li>
                <li class="nav-li li-nav" >


                    <!-- disable time limit or time accepted upon order from sir francis hermano -->
                <!-- <?php 
                  $current_time = time();
                  $weekday = date('w', $current_time); // Get the current day of the week as a number (0 for Sunday, 6 for Saturday)
                  $start_time = strtotime("5:00am");
                  $end_time = strtotime("12:00pm");
                    
                    ?>
                    @if($weekday != 0 && $weekday != 6)
                        @if($current_time >= $start_time && $current_time <= $end_time) 
                            <a class="opd-sub-nav" href="#" onclick="myFunction()">History <i class="fa fa-history" disabled id="history_nav"></i></a>
                        @else
                            <a class="opd-sub-nav" href="{{ url('rcptnLogs') }}" disabled>History <i class="fa fa-history"></i></a>
                        @endif
                    @else
                        <a class="opd-sub-nav" href="{{ url('rcptnLogs') }}" disabled>History <i class="fa fa-history"></i></a>
                    @endif -->

                     <a class="opd-sub-nav" href="{{ url('rcptnLogs') }}" disabled>History <i class="fa fa-history"></i></a>
                </li>

                <li class="dropdown opd-nav li-nav" >
                <!-- disable time limit or time accepted upon order from sir francis hermano -->
                <!-- @if($weekday != 0 && $weekday != 6)
                        @if($current_time >= $start_time && $current_time <= $end_time) 
                            <a href="#" class="dropdown-toggle opd-sub-nav" data-toggle="#" role="button" aria-haspopup="true" aria-expanded="false" onclick="myFunction2()">
                            Reports <i class="fa fa-file-text-o" ></i>
                            <span class="caret"></span>
                            </a>
                        @else
                            <a href="#" class="dropdown-toggle opd-sub-nav" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                Reports <i class="fa fa-file-text-o" disabled></i>
                                <span class="caret"></span>
                            </a>
                        @endif
                    @else
                            <a href="#" class="dropdown-toggle opd-sub-nav" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                Reports <i class="fa fa-file-text-o" disabled></i>
                                <span class="caret"></span>
                            </a>
                    @endif -->


                          <a href="#" class="dropdown-toggle opd-sub-nav" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                Reports <i class="fa fa-file-text-o"></i>
                                <span class="caret"></span>
                            </a>
                   

                    <ul class="dropdown-menu">



                            <li class="reporst-li">
                                <a href="{{ url('censusWatch') }}">Statistics Report &nbsp; <small><strong class="text-danger">BETA</strong></small></a>
                            </li>
                            <li class="reporst-li">
                                <a href="{{ url('famedcensus') }}">
                                    Age, Gender Distribution &nbsp; <small><strong class="text-danger">BETA</strong></small>
                                </a>
                            </li>

                            @if(Auth::user()->clinic == 22 || Auth::user()->clinic == 21)
                                <li>
                                    <a href="{{ url('weeklyCensus') }}">Weekly Report &nbsp; <small><strong class="text-danger">BETA</strong></small></a>
                                </li>
                            @endif

                            <li class="dropdown-submenu reporst-li">
                                <a class="test" tabindex="-1" href="#">Medical Services &nbsp; <small><strong class="text-danger">BETA</strong></small>
                                    <i class="fa fa-caret-right pull-right" style="padding-top: 3px"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a tabindex="-1" href="{{ url('medServicesAccomplished') }}">Services Accomplished &nbsp; <small><strong class="text-danger">BETA</strong></small></a></li>
                                    <li><a tabindex="-1" href="{{ url('topLeadingServices') }}">Top Leading Services &nbsp; <small><strong class="text-danger">BETA</strong></small></a></li>
                                    <li><a tabindex="-1" href="{{ url('ancillarycensus') }}?top=ALL&from={{Carbon::now()->setTime(0,0)->format('Y-m-d')}}&to={{Carbon::now()->setTime(0,0)->format('Y-m-d')}}">Census &nbsp; <small><strong class="text-danger">BETA</strong></small></a></li>
                                </ul>
                            </li>

                            <li class="reporst-li">
                                <a href="{{ url('highestCases') }}">Demographic Report &nbsp; <small><strong class="text-danger">BETA</strong></small></a>
                            </li>


                            <li class="dropdown-submenu reporst-li">
                                <a class="test" tabindex="-1" href="#">Demographic Census &nbsp; <small><strong class="text-danger">BETA</strong></small>
                                    <i class="fa fa-caret-right pull-right" style="padding-top: 3px"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a tabindex="-1" href="{{ url('demographic') }}">Detailed Census &nbsp; <small><strong class="text-danger">BETA</strong></small></a></li>
                                    <li><a tabindex="-1" href="{{ url('demographicSummary') }}">Summary Census &nbsp; <small><strong class="text-danger">BETA</strong></small></a></li>
                                </ul>
                            </li>




                        <li class="reporst-li">
                            <a href="{{ url('ancillaryreport') }}">MSS Report &nbsp; <small><strong class="text-danger">BETA</strong></small></a>
                        </li>

                        <li class="reporst-li">
                            <a href="{{ url('refferalsReport') }}">Referrals Report &nbsp; <small><strong class="text-danger">BETA</strong></small></a>
                        </li>

                    </ul>
                </li>
                <li class="dropdown opd-nav2 li-nav">
                    <a class="opd-sub-nav2" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        {{ Auth::user()->username }}
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="reporst-li2" href="{{ url('receptionsAccount') }}">Update Account</a></li>
                        <li>
                            <a class="reporst-li2" href="{{ url('logout') }}"
                               onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();">
                                Logout
                            </a>

                            <form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

    </div>
</nav>

<script>
    function myFunction() {
         alert("Reports generation will be available between 3pm to 5am only, Please Contact IHOMP OFFICE at Intercom no. 1129 for technical assistance. Thank you!");
              return false;
}
function myFunction2() {
         alert("Reports generation will be available between 3pm to 5am only, Please Contact IHOMP OFFICE at Intercom no. 1129 for technical assistance. Thank you!");
              return false;
}
   
    </script>


<br/><br/><br/>
