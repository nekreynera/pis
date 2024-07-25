<?php
    $surveyArray = array('P'=>0,'D'=>0,'F'=>0,'C'=>0);
    foreach ($survey as $row){
        switch ($row->status){
            case 'C':
                $surveyArray['C'] = $row->total;
                break;
            case 'F':
                $surveyArray['F'] = $row->total;
                break;
            case 'D':
                $surveyArray['D'] = $row->total;
                break;
            default:
                $surveyArray['P'] = $row->total;
                break;
        }
    }

?>

<ul class="nav nav-tabs">
    <li>
            <a href="<?php echo e(url('overview')); ?>"
               class="pendingTab <?php echo e(($status == false)? 'pendingTabActive' : ''); ?>">
                Pending <span class="badge">
                    <?php echo e($surveyArray['P']); ?>

                </span>
            </a>
    </li>
    <li>
            <a href="<?php echo e(url('overview/C')); ?>"
               class="nawcTab <?php echo e(($status == 'C')? 'nawcTabActive' : ''); ?>">
                NAWC <span class="badge">
                    <?php echo e($surveyArray['C']); ?>

                </span>
            </a>
    </li>
    <li>
        <a href="<?php echo e(url('overview/F')); ?>"
           class="finishedTab <?php echo e(($status == 'F')? 'finishedTabActive' : ''); ?>">
            Done <span class="badge">
                <?php echo e($surveyArray['F']); ?>

            </span>
        </a>
    </li>


    


    <?php if(Auth::user()->clinic == 22 || Auth::user()->clinic == 21): ?>
        <li>
            <a href="<?php echo e(url('overview/D')); ?>"
               class="servingTab <?php echo e(($status == 'D')? 'servingTabActive' : ''); ?>">
                Posted Result <span class="badge">
                <?php echo e($surveyArray['D']); ?>

            </span>
            </a>
        </li>
    <?php endif; ?>



    <li>
        <a href="<?php echo e(url('overview/T')); ?>"
           class="totalTab <?php echo e(($status == 'T')? 'totalTabActive' : ''); ?>">
            Total <span class="badge">
                <?php echo e(array_sum($surveyArray)); ?>

                </span>
        </a>
    </li>
</ul>