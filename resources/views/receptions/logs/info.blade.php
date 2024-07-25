<td hidden>
    {{ $loop->index + 1 }}
</td>
<td class="{{ $status }}">
    {{ count($patients) - $loop->index }}
</td>
<td>{{ $patient->name }}</td>
@php
    $agePatient = App\Patient::age($patient->birthday)
@endphp
<td>{!! ($agePatient >= 60)? '<strong style="color: red">'.$agePatient.'</strong>' : '<span class="text-default">'.$agePatient.'</span>' !!}</td>

<td>
    @if($patient->status != null)
        @if(App\User::isActive($patient->doctors_id))
            {!! "<div class='online'></div> <span class='text-default'>Dr. $patient->doctorsname</span>" !!}
        @else
            {!! "<div class='offline'></div> <span class='text-default'>Dr. $patient->doctorsname</span>" !!}
        @endif
    @else
        <span class="text-danger">N/A</span>
    @endif
</td>

<td>
    @php
        $checkIfForRefferal = App\Refferal::checkIfForRefferal($patient->id);
    @endphp
    @if($checkIfForRefferal > 0)
        <a href='{{ url("patient_info/$patient->id") }}' class="btn btn-info btn-circle">
            <i class="fa fa-user-o"></i>
        </a>
    @else
        <a href='{{ url("patient_info/$patient->id") }}' class="btn btn-default btn-circle">
            <i class="fa fa-user-o text-primary"></i>
        </a>
    @endif

    @if($patient->rf > 0)
        <span class="notifyBadgeNumber badge">{{ $patient->rf }}</span>
    @endif
    @if($patient->ff > 0)
        <span class="notifyFollowUpBadgeNumber badge">{{ $patient->ff }}</span>
    @endif
</td>