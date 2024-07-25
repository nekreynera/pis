<div id="search-modal" class="modal" role="dialog">
  <div class="modal-dialog modal-xl">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Patient Search  <span class="fa fa-search"></span><span class="fa fa-user"></span></h4>
      </div>
      <div class="modal-body">
        <div class="searchloader">
          <img src="public/images/loader.svg">
        </div>
        <div class="col-md-2">
          <label>Showing [ <label class="patient_count info"></label> ] result</label>
        </div>
        <div class="row col-md-2 col-md-offset-8" style="padding-right: 0px;padding-bottom: 3px;">
            <div class="input-group">
               <input type="text" name="" class="form-control" id="searchpatient" style="height: 30px;font-size: 12px;" placeholder="Filter Patient Name">
              <span class="input-group-addon fa fa-search"></span>
            </div>
        </div>
        <!-- <div class="row"> -->
          
        
        <div class="table table-responsive" style="max-height: 420px;">
          <table class="table table-striped table-bordered" id="search-table" user-id="{{Auth::user()->id}}">
            <thead>
              <tr style="background-color: #ccc">
                <th>HOSP. NO</th>
                <th>LAST NAME</th>
                <th>FIRST NAME</th>
                <th>MIDDLE NAME</th>
                <th>SEX</th>
                <th>BIRHTDAY</th>
                <th>ADDRESS</th>
                <th>STATUS</th>
                @if(Auth::user()->id == "135")
                <th>ACTION</th>
                @endif
              </tr>
            </thead>
            <tbody class="search-table-body">
              
            </tbody>
          </table>
         </div>
         <!-- </div> -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
@include('doctors.medicalRecords')