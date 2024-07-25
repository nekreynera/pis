@component('partials/header')

    @slot('title')
        PIS | Demographic
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
        <div class="demographic">


            <br>

            <div class="row">
                <div class="col-md-3">
                    <h3 style="margin: 5px 0 0 0 ">{{ $clinic->name }}</h3>
                </div>
                <div class="col-md-9">
                    <form action="{{ url('demographic') }}" method="post" class="form-inline" style="display: inline">
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
                            <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-filter"></i>
                                    </span>
                                <select name="category" id="" class="form-control">
                                    <option value="All">Show All</option>
                                    <option value="New">New Patient</option>
                                    <option value="Old">Old Patient</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" style="margin-left:15px">
                            <button class="btn btn-success" type="submit">Submit</button>
                        </div>
                    </form>
                </div>

            </div>

            <hr>

            @if($demographics)

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr class="">
                            <th></th>
                            <th>{{ $category }}</th>
                            <th>{{ Carbon::parse($starting)->toFormattedDateString().' - '.Carbon::parse($ending)->toFormattedDateString() }}</th>
                            <th></th>
                            <th></th>
                            <th colspan="6" class="leyte">LEYTE</th>
                            <th colspan="2" class="wsamar">W-SAMAR</th>
                            <th colspan="2" class="esamar">E-SAMAR</th>
                            <th colspan="2" class="nsamar">N-SAMAR</th>
                            <th colspan="2" class="sleyte">S-LEYTE</th>
                            <th colspan="2" class="biliran">BILIRAN</th>
                            <th>ADDRESS</th>
                            <th>SC</th>
                            <th>GERIA</th>
                        </tr>
                        <tr class="">
                            <th>#</th>
                            <th>HN</th>
                            <th>NAME</th>
                            <th>AGE</th>
                            <th>SEX</th>
                            <th class="leyte">TC</th>
                            <th class="leyte">1ST</th>
                            <th class="leyte">2ND</th>
                            <th class="leyte">3RD</th>
                            <th class="leyte">4TH</th>
                            <th class="leyte">5TH</th>
                            <th class="wsamar">1ST</th>
                            <th class="wsamar">2ND</th>
                            <th class="esamar">1ST</th>
                            <th class="esamar">2ND</th>
                            <th class="nsamar">1ST</th>
                            <th class="nsamar">2ND</th>
                            <th class="sleyte">1ST</th>
                            <th class="sleyte">2ND</th>
                            <th class="biliran">1ST</th>
                            <th class="biliran">2ND</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                    
                        @foreach($demographics as $demographic)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>
                                {{ ($demographic->total > 1)? 'OLD' : 'NEW' }}
                            </td>
                            <td>{{ $demographic->name }}</td>
                            <td>{{ App\Patient::age($demographic->birthday) }}</td>
                            <td>{{ $demographic->sex }}</td>
                            <td class="leyte">
                                @if($demographic->provCode == '0837' && $demographic->city_municipality == '083747')
                                    {{ 1 }}
                                @endif
                            </td>
                            @for($i=1;$i<6;$i++)
                                <td class="leyte">
                                    @if($demographic->provCode == '0837' && $demographic->district == $i && $demographic->city_municipality != '083747')
                                        {{ 1 }}
                                    @endif
                                </td>
                            @endfor
                            @for($i=1;$i<3;$i++)
                                <td class="wsamar">
                                    @if($demographic->provCode == '0860' && $demographic->district == $i)
                                        {{ 1 }}
                                    @endif
                                </td>
                            @endfor
                            @for($i=1;$i<3;$i++)
                                <td class="esamar">
                                    @if($demographic->provCode == '0826' && $demographic->district == $i)
                                        {{ 1 }}
                                    @endif
                                </td>
                            @endfor
                            @for($i=1;$i<3;$i++)
                                <td class="nsamar">
                                    @if($demographic->provCode == '0848' && $demographic->district == $i)
                                        {{ 1 }}
                                    @endif
                                </td>
                            @endfor
                            @for($i=1;$i<3;$i++)
                                <td class="sleyte">
                                    @if($demographic->provCode == '0864' && $demographic->district == $i)
                                        {{ 1 }}
                                    @endif
                                </td>
                            @endfor
                            @for($i=1;$i<3;$i++)
                                <td class="biliran">
                                    @if($demographic->provCode == '0878' && $demographic->district == $i)
                                        {{ 1 }}
                                    @endif
                                </td>
                            @endfor
                            <td>{{ $demographic->citymunDesc }}</td>
                            <td>{{ (App\Patient::age($demographic->birthday) >= 60 && App\Patient::age($demographic->birthday) < 69)? 1 : '' }}</td>
                            <td>{{ (App\Patient::age($demographic->birthday) >= 70)? 1 : '' }}</td>
                        </tr>
                        @endforeach
                    
                    </tbody>

                    <tfoot>
                    @if(count($demographics) > 0 && $starting)
                        <tr>
                            <td>
                                <h5><b class="text-danger">Total</b></h5>
                            </td>
                            <td colspan="23"><h5><b class="text-danger">{{ count($demographics) }}</b></h5></td>
                        </tr>
                    @endif
                    </tfoot>

                </table>
            </div>


            @else

                
                    @if($starting && count($demographics) <= 0)
                        <h4 class="text-center text-danger">No results found <i class="fa fa-exclamation"></i></h4>
                    @else
                        <h4 class="text-center text-danger">Please select a date to be retrieve. <i class="fa fa-calendar"></i></h4>
                    @endif

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
