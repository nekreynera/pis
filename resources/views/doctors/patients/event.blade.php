<td>
@if($patient->pid == Session::get('pid') && $patient->status == 'S')
    <a href="{{ url('endConsultation') }}" class="btn btn-success btn-sm"
     title="Click to end this patient's consultation">
        END CONSULTATION
    </a>
@elseif($patient->status == 'H')
    <a href="{{ url('cancelPatient/'.$patient->id) }}" class="btn btn-danger btn-sm"
       onclick="return confirm('Stop this patients consultation?')"
       title="Click to stop this patient's consultation">
        STOP CONSULTATION
    </a>
@else
    @if($status != 'finished' && $status != 'nawc' && $patient->status != 'H')
        <a href="{{ url('startConsultation/'.$patient->pid) }}" class="btn btn-warning btn-sm"
           {!! (Session::has('pid'))? 'disabled onclick="return false"' : '' !!}
           title="Click to start patient consultation">
            START CONSULTATION
        </a>
    @elseif($status == 'finished')
        {{--<a href="{{ url('review/'.$patient->pid) }}" class="btn btn-info btn-sm"
           data-placement="right" data-toggle="tooltip" title="Click to review today's consultation">
            REVIEW CONSULTATION
        </a>--}}
    @endif
@endif    
</td>
