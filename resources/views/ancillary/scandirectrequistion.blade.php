@component('partials/header')

    @slot('title')
        PIS | ANCILLARY
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/css/doctors/reset.css') }}" rel="stylesheet" />
    @if(Auth::user()->theme == 2)
        <link href="{{ asset('public/css/doctors/darkstyle.css') }}" rel="stylesheet" />
    @else
        <link href="{{ asset('public/css/doctors/greenstyle.css') }}" rel="stylesheet" />
    @endif
     <link href="{{ asset('public/css/ancillary/scan.css') }}" rel="stylesheet" />

@endsection



@section('header')
    @include('ancillary.navigation')
@stop



@section('content')
    @component('ancillary/dashboard')
        @section('main-content')


            <div class="content-wrapper">
                <br>
                <br>
                <div class="">
                    <h3 class="text-center"> PATIENT REQUISITION</h3>
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
                    <form class="form-horizontal" action="{{ url('scandirect') }}" method="post">
                      {{ csrf_field() }}
                        <div class="col-md-6 col-md-offset-3">
                          <div class="form-group scaninput">
                            <label for="">for direct requistion</label>
                            <div class="input-group">
                              <input type="text" name="barcode" value="" class="form-control inputbarcode" placeholder="BARCODE/HOSPITAL NO" autofocus required>
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
