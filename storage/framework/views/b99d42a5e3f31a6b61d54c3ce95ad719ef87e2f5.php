
<div class="col-md-12">
        <form class="form-inline" method="get">
            <div class="form-group">
                <label>
                    Export as
                </label>
                <select class="form-control" name="export" required>
                    <option value="" hidden>--</option>
                    <!-- <option value="1" <?php if($request): ?> <?php if($request->type == "1"): ?> selected  <?php endif; ?> <?php else: ?> selected <?php endif; ?>>HTML</option> -->
                    <option value="2" <?php if($request): ?> <?php if($request->type == "2"): ?> selected  <?php endif; ?> <?php endif; ?>>Excel </option>
                </select>
            </div>
            <div class="form-group">
                <label>
                    Type
                </label>
                <select class="form-control" name="type" required>
                    <option value="" hidden>--</option>
                    <option value="1" <?php if($request): ?> <?php if($request->type == "1"): ?> selected  <?php endif; ?> <?php endif; ?>>Patients</option>
                    <option value="2" <?php if($request): ?> <?php if($request->type == "2"): ?> selected  <?php endif; ?> <?php endif; ?>>Medical Svcs Accomplishment </option>
                    <option value="3" <?php if($request): ?> <?php if($request->type == "3"): ?> selected  <?php endif; ?> <?php endif; ?>>Patient and services used MSS CLASS C</option>
                    <option value="4" <?php if($request): ?> <?php if($request->type == "4"): ?> selected  <?php endif; ?> <?php endif; ?>>Patient and services used MSS CLASS D</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>
                    Date From 
                </label>
                <input type="text" name="from" 
                <?php if($request): ?> value="<?php echo e($request->from); ?>" <?php else: ?> value="<?php echo e(Carbon::now()->format('m/d/Y')); ?>" <?php endif; ?> 
                class="form-control" id="datemask1" data-inputmask="'alias': 'mm/dd/yyyy'" data-mask required>
            </div>
            <div class="form-group">
                <label>
                    Date To 
                </label>
                <input type="text" name="to"
                <?php if($request): ?> value="<?php echo e($request->to); ?>" <?php else: ?> value="<?php echo e(Carbon::now()->format('m/d/Y')); ?>" <?php endif; ?> 
                 class="form-control" id="datemask2" data-inputmask="'alias': 'mm/dd/yyyy'" data-mask required>
            </div>
            <button type="submit" class="btn btn-success btn-sm"><span class="fa fa-cog"></span> Submit</button>
        </form>
</div>

