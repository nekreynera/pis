@component('partials/header')

    @slot('title')
        PIS | Requisition Show
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/css/doctors/reset.css') }}" rel="stylesheet" />
    @if(Auth::user()->theme == 2)
        <link href="{{ asset('public/css/doctors/darkstyle.css') }}" rel="stylesheet" />
    @else
        <link href="{{ asset('public/css/doctors/greenstyle.css') }}" rel="stylesheet" />
    @endif
    <link href="{{ asset('public/css/doctors/preview.css') }}" rel="stylesheet" />
@endsection



@section('header')
    @include('doctors.navigation')
@stop



@section('content')
    @component('doctors/dashboard')
@section('main-content')


    <div class="content-wrapper">
        <div class="container-fluid">
            <br>
            <div class="previewHeaderWrapper">
                <div class="col-md-12 text-center">
                    <h2>Requisition Details</h2>
                    <br><br>
                </div>
                <h3><small>PATIENT NAME:</small> {{ $patient->last_name.', '.$patient->first_name.' '.$patient->middle_name[0].'.' }}</h3>
                <div class="pull-right" style="display: inline">
                    @php
                        $action = ($requisition->users_id == Auth::user()->id || $checkIfForApproval)? '' : 'disabled onclick="event.preventDefault()"';
                        $activateEdit = ($requisition->users_id == Auth::user()->id || $checkIfForApproval)? 'onclick="return confirm('."'Edit this Requisition?'".')"' : '';
                        $activateDelete = ($requisition->users_id == Auth::user()->id)? 'onclick="return confirm('."'Delete this Requisition?'".')"' : '';
                    @endphp
                    <a href="{{ url('requisition_print/'.$requisition->id) }}" target="_blank" class="btn btn-default">
                        <span class="text-success">PRINT</span> <i class="fa fa-print text-success"></i>
                    </a>
                    @if(!$hideEdit)
                        <a href="{{ url('requisition/'.$requisition->id.'/edit') }}" {!! $action !!} class="btn btn-default" {!! $activateEdit !!}>
                            <span class="text-primary">EDIT</span> <i class="fa fa-pencil text-primary"></i>
                        </a>
                    @endif
                    {{--<a href="{{ url('requisitiondelete/'.$requisition->id) }}" {!! $action !!} class="btn btn-default" {!! $activateDelete !!}>
                        <span class="text-danger">DELETE</span> <i class="fa fa-trash text-danger"></i>
                    </a>--}}
                </div>
            </div>

            <br>
            <br>


            @if($requisitions)
                <div class="table table-responsive requisitionTable">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ITEM ID</th>
                                <th>ITEM DECSRIPTION</th>
                                <th>BRAND</th>
                                <th>QTY RENDERED</th>
                                <th>QTY</th>
                                <th>PRICE</th>
                                <th>UNIT</th>
                                {{--<th>STATUS</th>--}}
                                <th>REQUISITION DATE</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($requisitions as $requisition)
                                <tr>
                                    <td class="item_id">
                                        {{ $requisition[0]->item_id }}
                                    </td>
                                    <td class="item_description">
                                        {{ $requisition[0]->item_description }}
                                    </td>
                                    <td class="item_brand">
                                        {!! ($requisition[0]->brand)? $requisition[0]->brand : '<span class="text-danger">N/A</span>' !!}
                                    </td>
                                    <td>
                                        <span class="text-danger">{{ $requisition[0]->pharQTY or 0 }}</span>
                                    </td>
                                    <td>
                                        {{ $requisition[0]->qty }}
                                    </td>
                                    <td class="price">
                                        &#8369; {!! number_format($requisition[0]->price, 2) !!}
                                    </td>
                                    <td class="unitofmeasure">
                                        {!! ($requisition[0]->unitofmeasure)? $requisition[0]->unitofmeasure : '<span class="text-danger">N/A</span>' !!}
                                    </td>
                                    {{--<td>
                                        {!! ($requisition->status == 'Y')? '<span class="text-success">Available</span>' : '<span class="text-danger">Unavailable</span>' !!}
                                    </td>--}}
                                    <td>
                                        {{ Carbon::parse($requisition[0]->requisitionDate)->toFormattedDateString() }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            @endif


        </div>
    </div> <!-- .content-wrapper -->


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
    <script src="{{ asset('public/js/doctors/main.js') }}"></script>
    <script src="{{ asset('public/js/doctors/preview.js') }}"></script>
@stop


@endcomponent
