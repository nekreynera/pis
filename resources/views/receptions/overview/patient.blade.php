<td hidden>
    {{ $loop->index + 1 }}
</td>

@if(in_array(Auth::user()->clinic, $noDoctorsClinic))
    @php
        if ($patient->queue_status == 'C'){
            $queueStatus = 'nawc';
        }elseif ($patient->queue_status == 'F'){
            $queueStatus = 'finished';
        }elseif ($patient->queue_status == 'D'){
            $queueStatus = 'serving';
        }else{
            $queueStatus = 'pending';
        }
    @endphp
    <td class="{{ $queueStatus }}">
        {{ $loop->index + 1 }}
    </td>
@else
    <td class="{{ $status }}">
        {{ $loop->index + 1 }}
    </td>
@endif

<td>{{ $patient->name }}</td>
@php
    $agePatient = App\Patient::age($patient->birthday)
@endphp
<td>{!! ($agePatient >= 60)? '<strong style="color: red">'.$agePatient.'</strong>' : '<span class="text-default">'.$agePatient.'</span>' !!}</td>




{{--assign to doctor--}}
@if(Auth::user()->clinic != 31)
    <td>
        @if($patient->status == 'S' || $patient->status == 'P' || $patient->status == 'F' || $patient->status == 'H')
            @if(App\User::isActive($patient->doctors_id))
                {!! "<div class='online'></div> <span class='text-default'>Dr. $patient->doctorsname</span>" !!}
            @else
                {!! "<div class='offline'></div> <span class='text-default'>Dr. $patient->doctorsname</span>" !!}
            @endif
        @else
            <span class="text-danger">N/A</span>
        @endif
    </td>
@endif