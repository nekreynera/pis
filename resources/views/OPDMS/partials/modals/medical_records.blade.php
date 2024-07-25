<div class="modal" id="medical_records_modal">

    <div class="modal-dialog modal-lg">




        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-primary text-uppercase">@{{ p_name }}</h4>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-3">
                        <div class="list-group">
                            <a href="" class="list-group-item active"
                            v-on:click.prevent="consultation_records">
                                Consultations
                                <span class="badge">3</span>
                            </a>
                            <a href="#" class="list-group-item">
                                Other Forms
                                <span class="badge">3</span>
                            </a>
                            <a href="#" class="list-group-item">
                                Ultrasound
                                <span class="badge">3</span>
                            </a>
                            <a href="#" class="list-group-item">
                                X-ray
                                <span class="badge">3</span>
                            </a>
                            <a href="#" class="list-group-item">
                                Laboratory Requests
                                <span class="badge">3</span>
                            </a>
                            <a href="" class="list-group-item"
                            v-on:click.prevent="referral_records">
                                Referrals
                                <span class="badge">3</span>
                            </a>
                            <a href="" class="list-group-item"
                               v-on:click.prevent="followup_records">
                                Follow-up
                                <span class="badge">3</span>
                            </a>
                        </div>
                    </div>

                    <div class="col-md-9">

                        @include('OPDMS.partials.loader') {{-- loader icon --}}

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th v-for="row in medical_records_thead">
                                            @{{ row }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="medical_records_tbody">
                                </tbody>
                            </table>
                        </div>


                    </div>

                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-flat btn-default pull-left" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>