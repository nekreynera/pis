<?php

namespace App\Http\Controllers;

use App\Exports\CashierExport;
use Maatwebsite\Excel\Facades\Excel;
use Auth;
use Carbon;

class CashierExcelReportController extends Controller
{
	public function export()
    {
        return Excel::download(new CashierExport(), ''.Auth::user()->last_name.'-HOSPITAL INCOME(LBP):'.Carbon::parse(old('transdate'))->format('m-d-Y').'.xlsx');
    }

}