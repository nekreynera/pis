<div id="medRecordsModal" class="modal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-center">Medical Records</h4>
            </div>
            <div class="modal-body">
                <br>

                <div class="loaderWrapper col-md-2 bg-danger text-center">
                    <img src="{{ asset('public/images/loader.svg') }}" alt="loader" class="img-responsive" />
                    <p>Please Wait...</p>
                </div>

                <div class="list-group">
                    <a href="#" class="list-group-item disabled text-center">Patient Name: <strong class="approvalPatientName text-danger"></strong></a>

                    <a href="#" class="list-group-item recordsList" id="checkConsultation"
                       data-pid="" onclick="checkConsultation($(this))">
                        Consultations <span class="badge consultationBadge"></span></a>

                    <a href="#" class="list-group-item recordsList" id="checkRequisition" data-title="Medicine Records"
                       data-pid="" onclick="checkRequisition($(this))">
                        Medicines <span class="badge requisitionBadge"></span></a>


                    @if(Auth::user()->clinic == 3)
                        <a href="#" class="list-group-item recordsList" id="checkDental" data-title="Dental Requests"
                           data-category="5" data-pid="" onclick="checkRadiology($(this))">
                            Dental <span class="badge dentalBadge"></span>
                        </a>
                    @endif

                    <a href="#" class="list-group-item recordsList" id="checkLaboratory" data-title="Laboratory Records"
                       data-category="10" data-pid="" onclick="checklaboratory($(this))">
                        Laboratory <span class="badge laboratoryBadge"></span></a>

                    <a href="#" class="list-group-item recordsList" id="checkUltrasound" data-title="Ultrasound Records"
                       data-category="6" data-pid="" onclick="checkRadiology($(this))">
                        Ultrasound <span class="badge ultrasoundBadge"></span></a>

                    <a href="#" class="list-group-item recordsList" id="checkXRAY" data-title="X-Ray Records"
                       data-category="11" data-pid="" onclick="checkRadiology($(this))">
                        X-Ray <span class="badge xrayBadge"></span></a>

                    <a href="#" class="list-group-item recordsList" id="checkRefferals"
                       data-pid="" onclick="checkRefferals($(this))">
                        Refferals <span class="badge refferalBadge"></span></a>

                    <a href="#" class="list-group-item recordsList" id="checkFollowups"
                       data-pid="" onclick="checkFollowups($(this))">
                        Follow-Up <span class="badge followupBadge"></span></a>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>