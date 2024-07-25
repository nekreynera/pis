<nav class="navbar navbar-default navigation">

    <div class="container">

        <div class="navbar-header">
            <div class="navbar-toggle collapsed hamburger" data-toggle="collapse" data-target="#navigationMenus"
                aria-expanded="false" onclick="openHamburger(this)">
                <div class="bar1"></div>
                <div class="bar2"></div>
                <div class="bar3"></div>
            </div>
            <a class="navbar-brand" href="{{ url('mss') }}">
                <label class="longBrandName">PIS | MSS</label>
                <label class="shortHandName">PIS</label>
            </a>
        </div>


        <div class="collapse navbar-collapse" id="navigationMenus">
            <ul class="nav navbar-nav navbar-right">
                <li class="@if(Request::is('mss')) active @endif" style="cursor: not-allowed;">
                    <!-- <a onclick="alert('disabled');">SCAN <i class="fa fa-barcode"></i></a> -->
                    <a href="{{ url('mss') }}">SCAN <i class="fa fa-barcode"></i></a>
                </li>
                <li class="@if(Request::is('classified')) active @endif">
                    <a href="{{ url('classified') }}">PATIENTS <i class="fa fa-user-o"></i></a>
                </li>
                {{--@if(Auth::user()->id == 41 || Auth::user()->id == 136)--}}
                <li class="@if(Request::is('sponsors')) active @endif" style="cursor: not-allowed;">
                    <!-- <a onclick="alert('disabled');">CLASSIFICATION <i class="fa fa-id-card-o"></i></a> -->
                    <a href="{{ url('patient_discounts') }}">CLASSIFICATION <i class="fa fa-id-card-o"></i></a>
                </li>
                <li class="@if(Request::is('sponsors')) active @endif">
                    <a href="{{ url('patient_sponsors') }}">GUARANTOR <i class="fa fa-id-card-o"></i></a>
                </li>
                {{--@endif--}}
                {{--<li class="">
                    <a href="{{ url('searchrecord') }}">SEARCH PATIENT<i class="fa fa-search"></i></a>
                </li>--}}
                <li class="@if(Request::is('report') || Request::is('genaratedreport')) active @endif" style="cursor: not-allowed;">
                    <!-- <a onclick="alert('disabled');">REPORTS <i class="fa fa-file-pdf-o"></i></a> -->
                    <a href="{{ url('report') }}">REPORTS <i class="fa fa-file-pdf-o"></i></a>
                </li>
                <li class="dropdown">
                    @include('partials.settings')
                </li>
            </ul>
        </div>

    </div>
</nav>

<br/><br/><br/>
