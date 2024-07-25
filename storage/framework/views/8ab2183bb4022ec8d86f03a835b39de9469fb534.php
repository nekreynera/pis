<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPD | CASHIER
    <?php $__env->endSlot(); ?>

<?php $__env->startSection('pagestyle'); ?>
    <link href="<?php echo e(asset('public/css/doctors/reset.css')); ?>" rel="stylesheet" />
    <?php if(Auth::user()->theme == 2): ?>
        <link href="<?php echo e(asset('public/css/doctors/darkstyle.css')); ?>" rel="stylesheet" />
    <?php else: ?>
        <link href="<?php echo e(asset('public/css/doctors/greenstyle.css')); ?>" rel="stylesheet" />
    <?php endif; ?>
        <link href="<?php echo e(asset('public/css/cashier/main.css')); ?>" rel="stylesheet" />
        <link href="<?php echo e(asset('public/css/cashier/jquery.datepicker.css')); ?>" rel="stylesheet" />
        <link href="<?php echo e(asset('public/css/cashier/transaction.css')); ?>" rel="stylesheet" />

<?php $__env->stopSection(); ?>



<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('cashier.navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('cashier/dashboard'); ?>
        <?php $__env->startSection('main-content'); ?>
            <div class="container-fluid cashier-container" style="margin-top: 70px;">
                <div class="col-md-9">
                        <div class="col-md-12">
                            <input type="hidden" name="mss_discount" class="mss_discount" value="">
                            <form method="get">
                            <div class="row patient-information">
                                <div class="col-sm-3">
                                    <div class="form-group ">
                                        <label class="">NAME</label>
                                        <div class="form-group" >
                                            <div class="input-group">
                                                <input type="search" name="hospital_no" class="form-control" id="patient_name">
                                                <span class="input-group-addon fa fa-search"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                               <!--  <div class="col-sm-3">
                                    <div class="form-group ">
                                        <label class="">HOSPITAL NO</label>
                                        <div class="form-group" >
                                            <div class="input-group">
                                                <input type="search" name="hospital_no" class="form-control" id="hospital">
                                                <span class="input-group-addon fa fa-search"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                                 <div class="col-sm-3">
                                    <div class="form-group ">
                                        <label class="">RECIEPT NO</label>
                                        <div class="formgroup">
                                            <div class="input-group">
                                            <input type="search" name="reciept_no" class="form-control" id="reciept">
                                            <span class="input-group-addon fa fa-search"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="">TRANSACTION TYPE</label>
                                        <div class="formgroup">
                                            <input name="transaction" class="form-control" id="transaction" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                    
                    <div class="col-md-12">
                                        
                        <div class="row text-center cashier-banner">
                            
                            TRANSACTIONS
                        </div>
                        <div class="row transaction-body">
                            <div class="table-responsive transaction-table">
                                <table class="table table-hover table-striped table-bordered" id="myTable">
                                    <thead>
                                        <tr>
                                            <th><i class="fa fa-info-circle" ></i></th>
                                            <th></th>
                                            <th>DATE</th>
                                            <th>NUMBER</th>
                                            <th>PAYOR</th>
                                            <th>PARTICULARS</th>
                                            <th>TOTAL PER OR<b>(php)</b></th>
                                            <th>OTHER FEES</th>
                                            <th>MEDICINE</th>
                                            <th>MEDICAL <br>PHYSICAL <br>REHABILITAION</th>
                                            <th>LABORATORY</th>
                                            <th>RADIOLOGY</th>
                                            <th>CARDIOLOGY</th>
                                            <th>SUPPLIES</th>
                                        </tr>
                                    </thead>
                                    <tbody class="transaction-table-body">
                                        
                                            <?php for($i = 1; $i <= 20; $i++): ?>
                                            <tr>
                                                <td></td>
                                                <td>&nbsp;</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <?php endfor; ?>
                                       
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row cashier-footer" style="height: 150px;">
                            <div class="col-md-4">
                                <label class="col-md-4">PHARMACY</label>
                                <div class="col-md-7">
                                    <input type="text" name="" class="form-control tot_medicine" readonly>
                                </div><br>
                                <label class="col-md-4">SUPPLIES</label>
                                <div class="col-md-7">
                                    <input type="text" name="" class="form-control tot_supply" readonly>
                                </div><br>
                                <!-- <label class="col-md-4">INDUSTRIAL<br>(CONSULTATION FEE)</label>
                                <div class="col-md-7">
                                    <input type="text" name="" class="form-control tot_consultation" readonly>
                                </div><br> -->
                                
                            </div>
                            <div class="col-md-4">
                                <label class="col-md-4">OTHER FEES</label>
                                <div class="col-md-7 col-md-offset-1">
                                    <input type="text" name="" class="form-control tot_otherfees" readonly>
                                </div><br>
                                <label class="col-md-4">MED/PHYS/REHAB</label>
                                <div class="col-md-7 col-md-offset-1">
                                    <input type="text" name="" class="form-control tot_rehab" readonly>
                                </div><br>
                                <label class="col-md-4">LABORATORY</label>
                                <div class="col-md-7 col-md-offset-1">
                                    <input type="text" name="" class="form-control tot_laboratory" readonly>
                                </div><br>
                                <label class="col-md-4">RADIOLOGY</label>
                                <div class="col-md-7 col-md-offset-1">
                                    <input type="text" name="" class="form-control tot_radiology" readonly>
                                </div><br>
                                <label class="col-md-4">CARDIOLOGY</label>
                                <div class="col-md-7 col-md-offset-1">
                                    <input type="text" name="" class="form-control tot_cardiology" readonly>
                                </div><br>
                            </div>
                            <div class="col-md-3 col-md-offset-1">
                                 <label class="col-md-12">MEDICINE TOTAL(php)</label>
                                <div class="col-md-11 col-md-offset-1">
                                    <input type="text" name="" class="form-control tot_medicine" readonly>
                                </div><br>
                                 <label class="col-md-12">INCOME TOTAL(php)</label>
                                <div class="col-md-11 col-md-offset-1">
                                    <input type="text" name="" class="form-control tot_income" readonly>
                                </div><br>
                                <div class="col-md-12 col-sm-12" style="margin-top: 15px;">
                                    <button class="btn btn-default" data-toggle="modal" data-target="#genarate-modal">EXPORT THIS REPORT<span class="fa fa-file-text-o"></span></button>
                                </div>
                            </div>
                          
                           <!-- <span class="">TOTAL(php)-medicine</span>
                            
                           <div class="pull-right"genarate>
                             <span>AMOUNT: <i class="tot_amount"> 0.00 </i> </span>
                             <span>DISCOUNT: <i class="tot_discount"> 0.00 </i> </span>
                             <span>NET AMOUNT: <i class="tot_netamount"> 0.00 </i> </span>  
                           </div><br>
                           <span class="">TOTAL(php)-income</span>
                           <div class="pull-right">
                             <span>AMOUNT: <i class="tot_amountv"> 0.00 </i> </span>
                             <span>DISCOUNT: <i class="tot_discountv"> 0.00 </i> </span>
                             <span>NET AMOUNT: <i class="tot_netamountv"> 0.00 </i> </span>  
                           </div> -->
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="row reciept-number">
                        <h3><?php echo e(Carbon::now()->setTime(0,0)->format('m/d/Y')); ?></h3>    
                    </div>
                    <div class="row patient-payment">

                        <div style="width: 100%; font-family: 'Arial'; margin: auto;">
                            <div class="some_datepicker">
                            </div>
                           
                        </div>

                        <div class="monthly">
                            <div class="monthlybanner">
                                    MONTHLY TRANSACTION
                            </div>
                            <div class="table-responsive tablemonthly">
                                <table class="table table-bordered table-hover">
                                    <tbody class="monthlydivision">
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row button-payment" style="margin-top: 2px;">
                        <div class="button-banner">
                            <label>COMPONENTS</label>
                        </div>
                        <div class="button-body" style="min-height: 165px;">
                            <label>TRANSACTIONS BY:</label>
                            <a class="btn btn-default daylya"><span class="fa fa-calendar"></span> DAILY</a>
                            <!-- <a class="btn btn-default monthlya"><span class="fa fa-calendar"></span> MONTHLY</a> -->
                            <label>REFLECT O.R. SERIES (VOIDED)</label>
                            <!-- <a class="btn btn-default yearlya" id="medicine" disabled><span class="fa fa-calendar"></span> YEARLY</a> -->
                            <a class="btn btn-default" data-toggle="modal" data-target="#refincome-modal"><span class="fa fa-pencil-square-o"></span> INCOME / MEDS</a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="transaction-modal" class="modal" role="dialog">
                <div class="modal-dialog">
                    <form class="submitreciept">
                        <div class="modal-content">
                            <div class="modal-header">
                                PATIENT TRANSACTION
                            </div>
                            <div class="modal-body">
                                <font class="pull-right datem"></font>
                                <table class="table table-bordered" border="0">

                                    <tr>
                                        <td>PAYOR: <b class="namem"></b></td>
                                        
                                        <td>CLASSIFICATION: <b class="classificationm"></b></td>
                                    </tr>
                                    <tr>
                                        <td>CASHIER: <b><?php echo e(strtoupper(Auth::user()->first_name.' '.substr(Auth::user()->middle_name,0,1).'. '.Auth::user()->last_name)); ?></b></td>
                                        <td>O.R NO: <b class="or_nom"></b></td>
                                    </tr>
                                </table>

                                <table class="table table-bordered" border="0">
                                    <tr>
                                        <th>ITEM</th>
                                        <th>PRICE</th>
                                        <th>QTY</th>
                                        <th>AMOUNT</th>
                                        <th>MSS <br> <small>DISCOUNT</small></th>
                                        <th>GUARANTOR <br> <small>GRANDTED AMOUNT</small></th>
                                        <th>NETAMOUNT</th>
                                    </tr>
                                    <tbody class="modaltbody">
                                        <?php for($i = 1; $i <= 8;$i++): ?>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    <?php endfor; ?>
                                    </tbody>
                                    <tr>
                                        <th colspan="6">TOTAL</th>
                                        <th style="text-align: right;" class="totalm"></th>
                                    </tr>
                                </table>

                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="" class="hidden_or">
                                <input type="hidden" name="" class="hidden_type">
                                <button type="button" class="btn btn-default reprint-reciept"><span class="fa fa-print"></span> Re-Print </button>
                                <button type="button" class="btn btn-default edit-reciept"  data-toggle="modal" data-target="#ore-modal"><span class="fa fa-file-text-o"></span> Edit Reciept</button>
                               
                                <button type="button" class="btn btn-default voidtransaction"><b></b> <span class="fa fa-ban"></span></button>    
                                <button type="button" class="btn btn-default" data-dismiss="modal"> <span class="fa fa-remove"></span> Close</button>
                            </div>
                        </div>
                    </form>
              </div>
            </div>
            <div id="ore-modal" class="modal" role="dialog">
                <div class="modal-dialog">
                    <form class="submitofficialreciept form-horizontal">
                        <div class="modal-content">
                            <div class="modal-header">
                                OFFICIAL RECIEPT EDITING
                            </div>
                            <div class="modal-body">
                                <div class="pull-left" style="position: absolute;">
                                    <span class="fa fa-file-text-o pull-left"></span>
                                    
                                </div>
                               <div class="form-group">
                                    <label class="col-md-3 col-md-offset-2 ">Payer Name</label>
                                    <div class="col-md-6">
                                      <input type="text" name="payer" class="form-control payer" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 col-md-offset-2 ">Reciept Type</label>
                                    <div class="col-md-4">
                                      <input type="text" name="reciepttype" class="form-control reciepttype" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 col-md-offset-2 ">Series Type</label>
                                    <div class="col-md-4">
                                      <input type="text" name="seriespayer" class="form-control seriespayer" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 col-md-offset-2 ">Reciept No</label>
                                    <div class="col-md-4">
                                      <input type="text" name="recieptno" class="form-control recieptno" style="text-align: right;">
                                      <input type="hidden" name="recieptnoorig" class="form-control recieptno" id="recieptnoorig" style="text-align: right;">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 col-md-offset-2 ">Reciept Date</label>
                                    <div class="col-md-4">
                                      <input type="text" name="recieptdate" class="form-control recieptdate" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 col-md-offset-2 ">O.R Amount</label>
                                    <div class="col-md-4">
                                      <input type="text" name="oramount" class="form-control oramount" readonly style="text-align: right;">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-default">Post...</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-remove"></span> Close</button>
                            </div>
                        </div>
                    </form>
              </div>
            </div>

            <div id="genarate-modal" class="modal" role="dialog">
                <div class="modal-dialog">
                    <form class="form-horizontal genarate" method="GET" target="_blank" action="<?php echo e(url('dailyreport')); ?>">
                        <div class="modal-content">
                            <div class="modal-header">
                                REPORT AUTHENTICATION
                            </div>
                            <div class="modal-body">

                                <div class="form-group">
                                    <label class="col-md-4">O.R. Type</label>
                                    <div class="col-md-7">
                                        <select class="form-control mortype" name="mortype" required>
                                            <option class="income">INCOME</option>
                                            <option class="medicine">MEDICINE</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4">Report No.</label>
                                    <div class="col-md-7">
                                        <input type="text" name="mreportno" class="form-control mreportno" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-6">Undeposited Collections per last Report</label>
                                    <div class="col-md-5">
                                        <input type="text" name="undeposited" class="form-control undeposited">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5">Undeposited Collections O.R no</label>
                                    <div class="col-md-6">
                                        <input type="text" name="mgstart" class="form-control mgstart" placeholder="START-END">
                                    </div>
                                    
                                </div>
                                <div class="form-group">
                                    <label class="col-md-6">Date</label>
                                    <div class="col-md-5">
                                        <input type="text" name="mgdate" class="form-control mgdate" placeholder="DATE OF UNDEPOSITED COLLECTION">
                                        <input type="hidden" name="transdate" class="form-control transdate">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5">Official Designation</label>
                                    <div class="col-md-6">
                                        <input type="text" name="msdisignation" class="form-control msdisignation" placeholder="OFFICIAL DESIGNATION" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5">Export File as</label>
                                    <div class="col-md-6">
                                        <select class="form-control mortype" name="exporttype" required>
                                            <option class="EXCELL">EXCELL</option>
                                            <option class="PDF">PDF</option>
                                        </select>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-default" id="submit-export">Export</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-remove"></span> Close</button>
                            </div>
                        </div>
                    </form>
              </div>
            </div>
            <?php echo $__env->make('cashier.modals.reflect', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php echo $__env->make('cashier.modals.changept', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <!-- .content-wrapper -->

        <?php $__env->stopSection(); ?>
    <?php echo $__env->renderComponent(); ?>
<?php $__env->stopSection(); ?>




<?php $__env->startSection('footer'); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('pagescript'); ?>
    <?php echo $__env->make('message.toaster', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php if(count($errors) > 0): ?>
    <script>
        $(window).on('load', function(){
            $('#refincome-modal').modal('toggle');
        });
    </script>
     <?php endif; ?>
    <script src="<?php echo e(asset('public/plugins/js/form.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/modernizr.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/jquery.menu-aim.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/pharmacy/main.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/cashier/jquery.datepicker.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/cashier/transaction.js?v1.0.1')); ?>"></script>

<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>
