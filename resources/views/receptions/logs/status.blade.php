@if(!in_array(Auth::user()->clinic, $noDoctorsClinic))

    <ul class="nav nav-pills">
        <li><a href="#" class="finishedTabActive">Finished <span class="badge">{{ $fin }}</span></a></li>
        <li><a href="#" class="servingTabActive">Serving <span class="badge">{{ $serv }}</span></a></li>
        <li><a href="#" class="pendingTabActive">Pending <span class="badge">{{ $pen }}</span></a></li>
        <li><a href="#" class="unassignedTabActive">Unassigned <span class="badge">{{ $unassgned }}</span></a></li>
        <li><a href="#" class="pausedTabActive">Paused <span class="badge">{{ $pau }}</span></a></li>
        <li><a href="#" class="nawcTabActive">NAWC <span class="badge">{{ $can }}</span></a></li>
        <li><a href="#" class="totalTabActive">Total <span class="badge">{{ $pen + $serv + $unassgned + $pau + $can + $fin }}</span></a></li>
    </ul>

@else

    <ul class="nav nav-pills">
        <li><a href="#" class="pendingTabActive">Pending <span class="badge">{{ $queuePending }}</span></a></li>
        <li><a href="#" class="nawcTabActive">NAWC <span class="badge">{{ $queueCanceled }}</span></a></li>

        @if(Auth::user()->clinic == 22 || Auth::user()->clinic == 21)
         <li><a href="#" class="finishedTabActive">Done <span class="badge">{{ $queueDone }}</span></a></li>
        <li><a href="#" class="servingTabActive">Posted Result <span class="badge">{{ $queueFinished }}</span></a></li>
        @else
            <li><a href="#" class="finishedTabActive">Done <span class="badge">{{ $queueDone }}</span></a></li>
        @endif
        <li><a href="#" class="totalTabActive">Total <span class="badge">{{ $queuePending + $queueCanceled + $queueFinished + $queueDone }}</span></a></li>
    </ul>

@endif