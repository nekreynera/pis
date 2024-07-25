<div class="pageloaderWrapper col-md-1 bg-danger text-center">
    <img src="{{ asset('public/images/loader.svg') }}" alt="loader" class="img-responsive" />
    <p>Please Wait...</p>
</div>
<style>
	.pageloaderWrapper{
	    position: absolute;
	    z-index:500000;
	    background-color: rgba(0,0,0,.8);
	    color: #fff;
	    border-radius: 5px;
	    padding: 5px;
	    display: none;
	}
</style>