<div class="modal fade" id="modal-clinic">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Change Assigned Clinic</h4>
        </div>
        <div class="modal-body">
          <form method="post" id="form-clinic" action="{{ url('changeuserclinic') }}">
            {{ csrf_field() }}
            @php
              $clinics = App\Clinic::where('type', 'c')
                                    ->whereNotIn('id', [45,47,48,49,54,61,65,53,22,21])->get();
              $clinic_id = null;
              if(Auth::user()):
              $clinic_id = Auth::user()->clinic;
              endif;
            @endphp
            <select name="clinic_id" class="form-control clinic_id">

                @foreach($clinics as $clinic)
                  @if($clinic->name != '')
                    <option value="{{ $clinic->id }}" @if($clinic->id == $clinic_id) selected @endif>{{ $clinic->name }}</option>
                  @endif
                @endforeach
            </select>
          </form>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-default" form="form-clinic">Change</button>
        </div>
      </div>
    </div>
  </div>
  