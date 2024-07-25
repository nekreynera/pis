<div class="icdsContainer">
	@if(!empty($icds))
	@php $bottom = 0; @endphp
		@foreach($icds as $icd)
			<div class="form-group input-group {{ 'icd'.$icd->icd }}" data-icd="{{ $icd->icd }}">
				<input type="hidden" name="icd[]" value="{{ $icd->id.'_ICD' }}">
				<input type="text" class="form-control red" value="{{ '('.$icd->code.') '.$icd->description }}" readonly="" />
				<span class="input-group-addon deleteThisICD" data-placement="top" data-toggle="tooltip" title="Delete ICD"
				data-desc="{{ $icd->description }}" data-code="{{ $icd->code }}" data-id="{{ $icd->icd }}" onclick="removeICD($(this))">
					<i class="fa fa-trash"></i>
				</span>
			</div>
			@php $bottom += 40; @endphp
		@endforeach
	@endif
</div>