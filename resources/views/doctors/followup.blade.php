@component('partials/header')

    @slot('title')
        PIS | Follow Up
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/plugins/css/jquery-ui.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/doctors/reset.css') }}" rel="stylesheet" />
    @if(Auth::user()->theme == 2)
        <link href="{{ asset('public/css/doctors/darkstyle.css') }}" rel="stylesheet" />
    @else
        <link href="{{ asset('public/css/doctors/greenstyle.css') }}" rel="stylesheet" />
    @endif
    <link href="{{ asset('public/css/doctors/followup.css?v2.0.1') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/doctors/requisition.css?v2.0.1') }}" rel="stylesheet" />
    <style media="screen">
    @media only screen and (max-width: 500px) {
         .historyWrapper{
             padding: 0;
        }
    }
    </style>
@endsection



@section('header')
    @include('doctors.navigation')
@stop



@section('content')
    @component('doctors/dashboard')
        @section('main-content')


            <div class="content-wrapper" style="padding: 55px 10px 0px 10px;">
                <div class="container-fluid followupWrapper">
                    
                    @include('doctors.requisition.patientName')
                    
                        <div class="col-md-4 col-sm-4 bg-danger followUpContainer">
                            <h3 class="text-center">Follow-Up <i class="fa fa-calendar text-success"></i></h3>
                            <br>
                            <br>
                            <form action="{{ (isset($followup))? url('followup/'.$followup->id) : url('followup') }}" method="post">
                                {{ csrf_field() }}
                                @if(isset($followup))
                                    {{ method_field('PATCH') }}
                                @endif

                                <div class="form-group">
                                    <label for="">Reasons for Follow-Up</label>
                                    <small class="pull-right text-warning" style="font-size: 10px">(Optional Field)</small>
                                    <textarea name="reason" id="" cols="30" rows="4" class="form-control" placeholder="Type your reasons here...">{{ (isset($followup))? $followup->reason : '' }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="">Medical Clinic / Department *</label>
                                    <small class="pull-right text-danger" style="font-size: 10px">(Required Field)</small>
                                    <input type="hidden" name="clinic_code" value="{{ $clinic->id }}" />
                                    <input type="text" class="form-control" value="{{ $clinic->name }}" disabled />
                                </div>

                                <div class="form-group">
                                    <label for="">Assign to Specific Doctor</label>
                                    <small class="pull-right text-warning" style="font-size: 10px">(Optional Field)</small>
                                    <select name="assignedTo" id="" class="form-control">
                                        <option value="">--Select A Doctor--</option>
                                        @if(!empty($doctors))
                                            @foreach($doctors as $doctor)
                                                <option {{ (isset($followup) && $followup->users_id == $doctor->id)? 'selected' : '' }} value="{{ $doctor->id }}">Dr. {{ $doctor->last_name.', '.$doctor->first_name.' '.$doctor->middle_name[0].'.' }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <small class="text-muted" style="font-size: 10px">* Doctors that appear in here are within this clinic only.</small>
                                    <br>
                                </div>

                                <div class="form-group @if ($errors->has('followupdate')) has-error @endif">
                                    <label for="">Follow-Up Date *</label>
                                    <small class="pull-right text-danger" style="font-size: 10px">(Required Field)</small>
                                    <input type="text" name="followupdate" class="form-control" id="datepicker" value="{{ $followup->followupdate or old('followupdate') }}" placeholder="Select a follow-up date"
                                           @if ($errors->has('followupdate')) style="border: 1px solid red" @endif />
                                    @if ($errors->has('followupdate'))
                                        <span class="help-block">
                                            <small class="">{{ $errors->first('followupdate') }}</small>
                                        </span>
                                    @endif
                                </div>

                                <br>
                                <div class="form-group text-right">
                                    <button type="submit" class="btn btn-success">Submit & Save</button>
                                </div>
                            </form>
                        </div>

                        <div class="col-md-8 col-sm-8 historyWrapper">
                            <h3 class="text-center">Follow-Up History <i class="fa fa-history text-success"></i></h3>
                            <br>
                            <div class="table-responsive">
                                <table class="table consultationList">
                                    <thead>
                                        <tr>
                                            <th>PATIENT</th>
                                            <th>CLINIC</th>
                                            <th>FROM_DOCTOR</th>
                                            <th>TO_DOCTOR</th>
                                            <th>REASON</th>
                                            <th>STATUS</th>
                                            <th>FF_DATE</th>
                                            <th>EDIT</th>
                                            <th>DELETE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($followups) > 0)
                                        @foreach($followups as $followup)
                                            @php
                                                $action = ($followup->users_id == Auth::user()->id)? '' : 'disabled onclick="event.preventDefault()"';
                                                $activateEdit = ($followup->users_id == Auth::user()->id)? 'onclick="return confirm('."'Edit this follow-up?'".')"' : '';
                                                $activateDelete = ($followup->users_id == Auth::user()->id)? 'onclick="return confirm('."'Delete this follow-up?'".')"' : '';
                                            @endphp
                                            <tr>
                                                <td>{{ $followup->name }}</td>
                                                <td>{{ $followup->clinic }}</td>
                                                <td>{{ ($followup->fromDoctor)? "DR. $followup->fromDoctor" : 'N/A' }}</td>
                                                <td>{!! ($followup->toDoctor)? "DR. $followup->toDoctor" : '<span class="text-danger">N/A</span>' !!}</td>
                                                <td>{!! ($followup->reason)? $followup->reason : '<span class="text-danger">N/A</span>' !!}</td>
                                                <td>{!! ($followup->status == 'P')? '<span class="text-danger">Pending</span>' : '<span class="text-success">Finished</span>' !!}</td>
                                                <td>{{ Carbon::parse($followup->followupdate)->toFormattedDateString() }}</td>
                                                <td>
                                                    <a href="{{ url('followup/'.$followup->id.'/edit') }}" class="btn btn-info btn-circle" {!! $action !!} {!! $activateEdit !!}
                                                    data-placement="top" data-toggle="tooltip" title="Click to edit">
                                                    <i class="fa fa-pencil"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="{{ url('delete_followup/'.$followup->id) }}" class="btn btn-danger btn-circle" {!! $action !!} {!! $activateDelete !!} data-placement="top" data-toggle="tooltip" title="Click to delete">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="9" class="text-center">
                                                <strong class="text-danger">THERE IS CURRENTLY, NO FOLLOW UP FOR THIS PATIENT!</strong>
                                            </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- .content-wrapper -->




        @endsection
    @endcomponent
@endsection





@section('footer')
@stop



@section('pagescript')
    @include('message.toaster')
    <script src="{{ asset('public/plugins/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('public/plugins/js/modernizr.js') }}"></script>
    <script src="{{ asset('public/plugins/js/jquery.menu-aim.js') }}"></script>
    <script src="{{ asset('public/js/doctors/main.js') }}"></script>

    <script>
        $( function() {
            $( "#datepicker" ).datepicker({
                dateFormat: 'yy-mm-dd',
                minDate: new Date()
            });
        });
    </script>

@stop


@endcomponent
