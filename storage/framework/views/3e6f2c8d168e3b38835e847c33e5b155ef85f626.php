<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPD | ANCILLARY
    <?php $__env->endSlot(); ?>

<?php $__env->startSection('pagestyle'); ?>
    <link href="<?php echo e(asset('public/css/ancillary/list.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/plugins/css/dataTables.bootstrap.min.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>



<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('receptions/navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>
            <div class="container">
                    <!-- <h3 class="text-left"><span class="fa fa-wrench"></span> SERVICES</h3> -->
                <hr>
                
               
                <div>
                 
                  <!-- <a href="#"
                     class="btn btn-success add"
                     data-toggle="modal" data-target="#addService">
                      ADD SERVICE <span class=" fa fa-plus"></span>
                  </a>
                   <a href="<?php echo e(url('exportservicetopdf')); ?>" target="_blank" 
                     class="btn btn-info">
                      EXPORT TO PDF <span class=" fa fa-file-text-o"></span>
                  </a> -->
                    <?php
                      $active = 0;
                      $inactive = 0;
                      $deleted = 0;
                    ?>
                   <?php $__currentLoopData = $tab; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <?php if($list->status == "active" && $list->trash == "N"): ?>
                        <?php
                          $active++
                        ?>
                      <?php endif; ?>
                      <?php if($list->status == "inactive" && $list->trash == "N"): ?>
                        <?php
                          $inactive++
                        ?>
                      <?php endif; ?>
                      <?php if($list->trash == "Y"): ?>
                        <?php
                          $deleted++
                        ?>
                      <?php endif; ?>
                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <ul class="nav nav-tabs">
                      <li>
                          <a href="<?php echo e(url('ancillary?list=active')); ?>"
                             class="unassignedTab <?php if($request->list == 'active'): ?> <?php echo e('bg-success'); ?>  <?php endif; ?>" 
                             data-toggle="tooltip" data-placement="top" title="FILTER BY ACTIVE SERVICES">
                              ACTIVE
                              <span class="badge bsucesss"><?php echo e($active); ?></span>
                          </a>
                      </li>
                      <li>
                          <a href="<?php echo e(url('ancillary?list=inactive')); ?>"
                             class="unassignedTab <?php if($request->list == 'inactive'): ?> <?php echo e('bg-warning'); ?>  <?php endif; ?>" 
                             data-toggle="tooltip" data-placement="top" title="FILTER BY INACTIVE SERVICES">
                              INACTIVE
                              <span class="badge bwarning"><?php echo e($inactive); ?></span>
                          </a>
                      </li>
                      <li>
                          <a href="<?php echo e(url('ancillary?trash=Y')); ?>"
                             class="unassignedTab <?php if($request->trash == 'Y'): ?> <?php echo e('bg-danger'); ?>  <?php endif; ?>" 
                             data-toggle="tooltip" data-placement="top" title="FILTER BY DELETED SERVICES">
                              DELETED
                              <span class="badge bdanger"><?php echo e($deleted); ?></span>
                          </a>
                      </li>
                      <li>
                          <a href="<?php echo e(url('ancillary')); ?>"
                             class="unassignedTab" 
                             data-toggle="tooltip" data-placement="top" title="VIEW ALL SERVICES">
                              TOTAL
                              <span class="badge binfo"><?php echo e(count($tab)); ?></span>
                          </a>
                      </li>
                      <li class="pull-right">
                          <a href="<?php echo e(url('exportservicetopdf')); ?>?list='<?php echo e($request->list); ?>'&trash='<?php echo e($request->trash); ?>'" class="bg-info" target="_blank">
                              EXPORT TO PDF <span class=" fa fa-file-text-o"></span>
                          </a>
                      </li>
                      <li class="pull-right">
                          <a href="#"
                             class="add bg-primary"
                             data-toggle="modal" data-target="#addService">
                              ADD SERVICE <span class=" fa fa-plus"></span>
                          </a>
                      </li>
                   
                  </ul>
                  <br>
                </div>
               

                       
                  
                <div class="table-responsive content-medicine">
                    <table class="table table-striped table-bordered" id="services">
                        <thead>
                            <tr style="background-color: #ccc;">
                                <th hidden></th>
                                <th hidden></th>
                                <th>PARTICULAR</th>
                                <th>PRICE</th>
                                <th>TYPE</th>
                                <th>STATUS</th>
                                <th width="70px">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td hidden></td>
                                    <td hidden class="idt"><?php echo e($list->id); ?></td>
                                    <td class="sub_categorytd"><?php echo e($list->sub_category); ?></td>
                                    <td align="right" class="pricetd"><?php echo e(number_format($list->price, 2, '.', ',')); ?></td>
                                    <td align="center" class="typetd"><?php echo e(( $list->type )?'SUPPLY':'SERVICE'); ?></td>
                                     <?php if($list->trash == 'N'): ?>
                                      <?php if($list->status == 'active'): ?>
                                      <td align="center" class="statustd success" id="statustd"><?php echo e($list->status); ?></td>
                                      <?php else: ?>
                                      <td align="center" class="statustd warning" id="statustd"><?php echo e($list->status); ?></td>
                                      <?php endif; ?>
                                    <?php else: ?>
                                      <td align="center" class="statustd danger" id="statustd">DELETED</td>
                                    <?php endif; ?>
                                     <td align="center">
                                     <?php if($list->trash == 'N'): ?>
                                        <a href="#" class="btn btn-default editservice" data-toggle="tooltip" data-placement="top" title="EDIT ITEM"><span class="fa fa-pencil"></span></a>
                                        <a href="<?php echo e(url('movetotrash')); ?>/<?php echo e($list->id); ?>" 
                                            class="btn btn-default removeservice" 
                                            data-toggle="tooltip" data-placement="top" title="MOVE TO TRASH"
                                            onclick="return confirm('Delete this Service?')"><span class="fa fa-trash"></span></a>
                                     <?php else: ?>
                                        <a href="<?php echo e(url('restoreservice')); ?>/<?php echo e($list->id); ?>" 
                                          class="btn btn-warning btn-sm"
                                           onclick="return confirm('Re-use / Restore this Service?')">
                                          RESTORE <span class="fa fa-recycle"></span>
                                        </a>
                                     <?php endif; ?>
                                     </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div> 




            <div id="addService" class="modal" role="dialog">
              <div class="modal-dialog">

                <!-- Modal content-->
                <form method="post" action="<?php echo e(url('ancillary')); ?>">
                  <?php echo e(csrf_field()); ?>

                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-plus"></i> Add Service</h4>
                      </div>
                      <div class="modal-body">
                          
                         <div class="form-group">
                           <label>Service Name/ Description</label>
                           <textarea class="form-control" name="sub_category" autofocus placeholder="Enter Service Name/ Description" required></textarea>
                         </div>
                         <div class="form-group row">
                            <div class="col-md-6">
                                  <label>Price</label>
                                  <input type="text" name="price" class="form-control" placeholder="0.00" required />
                            </div>
                         </div>
                         <div class="form-group row">
                            <div class="col-md-6">
                                  <label>Type</label>
                                  <select name="type" class="form-control" required>
                                    <option value="" hidden>--choose--</option>
                                    <option value="0">SERVICE</option>
                                    <option value="1">SUPPLY</option>
                                  </select>
                            </div>
                         </div>
                         <div class="form-group row">
                            <div class="col-md-6">
                                  <label>Status</label>
                                  <select name="status" class="form-control" required>
                                    <option value="active">ACTIVE</option>
                                    <option value="inactive">INACTIVE</option>
                                  </select>
                            </div>
                            
                         </div>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Save</button>
                         <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-backward"></span> Cancel</button>
                      </div>
                    </div>
                </form>

              </div>
            </div>

            <div id="editservice" class="modal" role="dialog">
              <div class="modal-dialog">

                <!-- Modal content-->
                <form class="editservicemodal">
                  <?php echo e(csrf_field()); ?>

                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-pencil"></i> Edi Service</h4>
                      </div>
                      <div class="modal-body">
                       
                         <div class="form-group">
                           <label>Item Name/ Description</label>
                           <textarea class="form-control sub_category" name="sub_category" autofocus required></textarea>
                         </div>
                         <div class="form-group row">
                            <div class="col-md-6">
                                  <label>Price</label>
                                  <input type="text" name="price" class="form-control price" required />
                            </div>
                         </div>
                         <div class="form-group row">
                            <div class="col-md-6">
                                  <label>Type</label>
                                  <select name="type" class="form-control type" required>
                                    <option value="" hidden>--choose--</option>
                                    <option value="0">SERVICE</option>
                                    <option value="1">SUPPLY</option>
                                  </select>
                            </div>
                         </div>
                         <div class="form-group row">
                            <div class="col-md-6">
                                  <label>Status</label>
                                  <select name="status" class="form-control status" required>
                                    <option value="" hidden>--choose--</option>
                                    <option value="active">ACTIVE</option>
                                    <option value="inactive">INACTIVE</option>
                                  </select>
                            </div>
                            
                         </div>
                      </div>
                      <div class="modal-footer">
                        <input type="hidden" name="" class="hidden_id">
                        <button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Update</button>
                         <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-backward"></span> Cancel</button>
                      </div>
                    </div>
                </form>

              </div>
            </div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('footer'); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('pagescript'); ?>
    <?php echo $__env->make('message.toaster', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    
    <script src="<?php echo e(asset('public/plugins/js/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/dataTables.bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/ancillary/list.js?2')); ?>"></script>
<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>
