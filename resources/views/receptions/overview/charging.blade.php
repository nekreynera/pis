@if(in_array(Auth::user()->clinic, $chrgingClinics))
    <td align="center">

        @php
            $undoneItems = App\Cashincome::getAllUndonedItems($patient->id);
            $allServiceDone = (count($undoneItems) > 0)? '' : 'disabled';
        @endphp




            <div class="btn-group">
                <a href="#" class="btn btn-info @if(Request::is('rcptnLogs/*/*/*')) disabled @endif)"
                   onclick="chargeuser($(this))" data-id="{{ $patient->id }}"
                   data-placement="top" data-toggle="tooltip" title="Proceed to charging">
                    &#8369;
                </a>
                <button type="button" class="btn btn-primary dropdown-toggle {{ $allServiceDone }}" data-toggle="dropdown">
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu dropdown-menu-right" role="menu">
                    @foreach($undoneItems as $row)
                        <li class="{{ ($row->get == 'N')? 'bg-success' : 'bg-danger' }}">
                            @if($row->get == 'N')
                                <a href="{{ url('done/'.$row->id.'/Y') }}" data-placement="left" data-toggle="tooltip" title="Click to Done this service">
                                    <i class="fa fa-check text-success"></i> &nbsp; {!! $row->sub_category.' | <label class="label label-default">'.Carbon::parse($row->created_at)->toDateString().'</label>' !!}
                                </a>
                            @else
                                <a href="{{ url('done/'.$row->id.'/N') }}" data-placement="left" data-toggle="tooltip" title="Click to Revert this service">
                                    <i class="fa fa-refresh text-danger"></i> &nbsp; {!! $row->sub_category.' | <label class="label label-default">'.Carbon::parse($row->created_at)->toDateString().'</label>' !!}
                                </a>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>




        @if(in_array(Auth::user()->clinic, $chrgingClinics))
            @if(count($charging) > 0)
                @foreach($charging as $row)
                    @if($row->request > 0)
                        <label class="label label-primary"
                               data-placement="top" data-toggle="tooltip" title="Requests">{!! $row->request !!}</label>
                        <label class="label {{ ($row->paid == 0)? 'label-danger' : 'label-success'}}"
                               data-placement="top" data-toggle="tooltip" title="Paid">{!! $row->paid !!}</label>
                        {{--@if(Auth::user()->clinic == 21 || Auth::user()->clinic == 22)
                            <label class="label {{ ($row->managed == 0)? 'label-info' : 'label-danger'}}"
                                   data-placement="top" data-toggle="tooltip" title="Un-Managed">{!! $row->managed !!}</label>
                        @endif--}}
                    @else
                        <label class="label label-danger">No Pending Request</label>
                    @endif
                @endforeach
            @else
                <label class="label label-danger" data-placement="top" data-toggle="tooltip" title="Requests">No Pending Request</label>
            @endif
        @endif




        @if(Request::is('overview'))
        <form id="charging{{ $patient->id }}" action="{{ url('scandirect') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
            <input type="hidden" name="barcode" value="{{ $patient->barcode }}">
        </form>
        @endif


    </td>
@endif