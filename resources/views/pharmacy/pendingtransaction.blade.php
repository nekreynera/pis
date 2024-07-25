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
    <link href="{{ asset('public/css/pharmacy/pendingtransaction.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/plugins/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />

@endsection



@section('header')
    @include('pharmacy.navigation')
@stop



@section('content')
    @component('pharmacy/dashboard')
        @section('main-content')


            <div class="content-wrapper transaction">
                <br>
                <div class="banner">
                    <h3 class="text-left"> <i class="fa fa-exchange"></i> MANAGED TRANSACTIONS</h3>
                </div>
                <div class="">
                    <br>
                </div>
                <div class="table table-responsive content-medicine">
                    <table class="table table-striped table-bordered" id="transaction">
                        <thead>
                            <tr>
                                <th hidden></th>
                                <th>CLASSIFICATION & OR#</th>
                                <th style="min-width: 150px;">NAME OF PATIENT</th>
                                <th style="min-width: 150px;">GENERIC NAME</th>
                                <th style="min-width: 100px;">BRAND</th>
                                <th>PRICE</th>
                                <th>QTY</th>
                                <th>EDIT</th>
                                <th>REMOVE</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaction as $list)
                            <tr class="logs-info">
                              <td hidden></td>
                              <td align="center">{{ $list->label.'-'.$list->description}}@if(is_numeric($list->description)){{'%'}}@endif</td>
                              <td>{{ $list->name }}</td>
                              <td>{{ $list->item_description }}</td>
                              <td>{{ $list->brand }}</td>
                              <td align="right">{{ number_format($list->price, 2, '.', ',') }}</td>
                              <form class="submitqty" id="{{ $list->id }}" method="post">
                                 {{ csrf_field() }}                           
                                <td align="center" ><p class="tdqty" id="qtyid{{ $list->id }}">{{ $list->qty }}</p><input type="hidden" name="qty[]" class="form-control qtye" id="qtyinput{{ $list->id }}"></td>
                              </form>
                              <td align="center"><a href="#" class="btn btn-default edit" data-toggle="tooltip" data-placement="top" title="EDIT ITEM"><span class="fa fa-pencil"></span></a></td>
                              <td align="center"><a href="#" class="btn btn-default remove" data-toggle="tooltip" data-placement="top" title="CANCEL" id="{{ $list->id }}"><span class="fa fa-remove"></span></a></td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
            </div> 

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
    <script src="{{ asset('public/js/pharmacy/pendingtransaction.js') }}"></script>
@stop


@endcomponent
