<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPD | Medical Services Accomplished
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



            <?php echo $__env->make('radiology.reports.searchform', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


            <?php if($starting && $ending): ?>


                <?php if(!empty($reports)): ?>


                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr class="bg-primary">
                                <th colspan="15" class="text-center">MEDICAL SERVICES ACCOMPLISHED</th>
                            </tr>
                            <tr>
                                <th colspan="15" class="text-center">DIAGNOSTIC</th>
                            </tr>
                            <tr>
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
                                    $duplicateCategory = false;
                                    $counter = 1;
                                    $noResult= false;
                                    $monthTotal = array();
                                    $totalPerRow = array();
                                    $sumPerRow = false;
                                    for ($k=1;$k<13;$k++){
                                        $monthTotal['m'.$k] = 0;
                                    }
                                ?>

                                <?php $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                                    <?php if($sumPerRow == $row->cid): ?>
                                        <?php
                                            $totalPerRow['t'.$row->cid] += $row->total;
                                        ?>
                                    <?php else: ?>
                                        <?php
                                            $totalPerRow['t'.$row->cid] = $row->total;
                                        ?>
                                    <?php endif; ?>
                                    <?php
                                        $sumPerRow = $row->cid;
                                    ?>


                                    <?php if($duplicateCategory && $duplicateCategory != $row->cid && $noResult): ?>
                                        <?php for($j=$counter;$j<13;$j++): ?>
                                            <td></td>
                                        <?php endfor; ?>
                                    <?php endif; ?>



                                    <?php if($duplicateCategory != $row->cid): ?>
                                        <?php $counter = 1 ?>
                                    <?php endif; ?>




                                    <?php if($duplicateCategory != $row->cid): ?>
                                        <tr>
                                            <?php endif; ?>

                                            <?php if($duplicateCategory != $row->cid): ?>
                                                <td class="<?php echo e($row->cid); ?>">
                                                    <?php echo e($row->sub_category); ?>

                                                </td>
                                                <td></td>
                                                <td class="<?php echo e('t'.$row->cid); ?>"></td>
                                            <?php endif; ?>


                                            <?php for($j=$counter;$j<13;$j++): ?>
                                                <td>
                                                    <?php if($row->month == $j): ?>
                                                        <?php echo e($row->total); ?>

                                                        <?php
                                                            $counter = $j + 1; $noResult = true;
                                                            $monthTotal['m'.$j] += $row->total;
                                                        ?>
                                                        <?php break; ?>
                                                    <?php else: ?>
                                                        <?php
                                                            $noResult = false;
                                                        ?>
                                                    <?php endif; ?>
                                                </td>
                                            <?php endfor; ?>


                                            <?php
                                                $duplicateCategory = $row->cid;
                                            ?>




                                            <?php if($duplicateCategory != $row->cid): ?>
                                        </tr>
                                    <?php endif; ?>



                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



                                <tr>
                                    <td class="bg-primary">
                                        <?php echo e(($category == 'N')? 'NEW' : 'OLD'); ?> PATIENTS
                                    </td>
                                    <td></td>
                                    <td><?php echo e(array_sum($totalPerRow)); ?></td>
                                    <?php for($i=1;$i<13;$i++): ?>
                                        <td>
                                            <?php echo e($monthTotal['m'.$i]); ?>

                                        </td>
                                    <?php endfor; ?>
                                </tr>

                            <?php endif; ?>

                            </tbody>
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


    <?php if(!empty($reports)): ?>


        <?php
            $arrayKeys = array_keys($totalPerRow);
        ?>


        <?php $__currentLoopData = $arrayKeys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <script>
                $(document).ready(function () {
                    $('<?php echo e(".$row"); ?>').text(<?php echo e($totalPerRow[$row]); ?>)
                })
            </script>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


    <?php endif; ?>




    <?php echo $__env->make('message.toaster', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <script src="<?php echo e(asset('public/plugins/js/jquery-ui.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/radiology/reports/reports.js')); ?>"></script>


<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>
