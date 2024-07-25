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
    <link href="{{ asset('public/css/pharmacy/inventory.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/plugins/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />

@endsection



@section('header')
    @include('pharmacy.navigation')
@stop



@section('content')
    @component('pharmacy/dashboard')
        @section('main-content')


           <div class="content-wrapper inventory">
              <br>
              <div class="banner">
                  <h3 class="text-left"> <i class="fa fa-cubes"></i> INVENTORY</h3>
                  <div class="pull-right" style="margin-top: -10px;">
                      <span style="background-color: #00e600;color: white;padding: 3px;font-weight: bold;">&nbsp;ACTIVE&nbsp;</span>
                      <span style="background-color: orange;color: white;padding: 3px;font-weight: bold;">&nbsp;INACTIVE&nbsp;</span>
                      <span style="background-color: red;color: white;padding: 3px;font-weight: bold;">&nbsp;DELETED&nbsp;</span>
                      <!-- <span style="background-color: yellow;color: black;padding: 3px;font-weight: bold;">&nbsp;REQUEST&nbsp;</span> -->
                      
                  </div>
              </div>
              <div class="">
                  <br>
              </div>
              <div class="table table-responsive content-inventory">
                  <table class="table table-striped table-bordered" id="inventory">
                      <thead>
                          <tr>
                              <th hidden></th>
                              <th width="10px" style="padding: 0px;"></th>
                              <th>BRAND</th>
                              <th>NAME/DESCRIPTION</th>
                              <th>UNIT OF MEASURE</th>
                              <th>PRICE</th>
                              <th>EXPIRATION DATE</th>
                              <th>STOCK</th>
                            
                              <th>INFO</th>
                             
                          </tr>
                      </thead>
                      <tbody>
                            @foreach($inventory as $list)
                            @if($list->trash == "Y")
                            <tr class="danger">
                            @else
                            <tr>
                            @endif
                                <td hidden></td>
                                @if($list->trash == "Y")
                                <td width="10px" style="padding: 0px;background-color: #ff3333">&nbsp;</td>
                                @else
                                  @if($list->status == "Y")
                                  <td width="10px" style="padding: 0px;background-color: #00cc44">&nbsp;</td>
                                  @else
                                  <td width="10px" style="padding: 0px;background-color: #ff6600">&nbsp;</td>
                                  @endif
                                @endif
                                <td>{{ $list->brand }}</td>
                                <td>{{ $list->item_description }}</td>
                                <td>{{ $list->unitofmeasure }}</td>
                                <td>{{ number_format($list->price, 2, '.', ',') }}</td>
                                <td>{{ $list->expire_date }}</td>
                                <td>{{ ($list->stock)?"$list->stock":"0" }}</td>
                                
                                <td>{{ ($list->status == 'Y')?"ACITVE":"INACTIVE" }}</td>
                            </tr>
                            @endforeach
                         
                      </tbody>
                  </table>
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
    <script src="{{ asset('public/plugins/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/plugins/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/js/pharmacy/inventory.js') }}"></script>
@stop


@endcomponent
