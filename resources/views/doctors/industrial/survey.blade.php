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
                @if($surveys) {!! ($srv->general_survey == '0')? $check : $uncheck !!} @endif
                    No Significant Findings
            </td>
        </tr>
        <tr>
            <td></td>
            <td style="width: 80%">
                @if($surveys) {!! ($srv->general_survey != '0' && $srv->general_survey != null)? $check : $uncheck !!} @endif
                    Noted the following:
                    @if($surveys)
                        @if($srv->general_survey != '0' && $srv->general_survey != null)
                            {{ $srv->general_survey }}
                        @endif
                    @endif
            </td>
        </tr>
        <tr>
            <td style="width: 20%">Skin Intigument:</td>
            <td style="width: 80%">
                @if($surveys) {!! ($srv->skin_integument == '0')? $check : $uncheck !!} @endif
                No Significant Findings
            </td>
        </tr>
        <tr>
            <td></td>
            <td style="width: 80%">
                @if($surveys) {!! ($srv->skin_integument != '0' && $srv->skin_integument != null)? $check : $uncheck !!} @endif
                Noted the following:
                    @if($surveys)
                        @if($srv->skin_integument != '0' && $srv->skin_integument != null)
                            {{ $srv->skin_integument }}
                        @endif
                    @endif
            </td>
        </tr>
        <tr>
            <td style="width: 20%">HEENT:</td>
            <td style="width: 80%">
                @if($surveys) {!! ($srv->heent == '0')? $check : $uncheck !!} @endif
                No Significant Findings
            </td>
        </tr>
        <tr>
            <td></td>
            <td style="width: 80%">
                @if($surveys) {!! ($srv->heent != '0' && $srv->heent != null)? $check : $uncheck !!} @endif
                Noted the following:
                    @if($surveys)
                        @if($srv->heent != '0' && $srv->heent != null)
                            {{ $srv->heent }}
                        @endif
                    @endif
            </td>
        </tr>
        <tr>
            <td style="width: 20%">Respiratory:</td>
            <td style="width: 80%">
                @if($surveys) {!! ($srv->respiratory == '0')? $check : $uncheck !!} @endif
                No Significant Findings
            </td>
        </tr>
        <tr>
            <td></td>
            <td style="width: 80%">
                @if($surveys) {!! ($srv->respiratory != '0' && $srv->respiratory != null)? $check : $uncheck !!} @endif
                Noted the following:
                    @if($surveys)
                        @if($srv->respiratory != '0' && $srv->respiratory != null)
                            {{ $srv->respiratory }}
                        @endif
                    @endif
            </td>
        </tr>
        <tr>
            <td style="width: 20%">Cardiovascular:</td>
            <td style="width: 80%">
                @if($surveys) {!! ($srv->cardiovascular == '0')? $check : $uncheck !!} @endif
                No Significant Findings
            </td>
        </tr>
        <tr>
            <td></td>
            <td style="width: 80%">
                @if($surveys) {!! ($srv->cardiovascular != '0' && $srv->cardiovascular != null)? $check : $uncheck !!} @endif
                Noted the following:
                    @if($surveys)
                        @if($srv->cardiovascular != '0' && $srv->cardiovascular != null)
                            {{ $srv->cardiovascular }}
                        @endif
                    @endif
            </td>
        </tr>
        <tr>
            <td style="width: 20%">Gastrointestinal:</td>
            <td style="width: 80%">
                @if($surveys) {!! ($srv->gastrointestinal == '0')? $check : $uncheck !!} @endif
                No Significant Findings
            </td>
        </tr>
        <tr>
            <td></td>
            <td style="width: 80%">
                @if($surveys) {!! ($srv->gastrointestinal != '0' && $srv->gastrointestinal != null)? $check : $uncheck !!} @endif
                Noted the following:
                    @if($surveys)
                        @if($srv->gastrointestinal != '0' && $srv->gastrointestinal != null)
                            {{ $srv->gastrointestinal }}
                        @endif
                    @endif
            </td>
        </tr>
        <tr>
            <td style="width: 20%">Genitourinary:</td>
            <td style="width: 80%">
                @if($surveys) {!! ($srv->genitourinary == '0')? $check : $uncheck !!} @endif
                No Significant Findings
            </td>
        </tr>
        <tr>
            <td></td>
            <td style="width: 80%">
                @if($surveys) {!! ($srv->genitourinary != '0' && $srv->genitourinary != null)? $check : $uncheck !!} @endif
                Noted the following:
                    @if($surveys)
                        @if($srv->genitourinary != '0' && $srv->genitourinary != null)
                            {{ $srv->genitourinary }}
                        @endif
                    @endif
            </td>
        </tr>
        <tr>
            <td style="width: 20%">Neurologic:</td>
            <td style="width: 80%">
                @if($surveys) {!! ($srv->neurologic == '0')? $check : $uncheck !!} @endif
                No Significant Findings
            </td>
        </tr>
        <tr>
            <td></td>
            <td style="width: 80%">
                @if($surveys) {!! ($srv->neurologic != '0' && $srv->neurologic != null)? $check : $uncheck !!} @endif
                Noted the following:
                    @if($surveys)
                        @if($srv->neurologic != '0' && $srv->neurologic != null)
                            {{ $srv->neurologic }}
                        @endif
                    @endif
            </td>
        </tr>
    </tbody>
</table>