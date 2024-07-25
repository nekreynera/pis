<?php
    $checkedImage = './public/images/checkbox-check.png';
    $uncheckedImage = './public/images/checkbox.png';
    $check = '<img src="'.$checkedImage.'" alt="" width="10px" height="10px;"/>';
    $uncheck = '<img src="'.$uncheckedImage.'" alt="" width="10px" height="10px;"/>';


    $heentArray = array();
    if($industrialConsultations && $industrialConsultations->system_reviews){
        $heentArray = explode(',', $industrialConsultations->system_reviews->heent);
    }

    $gastrointestinalArray = array();
    if($industrialConsultations && $industrialConsultations->system_reviews){
        $gastrointestinalArray = explode(',', $industrialConsultations->system_reviews->gastrointestinal);
    }

    $neurologicArray = array();
    if($industrialConsultations && $industrialConsultations->system_reviews){
        $neurologicArray = explode(',', $industrialConsultations->system_reviews->neurologic);
    }

?>

<table>
    <thead>
        <tr>
            <th><b><i>HEENT</i></b></th>
            <th><b><i>Gastrointestinal</i></b></th>
            <th><b><i>Neurologic</i></b></th>
        </tr>
    </thead>
    <tbody>
    <tr>
        <td>
            <?php if(in_array(1,$heentArray)): ?>
                <?php echo $check; ?>

            <?php else: ?>
                <?php echo $uncheck; ?>

            <?php endif; ?>
            Blurring of Vision
        </td>
        <td>
            <?php if(in_array(1,$gastrointestinalArray)): ?>
                <?php echo $check; ?>

            <?php else: ?>
                <?php echo $uncheck; ?>

            <?php endif; ?>
            Abdominal Pain
        </td>
        <td>
            <?php if(in_array(1,$neurologicArray)): ?>
                <?php echo $check; ?>

            <?php else: ?>
                <?php echo $uncheck; ?>

            <?php endif; ?>
            Weakness
        </td>
     </tr>
    <tr>
        <td>
            <?php if(in_array(2,$heentArray)): ?>
                <?php echo $check; ?>

            <?php else: ?>
                <?php echo $uncheck; ?>

            <?php endif; ?>
            Ringing of Ears
        </td>
        <td>
            <?php if(in_array(2,$gastrointestinalArray)): ?>
                <?php echo $check; ?>

            <?php else: ?>
                <?php echo $uncheck; ?>

            <?php endif; ?>
            Jaundice
        </td>
        <td>
            <?php if(in_array(2,$neurologicArray)): ?>
                <?php echo $check; ?>

            <?php else: ?>
                <?php echo $uncheck; ?>

            <?php endif; ?>
            Numbness/Paresthesia
        </td>
    </tr>
    <tr>
        <td>
            <?php if(in_array(3,$heentArray)): ?>
                <?php echo $check; ?>

            <?php else: ?>
                <?php echo $uncheck; ?>

            <?php endif; ?>
            Eye Redness
        </td>
        <td>
            <?php if(in_array(3,$gastrointestinalArray)): ?>
                <?php echo $check; ?>

            <?php else: ?>
                <?php echo $uncheck; ?>

            <?php endif; ?>
            Nausea/Vomiting
        </td>
        <td>
            <?php if(in_array(3,$neurologicArray)): ?>
                <?php echo $check; ?>

            <?php else: ?>
                <?php echo $uncheck; ?>

            <?php endif; ?>
            Headache
        </td>
    </tr>
    <tr>
        <td></td>
        <td>
            <?php if(in_array(4,$gastrointestinalArray)): ?>
                <?php echo $check; ?>

            <?php else: ?>
                <?php echo $uncheck; ?>

            <?php endif; ?>
            Diarrhea
        </td>
        <td>
            <?php if(in_array(4,$neurologicArray)): ?>
                <?php echo $check; ?>

            <?php else: ?>
                <?php echo $uncheck; ?>

            <?php endif; ?>
            Dizziness
        </td>
    </tr>
    <tr>
        <td></td>
        <td>
            <?php if(in_array(5,$gastrointestinalArray)): ?>
                <?php echo $check; ?>

            <?php else: ?>
                <?php echo $uncheck; ?>

            <?php endif; ?>
            Melena/Hematochezia
        </td>
        <td>
            <?php if(in_array(5,$neurologicArray)): ?>
                <?php echo $check; ?>

            <?php else: ?>
                <?php echo $uncheck; ?>

            <?php endif; ?>
            Galt Disturbances
        </td>
    </tr>
    </tbody>
</table>


<br/>
<br/>

