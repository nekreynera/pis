<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPD | Top Leading Services
    <?php $__env->endSlot(); ?>

<?php $__env->startSection('pagestyle'); ?>
    <link href="<?php echo e(asset('public/plugins/css/jquery-ui.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/radiology/reports/highestCases.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>


<?php $__env->startSection('header'); ?>
    <?php if(Auth::user()->role == 5): ?>
        <?php echo $__env->make('receptions.navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php else: ?>
        <?php echo $__env->make('radiology/navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>
    <br>
    <div class="container-fluid">


        <div class="container">



            <?php echo $__env->make('receptions.reports.topLeadingSearch', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


            <?php if($starting && $ending): ?>

                <?php
                    $startMonth = Carbon::parse($start)->month;
                    $endMonth = Carbon::parse($end)->month;
                    $total = 0;
                    $monthTotal = array();
                ?>

                <?php if(!empty($reports)): ?>


                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr class="bg-primary">
                                <th colspan="16" class="text-center">TOP LEADING SERVICES</th>
                            </tr>
                            <tr>
                                <th colspan="16" class="text-center">DIAGNOSTIC</th>
                            </tr>
                            <tr>
                                <th rowspan="2">#</th>
                                <th rowspan="2" class="text-center">NAME OF CASES</th>
                                <th colspan="2" class="text-center">Number of Consultations</th>
                                <th colspan="12" class="text-center">Month</th>
                            </tr>
                            <tr>
                                <td>SubTotal</td>
                                <td>Total</td>
                                <?php for($i=1;$i<13;$i++): ?>
                                    <td>
                                        <?php echo e(Carbon::parse("2018-$i-01")->format('F')); ?>

                                    </td>
                                <?php endfor; ?>
                            </tr>
                            </thead>


                            <tbody>

                            <?php if(!empty($reports)): ?>

                                <?php
                                    for ($k=1;$k<13;$k++){
                                        $monthTotal['m'.$k] = 0;
                                    }
                                ?>

                                <?php $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <tr>
                                        <td>
                                            <?php echo e($loop->index + 1); ?>

                                        </td>
                                        <td>
                                            <?php echo e($row->sub_category); ?>

                                        </td>
                                        <td></td>
                                        <td>
                                            <?php echo e($row->total); ?>

                                        </td>
                                        <?php for($i=1;$i<13;$i++): ?>
                                            <td>
                                                <?php if($i >= $startMonth && $i <= $endMonth): ?>
                                                    <?php
                                                        $query = App\Ancillaryrequist::topLeading($row->id, Carbon::create(Carbon::parse($start)->year, $i)->format('Y-m'))
                                                    ?>
                                                    <?php echo e((empty($query))? '' : $query); ?>

                                                    <?php
                                                        $monthTotal['m'.$i] += $query;
                                                    ?>
                                                <?php endif; ?>
                                            </td>
                                        <?php endfor; ?>
                                    </tr>


                                    <?php
                                        ($row->total)? $total+=$row->total : '';
                                    ?>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



                            <?php endif; ?>

                            </tbody>

                            <tfoot>
                                <tr>
                                    <td colspan="2">Total</td>
                                    <td></td>
                                    <td><?php echo e($total); ?></td>
                                    <?php for($i=1;$i<13;$i++): ?>
                                        <td>
                                            <?php echo e($monthTotal['m'.$i]); ?>

                                        </td>
                                    <?php endfor; ?>
                                </tr>
                            </tfoot>

                        </table>
                    </div>


                <?php else: ?>

                    <h4 class="text-center text-danger">
                        Sorry! No Results Found.
                    </h4>

                <?php endif; ?>


            <?php else: ?>

                <h4 class="text-center text-danger">
                    Please select a date to be retrieve <i class="fa fa-warning"></i>
                </h4>

            <?php endif; ?>


            <hr>


        </div>

    </div>

<?php $__env->stopSection(); ?>



<?php $__env->startSection('footer'); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('pagescript'); ?>


    <?php echo $__env->make('message.toaster', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <script src="<?php echo e(asset('public/plugins/js/jquery-ui.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/radiology/reports/reports.js')); ?>"></script>


<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>
