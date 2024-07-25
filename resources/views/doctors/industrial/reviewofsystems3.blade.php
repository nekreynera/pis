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
            @if(in_array(1,$cardiovascularArray))
                {!! $check !!}
            @else
                {!! $uncheck !!}
            @endif
            Chest Pain
        </td>
        <td>
            @if(in_array(1,$metabolic_endocrineArray))
                {!! $check !!}
            @else
                {!! $uncheck !!}
            @endif
            Polyuria
        </td>
        <td>
            @if(in_array(1,$skin_integumentArray))
                {!! $check !!}
            @else
                {!! $uncheck !!}
            @endif
            Pallor
        </td>
    </tr>
    <tr>
        <td>
            @if(in_array(2,$cardiovascularArray))
                {!! $check !!}
            @else
                {!! $uncheck !!}
            @endif
            Orthopnea
        </td>
        <td>
            @if(in_array(2,$metabolic_endocrineArray))
                {!! $check !!}
            @else
                {!! $uncheck !!}
            @endif
            Polydipsia
        </td>
        <td>
            @if(in_array(2,$skin_integumentArray))
                {!! $check !!}
            @else
                {!! $uncheck !!}
            @endif
            Bore Cyanosis
        </td>
    </tr>
    <tr>
        <td>
            @if(in_array(3,$cardiovascularArray))
                {!! $check !!}
            @else
                {!! $uncheck !!}
            @endif
            Paroxysmal Nocturnal Dyspnea
        </td>
        <td>
            @if(in_array(3,$metabolic_endocrineArray))
                {!! $check !!}
            @else
                {!! $uncheck !!}
            @endif
            Polyphagia
        </td>
        <td>
            @if(in_array(3,$skin_integumentArray))
                {!! $check !!}
            @else
                {!! $uncheck !!}
            @endif
            Rashes
        </td>
    </tr>
    <tr>
        <td>
            @if(in_array(4,$cardiovascularArray))
                {!! $check !!}
            @else
                {!! $uncheck !!}
            @endif
            Easy Fatigability
        </td>
        <td>
            @if(in_array(4,$metabolic_endocrineArray))
                {!! $check !!}
            @else
                {!! $uncheck !!}
            @endif
            Unexplained Weight Loss/Gain
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            @if(in_array(5,$cardiovascularArray))
                {!! $check !!}
            @else
                {!! $uncheck !!}
            @endif
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

