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
            @if(in_array(1,$respiratoryArray))
                {!! $check !!}
            @else
                {!! $uncheck !!}
            @endif
            Difficulty of Breathing
        </td>
        <td>
            @if(in_array(1,$genitourinaryArray))
                {!! $check !!}
            @else
                {!! $uncheck !!}
            @endif
            Frequency
        </td>
        <td>
            @if(in_array(1,$musculoskeletalArray))
                {!! $check !!}
            @else
                {!! $uncheck !!}
            @endif
            Muscle Pain
        </td>
    </tr>
    <tr>
        <td>
            @if(in_array(2,$respiratoryArray))
                {!! $check !!}
            @else
                {!! $uncheck !!}
            @endif
            Wheezes
        </td>
        <td>
            @if(in_array(2,$genitourinaryArray))
                {!! $check !!}
            @else
                {!! $uncheck !!}
            @endif
            Hematuria
        </td>
        <td>
            @if(in_array(2,$musculoskeletalArray))
                {!! $check !!}
            @else
                {!! $uncheck !!}
            @endif
            Bore Pain
        </td>
    </tr>
    <tr>
        <td>
            @if(in_array(3,$respiratoryArray))
                {!! $check !!}
            @else
                {!! $uncheck !!}
            @endif
            Hemoptysis
        </td>
        <td>
            @if(in_array(3,$genitourinaryArray))
                {!! $check !!}
            @else
                {!! $uncheck !!}
            @endif
            Passage of Sandy Material
        </td>
        <td>
            @if(in_array(3,$musculoskeletalArray))
                {!! $check !!}
            @else
                {!! $uncheck !!}
            @endif
            Sprain/Strain
        </td>
    </tr>
    <tr>
        <td></td>
        <td>
            @if(in_array(4,$genitourinaryArray))
                {!! $check !!}
            @else
                {!! $uncheck !!}
            @endif
            Dribbling
        </td>
        <td>
            @if(in_array(4,$musculoskeletalArray))
                {!! $check !!}
            @else
                {!! $uncheck !!}
            @endif
            Joint Pains
        </td>
    </tr>
    <tr>
        <td></td>
        <td>
            @if(in_array(5,$genitourinaryArray))
                {!! $check !!}
            @else
                {!! $uncheck !!}
            @endif
            Hesitancy
        </td>
        <td>
        </td>
    </tr>
    </tbody>
</table>


<br/>
<br/>

