@component('partials/header')

    @slot('title')
        PIS | Login
    @endslot

    @section('pagestyle')
        <link href="{{ asset('public/css/partials/login.css') }}" rel="stylesheet" />
    @stop



    @section('header')
    @stop



    @section('content')
    <div class="container-fluid loginWrapper">
        <div class="container">
            <div class="row">
                <div class=" col-md-3 logoWrapper">
                    <a href="https://evrmc.doh.gov.ph/" target="_blank" title="Official Eastern Visayas Medical Center Website" >
                        <img src="{{ asset('public/images/evrmc-logo.png') }}" class="img-responsive" />
                    </a>
					<img src="{{ asset('public/images/hem-doh.png') }}" class="img-responsive" />
                </div>
                <div class="col-md-9 loginBannerTitle">
                    <h3>EVMC - Philippine Emergency Medical Assistance Team</h3>
                    <h1>PEMAT INFORMATION SYSTEM (PIS)</h1>
                </div>
            </div>

            <br/>
            <br/>
            <br/>

            <div class="row">
				<div class="col-md-6">
					<img src="{{ asset('public/images/login_sideimage.png') }}" class="img-responsive" alt="Philippine Emergency Medical Assistance Team" />
				</div>
                <div class="col-md-6">
                    <form action="{{ url('login') }}" method="post">
						<div class="container">
							<div class="col-md-4">
								<div class="row">
									<h1 class="text-center">Secure Login</h1>
									<br/>

										@include('message.msg')

										{{ csrf_field() }}

										<div class="form-group @if($errors->has('username')) has-error @endif">
											<div class="input-group">
												<input type="text" name="username" value="{{ old('username') }}" class="form-control"
												placeholder="Enter Username" aria-describedby="usernameaddon" autofocus />
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

										<br/>

										<div class="form-group @if($errors->has('password')) has-error @endif">
											<div class="input-group">
											<input type="password" name="password" class="form-control" placeholder="Enter Password"
											aria-describedby="passwordaddon" />
											<span class="input-group-addon addonIcon" id="emailaddon">
													<i class="fa fa-lock"></i>
												</span>
											</div>
											@if ($errors->has('password'))
												<span class="help-block">
													<strong class="">{{ $errors->first('password') }}</strong>
												</span>
											@endif
										</div>

										<div class="form-group">
											<br/>
											<button type="submit" class="btn btn-block btn-default">
												Login <i class="fa fa-sign-in"></i>
											</button>
										</div>

								</div>
							</div>
						</div>
					</form>
                </div>
			
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

<script>


</script>