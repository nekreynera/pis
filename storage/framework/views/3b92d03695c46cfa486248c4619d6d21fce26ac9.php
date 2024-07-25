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


            <?php
                $st = Carbon::parse($start);
                $et = Carbon::parse($end);
                $begin = Carbon::parse($start)->month;
                $final = Carbon::parse($end)->month + 1;
                $noDoctorsClinic = array(10,48,22,21);
                $sum = array();
            ?>

                <div class="table-responsive monthlyTableWrapper">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th rowspan="2" class="text-center">Status</th>
                            <th colspan="31" class="text-center">Month</th>
                        </tr>
                        <tr>
                            <?php for($i=$begin;$i<$final;$i++): ?>
                                <th class="text-center"><?php echo e(Carbon::parse("2018-$i-01")->format('F')); ?></th>
                            <?php endfor; ?>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="finishedTabActive">
                            <td>
                                <?php echo e((!in_array(Auth::user()->clinic, $noDoctorsClinic))? 'Finished' : 'Done'); ?>

                            </td>
                            <?php for($i=$begin;$i<$final;$i++): ?>
                                <?php
                                    $day = Carbon::create($et->year, $i)->endOfMonth()->day;
                                    $startingDate = Carbon::createFromDate($st->year, $i, 01)->toDateString();
                                    $endingDate = Carbon::createFromDate($et->year, $i, $day)->toDateString();
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
                                    $result = App\Http\Controllers\MonitoringController::monitorMonthly($startingDate, $endingDate, $stat);
                                    (array_key_exists('m'.$i, $sum))? $sum['m'.$i] += $result : $sum['m'.$i] = $result;
                                ?>
                                <td class="text-center"><?php echo e($result); ?></td>
                            <?php endfor; ?>
                        </tr>

                        <?php if(!in_array(Auth::user()->clinic, $noDoctorsClinic)): ?>
                        <tr class="servingTabActive">
                            <td>
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
                            <?php for($i=$begin;$i<$final;$i++): ?>
                                <?php
                                    $day = Carbon::create($et->year, $i)->endOfMonth()->day;
                                    $startingDate = Carbon::createFromDate($st->year, $i, 01)->toDateString();
                                    $endingDate = Carbon::createFromDate($et->year, $i, $day)->toDateString();
                                    $stat = (in_array(Auth::user()->clinic, $noDoctorsClinic))? 'F' : 'S' ;
                                    $result = App\Http\Controllers\MonitoringController::monitorMonthly($startingDate, $endingDate, $stat);
                                    (array_key_exists('m'.$i, $sum))? $sum['m'.$i] += $result : $sum['m'.$i];
                                ?>
                                <td class="text-center"><?php echo e($result); ?></td>
                            <?php endfor; ?>
                        </tr>
                        <?php endif; ?>

                        <tr class="pendingTabActive">
                            <td>Pending</td>
                            <?php for($i=$begin;$i<$final;$i++): ?>
                                <?php
                                    $day = Carbon::create($et->year, $i)->endOfMonth()->day;
                                    $startingDate = Carbon::createFromDate($st->year, $i, 01)->toDateString();
                                    $endingDate = Carbon::createFromDate($et->year, $i, $day)->toDateString();
                                    $result = App\Http\Controllers\MonitoringController::monitorMonthly($startingDate, $endingDate, 'P');
                                    (array_key_exists('m'.$i, $sum))? $sum['m'.$i] += $result : $sum['m'.$i];
                                ?>
                                <td class="text-center"><?php echo e($result); ?></td>
                            <?php endfor; ?>
                        </tr>
                        <?php if(!in_array(Auth::user()->clinic, $noDoctorsClinic)): ?>
                            <tr class="pausedTabActive">
                                <td>Paused</td>
                                <?php for($i=$begin;$i<$final;$i++): ?>
                                    <?php
                                        $day = Carbon::create($et->year, $i)->endOfMonth()->day;
                                        $startingDate = Carbon::createFromDate($st->year, $i, 01)->toDateString();
                                        $endingDate = Carbon::createFromDate($et->year, $i, $day)->toDateString();
                                        $result = App\Http\Controllers\MonitoringController::monitorMonthly($startingDate, $endingDate, 'H');
                                        (array_key_exists('m'.$i, $sum))? $sum['m'.$i] += $result : $sum['m'.$i];
                                    ?>
                                    <td class="text-center"><?php echo e($result); ?></td>
                                <?php endfor; ?>
                            </tr>
                        <?php endif; ?>
                        <tr class="nawcTabActive">
                            <td>Canceled</td>
                            <?php for($i=$begin;$i<$final;$i++): ?>
                                <?php
                                    $day = Carbon::create($et->year, $i)->endOfMonth()->day;
                                    $startingDate = Carbon::createFromDate($st->year, $i, 01)->toDateString();
                                    $endingDate = Carbon::createFromDate($et->year, $i, $day)->toDateString();
                                    $result = App\Http\Controllers\MonitoringController::monitorMonthly($startingDate, $endingDate, 'C');
                                    (array_key_exists('m'.$i, $sum))? $sum['m'.$i] += $result : $sum['m'.$i];
                                ?>
                                <td class="text-center"><?php echo e($result); ?></td>
                            <?php endfor; ?>
                        </tr>
                        <?php if(!in_array(Auth::user()->clinic, $noDoctorsClinic)): ?>
                        <tr class="unassignedTabActive">
                            <td>Unassigned</td>
                            <?php for($i=$begin;$i<$final;$i++): ?>
                                <?php
                                    $day = Carbon::create($et->year, $i)->endOfMonth()->day;
                                    $startingDate = Carbon::createFromDate($st->year, $i, 01)->toDateString();
                                    $endingDate = Carbon::createFromDate($et->year, $i, $day)->toDateString();
                                    $result = App\Http\Controllers\MonitoringController::monitorMonthly($startingDate, $endingDate, 'U');
                                    (array_key_exists('m'.$i, $sum))? $sum['m'.$i] += $result : $sum['m'.$i];
                                ?>
                                <td class="text-center"><?php echo e($result); ?></td>
                            <?php endfor; ?>
                        </tr>
                        <?php endif; ?>

                        </tbody>

                        <tfoot>

                            <tr class="">
                                <th>Total</th>
                                <?php for($i=$begin;$i<$final;$i++): ?>
                                    <th class="text-center"><?php echo e($sum['m'.$i]); ?></th>
                                <?php endfor; ?>
                            </tr>


                            <?php if(Auth::user()->clinic == 22 || Auth::user()->clinic == 21): ?>
                            <tr class="">
                                <td colspan="<?php echo e($final); ?>"><br></td>
                            </tr>


                            <tr class="servingTabActive">
                                <td>
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
                                <?php for($i=$begin;$i<$final;$i++): ?>
                                    <?php
                                        $day = Carbon::create($et->year, $i)->endOfMonth()->day;
                                        $startingDate = Carbon::createFromDate($st->year, $i, 01)->toDateString();
                                        $endingDate = Carbon::createFromDate($et->year, $i, $day)->toDateString();
                                        $stat = (in_array(Auth::user()->clinic, $noDoctorsClinic))? 'F' : 'S' ;
                                        $result = App\Http\Controllers\MonitoringController::monitorMonthly($startingDate, $endingDate, $stat);
                                        (array_key_exists('m'.$i, $sum))? $sum['m'.$i] += $result : $sum['m'.$i];
                                    ?>
                                    <td class="text-center"><?php echo e($result); ?></td>
                                <?php endfor; ?>
                            </tr>
                            <?php endif; ?>

                        </tfoot>
                    </table>
                </div>


        </div>
    </div>

<?php $__env->stopSection(); ?>





<?php $__env->startSection('footer'); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('pagescript'); ?>
    <?php echo $__env->make('message.toaster', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <script src="<?php echo e(asset('public/plugins/js/jquery-ui.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/receptions/reports.js')); ?>"></script>

    <?php if(Session::has('census') && Session::get('census') == 'daily'): ?>
        <script>
            $(document).ready(function () {
                $('.dailyBtn').click();
            });
        </script>
    <?php endif; ?>


    <?php if($category): ?>
        <script>
            $(document).ready(function () {
                $('.monthlyBtn').click();
            });
        </script>
    <?php endif; ?>

<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>
