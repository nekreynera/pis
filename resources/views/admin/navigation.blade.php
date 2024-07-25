<nav class="navbar navbar-default navigation">

    <div class="container">

        <div class="navbar-header">
            <div class="navbar-toggle collapsed hamburger" data-toggle="collapse" data-target="#navigationMenus" 
                aria-expanded="false" onclick="openHamburger(this)">
                <div class="bar1"></div>
                <div class="bar2"></div>
                <div class="bar3"></div>
            </div>
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fa fa-stethoscope"></i>
                <label class="longBrandName">PEMAT INFORMATION SYSTEM</label>
                <label class="shortHandName">PEMAT</label>
            </a>
        </div>


        <div class="collapse navbar-collapse" id="navigationMenus">
            <ul class="nav navbar-nav navbar-right">
                {{--<li class="">
                    <a href="{{ url('patients') }}">REGISTER PATIENTS <i class="fa fa-pencil"></i></a>
                </li>
                <li class="">
                    <a href="{{ url('unprinted') }}">UNPRINTED CARDS <i class="fa fa-print"></i></a>
                </li>
                <li class="">
                    <a href="{{ url('searchpatient') }}">SEARCH PATIENTS <i class="fa fa-search"></i></a>
                </li>--}}
                <li class="nav-li li-nav">
                    <a class="opd-sub-nav" href="{{ url('register') }}">
                        Register
                    </a>
                </li>
                <li class="nav-li li-nav">
                    <a class="opd-sub-nav" href="{{ url('userlist') }}">
                        Userlist
                    </a>
                </li>
                <li class="nav-li li-nav">
                     <a href="#" class="dropdown-toggle opd-sub-nav" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        Reports
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="reporst-li"><a href="{{ url('admin/consultation_logs') }}">Consultation Logs</a></li>
                        
                        <li class="reporst-li"><a href="{{ url('admin/geographic_cencus') }}">Geographic Census</a></li>
                    </ul>
                </li>
                <li class="dropdown opd-nav li-nav">
                    <a href="#" class="dropdown-toggle opd-sub-nav" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        {{ Auth::user()->username }}
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="reporst-li"><a href="#">Update Profile</a></li>
                        <li class="reporst-li">
                            <a href="{{ url('logout') }}"
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

<br/><br/><br/>