
<div class="col-md-12">
        <form class="form-inline" method="get">
            <div class="form-group">
                <label>
                    Export as
                </label>
                <select class="form-control" name="export" required>
                    <option value="" hidden>--</option>
                    <!-- <option value="1" @if($request) @if($request->type == "1") selected  @endif @else selected @endif>HTML</option> -->
                    <option value="2" @if($request) @if($request->type == "2") selected  @endif @endif>Excel </option>
                </select>
            </div>
            <div class="form-group">
                <label>
                    Type
                </label>
                <select class="form-control" name="type" required>
                    <option value="" hidden>--</option>
                    <option value="1" @if($request) @if($request->type == "1") selected  @endif @endif>Patients</option>
                    <option value="2" @if($request) @if($request->type == "2") selected  @endif @endif>Medical Svcs Accomplishment </option>
                    <option value="3" @if($request) @if($request->type == "3") selected  @endif @endif>Patient and services used MSS CLASS C</option>
                    <option value="4" @if($request) @if($request->type == "4") selected  @endif @endif>Patient and services used MSS CLASS D</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>
                    Date From 
                </label>
                <input type="text" name="from" 
                @if($request) value="{{ $request->from }}" @else value="{{ Carbon::now()->format('m/d/Y') }}" @endif 
                class="form-control" id="datemask1" data-inputmask="'alias': 'mm/dd/yyyy'" data-mask required>
            </div>
            <div class="form-group">
                <label>
                    Date To 
                </label>
                <input type="text" name="to"
                @if($request) value="{{ $request->to }}" @else value="{{ Carbon::now()->format('m/d/Y') }}" @endif 
                 class="form-control" id="datemask2" data-inputmask="'alias': 'mm/dd/yyyy'" data-mask required>
            </div>
            <button type="submit" class="btn btn-success btn-sm"><span class="fa fa-cog"></span> Submit</button>
        </form>
</div>

