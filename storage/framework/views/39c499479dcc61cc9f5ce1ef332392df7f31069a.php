<?php
    if($industrialConsultations && $industrialConsultations->final_results){
        $fin = true;
        $fn = $industrialConsultations->final_results;
    }else{
        $fin = false;
    }
?>


<table>
    <tbody>
        <tr>
            <td style="height: 60px">Assesment: <?php if($fin): ?> <?php echo e($fn->assesment); ?> <?php endif; ?></td>
            <td></td>
        </tr>
        <tr>
            <td style="height: 60px">Plan: <?php if($fin): ?> <?php echo e($fn->plan); ?> <?php endif; ?></td>
            <td>Follow-Up <?php if($fin): ?> <?php echo e($fn->followup); ?> <?php endif; ?></td>
        </tr>
        <tr>
            <td style="height: 60px">Diagnostic: <?php if($fin): ?> <?php echo e($fn->diagnostic); ?> <?php endif; ?></td>
            <td>Refferal: <?php if($fin): ?> <?php echo e($fn->referral); ?> <?php endif; ?></td>
        </tr>
        <tr>
            <td style="height: 60px">Therapeutics: <?php if($fin): ?> <?php echo e($fn->therapeutics); ?> <?php endif; ?></td>
            <td>Health Education and Advise: <?php if($fin): ?> <?php echo e($fn->advise); ?> <?php endif; ?></td>
        </tr>
    </tbody>
</table>