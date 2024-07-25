<br>

<div>

    <div class="text-right">
        <form action="<?php echo e(url('monitoring')); ?>" method="post" class="form-inline" role="form">

            <?php echo e(csrf_field()); ?>



            <div class="form-group">
                <div class="radio">
                    <label><input type="radio" value="daily" name="optradio" class="dailyBtn" checked> Daily</label>
                </div>
                &nbsp;
                <div class="radio">
                    <label><input type="radio" value="monthly" name="optradio" class="monthlyBtn"> Monthly</label>
                </div>
            </div>


            &nbsp;


            <div class="form-group dailyWrapper">
                <div class="input-group">
                    <span class="input-group-addon" id="startingDate" onclick="document.getElementById('start').focus()">
                        <i class="fa fa-calendar"></i>
                    </span>
                    <input type="text" name="daily" class="form-control datepicker" value="<?php echo e(isset($daily) ? $daily : ''); ?>"
                           placeholder="Select Month" aria-describedby="startingDate" id="start" required />
                </div>
                <?php if($errors->has('daily')): ?>
                    <span class="help-block">
                        <strong class=""><?php echo e($errors->first('daily')); ?></strong>
                    </span>
                <?php endif; ?>
            </div>



            <div class="monthlyWrapper">

                <div class="form-group <?php if($errors->has('starting')): ?> has-error <?php endif; ?>">
                    <div class="input-group">
                    <span class="input-group-addon" id="startingDate" onclick="document.getElementById('starting').focus()">
                        <i class="fa fa-calendar"></i>
                    </span>
                        <input type="text" name="starting" class="form-control datepicker" value="<?php echo e(isset($starting) ? $starting : ''); ?>"
                               placeholder="Starting Date" aria-describedby="startingDate" id="starting" />
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
                        <input type="text" name="ending" class="form-control datepicker" value="<?php echo e(isset($ending) ? $ending : ''); ?>"
                               placeholder="Ending Date" aria-describedby="endingDate" id="ending">
                    </div>
                    <?php if($errors->has('ending')): ?>
                        <span class="help-block">
                        <strong class=""><?php echo e($errors->first('ending')); ?></strong>
                    </span>
                    <?php endif; ?>
                </div>

            </div>


            &nbsp;

            <div class="form-group">
                <button class="btn btn-success">Submit</button>
            </div>

        </form>


    </div>

</div>

<br>

