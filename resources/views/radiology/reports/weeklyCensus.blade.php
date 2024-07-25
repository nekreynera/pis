@component('partials/header')

    @slot('title')
        PIS | Weekly Census
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/plugins/css/jquery-ui.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/radiology/reports/highestCases.css') }}" rel="stylesheet" />
@stop


@section('header')
    @if(Auth::user()->role == 5)
        @include('receptions.navigation')
    @else
        @include('radiology/navigation')
    @endif
@stop



@section('content')
    <br>
    <div class="container-fluid">
        <div class="container weeklyCensus">

            @include('radiology.reports.weeklyDate')


            @if($dateTime)



                @php
                    $date = Carbon::parse($dateTime);
                    $ted = Carbon::parse($dateTime);
                @endphp

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th rowspan="2" colspan="2" class="text-center">
                                <h4><strong>PARTICULARS</strong></h4>
                            </th>
                            <th colspan="5" id="monthTD" class="text-center">
                                {{ $date->format('F') }}
                            </th>
                        </tr>
                        <tr>


                            @for($i=1;$i<7;$i++)
                                @php
                                    $endloop = $i;
                                    if($i == 1){
                                        $start = '01';
                                    }else{
                                        $start = $date->endOfWeek()->addDay()->format('d');
                                    }
                                    if ($date->endOfWeek()->format('m') != $ted->format('m')){
                                        $end = $ted->endOfMonth()->format('d');
                                    }else{
                                        $end = $date->endOfWeek()->format('d');
                                    }
                                @endphp
                                <th>
                                    WEEK {{ $i }} <br>
                                    ({{ $ted->format('m').'/'.$start.'-'.$end.'/'.$date->format('y') }})
                                </th>
                                @if($date->endOfWeek()->format('m') != $ted->format('m'))
                                    @php break; @endphp
                                @endif
                            @endfor




                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="2">
                                1. Total number of Radiologic Procedure Done
                            </td>
                            @for($i=0;$i<$endloop;$i++)
                                <td></td>
                            @endfor
                        </tr>
                        <tr>
                            <td class="text-right">a.</td>
                            <td>In-Patients</td>
                            @for($i=0;$i<$endloop;$i++)
                                <td></td>
                            @endfor
                        </tr>


                        <tr>
                            <td class="text-right">b.</td>
                            <td>Out-Patients</td>

                            @php
                                $firstDate = Carbon::parse($dateTime);
                                $secondDate = Carbon::parse($dateTime);
                            @endphp
                            @for($i=1;$i<7;$i++)
                                @php
                                    if($i == 1){
                                        $start = '01';
                                    }else{
                                        $start = $firstDate->endOfWeek()->addDay()->format('d');
                                    }
                                    if ($firstDate->endOfWeek()->format('m') != $secondDate->format('m')){
                                        $end = $secondDate->endOfMonth()->format('d');
                                    }else{
                                        $end = $firstDate->endOfWeek()->format('d');
                                    }
                                @endphp
                                <td>
                                    @php
                                        $startDate = $firstDate->format('Y').'-'.$secondDate->format('m').'-'.$start;
                                        $endDate = $firstDate->format('Y').'-'.$secondDate->format('m').'-'.$end;
                                        $total = App\Radiology::weeklyReport($startDate, $endDate);
                                    @endphp
                                    {{ $total[0]->total }}
                                </td>
                                @if($firstDate->endOfWeek()->format('m') != $secondDate->format('m'))
                                    @php break; @endphp
                                @endif
                            @endfor

                        </tr>



                        <tr>
                            <td colspan="2">
                                2. Total number of Out-Patients provided with Diagnostic <br>
                                Services from Presentation of Request to Release
                            </td>

                            @php
                                $firstDate = Carbon::parse($dateTime);
                                $secondDate = Carbon::parse($dateTime);
                            @endphp
                            @for($i=1;$i<7;$i++)
                                @php
                                    if($i == 1){
                                        $start = '01';
                                    }else{
                                        $start = $firstDate->endOfWeek()->addDay()->format('d');
                                    }
                                    if ($firstDate->endOfWeek()->format('m') != $secondDate->format('m')){
                                        $end = $secondDate->endOfMonth()->format('d');
                                    }else{
                                        $end = $firstDate->endOfWeek()->format('d');
                                    }
                                @endphp
                                <td>
                                    @php
                                        $startDate = $firstDate->format('Y').'-'.$secondDate->format('m').'-'.$start;
                                        $endDate = $firstDate->format('Y').'-'.$secondDate->format('m').'-'.$end;
                                        $total = App\Radiology::withResult($startDate, $endDate);
                                    @endphp
                                    {{ $total[0]->total }}
                                </td>
                                @if($firstDate->endOfWeek()->format('m') != $secondDate->format('m'))
                                    @php break; @endphp
                                @endif
                            @endfor

                        </tr>
                        </tbody>
                    </table>
                </div>



            @else

                <hr>

                <h4 class="text-danger text-center">
                    Please select a date to be retrieve <i class="fa fa-calendar"></i>
                </h4>

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
    <script src="{{ asset('public/js/radiology/reports/reports.js') }}"></script>


    @if($dateTime)
        <script>
            $('#monthTD').attr('colspan',{{ $endloop }});
        </script>
    @endif



@stop


@endcomponent
