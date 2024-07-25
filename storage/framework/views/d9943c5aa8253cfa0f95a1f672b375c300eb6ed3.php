<?php
$checkedImage = './public/images/checkbox-check.png';
$uncheckedImage = './public/images/checkbox.png';
$check = '<img src="'.$checkedImage.'" alt="" width="10px" height="10px;"/>';
$uncheck = '<img src="'.$uncheckedImage.'" alt="" width="10px" height="10px;"/>';

if($industrialConsultations && $industrialConsultations->system_reviews){
    $cardiovascularArray = explode(',', $industrialConsultations->system_reviews->cardiovascular);
}else{
    $cardiovascularArray = array();
}

if($industrialConsultations && $industrialConsultations->system_reviews){
    $metabolic_endocrineArray = explode(',', $industrialConsultations->system_reviews->metabolic_endocrine);
}else{
    $metabolic_endocrineArray = array();
}

if($industrialConsultations && $industrialConsultations->system_reviews){
    $skin_integumentArray = explode(',', $industrialConsultations->system_reviews->skin_integument);
}else{
    $skin_integumentArray = array();
}

?>


<table>
    <thead>
    <tr>
        <th><b><i>Cardiovascular</i></b></th>
        <th><b><i>Metabolic/Endocrine</i></b></th>
        <th><b><i>Skin/Integument</i></b></th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>
            <?php if(in_array(1,$cardiovascularArray)): ?>
                <?php echo $check; ?>

            <?php else: ?>
                <?php echo $uncheck; ?>

            <?php endif; ?>
            Chest Pain
        </td>
        <td>
            <?php if(in_array(1,$metabolic_endocrineArray)): ?>
                <?php echo $check; ?>

            <?php else: ?>
                <?php echo $uncheck; ?>

            <?php endif; ?>
            Polyuria
        </td>
        <td>
            <?php if(in_array(1,$skin_integumentArray)): ?>
                <?php echo $check; ?>

            <?php else: ?>
                <?php echo $uncheck; ?>

            <?php endif; ?>
            Pallor
        </td>
    </tr>
    <tr>
        <td>
            <?php if(in_array(2,$cardiovascularArray)): ?>
                <?php echo $check; ?>

            <?php else: ?>
                <?php echo $uncheck; ?>

            <?php endif; ?>
            Orthopnea
        </td>
        <td>
            <?php if(in_array(2,$metabolic_endocrineArray)): ?>
                <?php echo $check; ?>

            <?php else: ?>
                <?php echo $uncheck; ?>

            <?php endif; ?>
            Polydipsia
        </td>
        <td>
            <?php if(in_array(2,$skin_integumentArray)): ?>
                <?php echo $check; ?>

            <?php else: ?>
                <?php echo $uncheck; ?>

            <?php endif; ?>
            Bore Cyanosis
        </td>
    </tr>
    <tr>
        <td>
            <?php if(in_array(3,$cardiovascularArray)): ?>
                <?php echo $check; ?>

            <?php else: ?>
                <?php echo $uncheck; ?>

            <?php endif; ?>
            Paroxysmal Nocturnal Dyspnea
        </td>
        <td>
            <?php if(in_array(3,$metabolic_endocrineArray)): ?>
                <?php echo $check; ?>

            <?php else: ?>
                <?php echo $uncheck; ?>

            <?php endif; ?>
            Polyphagia
        </td>
        <td>
            <?php if(in_array(3,$skin_integumentArray)): ?>
                <?php echo $check; ?>

            <?php else: ?>
                <?php echo $uncheck; ?>

            <?php endif; ?>
            Rashes
        </td>
    </tr>
    <tr>
        <td>
            <?php if(in_array(4,$cardiovascularArray)): ?>
                <?php echo $check; ?>

            <?php else: ?>
                <?php echo $uncheck; ?>

            <?php endif; ?>
            Easy Fatigability
        </td>
        <td>
            <?php if(in_array(4,$metabolic_endocrineArray)): ?>
                <?php echo $check; ?>

            <?php else: ?>
                <?php echo $uncheck; ?>

            <?php endif; ?>
            Unexplained Weight Loss/Gain
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            <?php if(in_array(5,$cardiovascularArray)): ?>
                <?php echo $check; ?>

            <?php else: ?>
                <?php echo $uncheck; ?>

            <?php endif; ?>
            Edema
        </td>
        <td>
        </td>
        <td>
        </td>
    </tr>
    </tbody>
</table>


<br/>
<br/>

