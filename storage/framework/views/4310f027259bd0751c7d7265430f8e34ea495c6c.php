<div class="icdsContainer">
	<?php if(!empty($icds)): ?>
	<?php $bottom = 0; ?>
		<?php $__currentLoopData = $icds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $icd): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<div class="form-group input-group <?php echo e('icd'.$icd->icd); ?>" data-icd="<?php echo e($icd->icd); ?>">
				<input type="hidden" name="icd[]" value="<?php echo e($icd->id.'_ICD'); ?>">
				<input type="text" class="form-control red" value="<?php echo e('('.$icd->code.') '.$icd->description); ?>" readonly="" />
				<span class="input-group-addon deleteThisICD" data-placement="top" data-toggle="tooltip" title="Delete ICD"
				data-desc="<?php echo e($icd->description); ?>" data-code="<?php echo e($icd->code); ?>" data-id="<?php echo e($icd->icd); ?>" onclick="removeICD($(this))">
					<i class="fa fa-trash"></i>
				</span>
			</div>
			<?php $bottom += 40; ?>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	<?php endif; ?>
</div>