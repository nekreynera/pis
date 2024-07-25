<td>
    @php
        $checkIfForRefferal = App\Refferal::checkIfForRefferal($patient->pid);
    @endphp
    @if($checkIfForRefferal > 0)
        <a href='{{ url("patientinfo/$patient->pid") }}' class="btn btn-info btn-circle" title="Patient Information">
            <i class="fa fa-user-o"></i>
        </a>
    @else
        <a href='{{ url("patientinfo/$patient->pid") }}' class="btn btn-default btn-circle" title="Patient Information">
            <i class="fa fa-user-o text-primary"></i>
        </a>
    @endif

    @if($refferal > 0)
        <span class="notifyBadgeNumber badge">{{ $refferal }}</span>
    @endif
    @if($followups > 0)
        <span class="notifyFollowUpBadgeNumber badge">{{ $followups }}</span>
    @endif

</td>
