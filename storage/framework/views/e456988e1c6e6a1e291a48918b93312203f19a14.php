<div class="modal" id="modal-new-transaction">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                Laboratory Transaction Window
            </div>
            <div class="modal-body">
                <div class="modal-loader">
                    <?php echo $__env->make('OPDMS.partials.loader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive patient-information">
                            <table class="table table-bordered">
                                <tr>
                                    <td>Patient: <strong class="patient-name"></strong></td>
                                    <td>Birth Date: <font class="patient-birth-date"></font></td>
                                    <td>Age: <font class="patient-age"></font></td>
                                    <td>C.Status: <font class="patient-c-status"></font></td>
                                </tr>
                                <tr>
                                    <td>Hospital ID: <strong class="patient-hospital-no"></strong></td>
                                    <td colspan="2" style="max-width: 500px;">Address: <font class="patient-address"></font></td>
                                    <td>Sex: <font class="patient-sex"></font></td>
                                </tr>
                                <tr>
                                    <td>QR-Code: <font class="patient-qr-code"></font></td>
                                    <td colspan="2">Mss Classification: 
                                        <strong class="patient-mss" data-discount=""></strong>
                                       <!--  <select class="patient-mss" style="width: 100px;" disabled>
                                            <option value=""></option>
                                            <option value=""></option>
                                            <option value=""></option>
                                        </select> -->
                                    </td>
                                    <td>Registered: <font class="patient-regestered"></font></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row list-search-row">
                    <div class="col-md-12">
                        <div class="col-md-9 col-sm-9 col-xs-8 content-container">
                            <form class="text-center list-search search-input" id="list-search" method="POST" action="<?php echo e(url('searchlist')); ?>">
                                    <div class="input-group">
                                          <!-- /btn-group -->
                                          <input type="text" name="list_search" id="list-search-input" class="form-control input-sm" placeholder="Input Keyword..." autofocus/>
                                          <span class="input-group-btn">
                                              <button class="btn btn-success btn-sm" type="submit" form="#list-search">
                                                  <i class="fa fa-search"></i>
                                              </button>
                                          </span>
                                    </div>
                                    <!-- /input-group -->
                            </form>
                            <?php echo $__env->make('OPDMS.partials.loader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="ancillary-table">
                                    <thead>
                                        <tr class="bg-gray">
                                            <th></th>
                                            <th hidden></th>
                                            <th>Service Name</th>
                                            <th>Price</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="ancillary-tbody">
                                    </tbody>
                                    <tfoot>
                                        <tr class="deeper_tr">
                                            <td colspan="5" class="text-center">HIT ENTER KEY TO SEARCH DEEPER</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>    
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-4 side-bar-container">
                              <!-- /btn-group -->
                              <div class="input-group search-input">
                                <input type="text" name="sub" id="sub-search-input" class="form-control input-sm" placeholder="Pathology Name..." autofocus/>
                                <span class="input-group-btn">
                                    <button class="btn btn-success btn-sm" type="submit" id="search-button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                              </div>
                              <div class="">
                                  <ul class="sidebar-menu ancillary-sidebar-special" data-widget="tree" id="ancillary-sidebar-special">
                                     
                                  </ul>
                              </div>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-12">
                        <div class="text-right status-button">
                            <button class="btn btn-flat bg-yellow-active btn-xs" status="Unpaid">UNPAID</button>
                            <button class="btn btn-flat bg-green-active btn-xs" status="Paid">PAID / CHARITY</button>
                            <button class="btn btn-flat bg-yellow-active btn-xs" status="Pending">PENDING</button>
                            <button class="btn btn-flat bg-aqua-active btn-xs" status="Done">DONE</button>
                            <button class="btn btn-flat bg-gray-active btn-xs" status="All" id="selected">ALL</button>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-12 div-ancillary-request">
                            <?php echo $__env->make('OPDMS.partials.loader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                            <form method="post" id="pendingrequesrform" action="<?php echo e(url('laboratorypatients')); ?>">
                                <?php echo e(csrf_field()); ?>

                                <div class="table-responsive table-responsive-ancillary-request">
                                    <table class="table table-striped table-hover" id="ancillary-request">
                                        <thead>
                                            <tr class="bg-gray">
                                                <th></th>
                                                <th hidden></th>
                                                <th>Service Name</th>
                                                <th>Price</th>
                                                <th>Qty</th>
                                                <th>Amount</th>
                                                <th>MSS <br> Discount</th>
                                                <th>Sponsored</th>
                                                <th>Net Amount</th>
                                                <th>Payment <br>Status</th>
                                                <th>Process <br> Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="ancillary-request-tbody">
                                        </tbody>
                                        <tfoot class="ancillary-request-tfoot">
                                            <tr>
                                                <th colspan="4">Total</th>
                                                <th class="text-right item_amount">0.00</th>
                                                <th class="text-right item_discount">0.00</th>
                                                <th class="text-right item_netamount">0.00</th>
                                                <th colspan="2"></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
           
            <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left btn-sm" data-dismiss="modal"><span class="fa fa-close"></span> Close</button>
                <button type="button" class="btn btn-danger btn-sm" id="remove"><span class="fa fa-remove"></span> Remove request</button>
                <button type="button" class="btn btn-default btn-sm" id="print-charge-slip"><span class="fa fa-print"></span> Print charge slip</button>
                <button type="button" class="btn btn-warning btn-sm" id="undone"><span class="fa fa-rotate-left"></span> Undone | Move back to pending</button>
                <button type="button" class="btn btn-info btn-sm" id="done"><span class="fa fa-check"></span> Done</button>
                <button type="button" class="btn btn-default btn-sm" id="print"><span class="fa fa-print"></span> Print request form</button>
                <!-- <button type="submit" class="btn btn-success btn-sm" form="pendingrequesrform" id="save"><span class="fa fa-save"></span> Save</button> -->
                <button type="submit" class="btn btn-success btn-sm" id="proceed"><span class="fa fa-angle-double-right"></span> Proceed</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->