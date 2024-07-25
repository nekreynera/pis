<?php if(!in_array(Auth::user()->clinic, $noDoctorsClinic)): ?>

    <ul class="nav nav-pills">
        <li><a href="#" class="finishedTabActive">Finished <span class="badge"><?php echo e($fin); ?></span></a></li>
        <li><a href="#" class="servingTabActive">Serving <span class="badge"><?php echo e($serv); ?></span></a></li>
        <li><a href="#" class="pendingTabActive">Pending <span class="badge"><?php echo e($pen); ?></span></a></li>
        <li><a href="#" class="unassignedTabActive">Unassigned <span class="badge"><?php echo e($unassgned); ?></span></a></li>
        <li><a href="#" class="pausedTabActive">Paused <span class="badge"><?php echo e($pau); ?></span></a></li>
        <li><a href="#" class="nawcTabActive">NAWC <span class="badge"><?php echo e($can); ?></span></a></li>
        <li><a href="#" class="totalTabActive">Total <span class="badge"><?php echo e($pen + $serv + $unassgned + $pau + $can + $fin); ?></span></a></li>
    </ul>

<?php else: ?>

    <ul class="nav nav-pills">
        <li><a href="#" class="pendingTabActive">Pending <span class="badge"><?php echo e($queuePending); ?></span></a></li>
        <li><a href="#" class="nawcTabActive">NAWC <span class="badge"><?php echo e($queueCanceled); ?></span></a></li>

        <?php if(Auth::user()->clinic == 22 || Auth::user()->clinic == 21): ?>
         <li><a href="#" class="finishedTabActive">Done <span class="badge"><?php echo e($queueDone); ?></span></a></li>
        <li><a href="#" class="servingTabActive">Posted Result <span class="badge"><?php echo e($queueFinished); ?></span></a></li>
        <?php else: ?>
            <li><a href="#" class="finishedTabActive">Done <span class="badge"><?php echo e($queueDone); ?></span></a></li>
        <?php endif; ?>
        <li><a href="#" class="totalTabActive">Total <span class="badge"><?php echo e($queuePending + $queueCanceled + $queueFinished + $queueDone); ?></span></a></li>
    </ul>

<?php endif; ?>