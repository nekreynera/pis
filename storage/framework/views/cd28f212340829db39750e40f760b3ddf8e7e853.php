<div class="row">
    <div class="col-md-12 text-center">
        <form action="<?php echo e(url('rcptnLogs')); ?>" method="post" class="form-inline">
            <?php echo e(csrf_field()); ?>

            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                <input type="text" required name="starting" value="<?php echo e(isset($starting) ? $starting : ''); ?>" class="form-control datepicker" required placeholder="Starting date">
            </div>
            <div class="form-group" style="margin: 0 10px 0 10px">
                <i class="fa fa-arrow-right"></i>
            </div>
            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                <input type="text" required name="ending" value="<?php echo e(isset($ending) ? $ending : ''); ?>" class="form-control datepicker" required placeholder="Ending date">
            </div>
            <div class="form-group" style="margin-left:15px">
                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-filter"></i>
                                    </span>
                    <select name="doctor" id="" class="form-control" style="height: 40px">
                        <option value="0">--Show All--</option>
                        <?php if($allDoctors): ?>
                            <?php $__currentLoopData = $allDoctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allDoctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($allDoctor->id); ?>"><?php echo e('Dr. '.strtoupper($allDoctor->name)); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
            <div class="form-group" style="margin-left:15px">
                <button class="btn btn-success" type="submit" style="height: 40px">Submit</button>
            </div>
        </form>
    </div>

</div>