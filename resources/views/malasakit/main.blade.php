@component('partials/header')

  @slot('title')
    EVRMC | MALASAKIT CENTER
  @endslot

  @section('pagestyle')
    <link href="{{ asset('public/css/malasakit/main.css') }}" rel="stylesheet" />
  @endsection

  @section('header')
    @include('malasakit/navigation')
  @endsection

  @section('content')
   <table border="1">
     <thead>
       <tr>
         <th colspan="2">
            Official Receipt/<br>
            Report of Collections <br>
            by Sub-Collector
          </th>
          <th rowspan="2">
            Responsibilty <br>
            Center <br>
            Code
          </th>
          <th rowspan="2">
            Payor 
          </th>
          <th rowspan="2">
            Particulars
          </th>
          <th rowspan="2">
            MFO/PAP
          </th>
          <th colspan="6">
            AMOUNT
          </th>
       </tr>
       <tr>
         <th>
            DATE
          </th>
         <th>
            NUMBER
          </th>
         <th>
            TOTAL <br>
            PER <br>
            OR
          </th>
          <th>
            OTHER <br>
            FEES <br>
            (4020217099)
          </th>
          <th>
            MEDICAL FEES <br>
            - PHYSICAL <br>
            MEDICINE & <br>
             REHABILITATION <br>
             SERVICES <br>
            (4020217009) <br>
          </th>
          <th>
            LABORATORY
          </th>
          <th>
            RADIOLOGY
          </th>
          <th>
            CARDIOLOGY
          </th>
       </tr>
     </thead>
   </table>
  @endsection

  @section('pagescript')
    @include('message/toaster')
    <!-- <script src="{{ asset('public/js/mss/scan.js') }}"></script> -->

  @endsection

@endcomponent
