<main class="cd-main-content">
    <nav class="cd-side-nav">
        <ul>
            <li class="cd-label">Main</li>
            <li class="has-children patientlist @if(Request::is('patientlist')) active @endif">
                <a href="{{ url('patientlist') }}">Patients</a>
            </li>



           {{-- @if(Session::has('pid'))
            <li class="has-children history">
                <a href="#0">Medical Records</a>
                <ul>
                    <li>
                        <a href="{{ url('nowservingconsultations/'.$history[0]->id) }}">Consultation Records
                            <span class="badge recordsBadge">{{ $history[0]->consultations or '' }}</span>
                        </a>
                    </li>
                  <!--   <li>
                        <a href="{{ url('diagnosis_list/'.$history[0]->id) }}" class="disabled">Diagnosis Records
                            <span class="badge recordsBadge">{{ $history[0]->diagnosis or '' }}</span>
                        </a>
                    </li> -->
                    <li>
                        <a href="{{ url('requisitions_list/'.$history[0]->id) }}">Requisition Records
                            <span class="badge recordsBadge">{{ ($history[0]->requisitions != 0)? $history[0]->requisitions : '' }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('nowservingrefferal/'.$history[0]->id) }}">Refferal Records
                            <span class="badge recordsBadge">{{ $history[0]->refferals or '' }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('nowservingfollowup/'.$history[0]->id) }}">Follow Up Records
                            <span class="badge recordsBadge">{{ $history[0]->followups or '' }}</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif--}}



            <li class="has-children notifications @if(Request::is('consultation') || Request::is('consultation/*/edit')) active @endif">
                <a href="{{ url('consultation') }}">Consultation{{--<span class="count">3</span>--}}</a>
                {{--<ul>
                    <li><a href="#" data-toggle="modal" data-target="#fileupload">Filemanager</a></li>
                </ul>--}}
            </li>
            {{--<li class="has-children comments @if(Request::is('diagnosis')) active @endif">
                <a href="{{ url('diagnosis') }}">Diagnosis</a>
            </li>--}}
            {{--<li class="has-children doctors_order @if(Request::is('doctors_order')) active @endif">
                <a href="{{ url('doctors_order') }}">Disposition</a>
            </li>--}}
            {{--<li class="has-children medicalImging @if(Request::is('medical_images')) active @endif">
                <a href="{{ url('medical_imaging') }}">Medical Imaging</a>
            </li>--}}
        </ul>

        <ul>
            <li class="cd-label">Secondary</li>
            <li class="has-children users @if(Request::is('requisition')) active @endif">
                <a href="{{ url('requisition') }}">Requisition</a>
            </li>
            <li class="has-children bookmarks @if(Request::is('refferal')) active @endif">
                <a href="{{ url('refferal') }}">Referral</a>
            </li>
            <li class="has-children images @if(Request::is('followup')) active @endif">
                <a href="{{ url('followup') }}">Follow-Up</a>
            </li>

            {{--@if(Session::has('pid'))
                <li class="has-children patientinfo @if(Request::is('patientinformation')) active @endif">
                    <a href="{{ url('patientinformation') }}">Patient Info {!! (($refferal + $followups) > 0)? '<span class="count">'.($refferal + $followups).'</span>' : '' !!} </a>
                </li>
            @endif--}}

            <li class="has-children diseases @if(Request::is('diseases')) active @endif">
                <a href="{{ url('diseases') }}">Diseases</a>
            </li>

        </ul>


        <!-- FOR FAMED ONLY -->
        {{--smoke--}}

        <ul>
            <li class="cd-label">OTHERS</li>
            <li class="has-children reports">
                <a href="#">Reports</a>
                <ul>
                    @if(Auth::user()->clinic == 8)
                        <li>
                            <a href="{{ url('smoke_cessation') }}">Smoke Cessation</a>
                        </li>
                    @endif
                    <li>
                        <a href="{{ url('doctors_census') }}">Age Gender Distribution</a>
                    </li>
                </ul>
            </li>
        </ul>


        {{--@if(Request::is('consultation') || Request::is('consultation/*/edit') || Request::is('diagnosis') || Request::is('diagnosis/*/edit'))
            <ul>
                <li class="cd-label">Action</li>
                <li class="action-btn">
                    <a href="#" class="saveButton">Submit & Save</a>
                </li>
            </ul>
        @endif--}}

    </nav>

    @yield('main-content')

</main> <!-- .cd-main-content -->