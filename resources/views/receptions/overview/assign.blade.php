<td>
    <div class="dropdown">
        <a href="" class="btn btn-default btn-circle dropdown-toggle" {!! (empty($asgn))? 'data-toggle="dropdown"' : $asgn !!}>
            <i class="fa fa-arrow-left text-success"></i>
        </a>
        <ul class="dropdown-menu dropdown-menu-right">
            <li class="dropdown-header">--Assign to Doctor--</li>
            @if(count($allDoctors) > 0)
                @foreach($allDoctors as $allDoctor)
                    @php
                        $checkAssigned = (in_array($allDoctor->id, $assignedDoctor))? '#adebad' : '';
                    @endphp
                    @if(App\User::isActive($allDoctor->id))
                    <li>
                        <a href='{{ url("assign/$patient->id/$allDoctor->id") }}' style="background-color: {!! $checkAssigned !!}">
                            {!! "<div class='online'></div> <span class='text-uppercase'>Dr. $allDoctor->name</span>" !!}
                        </a>
                    </li>
                    @endif
                @endforeach
            @endif
        </ul>
    </div>
</td>