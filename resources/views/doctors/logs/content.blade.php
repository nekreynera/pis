<tr>
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
    <td>
        <a href="{{ url('patientinfo/'.$patient->pid) }}" class="btn btn-circle btn-default"
           data-placement="top" data-toggle="tooltip" title="Patient's information">
            <i class="fa fa-user-o text-primary"></i>
        </a>
        @if($totalNotification > 0)
            <span class="notifyBadge badge">{{ $totalNotification }}</span>
        @endif
    </td>
    <td class="text-center">
        @if($patient->pcid)
            <button class="btn btn-primary btn-sm btn-circle"
                    onclick="medicalRecords({{ $patient->pid }})" title="View medical record's">
                <i class="fa fa-file-text-o"></i>
            </button>
        @else
            <button class="btn btn-default btn-sm btn-circle"
                    onclick="medicalRecords({{ $patient->pid }})" title="View medical record's">
                <i class="fa fa-file-text-o text-primary"></i>
            </button>
        @endif
    </td>
    <td>
        <p class="{{ $statusColor }}">{{ strtoupper($status) }}</p>
    </td>
    <td>
        {{ Carbon::parse($patient->updated_at)->toDayDateTimeString() }}
    </td>
</tr>