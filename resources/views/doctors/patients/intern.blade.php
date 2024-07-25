@if($intern)
    <td>
        <div class="dropdown">
            @php
                $approvalStatus = App\Approval::checkApprovalStatus($patient->pid);
                if ($approvalStatus){
                    if ($approvalStatus->approved == 'N'){
                          $apprvltatus = '<span class="text-danger">Declined</span>';
                    }elseif ($approvalStatus->approved == 'Y'){
                          $apprvltatus = '<span class="text-success">Approved</span>';
                    }else{
                          $apprvltatus = '<span class="text-info">Pending</span>';
                    }
                }else{
                      $apprvltatus = '<span class="text-warning">For Approval</span>';
                }
            @endphp
            {!! $apprvltatus !!}
            <a href="" class="btn btn-default btn-circle dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-arrow-right text-success"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-right">
                <li class="dropdown-header">--Approving Doctor--</li>
                @if(count($allDoctors) > 0)
                    @foreach($allDoctors as $allDoctor)
                        @if($allDoctor->id != Auth::user()->id)
                            @php
                                if ($approvalStatus){
                                    $checkStst = ($allDoctor->id == $approvalStatus->approved_by)? 'class="disabled" onclick="return false"' : '';
                                }else{
                                    $checkStst = '';
                                }
                            @endphp
                            <li {!! $checkStst !!}>
                                <a href='{{ url("approval/$patient->pid/$allDoctor->id") }}'>
                                    <div class='@if(App\User::isActive($allDoctor->id)) online @else offline @endif'></div> <span class='text-default'>Dr. {{ ucwords(strtolower($allDoctor->name)) }}</span>
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            </ul>
        </div>
    </td>
@endif