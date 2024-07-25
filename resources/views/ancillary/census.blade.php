@component('partials/header')

    @slot('title')
        PIS | ANCILLARY
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/css/ancillary/census.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/plugins/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />
@endsection



@section('header')
    @include('receptions/navigation')
@stop



@section('content')


            <div class="container">
                <div class="col-md-12">
                    <br>
                    <form class="form-inline text-right" method="GET">
                        <div class="form-group">
                            <label>FILTER </label>
                            <select class="form-control" name="top" required>
                                <option value="" hidden>CHOOSE</option>
                                @if(isset($_GET['top']))
                                <option value="10"  @if($_GET['top'] == '10') selected @endif>TOP 10</option>
                                <option value="20"  @if($_GET['top'] == '20') selected @endif>TOP 20</option>
                                <option value="30"  @if($_GET['top'] == '30') selected @endif>TOP 30</option>
                                <option value="ALL" @if($_GET['top'] == 'ALL') selected @endif>ALL</option>
                                @else
                                <option value="10">TOP 10</option>
                                <option value="20">TOP 20</option>
                                <option value="30">TOP 30</option>
                                <option value="ALL">ALL</option>
                                @endif
                            </select>
                        </div>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <div class="form-group">
                            <label>FROM </label>
                            <div class="input-group">
                                <input type="date" name="from" class="form-control" @if(isset($_GET['to'])) value="{{  $_GET['from'] }}" @endif required>
                                <span class="input-group-addon fa fa-calendar"></span>
                            </div>
                        </div>
                         &nbsp;&nbsp;&nbsp;&nbsp;<span class="fa fa-arrow-right"></span> &nbsp;&nbsp;&nbsp;&nbsp;
                        <div class="form-group">
                            <label>TO </label>
                            <div class="input-group">
                                <input type="date" name="to" class="form-control" @if(isset($_GET['to'])) value="{{  $_GET['to']  }}" @endif required>
                                <span class="input-group-addon fa fa-calendar"></span>
                            </div>
                        </div>
                         &nbsp;&nbsp;&nbsp;&nbsp;
                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-sm"> SUBMIT <span class="fa fa-cog"></span></button>
                        </div>
                    </form>
                </div>
                <div class="col-md-12">
                    <br><br>
                    @if (isset($_GET['from']))
                    <label>TOTAL NUMBER OF PATIENT PER SERVICES - DATE: {{  Carbon::parse($_GET['from'])->format('M-d-Y').' to '.Carbon::parse($_GET['to'])->format('M-d-Y') }}</label>
                     @endif
                </div>
                <div class="col-md-12">
                    <div class="table-responsive" id="rankindiv">
                        <table class="table table-bordered table-stripped">
                            <thead>
                                
                                <tr>
                                    <th>RANKING</th>
                                    <th>PARTICULAR</th>
                                    <th>FEMALE</th>
                                    <th>MALE</th>
                                    <th>TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $l = 1;
                                $total = 0;
                                $female = 0;
                                $male = 0;
                                @endphp

                                @if(count($census) > 0)
                                @foreach($census as $list)
                                <tr>
                                    <td align="center">{{ $l }}</td>
                                    <td>{{ $list->sub_category }}</td>
                                    <td align="center" class="">{{ $list->female }}</td>
                                    <td align="center" class="">{{ $list->male }}</td>
                                    <td align="center" class="">@if(Auth::user()->clinic == "3") {{ $list->person }} @else {{ $list->result }} @endif</td>

                                </tr>

                                @php

                                $l++;

                                $female += $list->female;
                                $male += $list->male;

                                if(Auth::user()->clinic == "3"):
                                $total += $list->person;
                                else:
                                $total += $list->result;
                                endif;
                                
                                @endphp

                                @endforeach

                                @php
                                $m = 0; 
                                $f = 0; 
                                @endphp

                                @if(Auth::user()->clinic == "3")
                                    @foreach($consultation as $list)
                                            @if($list->sex == "M")
                                                @php
                                                    $m++
                                                @endphp
                                            @endif
                                            @if($list->sex == "F")
                                                @php
                                                    $f++
                                                @endphp
                                            @endif
                                    @endforeach
                                    <tr>
                                        <td colspan="5" class=""></td>
                                       
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="success text-right"><b>TOTAL SERVICES:</b></td>
                                        <td align="center" class="success"><b>{{ $female }}</b></td>
                                        <td align="center" class="success"><b>{{ $male }}</b></td>
                                        <td align="center" class="success"><b>{{ $total }}</b></td>
                                    </tr>
                                     <tr>
                                        <td colspan="5" class=""></td>
                                      
                                    </tr>
                                     <tr>
                                        <td colspan="2" class="success text-right">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<b>TOTAL CONSULTATION:</b></td>
                                        <td align="center" class="success"><b>{{ $f - $female  }}</b></td>
                                        <td align="center" class="success"><b>{{ $m - $male}}</b></td>
                                        <td align="center" class="success"><b>{{ count($consultation) - $total }}</b></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class=""></td>
                                      
                                    </tr>
                                    <tr>
                                        <th colspan="2" style="text-align: right;">GRAND TOTAL:</th>
                                        <th>{{ $female + ($f - $female) }}</th>
                                        <th>{{ $male + ($m - $male) }}</th>
                                        <th>{{ count($consultation) }}</th>
                                    </tr>
                                @else
                                    <tr>
                                        <th colspan="2" style="text-align: right;">GRAND TOTAL:</th>
                                        <th colspan="">{{ $female }}</th>
                                        <th colspan="">{{ $male }}</th>
                                        <th colspan="">{{  $total }}</th>
                                    </tr>
                                @endif
                                @else
                                    <tr>
                                        <td colspan="5" class="default" align="center" >NO RESULT FOUND</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                </div>
            </div> 
            <!-- .content-wrapper -->

        @endsection


@section('footer')
@stop



@section('pagescript')
    @include('message.toaster')
    
    <script src="{{ asset('public/plugins/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/plugins/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/js/ancillary/list.js') }}"></script>
@stop


@endcomponent
