<!-- Sidebar Menu -->

<ul class="sidebar-menu" data-widget="tree">

    <li class="header">
        MAIN NAVIGATION
    </li>
    <li class="@if(Request::is('laboratorypatients')) active @endif">
        <a href="{{ url('laboratorypatients') }}">
            <i class="fa fa-users"></i>
            <span>Patients</span>
        </a>
    </li>
    <li class="@if(Request::is('laboratoryancillarys')) active @endif">
        <a href="{{ url('laboratoryancillarys') }}">
            <i class="fa fa-flask"></i>
            <span>Laboratory</span>
        </a>
    </li>
    <!-- <div > -->
        <li class="header" @if(Request::is('register_report')) hidden @endif>LABELS</li>
        @if(Request::is('laboratorypatients'))
        <li @if(Request::is('register_report')) hidden @endif class="disabled">
            <a href="#" id="patient-information" data-id="#">
                <i class="fa fa-user-o"></i>
                <span>Patient Information</span>
            </a>
        </li>
        <li @if(Request::is('register_report')) hidden @endif class="disabled">
            <a href="#" id="medical-record" data-id="#">
                <i class="fa fa-book"></i>
                <span>Medical Record</span>
            </a>
        </li>
        {{--<li @if(Request::is('register_report')) hidden @endif class="disabled">
            <a href="#" id="patient-transaction" data-id="#">
                <i class="fa fa-id-card-o"></i>
                <span>Transaction</span>
            </a>
        </li>--}}
        @endif
        @if(Request::is('laboratoryancillarys'))
        <li @if(Request::is('register_report')) hidden @endif class="disabled">
            <a href="#" id="service-information" data-id="#">
                <i class="fa fa-info-circle"></i>
                <span>Service Information</span>
            </a>
        </li>
        @endif
    <!-- </div> -->
    <li class="header">OTHERS</li>
    
    <li>
       <a href="{{ url('laboratoryreports') }}">
            <i class="fa fa-file-text-o"></i>
            <span>Report</span>
       </a> 
    </li>

</ul>