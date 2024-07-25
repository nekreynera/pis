<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        PIS | Pedia Queuing
    <?php $__env->endSlot(); ?>

<?php $__env->startSection('pagestyle'); ?>
    <link href="<?php echo e(asset('public/plugins/css/dataTables.bootstrap.min.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/doctors/patientlist.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/nurse/pedia/queuingTable.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/partials/patient_info.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>


<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('nurse.pedia.navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>


    <div class="container">


        <?php echo $__env->make('doctors.medicalRecords', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('doctors.ajaxConsultationList', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('doctors.ajaxRequisitionList', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('doctors.ajaxRefferals', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('doctors.ajaxFollowup', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('doctors.requisition.medsWatch', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('doctors.records.radiology', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('ancillary.chargingmodal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('ancillary.loader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>




        <?php echo $__env->make('partials.patient_info', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <?php echo $__env->make('nurse.pedia.form_records', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


        <?php if($queuings->isEmpty()): ?>

            <br>
            <br>
            <br>
            <div class="alert alert-danger text-center">
                <strong>
                    No Patients On Queued <i class="fa fa-warning"></i>
                </strong>
            </div>


        <?php else: ?>

            <br>

        <div class="table-responsive">
            <table class="table table-bordered table-condensed" id="queuingTable">
                <thead>
                    <tr>
                        <th>No. #</th>
                        <th>Patient Name</th>
                        <th>Age</th>
                        <th>Patient Info</th>
                        <th>Forms</th>
                        <th>Records</th>
                        <th>Assigned Doctor</th>
                        <th>Action</th>
                        <th>Status</th>
                        <th>Timestamp</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $queuings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $queuing): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <?php echo e($loop->index + 1); ?>

                        </td>
                        <td class="text-uppercase">
                            <strong class="text-info"><?php echo e($queuing->ptLastName.', '.$queuing->ptFirstName.' '.$queuing->ptSuffix.' '.$queuing->ptMiddleName); ?></strong>
                        </td>
                        <td>
                            <?php $age = App\Patient::age($queuing->birthday); ?>
                                <?php if($age >= 60): ?>
                                    <strong class="text-danger">
                                        <?php echo e($age); ?>

                                    </strong>
                                <?php else: ?>
                                    <?php echo e($age); ?>

                                <?php endif; ?>
                        </td>
                        <td>
                            <button class="btn btn-default btn-circle patient_info" data-pid="<?php echo e($queuing->patients_id); ?>">
                                <i class="fa fa-user-o"></i>
                            </button>
                        </td>
                        <?php
                        if ($queuing->status == 'F'){
                            $className = 'bg-blue';
                            $statusText = 'Finished';
                        }elseif ($queuing->status == 'P'){
                            $className = 'bg-orange';
                            $statusText = 'Pending';
                        }elseif ($queuing->status == 'H'){
                            $className = 'bg-brown';
                            $statusText = 'Paused';
                        }elseif ($queuing->status == 'C'){
                            $className = 'bg-red';
                            $statusText = 'NAWC';
                        }elseif ($queuing->status == 'S'){
                            $className = 'bg-green';
                            $statusText = 'Serving';
                        }else{
                            $className = 'bg-purple';
                            $statusText = 'Unassigned';
                        }
                        ?>
                        <td>
                            <button class="btn btn-default btn-circle" onclick="showPediaForms(<?php echo e($queuing->patients_id); ?>)">
                                <i class="fa fa-file-o"></i>
                            </button>
                        </td>
                        <td>
                            <button class="btn btn-default btn-circle"
                                    onclick="medicalRecords(<?php echo e($queuing->patients_id); ?>)" title="View medical record's">
                                <i class="fa fa-file-text-o text-primary"></i>
                            </button>
                        </td>
                        <td class="text-uppercase">
                            <?php if($queuing->doctors_id): ?>
                                <strong class="text-info">
                                    DR. <?php echo e($queuing->last_name.', '.$queuing->first_name.' '.$queuing->suffix.' '.$queuing->middle_name); ?>

                                </strong>
                            <?php else: ?>
                                <strong class="text-danger">
                                    None
                                </strong>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-default dropdown-toggle" type="button" id="dropdownMenu1"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    Pediatric Forms
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li>
                                        <a href="<?php echo e(url('otpc_homepage/'.$queuing->patients_id)); ?>" target="_blank">
                                            Therapeutic Care
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo e(url('childhood_care/'.$queuing->patients_id)); ?>" target="_blank">
                                            Childhood Care
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo e(url('kmc/'.$queuing->patients_id)); ?>" target="_blank">
                                            KMC (Kangaroo Mother Care Program)
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                        <td class="<?php echo e($className); ?>">
                            <?php echo e($statusText); ?>

                        </td>
                        <td>
                            Today <?php echo e(Carbon::parse($queuing->created_at)->format('h:i:s')); ?>

                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="10" class="text-center">
                            <?php echo e($queuings->links()); ?>

                        </td>
                    </tr>
                </tfoot>
            </table>

        </div>


        <?php endif; ?>

    </div>

<?php $__env->stopSection(); ?>



<?php $__env->startSection('footer'); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('pagescript'); ?>

    <?php echo $__env->make('message.toaster', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <script src="<?php echo e(asset('public/plugins/js/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/dataTables.bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/partials/patient_info.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/nurse/pedia/form_records.js')); ?>"></script>

    <script src="<?php echo e(asset('public/js/doctors/ajaxRecords.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/receptions/consultation.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/results/master.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/results/medsWatch.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/results/ultrasound.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/results/radiologyQuickView.js')); ?>"></script>

    <script>
        $('#queuingTable').dataTable({
            language: {
                searchPlaceholder: "Filter Patients"
            },
            bPaginate: false,
            bInfo: false
        });
    </script>
    <?php echo $__env->make('receptions.message.notify', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>
