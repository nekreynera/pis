<div id="searchWatcherModal" class="modal" role="dialog">
  <div class="modal-dialog">


    <!-- Modal content-->
    <div class="modal-content">


        <div class="loaderRefresh">
            <div class="loaderWaiting">
                <i class="fa fa-spinner fa-spin"></i>
                <span> Please Wait...</span>
            </div>
        </div>

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Search Watchers</h4>
      </div>
      <div class="modal-body">


            


            <form action="{{ url('searchwatcher') }}" method="post" id="watchersForm" onsubmit="watchersForm()">
                {{ csrf_field() }}
                <small class="text-muted">Enter watcher's name, hospital no, qrcode or date of when patient was admited.</small>
                <div class="input-group">
                    <input type="text" name="search" id="searchwatcherInput" class="form-control" 
                    placeholder="Search Watchers..." required />
                    <span class="input-group-addon searchWatcherBtn" onclick="searchWatcher()">
                        <i class="fa fa-search"></i> Search
                    </span>
                </div>
            </form>


            <br>
            <br>






            <div class="table-responsive">

                <h5 class="text-success">Search Results:</h5>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Watchers Name</th>
                                <th>Patients Name</th>
                                <th>Date of Admittion</th>
                            </tr>
                        </thead>
                        <tbody class="watchersTbody">
                        </tbody>
                    </table>
                </div>
            </div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>