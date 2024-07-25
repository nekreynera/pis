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
    <link href="{{ asset('public/css/pharmacy/medicine.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/plugins/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />
@endsection



@section('header')
    @include('pharmacy.navigation')
@stop



@section('content')
    @component('pharmacy/dashboard')
        @section('main-content')


            <div class="content-wrapper">
                <br>
                <br>
                <div class="banner">
                    <h3 class="text-left"> <i class="fa fa-medkit"></i> MEDICINE</h3>
                </div>
                <div class="">
                    <br>
                    <a href="exportmedicineotpdf?stats=<?php echo $_GET['stats'] ?>" target="_blank" class="btn btn-default add"
                      data-toggle="tooltip" data-placement="top" title="EXPORT <?php echo strtoupper($_GET['stats']) ?> MEDICINES"
                    >
                        <i class="fa fa-file-text"></i> Export to PDF
                    </a>
                    <button class="btn btn-default add" data-toggle="modal" data-target="#addMedicine"><i class="fa fa-cart-plus"></i> Add Medicine</button>
                    <br>
                    @php
                      $active = 0;
                      $inactive = 0;
                      $deleted = 0;
                    @endphp
                    @foreach($counting as $list)
                      @if($list->trash == "Y")
                        @php
                        $deleted++;
                        @endphp
                      @endif
                      @if($list->status == "Y" && $list->trash != "Y")
                        @php
                        $active++;
                        @endphp
                      @endif
                       @if($list->status == "N" && $list->trash != "Y")
                        @php
                        $inactive++;
                        @endphp
                      @endif
                    @endforeach
                    <div class="pull-right" style="margin-top: -20px;">
                            <a href="pharmacy?stats=active" @if(isset($_GET['stats']) && $_GET['stats'] == "active") class="border" @endif><span style="background-color: #00e600;color: white;padding: 3px;font-weight: bold;">&nbsp;ACTIVE&nbsp;<span class="actived">{{ $active }}</span>&nbsp;</span></a>
                            <a href="pharmacy?stats=inactive" @if(isset($_GET['stats']) && $_GET['stats'] == "inactive") class="border"  @endif><span style="background-color: orange;color: white;padding: 3px;font-weight: bold;">&nbsp;INACTIVE&nbsp;<span class="inactived">{{ $inactive }}</span>&nbsp;</span></a>
                            <a href="pharmacy?stats=deleted" @if(isset($_GET['stats']) && $_GET['stats'] == "deleted") class="border"  @endif><span style="background-color: red;color: white;padding: 3px;font-weight: bold;">&nbsp;DELETED&nbsp;<span class="deleted">{{ $deleted }}</span>&nbsp;</span></a>
                            <a href="pharmacy?stats=all" @if(isset($_GET['stats']) && $_GET['stats'] == "all") class="border"  @endif><span style="background-color: #737373;color: white;padding: 3px;font-weight: bold;">&nbsp;TOTAL&nbsp;<span>{{ COUNT($counting) }}</span>&nbsp;</span></a>
                    </div>
                    <br>
                   

                </div>
                

                <div class="table-responsive content-medicine">
                    <table class="table table-striped table-bordered" id="medicine">
                        <thead>
                            <tr>
                                <th hidden></th>
                                <th hidden></th>
                                <th>CODE</th>
                                <th>BRAND</th>
                                <th>NAME/DESCRIPTION</th>
                                <th>EXPIRATION DATE</th>
                                <th>UNIT OF MEASURE</th>
                                <th>PRICE</th>
                                <th>STATUS</th>
                                <th>QUANTITY</th>
                                <th width="70px">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($medicine as $list)
                                @if($list->trash == "Y")
                                <tr class="danger">
                                @else
                                <tr>
                                @endif
                                    <td hidden></td>
                                    <td hidden class="idt">{{ $list->id }}</td>
                                    @if($list->trash == "Y")
                                      <td align="center" class="item_idt" style="border-left: 11px solid red">{{ $list->item_id }}</td>
                                    @else
                                      @if($list->status == "Y")
                                        <td align="center" class="item_description" style="border-left: 11px solid #00e600">{{ $list->item_id }}</td>
                                      @else
                                        <td align="center" class="item_idt" style="border-left: 11px solid orange">{{ $list->item_id }}</td>
                                      @endif
                                    @endif
                                    <td class="brandt">{{ $list->brand }}</td>
                                    <td class="desct">{{ $list->item_description }}</td>
                                    <td align="center" class="expiredate">{{ $list->expire_date }}</td>
                                    <td align="center" class="unitofmeasuret">{{ $list->unitofmeasure }}</td>
                                    <td align="right" class="pricet">{{ number_format($list->price, 2, '.', ',') }}</td>
                                    <td align="center" class="statust">@if($list->status == "Y"){{"ACTIVE"}}@else{{"INACTIVE"}}@endif</td>
                                    @if($list->stock)
                                    <td class="info" id="stockid" align="center">{{ $list->stock }}
                                      @if($list->stock <= 0 || $list->stock == "0")
                                        <span class="fa fa-warning" style="color: #ff8000"></span>
                                      @endif
                                    </td>
                                    @else 
                                    <td class="danger" id="stockid" align="center"> {{ '0' }} <span class="fa fa-warning" style="color: #ff8000"></span></td>
                                    @endif
                                    <td align="center" class="actioncol">
                                       @if($list->trash == "Y")
                                           <a href="#" class="btn btn-warning restore btn-sm" data-toggle="tooltip" data-placement="top" title="RESTORE ITEM"><span class="fa fa-recycle"></span> RESTORE</a>
                                       @else
                                          <a href="#" class="btn btn-default edit" data-toggle="tooltip" data-placement="top" title="EDIT ITEM"><span class="fa fa-pencil"></span></a>
                                          <a href="#" class="btn btn-default remove" data-toggle="tooltip" data-placement="top" title="MOVE TO TRASH"><span class="fa fa-trash"></span></a>
                                       @endif
                                     
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div> 
            <!-- .content-wrapper -->

            <!-- add medicine -->
            <div id="addMedicine" class="modal fade" role="dialog">
              <div class="modal-dialog">

                <!-- Modal content-->
                <form method="post" action="{{ url('pharmacy') }}">
                  {{ csrf_field() }}
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-cart-plus"></i> Add Medicine</h4>
                      </div>
                      <div class="modal-body">

                         <div class="form-group">
                           <label>Item Code</label>
                           <input type="text" name="item_id" class="form-control item_id" value="{{ 'MED'.$maxids }}" readonly>
                         </div>
                          <div class="form-group">
                           <label>Expiration Date</label>
                           <input type="date" name="expire_date" class="form-control item_id">
                         </div>

                         <div class="form-group">
                           <label>Brand</label>
                           <input class="form-control" name="brand">
                         </div>

                         <div class="form-group">
                           <label>Item Name/ Description</label>
                           <textarea class="form-control" name="item_description"></textarea>
                         </div>

                         <div class="form-group row">
                            <div class="col-md-6">
                                  <label>Unit of Measure</label>
                                  <input name="unitofmeasure" class="form-control"/>
                            </div>
                            <div class="col-md-6">
                                  <label>Price</label>
                                  <input type="text" name="price" class="form-control"/>
                            </div>
                         </div>
                         <div class="form-group row">
                            <div class="col-md-6">
                                  <label>Status</label>
                                  <select name="status" class="form-control" required>
                                    <option value="" hidden>--choose--</option>
                                    <option value="Y">ACTIVE</option>
                                    <option value="N">INACTIVE</option>
                                  </select>
                            </div>
                            <div class="col-md-6">
                                  <label>Quantiy</label>
                                  <input type="number" name="stock" class="form-control" required />
                            </div>
                         </div>
                         <div class="form-group">
                           <label>REMARKS <label style="color: red;font-size: 10px;">(required)</label></label>
                           <textarea class="form-control" name="remarks" required></textarea>
                         </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-backward"></span> Cancel</button>
                        <button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Save</button>
                      </div>
                    </div>
                </form>

              </div>
            </div>

            <div id="editMedicine" class="modal fade" role="dialog">
              <div class="modal-dialog">

                <!-- Modal content-->
                <form class="editMedicine">
                  {{ csrf_field() }}
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-cart-plus"></i> Edit Medicine</h4>
                      </div>
                      <div class="modal-body">
                          
                          <div class="form-group">
                            <label>Brand</label>
                            <input class="form-control brande" name="brand">
                          </div>
                          <div class="form-group">
                            <label>Expiration Date</label>
                            <input type="date" name="expire_date" class="form-control item_id" id="expire_date">
                          </div>

          
                         <div class="form-group">
                           <label>Item Name/ Description</label>
                           <textarea class="form-control item_descriptione" name="item_description"></textarea>
                         </div>

                         <div class="form-group row">
                            <div class="col-md-6">
                                  <label>Unit of Measure</label>
                                  <input name="unitofmeasure" class="form-control unitofmeasuree"/>
                            </div>
                            <div class="col-md-6">
                                  <label>Price</label>
                                  <input type="text" name="price" class="form-control pricee"/>
                            </div>
                         </div>
                         <div class="form-group row">
                            <div class="col-md-6">
                                  <label>Status</label>
                                  <select name="status" class="form-control statuse" required>
                                    <option value="" hidden>--choose--</option>
                                    <option value="Y">ACTIVE</option>
                                    <option value="N">INACTIVE</option>
                                  </select>
                            </div>
                            <div class="col-md-6">
                                  <label>Quantiy</label>
                                  <div class="input-group">
                                      <div class="input-group-btn">
                                          <button type="button" class="btn btn-default dropdown-toggle chooseb" 
                                              data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                              +- <span class="caret"></span>
                                          </button>
                                          <ul class="dropdown-menu">
                                              <li><a href="" class="add">ADD <i class="fa fa-plus-circle"></i></a></li>
                                              <li><a href=""  class="deduct">DEDUCT <i class="fa fa-minus-circle"></i></a></li>
                                          </ul>
                                      </div><!-- /btn-group -->
                                      <input type="number" id="stocke"  name="stock" class="form-control">
                                  </div><!-- /input-group -->
                                 
                                  
                            </div>
                            
                         </div>
                         <div class="form-group">
                            <label>REMARKS <label style="color: red;font-size: 10px;">(required)</label></label>
                            <textarea class="form-control remarks" name="remarks" required></textarea>
                          </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-backward"></span> Cancel</button>
                        <button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Save</button>
                        <input type="hidden" name="id" class="ids">
                      </div>
                    </div>
                </form>

              </div>
            </div>

            <!-- end -->




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
    <script src="{{ asset('public/js/pharmacy/medicine.js') }}"></script>
@stop


@endcomponent
