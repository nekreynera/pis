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
                <label class="longBrandName">PIS | MEDICAL RECORDS</label>
                <label class="shortHandName">PIS</label>
            </a>
        </div>


        <div class="collapse navbar-collapse" id="navigationMenus">
            <ul class="nav navbar-nav navbar-right">
                <li class="addpatient">
                    <a href="#">ADD PATIENT <i class="fa fa-user-o"></i></a>
                </li>
                <li class="">
                    <a href="{{ url('medicalrecord?stats=P') }}">OVERVIEW <i class="fa fa-list"></i></a>
                </li>
                <li class="">
                    <a href="{{ url('msssearch') }}">SEARCH PATIENT<i class="fa fa-search"></i></a>
                </li>
                <li class="">
                    <a href="{{ url('report') }}">REPORTS <i class="fa fa-file-o"></i></a>
                </li>
                <li class="dropdown">
                    @include('partials.settings')
                </li>
            </ul>
        </div>

    </div>
</nav>

<br/><br/><br/>
