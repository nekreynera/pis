<!-- Sidebar Menu -->

<ul class="sidebar-menu" data-widget="tree">

    <li class="header">
        MAIN NAVIGATION
    </li>
    <li>
        <a href="<?php echo e(url('patients')); ?>">
            <i class="fa fa-users"></i>
            <span>Patients</span>
        </a>
    </li>
    <!-- <div > -->
        <li class="header" <?php if(Request::is('register_report')): ?> hidden <?php endif; ?>>LABELS</li>

        <li <?php if(Request::is('register_report')): ?> hidden <?php endif; ?> class="disabled">
            <a href="#" id="patient-information" data-id="#">
                <i class="fa fa-user-o"></i>
                <span>Patient Information</span>
            </a>
        </li>
        <li <?php if(Request::is('register_report')): ?> hidden <?php endif; ?> class="disabled">
            <a href="#" id="medical-record" data-id="#">
                <i class="fa fa-book"></i>
                <span>Medical Record</span>
            </a>
        </li>
        <li <?php if(Request::is('register_report')): ?> hidden <?php endif; ?> class="disabled">
            <a href="#" id="patient-transaction" data-id="#">
                <i class="fa fa-id-card-o"></i>
                <span>Transaction</span>
            </a>
        </li>
    <!-- </div> -->
    <li class="header">OTHERS</li>
    <li>
       <a href="<?php echo e(url('register_report')); ?>">
            <i class="fa fa-file-text-o"></i>
            <span>Report</span>
       </a> 
    </li>

</ul>