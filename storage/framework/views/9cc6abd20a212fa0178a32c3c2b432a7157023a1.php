<?php
$checkedImage = './public/images/checkbox-check.png';
$uncheckedImage = './public/images/checkbox.png';
$check = '<img src="'.$checkedImage.'" alt="" width="10px" height="10px;"/>';
$uncheck = '<img src="'.$uncheckedImage.'" alt="" width="10px" height="10px;"/>';


if($industrialConsultations && $industrialConsultations->system_reviews){
    $respiratoryArray = explode(',', $industrialConsultations->system_reviews->respiratory);
}else{
    $respiratoryArray = array();
}

if($industrialConsultations && $industrialConsultations->system_reviews){
    $genitourinaryArray = explode(',', $industrialConsultations->system_reviews->genitourinary);
}else{
    $genitourinaryArray = array();
}

if($industrialConsultations && $industrialConsultations->system_reviews){
    $musculoskeletalArray = explode(',', $industrialConsultations->system_reviews->musculoskeletal);
}else{
    $musculoskeletalArray = array();
}

?>

<table>
    <thead>
    <tr>
        <th><b><i>Respiratory</i></b></th>
        <th><b><i>Genitourinary</i></b></th>
        <th><b><i>Musculoskeletal</i></b></th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>
            <?php if(in_array(1,$respiratoryArray)): ?>
                <?php echo $check; ?>

            <?php else: ?>
                <?php echo $uncheck; ?>

            <?php endif; ?>
            Difficulty of Breathing
        </td>
        <td>
            <?php if(in_array(1,$genitourinaryArray)): ?>
                <?php echo $check; ?>

            <?php else: ?>
                <?php echo $uncheck; ?>

            <?php endif; ?>
            Frequency
        </td>
        <td>
            <?php if(in_array(1,$musculoskeletalArray)): ?>
                <?php echo $check; ?>

            <?php else: ?>
                <?php echo $uncheck; ?>

            <?php endif; ?>
            Muscle Pain
        </td>
    </tr>
    <tr>
        <td>
            <?php if(in_array(2,$respiratoryArray)): ?>
                <?php echo $check; ?>

            <?php else: ?>
                <?php echo $uncheck; ?>

            <?php endif; ?>
            Wheezes
        </td>
        <td>
            <?php if(in_array(2,$genitourinaryArray)): ?>
                <?php echo $check; ?>

            <?php else: ?>
                <?php echo $uncheck; ?>

            <?php endif; ?>
            Hematuria
        </td>
        <td>
            <?php if(in_array(2,$musculoskeletalArray)): ?>
                <?php echo $check; ?>

            <?php else: ?>
                <?php echo $uncheck; ?>

            <?php endif; ?>
            Bore Pain
        </td>
    </tr>
    <tr>
        <td>
            <?php if(in_array(3,$respiratoryArray)): ?>
                <?php echo $check; ?>

            <?php else: ?>
                <?php echo $uncheck; ?>

            <?php endif; ?>
            Hemoptysis
        </td>
        <td>
            <?php if(in_array(3,$genitourinaryArray)): ?>
                <?php echo $check; ?>

            <?php else: ?>
                <?php echo $uncheck; ?>

            <?php endif; ?>
            Passage of Sandy Material
        </td>
        <td>
            <?php if(in_array(3,$musculoskeletalArray)): ?>
                <?php echo $check; ?>

            <?php else: ?>
                <?php echo $uncheck; ?>

            <?php endif; ?>
            Sprain/Strain
        </td>
    </tr>
    <tr>
        <td></td>
        <td>
            <?php if(in_array(4,$genitourinaryArray)): ?>
                <?php echo $check; ?>

            <?php else: ?>
                <?php echo $uncheck; ?>

            <?php endif; ?>
            Dribbling
        </td>
        <td>
            <?php if(in_array(4,$musculoskeletalArray)): ?>
                <?php echo $check; ?>

            <?php else: ?>
                <?php echo $uncheck; ?>

            <?php endif; ?>
            Joint Pains
        </td>
    </tr>
    <tr>
        <td></td>
        <td>
            <?php if(in_array(5,$genitourinaryArray)): ?>
                <?php echo $check; ?>

            <?php else: ?>
                <?php echo $uncheck; ?>

            <?php endif; ?>
            Hesitancy
        </td>
        <td>
        </td>
    </tr>
    </tbody>
</table>


<br/>
<br/>

