<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">

            <div class="pull-left image">
                <?php
                    if(Auth::user()->profile){
                        $avatar = asset('public/users/'.Auth::user()->profile);
                    }else{
                        $avatar = asset('/public/OPDMS/images/avatar.png');
                    }
                ?>
                
                <img src="<?php echo e($avatar); ?>" class="img-circle img-responsive userAvatarDashboard" alt="User Image">
            </div>


            <div class="pull-left info">

                <p class="text-ellipsis">
                    <?php echo e(Auth::user()->first_name.' '.Auth::user()->last_name); ?>

                </p>

                
                <small><i class="fa fa-circle text-green"></i> Online</small>
                

            </div>
        </div>



        <!-- search form (Optional) -->



        <?php echo $__env->yieldContent('search_form'); ?>



        <!-- /.search form -->


        <?php if(Auth::user()->role == 5): ?> 
            <?php echo $__env->make('OPDMS.reception.roles', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php elseif(Auth::user()->role == 1): ?> 
            <?php echo $__env->make('OPDMS.patients.roles', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php elseif(Auth::user()->role == 4 && Auth::user()->clinic == 47): ?> 
            <?php echo $__env->make('OPDMS.laboratory.roles', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php endif; ?>




        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>