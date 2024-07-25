<nav class="navbar navbar-default navigation">

    <div class="container">

        <div class="navbar-header">
            <div class="navbar-toggle collapsed hamburger" data-toggle="collapse" data-target="#navigationMenus" 
                aria-expanded="false" onclick="openHamburger(this)">
                <div class="bar1"></div>
                <div class="bar2"></div>
                <div class="bar3"></div>
            </div>
            <a class="navbar-brand" href="#">
                <i class="fa fa-stethoscope"></i>
                <label class="longBrandName">OUT PATIENT RECORDS MNGT. SYSTEM</label>
                <label class="shortHandName">OPD</label>
            </a>
        </div>


        <div class="collapse navbar-collapse" id="navigationMenus">
            <ul class="nav navbar-nav navbar-right">
                <li class="">
                    <a href="<?php echo e(url('triage')); ?>">ENTER QRCODE <i class="fa fa-qrcode"></i></a>
                </li>
                <li class="">
                    <a href="<?php echo e(url('triagesearch')); ?>">SEARCH PATIENTS <i class="fa fa-search"></i></a>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <?php echo e(Auth::user()->username); ?>

                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo e(url('triageAccount')); ?>">Update Account</a></li>
                        <li>
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