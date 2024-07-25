@if(in_array(Auth::user()->clinic, $noDoctorsClinic))

    <td>

        @if($patient->queue_status == 'F')



                <a href="{{ url('queueStatus/'.$patient->qid.'/P') }}"
                   data-placement="top" data-toggle="tooltip" title="Click to revert"
                   class="btn btn-warning btn-circle" data-toggle=""
                   onclick="return confirm('Do you really want to revert this patient?')">
                    <i class="fa fa-refresh"></i>
                </a>

        @else
            @php $done = 'disabled' @endphp
            @foreach($charging as $row)
                @php
                    <!-- $done = ($row->paid <= 0 || $patient->queue_status == 'D')? 'disabled' : ''; -->
                    $done = ($row->paid <= 0 || $patient->queue_status == 'D')? '' : '';
                @endphp
            @endforeach


                <a href="{{ url('queueStatus/'.$patient->qid.'/F') }}"
                   data-placement="top" data-toggle="tooltip" title="Click to mark as done"
                   class="btn btn-circle {{ $done }} {{ ($done != 'disabled')? 'btn-primary' : 'btn-default' }}"
                   onclick="return confirm('Do you really want to marked this patient as done?')">
                    <i class="fa fa-check"></i>
                </a>


        @endif

    </td>

@endif