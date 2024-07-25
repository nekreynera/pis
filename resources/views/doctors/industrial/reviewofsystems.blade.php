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
            @if(in_array(1,$heentArray))
                {!! $check !!}
            @else
                {!! $uncheck !!}
            @endif
            Blurring of Vision
        </td>
        <td>
            @if(in_array(1,$gastrointestinalArray))
                {!! $check !!}
            @else
                {!! $uncheck !!}
            @endif
            Abdominal Pain
        </td>
        <td>
            @if(in_array(1,$neurologicArray))
                {!! $check !!}
            @else
                {!! $uncheck !!}
            @endif
            Weakness
        </td>
     </tr>
    <tr>
        <td>
            @if(in_array(2,$heentArray))
                {!! $check !!}
            @else
                {!! $uncheck !!}
            @endif
            Ringing of Ears
        </td>
        <td>
            @if(in_array(2,$gastrointestinalArray))
                {!! $check !!}
            @else
                {!! $uncheck !!}
            @endif
            Jaundice
        </td>
        <td>
            @if(in_array(2,$neurologicArray))
                {!! $check !!}
            @else
                {!! $uncheck !!}
            @endif
            Numbness/Paresthesia
        </td>
    </tr>
    <tr>
        <td>
            @if(in_array(3,$heentArray))
                {!! $check !!}
            @else
                {!! $uncheck !!}
            @endif
            Eye Redness
        </td>
        <td>
            @if(in_array(3,$gastrointestinalArray))
                {!! $check !!}
            @else
                {!! $uncheck !!}
            @endif
            Nausea/Vomiting
        </td>
        <td>
            @if(in_array(3,$neurologicArray))
                {!! $check !!}
            @else
                {!! $uncheck !!}
            @endif
            Headache
        </td>
    </tr>
    <tr>
        <td></td>
        <td>
            @if(in_array(4,$gastrointestinalArray))
                {!! $check !!}
            @else
                {!! $uncheck !!}
            @endif
            Diarrhea
        </td>
        <td>
            @if(in_array(4,$neurologicArray))
                {!! $check !!}
            @else
                {!! $uncheck !!}
            @endif
            Dizziness
        </td>
    </tr>
    <tr>
        <td></td>
        <td>
            @if(in_array(5,$gastrointestinalArray))
                {!! $check !!}
            @else
                {!! $uncheck !!}
            @endif
            Melena/Hematochezia
        </td>
        <td>
            @if(in_array(5,$neurologicArray))
                {!! $check !!}
            @else
                {!! $uncheck !!}
            @endif
            Galt Disturbances
        </td>
    </tr>
    </tbody>
</table>


<br/>
<br/>

