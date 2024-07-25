<td>
    @if($patient->cid == null)
        <button class="btn btn-default btn-circle"
                onclick="medicalRecords({{ $patient->id }})" title="View medical record's">
            <i class="fa fa-file-text-o text-primary"></i>
        </button>
    @else
        <button class="btn btn-primary btn-circle"
                onclick="medicalRecords({{ $patient->id }})" title="View medical record's">
            <i class="fa fa-file-text-o text-default"></i>
        </button>
    @endif
</td>