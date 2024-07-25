{{-- patient status goes here --}}

<?php

//color coding of patient status

//$pending_status = ($status == 'P')? 'bg-orange' : 'btn-default';
//$paused_status = ($status == 'H')? 'bg-brown' : 'btn-default';
//$canceled_status = ($status == 'C')? 'bg-red' : 'btn-default';
//$serving_status = ($status == 'S')? 'bg-green' : 'btn-default';
//$finished_status = ($status == 'F')? 'bg-blue' : 'btn-default';
//$all_status = ($status == 'A')? 'bg-black' : 'btn-default';
//$unassigned_status = ($status)? 'btn-default' : 'bg-purple';



        /* queue count show total on button of status */
$queue_count_sum = 0;
foreach ($queue_count as $row){
    $queue_count_sum += $row->total;
    if(!$row->status){ $unassigned_total = $row->total; }
    if($row->status == 'P'){ $pending_total = $row->total; }
    if($row->status == 'H'){ $paused_total = $row->total; }
    if($row->status == 'C'){ $nawc_total = $row->total; }
    if($row->status == 'S'){ $serving_total = $row->total; }
    if($row->status == 'F'){ $finished_total = $row->total; }
}

?>


<div class="box-header with-border">
    <a href="{{ url('patient_queue') }}" class="btn btn-flat bg-purple"
       onclick="full_window_loader()">
        Unassigned
        <span class="badge bg-gray">
            {{ $unassigned_total or 0 }}
        </span>
    </a>
    <a href="{{ url('patient_queue/P') }}" class="btn btn-flat bg-orange"
       onclick="full_window_loader()">
        Pending
        <span class="badge bg-gray">
            {{ $pending_total or 0 }}
        </span>
    </a>
    <a href="{{ url('patient_queue/H') }}" class="btn btn-flat bg-brown"
       onclick="full_window_loader()">
        Paused
        <span class="badge bg-gray">
            {{ $paused_total or 0 }}
        </span>
    </a>
    <a href="{{ url('patient_queue/C') }}" class="btn btn-flat bg-red"
       data-toggle="tooltip" title="Not Around When Called"
       onclick="full_window_loader()">
        NAWC
        <span class="badge bg-gray">
            {{ $nawc_total or 0 }}
        </span>
    </a>
    <a href="{{ url('patient_queue/S') }}" class="btn btn-flat bg-green"
       onclick="full_window_loader()">
        Serving
        <span class="badge bg-gray">
            {{ $serving_total or 0 }}
        </span>
    </a>
    <a href="{{ url('patient_queue/F') }}" class="btn btn-flat bg-blue"
       onclick="full_window_loader()">
        Finished
        <span class="badge bg-gray">
            {{ $finished_total or 0 }}
        </span>
    </a>
    <a href="{{ url('patient_queue/A') }}" class="btn btn-flat bg-black"
       data-toggle="tooltip" title="Show all queued patients"
       onclick="full_window_loader()">
        All
        <span class="badge bg-gray">
            {{ $queue_count_sum }}
        </span>
    </a>
</div>