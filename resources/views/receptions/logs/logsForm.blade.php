<div class="row">
    <div class="col-md-12 text-center">
        <form action="{{ url('rcptnLogs') }}" method="post" class="form-inline">
            {{ csrf_field() }}
            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                <input type="text" required name="starting" value="{{ $starting or '' }}" class="form-control datepicker" required placeholder="Starting date">
            </div>
            <div class="form-group" style="margin: 0 10px 0 10px">
                <i class="fa fa-arrow-right"></i>
            </div>
            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                <input type="text" required name="ending" value="{{ $ending or '' }}" class="form-control datepicker" required placeholder="Ending date">
            </div>
            <div class="form-group" style="margin-left:15px">
                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-filter"></i>
                                    </span>
                    <select name="doctor" id="" class="form-control" style="height: 40px">
                        <option value="0">--Show All--</option>
                        @if($allDoctors)
                            @foreach($allDoctors as $allDoctor)
                                <option value="{{ $allDoctor->id }}">{{ 'Dr. '.strtoupper($allDoctor->name) }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="form-group" style="margin-left:15px">
                <button class="btn btn-success" type="submit" style="height: 40px">Submit</button>
            </div>
        </form>
    </div>

</div>