<div class="col-md-12 col-sm-12">
    <div class="row seletecItemsWrapper">
        <div class="table-responsive tableSelectedItems">
            @include('OPDMS.partials.loader')
            <table class="table table-striped" id="selected-items">
                <thead>
                <tr>
                    <th><i class="fa fa-question"></i></th>
                    <th>ITEM NAME</th>
                    <th>PRICE</th>
                    <th>QTY</th>
                    <th>AMOUNT</th>
                    <th>DISCOUNT</th>
                    <th>NET AMOUNT</th>
                </tr>
                </thead>
                <form id="savependingRequistion" method="POST" action="{{ url('savePendingRequisition') }}">
                    {{ csrf_field() }}
                    <tbody class="selectedItemsTbody">
                        @php
                            $total_amount = 0;
                            $total_discount = 0;
                            $total_net_amount = 0;
                        @endphp
                    @if(count($request) > 0)
                        @foreach($request as $list)
                            <tr data-type="{{$list->item_type}}" data-id-type="{{$list->item_id.'-'.$list->item_type}}">
                                <td class="text-center">
                                    <input type="checkbox" name="selected[]" value="{{$list->item_id}}" checked>
                                    <input type="hidden" name="request_id[]" value="{{$list->request_id}}">
                                    <input type="hidden" name="request_type[]" value="{{$list->item_type}}">
                                </td>
                                <td class="text-capitalize item-name">{{ $list->name }}</td>
                                <td class="text-right item-price">
                                    {{ number_format($list->price, 2, '.', '') }}
                                    <input type="hidden" name="item_price[]" value="{{ number_format($list->price, 2, '.', '') }}">
                                </td>
                                <td class="text-center item-qty">
                                    <input type="number" name="qty[]" value="{{ $list->qty }}"min="1" readonly>
                                </td>
                                    <!-- $discount = $amount * $patient->discount; -->

                                @php
                                    $amount = $list->price * $list->qty;
                                    $discount = 0;
                                    $net_amount = $amount - $discount;

                                    $total_amount+=$amount;
                                    $total_discount+=$discount;
                                    $total_net_amount+=$net_amount;
                                @endphp
                                <td class="text-right item-amount">{{ number_format($amount, 2, '.', '') }}</td>
                                <td class="text-right item-discount">
                                    {{ number_format($discount, 2, '.', '') }}
                                    <input type="hidden" name="item_discount[]" value="{{ number_format($discount, 2, '.', '') }}">
                                </td>
                                <td class="text-right item-net-amount">{{ number_format($net_amount, 2, '.', '') }}</td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </form>

                <tfoot class="selectedItemsTfoot">
                    <tr>
                        <td colspan="4" class="text-right"><b>TOTAL</b></td>
                        <td class="text-right"><b class="total-amount">{{ number_format($total_amount, 2, '.', '') }}</b></td>
                        <td class="text-right"><b class="total-discount">{{ number_format($total_discount, 2, '.', '') }}</b></td>
                        <td class="text-right"><b class="total-net-amount">{{ number_format($total_net_amount, 2, '.', '') }}</b></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<div class="col-md-8 col-sm-8 col-xs-8" style="padding-left: 0px;top: 5px;">
    <p><i class="fa fa-info-circle"></i> <font style="color: red">ICD CODES</font> are <b>required</b> when requesting laboratory services.</p>
</div>
<div class="col-md-4 col-sm-4 col-xs-4 submitRequisition">
    <div class="text-right">

        <!-- <button type="button" name="button" class="btn btn-danger btn-sm cancel"><span class="fa fa-remove"></span> CANCEL</button> -->
        <button type="submit" id="{{ (Auth::user()->clinic == 43)?'selectpamentoption':'savependingRequistionbutton' }}" class="btn btn-success btn-sm"><span class="fa fa-save"></span> SAVE REQUISITION</button>
    </div>
</div>