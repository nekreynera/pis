@if(!in_array(Auth::user()->clinic, $noDoctorsClinic))
    <td>
        <a href='{!! ($patient->status == null)? url("cancelUnassigned/$patient->id") : url("cancelAssignation/$patient->asgnid") !!}'
           class="btn btn-default btn-circle" {!! $cancel !!} onclick="return confirm('Cancel this patient?')">
            <i class="fa fa-remove text-danger"></i>
        </a>
    </td>
@else
    @if($patient->queue_status == 'C')
        <td>
            <a href="{{ url('queueStatus/'.$patient->qid.'/P') }}"
               data-placement="top" data-toggle="tooltip" title="Click to mark as pending"
               class="btn btn-default btn-circle {{ ($patient->queue_status == 'F')? 'disabled':'' }}"
               onclick="return confirm('Restore this patient?')">
                <i class="fa fa-refresh text-success"></i>
            </a>
        </td>
    @else
        <td>
            <a href="{{ url('queueStatus/'.$patient->qid.'/C') }}"
               data-placement="top" data-toggle="tooltip" title="Click to mark as NAWC"
               class="btn btn-default btn-circle {{ ($patient->queue_status == 'F' || $patient->queue_status == 'D')? 'disabled':'' }}"
               onclick="return confirm('Cancel this patient?')">
                <i class="fa fa-remove text-danger"></i>
            </a>
        </td>
    @endif
@endif


<td>
    <?php
        $consultation_count = App\Consultation::check_saved_consultation_exist($patient->id);
    ?>
    <a href="{{ url('chief_complaint/'.$patient->id) }}"
       class="btn btn-default btn-circle @if($consultation_count) disabled @endif">
        <i class="fa fa-pencil text-primary"></i>
    </a>
</td>


<td>
    {{ Carbon::parse($patient->created_at)->format('H:i:s a') }}
</td>