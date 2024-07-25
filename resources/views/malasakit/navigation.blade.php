
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
                <font class="longBrandName">EVRMC-PIS | MALASAKIT CENTER</font>
                <font class="shortHandName">PIS</font>
            </a>
        </div>


        <div class="collapse navbar-collapse" id="navigationMenus">
            <ul class="nav navbar-nav navbar-right">
                
                <li class="dropdown">
                    @include('partials.settings')
                </li>
            </ul>
        </div>

    </div>
</nav>

<br/><br/><br/>
