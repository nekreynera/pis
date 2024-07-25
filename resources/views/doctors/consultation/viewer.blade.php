


<div class="col-md-3" id="minimizer">
    <div class="row">
        <div class="col-md-8 patientName">
            <p>SANTOS, JUAN JR. TAMAD</p>
        </div>

        <div class="col-md-4 text-right contentWindow">
            <i class="fa fa-window-minimize"></i>
            <i class="fa fa-window-maximize" onclick="windowGrow()"></i>
            <i class="fa fa-window-close closeWindow"></i>
        </div>
    </div>
</div>




<div class="row fullViewer halfViewer" id="viewerContainer">

    <div class="col-md-12">

        <div class="row bg-warning secondaryContainer">







            {{-- wrapper for page thumbnails col-xs-2 hidden-sm hidden-xs--}}
            <div class="col-md-2 col-sm-3 col-xs-5" id="thumbnailsContainer">
                <div class="row">

                    <div class="thumbnailHeader">
                        <p>Page Thumbnails</p>
                        <i class="fa fa-chevron-left" id="chevronMinimize"></i>
                    </div>

                    <div class="thumbnailsWrapper">
                        @for($i=1;$i<10;$i++)
                            <p class="thumbnailDate text-center">Mar 12, 2018</p>

                            <a href="#page{{ $i }}" class="text-muted">
                                <div class="thumbnailContent center-block">
                                    {!! $viewer->consultation !!}
                                </div>
                            </a>

                            <p class="pageNumber text-muted text-center">{{ $i }}</p>
                        @endfor
                    </div>

                </div>
            </div>













            {{-- wrapper for main content --}}
            <div class="col-md-10  mainContentWrapper">

                <div class="row mainContentHeader">
                    <div class="col-md-8 col-xs-7 patientName">

                        <i class="fa fa-chevron-right text-muted" id="chevronMaximize"></i>

                        <!-- <i class="fa fa-navicon hidden-sm hidden-md hidden-lg" id="chevronMaximize"></i> -->

                        &nbsp;
                        <p>
                             SANTOS, <span class="hidden-xs">JUAN JR. TAMAD</span>
                        </p>
                    </div>

                    <div class="col-md-4 col-xs-5 text-right contentWindow">
                        <i class="fa fa-window-minimize" id="windowMinimize"></i>
                        <i class="fa fa-window-restore hidden-xs" id="windowRestore" onclick="windowRestore()"></i>
                        <i class="fa fa-window-close closeWindow"></i>
                    </div>
                </div>


                {{-- Main Content --}}
                <div class="row mainContent">


                    <div class="magnifyWrapper">
                        <button class="btn btn-circle btn-default" id="zoomIn" title="Zoom In">
                            <i class="fa fa-plus"></i>
                        </button>
                        <br>
                        <button class="btn btn-circle btn-default" id="zoomOut" title="Zoom Out">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>



                    @for($i=1;$i<10;$i++)

                    <div class="pageContent center-block" id="page{{ $i }}">

                        <div class="row contentHeaderRow">

                            {{-- Doctors Name --}}
                            <div class="col-md-7 col-sm-6">
                                <p class="doctorsName">{{ $i }} Family Medicine | Dr. Juan Tamad Jr. Santos</p>
                            </div>
                            {{-- Doctors Name --}}

                            {{-- Print and Delete Icons --}}
                            <div class="col-md-5 col-sm-6 text-right">
                                <a href="" class="contentIcons iconPrint">
                                    <i class="fa fa-print"></i> Print
                                </a>
                                &nbsp;
                                <a href="" class="contentIcons iconPencil">
                                    <i class="fa fa-pencil"></i> Edit
                                </a>
                            </div>
                            {{-- Print and Delete Icons --}}
                        </div>
                        {!! $viewer->consultation !!} {{-- Main Body Content --}}
                    </div>

                    <br>

                    @endfor



                </div>
            </div> {{--end of main content--}}





        </div>



    </div>
</div>
