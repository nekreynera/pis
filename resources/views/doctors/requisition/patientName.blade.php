{{--<div class="col-md-12 row patient-name">
    <h4><small>PATIENT NAME:</small> {{ $patient->last_name.', '.$patient->first_name.' '.$patient->middle_name }}</h4>
</div>--}}
<div class="row">
	<table class="table table-bordered" id="patient-table">
		<tr>
			<td colspan="2"><label>Patient:</label> <font>{{ $patient->first_name.' '.$patient->middle_name.' '.$patient->last_name.' ('.carbon::parse($patient->birthday)->format('m/d/Y').')  | '.App\Patient::age($patient->birthday).' | '.$patient->civil_status }}</font></td>
		</tr>
		<tr>
			<td colspan="2"><label>Address:</label> <font>{{ $patient->address }}</font></td>
		</tr>
		<tr>
			<td><label>Hospital no:</label> <b>{{ $patient->hospital_no }}</b></td>
			<!-- <td><label>Mss Classification: </label> <b>
				{{ ($patient->label)?$patient->label.' - '.$patient->description:'N\A' }}
				</b>
				<input type="hidden" name="discount" value="{{ $patient->discount }}">
				<input type="hidden" name="mss_id" value="{{ $patient->id }}">
			</td> -->
			<td><label>Mss Classification: </label> <b>
				N\A
				</b>
				<input type="hidden" name="discount" value="0">
				<input type="hidden" name="mss_id" value="null">
			</td>
		</tr>
	</table>	

