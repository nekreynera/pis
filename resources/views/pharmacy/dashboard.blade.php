<style>
    .cd-side-nav > ul > li.customer > a::before {
      font-family: FontAwesome;
      content: "\f007";
      font-size: 16px;
      color: #fff;
    }
    .cd-side-nav > ul > li.transaction > a::before {
      font-family: FontAwesome;
      content: "\f0ec";
      font-size: 16px;
      color: #fff;
    }
    .cd-side-nav > ul > li.medicine > a::before {
      font-family: FontAwesome;
      content: "\f0fa";
      font-size: 16px;
      color: #fff;
    }
    .cd-side-nav > ul > li.logs > a::before {
      font-family: FontAwesome;
      content: "\f02d";
      font-size: 16px;
      color: #fff;
    }
    .cd-side-nav > ul > li.reports > a::before {
      font-family: FontAwesome;
      content: "\f1c1";
      font-size: 16px;
      color: #fff;
    }
    .cd-side-nav > ul > li.cubes > a::before {
      font-family: FontAwesome;
      content: "\f1b3";
      font-size: 16px;
      color: #fff;
    }
    .formsfordate{
      padding: 10px!important;
    }
    .formsfordate label{
      color: #ffffff;
      font-size: 10px;
    }
    .formsfordate input{
      border-radius: 0px;
      height: 25px;
      font-size: 10px;
    }
</style>
<main class="cd-main-content">
    <nav class="cd-side-nav">
        <ul>
            <li class="cd-label">Main</li>
            <!-- <li class="has-children medicine @if(Request::is('manualinput')) active @endif">
                <a href="{{ url('manualinput') }}">Requisition</a>
            </li> -->
           <!--  <li class="has-children customer @if(Request::is('patientrequest') || Request::is('managerequest')) active @endif">
                <a href="#0">Customer</a> -->
                <!-- <span class="count">3</span> -->

              <!--   <ul>
                    <li><a href="{{ url('patientrequest') }}">Issue Request</a></li>
                    <li><a href="{{ url('managerequest') }}">Control Request</a></li>
                    <li><a href="{{ url('manualinput') }}">Direct Render</a></li>
                </ul>
            </li> -->
            <li class="has-children transaction @if(Request::is('phartransaction')) active @endif">
                <a href="{{ url('phartransaction') }}">Transaction</a>
            </li>

            <li class="has-children medicine @if(Request::is('pharmacy')) active @endif">
                <a href="{{ url('pharmacy?stats=all') }}">Medicine</a>
            </li>
            

        </ul>

        <ul>
            <li class="cd-label">Secondary</li>
            <li class="has-children logs @if(Request::is('logs')) active @endif">
                @php
                $now = Carbon::now();
                $date = Carbon::parse($now)->format('Y-m-d');
                @endphp
                <a href="logs?from={{$date}}&to={{$date}}">Logs</a>

                {{--<ul>
                    <li><a href="#0">All Bookmarks</a></li>
                    <li><a href="#0">Edit Bookmark</a></li>
                    <li><a href="#0">Import Bookmark</a></li>
                </ul>--}}
            </li>
            <li class="has-children cubes @if(Request::is('pharmacycencus')) active @endif">
                <a href="{{ url('pharmacycencus') }}" target="_blank">Census</a>
            </li>
            <li class="has-children reports @if(Request::is('reports')) active @endif">
                <a href="{{ url('reports') }}">Reports</a>
            </li>
            <!-- <li class="has-children reports">
                <a href="#0">Reports</a>

                <ul>
                    <li><a href="{{ url('issuance_C') }}">Issuance - CLASS C</a></li>
                    <li><a href="{{ url('issuance_D') }}">Issuance - CLASS D</a></li>
                    <li><a href="{{ url('issuance_DOH') }}">Issuance - DOH</a></li>
                    <li><a href="{{ url('inventory_R') }}">Inventory</a></li>
                    <li><a href="{{ url('consolidation_C') }}">Consolidation</a></li>
                    
                </ul>
            </li> -->

            <!-- <li class="has-children cubes @if(Request::is('inventory')) active @endif">
                <a href="{{ url('inventory') }}">Consolidition</a>
            </li> -->
        </ul>

    </nav>

    @yield('main-content')
    
</main> <!-- .cd-main-content -->
