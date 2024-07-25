<div class="col-md-12">
	<div class="table-responsive" id="dispensedmeds">
		<table class="table table-bordered">
			<tr>
				<th class="text-center" colspan="15">TOP 10 DISPENSED MEDICINES</th>
			</tr>
			<tr>
				<th class="text-center" style="padding: 2px;background-color: #e6e6e6" colspan="15"><i>PIS PHARMACY 2024</i></th>
			</tr>
			<tr class="bg-success">
				<th colspan="1" rowspan="2">GENERIC NAME</th>
				<th rowspan="2">TOTAL</th>
				<th colspan="12">Month</th>
			<tr class="bg-success">
				<th>January</th>
				<th>February</th>
				<th>March</th>
				<th>April</th>
				<th>May</th>
				<th>June</th>
				<th>July</th>
				<th>August</th>
				<th>September</th>
				<th>October</th>
				<th>November</th>
				<th>December</th>
			</tr>
			@php
				$result = App\Sales::dispensedmeds($request->month, $request->year);
				$i=1;
			@endphp
			@foreach($result as $list)
				<tr @if($i<=10) class="bg-info" @endif>
					<td>@if($i<=10)<span class="badge"> {{$i}} </span> @endif {{ $list->item_description }} ({{$list->unitofmeasure}})</td>
					<td align="center">{{ $list->result }}</td>
					<td align="center">@if($request->month=="1") {{$list->result}} @endif</td>
					<td align="center">@if($request->month=="2") {{$list->result}} @endif</td>
					<td align="center">@if($request->month=="3") {{$list->result}} @endif</td>
					<td align="center">@if($request->month=="4") {{$list->result}} @endif</td>
					<td align="center">@if($request->month=="5") {{$list->result}} @endif</td>
					<td align="center">@if($request->month=="6") {{$list->result}} @endif</td>
					<td align="center">@if($request->month=="7") {{$list->result}} @endif</td>
					<td align="center">@if($request->month=="8") {{$list->result}} @endif</td>
					<td align="center">@if($request->month=="9") {{$list->result}} @endif</td>
					<td align="center">@if($request->month=="10") {{$list->result}} @endif</td>
					<td align="center">@if($request->month=="11") {{$list->result}} @endif</td>
					<td align="center">@if($request->month=="12") {{$list->result}} @endif</td>
				</tr>
				@php
				$i++;
				@endphp
			@endforeach
			
		</table>
	</div>
	
</div>
