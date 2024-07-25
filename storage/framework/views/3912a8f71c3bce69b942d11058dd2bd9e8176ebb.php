<div class="row">

        <div class="col-md-3">
            <h2 class="text-left">Patients</h2>
        </div>

        <br class="visible-xs">

    <div class="col-md-9">
        <ul class="nav nav-pills pull-right">
            <li>
                <a href="<?php echo e(url('patientlist')); ?>"
                   class="pendingTab <?php echo e(($status == false)? 'pendingTabActive' : ''); ?>">
                    <small class="hidden-xs">Pending</small>
                    <span class="badge">
                        <?php echo e((isset($survey[0]->pending) || isset($survey[0]->serving))? $survey[0]->pending + $survey[0]->serving: 0); ?>

                    </span>
                </a>
            </li>
            <li>
                <a href="<?php echo e(url('patientlist/H')); ?>"
                   class="pausedTab <?php echo e(($status == 'H')? 'pausedTabActive' : ''); ?>">
                    <small class="hidden-xs">Paused </small>
                    <span class="badge"><?php echo e((isset($survey[0]->paused))? $survey[0]->paused : 0); ?></span>
                </a>
            </li>
            <li>
                <a href="<?php echo e(url('patientlist/C')); ?>"
                   class="nawcTab <?php echo e(($status == 'C')? 'nawcTabActive' : ''); ?>">
                    <small class="hidden-xs">NAWC</small>
                    <span class="badge"><?php echo e((isset($survey[0]->nawc))? $survey[0]->nawc : 0); ?></span>
                </a>
            </li>
            <li>
                <a href="<?php echo e(url('patientlist/F')); ?>"
                   class="finishedTab <?php echo e(($status == 'F')? 'finishedTabActive' : ''); ?>">
                    <small class="hidden-xs">Finished </small>
                    <span class="badge"><?php echo e((isset($survey[0]->finished))? $survey[0]->finished : 0); ?></span>
                </a>
            </li>
            <li>
                <a href="<?php echo e(url('patientlist/S')); ?>"
                   class="servingTab <?php echo e(($status == 'S')? 'servingTabActive' : ''); ?>">
                    <small class="hidden-xs">Serving</small>
                    <span class="badge"><?php echo e((isset($survey[0]->serving))? $survey[0]->serving : 0); ?></span>
                </a>
            </li>
            <li>
                <a href="<?php echo e(url('patientlist/T')); ?>"
                   class="totalTab <?php echo e(($status == 'T')? 'totalTabActive' : ''); ?>">
                    <small class="hidden-xs">Total</small>
                    <span class="badge">
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
