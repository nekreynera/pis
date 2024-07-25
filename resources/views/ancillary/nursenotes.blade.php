
<link href="{{ asset('public/css/receptions/nursenotes.css') }}" rel="stylesheet" />

<div id="z-nursenotes-modal" class="modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content" style="text-align: left!important;">
      <div class="modal-body">

        <div class="row">
            <div class="col-md-6">
                <h3>
                    <small class="patient-name">Patient Name:</small>
                </h3>
            </div>
            <div class="col-md-6">
                <h3 class="text-right titleWrapper">
                    Write Nurse Notes
                    <button type="submit" form="consultationForm" onclick="return confirm('Save this nurse notes?')"
                            class="btn btn-default iconsNurse save-nurse-notes" data-placement="top" data-toggle="tooltip" title="Click to save nurse notes" >
                        <i class="fa fa-save text-danger"></i>
                    </button>
                    <a href="/?#" target="_blank" class="btn btn-default iconsNurse"
                       data-placement="top" data-toggle="tooltip" title="Print this consultation" >
                        <i class="fa fa-print text-success"></i>
                    </a>
                </h3>
            </div>
        </div>

            <input type="hidden" name="cid">
            <div class="form-group">
                <textarea name="consultation" id="diagnosis2" class="my-editor" rows="40"></textarea>
            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><span class="fa fa-remove"></span> Close</button>
          </div>
        </div>

      </div>
    </div>
</div>

