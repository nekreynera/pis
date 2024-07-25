<td class="{{ $status }}">
    {{ $loop->index + 1 }}
</td>
<td>
    {{ $patient->name }}
</td>
<td>
    @php
        $agePatient = App\Patient::age($patient->birthday);
    @endphp
    {!! ($agePatient > 59)? '<strong style="color:red">'.$agePatient.'</strong>' : $agePatient !!}
</td>