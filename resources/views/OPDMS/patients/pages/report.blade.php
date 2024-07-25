@php 
  use App\Patient;
@endphp
@component('OPDMS.partials.header')


@slot('title')
    MEDICAL RECORDS
@endslot


@section('pagestyle')
    <link href="{{ asset('public/OPDMS/css/patients/main.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/OPDMS/css/patients/report.css') }}" rel="stylesheet" />
@endsection
    


@section('navigation')
    @include('OPDMS.partials.boilerplate.navigation')
@endsection


@section('dashboard')
    @component('OPDMS.partials.boilerplate.dashboard')
        {{--
            @section('search_form')
                @include('OPDMS.partials.boilerplate.search_form', ['redirector' => 'admin.search'])
            @endsection
        --}}
    @endcomponent
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" id="main-page">

        @include('OPDMS.partials.boilerplate.header',
        ['header' => 'Reports', 'sub' => ''])

        <!-- Main content -->
        <section class="content">

            <div class="box">
                <div class="box-header with-border">
                   
                    <!-- <label>NUMBER REGISTERED PATIENTS</label> -->
                </div>
                <div class="box-body">
                    @include('OPDMS.partials.loader')
                    <div class="report-header">
                        <form class="" method="GET">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row col-md-12">
                                        <div class="col-md-6" style="padding-right: 0px;">
                                            <select name="report" class="form-control generate-by">
                                                <option value="patients a" @if($request->report == 'patients a') selected @endif>NUMBER REGISTERED PATIENTS</option>
                                                <option value="printed a" @if($request->report == 'printed a') selected @endif>NUMBER PRINTED ID</option>
                                                <!-- <option value="3">NUMBER DISIGNATED PATIENT</option> -->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <br>
                                    </div>

                                    <div class="col-md-3 @if($errors->has('generate')) has-error @endif">
                                        <label>Generate By:</label>
                                        <select name="generate" class="form-control generate-by">
                                            <option value="DATE" @if($request->generate == 'DATE') selected @endif>Daily</option>
                                            <option value="MONTH" @if($request->generate == 'MONTH') selected @endif>Monthly</option>
                                        </select>
                                        @if ($errors->has('generate'))
                                            <span class="help-block">
                                                <strong class="">{{ $errors->first('generate') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-md-3 @if($errors->has('user')) has-error @endif">
                                        <label>User:</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                               <i class="fa fa-user"></i>
                                            </div> 
                                            <select name="user" class="form-control">
                                                <option value="All" @if($request->user == 'All') selected @endif>All</option>
                                                <option value="{{ Auth::user()->id }}">{{ ucwords(strtolower(Auth::user()->first_name)).' '.ucwords(strtolower(Auth::user()->middle_name)).' 
                                                    '.ucwords(strtolower(Auth::user()->last_name)) }}</option>
                                            </select>
                                        </div>
                                        
                                        @if ($errors->has('user'))
                                            <span class="help-block">
                                                <strong class="">{{ $errors->first('user') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-md-3 @if($errors->has('from')) has-error @endif">
                                        <label>From:</label>
                                        <div class="input-group div-from-day" @if($request->generate == 'MONTH') style="display: none!important;" @endif>
                                            <div class="input-group-addon">
                                               <i class="fa fa-calendar"></i>
                                            </div> 
                                            <input type="text" name="arr_from[]" value="@if($request->generate == 'DATE'){{ $request->from }}@else{{ Carbon::now()->format('m/d/Y') }}@endif" class="form-control from-day" id="datemask1" 
                                            data-inputmask="'alias': 'mm/dd/yyyy'" data-mask>
                                        </div>
                                        <div class="div-from-month"  
                                                @if($request->generate)
                                                    @if($request->generate == 'DATE') 
                                                        style="display: none!important;" 
                                                    @elseif($request->generate == 'MONTH') 
                                                        style="display: block!important;" 
                                                    @endif
                                                @else
                                                    style="display: none;"
                                                @endif>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                   <i class="fa fa-calendar"></i>
                                                </div> 
                                                <input type="text" name="arr_from[]" value="@if($request->generate == 'MONTH'){{ $request->from }}@endif" class="form-control from-month" id="from-month" 
                                                data-inputmask="'alias': 'mm/dd/yyyy'" data-mask>
                                            </div>
                                        </div>
                                        

                                        @if ($errors->has('from'))
                                            <span class="help-block">
                                                <strong class="">{{ $errors->first('from') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="col-md-3 @if($errors->has('to')) has-error @endif">
                                        <label>To:</label>
                                        
                                        <div class="input-group div-to-day" @if($request->generate == 'MONTH') style="display: none!important;" @endif>
                                            <div class="input-group-addon">
                                               <i class="fa fa-calendar"></i>
                                            </div> 
                                            <input type="text" name="arr_to[]" value="@if($request->generate == 'DATE'){{ $request->to }}@else{{ Carbon::now()->format('m/d/Y') }}@endif" class="form-control to-day" id="datemask2" 
                                            data-inputmask="'alias': 'mm/dd/yyyy'" data-mask>
                                        </div>

                                        <div class="div-to-month" 
                                                @if($request->generate)
                                                    @if($request->generate == 'DATE') 
                                                        style="display: none!important;" 
                                                    @elseif($request->generate == 'MONTH') 
                                                        style="display: block!important;" 
                                                    @endif
                                                @else
                                                    style="display: none;"
                                                @endif>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                       <i class="fa fa-calendar"></i>
                                                    </div> 
                                                    <input type="text" name="arr_to[]" value="@if($request->generate == 'MONTH'){{ $request->to }}@endif" class="form-control to-month" id="to-month" 
                                                    data-inputmask="'alias': 'mm/dd/yyyy'" data-mask>
                                                </div>
                                            
                                        </div>
                                        

                                        @if ($errors->has('to'))
                                            <span class="help-block">
                                                <strong class="">{{ $errors->first('to') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="col-md-12 text-right form-button">
                                        <button type="submit" class="btn btn-success btn-sm"><span class="fa fa-cog"></span> Generate</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="report-body">
                        <div class="row">
                            <div class="total-wrapper col-md-12">
                                <span class="col-md-6">@if($request->generate) {{ $request->generate }} @else {{ 'DATE' }} @endif</span>
                                <span class="col-md-6">RESULT</span>
                            </div>
                            <div class="col-md-12">
                               
                                <div class="table-responsive" style="max-height: 270px;">
                                    <table class="table table-hover table-striped">
                                        <tbody>
                                            @php
                                                $total = 0;
                                            @endphp
                                            @if(count($data) > 0)
                                            @foreach($data as $list)
                                                @php
                                                    $total+=$list->result;
                                                @endphp
                                            <tr>
                                                <td hidden></td>
                                                <td align="center" width="51%">
                                                    @if($request->generate == "DATE")
                                                    {{ Carbon::parse($list->date)->format('m/d/Y') }}
                                                    @else
                                                    {{ Carbon::parse($list->date)->format('F Y') }}
                                                    @endif
                                                </td>
                                                <td align="center" width="49%"><b>{{ $list->result }}</b></td>
                                            </tr>
                                            @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                
                            </div>
                            <div class="total-wrapper col-md-12">
                                <span class="col-md-6">TOTAL</span>
                                <span class="col-md-6">{{ $total }}</span>
                            </div>
                        </div>
                    </div>
                <div class="box-footer">
                    <small>
                        <em class="text-muted">
                            Page where you can generate number of registered patient by month or day
                        </em>
                    </small>
                </div>
            </div>

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection



{{--@section('footer')
    @include('OPDMS.partials.boilerplate.footer')
@endsection--}}

@section('aside')
    @include('OPDMS.partials.boilerplate.aside')
@endsection


@section('pluginscript')
    <script src="{{ asset('public/AdminLTE/plugins/input-mask/jquery.inputmask.js') }}"></script>
    <script src="{{ asset('public/AdminLTE/plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
    <script src="{{ asset('public/AdminLTE/plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
    
@endsection

@section('pagescript')
    <script>
        var dateToday = '{{ Carbon::today()->format("m/d/Y") }}';
    </script>
    <script src="{{ asset('public/OPDMS/js/patients/main.js') }}"></script>
    <script src="{{ asset('public/OPDMS/js/patients/report.js') }}"></script>
    <script src="{{ asset('public/OPDMS/js/patients/table.js') }}"></script>

@endsection


@endcomponent