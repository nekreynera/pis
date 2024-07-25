
<div class="col-md-9 col-sm-9">
  <div class="row">
      <div class="col-md-6 col-sm-6 col-xs-4 action-button">
          <button class="btn btn-success btn-sm" id="new-list"><span class="fa fa-flask"></span> Nasdew</button>
          <button class="btn btn-success btn-sm disabled" id="edit-list" data-id="#"><span class="fa fa-pencil"></span> Edit</button>
      </div>
      <div class="col-md-6 col-sm-6 col-xs-8 action-search">
          <form class="list-search text-center" id="list-search" method="POST" action="{{ url('searchlist') }}">
                  <div class="input-group">
                        <!-- /btn-group -->
                        <input type="text" name="list_search" id="list-search-input" class="form-control input-sm" placeholder="Service Keyword..." autofocus/>
                        <span class="input-group-btn">
                            <button class="btn btn-success btn-sm" type="submit" form="#list-search">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                  </div>
                  <!-- /input-group -->
          </form>
      </div>
  </div>

</div>
<div class="col-md-3 col-sm-3">
  <div class="row">
    <div class="col-md-5 col-sm-12 col-xs-2">
      <button class="btn btn-success btn-sm " id="new-sub"><i class="fa fa-plus"></i></button>
      <button class="btn btn-success btn-sm" id="edit-sub" data-id="1"><i class="fa fa-pencil"></i></button>
    </div>
    <div class="col-md-7 col-sm-12 col-xs-10">
      <div class="input-group">
            <!-- /btn-group -->
            <input type="text" name="sub" id="sub-search-input" class="form-control input-sm" placeholder="Pathology keyword..." autofocus/>
            <span class="input-group-btn">
                <button class="btn btn-success btn-sm" type="submit" id="search-button">
                    <i class="fa fa-search"></i>
                </button>
            </span>
      </div>
    </div>
  </div>
</div>
<div class="btn-group-vertical trial-click">
  <button type="button" class="btn btn-default btn-sm" id="edit-list"><span class="fa fa-pencil"></span> Edit</button>
  <a href="#" class="btn btn-default btn-sm" id="service-information" data-id="#"><span class="fa fa-info-circle"></span> Service Information <a>
</div>


