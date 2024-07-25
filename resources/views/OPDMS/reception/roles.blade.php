<!-- Sidebar Menu -->

<ul class="sidebar-menu" data-widget="tree">


     {{--dashboard header title--}}
    <li class="header action_buttons">
        Action Buttons <i v-if="spinner_action_btn" class="fa fa-spinner fa-spin text-green"></i>
    </li>

    <li v-if="patient_selected">
        <a href="" v-on:click.prevent="patient_information">
            <i class="fa fa-user-o"></i>
            <span>Patient Information</span>
        </a>
    </li>
    <li v-if="patient_selected">
        <a href="" v-on:click.prevent="consultation_records">
            <i class="fa fa-file-text-o"></i>
            <span>Medical Records</span>
        </a>
    </li>
    <li v-if="patient_selected">
        <a href="" v-on:click.prevent="write_nurse_notes">
            <i class="fa fa-file-text-o"></i>
            <span>Nurse Notes</span>
        </a>
    </li>
    <li v-if="patient_selected">
        <a href="" v-on:click.prevent="patient_notification">
            <i class="fa fa-bell-o"></i> <span>Notifications</span>
            <span class="pull-right fa fa-circle text-yellow" v-if="rr_notification_show"
            title="Referrals"></span>
            <span class="pull-right fa fa-circle text-blue" v-if="ff_notification_show"
            title="Today`s Follow-up"></span>
            <span class="pull-right fa fa-circle text-green" v-if="ls_notification_show"
            title="Last Consultation"></span>
        </a>
    </li>
    <li v-if="assignations">
        <a href="" v-on:click.prevent="patient_assignation">
            <i class="fa fa-arrow-left"></i>
            <span>Assignations</span>
        </a>
    </li>
    <li v-if="re_assign">
        <a href="" v-on:click.prevent="patient_re_assignation">
            <i class="fa fa-arrow-left"></i>
            <span>Re-assign</span>
        </a>
    </li>
    <li v-if="nawc">
        <a href="" v-on:click.prevent="remove_queued_patient">
            <i class="fa fa-trash-o"></i>
            <span>NAWC</span>
        </a>
    </li>



    {{-- dashboard header title --}}
    <li class="header">Main</li>


    <li class="treeview">
        <a href="#"><i class="fa fa-shield"></i> <span>Admin</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
        </a>
        <ul class="treeview-menu">
            <li class="">
                <a href="{{ url('register') }}">
                    <i class="fa fa-user-plus"></i>
                    Add User
                </a>
            </li>
            <li class="">
                <a href="{{ url('users') }}">
                    <i class="fa fa-user-circle"></i>
                    Userlist
                </a>
            </li>
        </ul>
    </li>





</ul>