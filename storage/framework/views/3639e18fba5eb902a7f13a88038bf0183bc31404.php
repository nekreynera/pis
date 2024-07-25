<?php $__env->startComponent('OPDMS.partials.header'); ?>


<?php $__env->slot('title'); ?>
    OPD | LABORATORY
<?php $__env->endSlot(); ?>


<?php $__env->startSection('pagestyle'); ?>
    <link href="<?php echo e(asset('public/OPDMS/css/patients/main.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/OPDMS/css/laboratory/main.css')); ?>" rel="stylesheet" />
    <!-- <link href="<?php echo e(asset('public/OPDMS/css/patients/action.css')); ?>" rel="stylesheet" /> -->
    <link href="<?php echo e(asset('public/OPDMS/css/laboratory/laboratory/action.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/OPDMS/css/laboratory/laboratory/sub.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/OPDMS/css/laboratory/laboratory/infolist.css')); ?>" rel="stylesheet" />
    <!-- <link href="<?php echo e(asset('public/OPDMS/css/patients/check_patient.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/OPDMS/css/patients/result_patient.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/OPDMS/css/patients/print_patient.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/OPDMS/css/patients/edit_patient.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/OPDMS/css/patients/remove.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/OPDMS/css/patients/patient_information.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/OPDMS/css/patients/medical_records.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/OPDMS/css/patients/transaction.css')); ?>" rel="stylesheet" /> -->
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
        ['header' => 'Laboratory', 'sub' => 'All laboratory services are showned here.'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <!-- Main content -->
        <section class="content laboratory-content">

            <div class="box">
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-3 col-sm-4 col-xs-4 side-bar-container">
                        <div class="row action-sub">
                          <div class="col-md-12 col-sm-12 col-xs-12">
                            
                            <button class="btn btn-success btn-sm" id="edit-sub" data-id="1"><i class="fa fa-pencil"></i> Edit</button>
                          </div>
                         

                        </div>              
                        <ul class="sidebar-menu ancillary-sidebar-special" data-widget="tree" id="ancillary-sidebar-special">
                            <?php $__currentLoopData = $laboratory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="header text-uppercase" data-id=<?php echo e($list->id); ?>>
                              <?php echo e($list->name); ?>

                            </li>
                              <?php $__currentLoopData = $sub; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sublist): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($list->id == $sublist->laboratory_id): ?>
                                <li data-id="<?php echo e($sublist->id); ?>" 
                                  class="text-capitalize">
                                  <a href="#">
                                    <span><?php echo e($sublist->name); ?></span>
                                  </a>
                                </li>
                                <?php endif; ?>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                    <div class="col-md-9 col-sm-8 col-xs-8 content-container">
                      <div class="row sub-list-action">
                          <div class="col-md-6 col-sm-6 col-xs-6 col-xxs-12">
                              <button class="btn btn-success btn-sm" id="new-list"><span class="fa fa-flask"></span> New</button>
                              <button class="btn btn-success btn-sm disabled" id="edit-list" data-id="#"><span class="fa fa-pencil"></span> Edit</button>
                          </div>
                          <div class="col-md-6 col-sm-6 col-xs-6 col-xxs-12">
                              <form class="list-search text-center" id="list-search" method="POST" action="<?php echo e(url('searchlist')); ?>">
                                      <div class="input-group">
                                            <!-- /btn-group -->
                                            <input type="text" name="list_search" id="list-search-input" class="form-control input-sm" placeholder="Service Keyword..." autofocus/>
                                            <span class="input-group-btn">
                                                <button class="btn btn-success btn-sm" type="submit" form="#list-search">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                            </span>
                                      </div>
                                      <!-- /input-group -->
                              </form>
                          </div>
                          
                      </div>
                      <div class="btn-group-vertical trial-click">
                        <button type="button" class="btn btn-default btn-sm" id="edit-list" data-id="#"><span class="fa fa-pencil"></span> Edit</button>
                        <a href="#" class="btn btn-default btn-sm" id="service-information" data-id="#"><span class="fa fa-info-circle"></span> Service Information </a>
                      </div>
                    <?php echo $__env->make('OPDMS.partials.loader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                      <div class="table-responsive" style="max-height: 400px;">
                          <table class="table table-striped table-hover" id="ancillary-table">
                              <thead>
                                  <tr class="bg-gray">
                                      <th></th>
                                      <th hidden></th>
                                      <th>Service Name</th>
                                      <th>Price</th>
                                      <th>Status</th>
                                      <th>Date</th>
                                  </tr>
                              </thead>
                              <tbody class="ancillary-tbody">
                                  <?php if(count($lablist) > 0): ?>
                                    <?php $__currentLoopData = $lablist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr data-id="<?php echo e($list->id); ?>">
                                      <td><span class="fa fa-caret-right"></span></td>
                                      <td hidden></td>
                                      <td class="text-capitalize"><?php echo e(ucwords($list->name)); ?></td>
                                      <td class="text-right"><?php echo e(number_format($list->price, 2, '.', '')); ?></td>
                                      <?php if($list->status == 'Active'): ?>
                                      <td class="text-center"><small class="label bg-green">Active</small></td>
                                      <?php else: ?>
                                      <td class="text-center"><small class="label bg-red">Inactive</small></td>
                                      <?php endif; ?>
                                      <td class="text-center"><?php echo e(Carbon::parse($list->created_at)->format('m/d/Y')); ?></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                  <?php else: ?>
                                    <tr>
                                      <td hidden></td>
                                      <td colspan="5" class="text-center text-bold"><span class="fa fa-warning"></span> Empty Data</td>
                                    </tr>
                                  <?php endif; ?>
                              </tbody>
                          </table>
                      </div>    
                    </div>
                    
                  </div>
                </div>

                <div class="box-footer">
                    <small>
                        <em class="text-muted">
                          Showing <b> <?php echo e(count($lablist)); ?> </b> result(s).
                        </em>
                    </small>
                </div>
            </div>

        </section>
        <!-- /.content -->
    </div>

    <?php echo $__env->make('OPDMS.laboratory.modals.laboratory.newsub', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('OPDMS.laboratory.modals.laboratory.editsub', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('OPDMS.laboratory.modals.laboratory.newlist', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('OPDMS.laboratory.modals.laboratory.editlist', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('OPDMS.laboratory.modals.laboratory.infolist', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <!-- /.content-wrapper -->
<?php $__env->stopSection(); ?>



<?php $__env->startSection('aside'); ?>
    <?php echo $__env->make('OPDMS.partials.boilerplate.aside', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('pluginscript'); ?>
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('pagescript'); ?>
    <script>
        var dateToday = '<?php echo e(Carbon::today()->format("m/d/Y")); ?>';
    </script>
    <script src="<?php echo e(asset('public/OPDMS/js/laboratory/main.js')); ?>"></script>
    <script src="<?php echo e(asset('public/OPDMS/js/laboratory/action.js')); ?>"></script>
    <script src="<?php echo e(asset('public/OPDMS/js/laboratory/sub.js')); ?>"></script>
    <script src="<?php echo e(asset('public/OPDMS/js/laboratory/list.js')); ?>"></script>
    <script src="<?php echo e(asset('public/OPDMS/js/laboratory/category.js')); ?>"></script>
    <script src="<?php echo e(asset('public/OPDMS/js/laboratory/table.js')); ?>"></script>
    <script src="<?php echo e(asset('public/OPDMS/js/laboratory/search.js')); ?>"></script>
    <!-- <script src="<?php echo e(asset('public/OPDMS/js/patients/check_patient.js')); ?>"></script>
    <script src="<?php echo e(asset('public/OPDMS/js/patients/result_patient.js')); ?>"></script>
    <script src="<?php echo e(asset('public/OPDMS/js/patients/print_patient.js')); ?>"></script>
    <script src="<?php echo e(asset('public/OPDMS/js/patients/store_patient.js')); ?>"></script>
    <script src="<?php echo e(asset('public/OPDMS/js/patients/edit_patient.js')); ?>"></script>
    <script src="<?php echo e(asset('public/OPDMS/js/patients/remove.js')); ?>"></script>-->
    <script src="<?php echo e(asset('public/OPDMS/js/laboratory/roles.js')); ?>"></script>
   <!--  <script src="<?php echo e(asset('public/OPDMS/js/patients/patient_information.js')); ?>"></script>
    <script src="<?php echo e(asset('public/OPDMS/js/patients/medical_record.js')); ?>"></script>
    <script src="<?php echo e(asset('public/OPDMS/js/patients/transaction.js')); ?>"></script>

    <script src="<?php echo e(asset('public/OPDMS/js/patients/address.js')); ?>"></script> -->


    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2();



            $(window).load(function(){
                $('body').attr('oncontextmenu', 'return false');
            })
        });
    </script>

<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>