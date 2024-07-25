<div id="icd10CodeModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xl">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-center hidden-xs">International Classification of Diseases</h4>
                <h4 class="modal-title text-center visible-xs">ICD 10 Codes</h4>
            </div>
            <div class="modal-body">
                <div class="icdWrapper row">
                    <div class="row">
                        <div class="col-md-6">
                            <form action="{{ url('searchICD') }}" method="POST" id="icdSearchForm">
                                {{ csrf_field() }}
                                <div class="input-group">
                                    <input type="text" name="search" id="search" class="form-control" placeholder="Search ICD By Description..." aria-describedby="basic-addon1">
                                    <span class="input-group-addon" onclick="icd('searchActivate')">
                                        <i class="fa fa-search"></i>
                                    </span>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <form action="{{ url('searchICD') }}" method="post" id="icdSearchCodeForm">
                                <div class="input-group">
                                    <input type="text" name="search" id="search" class="form-control" placeholder="Search ICD By Code..." aria-describedby="basic-addon1">
                                    <span class="input-group-addon" id="basic-addon1" onclick="icd('searcCodeActivate')">
                                        <i class="fa fa-search"></i>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                    <br>
                    <div class="">
                        <p class="text-right text-primary">Total of <span class="totalICDS"></span> Results Found...</p>
                        <div class="loaderWrapper">
                            <img src="{{ asset('public/images/loader.svg') }}" alt="Loader" class="img-responsive center-block" />
                            <p>Loading...</p>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped" id="tableICD">
                                <thead>
                                <tr>
                                    <th><i class="fa fa-question"></i></th>
                                    <th>CODE</th>
                                    <th>DESCRIPTION</th>
                                </tr>
                                </thead>
                                <tbody id="icdTbody">
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-center" id="paginator" style="padding: 0px;margin: 0px">
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" class="close" data-dismiss="modal">OK <i class="fa fa-check"></i></button>
            </div>
        </div>

    </div>
</div>
