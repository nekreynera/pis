<div class="row">

    <div class="col-md-12">
        <ul class="nav nav-pills">
            <li>
                <a href="{{ url('consultationLogs/'.$starting.'/'.$ending.'/P') }}"
                   class="pendingTab {{ ($status == 'P')? 'pendingTabActive' : '' }}">
                    Pending <span class="badge">{{ (isset($survey[0]->pending))? $survey[0]->pending : 0 }}</span>
                </a>
            </li>
            <li>
                <a href="{{ url('consultationLogs/'.$starting.'/'.$ending.'/H') }}"
                   class="pausedTab {{ ($status == 'H')? 'pausedTabActive' : '' }}">
                    Paused <span class="badge">{{ (isset($survey[0]->paused))? $survey[0]->paused : 0 }}</span>
                </a>
            </li>
            <li>
                <a href="{{ url('consultationLogs/'.$starting.'/'.$ending.'/C') }}"
                   class="nawcTab {{ ($status == 'C')? 'nawcTabActive' : '' }}">
                    NAWC <span class="badge">{{ (isset($survey[0]->nawc))? $survey[0]->nawc : 0 }}</span>
                </a>
            </li>
            <li>
                <a href="{{ url('consultationLogs/'.$starting.'/'.$ending.'/F') }}"
                   class="finishedTab {{ ($status == 'F')? 'finishedTabActive' : '' }}">
                    Finished <span class="badge">{{ (isset($survey[0]->finished))? $survey[0]->finished : 0 }}</span>
                </a>
            </li>
            <li>
                <a href="{{ url('consultationLogs/'.$starting.'/'.$ending.'/S') }}"
                   class="servingTab {{ ($status == 'S')? 'servingTabActive' : '' }}">
                    Serving <span class="badge">{{ (isset($survey[0]->serving))? $survey[0]->serving : 0 }}</span>
                </a>
            </li>
            <li>
                <a href="{{ url('consultationLogs/'.$starting.'/'.$ending) }}"
                   class="totalTab {{ ($status == false)? 'totalTabActive' : '' }}">
                    Total <span class="badge">
                    @if(isset($survey) && $survey)
                            {{ $survey[0]->serving + $survey[0]->pending + $survey[0]->nawc + $survey[0]->finished + $survey[0]->paused }}
                    @else
                        0
                    @endif
                    </span>
                </a>
            </li>
        </ul>
    </div>
</div>