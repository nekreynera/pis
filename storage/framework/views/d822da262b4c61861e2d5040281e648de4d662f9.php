<!-- Sidebar Menu -->

<ul class="sidebar-menu" data-widget="tree">

    <li class="header">
        MAIN NAVIGATION
    </li>
    <li class="<?php if(Request::is('laboratorypatients')): ?> active <?php endif; ?>">
        <a href="<?php echo e(url('laboratorypatients')); ?>">
            <i class="fa fa-users"></i>
            <span>Patients</span>
        </a>
    </li>
    <li class="<?php if(Request::is('laboratoryancillarys')): ?> active <?php endif; ?>">
        <a href="<?php echo e(url('laboratoryancillarys')); ?>">
            <i class="fa fa-flask"></i>
            <span>Laboratory</span>
        </a>
    </li>
    <!-- <div > -->
        <li class="header" <?php if(Request::is('register_report')): ?> hidden <?php endif; ?>>LABELS</li>
        <?php if(Request::is('laboratorypatients')): ?>
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
        
        <?php endif; ?>
        <?php if(Request::is('laboratoryancillarys')): ?>
        <li <?php if(Request::is('register_report')): ?> hidden <?php endif; ?> class="disabled">
            <a href="#" id="service-information" data-id="#">
                <i class="fa fa-info-circle"></i>
                <span>Service Information</span>
            </a>
        </li>
        <?php endif; ?>
    <!-- </div> -->
    <li class="header">OTHERS</li>
    
    <li>
       <a href="<?php echo e(url('laboratoryreports')); ?>">
            <i class="fa fa-file-text-o"></i>
            <span>Report</span>
       </a> 
    </li>

</ul>