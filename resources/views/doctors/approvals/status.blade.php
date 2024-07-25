<td class="text-center">
    <a href="{{ url('markAsApproved/'.$approval->approvalid) }}" class="btn btn-default btn-circle"
       data-placement="top" data-toggle="tooltip" title="Click to mark as approved?">
        <i class="fa fa-thumbs-o-up text-success"></i>
    </a>
</td>

<td class="text-center">
    <a href="{{ url('markAsUnApproved/'.$approval->approvalid) }}" class="btn btn-default btn-circle"
       data-placement="top" data-toggle="tooltip" title="Click to mark as declined?">
        <i class="fa fa-thumbs-o-down text-danger"></i>
    </a>
</td>
<td>
    @php
        if($approval->approved == 'N'){
            $approvalStat = '<span class="text-danger">Declined</span>';
        }elseif($approval->approved == 'Y'){
            $approvalStat = '<span class="text-success">Approved</span>';
        }else{
            $approvalStat = '<span class="text-warning">For Approval</span>';
        }
    @endphp
    {!! $approvalStat !!}
</td>