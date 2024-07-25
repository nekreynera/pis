<div id="notification" class="modal" role="dialog">
    <div class="modal-dialog modal-xxl">

        <!-- Modal content-->
        <div class="modal-content">
            {{--<div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-center text-danger"><i class="fa fa-bell-o"></i> Refferals and Follow-up Notifications of this Patient</h4>
            </div>--}}
            <div class="modal-body">

                @if(((count($refferals) + count($followups)) > 0))
                <div class="row">

                    @if(count($refferals) > 0)
                    <div class="col-md-12">
                            <br>
                                <br>
                                <div class="table-responsive">
                                    <p class="text-danger text-center hidden-xs">
                                        <strong>This patient has a pending <b style="color: red;font-size: 25px">Referral</b> to this clinic.</strong>
                                    </p>
                                    <br>
                                    <p class="text-danger text-center visible-xs">
                                         This patient has a pending <b style="color: red;">Referral</b> to this clinic.
                                    </p>
                                    <br>
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>PATIENT</th>
                                            <th>FROM_CLINIC</th>
                                            <th>REFFERED_BY</th>
                                            <th>TO_CLINIC</th>
                                            <th>REFFERED_TO</th>
                                            <th>REASON</th>
                                            <th>STATUS</th>
                                            <th>DATE</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @if(count($refferals))
                                            @foreach($refferals as $refferal)
                                                <tr>
                                                    <td>{{ $refferal->name }}</td>
                                                    <td>{{ ($refferal->fromClinic)? $refferal->fromClinic : 'N/A' }}</td>
                                                    <td>{{ ($refferal->fromDoctor)? 'Dr. '.$refferal->fromDoctor : 'N/A' }}</td>
                                                    <td>{{ ($refferal->toClinic)? $refferal->toClinic : 'N/A' }}</td>
                                                    <td>{{ ($refferal->toDoctor)? $refferal->toDoctor : 'Unassigned' }}</td>
                                                    <td>{{ ($refferal->reason)? $refferal->reason : 'N/A' }}</td>
                                                    <td>{!! ($refferal->status == 'P')? '<span class="text-danger">Pending</span>' : '<span class="text-success">Finished</span>' !!}</td>
                                                    <td>{{ Carbon::parse($refferal->created_at)->toFormattedDateString() }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5" class="text-center">
                                                    <strong class="text-danger">
                                                        NO REFFERALS FOUND.
                                                    </strong>
                                                </td>
                                            </tr>
                                        @endif

                                        </tbody>

                                    </table>

                                </div>
                    </div>

                    @endif





                    @if(count($followups) > 0)
                    <div class="col-md-12">

                            <hr>
                            <div class="table-responsive">
                                <p class="text-danger text-center hidden-xs">
                                    <strong>This patient has a pending <b style="color: red;font-size: 25px">Follow-Up</b>  to this clinic.</strong>
                                </p>
                                <br>
                                <p class="text-danger text-center visible-xs">
                                     This patient has a pending <b style="color: red;">Follow-Up</b> to this clinic.
                                </p>
                                <br>
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>TO_DOCTOR</th>
                                        <th>CLINIC</th>
                                        <th>REASON</th>
                                        <th>FF_DATE</th>
                                        <th>STATUS</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($followups) > 0)
                                        @foreach($followups as $followup)
                                            <tr>
                                                <td>{{ (!empty($followup->doctorsname))? $followup->doctorsname : 'N/A' }}</td>
                                                <td>{{ $followup->name }}</td>
                                                <td>{{ $followup->reason }}</td>
                                                <td>{{ Carbon::parse($followup->followupdate)->toFormattedDateString() }}</td>
                                                <td>{!! ($followup->status == 'P')? '<span class="text-danger">Pending</span>' : '<span class="text-success">Finished</span>' !!}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center">
                                                <strong class="text-danger">
                                                    NO FOLLOW-UP FOUND.
                                                </strong>
                                            </td>
                                        </tr>
                                    @endif

                                    </tbody>
                                </table>
                            </div>
                    </div>
                        @endif


                </div>


                @else
                    <h3 class="text-center text-danger"><b>NO NOTIFICATIONS TO BE DISPLAYED <i class="fa fa-exclamation"></i></b></h3>
                @endif


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
