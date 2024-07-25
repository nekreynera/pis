<?php
    $checkedImage = './public/images/checkbox-check.png';
    $uncheckedImage = './public/images/checkbox.png';
    $check = '<img src="'.$checkedImage.'" alt="" width="10px" height="10px;"/>';
    $uncheck = '<img src="'.$uncheckedImage.'" alt="" width="10px" height="10px;"/>';

    if($industrialConsultations && $industrialConsultations->industrial_surveys){
        $surveys = true;
        $srv = $industrialConsultations->industrial_surveys;
    }else{
        $surveys = false;
    }
?>

<table style="padding:5px;">
    <tbody>
        <tr>
            <td style="width: 20%">General Survey:</td>
            <td style="width: 80%">
                <?php if($surveys): ?> <?php echo ($srv->general_survey == '0')? $check : $uncheck; ?> <?php endif; ?>
                    No Significant Findings
            </td>
        </tr>
        <tr>
            <td></td>
            <td style="width: 80%">
                <?php if($surveys): ?> <?php echo ($srv->general_survey != '0' && $srv->general_survey != null)? $check : $uncheck; ?> <?php endif; ?>
                    Noted the following:
                    <?php if($surveys): ?>
                        <?php if($srv->general_survey != '0' && $srv->general_survey != null): ?>
                            <?php echo e($srv->general_survey); ?>

                        <?php endif; ?>
                    <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td style="width: 20%">Skin Intigument:</td>
            <td style="width: 80%">
                <?php if($surveys): ?> <?php echo ($srv->skin_integument == '0')? $check : $uncheck; ?> <?php endif; ?>
                No Significant Findings
            </td>
        </tr>
        <tr>
            <td></td>
            <td style="width: 80%">
                <?php if($surveys): ?> <?php echo ($srv->skin_integument != '0' && $srv->skin_integument != null)? $check : $uncheck; ?> <?php endif; ?>
                Noted the following:
                    <?php if($surveys): ?>
                        <?php if($srv->skin_integument != '0' && $srv->skin_integument != null): ?>
                            <?php echo e($srv->skin_integument); ?>

                        <?php endif; ?>
                    <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td style="width: 20%">HEENT:</td>
            <td style="width: 80%">
                <?php if($surveys): ?> <?php echo ($srv->heent == '0')? $check : $uncheck; ?> <?php endif; ?>
                No Significant Findings
            </td>
        </tr>
        <tr>
            <td></td>
            <td style="width: 80%">
                <?php if($surveys): ?> <?php echo ($srv->heent != '0' && $srv->heent != null)? $check : $uncheck; ?> <?php endif; ?>
                Noted the following:
                    <?php if($surveys): ?>
                        <?php if($srv->heent != '0' && $srv->heent != null): ?>
                            <?php echo e($srv->heent); ?>

                        <?php endif; ?>
                    <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td style="width: 20%">Respiratory:</td>
            <td style="width: 80%">
                <?php if($surveys): ?> <?php echo ($srv->respiratory == '0')? $check : $uncheck; ?> <?php endif; ?>
                No Significant Findings
            </td>
        </tr>
        <tr>
            <td></td>
            <td style="width: 80%">
                <?php if($surveys): ?> <?php echo ($srv->respiratory != '0' && $srv->respiratory != null)? $check : $uncheck; ?> <?php endif; ?>
                Noted the following:
                    <?php if($surveys): ?>
                        <?php if($srv->respiratory != '0' && $srv->respiratory != null): ?>
                            <?php echo e($srv->respiratory); ?>

                        <?php endif; ?>
                    <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td style="width: 20%">Cardiovascular:</td>
            <td style="width: 80%">
                <?php if($surveys): ?> <?php echo ($srv->cardiovascular == '0')? $check : $uncheck; ?> <?php endif; ?>
                No Significant Findings
            </td>
        </tr>
        <tr>
            <td></td>
            <td style="width: 80%">
                <?php if($surveys): ?> <?php echo ($srv->cardiovascular != '0' && $srv->cardiovascular != null)? $check : $uncheck; ?> <?php endif; ?>
                Noted the following:
                    <?php if($surveys): ?>
                        <?php if($srv->cardiovascular != '0' && $srv->cardiovascular != null): ?>
                            <?php echo e($srv->cardiovascular); ?>

                        <?php endif; ?>
                    <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td style="width: 20%">Gastrointestinal:</td>
            <td style="width: 80%">
                <?php if($surveys): ?> <?php echo ($srv->gastrointestinal == '0')? $check : $uncheck; ?> <?php endif; ?>
                No Significant Findings
            </td>
        </tr>
        <tr>
            <td></td>
            <td style="width: 80%">
                <?php if($surveys): ?> <?php echo ($srv->gastrointestinal != '0' && $srv->gastrointestinal != null)? $check : $uncheck; ?> <?php endif; ?>
                Noted the following:
                    <?php if($surveys): ?>
                        <?php if($srv->gastrointestinal != '0' && $srv->gastrointestinal != null): ?>
                            <?php echo e($srv->gastrointestinal); ?>

                        <?php endif; ?>
                    <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td style="width: 20%">Genitourinary:</td>
            <td style="width: 80%">
                <?php if($surveys): ?> <?php echo ($srv->genitourinary == '0')? $check : $uncheck; ?> <?php endif; ?>
                No Significant Findings
            </td>
        </tr>
        <tr>
            <td></td>
            <td style="width: 80%">
                <?php if($surveys): ?> <?php echo ($srv->genitourinary != '0' && $srv->genitourinary != null)? $check : $uncheck; ?> <?php endif; ?>
                Noted the following:
                    <?php if($surveys): ?>
                        <?php if($srv->genitourinary != '0' && $srv->genitourinary != null): ?>
                            <?php echo e($srv->genitourinary); ?>

                        <?php endif; ?>
                    <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td style="width: 20%">Neurologic:</td>
            <td style="width: 80%">
                <?php if($surveys): ?> <?php echo ($srv->neurologic == '0')? $check : $uncheck; ?> <?php endif; ?>
                No Significant Findings
            </td>
        </tr>
        <tr>
            <td></td>
            <td style="width: 80%">
                <?php if($surveys): ?> <?php echo ($srv->neurologic != '0' && $srv->neurologic != null)? $check : $uncheck; ?> <?php endif; ?>
                Noted the following:
                    <?php if($surveys): ?>
                        <?php if($srv->neurologic != '0' && $srv->neurologic != null): ?>
                            <?php echo e($srv->neurologic); ?>

                        <?php endif; ?>
                    <?php endif; ?>
            </td>
        </tr>
    </tbody>
</table>