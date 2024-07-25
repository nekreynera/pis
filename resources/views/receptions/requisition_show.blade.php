@component('partials/header')

    @slot('title')
        PIS | Requisition Details
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/css/doctors/preview.css') }}" rel="stylesheet" />
@stop


@section('header')
    @include('receptions.navigation')
@stop



@section('content')

    <div class="container-fluid">
        <div class="container">
            <br>

            <div class="row">
                <div class="col-md-10">
                    <h2 class="text-left" style="margin: 0">Requisition Details</h2>
                </div>
                <div class="col-md-2 text-right">
                    <a href="{{ url('requisition_print/'.$requisition->id) }}" target="_blank" class="btn btn-default text-success">
                        <i class="fa fa-print text-success"></i> <span class="text-success">Print</span>
                    </a>
                </div>
            </div>

            <br>
            @if($requisitions)
                <div class="table-responsive requisitionTable">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>ITEM ID</th>
                            <th>ITEM DECSRIPTION</th>
                            <th>BRAND</th>
                            <th>QTY</th>
                            <th>PRICE</th>
                            <th>UNIT</th>
                            <th>STATUS</th>
                            <th>REQUISITION DATE</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($requisitions as $requisition)
                            <tr>
                                <td class="item_id">
                                    {{ $requisition->item_id }}
                                </td>
                                <td class="item_description">
                                    {{ $requisition->item_description }}
                                </td>
                                <td class="item_brand">
                                    {!! ($requisition->brand)? $requisition->brand : '<span class="text-danger">N/A</span>' !!}
                                </td>
                                <td>
                                    {{ $requisition->qty }}
                                </td>
                                <td class="price">
                                    {{ $requisition->price }}
                                </td>
                                <td class="unitofmeasure">
                                    {!! ($requisition->unitofmeasure)? $requisition->unitofmeasure : '<span class="text-danger">N/A</span>' !!}
                                </td>
                                <td>
                                    {!! ($requisition->status == 'Y')? '<span class="text-success">Available</span>' : '<span class="text-danger">Unavailable</span>' !!}
                                </td>
                                <td>
                                    {{ Carbon::parse($requisition->requisitionDate)->toFormattedDateString() }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            @endif
        </div>
    </div>



@endsection



@section('footer')
@stop



@section('pagescript')
    @include('message.toaster')
@stop


@endcomponent
