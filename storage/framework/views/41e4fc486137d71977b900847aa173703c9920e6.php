<?php

$checkedImage = './public/images/checkbox-check.png';
$uncheckedImage = './public/images/checkbox.png';
$check = '<img src="'.$checkedImage.'" alt="" width="10px" height="10px;"/>';
$uncheck = '<img src="'.$uncheckedImage.'" alt="" width="10px" height="10px;"/>';

if($industrialConsultations && $industrialConsultations->industrial_history){
    $history = true;
}else{
    $history = false;
}



if($industrialConsultations && $history){
    $obstetric = explode(',', $industrialConsultations->industrial_history->obstetric);
}else{
    $obstetric = 1;
}


if(count($obstetric) > 1){
    $obs = true;
}else{
    $obs = false;
}


?>

<table>
    <thead>
        <tr>
            <th><b>Past Medical History</b></th>
            <th><b>Personal/Social History</b></th>
            <th><b>Obstetric/Menstrual History</b></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                Illnesses:
                <?php if($history): ?>
                    <u> <?php echo e($industrialConsultations->industrial_history->illnesses); ?> </u>
                <?php endif; ?>
            </td>
            <td>
                Smoker?
                <?php if($history): ?>
                    <?php if($industrialConsultations->industrial_history->smoker == 'Yes'): ?>
                        <?php echo $check; ?>

                    <?php else: ?>
                        <?php echo $uncheck; ?>

                    <?php endif; ?>
                    Yes,
                <?php endif; ?>
                <?php if($history): ?>
                    <?php if($industrialConsultations->industrial_history->smoker == 'No'): ?>
                        <?php echo $check; ?>

                    <?php else: ?>
                        <?php echo $uncheck; ?>

                    <?php endif; ?>
                    No
                <?php endif; ?>
            </td>
            <td>
                G
                <?php if($industrialConsultations && $history && $obs): ?>
                    <u><?php echo e($obstetric[0]); ?></u>
                <?php else: ?>
                    <?php echo $uncheck; ?>

                <?php endif; ?>
                P
                <?php if($industrialConsultations && $history && $obs): ?>
                    <u><?php echo e($obstetric[1]); ?></u>
                <?php else: ?>
                    <?php echo $uncheck; ?>

                <?php endif; ?>
                (
                <?php if($industrialConsultations && $history && $obs): ?> <?php echo e(isset($obstetric[2]) ? $obstetric[2] : ''); ?>,  <?php endif; ?>
                <?php if($industrialConsultations && $history && $obs): ?> <?php echo e(isset($obstetric[3]) ? $obstetric[3] : ''); ?>,  <?php endif; ?>
                <?php if($industrialConsultations && $history && $obs): ?> <?php echo e(isset($obstetric[4]) ? $obstetric[4] : ''); ?>,  <?php endif; ?>
                <?php if($industrialConsultations && $history && $obs): ?> <?php echo e(isset($obstetric[5]) ? $obstetric[5] : ''); ?>,  <?php endif; ?>
                )
            </td>
        </tr>


        <tr>
            <td>
                Hospitalization:
                <?php if($history): ?>
                    <u><?php echo e($industrialConsultations->industrial_history->hospitalization); ?></u>
                <?php endif; ?>
            </td>
            <td>
                Pack Year?
                <?php if($history): ?>
                    <u><?php echo e($industrialConsultations->industrial_history->packyear); ?></u>
                <?php endif; ?>
            </td>
            <td>
                Age of Menarche:
                <?php if($history): ?>
                    <u><?php echo e($industrialConsultations->industrial_history->menarche); ?></u>
                <?php endif; ?>
            </td>
        </tr>


        <tr>
            <td>
                Allergies:
                <?php if($history): ?>
                    <u><?php echo e($industrialConsultations->industrial_history->allergies); ?></u>
                <?php endif; ?>
            </td>
            <td>
                Alcohol Beverage Drinker?
                <?php if($history): ?>
                    <u><?php echo e($industrialConsultations->industrial_history->drinker); ?></u>
                <?php endif; ?>
            </td>
            <td>
                Age of first coitus:
                <?php if($history): ?>
                    <u><?php echo e($industrialConsultations->industrial_history->coitus); ?></u>
                <?php endif; ?>
            </td>
        </tr>

    </tbody>
</table>