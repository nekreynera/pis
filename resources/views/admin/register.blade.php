@component('partials/header')

    @slot('title')
        PIS | Register
    @endslot

    @section('pagestyle')
    @stop



    @section('header')
        @include('admin/navigation')
    @stop



    @section('content')
        <form action="{{ url('users') }}" method="post" id="register">
            <div class="container">
                <div class="col-md-4 col-md-offset-4">
                    <div class="row">
                        <h3 class="text-center">CREATE USER</h3>
                        <br/>

                            @include('message.msg')

                            {{ csrf_field() }}

                            <div class="form-group @if($errors->has('last_name')) has-error @endif">
                                <label>Last Name</label>
                                <input type="text" name="last_name" value="{{ old('last_name') }}" class="form-control" placeholder="Enter Last Name" />
                                @if ($errors->has('last_name'))
                                    <span class="help-block">
                                        <strong class="">{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group @if($errors->has('first_name')) has-error @endif">
                                <label>First Name</label>
                                <input type="text" name="first_name" value="{{ old('first_name') }}" class="form-control" placeholder="Enter First Name" />
                                @if ($errors->has('first_name'))
                                    <span class="help-block">
                                        <strong class="">{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Middle Name</label>
                                <input type="text" name="middle_name" value="{{ old('middle_name') }}" class="form-control" placeholder="Enter Middle Name" />
                            </div>

                            <div class="form-group">
                                <label>Clinic / Department / Ward</label>
                                <select class="form-control" name="clinic">
                                    <option value="">--Select Clinic--</option>
                                    @foreach($clinics as $clinic)
                                        @php $oldClinic = (old('clinic') == $clinic->id)? "selected" : "" ;  @endphp
                                        <option {{ $oldClinic }} value="{{ $clinic->id }}">{{ $clinic->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group @if($errors->has('role')) has-error @endif">
                                <label>Role</label>
                                <select class="form-control" name="role">
                                    <option value="">--Select Role--</option>
                                    @foreach($roles as $role)
                                        @php $oldRole = (old('role') == $role->id)? "selected" : "" ;  @endphp
                                        <option {{ $oldRole }} value="{{ $role->id }}">{{ $role->description }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('role'))
                                    <span class="help-block">
                                        <strong class="">{{ $errors->first('role') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group @if($errors->has('med_interns')) has-error @endif">
                                <label>Medical Clerk(Intern)</label>
                                <select class="form-control" name="med_interns">
                                    <option value="no">No</option>
                                    <option value="yes">Yes</option>
                                </select>
                                @if ($errors->has('med_internse'))
                                    <span class="help-block">
                                        <strong class="">{{ $errors->first('med_interns') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group @if($errors->has('username')) has-error @endif">
                                <label>Username</label>
                                <input type="text" name="username" value="{{ old('username') }}" class="form-control" placeholder="Enter Username" />
                                @if ($errors->has('username'))
                                    <span class="help-block">
                                        <strong class="">{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group @if($errors->has('password')) has-error @endif">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Enter Password" />
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong class="">{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" />
                            </div>

                            <div class="form-group">
                                <br/>
                                <button type="submit" class="btn btn-block btn-success">Submit&nbsp; <i class="fa fa-arrow-right"></i></button>
                            </div>

                    </div>
                </div>
            </div>

        </form>

        <br><br>
            

        
    @endsection





    @section('footer')
    @stop



    @section('pagescript')
        @include('message.toaster')
    @stop


@endcomponent
