<!-- Modal -->


<style>
    input[name="barcode"]{
        height: 70px;
        text-align: center;
        font-size: 25px;
        background-color: transparent;
        border: 2px solid #00b300;
        border-radius: 5px;
    }
    input[name="barcode"]:focus{
        border:2px solid #00b300;
        box-shadow: 5px -5px 12px #b3ffb3, -5px 5px 12px #b3ffb3;
    }
    #qrcodeModal .modal-body{
        padding: 50px;
    }
</style>


<div id="qrcodeModal" class="modal" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-center">Enter QRCode or Hospital No.</h4>
            </div>
            <div class="modal-body">

                <form>
                    <div class="form-group">
                        <input type="text" id="qcodeInput" name="barcode" class="form-control receptionsbarcode">
                    </div>
                </form>

                <br>
                <p class="text-center">
                    <strong>
                        “ Prioritization of patients for medical treatment ”
                    </strong>
                </p>
                <p class="text-center text-muted">
                    Medicine is a science of uncertainty and an art of probabality.
                </p>
                 <div class="alert alert-info alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-info"></i> Info!</h4>
                        If the patient is <b>walk-in</b>, manually type the unique walk-in number located at the upper right corner of the <b>EVRMC official receipt</b>. <br>
                        Example: <b>WALK-IN-000001</b> <br>

                        <p>Flow for the walk-in patient: </p>
                            <ol>
                                <li>Triage</li>
                                <li>Cashier</li>
                                <li>Diagnostics Center</li>
                            </ol>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>