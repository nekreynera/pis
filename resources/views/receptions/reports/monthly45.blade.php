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


            @php
                $st = Carbon::parse($start);
                $et = Carbon::parse($end);
                $begin = Carbon::parse($start)->month;
                $final = Carbon::parse($end)->month + 1;
                $noDoctorsClinic = array(10,48,22,21);
                $sum = array();
            @endphp

                <div class="table-responsive monthlyTableWrapper">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th rowspan="2" class="text-center">Status</th>
                            <th colspan="31" class="text-center">Month</th>
                        </tr>
                        <tr>
                            @for($i=$begin;$i<$final;$i++)
                                <th class="text-center">{{ Carbon::parse("2018-$i-01")->format('F') }}</th>
                            @endfor
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="finishedTabActive">
                            <td>
                                {{  (!in_array(Auth::user()->clinic, $noDoctorsClinic))? 'Finished' : 'Done' }}
                            </td>
                            @for($i=$begin;$i<$final;$i++)
                                @php
                                    $day = Carbon::create($et->year, $i)->endOfMonth()->day;
                                    $startingDate = Carbon::createFromDate($st->year, $i, 01)->toDateString();
                                    $endingDate = Carbon::createFromDate($et->year, $i, $day)->toDateString();
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
                                    $result = App\Http\Controllers\MonitoringController::monitorMonthly($startingDate, $endingDate, $stat);
                                    (array_key_exists('m'.$i, $sum))? $sum['m'.$i] += $result : $sum['m'.$i] = $result;
                                @endphp
                                <td class="text-center">{{ $result }}</td>
                            @endfor
                        </tr>

                        @if(!in_array(Auth::user()->clinic, $noDoctorsClinic))
                        <tr class="servingTabActive">
                            <td>
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
                            @for($i=$begin;$i<$final;$i++)
                                @php
                                    $day = Carbon::create($et->year, $i)->endOfMonth()->day;
                                    $startingDate = Carbon::createFromDate($st->year, $i, 01)->toDateString();
                                    $endingDate = Carbon::createFromDate($et->year, $i, $day)->toDateString();
                                    $stat = (in_array(Auth::user()->clinic, $noDoctorsClinic))? 'F' : 'S' ;
                                    $result = App\Http\Controllers\MonitoringController::monitorMonthly($startingDate, $endingDate, $stat);
                                    (array_key_exists('m'.$i, $sum))? $sum['m'.$i] += $result : $sum['m'.$i];
                                @endphp
                                <td class="text-center">{{ $result }}</td>
                            @endfor
                        </tr>
                        @endif

                        <tr class="pendingTabActive">
                            <td>Pending</td>
                            @for($i=$begin;$i<$final;$i++)
                                @php
                                    $day = Carbon::create($et->year, $i)->endOfMonth()->day;
                                    $startingDate = Carbon::createFromDate($st->year, $i, 01)->toDateString();
                                    $endingDate = Carbon::createFromDate($et->year, $i, $day)->toDateString();
                                    $result = App\Http\Controllers\MonitoringController::monitorMonthly($startingDate, $endingDate, 'P');
                                    (array_key_exists('m'.$i, $sum))? $sum['m'.$i] += $result : $sum['m'.$i];
                                @endphp
                                <td class="text-center">{{ $result }}</td>
                            @endfor
                        </tr>
                        @if(!in_array(Auth::user()->clinic, $noDoctorsClinic))
                            <tr class="pausedTabActive">
                                <td>Paused</td>
                                @for($i=$begin;$i<$final;$i++)
                                    @php
                                        $day = Carbon::create($et->year, $i)->endOfMonth()->day;
                                        $startingDate = Carbon::createFromDate($st->year, $i, 01)->toDateString();
                                        $endingDate = Carbon::createFromDate($et->year, $i, $day)->toDateString();
                                        $result = App\Http\Controllers\MonitoringController::monitorMonthly($startingDate, $endingDate, 'H');
                                        (array_key_exists('m'.$i, $sum))? $sum['m'.$i] += $result : $sum['m'.$i];
                                    @endphp
                                    <td class="text-center">{{ $result }}</td>
                                @endfor
                            </tr>
                        @endif
                        <tr class="nawcTabActive">
                            <td>Canceled</td>
                            @for($i=$begin;$i<$final;$i++)
                                @php
                                    $day = Carbon::create($et->year, $i)->endOfMonth()->day;
                                    $startingDate = Carbon::createFromDate($st->year, $i, 01)->toDateString();
                                    $endingDate = Carbon::createFromDate($et->year, $i, $day)->toDateString();
                                    $result = App\Http\Controllers\MonitoringController::monitorMonthly($startingDate, $endingDate, 'C');
                                    (array_key_exists('m'.$i, $sum))? $sum['m'.$i] += $result : $sum['m'.$i];
                                @endphp
                                <td class="text-center">{{ $result }}</td>
                            @endfor
                        </tr>
                        @if(!in_array(Auth::user()->clinic, $noDoctorsClinic))
                        <tr class="unassignedTabActive">
                            <td>Unassigned</td>
                            @for($i=$begin;$i<$final;$i++)
                                @php
                                    $day = Carbon::create($et->year, $i)->endOfMonth()->day;
                                    $startingDate = Carbon::createFromDate($st->year, $i, 01)->toDateString();
                                    $endingDate = Carbon::createFromDate($et->year, $i, $day)->toDateString();
                                    $result = App\Http\Controllers\MonitoringController::monitorMonthly($startingDate, $endingDate, 'U');
                                    (array_key_exists('m'.$i, $sum))? $sum['m'.$i] += $result : $sum['m'.$i];
                                @endphp
                                <td class="text-center">{{ $result }}</td>
                            @endfor
                        </tr>
                        @endif

                        </tbody>

                        <tfoot>

                            <tr class="">
                                <th>Total</th>
                                @for($i=$begin;$i<$final;$i++)
                                    <th class="text-center">{{ $sum['m'.$i] }}</th>
                                @endfor
                            </tr>


                            @if(Auth::user()->clinic == 22 || Auth::user()->clinic == 21)
                            <tr class="">
                                <td colspan="{{ $final }}"><br></td>
                            </tr>


                            <tr class="servingTabActive">
                                <td>
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
                                @for($i=$begin;$i<$final;$i++)
                                    @php
                                        $day = Carbon::create($et->year, $i)->endOfMonth()->day;
                                        $startingDate = Carbon::createFromDate($st->year, $i, 01)->toDateString();
                                        $endingDate = Carbon::createFromDate($et->year, $i, $day)->toDateString();
                                        $stat = (in_array(Auth::user()->clinic, $noDoctorsClinic))? 'F' : 'S' ;
                                        $result = App\Http\Controllers\MonitoringController::monitorMonthly($startingDate, $endingDate, $stat);
                                        (array_key_exists('m'.$i, $sum))? $sum['m'.$i] += $result : $sum['m'.$i];
                                    @endphp
                                    <td class="text-center">{{ $result }}</td>
                                @endfor
                            </tr>
                            @endif

                        </tfoot>
                    </table>
                </div>


        </div>
    </div>

@endsection





@section('footer')
@stop



@section('pagescript')
    @include('message.toaster')
    <script src="{{ asset('public/plugins/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('public/js/receptions/reports.js') }}"></script>

    @if(Session::has('census') && Session::get('census') == 'daily')
        <script>
            $(document).ready(function () {
                $('.dailyBtn').click();
            });
        </script>
    @endif


    @if($category)
        <script>
            $(document).ready(function () {
                $('.monthlyBtn').click();
            });
        </script>
    @endif

@stop


@endcomponent
