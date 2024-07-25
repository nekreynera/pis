<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        PIS | Census
    <?php $__env->endSlot(); ?>

<?php $__env->startSection('pagestyle'); ?>
    <link href="<?php echo e(asset('public/css/doctors/reset.css')); ?>" rel="stylesheet" />
    <?php if(Auth::user()->theme == 2): ?>
        <link href="<?php echo e(asset('public/css/doctors/darkstyle.css')); ?>" rel="stylesheet" />
    <?php else: ?>
        <link href="<?php echo e(asset('public/css/doctors/greenstyle.css')); ?>" rel="stylesheet" />
    <?php endif; ?>
    <link href="<?php echo e(asset('public/plugins/css/jquery-ui.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/plugins/css/dataTables.bootstrap.min.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/receptions/census.css')); ?>" rel="stylesheet" />

<?php $__env->stopSection(); ?>



<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('doctors.navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('doctors.dashboard'); ?>
        <?php $__env->startSection('main-content'); ?>


 <div class="content-wrapper" style="padding: 50px 0px">

        <br>
            <div class="col-md-12">

                <h4 class="text-info">
                    <span class="text-muted">Consulted by:</span>
                    DR. <?php echo e(Auth::user()->last_name.', '.Auth::user()->first_name.' '.Auth::user()->suffix.' '.Auth::user()->middle_name); ?>

                </h4>

                <hr>
                
                <div class="text-right">
                    <form action="<?php echo e(url('doctorsStoreCensus')); ?>" class="form-inline" method="post">
                        <?php echo e(csrf_field()); ?>


                        <div class="form-group <?php if($errors->has('startingDate')): ?> has-error <?php endif; ?>">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-filter"></i>
                                </span>
                                <select name="filter" id="" class="form-control">
                                    <option value="5000" <?php echo e(($limit == 5000)? 'selected' : ''); ?>>Show All</option>
                                    <option value="10" <?php echo e(($limit == 10)? 'selected' : ''); ?>>Top 10 Diseases</option>
                                    <option value="20" <?php echo e(($limit == 20)? 'selected' : ''); ?>>Top 20 Diseases</option>
                                    <option value="50" <?php echo e(($limit == 50)? 'selected' : ''); ?>>Top 50 Diseases</option>
                                </select>
                            </div>
                        </div>



                        

                        


                        &nbsp;



                        <div class="form-group <?php if($errors->has('startingDate')): ?> has-error <?php endif; ?>">
                            <div class="input-group">
                                <span class="input-group-addon" onclick="document.getElementById('starting').focus()">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                <input type="text" name="startingDate" value="<?php echo e(isset($starting) ? $starting : ''); ?>"
                                 id="starting" placeholder="Enter Starting Date" class="form-control datepicker" />
                            </div>
                            <?php if($errors->has('startingDate')): ?>
                                 <span class="help-block">
                                     <strong class=""><?php echo e($errors->first('startingDate')); ?></strong>
                                 </span>
                            <?php endif; ?>
                        </div>



                        

                        


                        &nbsp;




                        <div class="form-group <?php if($errors->has('endingDate')): ?> has-error <?php endif; ?>">
                            <div class="input-group">
                                <span class="input-group-addon" onclick="document.getElementById('endingDate').focus()">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                <input type="text" id="endingDate" value="<?php echo e(isset($ending) ? $ending : ''); ?>" name="endingDate"
                                       placeholder="Enter Ending Date" class="form-control datepicker" />
                            </div>
                            <?php if($errors->has('endingDate')): ?>
                                <span class="help-block">
                                     <strong class=""><?php echo e($errors->first('endingDate')); ?></strong>
                                 </span>
                            <?php endif; ?>
                        </div>



                        &nbsp;




                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>



                    </form>
                </div>

                <br>

            </div>
            




        <?php if($starting): ?>

        <?php if(count($census) > 0): ?>

        <div class="col-md-12">

        <div class="table-responsive">
            <table class="table table-bordered table-condensed" id="censusTable">
                <thead>
                    <tr>
                        <th colspan="3" rowspan="4" class="text-center">NAME OF CASES</th>
                    </tr>
                    <tr>
                        <th colspan="35" class="text-center">AGE(Years Old) / Gender</th>
                    </tr>
                    <tr class="bg-warning">
                        <td colspan="2">Under1</td>
                        <td colspan="2">1-4</td>
                        <td colspan="2">5-9</td>
                        <td colspan="2">10-14</td>
                        <td colspan="2">15-19</td>
                        <td colspan="2">20-24</td>
                        <td colspan="2">25-29</td>
                        <td colspan="2">30-34</td>
                        <td colspan="2">35-39</td>
                        <td colspan="2">40-44</td>
                        <td colspan="2">45-49</td>
                        <td colspan="2">50-54</td>
                        <td colspan="2">55-59</td>
                        <td colspan="2">60-64</td>
                        <td colspan="2">65-69</td>
                        <td colspan="2">Above70</td>
                        <td colspan="2">TOTAL BY GENDER</td>
                        <td colspan="2" rowspan="4" class="bg-info">TOTAL</td>
                    </tr>
                    <tr class="bg-primary">
                        <?php for($i=0;$i<17;$i++): ?>
                            <td>M</td>
                            <td>F</td>
                        <?php endfor; ?>
                    </tr>
                </thead>
                <tbody>

                    <?php
                        $ageTotal = array();
                        $maleTotal = array();
                        $femaleTotal = array();
                        $grandTotal = 0;
                    ?>
                    <?php $__currentLoopData = $census; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            //$code = substr($row->code,0,strrpos($row->code, '.'));
                            $checkCnsus = App\ConsultationsICD::getICD($starting, $ending, $row->icd, $row->code);
                            $ageArray = array();
                            $sexArray = array();
                        ?>
                        <?php $__currentLoopData = $checkCnsus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $age = App\Patient::censusage($cen->birthday);
                                $sex = ($cen->sex == null)? 'M' : $cen->sex;
                                if ($age < 1){
                                    $class = 1;
                                    $pushAge = (array_key_exists('age1', $ageTotal))? $ageTotal['age1']++ : array_push($ageTotal, $ageTotal['age1'] = 1);
                                }elseif ($age >= 1 && $age <= 4){
                                    $class = 2;
                                    $pushAge = (array_key_exists('age2', $ageTotal))? $ageTotal['age2']++ : array_push($ageTotal, $ageTotal['age2'] = 1);
                                }elseif ($age >= 5 && $age <= 9){
                                    $class = 3;
                                    $pushAge = (array_key_exists('age3', $ageTotal))? $ageTotal['age3']++ : array_push($ageTotal, $ageTotal['age3'] = 1);
                                }elseif ($age >= 10 && $age <= 14){
                                    $class = 4;
                                    $pushAge = (array_key_exists('age4', $ageTotal))? $ageTotal['age4']++ : array_push($ageTotal, $ageTotal['age4'] = 1);
                                }elseif ($age >= 15 && $age <= 19){
                                    $class = 5;
                                    $pushAge = (array_key_exists('age5', $ageTotal))? $ageTotal['age5']++ : array_push($ageTotal, $ageTotal['age5'] = 1);
                                }elseif ($age >= 20 && $age <= 24){
                                    $class = 6;
                                    $pushAge = (array_key_exists('age6', $ageTotal))? $ageTotal['age6']++ : array_push($ageTotal, $ageTotal['age6'] = 1);
                                }elseif ($age >= 25 && $age <= 29){
                                    $class = 7;
                                    $pushAge = (array_key_exists('age7', $ageTotal))? $ageTotal['age7']++ : array_push($ageTotal, $ageTotal['age7'] = 1);
                                }elseif ($age >= 30 && $age <= 34){
                                    $class = 8;
                                    $pushAge = (array_key_exists('age8', $ageTotal))? $ageTotal['age8']++ : array_push($ageTotal, $ageTotal['age8'] = 1);
                                }elseif ($age >= 35 && $age <= 39){
                                    $class = 9;
                                    $pushAge = (array_key_exists('age9', $ageTotal))? $ageTotal['age9']++ : array_push($ageTotal, $ageTotal['age9'] = 1);
                                }elseif ($age >= 40 && $age <= 44){
                                    $class = 10;
                                    $pushAge = (array_key_exists('age10', $ageTotal))? $ageTotal['age10']++ : array_push($ageTotal, $ageTotal['age10'] = 1);
                                }elseif ($age >= 45 && $age <= 49){
                                    $class = 11;
                                    $pushAge = (array_key_exists('age11', $ageTotal))? $ageTotal['age11']++ : array_push($ageTotal, $ageTotal['age11'] = 1);
                                }elseif ($age >= 50 && $age <= 54){
                                    $class = 12;
                                    $pushAge = (array_key_exists('age12', $ageTotal))? $ageTotal['age12']++ : array_push($ageTotal, $ageTotal['age12'] = 1);
                                }elseif ($age >= 55 && $age <= 59){
                                    $class = 13;
                                    $pushAge = (array_key_exists('age13', $ageTotal))? $ageTotal['age13']++ : array_push($ageTotal, $ageTotal['age13'] = 1);
                                }elseif ($age >= 60 && $age <= 64){
                                    $class = 14;
                                    $pushAge = (array_key_exists('age14', $ageTotal))? $ageTotal['age14']++ : array_push($ageTotal, $ageTotal['age14'] = 1);
                                }elseif ($age >= 65 && $age <= 69){
                                    $class = 15;
                                    $pushAge = (array_key_exists('age15', $ageTotal))? $ageTotal['age15']++ : array_push($ageTotal, $ageTotal['age15'] = 1);
                                }else{
                                    $class = 16;
                                    $pushAge = (array_key_exists('age16', $ageTotal))? $ageTotal['age16']++ : array_push($ageTotal, $ageTotal['age16'] = 1);
                                }
                            array_push($ageArray, $class.$sex);
                            $male = 0;
                            $female = 0;
                            ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <tr>
                            <td class="bg-default"><?php echo e($loop->index+1); ?></td>
                            <td><?php echo e($row->code); ?></td>
                            <td><?php echo e($row->description); ?></td>
                            <?php for($i=1;$i<18;$i++): ?>
                                    <td>
                                        <?php if(in_array($i.'M', $ageArray)): ?>
                                            <?php
                                                $censusNum = array_count_values($ageArray);
                                                $male += $censusNum[$i.'M'];
                                                (array_key_exists('m'.$i, $maleTotal))? $maleTotal['m'.$i] = $maleTotal['m'.$i] + $censusNum[$i.'M'] : $maleTotal['m'.$i] = $censusNum[$i.'M'];
                                            ?>
                                            <?php echo e($censusNum[$i.'M']); ?>

                                        <?php endif; ?>
                                        <?php if($i == 17): ?>
                                            <?php echo e($male); ?>

                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if(in_array($i.'F', $ageArray)): ?>
                                            <?php
                                                $censusNum = array_count_values($ageArray);
                                                $female += $censusNum[$i.'F'];
                                                (array_key_exists('f'.$i, $femaleTotal))? $femaleTotal['f'.$i] = $femaleTotal['f'.$i] + $censusNum[$i.'F'] : $femaleTotal['f'.$i] = $censusNum[$i.'F'];
                                            ?>
                                            <?php echo e($censusNum[$i.'F']); ?>

                                        <?php endif; ?>
                                        <?php if($i == 17): ?>
                                            <?php echo e($female); ?>

                                        <?php endif; ?>
                                    </td>
                                <?php if($i == 17): ?>
                                    <?php
                                        $grandTotal += $male + $female;
                                    ?>
                                    <td><?php echo e($male + $female); ?></td>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </tr>
                        <?php if($loop->index == count($census) - 1): ?>
                            <tr>
                                <td colspan="3">TOTAL BY SEX</td>
                                <?php for($x=1;$x<18;$x++): ?>
                                    <?php if($x < 17): ?>
                                        <td><?php echo e((array_key_exists('m'.$x, $maleTotal))? $maleTotal['m'.$x] : 0); ?></td>
                                        <td><?php echo e((array_key_exists('f'.$x, $femaleTotal))? $femaleTotal['f'.$x] : 0); ?></td>
                                    <?php endif; ?>
                                    <?php if($x == 17): ?>
                                        <td colspan="3" rowspan="2" class="text-center bg-info">
                                            <strong><?php echo e($grandTotal); ?></strong>
                                        </td>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            </tr>
                            <tr>
                                <td colspan="3">TOTAL BY AGE</td>
                                <?php for($t=1;$t<17;$t++): ?>
                                    <td colspan="2">
                                        <?php echo e((array_key_exists('age'.$t, $ageTotal))? $ageTotal['age'.$t] : 0); ?>

                                    </td>
                                <?php endfor; ?>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </tbody>
            </table>
        </div>



        <?php else: ?>
            <hr>
                <h4 class="text-danger text-center">
                    No Results Found
                </h4>
            <hr>
        <?php endif; ?>


        <?php else: ?>
            <hr>
                <h4 class="text-danger text-center">
                    Please select a date to be retreive <i class="fa fa-calendar"></i>
                </h4>
            <hr>
        <?php endif; ?>




    </div>




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
    <script src="<?php echo e(asset('public/plugins/js/jquery-ui.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/doctors/main.js')); ?>"></script>


    <script src="<?php echo e(asset('public/plugins/js/jquery-ui.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/AdminLTE/bower_components/datatables.net/js/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/AdminLTE/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')); ?>"></script>

    <script>
        $( ".datepicker" ).datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd'
            });
    </script>

<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>
