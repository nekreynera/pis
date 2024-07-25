<?php 
  use App\Patient;
?>
<?php $__env->startComponent('OPDMS.partials.header'); ?>


<?php $__env->slot('title'); ?>
    MEDICAL RECORDS
<?php $__env->endSlot(); ?>


<?php $__env->startSection('pagestyle'); ?>
    <link href="<?php echo e(asset('public/OPDMS/css/patients/main.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/OPDMS/css/patients/report.css')); ?>" rel="stylesheet" />
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
        ['header' => 'Reports', 'sub' => ''], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <!-- Main content -->
        <section class="content">

            <div class="box">
                <div class="box-header with-border">
                   
                    <!-- <label>NUMBER REGISTERED PATIENTS</label> -->
                </div>
                <div class="box-body">
                    <?php echo $__env->make('OPDMS.partials.loader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    <div class="report-header">
                        <form class="" method="GET">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row col-md-12">
                                        <div class="col-md-6" style="padding-right: 0px;">
                                            <select name="report" class="form-control generate-by">
                                                <option value="patients a" <?php if($request->report == 'patients a'): ?> selected <?php endif; ?>>NUMBER REGISTERED PATIENTS</option>
                                                <option value="printed a" <?php if($request->report == 'printed a'): ?> selected <?php endif; ?>>NUMBER PRINTED ID</option>
                                                <!-- <option value="3">NUMBER DISIGNATED PATIENT</option> -->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <br>
                                    </div>

                                    <div class="col-md-3 <?php if($errors->has('generate')): ?> has-error <?php endif; ?>">
                                        <label>Generate By:</label>
                                        <select name="generate" class="form-control generate-by">
                                            <option value="DATE" <?php if($request->generate == 'DATE'): ?> selected <?php endif; ?>>Daily</option>
                                            <option value="MONTH" <?php if($request->generate == 'MONTH'): ?> selected <?php endif; ?>>Monthly</option>
                                        </select>
                                        <?php if($errors->has('generate')): ?>
                                            <span class="help-block">
                                                <strong class=""><?php echo e($errors->first('generate')); ?></strong>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-3 <?php if($errors->has('user')): ?> has-error <?php endif; ?>">
                                        <label>User:</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                               <i class="fa fa-user"></i>
                                            </div> 
                                            <select name="user" class="form-control">
                                                <option value="All" <?php if($request->user == 'All'): ?> selected <?php endif; ?>>All</option>
                                                <option value="<?php echo e(Auth::user()->id); ?>"><?php echo e(ucwords(strtolower(Auth::user()->first_name)).' '.ucwords(strtolower(Auth::user()->middle_name)).' 
                                                    '.ucwords(strtolower(Auth::user()->last_name))); ?></option>
                                            </select>
                                        </div>
                                        
                                        <?php if($errors->has('user')): ?>
                                            <span class="help-block">
                                                <strong class=""><?php echo e($errors->first('user')); ?></strong>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-3 <?php if($errors->has('from')): ?> has-error <?php endif; ?>">
                                        <label>From:</label>
                                        <div class="input-group div-from-day" <?php if($request->generate == 'MONTH'): ?> style="display: none!important;" <?php endif; ?>>
                                            <div class="input-group-addon">
                                               <i class="fa fa-calendar"></i>
                                            </div> 
                                            <input type="text" name="arr_from[]" value="<?php if($request->generate == 'DATE'): ?><?php echo e($request->from); ?><?php else: ?><?php echo e(Carbon::now()->format('m/d/Y')); ?><?php endif; ?>" class="form-control from-day" id="datemask1" 
                                            data-inputmask="'alias': 'mm/dd/yyyy'" data-mask>
                                        </div>
                                        <div class="div-from-month"  
                                                <?php if($request->generate): ?>
                                                    <?php if($request->generate == 'DATE'): ?> 
                                                        style="display: none!important;" 
                                                    <?php elseif($request->generate == 'MONTH'): ?> 
                                                        style="display: block!important;" 
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    style="display: none;"
                                                <?php endif; ?>>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                   <i class="fa fa-calendar"></i>
                                                </div> 
                                                <input type="text" name="arr_from[]" value="<?php if($request->generate == 'MONTH'): ?><?php echo e($request->from); ?><?php endif; ?>" class="form-control from-month" id="from-month" 
                                                data-inputmask="'alias': 'mm/dd/yyyy'" data-mask>
                                            </div>
                                        </div>
                                        

                                        <?php if($errors->has('from')): ?>
                                            <span class="help-block">
                                                <strong class=""><?php echo e($errors->first('from')); ?></strong>
                                            </span>
                                        <?php endif; ?>
                                    </div>

                                    <div class="col-md-3 <?php if($errors->has('to')): ?> has-error <?php endif; ?>">
                                        <label>To:</label>
                                        
                                        <div class="input-group div-to-day" <?php if($request->generate == 'MONTH'): ?> style="display: none!important;" <?php endif; ?>>
                                            <div class="input-group-addon">
                                               <i class="fa fa-calendar"></i>
                                            </div> 
                                            <input type="text" name="arr_to[]" value="<?php if($request->generate == 'DATE'): ?><?php echo e($request->to); ?><?php else: ?><?php echo e(Carbon::now()->format('m/d/Y')); ?><?php endif; ?>" class="form-control to-day" id="datemask2" 
                                            data-inputmask="'alias': 'mm/dd/yyyy'" data-mask>
                                        </div>

                                        <div class="div-to-month" 
                                                <?php if($request->generate): ?>
                                                    <?php if($request->generate == 'DATE'): ?> 
                                                        style="display: none!important;" 
                                                    <?php elseif($request->generate == 'MONTH'): ?> 
                                                        style="display: block!important;" 
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    style="display: none;"
                                                <?php endif; ?>>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                       <i class="fa fa-calendar"></i>
                                                    </div> 
                                                    <input type="text" name="arr_to[]" value="<?php if($request->generate == 'MONTH'): ?><?php echo e($request->to); ?><?php endif; ?>" class="form-control to-month" id="to-month" 
                                                    data-inputmask="'alias': 'mm/dd/yyyy'" data-mask>
                                                </div>
                                            
                                        </div>
                                        

                                        <?php if($errors->has('to')): ?>
                                            <span class="help-block">
                                                <strong class=""><?php echo e($errors->first('to')); ?></strong>
                                            </span>
                                        <?php endif; ?>
                                    </div>

                                    <div class="col-md-12 text-right form-button">
                                        <button type="submit" class="btn btn-success btn-sm"><span class="fa fa-cog"></span> Generate</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="report-body">
                        <div class="row">
                            <div class="total-wrapper col-md-12">
                                <span class="col-md-6"><?php if($request->generate): ?> <?php echo e($request->generate); ?> <?php else: ?> <?php echo e('DATE'); ?> <?php endif; ?></span>
                                <span class="col-md-6">RESULT</span>
                            </div>
                            <div class="col-md-12">
                               
                                <div class="table-responsive" style="max-height: 270px;">
                                    <table class="table table-hover table-striped">
                                        <tbody>
                                            <?php
                                                $total = 0;
                                            ?>
                                            <?php if(count($data) > 0): ?>
                                            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                    $total+=$list->result;
                                                ?>
                                            <tr>
                                                <td hidden></td>
                                                <td align="center" width="51%">
                                                    <?php if($request->generate == "DATE"): ?>
                                                    <?php echo e(Carbon::parse($list->date)->format('m/d/Y')); ?>

                                                    <?php else: ?>
                                                    <?php echo e(Carbon::parse($list->date)->format('F Y')); ?>

                                                    <?php endif; ?>
                                                </td>
                                                <td align="center" width="49%"><b><?php echo e($list->result); ?></b></td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                                
                            </div>
                            <div class="total-wrapper col-md-12">
                                <span class="col-md-6">TOTAL</span>
                                <span class="col-md-6"><?php echo e($total); ?></span>
                            </div>
                        </div>
                    </div>
                <div class="box-footer">
                    <small>
                        <em class="text-muted">
                            Page where you can generate number of registered patient by month or day
                        </em>
                    </small>
                </div>
            </div>

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
<?php $__env->stopSection(); ?>





<?php $__env->startSection('aside'); ?>
    <?php echo $__env->make('OPDMS.partials.boilerplate.aside', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('pluginscript'); ?>
    <script src="<?php echo e(asset('public/AdminLTE/plugins/input-mask/jquery.inputmask.js')); ?>"></script>
    <script src="<?php echo e(asset('public/AdminLTE/plugins/input-mask/jquery.inputmask.date.extensions.js')); ?>"></script>
    <script src="<?php echo e(asset('public/AdminLTE/plugins/input-mask/jquery.inputmask.extensions.js')); ?>"></script>
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('pagescript'); ?>
    <script>
        var dateToday = '<?php echo e(Carbon::today()->format("m/d/Y")); ?>';
    </script>
    <script src="<?php echo e(asset('public/OPDMS/js/patients/main.js')); ?>"></script>
    <script src="<?php echo e(asset('public/OPDMS/js/patients/report.js')); ?>"></script>
    <script src="<?php echo e(asset('public/OPDMS/js/patients/table.js')); ?>"></script>

<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>