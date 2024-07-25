<div class="box-header with-border">
    <div class="row">
        <div class="col-md-6 action-button">
            <button class="btn btn-success btn-sm" id="check-patient-toggle"><span class="fa fa-user"></span> New</button>
            <button class="btn btn-success btn-sm disabled" id="edit-button" data-id="#"><span class="fa fa-pencil"></span> Edit</button>
            <a class="btn btn-success btn-sm" id="print-button" data-id="#" disabled><span class="fa fa-print"></span> Print</a>
            <button class="btn btn-primary btn-sm" id="print-multiple"><span class="fa fa-print"></span> Print Multiple</button>
            <button class="btn btn-danger btn-sm disabled" id="remove-button" data-id="#"><span class="fa fa-trash"></span> Remove</button>
            @if(Auth::user()->id == '135')
            <a class="btn btn-danger btn-sm" id="delete-button" data-id="#" disabled><span class="fa fa-remove"></span> Delete</a>
            @endif
        </div>
        <div class="col-md-6 action-search">

            <form class="form-search text-center" method="GET" action="">
                    <div class="input-group">

                          <div class="input-group-btn">
                              <button type="button" class="btn btn-default btn-sm dropdown-toggle" 
                                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <i class="fa fa-search"></i> Search By <span class="caret"></span>
                              </button>
                              <ul class="dropdown-menu search-menu">
                                  <li><a href="#" class="lname">Last Name</a></li>
                                  <li><a href="#" class="fname">First Name</a></li>
                                  <li><a href="#" class="completename">Last Name & First Name</a></li>
                                  <li><a href="#" class="hospital_no">Patient Hospital No.</a></li>
                                  <li><a href="#" class="datereg">Date Registered</a></li>
                                  <li><a href="{{ url('patients?deleted=true') }}" class="bg-red">For Delete</a></li>
                              </ul>
                          </div>
                          
                          <!-- /btn-group -->
                          <input type="text" name="patient" id="searchInput" class="form-control input-sm" placeholder="hospital no last name first name middle name..." autofocus/>
                          <span class="input-group-btn">
                              <button class="btn btn-success btn-sm" type="submit" id="search-button">
                                  <i class="fa fa-search"></i> Search
                              </button>
                          </span>
                    </div>
                    <span class="fa fa-info-circle"></span> <small class="search-guide"> hospital no last name first name middle name</small>
                    <!-- /input-group -->
            </form>
        </div>
    </div>
</div>
<div class="btn-group-vertical trial-click">
  <button type="button" class="btn btn-default btn-sm" id="edit-button"><span class="fa fa-pencil"></span> Edit</button>
  <a href="#" class="btn btn-default btn-sm" id="print-button" data-id="#"><span class="fa fa-print"></span> Print</a>
  <a href="#" class="btn btn-default btn-sm" id="patient-information" data-id="#"><span class="fa fa-user-o"></span> Patient Information <a>
  <a href="#" class="btn btn-default btn-sm" id="medical-record"><span class="fa fa-file-text-o"></span> Medical Record</span></a>
  <a href="#" class="btn btn-default btn-sm" id="patient-transaction"><span class="fa fa-id-card-o"></span> Transaction</span></a>
  <button type="button" class="btn btn-danger btn-sm" id="remove-button"><span class="fa fa-trash"></span> Remove</button>
</div>