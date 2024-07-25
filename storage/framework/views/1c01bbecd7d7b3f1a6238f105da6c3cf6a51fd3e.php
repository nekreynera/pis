<table style="width: 265px;padding-bottom: 45px;">
    <tbody>
        <?php $__currentLoopData = $requisitions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $requisition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td width="150px"><?php echo e($requisition->item_description); ?></td>
                <td>QTY: <?php echo e($requisition->qty); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>