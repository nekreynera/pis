<ul class="nav nav-tabs">



    @if(Request::is('addTemplate'))
        <li class="active">
            <a data-toggle="tab" href="#addResultWrapper">
                Add Template <i class="fa fa-file-text-o"></i>
            </a>
        </li>
    @else
        <li class="active">
            <a data-toggle="tab" href="#addResultWrapper">
                Edit Template <i class="fa fa-file-text-o"></i>
            </a>
        </li>
    @endif


    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            Ultrasound
            <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            @foreach($ultrasound as $row)
            <li>
                <a href="{{ url('editTemplate/'.$row->id) }}">
                    {{ $row->description }}
                </a>
            </li>
            @endforeach
        </ul>
    </li>



    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            X-Ray
            <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            @foreach($xray as $row)
                <li>
                    <a href="{{ url('editTemplate/'.$row->id) }}">
                        {{ $row->description }}
                    </a>
                </li>
            @endforeach
        </ul>
    </li>



    @if(Request::is('radiology/*/edit'))
        <li>
            <a href="{{ url('radiologyPrint/'.$radiology->id) }}" target="_blank">
                Print <i class="fa fa-print"></i>
            </a>
        </li>
    @endif



</ul>