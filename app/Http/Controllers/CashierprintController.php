<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Patient;
use App\Mss;
use App\Mssclassification;
use App\User;
use App\Cashrecieptno;
use App\Cashidsale;
use App\Sales;
use PDF;
use DNS1D;
use DB;
use Carbon;
use Auth;
use Session;

class CashierprintController extends Controller
{
	
	public function printreciept()
	{

		$number = strtoupper($this->convertNumberToWord(125.50));
		$string = 'SILVER SULFADIAZINE CREAM 1% 500G';
		PDF::SetTitle('TRANSACTION RECIEPT');
		PDF::SetAutoPageBreak(TRUE, 0);
		// ob_start();
		PDF::AddPage('P',array(115,203));
		PDF::SetFont('helvetica','',10);
		PDF::SetMargins(0,0,0);
		PDF::SetXY(60,50);
		PDF::Cell(30,5,'1/10/2018',0,0,'C');
		
		PDF::SetXY(43,175);
		PDF::Cell(50,5,'SONIA O. BELTRAN',0,0,'C');
		PDF::SetXY(25,65);
		PDF::Cell(70,5,'DARRYL JOSEPH A. BAGARES',0,0);
		
		
		PDF::SetXY(17,77);
		for ($i=1; $i <= 10  ; $i++) { 
			$y = PDF::GetY()+5;
			PDF::SetXY(15,$y);
			PDF::Cell(40,5,''.substr($string,0,19).'...',0,0);
			PDF::SetXY(75,$y);
			PDF::Cell(25,5,'100.0'.$i.'',0,0,'C');

		}
		$y = PDF::GetY()+5;
		PDF::SetXY(75,$y);
		PDF::Cell(25,5,'125.0'.$i.'',0,0,'C');
		PDF::SetXY(20,140);
		PDF::Cell(70,5,""."$number"." PESOS ONLY",1,0,'C');
		
		
		// ob_end_clean();
		PDF::Output();
		return;
	}

}