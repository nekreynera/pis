<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPD | ANCILLARY
    <?php $__env->endSlot(); ?>

<?php $__env->startSection('pagestyle'); ?>
    <link href="<?php echo e(asset('public/css/doctors/reset.css')); ?>" rel="stylesheet" />
    <?php if(Auth::user()->theme == 2): ?>
        <link href="<?php echo e(asset('public/css/doctors/darkstyle.css')); ?>" rel="stylesheet" />
    <?php else: ?>
        <link href="<?php echo e(asset('public/css/doctors/greenstyle.css')); ?>" rel="stylesheet" />
    <?php endif; ?>
    <link href="<?php echo e(asset('public/css/ancillary/manualrequest.css')); ?>" rel="stylesheet" />


<?php $__env->stopSection(); ?>



<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('ancillary.navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('ancillary/dashboard'); ?>
<?php $__env->startSection('main-content'); ?>


    <div class="content-wrapper" style="margin-left: 150px;padding-right: 20px;">
        <br>
        <div class="banner">
            <h3 class="text-left"> <i class="fa fa-user-md"></i>DIRECT REQUISITION </h3>
            <?php if(COUNT($pendingunpaid) > 0 || COUNT($pendingpaid) > 0): ?>
               <body onload="$('#pendingtransaction-modal').modal('toggle')"></body>
            <?php endif; ?>

        </div>
        <div class="">
            <br>
            <br>
        </div>
        <div class="container-fluid">


            <div class="col-md-12 requsitionWrapper">
                <div class="row">
                    <div class="col-md-3 departmentWrapper">
                        <table class="table table-condensed table-bordered">
                            <tr>
                                <th>PATIENT INFORMATION</th>
                            </tr>
                            <tr>
                                <td><b>NAME: </b> <?php echo e($patient->first_name.' '.$patient->middle_name.' '.$patient->last_name); ?></td>

                            </tr>
                            <tr>
                                <?php
                                    $agePatient = App\Patient::age($patient->birthday)
                                ?>
                                <td><b>AGE: </b> <?php echo e($agePatient); ?></td>

                            </tr>
                            <tr>
                                <?php if(is_numeric($patient->description)): ?>
                                    <td><b>CLASSIFICATION: </b> <?php echo e($patient->label.'-'.$patient->description); ?>% </td>
                                <?php else: ?>
                                    <td><b>CLASSIFICATION: </b> <?php echo e($patient->label.'-'.$patient->description); ?></td>
                                <?php endif; ?>

                            </tr>
                            <tr>
                                <td><b>GENDER: </b> <?php echo e(($patient->sex=='M')? 'MALE':'FEMALE'); ?></td>

                            </tr>
                            <tr>
                                <td><b>ADDRESS: <br></b> <?php echo e($patient->address); ?></td>

                            </tr>

                        </table>


                    </div>
                    <div class="col-md-9 requsitionSelection">
                        <div class="search-header">
                            <form class="form-inline" onsubmit="return false">
                                <?php if(Auth::user()->clinic == "31"): ?>
                                <select class="form-control" id="category-select">
                                    <option value="">--FILTER BY--</option>
                                    <option value="X-RAY">X-RAY</option>
                                    <option value="ULTRASOUND">ULTRASOUND</option>
                                </select>
                                 <input type="text" name="" class="form-control" data-search="3" id="description" placeholder="Search By Description..." />
                                <?php else: ?>
                                <input type="text" name="" class="form-control" data-search="1" id="description" placeholder="Search By Description..." />
                                <?php endif; ?>
                                <small class="text-right"> &nbsp; Showing <strong id="countResults"><?php echo e(count($services)); ?></strong> Results</small>
                            </form>
                        </div>
                        <br/>
                        <div class="table-responsive tableWrapper">
                            <div class="loaderWrapper">
                                <img src="<?php echo e(asset('public/images/loader.svg')); ?>" alt="loader" class="img-responsive" />
                                <p>Loading...</p>
                            </div>

                            <table class="table table-hover" id="itemsDeptTable">
                                <thead>
                                <tr>
                                    <th><i class="fa fa-info-circle"></i></th>
                                    <?php if(Auth::user()->clinic == "31"): ?>
                                    <th>QTY</th>
                                    <?php endif; ?>
                                    <th>TYPE</th>
                                    <th>PARTICULAR</th>
                                    <th>PRICE</th>
                                </tr>
                                </thead>
                                <tbody class="selectitemsTbody">
                                <?php if(count($services)): ?>
                                    <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr style="cursor: pointer;">
                                            <td>
                                                <input type="checkbox" data-id="<?php echo e($list->id); ?>" class="check-item" />
                                            </td>
                                            <td class="choose_qty" align="center">0</td>
                                             <?php if(Auth::user()->clinic == "31"): ?>
                                            <td>
                                                <?php echo e($list->category); ?>

                                            </td>
                                            <?php endif; ?>
                                            <td class="item_description">
                                                <?php echo e($list->sub_category); ?>

                                            </td>

                                            <td class="price" align="center">
                                                <?php echo e(number_format($list->price, 2, '.', '')); ?>

                                            </td>


                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            <strong class="text-danger">NO RESULTS FOUND.</strong>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>


            <div class="col-md-12">
                <br>
                <div class="row seletecItemsWrapper">
                    <h5 class="text-center"> <b class="pull-left">TOTAL ITEMS SELECTED: <b class="total-count">0</b></b>
                        SELECTED ITEMS <b class="pull-right">CLASSIFICATION:  <?php echo e($patient->label.'-'.$patient->description); ?>% </b>
                    </h5>
                    <div class="table-responsive tableSelectedItems">
                        <form action="<?php echo e(url('ancillaryrequisition')); ?>" method="post" id="requisitionformlab">
                            <?php echo e(csrf_field()); ?>

                            <input type="hidden" name="patient_id" class="patient_id" value="<?php echo e($patient->id); ?>">
                            <input type="hidden" name="mss_id" class="mss_id" value="<?php echo e($patient->mss_id); ?>">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th><i class="fa fa-info-circle"></i></th>
                                    <th>PARTICULAR</th>
                                    <th>PRICE</th>
                                    <th hidden>QTY</th>
                                    <th>AMOUNT</th>
                                    <th>DISCOUNT</th>
                                    <th>NET AMOUNT</th>
                                </tr>
                                </thead>
                                <tbody class="selectedItemsTbody" id="<?php echo e($patient->discount); ?>">
                                <tr class="noSelectedTRwrapper">
                                    <td colspan="7" class="text-center">
                                        <strong class="text-danger">NO SELETECD ITEMS.</strong>
                                    </td>
                                </tr>
                                
                                </tbody>
                                <tr>
                                    <td colspan="7" class="text-right">
                                          <h4>&#8369; <strong id="grndTotal"></strong> Total(php) &nbsp;</h4>
                                    </td>
                                </tr>

                                  

                            </table>
                        </form>
                    </div>
                    <div class="col-md-12 grandtotalinfo">
                       
                        <div class="col-md-4 col-md-offset-8 text-right">
                            <button type="button" class="btn btn-default btn-sm" id="saverequisition">Save</button>
                            <a href="<?php echo e(url('directrequisition')); ?>" class="btn btn-default btn-sm">Cancel</a>
                        </div>



                    </div>
                </div>
            </div>



            <div id="pendingtransaction-modal" class="modal" role="dialog">
              <div class="modal-dialog">

                <!-- Modal content-->

                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"> PENDING TRANSACTIONS</h4>
                      </div>
                      <div class="modal-body">
                        <div class="table-responsive" style="max-height: 250px;">
                            <br>
                            <span class="count-badge"><?php echo e(count($pendingunpaid)); ?></span>
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="success">
                                        <th colspan="4">UNPAID TRANSACTION</th>
                                    </tr>
                                    <tr>
                                        <th>REQUISITION BY</th>
                                        <th>TOTAL ITEM</th>
                                        <th>DATETIME</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $pendingunpaid; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($list->users); ?></td>
                                        <td align="center"><?php echo e($list->req); ?></td>
                                        <td align="center"><?php echo e($list->updated_at); ?></td>
                                        <td align="center"><button class="btn btn-default btn-sm" id="viewunpaidparticulars" orno="<?php echo e($list->modifier); ?>" status="unpaid">View <span class=" fa fa-eye"></span></button></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive" style="max-height: 250px;">
                            <br>
                            <span class="count-badge"><?php echo e(count($pendingpaid)); ?></span>
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="success">
                                        <th colspan="4">PAID TRANSACTION</th>
                                    </tr>
                                    <tr>
                                        <th>REQUISITION BY</th>
                                        <th>TOTAL ITEM</th>
                                        <th>DATETIME</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $pendingpaid; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($list->users); ?></td>
                                        <td align="center"><?php echo e($list->req); ?></td>
                                        <td align="center"><?php echo e($list->updated_at); ?></td>
                                        <td align="center"><button class="btn btn-default btn-sm" id="viewpaidparticulars" orno="<?php echo e($list->or_no); ?>" status="paid">View <span class=" fa fa-eye"></span></button></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                         </div>

                        
                        
                      </div>
                      <div class="modal-footer">
                        
                         <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><span class="fa fa-remove"></span> Close</button>
                      </div>
                    </div>
              </div>
            </div>
                <div id="pendingusertransaction-modal" class="modal" role="dialog">
                  <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">USER PENDING TRANSACTIONS (<b class="status"></b>)</h4>
                          </div>
                          <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        
                                        <tr class="success">
                                            <th>PARTICULAR</th>
                                            <th>PRICE</th>
                                            <th>QTY</th>
                                            <th>AMOUNT</th>
                                            <th>DISCOUNT</th>
                                            <th>NETAMOUNT</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tbodypending">
                                       
                                    </tbody>
                                </table>
                            </div>
                          </div>
                          <div class="modal-footer">
                             <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><span class="fa fa-remove"></span> Close</button>
                          </div>
                        </div>
                  </div>
                </div>
            
        </div>
    </div>

    <!-- .content-wrapper -->

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
    <script src="<?php echo e(asset('public/js/pharmacy/main.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/ancillary/manualinput.js')); ?>"></script>
<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>
