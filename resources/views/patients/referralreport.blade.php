@component('partials/header')

    @slot('title')
        PIS | Census
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/plugins/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/plugins/css/jquery-ui.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('public/css/patients/reports.css') }}" />
@stop



@section('header')
    @include('patients/navigation')
@stop



@section('content')
    <div class="container">
        <form class="form-inline text-right" method="GET">
        	<br>
            <div class="form-group">
            	<label>STARTING MONTH </label>
            	&nbsp;&nbsp;
            	
            	<select name="starting_month" class="form-control starting_month">
            		@foreach($month as $list)
            		<option value="{{ $list->months }}">{{ Carbon::parse($list->created_at)->format('F') }}</option>
            		@endforeach
            	</select>
            </div>
            &nbsp;&nbsp;&nbsp;&nbsp;<span class="fa fa-arrow-right"></span>
            <div class="form-group">
            	<label>ENDING MONTH </label>
            	&nbsp;&nbsp;
            	
            	<select name="ending_month" class="form-control ending_month">
            		@foreach($month as $list)
            		<option value="{{ $list->months }}">{{ Carbon::parse($list->created_at)->format('F') }}</option>
            		@endforeach
            	</select>
            </div>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <div class="form-group">
            	<label>YEAR</label>
            	&nbsp;&nbsp;
            	
            	<select name="years" class="form-control">
            		@foreach($year as $list)
            		<option value="{{ $list->years }}">{{ Carbon::parse($list->created_at)->format('Y') }}</option>
            		@endforeach
            	</select>
            </div>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <div class="form-group">
            	<button type="submit" class="btn btn-success"><span class="fa fa-cog"></span> GENERATE</button>
            </div>
        </form>
        <div class="col-md-12">
        	<br><br>
        	@if(isset($request->starting_month) && !$request->hospitalid)
        		@include('patients.census.censusbymonth')
        	@elseif(isset($request->month) && !isset($request->hospitalidbymonth))
        		@include('patients.census.censusbyday')
        	@elseif(isset($request->hospitalid))
        		@include('patients.census.censusbycase')
            @elseif(isset($request->hospitalidbymonth))
            @include('patients.census.censusbycaseday')
        	@endif
        </div>
        	

    </div>
@endsection
@section('pagescript')
    @include('message.toaster')
    <script src="{{ asset('public/plugins/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/plugins/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/plugins/js/jquery-ui.min.js') }}"></script>
    <!-- <script src="{{ asset('public/js/patients/register.js') }}"></script> -->
    <script>
        $(document).on('change', '.starting_month', function(){
        	var start = $(this).val();
        	$(".ending_month option").each(function(){
        		var end = $(this).val();
        		if (start > end) {
        			$(this).attr('disabled', true);
        		}
        		else{
        			$(this).attr('disabled', false);
        		}
        	})
        	// alert($(this).val());
        })
    </script>
@stop
@endcomponent
