<div class="modal" id="modal-store-mss-classification">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                New Mss Classification Window
                <small class="pull-right">
                    <span class="fa fa-info-circle"></span>
                    Fields mark with <b class="text-red">*</b> are required
                </small>
            </div>
            <div class="modal-body">
                @include('OPDMS.partials.loader')
                <form class="form-horizontal" id="store-sponsors" method="POST" action="{{ url('sponsors') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="">Label <b class="text-red">*</b></label>
                            <input type="text" name="labels" class="form-control labels" placeholder="Label...">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <label class="">Description <b class="text-red">*</b></label>
                            <input type="text" name="description" class="form-control description" placeholder="Description...">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-5 col-sm-5 col-xs-6">
                            <label class="">Discount <b class="text-red">*</b></label>
                            <input type="text" name="discount" class="form-control discount text-right" placeholder="Discount...">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-4 col-sm-4 col-xs-6">
                            <label class="">Type <b class="text-red">*</b></label>
                            <select name="type" class="form-control type">
                                <option value="0" class="bg-success">Discount</option>
                                <option value="1" class="bg-primary">Guarantor</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-4 col-sm-4 col-xs-6">
                            <label class="">Status <b class="text-red">*</b></label>
                            <select name="status" class="form-control status">
                                <option value="1" class="bg-primary">Active</option>
                                <option value="0" class="bg-danger">In-active</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left btn-sm" data-dismiss="modal"><span class="fa fa-close"></span> Close</button>
                <button type="submit" class="btn btn-success btn-sm" form="store-sponsors" id="save"><span class="fa fa-save"></span> Save</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->