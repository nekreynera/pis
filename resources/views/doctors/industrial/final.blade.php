<?php
    if($industrialConsultations && $industrialConsultations->final_results){
        $fin = true;
        $fn = $industrialConsultations->final_results;
    }else{
        $fin = false;
    }
?>


<table>
    <tbody>
        <tr>
            <td style="height: 60px">Assesment: @if($fin) {{ $fn->assesment }} @endif</td>
            <td></td>
        </tr>
        <tr>
            <td style="height: 60px">Plan: @if($fin) {{ $fn->plan }} @endif</td>
            <td>Follow-Up @if($fin) {{ $fn->followup }} @endif</td>
        </tr>
        <tr>
            <td style="height: 60px">Diagnostic: @if($fin) {{ $fn->diagnostic }} @endif</td>
            <td>Refferal: @if($fin) {{ $fn->referral }} @endif</td>
        </tr>
        <tr>
            <td style="height: 60px">Therapeutics: @if($fin) {{ $fn->therapeutics }} @endif</td>
            <td>Health Education and Advise: @if($fin) {{ $fn->advise }} @endif</td>
        </tr>
    </tbody>
</table>