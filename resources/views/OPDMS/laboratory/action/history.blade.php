
<div class="col-md-12">
        <form class="form-inline text-right" method="get">
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

