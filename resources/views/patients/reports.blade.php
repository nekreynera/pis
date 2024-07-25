@component('partials/header')

    @slot('title')
        PIS | Census
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/plugins/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/plugins/css/jquery-ui.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/patients/reports.css') }}" rel="stylesheet" />
@stop



@section('header')
    @include('patients/navigation')
@stop



@section('content')
    <div class="container">
        <form class="form-horizontal generate-form" method="GET">
            <div class="row">
                <div class="col-md-7">
                    <div class="col-md-4" style="margin-right: 10px;">
                        <div class="form-group">
                            <label>TYPE</label>
                            <select class="form-control type" name="type" required>
                                <option value="" hidden>Select</option>
                                <option value="61" @if($request->type == "55") selected @endif>OUT PATIENT</option>   
                                <option value="54" @if($request->type == "54") selected @endif>IN PATIENT</option>  
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4" style="margin-right: 10px;">
                           
                            <div class="form-group">
                                <label>USER &nbsp;&nbsp;&nbsp;</label>
                                <select class="form-control user" name="user" required>
                                   
                                    
                                </select>
                            </div>
                    </div>
                    <div class="col-md-3" style="margin-right: 10px;">
                        <div class="form-group">
                            <label>GROUP BY</label>
                            <select class="form-control" name="group">
                                <option value="DATE" @if($request->group == "DATE") selected @endif)>DAILY</option>
                                <option value="MONTH" @if($request->group == "MONTH") selected @endif)>MONTHLY</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-7">
                    <div class="col-md-4" style="margin-right: 10px;">
                        <div class="form-group">
                            <label>STARTING DATE</label>
                            <input type="date" name="from" class="form-control" value="@if($request->from){{$request->from}}@else{{Carbon::now()->setTime(0,0)->format('Y-m-d')}}@endif" required>
                        </div>
                    </div>
                    <div class="col-md-4" style="margin-right: 10px;">
                        <div class="form-group">
                            <label>ENDING DATE</label>
                            <input type="date" name="to" class="form-control" value="@if($request->to){{$request->to}}@else{{Carbon::now()->setTime(0,0)->format('Y-m-d')}}@endif" required>
                        </div>
                    </div>
                    <div class="col-md-3" style="margin-right: 10px;">
                        <div class="form-group">
                            <label>&nbsp;</label><br>
                            <button type="submit" class="btn btn-success"><span class="fa fa-cog"></span> Submit</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    @php
                        if($request->type == 55):
                            $type = 'IN PATIENT';
                        else:
                            $type = 'OUT PATIENT';
                        endif;
                    @endphp
                    @if(isset($request->type))
                    <br>
                    <label class="label label-warning census-warning"><span class="fa fa-info-circle"></span> Census of {{ $type }}, Date Between {{ Carbon::parse($request->from)->format('F d, Y') }} to {{ Carbon::parse($request->to)->format('F d, Y') }}</label>
                    @endif
                </div>
            </div>
        </form>
        <br>
        <div class="table-responsive" id="referralcontainer">
            <table class="table table-striped" id="reportsTable">
                <thead class="success">
                    <tr style="background-color: #ccc">
                        <th hidden></th>
                        <th class="text-center">
                            @if($request->group)
                                {{ $request->group }}
                            @else
                                {{ "DATE" }}
                            @endif
                        </th>
                        <th class="text-center">NUMBER</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i=0;
                    @endphp
                    @foreach($data as $list)
                    <tr>
                        <td hidden></td>
                        <td align="center">
                            @if($request->group == "DATE")
                            {{ Carbon::parse($list->date)->format('m/d/Y') }}
                            @elseif($request->group == "MONTH")
                            {{ Carbon::parse($list->date)->format('F 0f Y') }}
                            @endif
                        </td>
                        <td align="center">{{ $list->result }}</td>
                        @php
                        $i+=$list->result;
                        @endphp
                    </tr>

                    @endforeach
                </tbody>
            </table>
            <table class="table table-bordered">
                 <tr>
                    <th class="text-center">TOTAL</th>
                    <th class="text-center">{{ $i }}</th>
                </tr>
            </table>
        </div>
    </div>
@endsection
@section('pagescript')
    @include('message.toaster')
    <script src="{{ asset('public/plugins/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/plugins/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/plugins/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('public/js/patients/reports.js') }}"></script>
@stop
@endcomponent
