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