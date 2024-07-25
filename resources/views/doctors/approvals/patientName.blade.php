<td>
    {{ $loop->index + 1 }}
</td>
<td>
    <span>{{ $approval->name }}</span>
</td>
<td>
    {{ App\Patient::age($approval->birthday) }}
</td>
<td>
    <span>{{ $approval->doctorsname }}</span>
</td>
<td class="text-center">
    <a href="{{ url('patientinfo/'.$approval->pid) }}" class="btn btn-circle btn-default"
       data-placement="top" data-toggle="tooltip" title="Patient's information">
        <i class="fa fa-user-o text-primary"></i>
    </a>
</td>