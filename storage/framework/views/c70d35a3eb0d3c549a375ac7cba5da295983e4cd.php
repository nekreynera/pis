<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <meta http-equiv="Expires" CONTENT="0">
        <meta http-equiv="cache-control" content="no-cache">
        <meta http-equiv="Pragma" CONTENT="no-cache">

        <title><?php echo e(isset($title) ? $title : 'OPD'); ?></title>

        <!-- Styles -->
        <link href="<?php echo e(asset('public/plugins/css/font-awesome.min.css')); ?>" rel="stylesheet" />
        <link rel="stylesheet" href="<?php echo e(asset('public/plugins/css/bootstrap.css')); ?>">
        <link href="<?php echo e(asset('public/plugins/css/toastr.min.css')); ?>" rel="stylesheet" />
        <link href="<?php echo e(asset('public/css/master.css')); ?>" rel="stylesheet" />
        <link href="<?php echo e(asset('public/css/partials/navigation.css?v2.0.1')); ?>" rel="stylesheet" />
        <link rel="shortcut icon" href="<?php echo e(asset('public/images/evrmc-logo.png')); ?>">
        <!-- Load page style -->

        <!-- Load page style -->
        <?php echo $__env->yieldContent('pagestyle'); ?>

    </head>

    <body>
        <?php 
              // dd(Auth::user());
         ?>
        <?php echo $__env->yieldContent('header'); ?>


        <?php echo $__env->yieldContent('content'); ?>

        <?php echo $__env->make('partials.clinics', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


        <?php echo $__env->yieldContent('footer'); ?>

        <input type="hidden" id="baseurl-tinymce" value="<?php echo e(url('')); ?>">

        <!-- Scripts -->
        <script src="<?php echo e(asset('public/plugins/js/jquery.js')); ?>"></script>
        <script src="<?php echo e(asset('public/plugins/js/bootstrap.js')); ?>"></script>
        <script src="<?php echo e(asset('public/plugins/js/toastr.min.js')); ?>"></script>
        <script src="<?php echo e(asset('public/js/master.js?v1.0.1')); ?>"></script>

        <?php echo $__env->yieldContent('pagescript'); ?>
        


        <script src="<?php echo e(asset('public/js/patients/watcher.js')); ?>"></script>
        <!-- <script>
            $('#navigationMenus .opd-nav').click(function(){
                $('#navigationMenus .opd-nav .opd-sub-nav').css('background-color','#028046');
                $('#navigationMenus .opd-nav2 .opd-sub-nav2').css('background-color','#00a65a');
                $('.dropdown-menu .reporst-li').css('background-color','#fff')
                $('.dropdown-menu .reporst-li .dropdown-menu li').css('background-color','#fff')
            });
            $('#navigationMenus .opd-nav2').click(function(){
                $('#navigationMenus .opd-nav2 .opd-sub-nav2').css('background-color','#028046');
                $('#navigationMenus .opd-nav .opd-sub-nav').css('background-color','#00a65a');
                $('.dropdown-menu .reporst-li2').css('background-color','#fff')
            });
        </script> -->

    </body>
</html>
