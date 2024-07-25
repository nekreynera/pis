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
     

@endsection



@section('header')
    @include('pharmacy.navigation')
@stop



@section('content')
    @component('pharmacy/dashboard')
        @section('main-content')


            <div class="content-wrapper">
                <br>
                <div class="banner">
                    <h3 class="text-left"> <i class="fa fa-user-md"></i> MANAGE REQUEST</h3>
                </div>
                <div class="">
                    <br>
                    <br>
                    <br>
                </div>
                <div class="col-md-6" style="padding: 0px;">
                    <table class="table table-condensed">
                        <tr>
                            <td><b>NAME: </b> {{ $patient->first_name.' '.$patient->middle_name.' '.$patient->last_name }}</td>

                        </tr>
                        <tr>
                            <td><b>AGE: </b> {{ $patient->age }}</td>
                            
                        </tr>
                        <tr>
                            @if(is_numeric($patient->description))
                            <td><b>CLASSIFICATION: </b> {{ $patient->label.'-'.$patient->description }}%</td>
                            @else
                            <td><b>CLASSIFICATION: </b> {{ $patient->label.'-'.$patient->description }}</td>
                            @endif
                            
                        </tr>
                    </table>
                </div>
                <div class="col-md-6" style="padding: 0px;">
                    
                     
                    <table class="table table-condensed">
                        <tr>
                            <td><b>GENDER: </b> {{ ($patient->sex=='M')? 'MALE':'FEMALE' }}</td>

                        </tr>
                        <tr>
                            <td><b>ADDRESS: </b> {{ $patient->address }}</td>
                            
                        </tr>
                        <tr>
                            <td><b>REQUEST BY: </b>DR. {{ $doctor }}</td>
                            
                        </tr>
                    </table>
                </div>
                <form class="managerequest" method="post" action="{{ url('saverequest') }}">
                   {{ csrf_field() }}
                   <div class="tobesubmit">
                    <input type="hidden" name="mss_id" value="{{ $patient->mss_id }}">
                    <div class="contents">
                    </div>
                   </div>
                <div class="col-md-12 tables">
                    <div class="table-banner text-right">
                        <h4 class="pull-left"> <i class="fa fa-list"> List of Request</i> </h4>
                        <a href="{{ url('managerequest') }}" class="btn btn-default btn-sm">Cancel <i class="fa fa-backward"></i></a>
                        <button type="submit" class="btn btn-success submitbutton" disabled>Save <span class="fa fa-save"></span></button>
                    </div>
                    <div class="table-responsive">
                       <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th><input type="checkbox" name="" class="th-check"></th>
                                <th>ITEM BRAND</th>
                                <th>ITEM NAME</th>
                                <th>PRICE</th>
                                <th>RQSTD QTY</th>
                                <th width="120px">RMNG QTY</th>
                                <th width="120px">MANAGE</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($medicine) > 0)
                            @foreach($medicine as $list)
                            @if($list->error)
                            <tr class="danger">
                                <td align="center"><input type="checkbox" name="" class="" disabled></td>
                            @else
                            <tr>
                                <td align="center"><input type="checkbox" name="" class="td-check"></td>
                            @endif

                                <td>{{ $list->brand }}<input type="hidden" name="" value="{{ $list->id }}" class="item_id"></td>
                                <td>{{ $list->item_description }}<input type="hidden" name="" value="{{ $list->anc_id }}" class="anc_id"></td>
                                <td align="right" class="price">{{ number_format($list->price, 2, '.', ',') }}</td>
                                <td align="center">{{ $list->rqty }}</td>
                                <td class="qtyt">
                                    @if($list->error)
                                        {{ $list->error }}
                                    @else
                                        {{ $list->qty }}
                                    @endif
                                    @if($list->ramaining)
                                         <span class="ramaining" data-toggle="tooltip" data-placement="top" title="{{ $list->ramaining }} REMAINING STOCK">{{ $list->ramaining }}</span>
                                    @endif
                                </td>
                                <td><input type="number" name="manage" class="form-control manage" value="@if($list->error){{0}}@elseif($list->ramaining){{$list->ramaining}}@else{{$list->qty}}@endif" readonly style="cursor: not-allowed;"></td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="7" class="danger" align="center" height="100px">NO REQUESITION FOUND</td>
                            </tr>
                            @endif
                            
                        </tbody>
                           
                            
                           
                       </table> 
                    </div>
                </div>
                </form>
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
    <script src="{{ asset('public/js/pharmacy/managerequest.js') }}"></script>
   
@stop


@endcomponent
