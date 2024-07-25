<div class="modal" id="consultation_show_modal">

    <div class="modal-dialog modal-lg">


        @include('OPDMS.partials.loader') {{-- loader icon --}}


        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-primary text-uppercase">@{{ p_name }}</h4>
                <a href="" class="btn btn-flat bg-green">Open All Consultations <i class="fa fa-eye"></i></a>
                <a href="" class="btn btn-flat btn-info">Print <i class="fa fa-print"></i></a>
                <a v-bind:href="create_nurse_notes_link" class="btn btn-flat bg-navy"
                   v-if="create_nurse_notes">Write Nurse Notes
                    <i class="fa fa-pencil"></i>
                </a>
                <a v-bind:href="edit_consultation_link" class="btn btn-flat bg-blue"
                   v-if="edit_consultation">Edit Consultation
                    <i class="fa fa-pencil"></i>
                </a>
                <br>
                <small>
                    <em class="text-muted">Clinic:</em> @{{ consultation_clinic_name | capitalize  }} |
                    <em class="text-muted">Consulted / Assisted by:</em> @{{ consultation_consulted_by | capitalize  }} |
                    <em class="text-muted">Consulted Date:</em> @{{ consultation_date | capitalize  }}
                </small>
            </div>
            <div class="modal-body">
                <div id="consultation_show_wrapper">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-flat btn-default pull-left" data-dismiss="modal">Close</button>
                <small class="text-muted">
                    Only the doctor who created this consultation are allowed to edit.
                </small>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>