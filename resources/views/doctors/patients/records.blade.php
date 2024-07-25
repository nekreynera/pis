<td class="text-center">
    @if($patient->pcid)
        <button class="btn btn-primary btn-circle" onclick="medicalRecords({{ $patient->pid }})" title="View medical record's">
            <i class="fa fa-file-text-o text-default"></i>
        </button>


        <!-- smoke -->
        @if($patient->smoke)
            <i class="fa fa-fire text-danger" title="Advised with smoke cessation"></i>
        @endif


    @else
        <button class="btn btn-default btn-circle" onclick="medicalRecords({{ $patient->pid }})" title="View medical record's">
            <i class="fa fa-file-text-o text-primary"></i>
        </button>
    @endif
</td>


{{--<td>
    <p class="{{ $statusColor }}">{{ strtoupper($status) }}</p>
</td>--}}

<td>
    {{ Carbon::parse($patient->created_at)->format('h:i:s a') }}
</td>