<div id="watchermodal" class="modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">PATIENT WATCHER</h4>
      </div>
      <div class="modal-body">
        <div class="table table-responsive">
          <table class="table table-striped" style="background-color: #e6e6e6;">
            <thead>
              <tr style="background-color: #cccccc">
                <th>NAME</th>
                <th>AGE</th>
                <th>SEX</th>
                <th>DATE <br>REGISTERED</th>
                <th>PRINT ID</th>
                <th>EDIT</th>
                <th>DELETE</th>
              </tr>
            </thead>
            <tbody class="watchertbody">
              
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
        <a href="#" 
        class="btn btn-success btn-sm" 
        id="addwatcher"
        data-toggle="tooltip"
        title="Add Watcher"
        >
        <span class=" fa fa-user-plus"></span>
         Add Watcher
       </a>
      </div>
    </div>

  </div>
</div>