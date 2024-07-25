<div class="modal" id="patient_assignation_modal">





    <div class="modal-dialog modal-lg">


        @include('OPDMS.partials.loader') {{-- loader icon --}}


        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-blue text-uppercase" id="p_name_holder">
                    @{{ p_name }}
                </h4>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-8">
                        <h4>
                            Assignations
                            <small>Designate this patient to a specific doctor.</small>
                        </h4>
                    </div>
                    <div class="col-md-4">
                        <form class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Filter:</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" onkeyup="filter_result($(this), 'assignations_table')"
                                           placeholder="Filter Results">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


                <div class="table-responsive selectable_table">
                    <table class="table table-bordered table-striped table-hover assignations_table">
                        <thead>
                            <tr>
                                <th>No#</th>
                                <th>Status</th>
                                <th>Doctor</th>
                                <th>Serving</th>
                                <th>Pending</th>
                                <th>NAWC</th>
                                <th>Paused</th>
                                <th>Finished</th>
                            </tr>
                        </thead>
                        <tbody id="assignations_tbody">
                            {{-- place doctors here via ajax --}}
                        </tbody>
                    </table>
                </div>







            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-flat btn-default pull-left" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>