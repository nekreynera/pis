<div class="row">
    <br>
    <div class="col-md-6">
        <h2>Consultation Logs</h2>
    </div>

    <div class="col-md-6">
        <form action="<?php echo e(url('consultationLogs')); ?>" method="post" class="form-inline">
            <?php echo e(csrf_field()); ?>

            <div class="input-group">
            <span class="input-group-addon" id="basic-addon1" onclick="document.getElementById('strt').focus()">
                <i class="fa fa-calendar"></i>
            </span>
                <input type="text" name="starting" id="strt" class="datepicker form-control" required placeholder="Enter Starting Date...">
            </div>
            <div class="form-group">
                &nbsp;
                <i class="fa fa-arrow-right"></i>
                &nbsp;
            </div>
            <div class="input-group">
            <span class="input-group-addon" id="basic-addon1" onclick="document.getElementById('end').focus()">
                <i class="fa fa-calendar"></i>
            </span>
                <input type="text" name="ending" class="datepicker form-control" id="end" required placeholder="Enter Ending Date...">
            </div>
            &nbsp;
            <div class="form-group">
                <button class="btn btn-success">Submit</button>
            </div>
        </form>
    </div>

</div>

<hr>
