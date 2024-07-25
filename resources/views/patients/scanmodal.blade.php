<div id="scanmodal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Scan Patient/Watcher ID</h4>
      </div>
      <div class="modal-body">
        <div class="row">
        <br>
          <div class="col-md-10 col-md-offset-1">
            <div class="input-group">
              <input type="text" name="credentials" value="" class="form-control inputbarcode" autofocus placeholder="Qr-code/Hospital no">
              <div class="input-group-btn">
                   <button type="button" class="btn btn-default dropdown-toggle" 
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                       Filter By <span class="caret"></span>
                   </button>
                   <ul class="dropdown-menu">
                       <li><a href="" class="name">PATIENT</a></li>
                       <li><a href=""  class="birthday">WATCHER</a></li>
                      
                   </ul>
               </div>
            </div>
          </div>
        <br>
          <div class="col-md-12">
          <p class="text-center">Scan ID to identify credential</p>
            
          </div>
        <br>
        </div>
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>