<style>
    table{
        font-size: 10px;
    }
    .titleHead{
        text-align: center;
        background-color: #ccc;
    }
    .stripedLine{
        background-color:#333;
    }
</style>
<div>
    <table border="1">
        <tbody>
        <tr>
            <td colspan="2">
                Clinic:
                {{ $data->clinic_name }}
            </td>
            <td>
                Childs No.:
                {{ $patient->hospital_no }}
            </td>
        </tr>
        <tr>
            <td colspan="3">
                Barangay:
                {{ $patient->provDesc.' '.$patient->citymunDesc.' '.$patient->brgyDesc }}
            </td>
        </tr>
        <tr>
            <td colspan="3">
                Family No.:
                {{ $data->family }}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                Childs Name:
                {{ $patient->last_name.', '.$patient->first_name.' '.$patient->suffix.' '.$patient->middle_name }}
            </td>
            <td>
                Sex: &nbsp; &nbsp; &nbsp;
                <label class="normalLabel">
                    <input type="radio" name="sex" value="M"
                           @if($patient->sex == 'M') checked="checked" @endif> M
                </label>
                &nbsp; &nbsp;
                <label class="normalLabel">
                    <input type="radio" name="sex" value="F"
                           @if($patient->sex == 'F') checked="checked" @endif> F
                </label>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                Mothers Name:
                {{ $data->mother }}
            </td>
        </tr>
        <tr>
            <td colspan="3">
                Educational Level:
                {{ $data->education }}
            </td>
        </tr>
        <tr>
            <td colspan="3">
                Occupation:
                {{ $data->occupation }}
            </td>
        </tr>
        <tr>
            <td>
                Date First Seen:
                {{ $data->date_first_seen }}
            </td>
            <td>
                Birth Date:
                {{ $patient->birthday }}
            </td>
            <td>
                Birth Weight:
                {{ $data->birth_weight }}
            </td>
        </tr>
        <tr>
            <td>
                Place of delivery:
                {{ $data->place_of_delivery }}
            </td>
            <td colspan="2">
                Birth registered at local civil registry (date):
                {{ $data->birth_registered }}
            </td>
        </tr>
        <tr>
            <td colspan="3">
                Complete address of family (House No., Street, City/Province):
                {{ $data->complete_address }}
            </td>
        </tr>
        <tr>
            <th colspan="3" class="titleHead">BROTHERS AND SISTERS</th>
        </tr>
        <tr>
            <td>Name:</td>
            <td>Sex:</td>
            <td>Date of Birth:</td>
        </tr>

        <?php
        $bro_sis = explode('^', $data->bro_sis);
        $gender = explode('^', $data->gender);
        $date_birth = explode('^', $data->date_birth);

        ?>


        @for($i=0;$i<12;$i++)
            <tr>
                <td>
                    @if($bro_sis[$i] != '*') {{ $bro_sis[$i] }} @endif
                </td>
                <td class="text-center">
                    <label class="normalLabel">
                        <input type="radio" name="gender{{ $i }}" value="M"
                               @if($gender[$i] == 'M') checked="checked" @endif> M
                    </label>
                    &nbsp; &nbsp; &nbsp; &nbsp;
                    <label class="normalLabel">
                        <input type="radio" name="gender{{ $i }}" value="F"
                               @if($gender[$i] == 'F') checked="checked" @endif> F
                    </label>
                </td>
                <td>
                    @if($date_birth[$i] != '*') {{ $date_birth[$i] }} @endif
                </td>
            </tr>
        @endfor



        </tbody>
    </table>
</div>


<div>
    <table border="1">
        <tbody>
        <tr>
            <th colspan="7" class="titleHead">ESSENTIAL HEALTH AND NUTRITION SERVICES</th>
        </tr>
        <tr>
            <td></td>
            <td colspan="6" style="text-align: center">DATE OF VISITS</td>
        </tr>
        <tr>
            <th></th>
            <td>1st</td>
            <td>2nd</td>
            <td>3rd</td>
            <td>4th</td>
            <td>5th</td>
            <td>6th</td>
        </tr>

        <?php
        $pv = explode('^', $data->pv);
        $opv = explode('^', $data->opv);
        $mmr_two = explode('^', $data->mmr_two);
        $ipv = explode('^', $data->ipv);
        $pcv = explode('^', $data->pcv);
        ?>

        <tr>
            <th>NEWBORN SCREENING</th>
            @for($i=0;$i<6;$i++)
                <td @if($i>0) class="stripedLine" @endif>
                    @if($i<1)
                        {{ $data->newborn_screening }}
                    @endif
                </td>
            @endfor
        </tr>
        <tr>
            <th>BCG (at birth)</th>
            @for($i=0;$i<6;$i++)
                <td @if($i>0) class="stripedLine" @endif>
                    @if($i<1)
                        {{ $data->bcg }}
                    @endif
                </td>
            @endfor
        </tr>

        <tr>
            <th>PV (6 wks, 10 wks, 14 wks old)</th>
            @for($i=0;$i<6;$i++)
                <td @if($i>2) class="stripedLine" @endif>
                    @if($i<3)
                        @if($pv[$i] != '*') {{ $pv[$i] }} @endif
                    @endif
                </td>
            @endfor
        </tr>

        <tr>
            <th>OPV (6 wks, 10 wks, 14 wks old)</th>
            @for($i=0;$i<6;$i++)
                <td @if($i>2) class="stripedLine" @endif>
                    @if($i<3)
                        @if($opv[$i] != '*') {{ $opv[$i] }} @endif
                    @endif
                </td>
            @endfor
        </tr>

        <tr>
            <th>HEPATITIS B (6 wks, 10 wks, 14 wks old)</th>
            @for($i=0;$i<6;$i++)
                <td @if($i>0) class="stripedLine" @endif>
                    @if($i<1)
                        {{ $data->hepatitis }}
                    @endif
                </td>
            @endfor
        </tr>

        <tr>
            <th>MMR1</th>
            @for($i=0;$i<6;$i++)
                <td @if($i>0) class="stripedLine" @endif>
                    @if($i<1)
                        {{ $data->mmr_one }}
                    @endif
                </td>
            @endfor
        </tr>
        <tr>
            <th>MMR2</th>
            @for($i=0;$i<6;$i++)
                <td>
                    @if($mmr_two[$i] != '*') {{ $mmr_two[$i] }} @endif
                </td>
            @endfor
        </tr>
        <tr>
            <th>IPV</th>
            @for($i=0;$i<6;$i++)
                <td>
                    @if($ipv[$i] != '*') {{ $ipv[$i] }} @endif
                </td>
            @endfor
        </tr>
        <tr>
            <th>PCV</th>
            @for($i=0;$i<6;$i++)
                <td>
                    @if($pcv[$i] != '*') {{ $pcv[$i] }} @endif
                </td>
            @endfor
        </tr>



        </tbody>
    </table>
</div>