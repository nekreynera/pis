<div class="col-md-12">
	<div class="table-responsive" id="chargetofund">
		<table class="table table-bordered">
			<tr>
				<th class="text-center" colspan="15">MEDICINES DISPENSED TO PATIENTS</th>
			</tr>
			<tr>
				<th class="text-center" style="padding: 2px;background-color: #e6e6e6" colspan="15"><i>PIS PHARMACY 2024</i></th>
			</tr>
			<tr class="bg-success">
				<th colspan="1" rowspan="2">CHARGE TO FUND</th>
				<th colspan="2">Number of Patients</th>
				<th colspan="12">Month</th>
			<tr class="bg-success">
				<th>Sub-Total</th>
				<th>Total</th>
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
				$data = 'DOH/ CHARITY,C1- C2- C3,EMPLOYEE,CLASS D';
				$id = '10,11,12,13-3,4,5,6,7,8-1000-9';
				$exdata = explode(',', $data);
				$exid = explode('-', $id);
				$i = 0;
			@endphp
			@foreach($exdata as $list)
				@php
					$result = App\Sales::chargetofund($exid[$i], $request->start_month, $request->end_month, $request->year);
				@endphp
			<tr>
				<td>{{ $exdata[$i] }}</td>
				@php
					$total=0;
				@endphp
				@foreach($result as $list) 
					@php
					$total+=$list->result;
					@endphp
				@endforeach
				<td align="center">{{ $total }}</td>
				<td align="center">{{ $total }}</td>
				@for($lo = 1; $lo <= 12; $lo++)
					<td align="center">
						@foreach($result as $list) 
							@if($list->yearmonth == $lo) 
								{{ $list->result }}
							@endif
						@endforeach
					</td>
				@endfor
			</tr>
				@php
				$i++;
				@endphp
			@endforeach
			
		</table>
	</div>
	
</div>
