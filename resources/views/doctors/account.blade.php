@component('partials/header')

    @slot('title')
        PIS | Edit Account
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/css/doctors/reset.css') }}" rel="stylesheet" />
    @if(Auth::user()->theme == 2)
        <link href="{{ asset('public/css/doctors/darkstyle.css') }}" rel="stylesheet" />
    @else
        <link href="{{ asset('public/css/doctors/greenstyle.css') }}" rel="stylesheet" />
    @endif
    <link href="{{ asset('public/css/doctors/consultation.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/partials/account.css') }}" rel="stylesheet" />
@endsection



@section('header')
    @include('doctors.navigation')
@stop



@section('content')
    @component('doctors/dashboard')
@section('main-content')


    <div class="content-wrapper">
        <br/>
        <br/>

        <div class="container-fluid">
            <h1>Edit Account</h1>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <div class="profileWrapper hidden-xs">
                        @if($user->profile)
                            <img src="{{ asset('public/users/'.$user->profile) }}" alt="" class="img-responsive center-block">
                        @else
                            <i class="fa fa-user-o"></i>
                        @endif
                    </div>
                    <br>
                    <label>Upload Profile</label>
                    <div class="form-group @if($errors->has('image')) has-error @endif">
                        <label class="btn btn-default btn-file" title="Upload image">
                            Choose Image <i class="fa fa-image"></i>
                            <input type="file" name="image" class="upVolunteerImage" form="accountForm" style="display: none;">
                        </label>
                        <span class="fileShowingImage"></span>
                        <p class="maxUpload">Maximum upload file size: 20 MB</p>
                        @if ($errors->has('image'))
                            <span class="help-block">
                                    <strong class="">{{ $errors->first('image') }}</strong>
                            </span>
                        @endif
                    </div>

                </div>
                <div class="col-md-6">
                    <form action="{{ url('update_account') }}" method="post" enctype="multipart/form-data" id="accountForm">
                        {{ csrf_field() }}
                        <div class="form-group @if($errors->has('last_name')) has-error @endif">
                            <label for="">Last Name *</label>
                            <div class="input-group">
                                <input type="text" name="last_name" value="{{ $user->last_name or old('last_name') }}" class="form-control"
                                       placeholder="Enter Last Name" />
                                <span class="input-group-addon addonIcon" id="usernameaddon">
                                    <i class="fa fa-user"></i>
                                </span>
                            </div>
                            @if ($errors->has('last_name'))
                                <span class="help-block">
                                    <strong class="">{{ $errors->first('last_name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group @if($errors->has('first_name')) has-error @endif">
                            <label for="">First Name *</label>
                            <div class="input-group">
                                <input type="text" name="first_name" value="{{ $user->first_name or old('first_name') }}" class="form-control"
                                       placeholder="Enter First Name" />
                                <span class="input-group-addon addonIcon" id="usernameaddon">
                                    <i class="fa fa-user"></i>
                                </span>
                            </div>
                            @if ($errors->has('first_name'))
                                <span class="help-block">
                                    <strong class="">{{ $errors->first('first_name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group @if($errors->has('middle_name')) has-error @endif">
                            <label for="">Middle Name *</label>
                            <div class="input-group">
                                <input type="text" name="middle_name" value="{{ $user->middle_name or old('middle_name') }}" class="form-control"
                                       placeholder="Enter Middle Name" />
                                <span class="input-group-addon addonIcon" id="usernameaddon">
                                    <i class="fa fa-user"></i>
                                </span>
                            </div>
                            @if ($errors->has('middle_name'))
                                <span class="help-block">
                                    <strong class="">{{ $errors->first('middle_name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group @if($errors->has('username')) has-error @endif">
                            <label for="">Username *</label>
                            <div class="input-group">
                                <input type="text" name="username" value="{{ $user->username or old('username') }}" class="form-control"
                                       placeholder="Enter Username" />
                                <span class="input-group-addon addonIcon" id="usernameaddon">
                                    <i class="fa fa-user"></i>
                                </span>
                            </div>
                            @if ($errors->has('username'))
                                <span class="help-block">
                                    <strong class="">{{ $errors->first('username') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group @if($errors->has('password')) has-error @endif">
                            <label for="">New Password *</label>
                            <div class="input-group">
                                <input type="password" name="password" class="form-control"
                                       placeholder="Enter Your New Password" />
                                <span class="input-group-addon addonIcon" id="usernameaddon">
                                    <i class="fa fa-lock"></i>
                                </span>
                            </div>
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong class="">{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group @if($errors->has('password_confirmation')) has-error @endif">
                            <label for="">Confirm Password *</label>
                            <div class="input-group">
                                <input type="password" name="password_confirmation" class="form-control"
                                       placeholder="Enter Your Confirmation Password" />
                                <span class="input-group-addon addonIcon" id="usernameaddon">
                                    <i class="fa fa-lock"></i>
                                </span>
                            </div>
                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                    <strong class="">{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group @if($errors->has('oldPassword')) has-error @endif">
                            <label for="">Old Password *</label>
                            <div class="input-group">
                                <input type="password" name="oldPassword" class="form-control"
                                       placeholder="Enter Your Old Password" />
                                <span class="input-group-addon addonIcon" id="usernameaddon">
                                    <i class="fa fa-lock"></i>
                                </span>
                            </div>
                            @if ($errors->has('oldPassword'))
                                <span class="help-block">
                                    <strong class="">{{ $errors->first('oldPassword') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="text-right">
                            <button class="btn btn-default">UPDATE ACCOUNT</button>
                        </div>

                    </form>
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
    <script src="{{ asset('public/plugins/js/form.js') }}"></script>
    <script src="{{ asset('public/plugins/js/modernizr.js') }}"></script>
    <script src="{{ asset('public/plugins/js/jquery.menu-aim.js') }}"></script>
    <script src="{{ asset('public/js/doctors/main.js') }}"></script>
@stop


@endcomponent
