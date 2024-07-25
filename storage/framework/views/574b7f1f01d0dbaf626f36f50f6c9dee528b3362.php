<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <meta http-equiv="Expires" CONTENT="0">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="Pragma" CONTENT="no-cache">

    <title><?php echo e(isset($title) ? $title : 'OPDMS'); ?></title>



    <!-- Styles -->
    <link href="<?php echo e(asset('public/OPDMS/plugins/bootstrap/bootstrap.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/OPDMS/plugins/font-awesome/font-awesome.min.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/OPDMS/plugins/toastr/toastr.min.css')); ?>" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo e(asset('public/OPDMS/plugins/jquery-ui/jquery-ui.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('public/AdminLTE/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('public/AdminLTE/bower_components/Ionicons/css/ionicons.min.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('public/AdminLTE/plugins/iCheck/all.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('public/AdminLTE/bower_components/select2/dist/css/select2.min.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('public/AdminLTE/dist/css/AdminLTE.min.css')); ?>"> <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo e(asset('public/AdminLTE/dist/css/skins/_all-skins.min.css')); ?>" />




    <link href="<?php echo e(asset('public/OPDMS/css/master.css')); ?>" rel="stylesheet" />

    <!-- Load page style -->
    <?php echo $__env->yieldContent('pagestyle'); ?>


</head>


<body class="hold-transition skin-green sidebar-mini fixed">

    <div class="wrapper">


        <?php echo $__env->make('OPDMS.partials.full_window_loader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 


        
        <?php echo $__env->yieldContent('vue-container-start'); ?>


        <?php echo $__env->yieldContent('navigation'); ?>


        <?php echo $__env->yieldContent('dashboard'); ?>


        <?php echo $__env->yieldContent('content'); ?>


        <?php echo $__env->yieldContent('footer'); ?>


        <?php echo $__env->yieldContent('aside'); ?>

        
        <?php echo $__env->yieldContent('vue-container-end'); ?>



    </div>


        <!-- Scripts -->



        
        <script src="<?php echo e(asset('public/OPDMS/plugins/jquery/jquery.js')); ?>"></script>
        <script src="<?php echo e(asset('public/OPDMS/plugins/jquery-ui/jquery-ui.min.js')); ?>"></script>
        <script src="<?php echo e(asset('public/OPDMS/plugins/toastr/toastr.min.js')); ?>"></script>
        <script src="<?php echo e(asset('public/OPDMS/plugins/bootstrap/bootstrap.js')); ?>"></script>
        <script src="<?php echo e(asset('public/AdminLTE/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')); ?>"></script>

        <script src="<?php echo e(asset('public/AdminLTE/bower_components/datatables.net/js/jquery.dataTables.min.js')); ?>"></script>
        <script src="<?php echo e(asset('public/AdminLTE/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')); ?>"></script>
        <script src="<?php echo e(asset('public/AdminLTE/plugins/iCheck/icheck.min.js')); ?>"></script>
        <script src="<?php echo e(asset('public/AdminLTE/bower_components/select2/dist/js/select2.full.min.js')); ?>"></script>

        
        <script src="<?php echo e(asset('public/OPDMS/plugins/vue/vue.js')); ?>"></script>

        
        <?php echo $__env->yieldContent('pluginscript'); ?>

        <script src="<?php echo e(asset('public/AdminLTE/dist/js/adminlte.min.js')); ?>"></script>
        <script src="<?php echo e(asset('public/AdminLTE/dist/js/demo.js')); ?>"></script>



        <script src="<?php echo e(asset('public/OPDMS/js/master.js')); ?>"></script>

        <?php echo $__env->make('OPDMS.message.toastr', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        
        <?php echo $__env->yieldContent('pagescript'); ?>

        <script src="<?php echo e(asset('public/OPDMS/js/partials/toaster.js')); ?>"></script>

        <script>
            var authenticate = <?php echo e(Auth::user()->id); ?>

            var auth_role = <?php echo e(Auth::user()->role); ?>

            
        </script>


</body>

</html>
