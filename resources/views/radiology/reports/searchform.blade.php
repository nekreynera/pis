<div class="text-right">
    <form action="{{ url('medServicesAccomplished') }}" method="post" class="form-inline" role="form">
        {{ csrf_field() }}

        <div class="form-group">
            <div class="input-group">
        <span class="input-group-addon" id="startingDate" onclick="document.getElementById('start').focus()">
            <i class="fa fa-calendar"></i>
        </span>
                <input type="text" name="starting" class="form-control datepicker" value="{{ $starting }}"
                       placeholder="Starting Date" aria-describedby="startingDate" id="start" />
            </div>
            @if ($errors->has('starting'))
                <span class="help-block">
                <strong class="">{{ $errors->first('starting') }}</strong>
            </span>
            @endif
        </div>


        &nbsp;<i class="fa fa-arrow-right"></i> &nbsp;



        <div class="form-group @if ($errors->has('ending')) has-error @endif">
            <div class="input-group">
        <span class="input-group-addon" id="endingDate" onclick="document.getElementById('ending').focus()">
            <i class="fa fa-calendar"></i>
        </span>
                <input type="text" name="ending" class="form-control datepicker" value="{{ $ending }}"
                       placeholder="Ending Date" aria-describedby="endingDate" id="ending">
            </div>
            @if ($errors->has('ending'))
                <span class="help-block">
                <strong class="">{{ $errors->first('ending') }}</strong>
            </span>
            @endif
        </div>


        &nbsp;
        <div class="form-group">
            <select name="category" id="" class="form-control">
                <option value="N" {{ ($category == 'N')? 'selected' : '' }}>New Patient</option>
                <option value="O" {{ ($category == 'O')? 'selected' : '' }}>Old Patient</option>
            </select>
        </div>

        &nbsp;
        <div class="form-group">
            <button class="btn btn-success">Submit</button>
        </div>

    </form>


    <hr>
</div>