<div id="alertModal" class="modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="fa fa-cog fa-spin"></i> System Updated </h4>
      </div>
      <div class="modal-body bg-warning">
        <label>Hi there, <span class="fa fa-medkit"></span> The OPDRMS had updated. </label>
        <br>
        <br> 
        List of update...
        <ol style="margin-left: 20px;">
          <li> 1. Walk-in patient MSS Classification(D-CHARITY) is automatically disabled for laboratory payment</li>
        </ol> 
        <br>
        <br>
        <i class="fa fa-info-circle"></i> Select desired discount for the patient laboratory payment
        <br><br>
        <label>INTEGRATED HOSPITAL OPERATIONS & MANAGEMENT PROGRAM</label><br>
        <p>Local Tel. No.: 1129</p>
      </div>
      <div class="modal-footer">
        <a href="{{ url('cashier?alert=true') }}" class="btn btn-success btn-sm">Got it! <span class="fa fa-thumbs-up"></span></a>
      </div>
    </div>
  </div>
</div>