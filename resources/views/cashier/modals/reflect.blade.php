<div id="refincome-modal" class="modal" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title">REFLECT O.R SERIES <strong>(VOIDED)</strong></h5>
      </div>
      <div class="modal-body">
        @if(count($errors) > 0)
            <div class="alert alert-danger">
                <strong><i class="fa fa-ban"></i> Whoops! looks like something went wrong.</strong>
                <br/>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form class="form-horizontal" id="storeincomeor" method="post" action="{{ url('storeincomeor') }}">
           {{ csrf_field() }}
          <div class="form-group @if($errors->has('date')) has-error @endif">
            <label class="col-sm-3 control-label">Date:</label>
            <div class="col-sm-5">
              <div class="input-group">
                <input type="date" name="date" class="form-control text-center" value="@if(old('date')){{old('date')}}@else{{date('Y-m-d')}}@endif">
                <span class="fa fa-calendar input-group-addon"></span>
              </div>
              @if($errors->has('date'))
                <span class="help-inline text-danger">{{ $errors->first('date') }}</span>
              @endif
            </div>
          </div>
          <div class="form-group @if($errors->has('or_no')) has-error @endif">
            <label class="col-sm-3 control-label">O.R Series:</label>
            <div class="col-sm-5">
              <input type="text" name="or_no" class="form-control text-center" placeholder="0000000" value="{{ old('or_no') }}">
              @if($errors->has('or_no'))
                <span class="help-inline text-danger">{{ $errors->first('or_no') }}</span>
              @endif
            </div>
            <div class="col-md-4">
              <select class="form-control" name="or_type">
                <option value="" hidden>O.R Type</option>
                <option value="i">INCOME</option>
                <option value="m">MEDS</option>
              </select>
               @if($errors->has('or_type'))
                <span class="help-inline text-danger">{{ $errors->first('or_type') }}</span>
                @endif
            </div>
            
          </div>
          <div class="form-group @if($errors->has('hospital_no')) has-error @endif">
            <label class="col-sm-3 control-label">Patient Hospital no:</label>
            <div class="col-sm-5">
              <div class="input-group">
                <input type="text" name="hospital_no" class="form-control text-center hospital_no" value="{{ old('hospital_no') }}">
                <span class="input-group-addon" id="search-patient">Search <i class="fa fa-search"></i></span>
              </div>
              @if($errors->has('hospital_no'))
                <span class="help-inline text-danger">{{ $errors->first('hospital_no') }}</span>
              @endif
              <span class="help-inline text-danger hospital_no-error"></span>
            </div>
          </div>
          <div class="form-group @if($errors->has('ptname')) has-error @endif">
            <label class="col-sm-3 control-label">Patient Name:</label>
            <div class="col-sm-9">
              <div class="input-group">
              <input type="text" name="ptname" class="form-control ptname" value="{{ old('ptname') }}" readonly>
                <span class="fa fa-user input-group-addon"></span>
              </div>
              <small>firstname middlename lastname</small><br>
              @if($errors->has('ptname'))
                <span class="help-inline text-danger">{{ $errors->first('ptname') }}</span>
              @endif
              <input type="hidden" name="ptid" class="ptid" value="{{ old('ptid') }}">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-remove"></span> Close</button>
        <button type="submit" class="btn btn-default" form="storeincomeor"><span class="fa fa-save"></span> Save & Submit</button>
      </div>
    </div>

  </div>
</div>