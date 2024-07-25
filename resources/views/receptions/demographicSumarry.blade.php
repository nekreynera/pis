@component('partials/header')

    @slot('title')
        PIS | Demographic Summary
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/css/receptions/demographic.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/plugins/css/jquery-ui.css') }}" rel="stylesheet" />
@stop


@section('header')
    @include('receptions.navigation')
@stop



@section('content')


    <div class="container-fluid">
        <div class="demographic col-md-12">


            <br>

            <div class="row">
                <div class="col-md-3">
                    <h3 style="margin: 5px 0 0 0 ">{{ $clinic->name }}</h3>
                </div>
                <div class="col-md-9">
                    <form action="{{ url('demographicSummary') }}" method="post" class="form-inline" style="display: inline">
                        {{ csrf_field() }}
                        <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            <input type="text" required name="starting" class="form-control datepicker" required placeholder="Starting date">
                        </div>
                        <div class="form-group" style="margin: 0 10px 0 10px">
                            <i class="fa fa-arrow-right"></i>
                        </div>
                        <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            <input type="text" required name="ending" class="form-control datepicker" required placeholder="Ending date">
                        </div>
                        <div class="form-group" style="margin-left:15px">
                            <button class="btn btn-success" type="submit">Submit</button>
                        </div>
                    </form>
                </div>

            </div>

            <br>


            <div class="row">

            @if($final)

            <div class="col-md-4">

            <div class="table-responsive demographicSummary">
                <table class="table table-bordered">
                    <thead>
                        <th>CITY/MUNICIPALITY</th>
                        <th>NEW</th>
                        <th>OLD</th>
                    </thead>
                    <tbody>

                    

                    <tr class="leyte">
                        <td colspan="3" class="text-center"><strong>LEYTE</strong></td>
                    </tr>
                    <tr class="leyte">
                        <td>TACLOBAN</td>
                        <td>{{ $final['TN'] }}</td>
                        <td>{{ $final['TO'] }}</td>
                    </tr>
                    @for($i=1;$i<6;$i++)
                        @php
                            if($i == 1){
                                $dis = '1st';
                            }elseif($i == 2){
                                $dis = '2nd';
                            }elseif($i == 3){
                                $dis = '3rd';
                            }elseif($i == 4){
                                $dis = '4th';
                            }else{
                                $dis = '5th';
                            }
                        @endphp
                        <tr class="leyte">
                            <td>{{ $dis }}</td>
                            <td>{{ $final['LN'.$i] }}</td>
                            <td>{{ $final['LO'.$i] }}</td>
                        </tr>
                    @endfor
                    <tr class="wsamar">
                        <td colspan="3" class="text-center"><strong>W-SAMAR</strong></td>
                    </tr>
                    @for($i=1;$i<3;$i++)
                        @php
                            if($i == 1){
                                $dis = '1st';
                            }elseif($i == 2){
                                $dis = '2nd';
                            }
                        @endphp
                        <tr class="wsamar">
                            <td>{{ $dis }}</td>
                            <td>{{ $final['WSN'.$i] }}</td>
                            <td>{{ $final['WSO'.$i] }}</td>
                        </tr>
                    @endfor
                    <tr class="esamar">
                        <td colspan="3" class="text-center"><strong>E-SAMAR</strong></td>
                    </tr>
                    @for($i=1;$i<3;$i++)
                        @php
                            if($i == 1){
                                $dis = '1st';
                            }elseif($i == 2){
                                $dis = '2nd';
                            }
                        @endphp
                        <tr class="esamar">
                            <td>{{ $dis }}</td>
                            <td>{{ $final['ESN'.$i] }}</td>
                            <td>{{ $final['ESO'.$i] }}</td>
                        </tr>
                    @endfor
                    <tr class="nsamar">
                        <td colspan="3" class="text-center"><strong>N-SAMAR</strong></td>
                    </tr>
                    @for($i=1;$i<3;$i++)
                        @php
                            if($i == 1){
                                $dis = '1st';
                            }elseif($i == 2){
                                $dis = '2nd';
                            }
                        @endphp
                        <tr class="nsamar">
                            <td>{{ $dis }}</td>
                            <td>{{ $final['NSN'.$i] }}</td>
                            <td>{{ $final['NSO'.$i] }}</td>
                        </tr>
                    @endfor
                    <tr class="sleyte">
                        <td colspan="3" class="text-center"><strong>S-LEYTE</strong></td>
                    </tr>
                    @for($i=1;$i<3;$i++)
                        @php
                            if($i == 1){
                                $dis = '1st';
                            }elseif($i == 2){
                                $dis = '2nd';
                            }
                        @endphp
                        <tr class="sleyte">
                            <td>{{ $dis }}</td>
                            <td>{{ $final['SLN'.$i] }}</td>
                            <td>{{ $final['SLO'.$i] }}</td>
                        </tr>
                    @endfor
                    <tr class="biliran">
                        <td colspan="3" class="text-center"><strong>BILIRAN</strong></td>
                    </tr>
                    @for($i=1;$i<3;$i++)
                        @php
                            if($i == 1){
                                $dis = '1st';
                            }elseif($i == 2){
                                $dis = '2nd';
                            }
                        @endphp
                        <tr class="biliran">
                            <td>{{ $dis }}</td>
                            <td>{{ $final['BN'.$i] }}</td>
                            <td>{{ $final['BO'.$i] }}</td>
                        </tr>
                    @endfor
                    <tr class="totalSum">
                        <td>TOTAL</td>
                        <td>{{ $new }}</td>
                        <td>{{ $old }}</td>
                    </tr>
                    <tr class="totalSum">
                        <td>GRAND TOTAL</td>
                        <td colspan="2" class="text-center">{{ $new + $old }}</td>
                    </tr>

                    
                    </tbody>
                </table>
            </div>

            </div>


                    @else
                        <hr>
                        @if(!$starting)
                            <h4 class="text-center text-danger">Please select a date to be retrieve. <i class="fa fa-calendar"></i></h4>
                        @else
                            <h4 class="text-center text-danger">No results found <i class="fa fa-exclamation"></i></h4>
                        @endif
                        <hr>
                    @endif


            @if($final)
            <div class="col-md-4">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <th></th>
                            <th>NEW</th>
                            <th>OLD</th>
                            <th>TOTAL</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>SENIOR CITIZEN</td>
                                <td>{{ $csn }}</td>
                                <td>{{ $cso }}</td>
                                <td><strong class="text-danger">{{ $csn + $cso }}</strong></td>
                            </tr>
                            <tr>
                                <td>GERIA</td>
                                <td>{{ $geriaN }}</td>
                                <td>{{ $geriaO }}</td>
                                <td><strong class="text-danger">{{ $geriaN + $geriaO }}</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            </div>

        </div>
    </div>

@endsection



@section('footer')
@stop



@section('pagescript')
    @include('message.toaster')
    <script src="{{ asset('public/plugins/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('public/plugins/js/jquery-ui.min.js') }}"></script>
    <script>
        $( function() {
            $( ".datepicker" ).datepicker({
                dateFormat: 'yy-mm-dd'
            });
        });
    </script>
    {{--<script>
        $(document).ready(function() {
            $('#patientsTable').dataTable();
        });
    </script>--}}
@stop


@endcomponent