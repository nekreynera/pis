@component('partials/header')

  @slot('title')
    PIS | MSS
  @endslot

  @section('pagestyle')
    <link href="{{ asset('public/css/mss/scan.css') }}" rel="stylesheet" />
  @endsection

  @section('header')
    @include('mss/navigation')
  @endsection

  @section('content')
    <div class="container">
      <form class="form-horizontal" action="{{ url('classification') }}" method="post">
        {{ csrf_field() }}
          <h3 class="text-center">MSWD Assessment Tool <i class="fa fa-check-square-o"></i></h3>
          <div class="col-md-6 col-md-offset-3">
            <div class="form-group scaninput">
              <label for="">SCAN BARCODE</label>
              <div class="input-group">
                <input type="text" name="barcode" value="" class="form-control inputbarcode" autofocus placeholder="Barcode/Hospital no">
                <span class="input-group-addon spanbarcode"><i class="fa fa-barcode"></i></span>
              </div>
            </div>
          </div>
      </form>
    </div>
  @endsection

  @section('pagescript')
    @include('message/toaster')
    <script src="{{ asset('public/js/mss/scan.js') }}"></script>

  @endsection

@endcomponent
