<table border="1">
    <thead>
        <tr>
            <th colspan="4" align="center" style="height: 15px">
                <strong>{{ (Auth::user()->clinic == 22)? 'RADIOGRAPHIC' : 'ULTRASOUND'}} RESULT</strong>
            </th>
        </tr>
        <tr>
            <td style="width: 300px;height: 20px">
                EVRMC-RADIO-UTZ &nbsp; <strong>{{ $radiology->imageID }}</strong> &nbsp; S.2018
            </td>
            <td colspan="3" style="width: 267px">
                Effectivity: Aug 18, 2017 Rev.1
            </td>
        </tr>
        <tr>
            <td style="height: 40px">
                Family Name, Given Name, M.I
                <br>
                {{ $radiology->patient }}
            </td>
            <td style="width: 70px">
                Age
                <br>
                {{ App\Patient::age($radiology->birthday).' / '.$radiology->sex }}
            </td>
            <td style="width: 70px">
                Ward <br>
                PIS
            </td>
            <td style="width: 127px">
                Date/Time
                <br>
                {{ Carbon::parse($radiology->created_at)->toFormattedDateString() }}
            </td>
        </tr>
        <tr>
            <td style="height: 35px">
                Clinic Data <br>
                {{ $radiology->clinicalData }}
            </td>
            <td style="width: 267px">
                Attending Physician <br>
                {{ $radiology->physician }}
            </td>
        </tr>
    </thead>
</table>
