<?php $__env->startComponent('OPDMS.partials.header'); ?>


<?php $__env->slot('title'); ?>
    OPD | LABORATORY
<?php $__env->endSlot(); ?>


<?php $__env->startSection('pagestyle'); ?>
    <link href="<?php echo e(asset('public/OPDMS/css/patients/main.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/OPDMS/css/laboratory/main.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/OPDMS/css/laboratory/patient/action.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/OPDMS/css/patients/medical_records.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/OPDMS/css/laboratory/patient/new.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/OPDMS/css/laboratory/patient/logs.css')); ?>" rel="stylesheet" />

    <!-- for transaction modal -->
    <link href="<?php echo e(asset('public/OPDMS/css/laboratory/laboratory/sub.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/OPDMS/css/laboratory/laboratory/infolist.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/OPDMS/css/patients/patient_information.css')); ?>" rel="stylesheet" />
    <!-- <link href="<?php echo e(asset('public/OPDMS/css/patients/print_patient.css')); ?>" rel="stylesheet" /> -->
    
<?php $__env->stopSection(); ?>


<?php $__env->startSection('navigation'); ?>
    <?php echo $__env->make('OPDMS.partials.boilerplate.navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('dashboard'); ?>
    <?php $__env->startComponent('OPDMS.partials.boilerplate.dashboard'); ?>
    <?php echo $__env->renderComponent(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" id="main-page">

        <?php echo $__env->make('OPDMS.partials.boilerplate.header',
        ['header' => 'Patients List', 'sub' => 'All queued patients will be shown here.'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <!-- Main content -->
        <section class="content">

            <div class="box">
                <div class="box-header with-border">
                  <div class="row action-div">
                    <?php echo $__env->make('OPDMS.laboratory.action.patient', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                  </div>
                </div>
                <div class="box-body">
                    <?php echo $__env->make('OPDMS.partials.loader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    <?php 
                        $pending=0;
                        $done=0;
                        $removed=0;
                    ?>
                    <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($list->status == 'P'): ?>
                            <?php $pending+=1 ?>
                        <?php endif; ?>
                        <?php if($list->status == 'F'): ?>
                            <?php $done+=1 ?>
                        <?php endif; ?>
                        <?php if($list->status == 'R'): ?>
                            <?php $removed+=1 ?>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <div class="text-right queing-status-button">
                        <button class="btn btn-warning btn-flat btn-xs" id="selected" data="P"><small class="label bg-black" id="pending-badge"><?php echo e($pending); ?></small>&nbsp; Pending</button>
                        <button class="btn btn-info btn-flat btn-xs" data="F"><small class="label bg-black" id="done-badge"><?php echo e($done); ?></small>&nbsp; Done</button>
                        <button class="btn btn-danger btn-flat btn-xs" data="R"><small class="label bg-black" id="removed-badge"><?php echo e($removed); ?></small>&nbsp; Removed</button>
                        <button class="btn btn-default btn-flat btn-xs" data="ALL"><small class="label bg-black" id="all-badge"><?php echo e(count($patients)); ?></small>&nbsp; All</button>
                    </div>
                    <div class="table-responsive" style="max-height: 350px;">
                        <table class="table table-striped table-hover" id="patient-table">
                            <thead>
                                <tr class="bg-gray">
                                    <th></th>
                                    <th><span class="fa fa-user-o"></span></th>
                                    <th>ID No</th>
                                    <th>Patient Name</th>
                                    <th>Age</th>
                                    <th>Gender</th>
                                    <th>Status</th>
                                    <th>Datetime Queued</th>
                                </tr>
                            </thead>
                            <tbody class="queued-patient-tbody">
                                <?php if(count($patients) > 0): ?>
                                    <!-- <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <tr data-id="<?php echo e($patient->id); ?>">
                                            <td><span class="fa fa-caret-right"></span></td>
                                            <td class="text-center"><span class="fa fa-user-o"></span></td>
                                            <td class="text-center"><?php echo e($patient->hospital_no); ?></td>
                                            <td><?php echo e($patient->last_name.', '.$patient->first_name.' '.substr($patient->middle_name, 0, 1).'.'); ?></td>
                                            <td class="text-center <?php if(App\Patient::age($patient->birthday) > 59): ?> text-red text-bold <?php endif; ?>"><?php echo e(App\Patient::age($patient->birthday)); ?></td>
                                            <td class="text-center"><?php echo e(($patient->sex == 'M')?'Male':'Female'); ?></td>
                                            <?php 
                                            $color = 'bg-yellow';
                                            $status = 'Pending';
                                            if($patient->status == 'F'):
                                            $status = 'Done';
                                            $color = 'bg-aqua';
                                            elseif($patient->status == 'R'):
                                            $status = 'Removed';
                                            $color = 'bg-red';
                                            endif
                                            ?>


                                            <td class="text-center"><span class="label <?php echo e($color); ?> active"><?php echo e($status); ?></span></td>
                                            <td class="text-center"><?php echo e(Carbon::parse($patient->created_at)->format('m/d/Y h:i a')); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> -->
                                <?php else: ?>
                                    <tr>
                                        <td height></td>
                                        <td></td>
                                        <td colspan="6" class="text-center"><span class="fa fa-warning"></span> EMPTY DATA</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                </div>

                <div class="box-footer">
                    <small>
                        <em class="text-muted">
                            <?php if(count($request->post()) > 0): ?>
                              Showing <b> <?php echo e(count($patients)); ?> search result(s).</b> 
                            <?php else: ?>  
                              Showing <b> <?php echo e(count($patients)); ?> </b>
                            <?php endif; ?>
                            of <?php echo e(count(App\LaboratoryQueues::whereDate('created_at', '=', Carbon::today())->get())); ?> queued patient(s) today.
                        </em>
                    </small>
                </div>
            </div>

        </section>
        <!-- /.content -->
    </div>
    <?php echo $__env->make('OPDMS.laboratory.modals.patient.scan', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('OPDMS.laboratory.modals.patient.new', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('OPDMS.laboratory.modals.patient.undone', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('OPDMS.laboratory.modals.patient.patients', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('OPDMS.laboratory.modals.patient.request_form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('OPDMS.laboratory.modals.patient.doctor', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('OPDMS.laboratory.modals.patient.new_doctor', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('OPDMS.laboratory.modals.alert', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('OPDMS.patients.modals.patient_information', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('OPDMS.patients.modals.medical_records', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <!-- /.content-wrapper -->
<?php $__env->stopSection(); ?>





<?php $__env->startSection('aside'); ?>
    <?php echo $__env->make('OPDMS.partials.boilerplate.aside', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('pluginscript'); ?>
  
<?php $__env->stopSection(); ?>
<?php 
    // 
 ?>

<?php $__env->startSection('pagescript'); ?>
    <?php if(!$alert): ?>
    <script>
            $("#alertModal").modal({backdrop: "static"});
    </script>
    <?php else: ?>
        <script>
            $("#alertModal").modal('hide');
        </script>
    <?php endif; ?>
    <script>
        var dateToday = '<?php echo e(Carbon::today()->format("m/d/Y")); ?>';
    </script>
    <script src="<?php echo e(asset('public/OPDMS/js/laboratory/main.js?v2.0.1')); ?>"></script>
    <script src="<?php echo e(asset('public/OPDMS/js/laboratory/patient/main.js?v2.0.1')); ?>"></script>
    <script src="<?php echo e(asset('public/OPDMS/js/laboratory/patient/action.js')); ?>"></script>
    <script src="<?php echo e(asset('public/OPDMS/js/laboratory/patient/scan.js')); ?>"></script>
    <script src="<?php echo e(asset('public/OPDMS/js/laboratory/patient/transaction.js?v1.0.7')); ?>"></script>
    <script src="<?php echo e(asset('public/OPDMS/js/laboratory/patient/list.js')); ?>"></script>
    <script src="<?php echo e(asset('public/OPDMS/js/laboratory/patient/sub.js')); ?>"></script>
    <script src="<?php echo e(asset('public/OPDMS/js/patients/table.js?v2.0.1')); ?>"></script>
    <script src="<?php echo e(asset('public/OPDMS/js/laboratory/patient/table.js?v2.0.1')); ?>"></script>
    <script src="<?php echo e(asset('public/OPDMS/js/laboratory/patient/view.js')); ?>"></script>
    <script src="<?php echo e(asset('public/OPDMS/js/laboratory/patient/search.js')); ?>"></script>
    <script src="<?php echo e(asset('public/OPDMS/js/laboratory/patient/logs.js')); ?>"></script>
    <script src="<?php echo e(asset('public/OPDMS/js/patients/patient_information.js')); ?>"></script>
    <script src="<?php echo e(asset('public/OPDMS/js/patients/medical_record.js')); ?>"></script>

   
    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2();

            $(window).load(function(){
                $('body').attr('oncontextmenu', 'return false');
            })

        });
        var patient_queued = '<?php echo e(json_encode($patients)); ?>';
        var json_patient_queued = JSON.parse(patient_queued.replace(/&quot;/g, '"'));
        appendqueuedpatientstotable(json_patient_queued, status = 'ALL');

    </script>

<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>