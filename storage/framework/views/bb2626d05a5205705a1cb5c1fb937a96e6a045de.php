<div class="row">

    <div class="col-md-12">
        <ul class="nav nav-pills">
            <li>
                <a href="<?php echo e(url('consultationLogs/'.$starting.'/'.$ending.'/P')); ?>"
                   class="pendingTab <?php echo e(($status == 'P')? 'pendingTabActive' : ''); ?>">
                    Pending <span class="badge"><?php echo e((isset($survey[0]->pending))? $survey[0]->pending : 0); ?></span>
                </a>
            </li>
            <li>
                <a href="<?php echo e(url('consultationLogs/'.$starting.'/'.$ending.'/H')); ?>"
                   class="pausedTab <?php echo e(($status == 'H')? 'pausedTabActive' : ''); ?>">
                    Paused <span class="badge"><?php echo e((isset($survey[0]->paused))? $survey[0]->paused : 0); ?></span>
                </a>
            </li>
            <li>
                <a href="<?php echo e(url('consultationLogs/'.$starting.'/'.$ending.'/C')); ?>"
                   class="nawcTab <?php echo e(($status == 'C')? 'nawcTabActive' : ''); ?>">
                    NAWC <span class="badge"><?php echo e((isset($survey[0]->nawc))? $survey[0]->nawc : 0); ?></span>
                </a>
            </li>
            <li>
                <a href="<?php echo e(url('consultationLogs/'.$starting.'/'.$ending.'/F')); ?>"
                   class="finishedTab <?php echo e(($status == 'F')? 'finishedTabActive' : ''); ?>">
                    Finished <span class="badge"><?php echo e((isset($survey[0]->finished))? $survey[0]->finished : 0); ?></span>
                </a>
            </li>
            <li>
                <a href="<?php echo e(url('consultationLogs/'.$starting.'/'.$ending.'/S')); ?>"
                   class="servingTab <?php echo e(($status == 'S')? 'servingTabActive' : ''); ?>">
                    Serving <span class="badge"><?php echo e((isset($survey[0]->serving))? $survey[0]->serving : 0); ?></span>
                </a>
            </li>
            <li>
                <a href="<?php echo e(url('consultationLogs/'.$starting.'/'.$ending)); ?>"
                   class="totalTab <?php echo e(($status == false)? 'totalTabActive' : ''); ?>">
                    Total <span class="badge">
                    <?php if(isset($survey) && $survey): ?>
                            <?php echo e($survey[0]->serving + $survey[0]->pending + $survey[0]->nawc + $survey[0]->finished + $survey[0]->paused); ?>

                    <?php else: ?>
                        0
                    <?php endif; ?>
                    </span>
                </a>
            </li>
        </ul>
    </div>
</div>