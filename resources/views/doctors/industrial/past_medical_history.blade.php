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
                @if($history)
                    <u> {{ $industrialConsultations->industrial_history->illnesses }} </u>
                @endif
            </td>
            <td>
                Smoker?
                @if($history)
                    @if($industrialConsultations->industrial_history->smoker == 'Yes')
                        {!! $check !!}
                    @else
                        {!! $uncheck !!}
                    @endif
                    Yes,
                @endif
                @if($history)
                    @if($industrialConsultations->industrial_history->smoker == 'No')
                        {!! $check !!}
                    @else
                        {!! $uncheck !!}
                    @endif
                    No
                @endif
            </td>
            <td>
                G
                @if($industrialConsultations && $history && $obs)
                    <u>{{ $obstetric[0] }}</u>
                @else
                    {!! $uncheck !!}
                @endif
                P
                @if($industrialConsultations && $history && $obs)
                    <u>{{ $obstetric[1] }}</u>
                @else
                    {!! $uncheck !!}
                @endif
                (
                @if($industrialConsultations && $history && $obs) {{ $obstetric[2] or '' }},  @endif
                @if($industrialConsultations && $history && $obs) {{ $obstetric[3] or '' }},  @endif
                @if($industrialConsultations && $history && $obs) {{ $obstetric[4] or '' }},  @endif
                @if($industrialConsultations && $history && $obs) {{ $obstetric[5] or '' }},  @endif
                )
            </td>
        </tr>


        <tr>
            <td>
                Hospitalization:
                @if($history)
                    <u>{{ $industrialConsultations->industrial_history->hospitalization }}</u>
                @endif
            </td>
            <td>
                Pack Year?
                @if($history)
                    <u>{{ $industrialConsultations->industrial_history->packyear }}</u>
                @endif
            </td>
            <td>
                Age of Menarche:
                @if($history)
                    <u>{{ $industrialConsultations->industrial_history->menarche }}</u>
                @endif
            </td>
        </tr>


        <tr>
            <td>
                Allergies:
                @if($history)
                    <u>{{ $industrialConsultations->industrial_history->allergies }}</u>
                @endif
            </td>
            <td>
                Alcohol Beverage Drinker?
                @if($history)
                    <u>{{ $industrialConsultations->industrial_history->drinker }}</u>
                @endif
            </td>
            <td>
                Age of first coitus:
                @if($history)
                    <u>{{ $industrialConsultations->industrial_history->coitus }}</u>
                @endif
            </td>
        </tr>

    </tbody>
</table>