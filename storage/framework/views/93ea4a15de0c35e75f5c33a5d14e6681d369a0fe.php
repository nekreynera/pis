<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPD | Monitoring
    <?php $__env->endSlot(); ?>

<?php $__env->startSection('pagestyle'); ?>
    <link href="<?php echo e(asset('public/plugins/css/jquery-ui.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/receptions/status.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/receptions/reports/monitoring.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>



<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('receptions.navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>

    <div class="container-fluid">
        <div class="container">



            <?php echo $__env->make('receptions.reports.search', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>



            <?php if($daily): ?>

            <?php
                $numDays = Carbon::parse($date)->daysInMonth + 1;
                $dt = Carbon::parse($date);
                $noDoctorsClinic = array(10,48,22,21);
                $sum = array();
                $fin = 0;
                $serv = 0;
                $pen = 0;
                $pau = 0;
                $can = 0;
                $unassgned = 0;
            ?>

            <div class="table-responsive monthlyTableWrapper">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th rowspan="3">Status</th>
                            <th colspan="<?php echo e(Carbon::parse($date)->endOfMonth()->day); ?>" class="text-center">
                                <?php echo e(Carbon::parse($date)->format('F Y')); ?>

                            </th>
                            <th rowspan="3">Total</th>
                        </tr>
                        <tr>
                            <?php for($i=1;$i<$numDays;$i++): ?>
                                <?php
                                $weekDay = Carbon::createFromDate($dt->year, $dt->month, $i)->format('l');
                                ?>
                                <th><?php echo e($weekDay[0]); ?></th>
                            <?php endfor; ?>
                        </tr>
                        <tr>
                            <?php for($i=1;$i<$numDays;$i++): ?>
                                <th><?php echo e($i); ?></th>
                            <?php endfor; ?>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td class="finishedTabActive">
                                <?php echo e((!in_array(Auth::user()->clinic, $noDoctorsClinic))? 'Finished' : 'Done'); ?>

                            </td>
                            <?php for($i=1;$i<$numDays;$i++): ?>
                                <?php
                                    $queryDate = Carbon::createFromDate($dt->year, $dt->month, $i)->toDateString();
                                    //$stat = (in_array(Auth::user()->clinic, $noDoctorsClinic))? 'D' : 'F' ;
                                    if (in_array(Auth::user()->clinic, $noDoctorsClinic)){
                                        if (Auth::user()->clinic == 22 || Auth::user()->clinic == 21){
                                            $stat = 'D';
                                        }else{
                                            $stat = 'F';
                                        }
                                    }else{
                                        $stat = 'F';
                                    }
                                    $result = App\Http\Controllers\MonitoringController::monitor($queryDate, $stat);
                                    (array_key_exists('d'.$i, $sum))? $sum['d'.$i] += $result : $sum['d'.$i] = $result;
                                    $fin += $result;
                                ?>
                                <td class="<?php echo e(($result)? 'finishedTabActive' : ''); ?>"><?php echo e($result); ?></td>
                            <?php endfor; ?>
                            <td style="background: #eee"><?php echo e($fin); ?></td>
                        </tr>

                        <?php if(!in_array(Auth::user()->clinic, $noDoctorsClinic)): ?>
                            <tr>
                                <td class="servingTabActive">
                                    
                                    <?php if(!in_array(Auth::user()->clinic, $noDoctorsClinic)): ?>
                                        Serving
                                    <?php else: ?>
                                        <?php if(Auth::user()->clinic == 22 || Auth::user()->clinic == 21): ?>
                                            Posted Result
                                        <?php else: ?>
                                            Finished
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </td>
                                <?php for($i=1;$i<$numDays;$i++): ?>
                                    <?php
                                        $queryDate = Carbon::createFromDate($dt->year, $dt->month, $i)->toDateString();
                                        $stat = (in_array(Auth::user()->clinic, $noDoctorsClinic))? 'F' : 'S' ;
                                        $result = App\Http\Controllers\MonitoringController::monitor($queryDate, $stat);
                                        (array_key_exists('d'.$i, $sum))? $sum['d'.$i] += $result : $sum['d'.$i] = $result;
                                        $serv += $result;
                                    ?>
                                    <td class="<?php echo e(($result)? 'servingTabActive' : ''); ?>"><?php echo e($result); ?></td>
                                <?php endfor; ?>
                                <td style="background: #eee">
                                   <?php echo e($serv); ?> 
                                </td>
                            </tr>
                        <?php endif; ?>

                        <tr>
                            <td class="pendingTabActive">
                                Pending
                            </td>
                            <?php for($i=1;$i<$numDays;$i++): ?>
                                <?php
                                    $queryDate = Carbon::createFromDate($dt->year, $dt->month, $i)->toDateString();
                                    $result = App\Http\Controllers\MonitoringController::monitor($queryDate, 'P');
                                    (array_key_exists('d'.$i, $sum))? $sum['d'.$i] += $result : $sum['d'.$i] = $result;
                                    $pen += $result;
                                ?>
                                <td class="<?php echo e(($result)? 'pendingTabActive' : ''); ?>"><?php echo e($result); ?></td>
                            <?php endfor; ?>
                            <td style="background: #eee">
                               <?php echo e($pen); ?> 
                            </td>
                        </tr>

                        <?php if(!in_array(Auth::user()->clinic, $noDoctorsClinic)): ?>
                            <tr>
                                <td class="pausedTabActive">Paused</td>
                                <?php for($i=1;$i<$numDays;$i++): ?>
                                    <?php
                                        $queryDate = Carbon::createFromDate($dt->year, $dt->month, $i)->toDateString();
                                        $result = App\Http\Controllers\MonitoringController::monitor($queryDate, 'H');
                                        (array_key_exists('d'.$i, $sum))? $sum['d'.$i] += $result : $sum['d'.$i] = $result;
                                        $pau += $result;
                                    ?>
                                    <td class="<?php echo e(($result)? 'pausedTabActive' : ''); ?>"><?php echo e($result); ?></td>
                                <?php endfor; ?>
                                <td style="background: #eee">
                                   <?php echo e($pau); ?> 
                                </td>
                            </tr>
                        <?php endif; ?>

                        <tr>
                            <td class="nawcTabActive">NAWC</td>
                            <?php for($i=1;$i<$numDays;$i++): ?>
                                <?php
                                    $queryDate = Carbon::createFromDate($dt->year, $dt->month, $i)->toDateString();
                                    $result = App\Http\Controllers\MonitoringController::monitor($queryDate, 'C');
                                    (array_key_exists('d'.$i, $sum))? $sum['d'.$i] += $result : $sum['d'.$i] = $result;
                                    $can += $result;
                                ?>
                                <td class="<?php echo e(($result)? 'nawcTabActive' : ''); ?>"><?php echo e($result); ?></td>
                            <?php endfor; ?>
                            <td style="background: #eee">
                                <?php echo e($can); ?>

                            </td>
                        </tr>

                        <?php if(!in_array(Auth::user()->clinic, $noDoctorsClinic)): ?>
                        <tr>
                            <td class="unassignedTabActive">Unassigned</td>
                            <?php for($i=1;$i<$numDays;$i++): ?>
                                <?php
                                    $queryDate = Carbon::createFromDate($dt->year, $dt->month, $i)->toDateString();
                                    $result = App\Http\Controllers\MonitoringController::monitor($queryDate, 'U');
                                    (array_key_exists('d'.$i, $sum))? $sum['d'.$i] += $result : $sum['d'.$i] = $result;
                                    $unassgned += $result;
                                ?>
                                <td class="<?php echo e(($result)? 'unassignedTabActive' : ''); ?>"><?php echo e($result); ?></td>
                            <?php endfor; ?>
                            <td style="background: #eee">
                                <?php echo e($unassgned); ?>

                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>

                    <tfoot>
                        <tr>
                            <th>Total</th>
                            <?php for($i=1;$i<$numDays;$i++): ?>
                                <th><?php echo e($sum['d'.$i]); ?></th>
                            <?php endfor; ?>
                            <th style="background: #333;color: #fff"><?php echo e(array_sum($sum)); ?></th>
                        </tr>

                        




                        <?php if(Auth::user()->clinic == 22 || Auth::user()->clinic == 21): ?>

                            <?php
                                $postedResult = 0;
                            ?>

                            <tr>
                                <td colspan="<?php echo e($numDays); ?>">
                                    <br>
                                </td>
                            </tr>

                            <tr>
                                <td class="servingTabActive">
                                    
                                    <?php if(!in_array(Auth::user()->clinic, $noDoctorsClinic)): ?>
                                        Serving
                                    <?php else: ?>
                                        <?php if(Auth::user()->clinic == 22 || Auth::user()->clinic == 21): ?>
                                            Posted Result
                                        <?php else: ?>
                                            Finished
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </td>
                                <?php
                                    $stat = (in_array(Auth::user()->clinic, $noDoctorsClinic))? 'F' : 'S' ;
                                ?>
                                <?php for($i=1;$i<$numDays;$i++): ?>
                                    <?php
                                        $queryDate = Carbon::createFromDate($dt->year, $dt->month, $i)->toDateString();
                                        $result = App\Http\Controllers\MonitoringController::monitor($queryDate, $stat);
                                        (array_key_exists('d'.$i, $sum))? $sum['d'.$i] += $result : $sum['d'.$i] = $result;
                                        $postedResult += $result;
                                    ?>
                                    <td class="<?php echo e(($result)? 'servingTabActive' : ''); ?>"><?php echo e($result); ?></td>
                                <?php endfor; ?>
                                <td style="background-color: #333; color: #fff">
                                    <?php echo e($postedResult); ?>

                                </td>
                            </tr>

                            <!-- <tr>
                                <th>Posted Total</th>
                                <th colspan="<?php echo e($numDays); ?>"><?php echo e($postedResult); ?></th>
                            </tr> -->

                        <?php endif; ?>

                    </tfoot>



                </table>
            </div>


            <?php else: ?>

                <hr>
                    <h4 class="text-center text-danger">Please select a date to be retrieve <i class="fa fa-calendar"></i></h4>
                <hr>

            <?php endif; ?>

        </div>
    </div>

<?php $__env->stopSection(); ?>





<?php $__env->startSection('footer'); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('pagescript'); ?>
    <?php echo $__env->make('message.toaster', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <script src="<?php echo e(asset('public/plugins/js/jquery-ui.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/receptions/reports.js')); ?>"></script>


    <?php if(Session::has('census') && Session::get('census') == 'monthly'): ?>
        <script>
            $(document).ready(function () {
               $('.monthlyBtn').click();
            });
        </script>
    <?php endif; ?>


<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>
