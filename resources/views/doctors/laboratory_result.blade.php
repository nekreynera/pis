<div id="laboratory_result" class="modal" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Laboratory Result...</h4>
            </div>
            <div class="modal-body" style="padding: 0px;">
                @include('OPDMS.partials.loader')
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src=""></iframe>
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>