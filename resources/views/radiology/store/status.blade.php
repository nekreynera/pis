@php
    $surveyArray = array('D'=>0,'F'=>0);
    foreach ($survey as $row){
        switch ($row->status){
            case 'F':
                $surveyArray['F'] = $row->total;
                break;
            default:
                $surveyArray['D'] = $row->total;
                break;
        }
    }

@endphp

<ul class="nav nav-tabs">
    {{--<li>
        <a href="{{ url('radiologyHome') }}"
           class="pendingTab {{ ($status == false)? 'pendingTabActive' : '' }}">
            Pending <span class="badge">
                    {{ $surveyArray['P'] }}
                </span>
        </a>
    </li>
    <li>
        <a href="{{ url('radiologyHome/C') }}"
           class="nawcTab {{ ($status == 'C')? 'nawcTabActive' : '' }}">
            NAWC <span class="badge">
                    {{ $surveyArray['C'] }}
                </span>
        </a>
    </li>--}}
    <li>
        <a href="{{ url('radiologyHome') }}"
           class="finishedTab {{ (!$status)? 'finishedTabActive' : '' }}">
            Waiting For Result <span class="badge">
                {{ $surveyArray['F'] }}
            </span>
        </a>
    </li>
    <li>
        <a href="{{ url('radiologyHome/D') }}"
           class="servingTab {{ ($status == 'D')? 'servingTabActive' : '' }}">
            Posted Result <span class="badge">
                {{ $surveyArray['D'] }}
            </span>
        </a>
    </li>
    <li>
        <a href="{{ url('radiologyHome/T') }}"
           class="totalTab {{ ($status == 'T')? 'totalTabActive' : '' }}">
            Total <span class="badge">
                {{ array_sum($surveyArray) }}
                </span>
        </a>
    </li>
</ul>