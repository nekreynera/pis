<div class="modal" id="notifications_modal">

    <div class="modal-dialog">


        @include('OPDMS.partials.loader') {{-- loader icon --}}


        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-primary text-uppercase">@{{ p_name }}</h4>
            </div>
            <div class="modal-body">
                <ul class="list-group">
                    <li class="list-group-item bg-gray text-center">
                        <strong>Notifications</strong>
                    </li>
                    {{-- last consultation --}}
                    <li class="list-group-item list-group-item-success">
                        <label>Last Consultation</label>
                        <div v-if="ls_main_div"> {{-- show if last consultation exits --}}
                            <small>Consultation date:</small>
                            <small>@{{ lc_date }}</small><br> {{-- vue js--}}
                            <small>Consulted by:</small>
                            <small class="text-uppercase">@{{ lc_doctor }}</small>
                        </div>
                        <p v-else class="text-red small">This patient has no saved consultation at this clinic.</p>
                    </li>
                    {{-- follow-up --}}
                    <li class="list-group-item list-group-item-info">
                        <label>Follow-up</label> <br>
                        <div v-if="ff_main_div"> {{-- show if Scheduled today for follow --}}
                            <small>Scheduled today for follow-up</small> <br>
                            <small>Follow-up to:</small>
                            <small>@{{ ff_doctor }}</small>
                        </div>
                        <p v-else class="text-red small">This patient has no scheduled follow-up today.</p>
                    </li>
                    {{-- referrals --}}
                    <li class="list-group-item list-group-item-warning">
                        <label>Referral</label> <br>
                        {{-- show if referrals exist--}}
                        <div v-if="rr_main_div">
                            <div v-for="refferal in refferal_notifications">
                                <small>Referral Date:</small>
                                <small>@{{ refferal.ref_date }}</small>
                                <br>
                                <small>Referral from:</small>
                                <small>@{{ refferal.rf_clinic }}</small>
                                <br>
                                <small class="text-uppercase">Referred by:</small>
                                <small class="text-uppercase">
                                    DR. @{{ refferal.rb_last_name }} @{{ refferal.rb_first_name }}
                                </small>
                                <div v-if="refferal.rt_last_name"> {{-- show if referred to specific doctor exist--}}
                                    <small>Referred to:</small>
                                    <small class="text-uppercase">
                                        DR. @{{ refferal.rt_last_name }} @{{ refferal.rt_first_name }}
                                    </small>
                                </div>
                                <hr>
                            </div>
                        </div>
                        <p v-else class="text-red small">This patient has no referral from other clinics.</p>
                    </li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-flat btn-default pull-left" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>