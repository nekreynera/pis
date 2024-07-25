<div class="col-md-9 col-sm-9 requsitionSelection">

    <div style="margin-bottom: 3px;">
        <form class="form-inline text-right" onsubmit="return false">
            <div class="input-group">
                <input type="text" name="" class="form-control requesition-item-input" id="requesition-item-input" data-search="description" placeholder="Search By Description..." />
                <span class="input-group-addon"><i class="fa fa-search"></i></span>
            </div>
        </form>
    </div>
    <div class="table-responsive tableWrapper">

        <div class="loaderWrapper">
            <img src="{{ asset('public/images/loader.svg') }}" alt="loader" class="img-responsive" />
            <p>Loading...</p>
        </div>

        <table class="table" id="requesition-item-table">

            <thead class="theadRequistion">
                <tr>
                    <th><i class="fa fa-question"></i></th>
                    <th>NAME</th>
                    <th>PRICE</th>
                    <th>STATUS</th>
                </tr>
            </thead>

            <tbody class="selectitemsTbody">

            @if(count($lablist))
                @foreach($lablist as $list)
                    <?php 
                        $checked = '';
                        $color = '';
                        foreach($request as $req):
                            if ($req->item_type == 'laboratory'):
                                if($list->id == $req->item_id):
                                    $checked = 'checked';
                                    $color = 'bg-success';
                                endif;
                            endif;
                        endforeach;
                    ?>
                    <tr class="{{ ($list->status == 'Active')? '' : 'bg-danger' }}{{ $color }}" data-id-type="{{$list->id}}-laboratory" data-type="laboratory">
                        <td class="text-center">
                            <input type="checkbox"  name="select" class="select" value="{{$list->id}}" {{ ($list->status == 'Inactive')? 'disabled' : '' }} {{ $checked }}/>
                        </td>
                        <td class="text-capitalize item-name">
                            {{ $list->name }}
                        </td>
                        <td class="text-right item-price">
                            {{ number_format($list->price, 2, '.', '') }}
                        </td>
                        <td class="text-center item-status">
                            {!! ($list->status == 'Active')?
                            '<span class="text-success">Available</span>' : '<span class="text-danger">Unavailable</span>' !!}
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5" class="text-center">
                        <strong class="text-danger">NO RESULTS FOUND.</strong>
                    </td>
                </tr>
            @endif
            </tbody>

        </table>


    </div>
</div>