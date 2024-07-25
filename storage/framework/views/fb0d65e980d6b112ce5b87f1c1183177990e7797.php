<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPD | Diseases
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
    <link href="<?php echo e(asset('public/css/doctors/diagnosis.css')); ?>" rel="stylesheet" />
    <style media="screen">
    @media  only screen and (max-width: 500px) {
         .icdWrapper{
            padding: 5px 0 0px 0 !important;
        }
    }
    </style>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('doctors.navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('doctors/dashboard'); ?>
<?php $__env->startSection('main-content'); ?>


    <div class="content-wrapper">
        <div class="container-fluid">

            <div class="row icdWrapper">
                <br>
                <h3 class="text-center hidden-xs">International Classification of Diseases</h3>
                <h3 class="text-center visible-xs">ICD 10 Codes</h3>
                <br>
                <div class="row">
                    <div class="col-md-6">
                        <form action="<?php echo e(url('searchICD')); ?>" method="POST" id="icdSearchForm">
                            <?php echo e(csrf_field()); ?>

                            <div class="input-group">
                                <input type="text" name="search" id="search" class="form-control" placeholder="Search ICD By Description..." aria-describedby="basic-addon1">
                                <span class="input-group-addon" id="basic-addon1" onclick="icd('searchActivate')">
                                    <i class="fa fa-search"></i>
                                </span>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <form action="<?php echo e(url('searchICD')); ?>" method="post" id="icdSearchCodeForm">
                            <div class="input-group">
                                <input type="text" name="search" id="search" class="form-control" placeholder="Search ICD By Code..." aria-describedby="basic-addon1">
                                <span class="input-group-addon" id="basic-addon1" onclick="icd('searcCodeActivate')">
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
                    <div class="table-responsive">

                    <table class="table table-striped" id="tableICD">
                        <thead>
                        <tr>
                            <th>#</th>
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
    <script src="<?php echo e(asset('public/js/doctors/icd_codes.js')); ?>"></script>
<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>
