<nav class="navbar navbar-default navigation">

    <div class="container">

        <div class="navbar-header">
            <div class="navbar-toggle collapsed hamburger" data-toggle="collapse" data-target="#navigationMenus" 
                aria-expanded="false" onclick="openHamburger(this)">
                <div class="bar1"></div>
                <div class="bar2"></div>
                <div class="bar3"></div>
            </div>
            <a class="navbar-brand" href="<?php echo e(url('/')); ?>">
                <i class="fa fa-stethoscope"></i>
                <label class="longBrandName">OUT PATIENT RECORDS MNGT. SYSTEM</label>
                <label class="shortHandName">OPD</label>
            </a>
        </div>


        <div class="collapse navbar-collapse" id="navigationMenus">
            <ul class="nav navbar-nav navbar-right">
                
                <li class="nav-li li-nav">
                    <a class="opd-sub-nav" href="<?php echo e(url('register')); ?>">
                        Register
                    </a>
                </li>
                <li class="nav-li li-nav">
                    <a class="opd-sub-nav" href="<?php echo e(url('userlist')); ?>">
                        Userlist
                    </a>
                </li>
                <li class="nav-li li-nav">
                     <a href="#" class="dropdown-toggle opd-sub-nav" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        Reports
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="reporst-li"><a href="<?php echo e(url('admin/consultation_logs')); ?>">Consultation Logs</a></li>
                        
                        <li class="reporst-li"><a href="<?php echo e(url('admin/geographic_cencus')); ?>">Geographic Census</a></li>
                    </ul>
                </li>
                <li class="dropdown opd-nav li-nav">
                    <a href="#" class="dropdown-toggle opd-sub-nav" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <?php echo e(Auth::user()->username); ?>

                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="reporst-li"><a href="#">Update Profile</a></li>
                        <li class="reporst-li">
                            <a href="<?php echo e(url('logout')); ?>"
                               onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();">
                                Logout
                            </a>

                            <form id="logout-form" action="<?php echo e(url('logout')); ?>" method="POST" style="display: none;">
                                <?php echo e(csrf_field()); ?>

                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

    </div>
</nav>

<br/><br/><br/>