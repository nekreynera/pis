<li class="dropdown messages-menu qrcode_main_wrapper">
    <!-- Menu toggle button -->
    <a href="" class="dropdown-toggle"
       onclick="qrcode_open($(this))" title="QR Code">
        <i class="fa fa-qrcode"></i>
    </a>
    <ul class="dropdown-menu">
        <li class="header text-center text-muted">
            <strong>Scan QR Code or Enter Hospital No.</strong>
        </li>
        <li class="qr_code_parent_list">
            <!-- Inner Menu: contains the notifications -->
            <ul class="menu">
                <li><!-- start notification -->
                    <form action="<?php echo e(url('qrcode')); ?>" method="post">
                        <?php echo e(csrf_field()); ?>

                        <input type="text" name="qrcode" class="form-control input-lg" required />
                    </form>
                </li>
                <!-- end notification -->
            </ul>
        </li>
        <li class="footer">
            <a href="#">
                <em>Please be sure patient is MSS classified</em>
            </a>
        </li>
    </ul>
</li>
<!-- /.qr code-menu -->



<li class="dropdown messages-menu search_queue_wrapper">
    <!-- Menu toggle button -->
    <a href="" class="dropdown-toggle"
       onclick="queue_search_open($(this))" title="Search queued patients">
        <i class="fa fa-search"></i>
    </a>
    <ul class="dropdown-menu">
        <li class="header text-center text-muted">
            <strong>Search today's queued patients</strong>
        </li>
        <li class="search_queued_parent_list">
            <!-- Inner Menu: contains the notifications -->
            <ul class="menu">
                <li><!-- start notification -->
                    <form action="<?php echo e(url('search_queued_patients')); ?>" method="post">
                        <?php echo e(csrf_field()); ?>

                        <input type="text" name="search" class="form-control input-lg" />
                    </form>
                </li>
                <!-- end notification -->
            </ul>
        </li>
        <li class="footer">
            <a href="#">
                <em>Ex: Santos Juan, Hospital no, QR Code</em>
            </a>
        </li>
    </ul>
</li>
<!-- /.qr code-menu -->






<!-- Messages: style can be found in dropdown.less-->
<li class="dropdown messages-menu">

    <!-- Menu toggle button -->
    <a href="#" class="dropdown-toggle" id="registeredPatientCount" data-toggle="dropdown">
        <i class="fa fa-user-o"></i>
        
        <span class="label label-success">67</span>
    </a>

    <ul class="dropdown-menu">
        <li class="header">Newly registered patients</li>
        <li class="newlyRegListContainer">
            <!-- inner menu: contains the messages -->

            

        </li>
        <li class="footer">
            <a href="<?php echo e(url('search_patient/'.Carbon::now()->toDateString().'/register.search')); ?>">
                See All New Patients
            </a>
        </li>
    </ul>

</li>
<!-- /.messages-menu -->






<!-- Notifications Menu -->
<li class="dropdown notifications-menu">
    <!-- Menu toggle button -->
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-bell-o"></i>
        <span class="label label-warning">10</span>
    </a>
    <ul class="dropdown-menu">
        <li class="header">You have 10 notifications</li>
        <li>
            <!-- Inner Menu: contains the notifications -->
            <ul class="menu">
                <li><!-- start notification -->
                    <a href="#">
                        <i class="fa fa-users text-aqua"></i> 5 new members joined today
                    </a>
                </li>
                <!-- end notification -->
            </ul>
        </li>
        <li class="footer"><a href="#">View all</a></li>
    </ul>
</li>
<!-- Tasks Menu -->
<li class="dropdown tasks-menu">
    <!-- Menu Toggle Button -->
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-flag-o"></i>
        <span class="label label-danger">9</span>
    </a>
    <ul class="dropdown-menu">
        <li class="header">You have 9 tasks</li>
        <li>
            <!-- Inner menu: contains the tasks -->
            <ul class="menu">
                <li><!-- Task item -->
                    <a href="#">
                        <!-- Task title and progress text -->
                        <h3>
                            Design some buttons
                            <small class="pull-right">20%</small>
                        </h3>
                        <!-- The progress bar -->
                        <div class="progress xs">
                            <!-- Change the css width attribute to simulate progress -->
                            <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar"
                                 aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                <span class="sr-only">20% Complete</span>
                            </div>
                        </div>
                    </a>
                </li>
                <!-- end task item -->
            </ul>
        </li>
        <li class="footer">
            <a href="#">View all tasks</a>
        </li>
    </ul>
</li>