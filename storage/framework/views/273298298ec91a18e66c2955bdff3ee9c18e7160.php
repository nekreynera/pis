<?php
    $surveyArray = array('D'=>0,'F'=>0);
    foreach ($survey as $row){
        switch ($row->status){
            case 'F':
                $surveyArray['F'] = $row->total;
                break;
            default:
                $surveyArray['D'] = $row->total;
                break;
        }
    }

?>

<ul class="nav nav-tabs">
    
    <li>
        <a href="<?php echo e(url('radiologyHome')); ?>"
           class="finishedTab <?php echo e((!$status)? 'finishedTabActive' : ''); ?>">
            Waiting For Result <span class="badge">
                <?php echo e($surveyArray['F']); ?>

            </span>
        </a>
    </li>
    <li>
        <a href="<?php echo e(url('radiologyHome/D')); ?>"
           class="servingTab <?php echo e(($status == 'D')? 'servingTabActive' : ''); ?>">
            Posted Result <span class="badge">
                <?php echo e($surveyArray['D']); ?>

            </span>
        </a>
    </li>
    <li>
        <a href="<?php echo e(url('radiologyHome/T')); ?>"
           class="totalTab <?php echo e(($status == 'T')? 'totalTabActive' : ''); ?>">
            Total <span class="badge">
                <?php echo e(array_sum($surveyArray)); ?>

                </span>
        </a>
    </li>
</ul>