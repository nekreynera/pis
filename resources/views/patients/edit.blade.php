@component('partials/header')

    @slot('title')
        PIS | Register
    @endslot

    @section('pagestyle')
        <link rel="stylesheet" href="{{ asset('public/AdminLTE/bower_components/select2/dist/css/select2.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('public/AdminLTE/dist/css/AdminLTE.min.css') }}"> <!-- Theme style -->

         <link href="{{ asset('public/plugins/css/jquery-ui.css') }}" rel="stylesheet" />
         <link href="{{ asset('public/css/patients/register.css') }}" rel="stylesheet" />
         <link href="{{ asset('public/css/patients/address.css') }}" rel="stylesheet" />
         <link href="{{ asset('public/css/triage/triage_support.css') }}" rel="stylesheet" />
    @stop



    @section('header')
        @include('patients/navigation')
    @stop



    @section('content')

        <form action='{{ url("patients/$patient->id") }}' method="post" id="registerForm">
            <div class="container">
                <div class="col-md-12">
                    <div class="row">
                        <h3 class="text-center">EDIT PATIENT INFORMATION</h3>
                        <br/>

                            @include('message.msg')

                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}

                            <input type="hidden" name="triage" value="{{ $triage->id or '' }}" />
                            <input type="hidden" name="vital_signs" value="{{ $vital_signs->id or '' }}" />

                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group @if ($errors->has('last_name')) has-error @endif">
                                        <label>Last Name</label>
                                        <input type="text" name="last_name" class="form-control names" value="{{ $patient->last_name }}" 
                                        placeholder="Enter Last Name" autofocus />
                                        @if ($errors->has('last_name'))
                                            <span class="help-block">
                                                <strong class="">{{ $errors->first('last_name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group @if ($errors->has('first_name')) has-error @endif">
                                        <label>First Name</label>
                                        <input type="text" name="first_name" class="form-control names" value="{{ $patient->first_name }}" 
                                        placeholder="Enter First Name" />
                                        @if ($errors->has('first_name'))
                                            <span class="help-block">
                                                <strong class="">{{ $errors->first('first_name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Middle Name</label>
                                        <input type="text" name="middle_name" class="form-control names" value="{{ $patient->middle_name }}" 
                                        placeholder="Enter Middle Name" />
                                    </div>
                                </div>

                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label>Suffix</label>
                                        <select class="form-control select" name="suffix">
                                            <option value="">--</option>
                                            <option @if($patient->suffix == 'Jr') selected @endif >Jr</option>
                                            <option @if($patient->suffix == 'Sr') selected @endif >Sr</option>
                                            <option @if($patient->suffix == 'Sra') selected @endif >Sra</option>
                                            <option @if($patient->suffix == 'II') selected @endif >II</option>
                                            <option @if($patient->suffix == 'III') selected @endif >III</option>
                                            <option @if($patient->suffix == 'IV') selected @endif >IV</option>
                                            <option @if($patient->suffix == 'V') selected @endif >V</option>
                                            <option @if($patient->suffix == 'VI') selected @endif >VI</option>
                                        </select>
                                    </div>
                                </div>

                            </div><!-- first row -->

                            <div class="row">

                                <div class="col-md-3">
                                    <div class="form-group @if ($errors->has('birthday')) has-error @endif">
                                        <label>Birthday</label>
                                        <input type="text" name="birthday" class="form-control birthday" id="datepicker" 
                                        value="{{ $patient->birthday }}" 
                                        placeholder="Enter Patient Birthday" />
                                        @if ($errors->has('birthday'))
                                            <span class="help-block">
                                                <strong class="">{{ $errors->first('birthday') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label>Age</label>
                                        <input type="text" name="age" id="age" class="form-control" value="{{ $patient->age }}" 
                                        placeholder="Age" />
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Sex</label>
                                        <select class="form-control select" name="sex">
                                            <option value="">Select Sex</option>
                                            <option value="M" @if($patient->sex == 'M') selected @endif >Male</option>
                                            <option value="F" @if($patient->sex == 'F') selected @endif >Female</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Civil Status</label>
                                        <select class="form-control select" name="civil_status">
                                            <option value="">Select Civil Status</option>
                                            <option @if($patient->civil_status == 'Single') selected @endif >
                                                Single
                                            </option>
                                            <option @if($patient->civil_status == 'Married') selected @endif >
                                                Married
                                            </option>
                                            <option @if($patient->civil_status == 'Common Law') selected @endif >
                                                Common Law
                                            </option>
                                            <option @if($patient->civil_status == 'Widow') selected @endif >
                                                Widow
                                            </option>
                                            <option @if($patient->civil_status == 'Separated-Legal') selected @endif >
                                                Separated-Legal
                                            </option>
                                            <option @if($patient->civil_status == 'Separated-InFact') selected @endif >
                                                Separated-InFact
                                            </option>
                                            <option @if($patient->civil_status == 'Divorce') selected @endif >
                                                Divorce
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group @if ($errors->has('contact_no')) has-error @endif">
                                        <label>Contact Number</label>
                                        <input type="text" name="contact_no" class="form-control" value="{{ $patient->contact_no }}" 
                                        placeholder="Enter Contact Number" />
                                        @if ($errors->has('contact_no'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('contact_no') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                            </div><!-- second row -->
                            @if(Auth::user()->clinic != 54)
                            <div class="row">
                                <div class="@if(Carbon::parse($patient->created_at)->format('m-d-Y') >= Carbon::parse()->now()->format('m-d-Y')) 
                                                col-md-10
                                            @else
                                                col-md-12
                                            @endif">
                                    <div class="form-group">
                                        <label>Permanent Address</label>
                                        <input type="text" name="address" class="form-control" id="address" value="{{ $patient->address }}" 
                                        placeholder="Please Enter Patient Address"  />
                                    </div>
                                </div>
                                @if(Carbon::parse($patient->created_at)->format('m-d-Y') >= Carbon::parse()->now()->format('m-d-Y'))
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Referral</label>
                                            <select name="referral" class="form-control select" id="referral">
                                                <option value="no" @if(!$referral) selected @endif>NO</option>
                                                <option value="yes" @if($referral) selected @endif>YES</option>
                                            </select>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            @else
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Permanent Address</label>
                                        <input type="text" name="address" class="form-control" id="address" value="{{ $patient->address }}" 
                                        placeholder="Please Enter Patient Address"  />
                                    </div>
                                </div>
                            </div>
                            @endif

                            @include('patients.address')

                    </div>
                </div>
            </div>


            
            
            @if(Auth::user()->clinic != 54)
            @include('triage.edit_triage_support', ['clinics' => $clinics, 'triage' => $triage, 'vital_signs' => $vital_signs])
            @endif

        </form>
            

            <div class="container">
                <div class="form-group text-right">
                    <button type="submit" form="registerForm" class="btn btn-success">Update&nbsp; <i class="fa fa-arrow-right"></i></button>
                </div>
            </div>

            <br><br>
            

        
    @endsection





    @section('footer')
    @stop



    @section('pagescript')
        @include('message.toaster')
        <script src="{{ asset('public/plugins/js/jquery-ui.min.js') }}"></script>
        <script src="{{ asset('public/js/patients/register.js') }}"></script>
        <script src="{{ asset('public/js/patients/address.js') }}"></script>

        <script src="{{ asset('public/AdminLTE/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
        <script src="{{ asset('public/AdminLTE/dist/js/adminlte.min.js') }}"></script>


        <script>
            $(function () {
                //Initialize Select2 Elements
                $('.select2').select2();
            });
        </script>

        @if ($errors->has('province') || $errors->has('region'))
            <script>
                $("#addressModal").modal("show");
            </script>
        @endif
    @stop


@endcomponent
