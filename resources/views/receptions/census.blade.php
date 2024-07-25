@component('partials/header')

    @slot('title')
        PIS | Census
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/plugins/css/jquery-ui.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/plugins/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/receptions/census.css') }}" rel="stylesheet" />
@stop


@section('header')
    @include('receptions.navigation')
@stop



@section('content')


    <div class="container-fluid">
        <br>
        <div>
            <div class="row">
                <div class="col-md-3">
                    <h3 style="margin: 0">{{ $clinic->name }}</h3>
                </div>
                <div class="col-md-9 text-right">
                    <form action="{{ url('receptionCensus') }}" class="form-inline" method="post">
                        {{ csrf_field() }}


                        <div class="form-group @if ($errors->has('startingDate')) has-error @endif">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-filter"></i>
                                </span>
                                <select name="filter" id="" class="form-control">
                                    <option value="5000" {{ ($limit == 5000)? 'selected' : '' }}>Show All</option>
                                    <option value="10" {{ ($limit == 10)? 'selected' : '' }}>Top 10 Diseases</option>
                                    <option value="20" {{ ($limit == 20)? 'selected' : '' }}>Top 20 Diseases</option>
                                    <option value="50" {{ ($limit == 50)? 'selected' : '' }}>Top 50 Diseases</option>
                                </select>
                            </div>
                        </div>



                        {{--<div class="form-group">
                            <label for="">Filter By:</label>
                            <select name="filter" id="" class="form-control">
                                <option value="5000">Show All</option>
                                <option value="10">Top 10 Diseases</option>
                                <option value="20">Top 20 Diseases</option>
                                <option value="50">Top 50 Diseases</option>
                            </select>
                        </div>--}}

                        {{--<div class="form-group @if ($errors->has('startingDate')) has-error @endif" style="margin: 0 15px">


                            <div class="input-group">
                                <span class="input-group-addon" id="endingDate" onclick="document.getElementById('ending').focus()">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                <input type="text" name="startingDate" value="{{ $starting or '' }}"
                                       id="datepicker" placeholder="Enter Starting Date" class="form-control" />
                            </div>



                            @if ($errors->has('startingDate'))
                                <span class="help-block">
                                    <strong class="">{{ $errors->first('startingDate') }}</strong>
                                </span>
                            @endif

                        </div>--}}


                        &nbsp;



                        <div class="form-group @if ($errors->has('startingDate')) has-error @endif">
                            <div class="input-group">
                                <span class="input-group-addon" onclick="document.getElementById('starting').focus()">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                <input type="text" name="startingDate" value="{{ $starting or '' }}"
                                 id="starting" placeholder="Enter Starting Date" class="form-control datepicker" />
                            </div>
                            @if ($errors->has('startingDate'))
                                 <span class="help-block">
                                     <strong class="">{{ $errors->first('startingDate') }}</strong>
                                 </span>
                            @endif
                        </div>



                        {{--<i class="fa fa-arrow-right" style="margin: 0 20px"></i>--}}

                        {{--<div class="form-group @if ($errors->has('endingDate')) has-error @endif">
                            <label for="">Ending Date <i class="fa fa-calendar"></i> :</label>
                            <input type="text" id="endingDate" value="{{ old('endingDate') }}" name="endingDate" placeholder="Enter Ending Date" class="form-control" />
                            @if ($errors->has('endingDate'))
                                <span class="help-block">
                                    <strong class="">{{ $errors->first('endingDate') }}</strong>
                                </span>
                            @endif
                        </div>--}}


                        &nbsp;




                        <div class="form-group @if ($errors->has('endingDate')) has-error @endif">
                            <div class="input-group">
                                <span class="input-group-addon" onclick="document.getElementById('endingDate').focus()">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                <input type="text" id="endingDate" value="{{ $ending or ''}}" name="endingDate"
                                       placeholder="Enter Ending Date" class="form-control datepicker" />
                            </div>
                            @if ($errors->has('endingDate'))
                                <span class="help-block">
                                     <strong class="">{{ $errors->first('endingDate') }}</strong>
                                 </span>
                            @endif
                        </div>



                        &nbsp;




                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>



                    </form>
                </div>
            </div>
            <br>
        </div>




        @if($starting)

        @if(count($census) > 0)

        <div class="table-responsive">
            <table class="table table-bordered table-condensed" id="censusTable">
                <thead>
                    <tr>
                        <th colspan="3" rowspan="4" class="text-center">NAME OF CASES</th>
                    </tr>
                    <tr>
                        <th colspan="35" class="text-center">AGE(Years Old) / Gender</th>
                    </tr>
                    <tr class="bg-warning">
                        <td colspan="2">Under1</td>
                        <td colspan="2">1-4</td>
                        <td colspan="2">5-9</td>
                        <td colspan="2">10-14</td>
                        <td colspan="2">15-19</td>
                        <td colspan="2">20-24</td>
                        <td colspan="2">25-29</td>
                        <td colspan="2">30-34</td>
                        <td colspan="2">35-39</td>
                        <td colspan="2">40-44</td>
                        <td colspan="2">45-49</td>
                        <td colspan="2">50-54</td>
                        <td colspan="2">55-59</td>
                        <td colspan="2">60-64</td>
                        <td colspan="2">65-69</td>
                        <td colspan="2">Above70</td>
                        <td colspan="2">TOTAL BY GENDER</td>
                        <td colspan="2" rowspan="4" class="bg-info">TOTAL</td>
                    </tr>
                    <tr class="bg-primary">
                        @for($i=0;$i<17;$i++)
                            <td>M</td>
                            <td>F</td>
                        @endfor
                    </tr>
                </thead>
                <tbody>

                    @php
                        $male = 0;
                        $female = 0;
                        $ageTotal = array();
                        $maleTotal = array();
                        $femaleTotal = array();
                        $grandTotal = 0;
                    @endphp
                    @foreach($census as $row)
                        @php
                            //$code = substr($row->code,0,strrpos($row->code, '.'));
                            $checkCnsus = App\ConsultationsICD::getICD($starting, $ending, $row->icd, $row->code);
                            $ageArray = array();
                            $sexArray = array();
                        @endphp
                        @foreach($checkCnsus as $cen)
                            @php
                                $age = App\Patient::censusage($cen->birthday);
                                $sex = ($cen->sex == null)? 'M' : $cen->sex;
                                if ($age < 1){
                                    $class = 1;
                                    $pushAge = (array_key_exists('age1', $ageTotal))? $ageTotal['age1']++ : array_push($ageTotal, $ageTotal['age1'] = 1);
                                }elseif ($age >= 1 && $age <= 4){
                                    $class = 2;
                                    $pushAge = (array_key_exists('age2', $ageTotal))? $ageTotal['age2']++ : array_push($ageTotal, $ageTotal['age2'] = 1);
                                }elseif ($age >= 5 && $age <= 9){
                                    $class = 3;
                                    $pushAge = (array_key_exists('age3', $ageTotal))? $ageTotal['age3']++ : array_push($ageTotal, $ageTotal['age3'] = 1);
                                }elseif ($age >= 10 && $age <= 14){
                                    $class = 4;
                                    $pushAge = (array_key_exists('age4', $ageTotal))? $ageTotal['age4']++ : array_push($ageTotal, $ageTotal['age4'] = 1);
                                }elseif ($age >= 15 && $age <= 19){
                                    $class = 5;
                                    $pushAge = (array_key_exists('age5', $ageTotal))? $ageTotal['age5']++ : array_push($ageTotal, $ageTotal['age5'] = 1);
                                }elseif ($age >= 20 && $age <= 24){
                                    $class = 6;
                                    $pushAge = (array_key_exists('age6', $ageTotal))? $ageTotal['age6']++ : array_push($ageTotal, $ageTotal['age6'] = 1);
                                }elseif ($age >= 25 && $age <= 29){
                                    $class = 7;
                                    $pushAge = (array_key_exists('age7', $ageTotal))? $ageTotal['age7']++ : array_push($ageTotal, $ageTotal['age7'] = 1);
                                }elseif ($age >= 30 && $age <= 34){
                                    $class = 8;
                                    $pushAge = (array_key_exists('age8', $ageTotal))? $ageTotal['age8']++ : array_push($ageTotal, $ageTotal['age8'] = 1);
                                }elseif ($age >= 35 && $age <= 39){
                                    $class = 9;
                                    $pushAge = (array_key_exists('age9', $ageTotal))? $ageTotal['age9']++ : array_push($ageTotal, $ageTotal['age9'] = 1);
                                }elseif ($age >= 40 && $age <= 44){
                                    $class = 10;
                                    $pushAge = (array_key_exists('age10', $ageTotal))? $ageTotal['age10']++ : array_push($ageTotal, $ageTotal['age10'] = 1);
                                }elseif ($age >= 45 && $age <= 49){
                                    $class = 11;
                                    $pushAge = (array_key_exists('age11', $ageTotal))? $ageTotal['age11']++ : array_push($ageTotal, $ageTotal['age11'] = 1);
                                }elseif ($age >= 50 && $age <= 54){
                                    $class = 12;
                                    $pushAge = (array_key_exists('age12', $ageTotal))? $ageTotal['age12']++ : array_push($ageTotal, $ageTotal['age12'] = 1);
                                }elseif ($age >= 55 && $age <= 59){
                                    $class = 13;
                                    $pushAge = (array_key_exists('age13', $ageTotal))? $ageTotal['age13']++ : array_push($ageTotal, $ageTotal['age13'] = 1);
                                }elseif ($age >= 60 && $age <= 64){
                                    $class = 14;
                                    $pushAge = (array_key_exists('age14', $ageTotal))? $ageTotal['age14']++ : array_push($ageTotal, $ageTotal['age14'] = 1);
                                }elseif ($age >= 65 && $age <= 69){
                                    $class = 15;
                                    $pushAge = (array_key_exists('age15', $ageTotal))? $ageTotal['age15']++ : array_push($ageTotal, $ageTotal['age15'] = 1);
                                }else{
                                    $class = 16;
                                    $pushAge = (array_key_exists('age16', $ageTotal))? $ageTotal['age16']++ : array_push($ageTotal, $ageTotal['age16'] = 1);
                                }
                            array_push($ageArray, $class.$sex);
                            $male = 0;
                            $female = 0;
                            @endphp
                        @endforeach

                        <tr>
                            <td class="bg-default">{{ $loop->index+1 }}</td>
                            <td>{{ $row->code }}</td>
                            <td>{{ $row->description }}</td>

                            @for($i=1;$i<18;$i++)

                                    <td>
                                        @if(in_array($i.'M', $ageArray))
                                            @php
                                                $censusNum = array_count_values($ageArray);
                                                $male += $censusNum[$i.'M'];
                                                (array_key_exists('m'.$i, $maleTotal))? $maleTotal['m'.$i] = $maleTotal['m'.$i] + $censusNum[$i.'M'] : $maleTotal['m'.$i] = $censusNum[$i.'M'];
                                            @endphp
                                            {{ $censusNum[$i.'M'] }}
                                        @endif
                                        @if($i == 17)
                                          
                                                {{ $male }}
                                          
                                        @endif
                                    </td>
                                    <td>
                                        @if(in_array($i.'F', $ageArray))
                                            @php
                                                $censusNum = array_count_values($ageArray);
                                                $female += $censusNum[$i.'F'];
                                                (array_key_exists('f'.$i, $femaleTotal))? $femaleTotal['f'.$i] = $femaleTotal['f'.$i] + $censusNum[$i.'F'] : $femaleTotal['f'.$i] = $censusNum[$i.'F'];
                                            @endphp
                                            {{ $censusNum[$i.'F'] }}
                                        @endif
                                        @if($i == 17)
                                        
                                            {{ $female }}
                                         
                                           
                                        @endif
                                    </td>
                                @if($i == 17)
                                    @php
                                        $grandTotal += $male + $female;
                                    @endphp
                                    <td>{{ $male + $female }}</td>
                                @endif
                            @endfor
                        </tr>
                        @if($loop->index == count($census) - 1)
                            <tr>
                                <td colspan="3">TOTAL BY SEX</td>
                                @for($x=1;$x<18;$x++)
                                    @if($x < 17)
                                        <td>{{ (array_key_exists('m'.$x, $maleTotal))? $maleTotal['m'.$x] : 0 }}</td>
                                        <td>{{ (array_key_exists('f'.$x, $femaleTotal))? $femaleTotal['f'.$x] : 0 }}</td>
                                    @endif
                                    @if($x == 17)
                                        <td colspan="3" rowspan="2" class="text-center bg-info">
                                            <strong>{{ $grandTotal }}</strong>
                                        </td>
                                    @endif
                                @endfor
                            </tr>
                            <tr>
                                <td colspan="3">TOTAL BY AGE</td>
                                @for($t=1;$t<17;$t++)
                                    <td colspan="2">
                                        {{ (array_key_exists('age'.$t, $ageTotal))? $ageTotal['age'.$t] : 0 }}
                                    </td>
                                @endfor
                            </tr>
                        @endif
                    @endforeach

                </tbody>
            </table>
        </div>



        @else
            <hr>
                <h4 class="text-danger text-center">
                    No Results Found
                </h4>
            <hr>
        @endif


        @else
            <hr>
                <h4 class="text-danger text-center">
                    Please select a date to be retreive <i class="fa fa-calendar"></i>
                </h4>
            <hr>
        @endif




    </div>

@endsection



@section('footer')
@stop



@section('pagescript')
    @include('message.toaster')
    <script src="{{ asset('public/plugins/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/plugins/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/plugins/js/jquery-ui.min.js') }}"></script>
    {{--<script src="{{ asset('public/js/patients/register.js') }}"></script>--}}
    {{--<script>
        $(document).ready(function() {
            $('#patientsTable').dataTable();
        });
    </script>--}}

    <script>
        $(document).ready(function () {
            $( ".datepicker" ).datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                yearRange: "-110:+0",
            });
        });
    </script>
@stop


@endcomponent