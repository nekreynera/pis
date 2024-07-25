<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPD | Classified Patient
    <?php $__env->endSlot(); ?>

    <?php $__env->startSection('pagestyle'); ?>
         <link href="<?php echo e(asset('public/css/partials/navigation.css')); ?>" rel="stylesheet" />
         <link href="<?php echo e(asset('public/plugins/css/dataTables.bootstrap.min.css')); ?>" rel="stylesheet" />
         <link href="<?php echo e(asset('public/css/mss/classified.css')); ?>" rel="stylesheet" />
    <?php $__env->stopSection(); ?>



    <?php $__env->startSection('header'); ?>
        <?php echo $__env->make('mss/navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php $__env->stopSection(); ?>



    <?php $__env->startSection('content'); ?>
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-4 col-xs-3">
                    <button class="btn btn-primary btn-sm btn-new-sponsor">
                      <span class="fa fa-plus"> </span>
                      New
                    </button>
                </div>
                <div class="col-md-6 col-sm-8 col-xs-9  pull-right">
                    <form class="text-center" method="GET" action="">
                        <div class="input-group">
                             <!--  <div class="input-group-btn">
                                  <button type="button" class="btn btn-default btn-sm dropdown-toggle" 
                                      data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      <i class="fa fa-search"></i> Search By <span class="caret"></span>
                                  </button>
                                  <ul class="dropdown-menu search-menu">
                                      <li><a href="#" class="lname">Label</a></li>
                                      <li><a href="#" class="hospital_no">Discount</a></li>
                                  </ul>
                              </div> -->
                              
                              <!-- /btn-group -->
                              <input type="text" name="patient" id="patient" onkeyup="searchsponsors($(this))" class="form-control patient input-sm" placeholder="Label, Discount..." autofocus/>
                              <span class="input-group-btn">
                                  <button class="btn btn-success btn-sm" type="submit" id="search-button">
                                      <i class="fa fa-search"></i> Search
                                  </button>
                              </span>
                        </div>
                        <span class="fa fa-info-circle"></span> <small class="search-guide"> Label, Discount</small>
                        <!-- /input-group -->
                    </form>
                </div>
            </div>
                
            <div class="table-responsive ">
                <table class="table table-striped table-hover" id="sponsorsTable">
                    <thead>
                        <tr>
                            <th style="width: 20px;">#</th>
                            <th>Label</th>
                            <th>Discription</th>
                            <th>Discount Rate <br><small>( amount * discount )</small></th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Action</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $var): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <th  style="background-color: #ccc;text-align: center;"><?php echo e($key+1); ?></th>
                                <td><?php echo e($var->label); ?></td>
                                <td class="text-center"><?php echo e((is_numeric($var->description))? $var->description.'%' : $var->description); ?></td>
                                <td class="text-right"><?php echo e($var->discount); ?></td>
                                <td class="text-center"><?php echo ($var->type)? '<span class="label bg-primary">Sponsor</span>' : '<span class="label bg-success">Discount</span>'; ?></td>
                                <td class="text-center"><?php echo ($var->status)? '<span class="label bg-primary">Active</span>' : '<span class="label bg-danger">In-active</span>'; ?></td>
                                <td class="text-center"> 
                                    <button class="btn btn-success btn-edit-sponsor btn-sm" 
                                          data-toggle="tooltip" data-placement="top"
                                          title="click me to edit classification data"
                                          data-id="<?php echo e($var->id); ?>">
                                          <i class="fa fa-pencil"></i>
                                          Edit
                                    </button>
                                    <button class="btn btn-info btn-view-monitoring btn-sm" <?php if(!$var->type): ?> style="display:none;" <?php endif; ?>
                                          data-toggle="tooltip" data-placement="top"
                                          title="click me to view guarantor transaction summary"
                                          data-id="<?php echo e($var->id); ?>">
                                          <span class="fa fa-hourglass-2"></span>
                                          Monitoring
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php echo $__env->make('mss.modals.sponsors.new', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('mss.modals.sponsors.edit', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('mss.modals.sponsors.monitoring', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php $__env->stopSection(); ?> 



    <?php $__env->startSection('pagescript'); ?>
        <script>
            // $('#modal-monitoring-mss-guarantor').modal('toggle');
            var dateToday = '<?php echo e(Carbon::today()->format("m/d/Y")); ?>';
            var mss_user_id = '<?php echo e(Auth::user()->id); ?>';
        </script>
        <script src="<?php echo e(asset('public/plugins/js/jquery.dataTables.min.js')); ?>"></script>
        <script src="<?php echo e(asset('public/plugins/js/dataTables.bootstrap.min.js')); ?>"></script>
        <script src="<?php echo e(asset('public/js/mss/sponsors.js')); ?>"></script>
    <?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>
