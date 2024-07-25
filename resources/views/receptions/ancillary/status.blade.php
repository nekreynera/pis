@php
    $surveyArray = array('P'=>0,'D'=>0,'F'=>0,'C'=>0);
    foreach ($survey as $row){
        switch ($row->status){
            case 'C':
                $surveyArray['C'] = $row->total;
                break;
            case 'F':
                $surveyArray['F'] = $row->total;
                break;
            case 'D':
                $surveyArray['D'] = $row->total;
                break;
            default:
                $surveyArray['P'] = $row->total;
                break;
        }
    }

@endphp

<ul class="nav nav-tabs">
    <li>
            <a href="{{ url('overview') }}"
               class="pendingTab {{ ($status == false)? 'pendingTabActive' : '' }}">
                Pending <span class="badge">
                    {{ $surveyArray['P'] }}
                </span>
            </a>
    </li>
    <li>
            <a href="{{ url('overview/C') }}"
               class="nawcTab {{ ($status == 'C')? 'nawcTabActive' : '' }}">
                NAWC <span class="badge">
                    {{ $surveyArray['C'] }}
                </span>
            </a>
    </li>
    <li>
        <a href="{{ url('overview/F') }}"
           class="finishedTab {{ ($status == 'F')? 'finishedTabActive' : '' }}">
            Done <span class="badge">
                {{ $surveyArray['F'] }}
            </span>
        </a>
    </li>


    {{--@if(Auth::user()->clinic == 22 || Auth::user()->clinic == 21)
    <li>
        <a href="{{ url('overview/D') }}"
           class="servingTab {{ ($status == 'D')? 'servingTabActive' : '' }}">
            Finished <span class="badge">
                {{ $surveyArray['D'] }}
            </span>
        </a>
    </li>
    @endif--}}


    @if(Auth::user()->clinic == 22 || Auth::user()->clinic == 21)
        <li>
            <a href="{{ url('overview/D') }}"
               class="servingTab {{ ($status == 'D')? 'servingTabActive' : '' }}">
                Posted Result <span class="badge">
                {{ $surveyArray['D'] }}
            </span>
            </a>
        </li>
    @endif



    <li>
        <a href="{{ url('overview/T') }}"
           class="totalTab {{ ($status == 'T')? 'totalTabActive' : '' }}">
            Total <span class="badge">
                {{ array_sum($surveyArray) }}
                </span>
        </a>
    </li>
</ul>