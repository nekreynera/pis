<div id="addpatientmodal" class="modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <form class="form-horizontal addpatientmodalform" action="{{ url('checkpatients') }}" method="post">
      {{ csrf_field() }}
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><span class="fa fa-user-o"></span> SEARCH..</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-10 col-md-offset-1">
           
              <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="last_name" class="form-control last_name" required>
              </div>
              <div class="form-group">
                <label>First Name</label>
                <input type="text" name="first_name" class="form-control first_name" required>
              </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success btn-sm"><span class="fa fa-arrow-right"></span> Submit</button>
        <a href="" class="trials" hidden></a>
      </div>
    </div>
    </form>
  </div>
</div>