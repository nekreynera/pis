@component('partials/header')

    @slot('title')
        PIS | Pharmacy
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/css/doctors/reset.css') }}" rel="stylesheet" />
    @if(Auth::user()->theme == 2)
        <link href="{{ asset('public/css/doctors/darkstyle.css') }}" rel="stylesheet" />
    @else
        <link href="{{ asset('public/css/doctors/greenstyle.css') }}" rel="stylesheet" />
    @endif
     <link href="{{ asset('public/css/pharmacy/patientrequist.css') }}" rel="stylesheet" />

@endsection



@section('header')
    @include('pharmacy.navigation')
@stop



@section('content')
    @component('pharmacy/dashboard')
        @section('main-content')


            <div class="content-wrapper">
                <br>
                <br>
                <div class="">
                    <h3 class="text-center"> <i class="fa fa-wheelchair"></i> PATIENT REQUISITION</h3>
                </div>
                <div class="">
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                </div>

                <div class="scannerform">
                    <form class="form-horizontal" action="{{ url('setmedicine') }}" method="post">
                      {{ csrf_field() }}
                        <div class="col-md-6 col-md-offset-3">
                          <div class="form-group scaninput">
                            <label for="">scan id or input hospital number</label>
                            <div class="input-group">
                              <input type="text" name="barcode" value="" class="form-control inputbarcode" placeholder="QR.code/Hospital no" autofocus required>
                              <span class="input-group-addon spanbarcode"><i class="fa fa-barcode"></i></span>
                            </div>
                          </div>
                        </div>
                    </form>
                </div>
                    
                
                
            </div> 
            <!-- .content-wrapper -->

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
    <script src="{{ asset('public/js/pharmacy/main.js') }}"></script>
    <!-- <script src="{{ asset('public/js/pharmacy/logs.js') }}"></script> -->
@stop


@endcomponent
