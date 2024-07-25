<?php

    //color coding of patient status

    if($queue->status == 'F'){
        $text = 'Finished';
        $status_color = 'bg-blue';
    }elseif($queue->status == 'P'){
        $text = 'Pending';
        $status_color = 'bg-orange';
    }elseif($queue->status == 'H'){
        $text = 'Paused';
        $status_color = 'bg-brown';
    }elseif($queue->status == 'C'){
        $text = 'NAWC';
        $status_color = 'bg-red';
    }elseif($queue->status == 'S'){
        $text = 'Serving';
        $status_color = 'bg-green';
    }else{
        $text = 'Unassigned';
        $status_color = 'bg-purple';
    }

?>

<td class="{{ $status_color }}">{{ $text }}</td>
