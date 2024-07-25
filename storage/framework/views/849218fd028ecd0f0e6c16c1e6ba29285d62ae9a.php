<div class="col-md-9 col-sm-9 requsitionSelection">

    <div style="margin-bottom: 3px;">
        <form class="form-inline text-right" onsubmit="return false">
            <div class="input-group">
                <input type="text" name="" class="form-control requesition-item-input" id="requesition-item-input" data-search="description" placeholder="Search By Description..." />
                <span class="input-group-addon"><i class="fa fa-search"></i></span>
            </div>
        </form>
    </div>
    <div class="table-responsive tableWrapper">

        <div class="loaderWrapper">
            <img src="<?php echo e(asset('public/images/loader.svg')); ?>" alt="loader" class="img-responsive" />
            <p>Loading...</p>
        </div>

        <table class="table" id="requesition-item-table">

            <thead class="theadRequistion">
                <tr>
                    <th><i class="fa fa-question"></i></th>
                    <th>NAME</th>
                    <th>PRICE</th>
                    <th>STATUS</th>
                </tr>
            </thead>

            <tbody class="selectitemsTbody">

            <?php if(count($lablist)): ?>
                <?php $__currentLoopData = $lablist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php 
                        $checked = '';
                        $color = '';
                        foreach($request as $req):
                            if ($req->item_type == 'laboratory'):
                                if($list->id == $req->item_id):
                                    $checked = 'checked';
                                    $color = 'bg-success';
                                endif;
                            endif;
                        endforeach;
                    ?>
                    <tr class="<?php echo e(($list->status == 'Active')? '' : 'bg-danger'); ?><?php echo e($color); ?>" data-id-type="<?php echo e($list->id); ?>-laboratory" data-type="laboratory">
                        <td class="text-center">
                            <input type="checkbox"  name="select" class="select" value="<?php echo e($list->id); ?>" <?php echo e(($list->status == 'Inactive')? 'disabled' : ''); ?> <?php echo e($checked); ?>/>
                        </td>
                        <td class="text-capitalize item-name">
                            <?php echo e($list->name); ?>

                        </td>
                        <td class="text-right item-price">
                            <?php echo e(number_format($list->price, 2, '.', '')); ?>

                        </td>
                        <td class="text-center item-status">
                            <?php echo ($list->status == 'Active')?
                            '<span class="text-success">Available</span>' : '<span class="text-danger">Unavailable</span>'; ?>

                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">
                        <strong class="text-danger">NO RESULTS FOUND.</strong>
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>

        </table>


    </div>
</div>