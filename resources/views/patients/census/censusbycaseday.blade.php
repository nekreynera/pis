<div class="table-responsive" id="referralcensus">
	<table class="table table-bordered">
		<?php
			$date = '01'.'-'.$request->month.'-'.'2018';
			$numDays = Carbon::parse($date)->daysInMonth + 1;
			
		?>
		<tr>
			<th class="text-center" colspan="{{$numDays+1}}">EVRMC REFERRAL</th>
		</tr>
		<tr>
			<th class="text-center" style="padding: 2px;background-color: #e6e6e6" colspan="{{$numDays+1}}"><i>OUT PATIENT DEPARTMENT</i></th>
		</tr>
		<tr class="bg-success">
			<th colspan="1" rowspan="2" class="text-center">{{$request->hospital}}</th>
			<th rowspan="2">TOTAL</th>
			<th colspan="{{$numDays-1}}" class="text-center">{{ Carbon::parse($date)->format('F') }}</th>
		<tr class="bg-success">
			@for($i=1;$i < $numDays;$i++)
			<th class="text-center">{{ $i }}</th>
			@endfor
			
		</tr>
		
		@foreach($data as $list)
		<tr>
			<td>{{ $list->diagnosis }}</td>
			<td>{{ $list->results }}</td>
			@php
				$result = App\Regfacility::countpercaseday($list->diagid, $list->facility, $request->month, $request->years);
			@endphp
			@for($lo = 1; $lo <$numDays; $lo++)
				<td align="center">
					@foreach($result as $var) 
					@php
						$days = Carbon::parse($var->days)->day;
					@endphp
					@if($days == $lo) 
						{{ $var->results }}
					@endif
				@endforeach
				</td>
			@endfor 
		</tr>
		@endforeach
		
	</table>
</div>