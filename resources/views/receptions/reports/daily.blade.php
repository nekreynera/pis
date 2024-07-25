@component('partials/header')

    @slot('title')
        PIS | Monitoring
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/plugins/css/jquery-ui.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/receptions/status.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/receptions/reports/monitoring.css') }}" rel="stylesheet" />
@stop



@section('header')
    @include('receptions.navigation')
@stop



@section('content')

    <div class="container-fluid">
        <div class="container">



            @include('receptions.reports.search')



            @if($daily)

            @php
                $numDays = Carbon::parse($date)->daysInMonth + 1;
                $dt = Carbon::parse($date);
                $noDoctorsClinic = array(10,48,22,21);
                $sum = array();
                $fin = 0;
                $serv = 0;
                $pen = 0;
                $pau = 0;
                $can = 0;
                $unassgned = 0;
            @endphp

            <div class="table-responsive monthlyTableWrapper">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th rowspan="3">Status</th>
                            <th colspan="{{ Carbon::parse($date)->endOfMonth()->day }}" class="text-center">
                                {{ Carbon::parse($date)->format('F Y') }}
                            </th>
                            <th rowspan="3">Total</th>
                        </tr>
                        <tr>
                            @for($i=1;$i<$numDays;$i++)
                                @php
                                $weekDay = Carbon::createFromDate($dt->year, $dt->month, $i)->format('l');
                                @endphp
                                <th>{{ $weekDay[0] }}</th>
                            @endfor
                        </tr>
                        <tr>
                            @for($i=1;$i<$numDays;$i++)
                                <th>{{ $i }}</th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td class="finishedTabActive">
                                {{  (!in_array(Auth::user()->clinic, $noDoctorsClinic))? 'Finished' : 'Done' }}
                            </td>
                            @for($i=1;$i<$numDays;$i++)
                                @php
                                    $queryDate = Carbon::createFromDate($dt->year, $dt->month, $i)->toDateString();
                                    //$stat = (in_array(Auth::user()->clinic, $noDoctorsClinic))? 'D' : 'F' ;
                                    if (in_array(Auth::user()->clinic, $noDoctorsClinic)){
                                        if (Auth::user()->clinic == 22 || Auth::user()->clinic == 21){
                                            $stat = 'D';
                                        }else{
                                            $stat = 'F';
                                        }
                                    }else{
                                        $stat = 'F';
                                    }
                                    $result = App\Http\Controllers\MonitoringController::monitor($queryDate, $stat);
                                    (array_key_exists('d'.$i, $sum))? $sum['d'.$i] += $result : $sum['d'.$i] = $result;
                                    $fin += $result;
                                @endphp
                                <td class="{{ ($result)? 'finishedTabActive' : '' }}">{{ $result }}</td>
                            @endfor
                            <td style="background: #eee">{{ $fin }}</td>
                        </tr>

                        @if(!in_array(Auth::user()->clinic, $noDoctorsClinic))
                            <tr>
                                <td class="servingTabActive">
                                    {{--{{  (!in_array(Auth::user()->clinic, $noDoctorsClinic))? 'Serving' : 'Finished' }}--}}
                                    @if(!in_array(Auth::user()->clinic, $noDoctorsClinic))
                                        Serving
                                    @else
                                        @if(Auth::user()->clinic == 22 || Auth::user()->clinic == 21)
                                            Posted Result
                                        @else
                                            Finished
                                        @endif
                                    @endif
                                </td>
                                @for($i=1;$i<$numDays;$i++)
                                    @php
                                        $queryDate = Carbon::createFromDate($dt->year, $dt->month, $i)->toDateString();
                                        $stat = (in_array(Auth::user()->clinic, $noDoctorsClinic))? 'F' : 'S' ;
                                        $result = App\Http\Controllers\MonitoringController::monitor($queryDate, $stat);
                                        (array_key_exists('d'.$i, $sum))? $sum['d'.$i] += $result : $sum['d'.$i] = $result;
                                        $serv += $result;
                                    @endphp
                                    <td class="{{ ($result)? 'servingTabActive' : '' }}">{{ $result }}</td>
                                @endfor
                                <td style="background: #eee">
                                   {{ $serv }} 
                                </td>
                            </tr>
                        @endif

                        <tr>
                            <td class="pendingTabActive">
                                Pending
                            </td>
                            @for($i=1;$i<$numDays;$i++)
                                @php
                                    $queryDate = Carbon::createFromDate($dt->year, $dt->month, $i)->toDateString();
                                    $result = App\Http\Controllers\MonitoringController::monitor($queryDate, 'P');
                                    (array_key_exists('d'.$i, $sum))? $sum['d'.$i] += $result : $sum['d'.$i] = $result;
                                    $pen += $result;
                                @endphp
                                <td class="{{ ($result)? 'pendingTabActive' : '' }}">{{ $result }}</td>
                            @endfor
                            <td style="background: #eee">
                               {{ $pen }} 
                            </td>
                        </tr>

                        @if(!in_array(Auth::user()->clinic, $noDoctorsClinic))
                            <tr>
                                <td class="pausedTabActive">Paused</td>
                                @for($i=1;$i<$numDays;$i++)
                                    @php
                                        $queryDate = Carbon::createFromDate($dt->year, $dt->month, $i)->toDateString();
                                        $result = App\Http\Controllers\MonitoringController::monitor($queryDate, 'H');
                                        (array_key_exists('d'.$i, $sum))? $sum['d'.$i] += $result : $sum['d'.$i] = $result;
                                        $pau += $result;
                                    @endphp
                                    <td class="{{ ($result)? 'pausedTabActive' : '' }}">{{ $result }}</td>
                                @endfor
                                <td style="background: #eee">
                                   {{ $pau }} 
                                </td>
                            </tr>
                        @endif

                        <tr>
                            <td class="nawcTabActive">NAWC</td>
                            @for($i=1;$i<$numDays;$i++)
                                @php
                                    $queryDate = Carbon::createFromDate($dt->year, $dt->month, $i)->toDateString();
                                    $result = App\Http\Controllers\MonitoringController::monitor($queryDate, 'C');
                                    (array_key_exists('d'.$i, $sum))? $sum['d'.$i] += $result : $sum['d'.$i] = $result;
                                    $can += $result;
                                @endphp
                                <td class="{{ ($result)? 'nawcTabActive' : '' }}">{{ $result }}</td>
                            @endfor
                            <td style="background: #eee">
                                {{ $can }}
                            </td>
                        </tr>

                        @if(!in_array(Auth::user()->clinic, $noDoctorsClinic))
                        <tr>
                            <td class="unassignedTabActive">Unassigned</td>
                            @for($i=1;$i<$numDays;$i++)
                                @php
                                    $queryDate = Carbon::createFromDate($dt->year, $dt->month, $i)->toDateString();
                                    $result = App\Http\Controllers\MonitoringController::monitor($queryDate, 'U');
                                    (array_key_exists('d'.$i, $sum))? $sum['d'.$i] += $result : $sum['d'.$i] = $result;
                                    $unassgned += $result;
                                @endphp
                                <td class="{{ ($result)? 'unassignedTabActive' : '' }}">{{ $result }}</td>
                            @endfor
                            <td style="background: #eee">
                                {{ $unassgned }}
                            </td>
                        </tr>
                        @endif
                    </tbody>

                    <tfoot>
                        <tr>
                            <th>Total</th>
                            @for($i=1;$i<$numDays;$i++)
                                <th>{{ $sum['d'.$i] }}</th>
                            @endfor
                            <th style="background: #333;color: #fff">{{ array_sum($sum) }}</th>
                        </tr>

                        




                        @if(Auth::user()->clinic == 22 || Auth::user()->clinic == 21)

                            @php
                                $postedResult = 0;
                            @endphp

                            <tr>
                                <td colspan="{{ $numDays }}">
                                    <br>
                                </td>
                            </tr>

                            <tr>
                                <td class="servingTabActive">
                                    {{--{{  (!in_array(Auth::user()->clinic, $noDoctorsClinic))? 'Serving' : 'Finished' }}--}}
                                    @if(!in_array(Auth::user()->clinic, $noDoctorsClinic))
                                        Serving
                                    @else
                                        @if(Auth::user()->clinic == 22 || Auth::user()->clinic == 21)
                                            Posted Result
                                        @else
                                            Finished
                                        @endif
                                    @endif
                                </td>
                                @php
                                    $stat = (in_array(Auth::user()->clinic, $noDoctorsClinic))? 'F' : 'S' ;
                                @endphp
                                @for($i=1;$i<$numDays;$i++)
                                    @php
                                        $queryDate = Carbon::createFromDate($dt->year, $dt->month, $i)->toDateString();
                                        $result = App\Http\Controllers\MonitoringController::monitor($queryDate, $stat);
                                        (array_key_exists('d'.$i, $sum))? $sum['d'.$i] += $result : $sum['d'.$i] = $result;
                                        $postedResult += $result;
                                    @endphp
                                    <td class="{{ ($result)? 'servingTabActive' : '' }}">{{ $result }}</td>
                                @endfor
                                <td style="background-color: #333; color: #fff">
                                    {{ $postedResult }}
                                </td>
                            </tr>

                            <!-- <tr>
                                <th>Posted Total</th>
                                <th colspan="{{ $numDays }}">{{ $postedResult }}</th>
                            </tr> -->

                        @endif

                    </tfoot>



                </table>
            </div>


            @else

                <hr>
                    <h4 class="text-center text-danger">Please select a date to be retrieve <i class="fa fa-calendar"></i></h4>
                <hr>

            @endif

        </div>
    </div>

@endsection





@section('footer')
@stop



@section('pagescript')
    @include('message.toaster')
    <script src="{{ asset('public/plugins/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('public/js/receptions/reports.js') }}"></script>


    @if(Session::has('census') && Session::get('census') == 'monthly')
        <script>
            $(document).ready(function () {
               $('.monthlyBtn').click();
            });
        </script>
    @endif


@stop


@endcomponent
