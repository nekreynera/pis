<div id="recordsModal" class="modal" role="dialog">
    <div class="modal-dialog modal-xl">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-center" id="recordsHeaderTitle"></h4>
            </div>
            <div class="modal-body">
                <br>

                @include('message.loader')

                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                    <table class="table">
                        <thead class="recordsThead">
                        <tr>
                            <th>VIEW RESULT</th>
                            <th>DESCRIPTION</th>
                            <th>PRICE</th>
                            <th>DATE</th>
                            <th>STATUS</th>
                            <th>DELETE</th>
                            <th>UPDATE</th>
                            <th>QTY</th>
                            <th><i class="fa fa-question"></i></th>
                        </tr>
                        </thead>
                        <tbody class="medsWatchTbody">
                            @for($i=0;$i < 5 ;$i++)
                            <tr>
                                <td>
                                    <a href="" class="btn btn-sm btn-success">
                                        <i class="fa fa-file-text-o"></i> Result
                                    </a>
                                </td>
                                <td>PARACETAMOL TOKMOL</td>
                                <td>4512.00</td>
                                <td>March 34, 2018</td>
                                <td>
                                    <span class="text-danger">Pending</span>
                                </td>
                                <td>
                                    <button class="btn btn-default btn-circle" disabled>
                                        <i class="fa fa-trash text-danger"></i>
                                    </button>
                                </td>
                                <td>
                                    <button class="btn btn-default btn-circle" disabled>
                                        <i class="fa fa-upload text-primary"></i>
                                    </button>
                                </td>
                                <td>
                                    <input type="number" value="5" class="form-control qtyTobeEdited" disabled>
                                </td>
                                <td>
                                    <input type="checkbox" class="enableCheckbosMeds">
                                </td>
                            </tr>

                            @endfor
                        </tbody>
                    </table>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <a href="" target="_blank" class="btn btn-success medsPrint">
                    <i class="fa fa-print"></i> Print
                </a>
            </div>
        </div>

    </div>
</div>