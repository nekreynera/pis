<style>
    #searchWatcherModal form span{
        background-color: #00cc66;
        border: 1px solid #00cc66;
        color: #fff;
        transition: background-color .3s
    }
    #searchWatcherModal form span:hover{
        background-color: #00b359;
        cursor: pointer;
    }
    #searchWatcherModal table{
        background-color: #e6e6e6;
    }
    #searchWatcherModal table th{
        font-size: 13px;
        background-color: #cccccc;
        text-align: center;
        padding: 4px;
    }
    #searchWatcherModal table td{
        font-size: 12px;
        padding: 4px;
    }
</style>


@include('patients.searchWatcherModal')
@include('patients.scanmodal')


<nav class="navbar navbar-default navigation">


    <div class="container">

        <div class="navbar-header">
            <div class="navbar-toggle collapsed hamburger" data-toggle="collapse" data-target="#navigationMenus" 
                aria-expanded="false" onclick="openHamburger(this)">
                <div class="bar1"></div>
                <div class="bar2"></div>
                <div class="bar3"></div>
            </div>
            @if(Auth::user()->clinic == 54)
            <a class="navbar-brand" href="{{ url('admittedpatient') }}">
            @else
            <a class="navbar-brand" href="{{ url('searchpatient') }}">
            @endif
                <i class="fa fa-stethoscope"></i>
                <label class="longBrandName">PIS</label>
                <label class="shortHandName">PIS</label>
            </a>
        </div>


        <div class="collapse navbar-collapse" id="navigationMenus">
            <ul class="nav navbar-nav navbar-right">
                <!-- <li class="">
                    <a href="{{ url('patients') }}">REGISTER <i class="fa fa-pencil"></i></a>
                </li> -->
                @if(Auth::user()->clinic != 54)
                <li class="{{ (Auth::user()->clinic == 54)?'disabled':'' }}">
                    <a href="{{ (Auth::user()->clinic == 54)?'#':url('searchpatient') }}"><i class="fa fa-user-circle-o"></i> OUT-PATIENTS </a>
                </li>
                <li class="{{ (Auth::user()->clinic == 54)?'':'disabled' }}">
                    <a  href="{{ (Auth::user()->clinic == 54)?url('admittedpatient'):'#' }}"><i class="fa fa-user-circle"></i> IN-PATIENTS </a>
                </li>
               <!--  <li class="">
                    <a href="{{ url('unprinted') }}">UNPRINTED CARDS <i class="fa fa-print"></i></a>
                </li> -->
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-file-text-o"> </i>
                        REPORT
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ url('registerreport') }}?user=all&group=DATE&from=<?php echo Carbon::now()->setTime(0,0)->format('Y-m-d') ?>&to=<?php echo Carbon::now()->setTime(0,0)->format('Y-m-d') ?>"
                            onclick="window.location.assign(baseUrl+'/registerreport')">REGISTRATION</a></li>
                        <!-- <li><a href="{{ url('referralreport') }}?">REFERRAL</a></li> -->
                    </ul>
                </li>
                @else
                    <li class="{{ (Auth::user()->clinic == 54)?'':'disabled' }}">
                        <a  href="{{ (Auth::user()->clinic == 54)?url('admittedpatient'):'#' }}"><i class="fa fa-user-circle"></i> ID REGISTRATION </a>
                    </li>
                    <li>
                        <a href="#" data-toggle="modal" data-target="#searchWatcherModal"><i class="fa fa-search"></i> SEARCH WATCHER </a>
                    </li>
                @endif
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        {{ Auth::user()->username }}
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">

                        <li><a href="{{ url('register_account') }}" onclick="window.location.assign(baseUrl+'/register_account')">Update Account</a></li>

                        <li>
                            <a href="{{ url('logout') }}"
                               onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();">
                                Logout <i class="fa fa-sign-out"></i>
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






