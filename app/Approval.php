<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Approval extends Model
{
	protected $table = "approvals";

    protected $fillable = [
        'patients_id', 'interns_id', 'approved_by', 'approved'
    ];

    public static function checkApprovalStatus($pid)
    {
        $approvalStatus = Approval::where('patients_id', '=', $pid)
                                    ->where('interns_id', '=', Auth::user()->id)
                                    ->whereDate('created_at', '=', Carbon::now()->toDateString())
                                    ->first();

        return $approvalStatus;
    }

}
