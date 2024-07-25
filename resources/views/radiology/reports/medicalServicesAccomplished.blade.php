@component('partials/header')

    @slot('title')
        PIS | Medical Services Accomplished
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



            @include('radiology.reports.searchform')


            @if($starting && $ending)


                @if(!empty($reports))


                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr class="bg-primary">
                                <th colspan="15" class="text-center">MEDICAL SERVICES ACCOMPLISHED</th>
                            </tr>
                            <tr>
                                <th colspan="15" class="text-center">DIAGNOSTIC{{-- - {{ (Auth::user()->clinic == 22)? 'X-RAY' : 'UTZ' }}--}}</th>
                            </tr>
                            <tr>
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
                                    $duplicateCategory = false;
                                    $counter = 1;
                                    $noResult= false;
                                    $monthTotal = array();
                                    $totalPerRow = array();
                                    $sumPerRow = false;
                                    for ($k=1;$k<13;$k++){
                                        $monthTotal['m'.$k] = 0;
                                    }
                                @endphp

                                @foreach($reports as $row)


                                    @if($sumPerRow == $row->cid)
                                        @php
                                            $totalPerRow['t'.$row->cid] += $row->total;
                                        @endphp
                                    @else
                                        @php
                                            $totalPerRow['t'.$row->cid] = $row->total;
                                        @endphp
                                    @endif
                                    @php
                                        $sumPerRow = $row->cid;
                                    @endphp


                                    @if($duplicateCategory && $duplicateCategory != $row->cid && $noResult)
                                        @for($j=$counter;$j<13;$j++)
                                            <td></td>
                                        @endfor
                                    @endif



                                    @if($duplicateCategory != $row->cid)
                                        @php $counter = 1 @endphp
                                    @endif




                                    @if($duplicateCategory != $row->cid)
                                        <tr>
                                            @endif

                                            @if($duplicateCategory != $row->cid)
                                                <td class="{{ $row->cid }}">
                                                    {{ $row->sub_category }}
                                                </td>
                                                <td></td>
                                                <td class="{{ 't'.$row->cid}}"></td>
                                            @endif


                                            @for($j=$counter;$j<13;$j++)
                                                <td>
                                                    @if($row->month == $j)
                                                        {{ $row->total }}
                                                        @php
                                                            $counter = $j + 1; $noResult = true;
                                                            $monthTotal['m'.$j] += $row->total;
                                                        @endphp
                                                        @break
                                                    @else
                                                        @php
                                                            $noResult = false;
                                                        @endphp
                                                    @endif
                                                </td>
                                            @endfor


                                            @php
                                                $duplicateCategory = $row->cid;
                                            @endphp




                                            @if($duplicateCategory != $row->cid)
                                        </tr>
                                    @endif



                                @endforeach



                                <tr>
                                    <td class="bg-primary">
                                        {{ ($category == 'N')? 'NEW' : 'OLD' }} PATIENTS
                                    </td>
                                    <td></td>
                                    <td>{{ array_sum($totalPerRow) }}</td>
                                    @for($i=1;$i<13;$i++)
                                        <td>
                                            {{ $monthTotal['m'.$i] }}
                                        </td>
                                    @endfor
                                </tr>

                            @endif

                            </tbody>
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


    @if(!empty($reports))


        @php
            $arrayKeys = array_keys($totalPerRow);
        @endphp


        @foreach($arrayKeys as $row)
            <script>
                $(document).ready(function () {
                    $('{{ ".$row" }}').text({{ $totalPerRow[$row] }})
                })
            </script>
        @endforeach


    @endif




    @include('message.toaster')
    <script src="{{ asset('public/plugins/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('public/js/radiology/reports/reports.js') }}"></script>


@stop


@endcomponent
