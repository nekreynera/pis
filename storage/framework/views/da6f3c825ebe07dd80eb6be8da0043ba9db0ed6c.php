<div class="col-md-12 col-sm-12">
    <div class="row seletecItemsWrapper">
        <div class="table-responsive tableSelectedItems">
            <?php echo $__env->make('OPDMS.partials.loader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <table class="table table-striped" id="selected-items">
                <thead>
                <tr>
                    <th><i class="fa fa-question"></i></th>
                    <th>ITEM NAME</th>
                    <th>PRICE</th>
                    <th>QTY</th>
                    <th>AMOUNT</th>
                    <th>DISCOUNT</th>
                    <th>NET AMOUNT</th>
                </tr>
                </thead>
                <form id="savependingRequistion" method="POST" action="<?php echo e(url('savePendingRequisition')); ?>">
                    <?php echo e(csrf_field()); ?>

                    <tbody class="selectedItemsTbody">
                        <?php
                            $total_amount = 0;
                            $total_discount = 0;
                            $total_net_amount = 0;
                        ?>
                    <?php if(count($request) > 0): ?>
                        <?php $__currentLoopData = $request; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr data-type="<?php echo e($list->item_type); ?>" data-id-type="<?php echo e($list->item_id.'-'.$list->item_type); ?>">
                                <td class="text-center">
                                    <input type="checkbox" name="selected[]" value="<?php echo e($list->item_id); ?>" checked>
                                    <input type="hidden" name="request_id[]" value="<?php echo e($list->request_id); ?>">
                                    <input type="hidden" name="request_type[]" value="<?php echo e($list->item_type); ?>">
                                </td>
                                <td class="text-capitalize item-name"><?php echo e($list->name); ?></td>
                                <td class="text-right item-price">
                                    <?php echo e(number_format($list->price, 2, '.', '')); ?>

                                    <input type="hidden" name="item_price[]" value="<?php echo e(number_format($list->price, 2, '.', '')); ?>">
                                </td>
                                <td class="text-center item-qty">
                                    <input type="number" name="qty[]" value="<?php echo e($list->qty); ?>"min="1" readonly>
                                </td>
                                    <!-- $discount = $amount * $patient->discount; -->

                                <?php
                                    $amount = $list->price * $list->qty;
                                    $discount = 0;
                                    $net_amount = $amount - $discount;

                                    $total_amount+=$amount;
                                    $total_discount+=$discount;
                                    $total_net_amount+=$net_amount;
                                ?>
                                <td class="text-right item-amount"><?php echo e(number_format($amount, 2, '.', '')); ?></td>
                                <td class="text-right item-discount">
                                    <?php echo e(number_format($discount, 2, '.', '')); ?>

                                    <input type="hidden" name="item_discount[]" value="<?php echo e(number_format($discount, 2, '.', '')); ?>">
                                </td>
                                <td class="text-right item-net-amount"><?php echo e(number_format($net_amount, 2, '.', '')); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                    </tbody>
                </form>

                <tfoot class="selectedItemsTfoot">
                    <tr>
                        <td colspan="4" class="text-right"><b>TOTAL</b></td>
                        <td class="text-right"><b class="total-amount"><?php echo e(number_format($total_amount, 2, '.', '')); ?></b></td>
                        <td class="text-right"><b class="total-discount"><?php echo e(number_format($total_discount, 2, '.', '')); ?></b></td>
                        <td class="text-right"><b class="total-net-amount"><?php echo e(number_format($total_net_amount, 2, '.', '')); ?></b></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<div class="col-md-8 col-sm-8 col-xs-8" style="padding-left: 0px;top: 5px;">
    <p><i class="fa fa-info-circle"></i> <font style="color: red">ICD CODES</font> are <b>required</b> when requesting laboratory services.</p>
</div>
<div class="col-md-4 col-sm-4 col-xs-4 submitRequisition">
    <div class="text-right">

        <!-- <button type="button" name="button" class="btn btn-danger btn-sm cancel"><span class="fa fa-remove"></span> CANCEL</button> -->
        <button type="submit" id="<?php echo e((Auth::user()->clinic == 43)?'selectpamentoption':'savependingRequistionbutton'); ?>" class="btn btn-success btn-sm"><span class="fa fa-save"></span> SAVE REQUISITION</button>
    </div>
</div>