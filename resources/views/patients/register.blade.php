@component('partials/header')

    @slot('title')
        PIS | Register
    @endslot

    @section('pagestyle')

        <link rel="stylesheet" href="{{ asset('public/AdminLTE/bower_components/select2/dist/css/select2.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('public/AdminLTE/dist/css/AdminLTE.min.css') }}"> <!-- Theme style -->

        <link href="{{ asset('public/css/doctors/patientlist.css') }}" rel="stylesheet" />
         <link href="{{ asset('public/plugins/css/jquery-ui.css') }}" rel="stylesheet" />
         <link href="{{ asset('public/css/patients/register.css') }}" rel="stylesheet" />
         <link href="{{ asset('public/css/patients/address.css') }}" rel="stylesheet" />
         <link href="{{ asset('public/css/patients/referral.css') }}" rel="stylesheet" />
         <link href="{{ asset('public/css/triage/triage_support.css') }}" rel="stylesheet" />
         <link href="{{ asset('public/css/patients/search.css') }}" rel="stylesheet" />
         <style>
            .camera{
                background-color: #ccc;
                padding: 15px;
                margin: 15px;
                border-radius: 5px;
            }
             .camera i{
                font-size: 80px;
             }
         </style>
    @stop



    @section('header')
        @include('patients/navigation')
    @stop



    @section('content')
        <form action="{{ url('patients') }}" method="post" id="registerForm" enctype="multipart/form-data">
            <div class="container">
                <div class="col-md-12">
                    <div class="row">
                        <h3 class="text-center">PATIENT REGISTRATION FORM</h3>
                        <br/>

                            @include('message.msg')

                            @include('message.errors')

                            {{ csrf_field() }}

                            <div class="row">
                                <div class="row col-md-12 " style="margin-top: -10px;">
                                    <div class="col-md-9 text-center">
                                        <label class="error_msg" hidden style="color: red">Data in Lastname and Firstname are required </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group @if ($errors->has('last_name')) has-error @endif">
                                        <label>Last Name</label>
                                        <input type="text" name="last_name" id="last_name" class="form-control names" value="{{ old('last_name') }}" placeholder="Enter Last Name" autofocus />
                                        <input type="hidden" name="users_id" value="{{ Auth::user()->id }}"/>
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
                                        <div class="input-group">
                                            <input type="text" name="first_name" id="first_name" class="form-control names" value="{{ old('first_name') }}" placeholder="Enter First Name" />
                                            <span class="input-group-addon fa fa-search" id="search-button" 
                                                style="background-color: rgb(68, 157, 68);
                                                        border: 1px solid rgb(57, 132, 57);
                                                        color: #fff;
                                                        cursor: pointer;
                                                "></span>
                                        </div>
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
                                        <input type="text" name="middle_name" id="middle_name" class="form-control names" value="{{ old('middle_name') }}" placeholder="Enter Middle Name" required />
                                    </div>
                                </div>

                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label>Suffix</label>
                                        <select class="form-control select" name="suffix">
                                            <option value="">--</option>
                                            <option @if(old('suffix') == 'Jr') selected @endif >Jr</option>
                                            <option @if(old('suffix') == 'Sr') selected @endif >Sr</option>
                                            <option @if(old('suffix') == 'Sra') selected @endif >Sra</option>
                                            <option @if(old('suffix') == 'II') selected @endif >II</option>
                                            <option @if(old('suffix') == 'III') selected @endif >III</option>
                                            <option @if(old('suffix') == 'IV') selected @endif >IV</option>
                                            <option @if(old('suffix') == 'V') selected @endif >V</option>
                                            <option @if(old('suffix') == 'VI') selected @endif >VI</option>
                                        </select>
                                    </div>
                                </div>

                            </div><!-- first row -->

                            <div class="row">

                                <div class="col-md-3">
                                    <div class="form-group @if ($errors->has('birthday')) has-error @endif">
                                        <label>Birthday</label>
                                        <input type="text" name="birthday" class="form-control birthday" id="datepicker" value="{{ old('birthday') }}" 
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
                                        <input type="text" name="age" id="age" class="form-control" value="{{ old('age') }}" placeholder="Age" />
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Sex</label>
                                        <select class="form-control select" name="sex">
                                            <option value="">Select Sex</option>
                                            <option value="M" @if(old('sex') == 'Male') selected @endif >Male</option>
                                            <option value="F" @if(old('sex') == 'Female') selected @endif >Female</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Civil Status</label>
                                        <select class="form-control select" name="civil_status">
                                            <option value="">Select Civil Status</option>
                                            <option @if(old('civil_status') == "New Born") selected @endif >New Born</option>
                                            <option @if(old('civil_status') == 'Child') selected @endif >Child</option>
                                            <option @if(old('civil_status') == 'Single') selected @endif >Single</option>
                                            <option @if(old('civil_status') == 'Married') selected @endif >Married</option>
                                            <option @if(old('civil_status') == 'Common Law') selected @endif >Common Law</option>
                                            <option @if(old('civil_status') == 'Widow') selected @endif >Widow</option>
                                            <option @if(old('civil_status') == 'Separated-Legal') selected @endif >Separated-Legal</option>
                                            <option @if(old('civil_status') == 'Separated-InFact') selected @endif >Separated-InFact</option>
                                            <option @if(old('civil_status') == 'Divorce') selected @endif >Divorce</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group @if ($errors->has('contact_no')) has-error @endif">
                                        <label>Contact Number</label>
                                        <input type="text" name="contact_no" class="form-control" value="{{ old('contact_no') }}" 
                                        placeholder="Enter Contact Number" />
                                        @if ($errors->has('contact_no'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('contact_no') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div><!-- second row -->

                            <div class="row">
                                <div class="{{ (Auth::user()->clinic != 54)? 'col-md-10' : 'col-md-12' }}">
                                    <div class="form-group">
                                        <label>Permanent Address</label>
                                        <input type="text" name="address" class="form-control" id="address" value="{{ old('address') }}" 
                                        placeholder="Please Enter Patient Address"  />
                                    </div>
                                </div>


                                @if(Auth::user()->clinic != 54)

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Referral</label>
                                        <select name="referral" class="form-control select" id="referral">
                                            <option value="no">NO</option>
                                            <option value="yes">YES</option>
                                        </select>
                                    </div>
                                </div>

                                @endif


                            </div>




                              <!--   <div class="camera col-md-2 bg-danger text-center">
                                    <i class="fa fa-camera"></i>
                                </div>
                                <div class="camera col-md-2 bg-info text-center">
                                    <i class="fa fa-hand-pointer-o"></i>
                                </div>
                             -->

                            @include('patients.address')

                            @include('patients.referrals')
                            @include('patients.search')



                            <div class="form-group profileWrapper">
                                <label class="btn btn-file text"
                                       title="Click to upload patient profile">
                                    Upload Patient Profile
                                    <i class="fa fa-user-circle-o"></i>
                                    <input type="file" name="profile" style="display: none;">
                                </label>
                            </div>


                            
                            



                    </div>
                </div>
            </div>


            @if(Auth::user()->clinic != 54)
                @include('triage.triage_support', ['clinics' => $clinics])
            @endif

        </form>
            

            <div class="container">
                <div class="form-group text-right">
                    <!-- <button type="button" class="btn btn-success btn-md" id="search-button"> Search&nbsp; <i class="fa fa-search"></i></button> -->
                    <button type="submit" form="registerForm" class="btn btn-success">Submit&nbsp; <i class="fa fa-arrow-right"></i></button>
                </div>
            </div>

            <br><br>
            

        
    @endsection





    @section('footer')
    @stop



    @section('pagescript')
        
        @include('message.toaster')
        @if($errors->has('barcode'))
            <script>
                toastr.error("{{ $errors->first('barcode') }}");

            </script>
        @elseif($errors->has('hospital_no'))
            <script>
                toastr.error("{{ $errors->first('hospital_no') }}");
            </script>
        @endif
        <script src="{{ asset('public/plugins/js/jquery-ui.min.js') }}"></script>
        <script src="{{ asset('public/js/patients/register.js') }}"></script>
        <script src="{{ asset('public/js/patients/address.js') }}"></script>
        <!-- <script src="{{ asset('public/js/patients/referral.js') }}"></script> -->
        <script src="{{ asset('public/js/patients/search.js') }}"></script>
        <script src="{{ asset('public/js/doctors/ajaxRecords.js') }}"></script>


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
