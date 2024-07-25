<td>
    <div class="dropdown">
        <a href="" class="btn btn-default btn-circle dropdown-toggle" {!! (empty($reasgn))? 'data-toggle="dropdown"' : $reasgn !!} >
            <i class="fa fa-refresh text-primary"></i>
        </a>
        <ul class="dropdown-menu dropdown-menu-right">
            <li class="dropdown-header">-- Re-assign to Doctor --</li>
            @if(count($allDoctors) > 0)
                @foreach($allDoctors as $allDoctor)
                    @php
                        $checkAssigned = (in_array($allDoctor->id, $assignedDoctor))? '#adebad' : '';
                    @endphp
                    @if(App\User::isActive($allDoctor->id))
                    <li class="{{ ($allDoctor->id == $patient->doctors_id)? 'disabled' : '' }}">
                        <a href='{{ url("reassign/$allDoctor->id/$patient->asgnid") }}' style="background-color: {!! $checkAssigned !!}" {!! ($allDoctor->id == $patient->doctors_id)? 'onclick="return false"' : 'onclick="return confirm('."'Re-assign this patient?'".')"' !!}>
                            {!! "<div class='online'></div> <span class='text-uppercase'>Dr. $allDoctor->name</span>" !!}
                        </a>
                    </li>
                    @endif
                @endforeach
            @endif
        </ul>
    </div>
</td>