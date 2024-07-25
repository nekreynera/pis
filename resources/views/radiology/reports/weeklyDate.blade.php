<form action="{{ url('weeklyCensus') }}" method="post" class="form-inline text-right" role="form">
    {{ csrf_field() }}

    <div class="form-group">
        <div class="input-group">
        <span class="input-group-addon" id="startingDate" onclick="document.getElementById('start').focus()">
            <i class="fa fa-calendar"></i>
        </span>
            <input type="text" name="dateTime" class="form-control datepicker" value="{{ $originalDate }}"
                   placeholder="Enter Date" aria-describedby="startingDate" id="start" required />
        </div>
        @if ($errors->has('dateTime'))
            <span class="help-block">
                <strong class="">{{ $errors->first('dateTime') }}</strong>
            </span>
        @endif
    </div>

    &nbsp;

    <div class="form-group">
        <button class="btn btn-success">Submit</button>
    </div>

</form>


<br>