    <div class="col-md-7 col-sm-7" style="display:inline;padding-left: 0px;">
        <!-- <h1 class="text-center" style="display: inline">
            <small class="text-danger hidden-xs">
                <?php echo e($patient->last_name.', '.$patient->first_name.' '.$middlename=($patient->middle_name)? $patient->middle_name[0].'.' : ''); ?>

            </small>
        </h1> -->
        <button class="btn btn-default menusConsultations btn-sm" title="Click to view patient information" data-toggle="modal" data-target="#patientInfo">
            <i class="fa fa-user-o text-primary"></i>
        </button>
        <button class="btn btn-default menusConsultations btn-sm" data-toggle="modal" data-target="#notification" title="Click to view patients notification">
            <i class="fa fa-bell-o text-primary"></i>
            <?php echo ((count($refferals) + count($followups)) > 0)? '<span class="badgeIcon">'.(count($refferals) + count($followups)).'</span>' : ''; ?>

        </button>


        


        <button class="btn btn-default menusConsultations btn-sm" onclick="medicalRecords(<?php echo e($patient->id); ?>)" title="View medical record's">
            <i class="fa fa-file-text-o text-success"></i>
        </button>


        <!-- smoke incesation -->

        <?php if(Auth::user()->clinic == 8): ?>
            <button class="btn <?php if($smoke): ?> btn-danger <?php else: ?> btn-default <?php endif; ?> menusConsultations btn-sm" data-status="<?php if($smoke): ?> on <?php else: ?> off <?php endif; ?>" title="Smoke Cessation"
                    onclick="smokeInceasation(<?php echo e($patient->id); ?>, $(this))">
                <i class="fa fa-fire <?php if($smoke): ?> text-white <?php else: ?> text-danger <?php endif; ?>"></i>
            </button>
            <a href="<?php echo e(url('diabetes/'.$patient->id)); ?>" class="btn btn-default menusConsultations btn-sm" data-status="" title="Diabetes">
                <i class="fa fa-tint" style="color: #BA4A00"></i>
            </a>
        <?php endif; ?>


    </div>

    <div class="col-md-5 col-sm-5 text-right icd10codes" style="display:inline;padding-right: 0px;">
        <a href="#" class="btn btn-default saveButton menusConsultations btn-sm"
           data-placement="top" data-toggle="tooltip" title="Click to Save this consultation">
            <i class="fa fa-save text-danger"></i>
        </a>
        <?php if(Session::has('cid')): ?>
            <a href="<?php echo e(url('createAnewForm')); ?>" class="btn btn-default menusConsultations btn-sm"
               data-placement="top" data-toggle="tooltip" title="Create a new blank consultation form"
               onclick="return confirm('Create a new blank consultation form?')">
                <i class="fa fa-file-o text-primary"></i>
            </a>
            <a href="<?php echo e(url('print/'.Session::get('cid'))); ?>" class="btn btn-default menusConsultations btn-sm"
               data-placement="top" data-toggle="tooltip" title="Print this consultation form"
               onclick="return confirm('Print this consultation?')" target="_blank">
                <i class="fa fa-print text-success"></i>
            </a>
            
        <?php endif; ?>
        <a href="#" class="btn btn-success icdCodesBtn btn-sm" data-toggle="modal" data-target="#icd10CodeModal">ICD <span class="hidden-xs">10 CODES</span></a>

        <?php if(Auth::user()->clinic == 43): ?>
            <button type="button" class="btn btn-warning icdCodesBtn btn-sm" data-toggle="modal" data-target="#industrialForm">Industrial Form</button>
        <?php endif; ?>

    </div>

