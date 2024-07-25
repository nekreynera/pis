<div class="row">
    <div class="col-md-2">
        <h3 class="text-center h3History">History</h3>
    </div>
    <div class="col-md-10">
        <form action="{{ url('radiologyhistory') }}" method="post" class="form-inline">
            {{ csrf_field() }}
            <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">
                            <i class="fa fa-calendar"></i>
                        </span>
                <input type="text" name="starting" value="{{ $starting }}" class="form-control datepicker" placeholder="Enter Starting Date">
            </div>
            &nbsp;
            <i class="fa fa-arrow-right"></i>
            &nbsp;
            <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">
                            <i class="fa fa-calendar"></i>
                        </span>
                <input type="text" name="ending" value="{{ $ending }}" class="form-control datepicker" placeholder="Enter Ending Date">
            </div>
            &nbsp;
            <div class="input-group">
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </form>
    </div>
</div>