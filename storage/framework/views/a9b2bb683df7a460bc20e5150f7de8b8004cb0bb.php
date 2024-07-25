<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPD | CASHIER
    <?php $__env->endSlot(); ?>

<?php $__env->startSection('pagestyle'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('public/OPDMS/plugins/jquery-ui/jquery-ui.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('public/AdminLTE/bower_components/select2/dist/css/select2.min.css')); ?>" />

    <link href="<?php echo e(asset('public/css/doctors/reset.css')); ?>" rel="stylesheet" />
    <?php if(Auth::user()->theme == 2): ?>
        <link href="<?php echo e(asset('public/css/doctors/darkstyle.css')); ?>" rel="stylesheet" />
    <?php else: ?>
        <link href="<?php echo e(asset('public/css/doctors/greenstyle.css')); ?>" rel="stylesheet" />
    <?php endif; ?>
        <link href="<?php echo e(asset('public/OPDMS/css/patients/main.css')); ?>" rel="stylesheet" />
        <link href="<?php echo e(asset('public/OPDMS/css/patients/check_patient.css')); ?>" rel="stylesheet" />
        <link href="<?php echo e(asset('public/OPDMS/css/patients/result_patient.css')); ?>" rel="stylesheet" />

        <link href="<?php echo e(asset('public/css/cashier/main.css')); ?>" rel="stylesheet" />
        <link href="<?php echo e(asset('public/css/cashier/manual.css')); ?>" rel="stylesheet" />
        <link href="<?php echo e(asset('public/css/cashier/income.css')); ?>" rel="stylesheet" />

<?php $__env->stopSection(); ?>



<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('cashier.navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('cashier/dashboard'); ?>
        <?php $__env->startSection('main-content'); ?>
            <div class="container-fluid cashier-container" style="margin-top: 70px;">
                <form class="submittransaction" method="post" action="<?php echo e(url('submittransaction')); ?>">
                <div class="col-md-9">
                        <div class="col-md-12">
                            <input type="hidden" name="mss_discount" class="mss_discount" value="">
                            <div class="row patient-information">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="">HOSPITAL NO</label>
                                        <div class="form-group">
                                            <input type="text" name="" class="form-control hospital_number">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group ">
                                    <label class="">NAME</label>
                                    <div class="form-group" >
                                        <input type="text" name="" class="form-control patient_name">
                                    </div>
                                </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group ">
                                        <label class="">CLASSIFICATION</label>
                                        <div class="formgroup">
                                            
                                            <select class="form-control patient_classification">
                                                
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="">SEX</label>
                                        <div class="formgroup">
                                            <input type="text" name="" class="form-control patient_sex">
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    
                    <div class="col-md-12">
                                        
                        <div class="row text-center cashier-banner">
                            <div class="addbutton pull-left">
                                <label>Number of Request.</label>
                                <select id="participants" class="input-mini required-entry">
                                    <?php for ($i=1; $i <= 15 ; $i++): ?>
                                    <option id="lineno" value="<?php echo $i ?>"><?php echo $i ?></option>
                                    <?php endfor; ?>
                                </select>
                                <button class="btn btn-default add" type="button"><span class="glyphicon glyphicon-plus"></span></button>
                            </div>
                            <div class="addbuttonincome pull-left">
                                <label>Number of Request.</label>
                                <select id="participantsincome" class="input-mini required-entryincome">
                                    <?php for ($i=1; $i <= 15 ; $i++): ?>
                                    <option id="lineno" value="<?php echo $i ?>"><?php echo $i ?></option>
                                    <?php endfor; ?>
                                </select>
                                <button class="btn btn-default addincome" type="button"><span class="glyphicon glyphicon-plus"></span></button>
                            </div>
                            PATIENT REQUEST
                        </div>
                        <div class="row forrequest">
                            <div class="table-responsive requestarea">
                                <table class="table table-hover table-striped table-bordered">
                                    <thead>
                                        <tr id="thead">
                                            <th>entry</th>
                                            <th>Pricing<b>(php)</b></th>
                                            <th>Qty</th>
                                            <th>Amount</th>
                                            <th class="th-discount" id="">MSS <br><b><small>Discount</small></b></th>
                                            <th class="th-discount" id="">Guarantor <br><b><small>granted amount</small></b></th>
                                            <th>Net Amount</th>
                                            <th>Charge By</th>
                                            <th>Datetime</th>
                                        </tr>
                                    </thead>
                                    <tbody class="itemsbody">
                                        <?php for($i=1;$i<=20;$i++): ?>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td width="100px;"></td>
                                                <td width="50"></td>
                                                <td width="100px;"></td>
                                                <td width="100px;"></td>
                                                <td width="150px;"></td>
                                                <td width="100px;"></td>
                                                <td width="100px;"></td>
                                                <td width="100px;"></td>
                                            </tr>
                                        <?php endfor; ?>
                                      
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row cashier-footer text-right">
                           
                               
                            
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="row button-payment">
                        <div class="button-banner">
                            <label>TRANSACTIONS</label>
                        </div>
                        <div class="button-body">
                            <a class="btn btn-default printid" data-toggle="modal" data-target="#searchpatient-modal"><span class="fa fa-id-card"></span> HOSPITAL-ID</a>
                            <a class="btn btn-default printid" data-toggle="modal" data-target="#reprint-modal"><span class="fa fa-id-card"></span> RE-PRINT HOSPITAL-ID</a>
                            <a class="btn btn-default modal-button" id="income"><span class="fa fa-money"></span> INCOME</a>
                            <!-- <a class="btn btn-default modal-button" id="medicine"><span class="fa fa-medkit"></span> MEDICINE</a> -->
                            <!-- <a class="btn btn-default modal-button" id="manual"><span class="fa fa-keyboard-o"></span> MANUAL</a> -->
                            <a href="<?php echo e(url('transaction')); ?>" class="btn btn-default" target="_blank"><span class="fa fa-list-alt"></span> TRANSACTION</a>
                            <a data-toggle="modal" data-target="#editreciept-modal" class="btn btn-default"><span class="fa fa-list-alt"></span> SET O.R SERIES</a>
                        </div>
                        
                    </div>
                     <div class="row patient-payment">
                        <div class="patient-payment-banner">
                            <label>PAYMENT SUMMARY</label>
                        </div>
                    <!-- <div class="row reciept-number"> -->
                        <div class="form-group ">
                            <label class="col-sm-4">O.R NO.</label>  
                            <div class="col-sm-8 formgroup">
                                <input type="text" name="invoicno" class="form-control invoicno" readonly style="color:red;font-weight: bold;border: 1px solid black; font-size: 16px;"> 
                            </div>
                        </div>
                          
                    <!-- </div> -->
                        <div class="form-group ">
                        <label class="col-sm-4">AMOUNT</label>
                            <div class="col-sm-8 formgroup">
                                <input type="text" name="tot_amount" class="form-control tot_amount" readonly> 
                            </div>
                        </div>
                        <div class="form-group ">
                        <label class="col-sm-4">DISCOUNT</label>
                            <div class="col-sm-8 formgroup">
                                <input type="text" name="tot_discount" class="form-control tot_discount" readonly> 
                            </div>
                        </div>
                        <div class="form-group ">
                        <label class="col-sm-3">TOTAL<b>(php)</b></label>
                            <div class="col-sm-9 formgroup">
                                <input type="text" name="tot_payment" class="form-control tot_payment" style="height: 50px;font-size: 20px;" readonly>   
                            </div>
                        </div>
                        <div class="form-group ">
                            <label class="col-sm-4">CASH<b>(php)</b></label>
                            <div class="col-sm-8 formgroup">
                                <input type="text" name="cash" class="form-control cash">
                            </div>
                        </div>
                        <div class="form-group ">
                        <label class="col-sm-4">CHANGE</label>
                            <div class="col-sm-8 formgroup">
                                <input type="text" name="change" class="form-control change" readonly> 
                            </div>
                        </div>

                        <div class="form-group pull-right">
                            <br>
                            <?php echo e(csrf_field()); ?>

                            <div class="transaction-content">
                                
                            </div>
                            <a href="<?php echo e(url('cashier')); ?>" class="btn btn-default"><span class="fa fa-arrow-left"></span> CANCEL</a>
                            <button type="submit" class="btn btn-default" style="font-weight: bold;">PROCEED <span class="fa fa-arrow-right"></span></button> 
                        </div>

                    
                </div>
                
            </div>
            </form>
            <div id="searchpatient-modal" class="modal" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            SELECT PATIENT
                        </div>
                        <div class="modal-body">
                            <div class="submitclassificationloader">
                              <img src="public/images/loader.svg">
                            </div>
                           <div class="row search-section">
                            <form class="searchpatientbyhospital" method="post" action="<?php echo e(url('searchpatient')); ?>" onsubmit="searchpatient($(this))">
                              <div class="col-md-7 calendar">
                                </div>
                              <div class="col-md-3" style="padding-right: 0px;">
                                <div class="input-group">
                                  <input type="text" id="hospital" class="form-control" placeholder="hosp no..">
                                  <span class="input-group-addon fa fa-search"></span>
                                </div>
                              </div>
                              <div class="col-md-2">
                                    <button type="submit" class="btn btn-default btn-xs"> Search </button>    
                              </div>
                              
                            </form>
                              
                              <div class="col-md-12 table-th">
                                <div class="col-md-1">
                                  
                                </div>
                                <div class="col-md-3">
                                  Hosp No 
                                </div>
                                <div class="col-md-6">
                                  Name
                                </div>
                                <div class="col-md-2">
                                  Age
                                </div>
                                <div class="col-md-12 table-responsive">
                                  <table class="table table-hover table-striped" id="myTable">
                                    <tbody class="tablebody">
                                      <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                      <tr >
                                        <td><input type="radio" name="names" id="not" class="radio check-patient" value="<?php echo e($list->id); ?>" style="height:12px"></td>
                                        <td><?php echo e($list->hospital_no); ?></td>
                                        <td><?php echo e($list->name); ?></td>
                                        <td><?php echo e($list->age); ?></td>
                                      </tr>
                                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                           </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="" class="hidden_id">
                            <button type="button" class="btn btn-default selectpatient">Select</button>
                            <button type="button" class="btn btn-default cancelselect" data-dismiss="modal">Close</button>
                            
                        </div>
                    </div>
              </div>
            </div>


            <div id="reprint-modal" class="modal" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            SELECT PATIENT &nbsp;(RE-PRINT PATIENT ID)
                        </div>
                        <div class="modal-body">
                            <div class="submitclassificationloader">
                              <img src="public/images/loader.svg">
                            </div>
                           <div class="row search-section">
                            <form class="searchreprintid" method="post" action="<?php echo e(url('searchpatient')); ?>" onsubmit="searchreprintid($(this))">
                                <div class="col-md-7">
                               
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group">
                                      <input type="text" id="hospitals" onkeyup="" class="form-control" placeholder="hosp no..">
                                      <span class="input-group-addon fa fa-search"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-default btn-xs"> Search </button>    
                                </div>
                             </form>
                             <!--  <div class="col-md-12 calendar">
                                  <a href="#" class="dropdown-toggle btn btn-default" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                      CHOOSE MONTH 
                                      <span class="caret"></span>
                                  </a>
                                  <ul class="dropdown-menu reprintmonths">
                                      
                                      
                                      
                                     
                                  </ul>
                              </div> -->
                              <div class="col-md-12 table-th">
                                <div class="col-md-1">
                                  
                                </div>
                                <div class="col-md-3">
                                  Hosp No 
                                </div>
                                <div class="col-md-6">
                                  Name
                                </div>
                                <div class="col-md-2">
                                  Age
                                </div>
                                <div class="col-md-12 table-responsive">
                                  <table class="table table-hover table-striped" id="myTables">
                                    <tbody class="tablebodys">
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                           </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="" class="hidden_id">
                            <button type="button" class="btn btn-default selectpatientreprint">Select</button>
                            <button type="button" class="btn btn-default cancelselect" data-dismiss="modal">Close</button>
                            
                        </div>
                    </div>
              </div>
            </div>


            <div id="scan-modal" class="modal" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            SCAN QRcode/Barcode
                        </div>
                        <div class="modal-body">
                            <form class="scanbarcode">
                                <div class="text-right">
                                    <a href="#" class="walk-in-patient">Walk-in Patient</a>
                                </div>
                                <label class="error_msg" style="color: red;font-size: 12px;display: none;">patient classification expired 
                                    <a href="#" class="continue" style="color: rgb(35, 82, 124);cursor: pointer;"> &nbsp;&nbsp; <b>continue</b> </a> 
                                </label>
                                <label class="error_msgs" style="color: red;font-size: 12px;display: none;">patient is not classified 
                                    <a href="#" class="continue" style="color: rgb(35, 82, 124);cursor: pointer;"> &nbsp;&nbsp; <b>continue</b> </a> 
                                </label>
                                <label class="error_ms" style="color: red;font-size: 12px;display: none;">
                                </label>
                                
                                <div class="form-group">
                                    <input type="text" name="barcode" class="form-control barcodeinput" 
                                    placeholder="Enter Patient QRcode/Hospital no" autofocus required />
                                    <br><br>
                                </div>
                                <div class="alert alert-info alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <h4><i class="icon fa fa-info"></i> Info!</h4>
                                    If the patient is <b>walk-in</b>. Click the "<b>Walk-in Patient</b> link, located at the upper right corner of this window modal. 
                                    <p>Flow for the walk-in patient: </p>
                                        <ol>
                                            <li>1. Triage</li>
                                            <li>2. Cashier</li>
                                            <li>3. Diagnostics Center</li>
                                        </ol>
                                </div>
                                
                            </form>
                            <br/>
                            <br/>
                            <p class="text-center">
                                <strong>“ Credential for patients transactions ”</strong>
                            </p>
                            <p class="text-center">
                                Please scan/input patient barcode/QRcode so that the patient  <br>
                                requisition will be properly transact.
                            </p>
                            
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="" class="hidden_id">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
              </div>
            </div>
            <div id="editreciept-modal" class="modal" role="dialog">
                <div class="modal-dialog">
                    <form class="submitreciept">
                        <div class="modal-content">
                            <div class="modal-header">
                                SET O.R SERIES
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <div class="bg-success text-center reciept-msg">
                                        <p>O.R number updated</p>
                                    </div>
                                    <div class="row">
                                        <br>
                                        <br>
                                         <div class="col-md-8" style="padding-right: 5px;">
                                            <input type="number" name="barcode" class="form-control input-reciept" 
                                        placeholder="" autofocus required /> 
                                        </div>
                                        <div class="col-md-4" style="padding-left: 5px;">
                                            <select class="form-control select-reciept" required>
                                                <option value="" hidden>CHOOSE</option>
                                                <option value="INCOME">INCOME</option>
                                                <option value="MEDICINE">MEDICINE</option>
                                            </select>   
                                        </div>
                                        <br>
                                        <br>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="" class="hidden_id">
                                <button type="submit" class="btn btn-default">Save</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                
                            </div>
                        </div>
                    </form>
              </div>
            </div>

            <!-- .content-wrapper -->
            <?php echo $__env->make('cashier.modals.alert', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php echo $__env->make('cashier.modals.walkin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php echo $__env->make('OPDMS.patients.modals.check_patient', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php echo $__env->make('OPDMS.patients.modals.check_result', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php $__env->stopSection(); ?>
    <?php echo $__env->renderComponent(); ?>
<?php $__env->stopSection(); ?>




<?php $__env->startSection('footer'); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('pagescript'); ?>
    <script src="<?php echo e(asset('public/OPDMS/plugins/jquery-ui/jquery-ui.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/AdminLTE/plugins/input-mask/jquery.inputmask.js')); ?>"></script>
    <script src="<?php echo e(asset('public/AdminLTE/plugins/input-mask/jquery.inputmask.date.extensions.js')); ?>"></script>
    <script src="<?php echo e(asset('public/AdminLTE/plugins/input-mask/jquery.inputmask.extensions.js')); ?>"></script>
    <script src="<?php echo e(asset('public/AdminLTE/bower_components/select2/dist/js/select2.full.min.js')); ?>"></script>

    <?php if(!$alert): ?>
        <script>
            $("#alertModal").modal({backdrop: "static"});
        </script>
    <?php else: ?>
        <script>
            $("#alertModal").modal('hide');
        </script>
    <?php endif; ?>
    <script>
        // $('#modal-medical-records').modal("toggle");
        var dateToday = '<?php echo e(Carbon::today()->format("m/d/Y")); ?>';
    </script>
    <?php echo $__env->make('message.toaster', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <script src="<?php echo e(asset('public/OPDMS/js/patients/main.js')); ?>"></script>
    <script src="<?php echo e(asset('public/OPDMS/js/patients/check_patient.js')); ?>"></script>
    <script src="<?php echo e(asset('public/OPDMS/js/patients/result_patient.js')); ?>"></script>
    <script src="<?php echo e(asset('public/OPDMS/js/patients/search.js')); ?>"></script>
    <script src="<?php echo e(asset('public/OPDMS/js/patients/table.js')); ?>"></script>
    <script src="<?php echo e(asset('public/OPDMS/js/patients/edit_patient.js')); ?>"></script>


    <script src="<?php echo e(asset('public/plugins/js/form.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/modernizr.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/jquery.menu-aim.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/pharmacy/main.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/cashier/main.js?v1.0.1')); ?>"></script>
    <script src="<?php echo e(asset('public/js/cashier/id.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/cashier/medicine.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/cashier/manual.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/cashier/income.js?v1.0.3')); ?>"></script>
    <script src="<?php echo e(asset('public/js/cashier/walkin.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/cashier/address.js')); ?>"></script>
<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>
