<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPD | Diagnosis Form
    <?php $__env->endSlot(); ?>

<?php $__env->startSection('pagestyle'); ?>
    <link href="<?php echo e(asset('public/plugins/css/jquery-ui.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/doctors/reset.css')); ?>" rel="stylesheet" />
    <?php if(Auth::user()->theme == 2): ?>
        <link href="<?php echo e(asset('public/css/doctors/darkstyle.css')); ?>" rel="stylesheet" />
    <?php else: ?>
        <link href="<?php echo e(asset('public/css/doctors/greenstyle.css')); ?>" rel="stylesheet" />
    <?php endif; ?>
    <link href="<?php echo e(asset('public/plugins/css/dataTables.bootstrap.min.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/doctors/consultation.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/doctors/diagnosis.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>



<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('doctors.navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('doctors/dashboard'); ?>
<?php $__env->startSection('main-content'); ?>


    <div class="content-wrapper">
        <br>
        <br>
        <div class="container-fluid">

            <div class="row diagnosisWrapper">

                <div class="row">
                    <div class="col-md-10">
                        <h2 class="text-center" style="display: inline">
                            DIAGNOSIS FORM <small>Patient Name: <?php echo e($patient->last_name.', '.$patient->first_name.' '.$patient->middle_name[0].'.'); ?></small>
                        </h2>
                    </div>
                    <div class="col-md-2 text-right icd10codes">
                        <a href="#" class="btn btn-default" data-toggle="modal" data-target="#icd10CodeModal">ICD 10 CODES</a>
                    </div>
                </div>

                <form action="<?php echo e(url('diagnosis')); ?>" method="post" id="diagnosisForm">
                    <?php echo e(csrf_field()); ?>

                    <div class="form-group">
                        <textarea name="diagnosis" id="diagnosis" class="my-editor" rows="40"></textarea>
                    </div>

                    <div class="icdsContainer">
                    </div>

                </form>
            </div>



            <div id="icd10CodeModal" class="modal fade" role="dialog">
                <div class="modal-dialog modal-xl">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close closeX" data-dismiss="modal">&times;</button>
                            <h2 class="modal-title text-center">International Classification of Diseases</h2>
                        </div>
                        <div class="modal-body">
                            <div class="row icdWrapper">
                                <div class="row">
                                    <div class="col-md-6">
                                        <form action="<?php echo e(url('searchICD')); ?>" method="POST" id="icdSearchForm">
                                            <?php echo e(csrf_field()); ?>

                                            <div class="input-group">
                                                <input type="text" name="search" id="search" class="form-control" placeholder="Search ICD By Description..." aria-describedby="basic-addon1">
                                                <span class="input-group-addon" id="basic-addon1">
                                                        <i class="fa fa-search"></i>
                                                    </span>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-6">
                                        <form action="<?php echo e(url('searchICD')); ?>" method="post" id="icdSearchCodeForm">
                                            <div class="input-group">
                                                <input type="text" name="search" id="search" class="form-control" placeholder="Search ICD By Code..." aria-describedby="basic-addon1">
                                                <span class="input-group-addon" id="basic-addon1">
                                                        <i class="fa fa-search"></i>
                                                    </span>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <br>
                                <div class="">
                                    <p class="text-right text-primary">Total of <span class="totalICDS"></span> Results Found...</p>
                                    <div class="loaderWrapper">
                                        <img src="<?php echo e(asset('public/images/loader.svg')); ?>" alt="Loader" class="img-responsive center-block" />
                                        <p>Loading...</p>
                                    </div>
                                    <table class="table table-striped" id="tableICD">
                                        <thead>
                                        <tr>
                                            <th><i class="fa fa-question"></i></th>
                                            <th>CODE</th>
                                            <th>DESCRIPTION</th>
                                        </tr>
                                        </thead>
                                        <tbody id="icdTbody">
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3" class="text-center" id="paginator">
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>

                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary" class="close" data-dismiss="modal">OK <i class="fa fa-check"></i></button>
                        </div>
                    </div>

                </div>
            </div>







        </div>
    </div> <!-- .content-wrapper -->




<?php $__env->stopSection(); ?>
<?php echo $__env->renderComponent(); ?>
<?php $__env->stopSection(); ?>





<?php $__env->startSection('footer'); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('pagescript'); ?>
    <?php echo $__env->make('message.toaster', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <script src="<?php echo e(asset('public/plugins/js/form.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/modernizr.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/jquery.menu-aim.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/doctors/main.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/dataTables.bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/tinymce/tinymce.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/doctors/diagnosiseditor.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/doctors/diagnosis.js')); ?>"></script>
<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>
