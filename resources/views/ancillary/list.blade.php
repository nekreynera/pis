@component('partials/header')

    @slot('title')
        PIS | ANCILLARY
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/css/ancillary/list.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/plugins/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />
@endsection



@section('header')
    @include('receptions/navigation')
@stop



@section('content')
            <div class="container">
                    <!-- <h3 class="text-left"><span class="fa fa-wrench"></span> SERVICES</h3> -->
                <hr>
                
               
                <div>
                 
                  <!-- <a href="#"
                     class="btn btn-success add"
                     data-toggle="modal" data-target="#addService">
                      ADD SERVICE <span class=" fa fa-plus"></span>
                  </a>
                   <a href="{{ url('exportservicetopdf') }}" target="_blank" 
                     class="btn btn-info">
                      EXPORT TO PDF <span class=" fa fa-file-text-o"></span>
                  </a> -->
                    @php
                      $active = 0;
                      $inactive = 0;
                      $deleted = 0;
                    @endphp
                   @foreach($tab as $list)
                      @if($list->status == "active" && $list->trash == "N")
                        @php
                          $active++
                        @endphp
                      @endif
                      @if($list->status == "inactive" && $list->trash == "N")
                        @php
                          $inactive++
                        @endphp
                      @endif
                      @if($list->trash == "Y")
                        @php
                          $deleted++
                        @endphp
                      @endif
                   @endforeach
                  <ul class="nav nav-tabs">
                      <li>
                          <a href="{{ url('ancillary?list=active') }}"
                             class="unassignedTab @if($request->list == 'active') {{ 'bg-success' }}  @endif" 
                             data-toggle="tooltip" data-placement="top" title="FILTER BY ACTIVE SERVICES">
                              ACTIVE
                              <span class="badge bsucesss">{{ $active }}</span>
                          </a>
                      </li>
                      <li>
                          <a href="{{ url('ancillary?list=inactive') }}"
                             class="unassignedTab @if($request->list == 'inactive') {{ 'bg-warning' }}  @endif" 
                             data-toggle="tooltip" data-placement="top" title="FILTER BY INACTIVE SERVICES">
                              INACTIVE
                              <span class="badge bwarning">{{ $inactive }}</span>
                          </a>
                      </li>
                      <li>
                          <a href="{{ url('ancillary?trash=Y') }}"
                             class="unassignedTab @if($request->trash == 'Y') {{ 'bg-danger' }}  @endif" 
                             data-toggle="tooltip" data-placement="top" title="FILTER BY DELETED SERVICES">
                              DELETED
                              <span class="badge bdanger">{{ $deleted }}</span>
                          </a>
                      </li>
                      <li>
                          <a href="{{ url('ancillary') }}"
                             class="unassignedTab" 
                             data-toggle="tooltip" data-placement="top" title="VIEW ALL SERVICES">
                              TOTAL
                              <span class="badge binfo">{{ count($tab) }}</span>
                          </a>
                      </li>
                      <li class="pull-right">
                          <a href="{{ url('exportservicetopdf') }}?list='{{$request->list}}'&trash='{{$request->trash}}'" class="bg-info" target="_blank">
                              EXPORT TO PDF <span class=" fa fa-file-text-o"></span>
                          </a>
                      </li>
                      <li class="pull-right">
                          <a href="#"
                             class="add bg-primary"
                             data-toggle="modal" data-target="#addService">
                              ADD SERVICE <span class=" fa fa-plus"></span>
                          </a>
                      </li>
                   
                  </ul>
                  <br>
                </div>
               

                       
                  
                <div class="table-responsive content-medicine">
                    <table class="table table-striped table-bordered" id="services">
                        <thead>
                            <tr style="background-color: #ccc;">
                                <th hidden></th>
                                <th hidden></th>
                                <th>PARTICULAR</th>
                                <th>PRICE</th>
                                <th>TYPE</th>
                                <th>STATUS</th>
                                <th width="70px">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($services as $list)
                                <tr>
                                    <td hidden></td>
                                    <td hidden class="idt">{{ $list->id }}</td>
                                    <td class="sub_categorytd">{{ $list->sub_category }}</td>
                                    <td align="right" class="pricetd">{{ number_format($list->price, 2, '.', ',') }}</td>
                                    <td align="center" class="typetd">{{ ( $list->type )?'SUPPLY':'SERVICE' }}</td>
                                     @if($list->trash == 'N')
                                      @if($list->status == 'active')
                                      <td align="center" class="statustd success" id="statustd">{{ $list->status }}</td>
                                      @else
                                      <td align="center" class="statustd warning" id="statustd">{{ $list->status }}</td>
                                      @endif
                                    @else
                                      <td align="center" class="statustd danger" id="statustd">DELETED</td>
                                    @endif
                                     <td align="center">
                                     @if($list->trash == 'N')
                                        <a href="#" class="btn btn-default editservice" data-toggle="tooltip" data-placement="top" title="EDIT ITEM"><span class="fa fa-pencil"></span></a>
                                        <a href="{{ url('movetotrash') }}/{{$list->id}}" 
                                            class="btn btn-default removeservice" 
                                            data-toggle="tooltip" data-placement="top" title="MOVE TO TRASH"
                                            onclick="return confirm('Delete this Service?')"><span class="fa fa-trash"></span></a>
                                     @else
                                        <a href="{{ url('restoreservice') }}/{{$list->id}}" 
                                          class="btn btn-warning btn-sm"
                                           onclick="return confirm('Re-use / Restore this Service?')">
                                          RESTORE <span class="fa fa-recycle"></span>
                                        </a>
                                     @endif
                                     </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div> 




            <div id="addService" class="modal" role="dialog">
              <div class="modal-dialog">

                <!-- Modal content-->
                <form method="post" action="{{ url('ancillary') }}">
                  {{ csrf_field() }}
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-plus"></i> Add Service</h4>
                      </div>
                      <div class="modal-body">
                          {{--@if(Auth::user()->clinic == "31")
                             <div class="form-group row">
                                <div class="col-md-6">
                               <label>TYPE</label>
                               <select class="form-control" name="type">
                                  <option value="11">X-RAY</option>
                                  <option value="6">ULTRASOUND</option>
                               </select>
                               </div>
                             </div> 
                            @endif--}}
                         <div class="form-group">
                           <label>Service Name/ Description</label>
                           <textarea class="form-control" name="sub_category" autofocus placeholder="Enter Service Name/ Description" required></textarea>
                         </div>
                         <div class="form-group row">
                            <div class="col-md-6">
                                  <label>Price</label>
                                  <input type="text" name="price" class="form-control" placeholder="0.00" required />
                            </div>
                         </div>
                         <div class="form-group row">
                            <div class="col-md-6">
                                  <label>Type</label>
                                  <select name="type" class="form-control" required>
                                    <option value="" hidden>--choose--</option>
                                    <option value="0">SERVICE</option>
                                    <option value="1">SUPPLY</option>
                                  </select>
                            </div>
                         </div>
                         <div class="form-group row">
                            <div class="col-md-6">
                                  <label>Status</label>
                                  <select name="status" class="form-control" required>
                                    <option value="active">ACTIVE</option>
                                    <option value="inactive">INACTIVE</option>
                                  </select>
                            </div>
                            
                         </div>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Save</button>
                         <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-backward"></span> Cancel</button>
                      </div>
                    </div>
                </form>

              </div>
            </div>

            <div id="editservice" class="modal" role="dialog">
              <div class="modal-dialog">

                <!-- Modal content-->
                <form class="editservicemodal">
                  {{ csrf_field() }}
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-pencil"></i> Edi Service</h4>
                      </div>
                      <div class="modal-body">
                       {{-- @if(Auth::user()->clinic == "31")
                         <div class="form-group row">
                            <div class="col-md-6">
                           <label>TYPE</label>
                           <select class="form-control type" name="type">
                              <option value="11">X-RAY</option>
                              <option value="6">ULTRASOUND</option>
                           </select>
                           </div>
                         </div> 
                        @endif--}}
                         <div class="form-group">
                           <label>Item Name/ Description</label>
                           <textarea class="form-control sub_category" name="sub_category" autofocus required></textarea>
                         </div>
                         <div class="form-group row">
                            <div class="col-md-6">
                                  <label>Price</label>
                                  <input type="text" name="price" class="form-control price" required />
                            </div>
                         </div>
                         <div class="form-group row">
                            <div class="col-md-6">
                                  <label>Type</label>
                                  <select name="type" class="form-control type" required>
                                    <option value="" hidden>--choose--</option>
                                    <option value="0">SERVICE</option>
                                    <option value="1">SUPPLY</option>
                                  </select>
                            </div>
                         </div>
                         <div class="form-group row">
                            <div class="col-md-6">
                                  <label>Status</label>
                                  <select name="status" class="form-control status" required>
                                    <option value="" hidden>--choose--</option>
                                    <option value="active">ACTIVE</option>
                                    <option value="inactive">INACTIVE</option>
                                  </select>
                            </div>
                            
                         </div>
                      </div>
                      <div class="modal-footer">
                        <input type="hidden" name="" class="hidden_id">
                        <button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Update</button>
                         <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-backward"></span> Cancel</button>
                      </div>
                    </div>
                </form>

              </div>
            </div>
@endsection


@section('footer')
@stop



@section('pagescript')
    @include('message.toaster')
    
    <script src="{{ asset('public/plugins/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/plugins/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/js/ancillary/list.js?2') }}"></script>
@stop


@endcomponent
