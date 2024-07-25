<?php if(Session::has('danger')): ?>
    <div class="alert alert-danger fade in text-center">
    	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong><?php echo e(Session::get('danger')); ?></strong>
    </div>
<?php endif; ?>

<?php if(Session::has('success')): ?>
    <div class="alert alert-success fade in text-center">
    	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong><?php echo e(Session::get('success')); ?></strong>
    </div>
<?php endif; ?>