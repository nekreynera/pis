<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPD | Pedia Queuing
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

        <br>

        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <form action="<?php echo e(url('pediaSearchPatient')); ?>" method="get" id="pediaSearchPatient">
                    <?php echo e(csrf_field()); ?>

                    <div class="input-group">
                        <input type="text" name="search" class="form-control" value="<?php echo e($data['search']); ?>" placeholder="Search Patient..." aria-describedby="basic-addon1">
                        <span class="input-group-addon" id="basic-addon1"
                              onclick="document.getElementById('pediaSearchPatient').submit()"
                              title="Click to search">
                        <i class="fa fa-search"></i>
                    </span>
                    </div>
                    <small><em class="text-muted"> Enter patient name, hospital no, barcode or date registered. Ex: Santos Juan</em></small>
                </form>
            </div>
        </div>


        <hr>



        <?php if(!$data['search']): ?>
            <div class="alert alert-info text-center">
                <strong>Please use the search form to retrieve patients.</strong>
            </div>
        <?php else: ?>


            <?php if($data['queuings']->isEmpty()): ?>

                <div class="alert alert-danger text-center">
                    <strong>Sorry! No Patients Found.</strong>
                </div>


            <?php else: ?>


                <div class="row">



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
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php $__currentLoopData = $data['queuings']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($loop->index + 1); ?></td>
                                    <td>
                                        <strong class="text-capitalize text-info">
                                            <?php echo e($row->last_name.', '.$row->first_name.' '.$row->suffix.' '.$row->middle_name); ?>

                                        </strong>
                                    </td>
                                    <td>
                                        <?php $age = App\Patient::age($row->birthday); ?>
                                        <?php if($age >= 60): ?>
                                            <strong class="text-danger">
                                                <?php echo e($age); ?>

                                            </strong>
                                        <?php else: ?>
                                            <?php echo e($age); ?>

                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-default btn-circle patient_info" data-pid="<?php echo e($row->id); ?>">
                                            <i class="fa fa-user-o"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn btn-default btn-circle" onclick="showPediaForms(<?php echo e($row->id); ?>)">
                                            <i class="fa fa-file-o"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn btn-default btn-circle"
                                                onclick="medicalRecords(<?php echo e($row->id); ?>)" title="View medical record's">
                                            <i class="fa fa-file-text-o text-primary"></i>
                                        </button>
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
                                                    <a href="<?php echo e(url('otpc_homepage/'.$row->id)); ?>" target="_blank">
                                                        Therapeutic Care
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo e(url('childhood_care/'.$row->id)); ?>" target="_blank">
                                                        Childhood Care
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo e(url('kmc/'.$row->id)); ?>" target="_blank">
                                                        KMC (Kangaroo Mother Care Program)
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </tbody>

                            <tfoot>
                                <tr>
                                    <td colspan="9" class="text-center">
                                        <?php echo e($data['queuings']->appends(['search' => $data['search'] ])->links()); ?>

                                    </td>
                                </tr>
                            </tfoot>

                        </table>
                    </div>

                </div>

            <?php endif; ?>






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
