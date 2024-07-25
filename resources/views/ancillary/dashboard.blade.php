
<main class="cd-main-content">
    <nav class="cd-side-nav">
        <ul>
            <li class="cd-label">Main</li>
           
          <!--   <li class="has-children medicine @if(Request::is('directrequisition')) active @endif">
                <a href="{{ url('directrequisition') }}">Requisition</a>
            </li> -->
            <li class="has-children transaction @if(Request::is('paidtransaction') || Request::is('unpaidtransaction')) active @endif">
                <a href="#0">Transactions</a>

                <ul>
                    <li><a href="{{ url('paidtransaction') }}"><b>Paid</b> <i style="font-size: 10px;">(class D/charity and paid in cashier)</i></a></li>
                    <li><a href="{{ url('unpaidtransaction') }}"><b>Unpaid</b> <i style="font-size: 10px;">(class C-Bellow or Unpaid in cashier)</i></a></li>
                   
                </ul>
            </li>
            <!-- <li class="has-children medicine @if(Request::is('ancillarytransaction')) active @endif">
                <a href="{{ url('ancillarytransaction') }}">Transaction</a>
            </li> -->
            <li class="has-children medicine @if(Request::is('pharmacy')) active @endif">
                <a href="{{ url('ancillary') }}">Services</a>
            </li>
        </ul>
        <ul>
            <li class="cd-label">Secondary</li>
            <li class="has-children logs @if(Request::is('ancillarycensus')) active @endif">
                <a href="ancillarycensus?top=ALL&from={{Carbon::now()->setTime(0,0)->format('Y-m-d')}}&to={{Carbon::now()->setTime(0,0)->format('Y-m-d')}}">Census</a>
            </li>
            <li class="has-children logs @if(Request::is('ancillaryreport')) active @endif">
                <a href="{{ url('ancillaryreport') }}">Report</a>
            </li>
            
           
            
        </ul>

    </nav>

    @yield('main-content')
    
</main> <!-- .cd-main-content -->
