<div class="text-right">
    <form action="<?php echo e(url('topLeadingServices')); ?>" method="post" class="form-inline" role="form">
        <?php echo e(csrf_field()); ?>


        <div class="form-group">
            <div class="input-group">
        <span class="input-group-addon" id="startingDate" onclick="document.getElementById('start').focus()">
            <i class="fa fa-calendar"></i>
        </span>
                <input type="text" name="starting" class="form-control datepicker" value="<?php echo e($starting); ?>"
                       placeholder="Starting Date" aria-describedby="startingDate" id="start" />
            </div>
            <?php if($errors->has('starting')): ?>
                <span class="help-block">
                <strong class=""><?php echo e($errors->first('starting')); ?></strong>
            </span>
            <?php endif; ?>
        </div>


        &nbsp;<i class="fa fa-arrow-right"></i> &nbsp;



        <div class="form-group <?php if($errors->has('ending')): ?> has-error <?php endif; ?>">
            <div class="input-group">
            <span class="input-group-addon" id="endingDate" onclick="document.getElementById('ending').focus()">
                <i class="fa fa-calendar"></i>
            </span>
                <input type="text" name="ending" class="form-control datepicker" value="<?php echo e($ending); ?>"
                       placeholder="Ending Date" aria-describedby="endingDate" id="ending">
            </div>
            <?php if($errors->has('ending')): ?>
                <span class="help-block">
                <strong class=""><?php echo e($errors->first('ending')); ?></strong>
            </span>
            <?php endif; ?>
        </div>


        &nbsp;
        <div class="form-group">
            <div class="input-group">
            <span class="input-group-addon">
                <i class="fa fa-filter"></i>
            </span>
            <select name="limit" id="" class="form-control">
                <option value="10" <?php echo e(($limit == 10)? 'selected' : ''); ?>>Top 10</option>
                <option value="20" <?php echo e(($limit == 20)? 'selected' : ''); ?>>Top 20</option>
                <option value="40" <?php echo e(($limit == 40)? 'selected' : ''); ?>>Top 40</option>
                <option value="80" <?php echo e(($limit == 80)? 'selected' : ''); ?>>Top 80</option>
                <option value="100" <?php echo e(($limit == 100)? 'selected' : ''); ?>>Top 100</option>
            </select>
            </div>
        </div>

        &nbsp;
        <div class="form-group">
            <button class="btn btn-success">Submit</button>
        </div>

    </form>


    <hr>
</div>