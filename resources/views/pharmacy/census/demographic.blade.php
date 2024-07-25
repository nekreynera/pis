<div class="table table-responisve">
	<table class="table table-bordered" id="demographictable">
		<tr>
			<th>DEMOGRAPHIC</th>
			<th colspan="{{count($month)*3}}" class="bg-warning">MONTH</th>
			<th rowspan="3">TOTAL PER <br> AREA <br>(QTY per Medicine)</th>
			<th rowspan="3">TOTAL PER <br> AREA <br>(Referrals From)</th>
			<th rowspan="3">TOTAL PER <br> AREA <br>(Referrals To)</th>
		</tr>
		<tr>
			<th rowspan="2">NAME OF PROVINCES / AREAS <br> RX SERVED</th>
			@foreach($month as $list)
			<th colspan="3">{{ Carbon::parse($list->dates)->format('F') }}</th>
			@endforeach
		</tr>
		
		<tr>
			@for($i=1;$i<=count($month);$i++)
			<th>Qty. per <br> Medicine</th>
			<th>Referrals <br> (FROM)</th>
			<th>Referrals <br> (TO)</th>
			@endfor
		</tr>
		@php
			$places = 'TACLOBAN CITY,
						LEYTE 1st District,
						LEYTE 2nd District,
						LEYTE 3rd District,
						LEYTE 4th District,
						LEYTE 5th District,
						SOUTHERN LEYTE,
						BILIRAN,
						WESTERN SAMAR 1st District,
						WESTERN SAMAR 2nd District,
						EASTERN SAMAR,
						NORTHERN SAMAR 1st District,
						NORTHERN SAMAR 2nd District,
						OUTSIDE REGION 8';
			$explaces = explode(",", $places);
			$placeid = '1004-
						967,969,970,973,975,977,978,983,985,996,1000,1001,1005,1006-
						976,987,989,993,998,1003,1007-
						974,988,999,1002,1008-
						968,982,986,991,994,995,997-
						966,971,972,979,980,981,984,990,992-
						1059,1060,1061,1062,1063,1064,1065,1066,1067,1068,1069,1070,1071,1072,1073,1074,1075,1076,1077-
						1078,1079,1080,1081,1082,1083,1084,1085-
						1033,1035,1039,1043,1048,1050,1052,1056,1057,1058-
						1034,1036,1037,1038,1040,1041,1042,1044,1045,1046,1047,1049,1051,1053,1054,1055-
						943,946,947,948,953,956,959,962,963,964,965,944,945,949,950,951,952,954,955,957,958,960,961-
						1009,1010,1011,1012,1013,1019,1021,1024,1025,1026,1027,1029,1031,1032-
						1014,1015,1016,1017,1018,1020,1022,1023,1028,1030-
                      	08';
            $explaceid = explode("-", $placeid);
           
		$pl = 0;
		@endphp
		@foreach($explaces as $expl)
			<tr class="bg-success">
				<td>{{$explaces[$pl]}}</td>
				@php
					$total = 0;
				@endphp
				@foreach($month as $var)
					@if($var->months >= $request->start_month && $var->months <= $request->end_month )
						@php
							if($explaceid[$pl] == "08"):
								$disctrictpermonth = App\Sales::outsideroedemographicpermonth($var->months, $request->year);
							else:
								$disctrictpermonth = App\Sales::demographicpermonth($explaceid[$pl], $var->months, $request->year);
							endif;
						@endphp
					@else
						@php
							$disctrictpermonth = [];
						@endphp
					@endif
				<td align="center">
					@foreach($disctrictpermonth as $list) 
						@if($list->months == $var->months) 
							{{ $list->result }} 
							@php
								$total+=$list->result
							@endphp
						@endif
					@endforeach
				</td>
				<td></td>
				<td></td>
				@endforeach
				<td align="center">{{$total}}</td>
				<td></td>
				<td></td>
			</tr>

			<tr>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;Total Rx Served</td>
				@php
					$total = 0;
				@endphp
				@foreach($month as $var)
					@if($var->months >= $request->start_month && $var->months <= $request->end_month )
						@php
							if($explaceid[$pl] == "08"):
								$disctrictpermonth = App\Sales::outsideroedemographicpermonth($var->months, $request->year);
							else:
								$disctrictpermonth = App\Sales::demographicpermonth($explaceid[$pl], $var->months, $request->year);
							endif;
						@endphp
					@else
						@php
							$disctrictpermonth = [];
						@endphp
					@endif
				<td align="center">
					@foreach($disctrictpermonth as $list) 
						@if($list->months == $var->months) 
							{{ $list->overallqty }} 
							@php
								$total+=$list->overallqty
							@endphp
						@endif
					@endforeach
				</td>
					
				<td></td>
				<td></td>
				@endforeach
				<td align="center">{{$total}}</td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;Highest Drugs/Meds Dispensed</td>
				@foreach($month as $var)
					@if($var->months >= $request->start_month && $var->months <= $request->end_month )
						@php
							if($explaceid[$pl] == "08"):
								$disctrictpermonth = App\Sales::outsideroedemographicpermonth($var->months, $request->year);
							else:
								$disctrictpermonth = App\Sales::demographicpermonth($explaceid[$pl], $var->months, $request->year);
							endif;
						@endphp
					@else
						@php
							$disctrictpermonth = [];
						@endphp
					@endif
				<td>@foreach($disctrictpermonth as $list) @if($list->months == $var->months) {{ $list->item_description.' '.'('.$list->unitofmeasure.')' }} @endif @endforeach</td>
				<td></td>
				<td></td>
				@endforeach
				<td align="center"></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;.</td>
			</tr>
			@php
			$pl++;
			@endphp
		@endforeach		
	</table>
</div>