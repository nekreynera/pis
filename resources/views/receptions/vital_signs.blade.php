@component('partials/header')

    @slot('title')
        PIS | Vital Signs
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/css/patients/register.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/triage/triage_support.css') }}" rel="stylesheet" />
@stop



@section('header')
    @include('receptions.navigation')
@stop



@section('content')
    <div class="container">
        <br/>
        <div class="row">

            <div class="col-md-6 patient_info">
                <h2 class="text-center">PATIENT INFO</h2>
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                        <tr>
                            <td>Name:</td>
                            <td>{{ $patient->last_name.' '.$patient->first_name.' '.$patient->middle_name.' '.$patient->suffix }}</td>
                        </tr>
                        <tr>
                            <td>Hospital:</td>
                            <td>{{ $patient->hospital_no }}</td>
                        </tr>
                        <tr>
                            <td>Barcode:</td>
                            <td>{{ $patient->barcode }}</td>
                        </tr>
                        <tr>
                            <td>Birthday:</td>
                            <td>
                                @if($patient->birthday)
                                    {{ Carbon::parse($patient->birthday)->format('F d, Y') }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Age:</td>
                            <td>25</td>
                        </tr>
                        <tr>
                            <td>Address:</td>
                            <td>{{ $patient->address }}</td>
                        </tr>
                        <tr>
                            <td>Civil Status:</td>
                            <td>{{ $patient->civil_status }}</td>
                        </tr>
                        <tr>
                            <td>Sex:</td>
                            <td>{{ ($patient->sex == 'M')? 'Male' : 'Female' }}</td>
                        </tr>
                        <tr>
                            <td>Contact No:</td>
                            <td>{{ ($patient->contact_no)? $patient->contact_no : 'None' }}</td>
                        </tr>
                        <tr>
                            <td>DateRegistered:</td>
                            <td>{{ Carbon::parse($patient->created_at)->format('F d, Y') }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>



            <div class="col-md-6">
                <h2 class="text-center">VITAL SIGNS</h2>
                <form action="{{ url('storeVitalSigns') }}" method="post">

                    {{ csrf_field() }}

                    <input type="hidden" name="patients_id" value="{{ $patient->id }}" />

                    <div class="form-group @if ($errors->has('clinic_code')) has-error @endif" style="display: none;">
                        <label>Assign Clinic</label>
                        <select name="clinic_code" readonly="" class="form-control select">
                            <option value="">--Select Clinic--</option>
                            @foreach($clinics as $clinic)
                                <option {{  ($clinic->code == $clinicID->code) ? 'selected' : ''}} value="{{ $clinic->code }}">{{ $clinic->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('clinic_code'))
                            <span class="help-block">
                                    <strong class="">{{ $errors->first('clinic_code') }}</strong>
                                </span>
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Blood Pressure</label>
                                <div class="input-group">
                                    <input type="text" name="blood_pressure" class="form-control" value="{{ old('blood_pressure') }}"
                                           placeholder="Enter Blood Pressure" />
                                    <div class="input-group-addon">BP</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Pulse Rate</label>
                                <div class="input-group">
                                    <input type="text" name="pulse_rate" class="form-control" value="{{ old('pulse_rate') }}" placeholder="Enter Pulse Rate" />
                                    <div class="input-group-addon">BPM</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Respiration Rate</label>
                                <div class="input-group">
                                    <input type="text" name="respiration_rate" class="form-control" value="{{ old('respiration_rate') }}"
                                           placeholder="Enter Respiration Rate" />
                                    <div class="input-group-addon">RM</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Body Temperature</label>
                                <div class="input-group">
                                    <input type="text" name="body_temperature" class="form-control" value="{{ old('body_temperature') }}"
                                           placeholder="Enter Body Temperature" />
                                    <div class="input-group-addon">°C</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Weight</label>
                                <div class="input-group">
                                    <input type="text" name="weight" class="form-control" value="{{ old('weight') }}" placeholder="Enter Weight" />
                                    <div class="input-group-addon">KG.</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Height</label>
                                <div class="input-group">
                                    <input type="text" name="height" class="form-control" value="{{ old('height') }}" placeholder="Enter Height" />
                                    <div class="input-group-addon">CM.</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group text-right">
                        <br/>
                        <button type="submit" class="btn btn-success">
                            Submit <i class="fa fa-arrow-right"></i>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection





@section('footer')
@stop



@section('pagescript')
    @include('message.toaster')
@stop


@endcomponent
