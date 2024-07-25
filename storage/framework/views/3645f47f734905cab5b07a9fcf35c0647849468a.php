<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPD | Classified Patient
    <?php $__env->endSlot(); ?>

    <?php $__env->startSection('pagestyle'); ?>
         <link href="<?php echo e(asset('public/css/partials/navigation.css')); ?>" rel="stylesheet" />
         <link href="<?php echo e(asset('public/plugins/css/dataTables.bootstrap.min.css')); ?>" rel="stylesheet" />
         <link href="<?php echo e(asset('public/css/mss/classified.css?v2.0.1')); ?>" rel="stylesheet" />
        <link rel="stylesheet" href="<?php echo e(asset('public/css/mss/charges.css?v2.0.1')); ?>" />
    <?php $__env->stopSection(); ?>



    <?php $__env->startSection('header'); ?>
        <?php echo $__env->make('mss/navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php $__env->stopSection(); ?>



    <?php $__env->startSection('content'); ?>
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-12 col-xs-12  pull-right">
                    <form class="text-center" method="GET" action="">
                        <div class="input-group">
                              <div class="input-group-btn">
                                  <button type="button" class="btn btn-default btn-sm dropdown-toggle" 
                                      data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      <i class="fa fa-search"></i> Search By <span class="caret"></span>
                                  </button>
                                  <ul class="dropdown-menu search-menu">
                                      <li><a href="#" class="lname">Last Name</a></li>
                                      <li><a href="#" class="fname">First Name</a></li>
                                      <li><a href="#" class="hospital_no">Patient Hospital No.</a></li>
                                      <li><a href="#" class="datereg">Date Classified</a></li>
                                  </ul>
                              </div>
                              
                              <!-- /btn-group -->
                              <input type="text" name="patient" id="patient" onkeyup="searchclassifiedpatient($(this))" class="form-control patient input-sm" placeholder="hospital no last name first name middle name..." autofocus/>
                              <span class="input-group-btn">
                                  <button class="btn btn-success btn-sm" type="submit" id="search-button">
                                      <i class="fa fa-search"></i> Search
                                  </button>
                              </span>
                        </div>
                        <span class="fa fa-info-circle"></span> <small class="search-guide"> hospital no last name first name middle name</small>
                        <!-- /input-group -->
                    </form>
                </div>
            </div>
            <div>
                <ul class="nav nav-tabs">
                    <?php
                        $total = 0;
                    ?>
                    <?php $__currentLoopData = $tab; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li
                        <?php if(count($request->post()) > 0): ?> 
                            <?php if($request->id == $list->mss_id): ?>
                                class="active" 
                            <?php endif; ?>
                        <?php endif; ?>
                    >
                        <a href="classified?id=<?php if($list->label): ?><?php echo e($list->mss_id); ?><?php else: ?><?php echo e('UNCLASSIFIED'); ?><?php endif; ?>&lname=<?php echo e($request->lname); ?>&fname=<?php echo e($request->fname); ?>&hospital_no=<?php echo e($request->hospital_no); ?>&datereg=<?php echo e($request->datereg); ?>&patient=<?php echo e($request->patient); ?>"
                           class="" 
                           data-toggle="tooltip" data-placement="top" title="VIEW ONLY <?php echo e($list->label.' - '.$list->description); ?>">
                            <?php if($list->label): ?>
                            <?php echo e($list->label.' - '.$list->description); ?>

                            <?php else: ?>
                                NOT MSS CLASSIFIED
                            <?php endif; ?>
                            <span class="badge"><?php echo e($list->counts); ?></span>
                        </a>
                    </li>
                    <?php
                        $total += $list->counts;
                    ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <li <?php if(!$request->id): ?> class="active" <?php endif; ?>>
                        <a href="classified?&lname=<?php echo e($request->lname); ?>&fname=<?php echo e($request->fname); ?>&hospital_no=<?php echo e($request->hospital_no); ?>&datereg=<?php echo e($request->datereg); ?>"
                           class="" 
                           data-toggle="tooltip" data-placement="top" title="TOTAL">
                            TOTAL
                            <span class="badge"><?php echo e($total); ?></span>
                        </a>
                    </li>
                </ul>
            </div>
                
            <div class="table-responsive ">
                <table class="table table-striped table-hover" id="classifiedTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th style="min-width: 100px;">MSWD NO</th>
                            <th>HOSPITAL NO</th>
                            <th style="min-width: 150px;">DATE</th>
                            <th style="min-width: 200px;">NAME OF PATIENT</th>
                            <th>AGE</th>
                            <th>GENDER</th>
                            <th style="min-width: 300px;">ADDRESS</th>
                            <th>CATEGORY</th>
                            <th style="min-width: 150px;">CLASSIFICATION</th>
                            <th>SECTORIAL GROUPING</th>
                            <th>SOURCE OF REFERRAL</th>
                            <th>PHILHEALTH CATEGORY</th>
                            <th style="min-width: 200px;">USER</th>
                            <th>PRINT</th>
                            <th>EDIT</th>
                            <th>MALASAKIT</th>
                            <th>CHARGES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $classified; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $var): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <th  style="background-color: #ccc"><?php echo e($key+1); ?></th>
                                <td class="text-center text-capitalize">
                                    <?php echo e($var->mswd); ?>

                                </td>
                                <td class="text-center"><?php echo e($var->hospital_no); ?></td>
                                <td class="text-center"><?php echo e(Carbon::parse($var->created_at)->format('m/d/Y g:ia')); ?></td>
                                <td class="text-capitalize"><?php echo e(strtolower($var->last_name).', '.strtolower($var->first_name).' '.substr(strtolower($var->middle_name), 0,1)); ?>.</td>
                                <?php if(Carbon::parse($var->birthday)->age >= 60): ?>
                                <td class="text-center" style="font-weight: bold;color: red;"><?php echo e(Carbon::parse($var->birthday)->age); ?></td>
                                <?php else: ?>
                                <td class="text-center"><?php echo e(Carbon::parse($var->birthday)->age); ?></td>
                                <?php endif; ?>
                                <td class="text-center"><?php echo e($var->gender); ?></td>
                                <td><?php echo e($var->brgyDesc.', '.$var->citymunDesc); ?></td>
                                <?php
                                    if($var->category == 'O'):
                                        $category = 'Old';
                                    elseif($var->category == 'N'):
                                        $category = 'New';
                                    else:
                                        $category = 'Cases Forward';
                                    endif;
                                ?>
                                <td class="text-center"><?php echo e($category); ?></td>
                                <td class="text-center">
                                    <?php if(Carbon::parse($var->validity)->format('Y-m-d') < Carbon::now()->format('Y-m-d')): ?>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-danger btn-sm" title="Expired (<?php echo e(Carbon::parse($var->validity)->format('m/d/Y')); ?>)">EXPIRED</button>
                                        <a href="<?php echo e(url('mss/'.$var->id.'/edit')); ?>" class="btn btn-success btn-sm" title="click me to Update patient mss classification">Edit</a>
                                    </div> <br>
                                    <?php endif; ?>
                                    <?php if($var->mss): ?>
                                    <?php echo e($var->mss); ?>

                                    <?php else: ?>
                                    <form action="<?php echo e(url('classification')); ?>" method="post">
                                        <?php echo e(csrf_field()); ?>

                                        <input type="hidden" name="barcode" value="<?php echo e($var->hospital_no); ?>" class="form-control inputbarcode">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-danger btn-sm">N / A</button>
                                            <button type="submit" class="btn btn-success btn-sm" title="click me to classify this patient">Classifiy</button>
                                        </div>
                                    </form>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($var->sectorial); ?></td>
                                <td><?php echo e($var->referral); ?></td>
                                <?php
                                    if($var->philhealth == 'M'):
                                        $philheath = 'Member';
                                    elseif($var->philhealth == 'D'):
                                        $philheath = 'Dependent';
                                    else:
                                        $philheath = '';
                                    endif;
                                ?>
                                <td><?php echo e($philheath); ?>-<?php echo e($var->membership); ?></td>
                                <td class="text-capitalize"><?php echo e(strtolower($var->users)); ?></td>
                                <td align="center">
                                    <a href="<?php echo e(url('mssform/'.$var->id)); ?>" class="btn btn-primary btn-sm" target="_blank" 
                                        data-toggle="tooltip" data-placement="top"
                                        data-id="<?php echo e($var->id); ?>" 
                                        title="click me to print patient MSWD Assessment form">
                                        <span class="fa fa-print"></span>
                                    </a>
                                </td>
                                <td align="center">
                                    <a href="<?php echo e(url('mss/'.$var->id.'/edit')); ?>" class="btn btn-success btn-sm" 
                                        data-toggle="tooltip" data-placement="top"
                                        title="click me to edit patient data">
                                        <i class="fa fa-pencil"></i>
                                    </a>

                                </td>
                                <td align="center">
                                    <a href="<?php echo e(url('malasakitprint/'.$var->id)); ?>" class="btn btn-danger btn-sm" 
                                        target="_blank" class="btn btn-default" 
                                        data-toggle="tooltip" data-placement="top"
                                        title="click me to print patient data in malasakit form">
                                        <i class="fa fa-heartbeat"></i>
                                    </a>
                                </td>
                                <td align="center">
                                    <button class="btn btn-warning btn-sm" id="patient-charges" 
                                        patient-id="<?php echo e($var->patient_id); ?>" 
                                        data-toggle="tooltip" data-placement="top"
                                        title="click me to view patient charges">
                                         <span class="fa fa-money"></span> 
                                    </button>
                                </td>
                                
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div id="choosedatemodal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-sm">
                <form method="post" action="<?php echo e(url('classifiedbyday')); ?>">
                       <?php echo e(csrf_field()); ?>

                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">CHOOSE DATE</h4>
                    </div>
                    <div class="modal-body">
                        <input type="date" name="date" id="choose_date" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">OK</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    <?php echo $__env->make('mss.modals.charges.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>    
    <?php echo $__env->make('mss.modals.charges.adjust', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>    
    <?php $__env->stopSection(); ?> 




    <?php $__env->startSection('pagescript'); ?>
        <script>
            // $('#patient-adjust-charges').modal('toggle');
            var dateToday = '<?php echo e(Carbon::today()->format("m/d/Y")); ?>';
            var mss_user_id = '<?php echo e(Auth::user()->id); ?>';
        </script>
        <script src="<?php echo e(asset('public/plugins/js/jquery.dataTables.min.js')); ?>"></script>
        <script src="<?php echo e(asset('public/plugins/js/dataTables.bootstrap.min.js')); ?>"></script>
        <script src="<?php echo e(asset('public/js/mss/classified.js?v2.0.1')); ?>"></script>
        <script src="<?php echo e(asset('public/js/mss/charges.js?v2.0.2')); ?>"></script>
    <?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>
