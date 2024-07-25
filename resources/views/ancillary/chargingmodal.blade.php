
<div id="chargingmodal" class="modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content" style="text-align: left!important;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" ><span class="fa fa-remove" style="color: red!important;"></span></button>
        <form class="form-inline">
            <div class="form-group">
                <label>Hospital no</label>
                <input type="" name="" class="form-control Phospital" readonly>
            </div>
            <div class="form-group">
                <label>Name</label>
                <input type="" name="" class="form-control Pname" style="width: 300px;" readonly>
            </div>
             <div class="form-group">
                <label>Classification</label>
                <input type="" name="" class="form-control Pmss" readonly>
                <input type="hidden" name="" class="form-control Pdiscount" readonly>
                <input type="hidden" name="" class="form-control Pmss_id" readonly>
                <input type="hidden" name="" class="form-control Ppatient_id" readonly>
            </div>
            <div class="form-group">
                <button class="btn btn-info btn-sm" id="view-charging-history" onclick="event.preventDefault()" data-id=""><span class="fa fa-history"></span> View Charging History</button>
            </div>
        </form>
      </div>
      <div class="modal-body">
        <div class="services-view">
            <div class="pull-left">
               <label>Showing <b class="service-count">123</b> Result of services...</label> 
            </div>
            <div class="pull-right">
                <form class="form-inline">
                    <div class="input-group" style="margin-bottom: 3px;">
                        <input type="text" name="" class="form-control" id="searchparticular" style="height: 30px!important;font-size: 12px;" placeholder="Filter Service Name..">
                        <span class="input-group-addon fa fa-search"></span>
                    </div>
                </form>
            </div>
            <table class="table table-striped" id="services-table-th">
                <thead>
                    <tr>
                        <th class="text-center"><span class="fa fa-plus"></span></th>
                        <th>ROW COUNT</th>
                        <th>PARTICULARS</th>
                        <th>PRICE</th>
                    </tr>
                </thead>
            </table>
            <div class="table-responsive" id="services-table">
                <table class="table table-striped" id="services-table-table">
                    
                    <tbody class="services-tbody">
                        <!-- @for($i=1;$i<=10;$i++)
                        <tr>
                            <td align="center"><button class="btn btn-default btn-sm"><span class="fa fa-plus"></span></button></td>
                            <td class="sservice">Service {{ $i }}</td>
                            <td align="right" class="sprice">{{$i}}1.00</td>
                        </tr>
                        @endfor -->
                    </tbody>
                </table>
            </div>
        </div>
        <hr>
        <div class="order-view">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-10">
                        <a href="#" class="order-expand"><span class="fa fa-window-maximize"></span> Expand Order View</a>&nbsp;&nbsp;&nbsp;
                        <a href="#" class="order-culomn-show"><span class="fa fa-table"></span> Show Some Columns</a>
                        <div class="row pull-right col-md-3">
                            <div class="input-group">
                                <input type="" name="" class="form-control" id="searchchargeparticular" style="height: 30px;font-size: 12px;" placeholder="Filter Service Name">
                                <span class="input-group-addon fa fa-search"></span>
                            </div>
                        </div>
                        <div class="table table-responsive" id="order-table">
                            <table class="table table-bordered" id="order-table-table">
                                <thead>
                                    <tr>
                                        <th><span class="fa fa-minus"></span></th>
                                        <th>Particular</th>
                                        <th>Price</th>
                                        <th>Qty</th>
                                        <th>Amount</th>
                                        <th>Mss <br> Discount</th>
                                        <th>Sponsored</th>
                                        <th>Net Amount</th>
                                        <th>Date</th>
                                        <th class="info">Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="order-tbody">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                   
                    <div class="col-md-2 service-summary">
                        <label class="bg-success" style="width: 100%;height: 30px;padding: 5px;"> PENDING PAYMENT...</label>
                        <br>
                        <form class="form-horizontal">
                            <label>Amount</label>
                            <input type="" name="" class="form-control tamount" readonly>
                            <br>
                            <label>Discount</label>
                            <input type="" name="" class="form-control tdiscount" readonly>
                            <br>
                            <label>Net Amount</label>
                            <input type="" name="" class="form-control tnetamount" readonly>
                        </form>
                    </div>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="text-right col-md-10">
            <button type="button" class="btn btn-default btn-sm" id="charge-all" disabled
            data-placement="top" data-toggle="tooltip" title="SAVE ALL"
            ><span class="fa fa-save"></span> Save</button>
            <button type="button" class="btn btn-default btn-sm" id="edit-all" disabled style="display: none;"><span class="fa fa-pencil"></span> Edit</button>
            <button type="button" class="btn btn-default btn-sm" id="done-all" disabled
            data-placement="top" data-toggle="tooltip" title="MARK ALL PAID ITEMS AS DONE"><span class="fa fa-check"></span> Done</button>
        </div>
        
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><span class="fa fa-remove"></span> Close</button>
      </div>
    </div>

  </div>
</div>

<div id="patient-history-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"> <span class="fa fa-history"></span> Patient Charging History</h4>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>O.R. Number</th>
                        <th>Particular</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Amount</th>
                        <th>Mss <br> Discount</th>
                        <th>Sponsored</th>
                        <th>Net Amount</th>
                        <th>Charge by</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody class="history-tbody">
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4"></th>
                        <th class="total_amount text-right"></th>
                        <th class="total_discount text-right"></th>
                        <th class="total_sponsored text-right"></th>
                        <th class="total_netamount text-right"></th>
                        <th colspan="2"></th>
                    </tr>
                </tfoot>
            </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><span class="fa fa-remove"></span>Close</button>
      </div>
    </div>

  </div>
</div>
 
