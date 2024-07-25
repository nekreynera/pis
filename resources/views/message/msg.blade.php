@if(Session::has('danger'))
    <div class="alert alert-danger fade in text-center">
    	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>{{ Session::get('danger') }}</strong>
    </div>
@endif

@if(Session::has('success'))
    <div class="alert alert-success fade in text-center">
    	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>{{ Session::get('success') }}</strong>
    </div>
@endif