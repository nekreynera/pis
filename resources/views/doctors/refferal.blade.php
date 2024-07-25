@component('partials/header')

    @slot('title')
        PIS | Refferal
    @endslot

@section('pagestyle')
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
                    <h3 class="text-center">Referral <i class="fa fa-share-square-o text-success"></i></h3>
                    <br>
                    <br>
                    <form action="{{ (isset($refferal))? url('refferal/'.$refferal->id) : url('refferal') }}" method="post">
                        {{ csrf_field() }}
                        @if(isset($refferal))
                            {{ method_field('PATCH') }}
                        @endif

                        <div class="form-group">
                            <label for="">Reasons for Refferal</label>
                            <small class="pull-right text-warning" style="font-size: 10px">(Optional Field)</small>
                            <textarea name="reason" id="" cols="30" rows="5" class="form-control" placeholder="Type your reasons here...">{{ (isset($refferal))? $refferal->reason : '' }}</textarea>
                        </div>

                        <div class="form-group @if ($errors->has('to_clinic')) has-error @endif">
                            <label for="">Medical Clinic / Department *</label>
                            <small class="pull-right text-danger" style="font-size: 10px">(Required Field)</small>
                            <select name="to_clinic" id="clinic" class="form-control clinic_code" @if ($errors->has('to_clinic')) style="border: 1px solid red" @endif>
                                <option value="">--Select A Clinic / Department--</option>
                                @foreach($clinics as $clinic)
                                    <option value="{{ $clinic->id }}" {{ (isset($refferal) && $refferal->to_clinic == $clinic->id)? 'selected' : '' }}>{{ $clinic->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('to_clinic'))
                                <span class="help-block">
                                    <small class="">{{ $errors->first('to_clinic') }}</small>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="">Assign to Specific Doctor</label>
                            <small class="pull-right text-warning" style="font-size: 10px">(Optional Field)</small>
                            <select name="assignedTo" id="doctor" class="form-control selectDoctor">
                                <option value="" class="">--Select A Doctor--</option>
                                @if(isset($users))
                                    @foreach($users as $user)
                                        <option class="" {{ (isset($refferal) && $refferal->assignedTo == $user->id)? 'selected value="'.$user->id.'"' : '' }}>
                                            {{ $user->last_name.', '.$user->first_name.' '.$user->middle_name[0].'.' }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            <small class="text-danger errorshow">Please select a clinic / department first.</small>
                        </div>

                        <br>

                        <div class="form-group text-right">
                            <button class="btn btn-success">Submit & Save</button>
                        </div>

                    </form>
                </div>

                <div class="col-md-8 col-sm-8 historyWrapper">
                    <h3 class="text-center">Referral History <i class="fa fa-history text-success"></i></h3>
                    <br>

                    <div class="table-responsive">
                        <table class="table consultationList">
                            <thead>
                            <tr>
                                <th>FROM_CLINIC</th>
                                <th>FROM_DOCTOR</th>
                                <th>TO_CLINIC</th>
                                <th>TO_DOCTOR</th>
                                <th>REASON</th>
                                <th>STATUS</th>
                                <th>DATE</th>
                                <th>EDIT</th>
                                <th>DELETE</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($refferals) > 0)
                                @foreach($refferals as $refferal)
                                    @php
                                        $action = ($refferal->users_id == Auth::user()->id && $refferal->status == 'P')? '' : 'disabled onclick="event.preventDefault()"';
                                        $activateEdit = ($refferal->users_id == Auth::user()->id && $refferal->status == 'P')? 'onclick="return confirm('."'Edit this refferal?'".')"' : '';
                                        $activateDelete = ($refferal->users_id == Auth::user()->id && $refferal->status == 'P')? 'onclick="return confirm('."'Delete this refferal?'".')"' : '';
                                    @endphp
                                    <tr>
                                        <td>{{ $refferal->fromClinic }}</td>
                                        <td>{{ ($refferal->fromDoctor)? "DR. $refferal->fromDoctor" : 'N/A' }}</td>
                                        <td>{{ ($refferal->toClinic)? $refferal->toClinic : 'N/A' }}</td>
                                        <td>{!! ($refferal->toDoctor)? "DR. $refferal->toDoctor" : '<span class="text-danger">N/A</span>' !!}</td>
                                        <td>{!! ($refferal->reason)? $refferal->reason : '<span class="text-danger">N/A</span>' !!}</td>
                                        <td>{!! ($refferal->status == 'P')? '<span class="text-danger">Pending</span>' : '<span class="text-success">Finished</span>' !!}</td>
                                        <td>{{ Carbon::parse($refferal->created_at)->toFormattedDateString() }}</td>
                                        <td>
                                            <a href="{{ url('refferal/'.$refferal->id.'/edit') }}" {!! $action !!} {!! $activateEdit !!} class="btn btn-info btn-circle"
                                               data-placement="top" data-toggle="tooltip" title="Click to edit" >
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ url('delete_refferal/'.$refferal->id) }}" {!! $action !!} {!! $activateDelete !!} class="btn btn-danger btn-circle"
                                               data-placement="top" data-toggle="tooltip" title="Click to delete" >
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="10" class="text-center">
                                        <strong class="text-danger">THERE IS CURRENTLY, NO REFFERALS FOR THIS PATIENT!</strong>
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
    <script src="{{ asset('public/plugins/js/modernizr.js') }}"></script>
    <script src="{{ asset('public/plugins/js/jquery.menu-aim.js') }}"></script>
    <script src="{{ asset('public/js/doctors/main.js') }}"></script>
    <script src="{{ asset('public/js/doctors/refferal.js') }}"></script>
@stop


@endcomponent
