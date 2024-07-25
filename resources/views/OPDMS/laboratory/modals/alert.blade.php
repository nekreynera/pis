<div id="alertModal" class="modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="fa fa-cog fa-spin"></i> System Updated </h4>
      </div>
      <div class="modal-body bg-warning">
        <label>Hi there, <span class="fa fa-medkit"></span> The PIS had updated. </label>
        <br>
        <br> 
        List of update...<br>
        <label>LABORATORY</label>
        <ol style="margin-left: 20px;">
          <li>Walk-in patient from private MSS Classification(D-CHARITY) is automatically disabled.</li>
          <li>Walk-in patient from public MSS Classification remain the same.</li>
        </ol> 
        <br><br>
        <i class="fa fa-info-circle"></i> Please select Walk-in patient(option) upon selecting a physician if the laboratory request is not from EVRMC
        <br><br>
        <label>INTEGRATED HOSPITAL OPERATIONS & MANAGEMENT PROGRAM</label><br>
        <p>Local Tel. No.: 1129</p>
      </div>
      <div class="modal-footer">
        <a href="{{ url('laboratorypatients?alert=true') }}" class="btn btn-success btn-sm">Got it! <span class="fa fa-thumbs-up"></span></a>
      </div>
    </div>
  </div>
</div>