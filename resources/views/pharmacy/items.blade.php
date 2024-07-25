@component('partials/header')

  @slot('title')
    PIS | Pharmacy
  @endslot

  @section('pagestyle')
    <link href="{{ asset('public/css/pharmacy/items.css') }}" rel="stylesheet" />
  @endsection

  @section('header')
    @include('pharmacy/navigation')
  @endsection

  @section('content')
    asas
  @endsection

  @section('pagescript')
    @include('message/toaster')
    <script src="{{ asset('public/js/pharmacy/items.js') }}"></script>

  @endsection

@endcomponent
