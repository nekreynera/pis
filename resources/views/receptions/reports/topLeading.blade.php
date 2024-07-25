@component('partials/header')

    @slot('title')
        PIS | Top Leading Services
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


        <div class="container">



            @include('receptions.reports.topLeadingSearch')


            @if($starting && $ending)

                @php
                    $startMonth = Carbon::parse($start)->month;
                    $endMonth = Carbon::parse($end)->month;
                    $total = 0;
                    $monthTotal = array();
                @endphp

                @if(!empty($reports))


                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr class="bg-primary">
                                <th colspan="16" class="text-center">TOP LEADING SERVICES</th>
                            </tr>
                            <tr>
                                <th colspan="16" class="text-center">DIAGNOSTIC{{--{{ (Auth::user()->clinic == 22)? 'X-RAY' : 'UTZ' }}--}}</th>
                            </tr>
                            <tr>
                                <th rowspan="2">#</th>
                                <th rowspan="2" class="text-center">NAME OF CASES</th>
                                <th colspan="2" class="text-center">Number of Consultations</th>
                                <th colspan="12" class="text-center">Month</th>
                            </tr>
                            <tr>
                                <td>SubTotal</td>
                                <td>Total</td>
                                @for($i=1;$i<13;$i++)
                                    <td>
                                        {{ Carbon::parse("2018-$i-01")->format('F') }}
                                    </td>
                                @endfor
                            </tr>
                            </thead>


                            <tbody>

                            @if(!empty($reports))

                                @php
                                    for ($k=1;$k<13;$k++){
                                        $monthTotal['m'.$k] = 0;
                                    }
                                @endphp

                                @foreach($reports as $row)

                                    <tr>
                                        <td>
                                            {{ $loop->index + 1 }}
                                        </td>
                                        <td>
                                            {{ $row->sub_category }}
                                        </td>
                                        <td></td>
                                        <td>
                                            {{ $row->total }}
                                        </td>
                                        @for($i=1;$i<13;$i++)
                                            <td>
                                                @if($i >= $startMonth && $i <= $endMonth)
                                                    @php
                                                        $query = App\Ancillaryrequist::topLeading($row->id, Carbon::create(Carbon::parse($start)->year, $i)->format('Y-m'))
                                                    @endphp
                                                    {{ (empty($query))? '' : $query }}
                                                    @php
                                                        $monthTotal['m'.$i] += $query;
                                                    @endphp
                                                @endif
                                            </td>
                                        @endfor
                                    </tr>


                                    @php
                                        ($row->total)? $total+=$row->total : '';
                                    @endphp

                                @endforeach



                            @endif

                            </tbody>

                            <tfoot>
                                <tr>
                                    <td colspan="2">Total</td>
                                    <td></td>
                                    <td>{{ $total }}</td>
                                    @for($i=1;$i<13;$i++)
                                        <td>
                                            {{ $monthTotal['m'.$i] }}
                                        </td>
                                    @endfor
                                </tr>
                            </tfoot>

                        </table>
                    </div>


                @else

                    <h4 class="text-center text-danger">
                        Sorry! No Results Found.
                    </h4>

                @endif


            @else

                <h4 class="text-center text-danger">
                    Please select a date to be retrieve <i class="fa fa-warning"></i>
                </h4>

            @endif


            <hr>


        </div>

    </div>

@endsection



@section('footer')
@stop



@section('pagescript')


    @include('message.toaster')
    <script src="{{ asset('public/plugins/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('public/js/radiology/reports/reports.js') }}"></script>


@stop


@endcomponent
