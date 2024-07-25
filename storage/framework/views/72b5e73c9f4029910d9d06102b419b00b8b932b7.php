
<link href="<?php echo e(asset('public/css/receptions/nursenotes.css')); ?>" rel="stylesheet" />
<link href="<?php echo e(asset('public/css/doctors/preview.css')); ?>" rel="stylesheet" />

<!-- Open to all -->
<input type="hidden" name="pid" class="hidden-id"/>
<!--  -->


<div id="chiefcomplaint-modal" class="modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content" style="text-align: left!important;">
      <div class="modal-body" style="height: 1000px; overflow: auto">
        <div class="row">
            <div class="container-fluid chiefcomplaintpart" style="display: none;">
                <div class="container">

                    <div class="row">
                        <div class="col-md-6">
                            <h3>
                                <small class="patient-name">Patient Name:</small>
                            </h3>
                        </div>
                    </div>

                    <form id="consultationForm">
                        <div class="form-group">
                            <textarea name="consultation" id="diagnosis" class="my-editor" rows="65" style="height: 200px"></textarea>
                        </div>
                    </form>

                </div>
            </div>
          </div>
            <div class="container rcptn" style="display: none">
                <div class="row">
                    <br>
                    <div class="row">
                        <div class="col-md-9">
                            <h2 class="text-left" style="margin: 0">Consultation Details</h2>
                        </div>
                        <div class="col-md-3 text-right">
                            <a href="/?#" target="_blank" class="btn btn-default text-success btn-print-notes">
                                <i class="fa fa-print text-success"></i> <span class="text-success">Print</span>
                            </a>
                            <a href="/?#" class="btn btn-default btn-nurse-notes btn-writenotes-modal">
                                <i class="fa fa-pencil text-danger"></i> <span class="text-danger">Write Nurse Notes</span>
                            </a>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th class="col-md-4">Last Name:</th>
                                    <td class="rcptn-lastname"></td>
                                </tr>
                                <tr>
                                    <th>Given Name:</th>
                                    <td class="rcptn-firstname"></td>
                                </tr>
                                <tr>
                                    <th>Civil Status:</th>
                                    <td class="rcptn-civilstatus"></td>
                                </tr>
                                <tr>
                                    <th>Address:</th>
                                    <td class="rcptn-address"></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th class="col-md-4">Middle Name:</th>
                                    <td class="rcptn-middlename"></td>
                                </tr>
                                <tr>
                                    <th>Birthday:</th>
                                    <td class="rcptn-birthday"></td>
                                </tr>
                                <tr>
                                    <th>Age:</th>
                                    <td class="rcptn-age"></td>
                                </tr>
                                <tr>
                                    <th>Contact No:</th>
                                    <td class="rcptn-contact"></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-12">

                            <div class="table-responsive rcptn-consultation-show">
                            </div>

                            <div class="diagnosisWrapper" style="display: none;">
                                <br>
                                <h2 class="">International Classification of Diseases</h2>
                                <br>
                                <div class="icd_codes"></div>
                            </div>
                            <div class="upload_files"></div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><span class="fa fa-remove"></span> Close</button>
          </div>

      </div>
    </div>
</div>

<input type="hidden" id="baseurl-tinymce" value="<?php echo e(url('')); ?>">

<!-- USED FOR CHIEF COMPLAINT -->
<script src="<?php echo e(asset('public/plugins/js/tinymce/tinymce.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/js/doctors/richtexteditor.js')); ?>"></script>
<script src="<?php echo e(asset('public/plugins/js/preventDelete.js')); ?>"></script>
<!--  -->