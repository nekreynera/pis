
<div class="col-md-12">
    <div class="row">
        <div class="col-md-6 col-sm-5 col-xs-4 action-button">
            <button class="btn btn-success btn-sm" id="new-patient"><span class="fa fa-user"></span> New</button>
            <button class="btn btn-success btn-sm disabled" id="view-patient" data-id="#"><span class="fa fa-eye"></span> View</button>
            <button class="btn btn-success btn-sm" id="printpatientslogs"><span class="fa fa-print"></span> Print-OPDLRLOGS</button>
            <!-- <button class="btn btn-success btn-sm" id="done-patient"><span class="fa fa-check"></span> Done</button> -->
            <!-- <button class="btn btn-danger btn-sm disabled" id="nawc-patient" data-id="#"><span class="fa fa-remove"></span> NAWC</button> -->
        </div>
        <div class="col-md-6 col-sm-7 col-xs-8 action-search">
            <form class="queued-patient-form text-center" method="GET" action="">
                <div class="input-group">
                    <div class="input-group-btn">
                        <button type="button" class="btn btn-default btn-sm dropdown-toggle" 
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-search"></i> Search By <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu search-menu">
                            <li><a href="#" class="lname">Last Name</a></li>
                            <li><a href="#" class="fname">First Name</a></li>
                            <li><a href="#" class="hospital_no">Patient Hospital No.</a></li>
                            <!-- <li><a href="#" class="datereg">Date Queued</a></li> -->
                        </ul>
                    </div>
                    
                    <!-- /btn-group -->
                    <input type="text" name="patient" id="queued-patient-input" class="form-control input-sm queued-patient-input" placeholder="Search Patient..." autofocus required />
                    <span class="input-group-btn">
                        <button class="btn btn-success btn-sm" type="submit" id="search-button">
                            <i class="fa fa-search"></i> Search
                        </button>
                    </span>
                </div>
              <!-- /input-group -->
            </form>
        </div>
    </div>
</div>

<div class="btn-group-vertical trial-click">
    <button type="button" class="btn btn-default btn-sm" id="view-patient" data-id="#"><span class="fa fa-eye"></span> View</button>
    <a href="#" class="btn btn-default btn-sm" id="patient-information" data-id="#"><span class="fa fa-user-o"></span> Patient Information </a>
    <a href="#" class="btn btn-default btn-sm" id="medical-record " data-id="#"><span class="fa fa-file-text-o"></span> Medical Record</span></a>
    <button type="button" class="btn btn-warning btn-sm queued-status-button" data="P" data-id="#"><span class="fa fa-rotate-left"></span> Mark as Pending</button>
    <button type="button" class="btn btn-info btn-sm queued-status-button" data="F" data-id="#"><span class="fa fa-check"></span> Mark as Done</button>
    <button type="button" class="btn btn-danger btn-sm queued-status-button" data="R" data-id="#"><span class="fa fa-remove"></span> Mark as Removed</button>
</div>
