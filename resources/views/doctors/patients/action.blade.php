<td class="text-center">
    @if($patient->status == 'P')
        <a href="{{ url('cancelPatient/'.$patient->id) }}" class="btn btn-default btn-circle"
           onclick="return confirm('Cancel this patient?')" title="This patient was not around when called.">
            <i class="fa fa-remove text-danger"></i>
        </a>
    @elseif($patient->status == 'C')
        <a href="{{ url('restorePatient/'.$patient->id) }}" class="btn btn-default btn-circle"
           onclick="return confirm('Restore this patient?')" title="Restore this patient">
            <i class="fa fa-arrow-left text-success"></i>
        </a>
    @elseif($patient->status == 'S')
        <a href="{{ url('pausePatient/'.$patient->id) }}" class="btn btn-default btn-circle"
           onclick="return confirm('Pause the consultation of this patient?')" title="Pause Consultation">
            <i class="fa fa-pause text-warning"></i>
        </a>
    @elseif($patient->status == 'F')
        <a href="{{ url('reConsult/'.$patient->id) }}" class="btn btn-default btn-circle"
           onclick="return confirm('Re-Consult this patient?')" title="Re-Consult this patient">
            <i class="fa fa-recycle text-success"></i>
        </a>
    @elseif($patient->status == 'H')
        <a href="{{ url('continueServing/'.$patient->id) }}" class="btn btn-default btn-circle"
           onclick="return confirm('Continue the consultation of this patient?')" title="Serve this patient">
            <i class="fa fa-stethoscope text-info"></i>
        </a>
    @endif
</td>