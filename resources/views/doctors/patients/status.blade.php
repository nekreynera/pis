<div class="row">

        <div class="col-md-3">
            <h2 class="text-left">Patients</h2>
        </div>

        <br class="visible-xs">

    <div class="col-md-9">
        <ul class="nav nav-pills pull-right">
            <li>
                <a href="{{ url('patientlist') }}"
                   class="pendingTab {{ ($status == false)? 'pendingTabActive' : '' }}">
                    <small class="hidden-xs">Pending</small>
                    <span class="badge">
                        {{ (isset($survey[0]->pending) || isset($survey[0]->serving))? $survey[0]->pending + $survey[0]->serving: 0 }}
                    </span>
                </a>
            </li>
            <li>
                <a href="{{ url('patientlist/H') }}"
                   class="pausedTab {{ ($status == 'H')? 'pausedTabActive' : '' }}">
                    <small class="hidden-xs">Paused </small>
                    <span class="badge">{{ (isset($survey[0]->paused))? $survey[0]->paused : 0 }}</span>
                </a>
            </li>
            <li>
                <a href="{{ url('patientlist/C') }}"
                   class="nawcTab {{ ($status == 'C')? 'nawcTabActive' : '' }}">
                    <small class="hidden-xs">NAWC</small>
                    <span class="badge">{{ (isset($survey[0]->nawc))? $survey[0]->nawc : 0 }}</span>
                </a>
            </li>
            <li>
                <a href="{{ url('patientlist/F') }}"
                   class="finishedTab {{ ($status == 'F')? 'finishedTabActive' : '' }}">
                    <small class="hidden-xs">Finished </small>
                    <span class="badge">{{ (isset($survey[0]->finished))? $survey[0]->finished : 0 }}</span>
                </a>
            </li>
            <li>
                <a href="{{ url('patientlist/S') }}"
                   class="servingTab {{ ($status == 'S')? 'servingTabActive' : '' }}">
                    <small class="hidden-xs">Serving</small>
                    <span class="badge">{{ (isset($survey[0]->serving))? $survey[0]->serving : 0 }}</span>
                </a>
            </li>
            <li>
                <a href="{{ url('patientlist/T') }}"
                   class="totalTab {{ ($status == 'T')? 'totalTabActive' : '' }}">
                    <small class="hidden-xs">Total</small>
                    <span class="badge">
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
