<?php

namespace App\Http\Controllers\OPDMS;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\JsonableInterface;
use App\Http\Controllers\Controller;
use DB;
use Auth;

class ActionsController extends Controller
{

    public function queued_action_buttons(Request $request)
    {
        $queue = DB::table('queues')->where([
                    ['queues.patients_id', $request->pid],
                    [DB::raw('DATE(queues.created_at)'), DB::raw('CURDATE()')],
                    [DB::raw('queues.clinic_code'), Auth::user()->clinic]
                ])->leftJoin('assignations', function($join){
                    $join->on('assignations.patients_id', 'queues.patients_id')
                        ->where([
                            [DB::raw('DATE(assignations.created_at)'), DB::raw('CURDATE()')],
                            [DB::raw('assignations.clinic_code'), Auth::user()->clinic]
                        ]);
                })->first();

        $data = array('queue' => $queue);

        echo json_encode($data);
        return;

    }


}
