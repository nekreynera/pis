<div class="container">
	<div class="row">
		<br/>
		<h3 class="text-center">TRIAGE SUPPORT</h3>
		
			<div class="col-md-8">
				<div class="form-group">
					<label>Assign Clinic</label>
					<select name="clinic" class="form-control select">
						<option value="">Select Clinic</option>
						@foreach($clinics as $clinic)
							<option {{ (isset($triage->clinic_code) and $triage->clinic_code == $clinic->code)? 'selected' : '' }} 
							value="{{ $clinic->code }}">
								{{ $clinic->name }}
							</option>
						@endforeach
					</select>
				</div>
			</div>
			
			<div class="col-md-2">
				<div class="form-group">
					<label>Weight</label>
					<div class="input-group">
					    <input type="text" name="weight" class="form-control" value="{{ $vital_signs->weight or '' }}" placeholder="Enter Weight" />
					    <div class="input-group-addon">KG.</div>
					</div>
				</div>
			</div>

			<div class="col-md-2">
				<div class="form-group">
					<label>Height</label>
					<div class="input-group">
					    <input type="text" name="height" class="form-control" value="{{ $vital_signs->height or '' }}" placeholder="Enter Height" />
					    <div class="input-group-addon">CM.</div>
					</div>
				</div>
			</div>
		
			<div class="col-md-3">
				<div class="form-group">
					<label>Blood Pressure</label>
					<div class="input-group">
					    <input type="text" name="blood_pressure" class="form-control" value="{{ $vital_signs->blood_pressure or '' }}" 
					    placeholder="Enter Blood Pressure" />
					    <div class="input-group-addon">BP</div>
					</div>
				</div>
			</div>

			<div class="col-md-3">
				<div class="form-group">
					<label>Pulse Rate</label>
					<div class="input-group">
					    <input type="text" name="pulse_rate" class="form-control" value="{{ $vital_signs->pulse_rate or '' }}" 
					    placeholder="Enter Pulse Rate" />
					    <div class="input-group-addon">BPM</div>
					</div>
				</div>
			</div>

			<div class="col-md-3">
				<div class="form-group">
					<label>Respiration Rate</label>
					<div class="input-group">
					    <input type="text" name="respiration_rate" class="form-control" value="{{ $vital_signs->respiration_rate or '' }}" 
					    placeholder="Enter Respiration Rate" />
					    <div class="input-group-addon">RM</div>
					</div>
				</div>
			</div>

			<div class="col-md-3">
				<div class="form-group">
					<label>Body Temperature</label>
					<div class="input-group">
					    <input type="text" name="body_temperature" class="form-control" value="{{ $vital_signs->body_temperature or '' }}" 
					    placeholder="Enter Body Temperature" />
					    <div class="input-group-addon">°C</div>
					</div>
				</div>
			</div>
		

	</div>
</div>


<br>





