<!-- Modal -->
<div id="formRecordsModal" class="modal fade" role="dialog">
    <div class="modal-dialog">


        <div class="loaderRefresh" style="position: fixed">
            <div class="loaderWaiting">
                <i class="fa fa-spinner fa-spin"></i>
                <span> Please Wait...</span>
            </div>
        </div>


        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Pediatric Forms (Records)</h4>
            </div>
            <div class="modal-body">

                <div class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             <a data-toggle="collapse" href="#therapeuticCareDivWrapper" class="therapeuticCareShowList" style="color: black;">
                                 Therapeutic Care
                                 
                             </a>
                            <?php if(Auth::user()->clinic == '26'): ?>
                            <a href="" target="_blank" class="pull-right text-muted therapeuticCareAnchorCreate">Create <i class="fa fa-pencil"></i></a>
                            <?php endif; ?>
                        </div>

                        <div id="therapeuticCareDivWrapper" class="panel-collapse collapse">
                            <ul class="list-group therapeuticCareUL">
                            </ul>
                        </div>
                    </div>


                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <a data-toggle="collapse" href="#childHoodCareHeader" style="color: black;">
                                Early Childhood Care And Development Card
                                
                            </a>
                            <?php if(Auth::user()->clinic == '26'): ?>
                            <a href="" target="_blank" class="pull-right text-muted childHoodCareAnchorCreate">Create <i class="fa fa-pencil"></i></a>
                            <?php endif; ?>
                        </div>
                        <div id="childHoodCareHeader" class="panel-collapse collapse">
                            <ul class="list-group childHoodCareUL">
                            </ul>
                        </div>
                    </div>


                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <a data-toggle="collapse" href="#kmcHeader" style="color: black;">
                                KMC (Kangaroo Mother Care Program)
                                
                            </a>
                            <?php if(Auth::user()->clinic == '26'): ?>
                            <a href="" target="_blank" class="pull-right text-muted kmcAnchorCreate">Create <i class="fa fa-pencil"></i></a>
                            <?php endif; ?>
                        </div>
                        <div id="kmcHeader" class="panel-collapse collapse">
                            <ul class="list-group kmcUL">
                            </ul>
                        </div>
                    </div>


                </div>




            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>