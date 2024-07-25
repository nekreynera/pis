<style>
    table{
        font-size: 9px;
    }
    .titleHead{
        text-align: center;
        background-color: #ccc;
    }
</style>
<div>
    <table border="1">
        <tbody>

        <tr>
            <td colspan="9"><label>Name:</label>
                {{ $patient->last_name.', '.$patient->first_name.' '.$patient->suffix.' '.$patient->middle_name }}
            </td>
            <td colspan="9"><label>Registration Number:</label>
                {{ $patient->hospital_no }}
            </td>
        </tr>
        <tr>
            <td width="70px"><label>Week</label>
            </td>
            <td width="30px">ADM</td>
            @for($i=2;$i<18;$i++)
                <td width="27px">{{ $i }}</td>
            @endfor
        </tr>


        <?php

        $date = explode('^', $data->date);
        $weightKG = explode('^', $data->weightKG);
        $weightLoss = explode('^', $data->weightLoss);
        $muac = explode('^', $data->muac);
        $edemaBack = explode('^', $data->edemaBack);
        $length_height = explode('^', $data->length_height);
        $whz = explode('^', $data->whz);
        $diarrheaDays = explode('^', $data->diarrheaDays);
        $vomiting_days = explode('^', $data->vomiting_days);
        $fever_days = explode('^', $data->fever_days);
        $cough_days = explode('^', $data->cough_days);
        $temperatureDays = explode('^', $data->temperatureDays);
        $respirationRate = explode('^', $data->respirationRate);
        $dehydrated = explode('^', $data->dehydrated);
        $anemia = explode('^', $data->anemia);
        $skin_infection = explode('^', $data->skin_infection);
        $appetite_test_day = explode('^', $data->appetite_test_day);
        $action_needed = explode('^', $data->action_needed);
        $appetite_test_pass_fail = explode('^', $data->appetite_test_pass_fail);
        $other_medication = explode('^', $data->other_medication);
        $rutf = explode('^', $data->rutf);
        $examiner = explode('^', $data->examiner);
        $outcome = explode('^', $data->outcome);

        ?>

        <tr>
            <td><label>Date</label></td>
            @for($i=0;$i<17;$i++)
                <td>
                    @if($date[$i] != '*')  {{ $date[$i] }} @endif
                </td>
            @endfor
        </tr>
        <tr>
            <th colspan="18" class="titleHead">Anthropometry</th>
        </tr>
        <tr>
            <td><label>Weight (kg)</label></td>
            @for($i=0;$i<17;$i++)
                <td>
                    @if($weightKG[$i] != '*')  {{ $weightKG[$i] }} @endif
                </td>
            @endfor
        </tr>
        <tr>
            <td><label>Weight loss * (Y/N)</label></td>
            @for($i=0;$i<17;$i++)
                <td>
                    @if($weightLoss[$i] != '*')  {{ $weightLoss[$i] }} @endif
                </td>
            @endfor
        </tr>
        <tr>
            <td><label>MUAC (cm)</label></td>
            @for($i=0;$i<17;$i++)
                <td>
                    @if($muac[$i] != '*')  {{ $muac[$i] }} @endif
                </td>
            @endfor
        </tr>
        <tr>
            <td><label>Edema (+ ++ +++)</label></td>
            @for($i=0;$i<17;$i++)
                <td>
                    @if($edemaBack[$i] != '*')  {{ $edemaBack[$i] }} @endif
                </td>
            @endfor
        </tr>
        <tr>
            <td><label>Length/Height</label></td>
            @for($i=0;$i<17;$i++)
                <td>
                    @if($length_height[$i] != '*')  {{ $length_height[$i] }} @endif
                </td>
            @endfor
        </tr>
        <tr>
            <td><label>WHZ</label></td>
            @for($i=0;$i<10;$i++)
                <td>
                    @if($whz[$i] != '*')  {{ $whz[$i] }} @endif
                </td>
            @endfor
        </tr>
        <tr>
            <td colspan="18" class="titleHead">
                * WEIGHT CHANGES MARASMICS: If below weight on week 3 refer for home visit. If no weight gain by week 5 refer to ITC.
            </td>
        </tr>
        <tr>
            <th colspan="18" class="titleHead">History</th>
        </tr>
        <tr>
            <td><label>Diarrhea (#days)</label></td>
            @for($i=0;$i<17;$i++)
                <td>
                    @if($diarrheaDays[$i] != '*')  {{ $diarrheaDays[$i] }} @endif
                </td>
            @endfor
        </tr>
        <tr>
            <td><label>Vomiting (#days)</label></td>
            @for($i=0;$i<17;$i++)
                <td>
                    @if($vomiting_days[$i] != '*')  {{ $vomiting_days[$i] }} @endif
                </td>
            @endfor
        </tr>
        <tr>
            <td><label>Fever (#days)</label></td>
            @for($i=0;$i<17;$i++)
                <td>
                    @if($fever_days[$i] != '*')  {{ $fever_days[$i] }} @endif
                </td>
            @endfor
        </tr>
        <tr>
            <td><label>Cough (#days)</label></td>
            @for($i=0;$i<17;$i++)
                <td>
                    @if($cough_days[$i] != '*')  {{ $cough_days[$i] }} @endif
                </td>
            @endfor
        </tr>
        <tr>
            <th colspan="18" class="titleHead">Physical Examination</th>
        </tr>
        <tr>
            <td><label>Temperature (C)</label></td>
            @for($i=0;$i<17;$i++)
                <td>
                    @if($temperatureDays[$i] != '*')  {{ $temperatureDays[$i] }} @endif
                </td>
            @endfor
        </tr>
        <tr>
            <td><label>Respiration Rate (# / min)</label></td>
            @for($i=0;$i<17;$i++)
                <td>
                    @if($respirationRate[$i] != '*')  {{ $respirationRate[$i] }} @endif
                </td>
            @endfor
        </tr>
        <tr>
            <td><label>Dehydrated (Y/ N)</label></td>
            @for($i=0;$i<17;$i++)
                <td>
                    @if($dehydrated[$i] != '*')  {{ $dehydrated[$i] }} @endif
                </td>
            @endfor
        </tr>
        <tr>
            <td><label>Anemia (Y/N)</label></td>
            @for($i=0;$i<17;$i++)
                <td>
                    @if($anemia[$i] != '*')  {{ $anemia[$i] }} @endif
                </td>
            @endfor
        </tr>
        <tr>
            <td><label>Skin Infection (Y/N)</label></td>
            @for($i=0;$i<17;$i++)
                <td>
                    @if($skin_infection[$i] != '*')  {{ $skin_infection[$i] }} @endif
                </td>
            @endfor
        </tr>
        <tr>
            <td><label>Appetite Test (Pass/Fail)</label></td>
            @for($i=0;$i<17;$i++)
                <td>
                    @if($appetite_test_day[$i] != '*')  {{ $appetite_test_day[$i] }} @endif
                </td>
            @endfor
        </tr>
        <tr>
            <td><label>Action Needed (Y/N)</label></td>
            @for($i=0;$i<17;$i++)
                <td>
                    @if($action_needed[$i] != '*')  {{ $action_needed[$i] }} @endif
                </td>
            @endfor
        </tr>
        <tr>
            <td><label>Appetite Test (Pass/Fail) (note below)</label></td>
            @for($i=0;$i<17;$i++)
                <td>
                    @if($appetite_test_pass_fail[$i] != '*')  {{ $appetite_test_pass_fail[$i] }} @endif
                </td>
            @endfor
        </tr>
        <tr>
            <td><label>Other Medication (see front of card)</label></td>
            @for($i=0;$i<17;$i++)
                <td>
                    @if($other_medication[$i] != '*')  {{ $other_medication[$i] }} @endif
                </td>
            @endfor
        </tr>
        <tr>
            <td><label>RUTF (#sachets)</label></td>
            @for($i=0;$i<17;$i++)
                <td>
                    @if($rutf[$i] != '*')  {{ $rutf[$i] }} @endif
                </td>
            @endfor
        </tr>
        <tr>
            <td><label>Name of Examiner</label></td>
            @for($i=0;$i<17;$i++)
                <td>
                    @if($examiner[$i] != '*')  {{ $examiner[$i] }} @endif
                </td>
            @endfor
        </tr>
        <tr>
            <td><label>OUTCOME ***</label></td>
            @for($i=0;$i<17;$i++)
                <td>
                    @if($outcome[$i] != '*')  {{ $outcome[$i] }} @endif
                </td>
            @endfor
        </tr>
        <tr>
            <td colspan="18">
                *** A = absent &nbsp; &nbsp; &nbsp;
                D = defaulter (3 consecutive absences) &nbsp; &nbsp; &nbsp;
                T = transfer to Inpatient &nbsp; &nbsp; &nbsp;
                X = died &nbsp; &nbsp; &nbsp;
                C = discharged cured &nbsp; &nbsp; &nbsp;
                RT = refused transfer &nbsp; &nbsp; &nbsp;
                HV = home visit &nbsp; &nbsp; &nbsp;
                NC = discharged non-cured &nbsp; &nbsp; &nbsp;
            </td>
        </tr>
        <tr>
            <td colspan="18" class="titleHead">**Action taken (include data)</td>
        </tr>

        </tbody>
    </table>
</div>