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
use App\ConvertNumberToWord;
use App\Cashmanualsale;
use App\Cashcredintials;
use App\Cashincomecategory;
use App\Cashincomesubcategory;
use App\Cashincome;
use PDF;
use DNS1D;
use DB;
use Carbon;
use Auth;
use Session;

class CashierreportController extends Controller
{
            
      public function dailyreport(Request $request)
      {
        if ($request->exporttype == "EXCELL") {
          return redirect('exporttransactiontoexcell')->withInput();
        }
            $cshier_id = Auth::user()->id;
            if ($cshier_id == 150 || $cshier_id == 325) {
              $cshier_id = '150,325';
            }
            elseif ($cshier_id == 269 || $cshier_id == 259 || $cshier_id == 145) {
              $cshier_id = '269,259,145';
            }
            elseif ($cshier_id == 366 || $cshier_id == 320) {
              $cshier_id = '366,320';
            }

            // dd($request);
            if ($request->mortype == 'INCOME') {
            $data =  DB::select("SELECT h.void,
                                                      DATE(h.created_at) as dates, 
                                      h.or_no as numbers,
                                                      i.last_name, i.first_name, i.middle_name,
                                                      ('HOSPITAL ID') as particulars,
                                                  h.price as total,
                                      h.price as other,
                                      (' ') as medicines,
                                      (' ') as medical,
                                      (' ') as laboratory,
                                      (' ') as radiology,
                                      (' ') as cardiology,
                                      (' ') as supply,
                                      ('hospital id') as type
                                          FROM cashidsale h
                                          LEFT JOIN patients i ON h.patients_id = i.id
                                          LEFT JOIN users j ON h.users_id = j.id
                                          WHERE date(h.created_at) = ?
                                          AND h.users_id IN($cshier_id)
                                          GROUP BY h.or_no
                                          UNION 
                                          SELECT o.void,
                                            DATE(o.created_at) as dates,
                                            o.or_no as numbers,
                                            p.last_name, p.first_name, p.middle_name,
                                      (CASE 
                                          WHEN t.id IN(6,11,13)
                                          THEN s.sub_category
                                          WHEN s.type
                                          THEN s.sub_category
                                          ELSE t.category
                                       END) as particulars,
                                      (CASE 
                                          WHEN o.discount 
                                          THEN SUM(((o.qty * o.price) - o.discount) - COALESCE(pg.granted_amount, 0 ))
                                          ELSE SUM(((o.qty * o.price) - 0) - COALESCE(pg.granted_amount, 0 ))
                                       END) as total,
                                      (CASE 
                                          WHEN t.id IN(1, 2, 3, 4, 5, 7, 8, 13, 14, 15, 17, 18, 19)
                                          AND s.type = 0
                                          THEN (CASE 
                                                      WHEN o.discount 
                                                      THEN SUM(((o.qty * o.price) - o.discount) - COALESCE(pg.granted_amount, 0 ))
                                                      ELSE SUM(((o.qty * o.price) - 0) - COALESCE(pg.granted_amount, 0 ))
                                                 END) 
                                          ELSE  ' '
                                      END) as other,
                                      (' ') as medicines,
                                      (CASE 
                                          WHEN t.id IN(9) 
                                          AND s.type = 0
                                          THEN SUM(((o.qty * o.price) - o.discount) - COALESCE(pg.granted_amount, 0 ))
                                          ELSE ' '
                                      END) as medical,
                                      (CASE 
                                          WHEN t.id = 10 
                                          AND s.type = 0
                                          THEN SUM(((o.qty * o.price) - o.discount) - COALESCE(pg.granted_amount, 0 ))
                                          ELSE ' '
                                       END) as laboratory,
                                      (CASE 
                                          WHEN t.id IN(6,11) 
                                          AND s.type = 0
                                          THEN SUM(((o.qty * o.price) - o.discount) - COALESCE(pg.granted_amount, 0 ))
                                          ELSE ' '
                                       END) as radiology,
                                      (CASE 
                                          WHEN t.id IN(12) 
                                          THEN SUM(((o.qty * o.price) - o.discount) - COALESCE(pg.granted_amount, 0 ))
                                          ELSE ' '
                                       END) as cardiology,
                                       (CASE 
                                          WHEN s.type = 1 
                                          THEN SUM(((o.qty * o.price) - o.discount) - COALESCE(pg.granted_amount, 0 ))
                                        ELSE ' '
                                       END) as supply,
                                       ('income') as type 
                                          FROM cashincome o
                                          LEFT JOIN patients p ON o.patients_id = p.id
                                          LEFT JOIN mss q ON o.mss_id = q.id
                                          LEFT JOIN users r ON o.users_id = r.id
                                          LEFT JOIN cashincomesubcategory s ON o.category_id = s.id
                                          LEFT JOIN cashincomecategory t ON s.cashincomecategory_id = t.id
                                          -- LEFT JOIN payment_guarantor pg ON o.id = pg.payment_id AND pg.type = 0
                                          LEFT JOIN 
                                            (SELECT payment_id, SUM(granted_amount) as granted_amount FROM payment_guarantor WHERE type = 0 GROUP BY payment_id) pg 
                                          ON o.id = pg.payment_id
                                          WHERE date(o.created_at) = ?
                                          AND o.users_id IN($cshier_id)
                                          GROUP BY o.or_no, t.id
                                          UNION
                                          SELECT 
                                            u.void,
                                              DATE(u.created_at) as dates,
                                              u.or_no as numbers,
                                              x.last_name, x.first_name, x.middle_name,
                                              ('LABORATORY') as particulars,
                                              (SUM(((v.qty * u.price) - u.discount) - COALESCE(pgu.granted_amount, 0 ))) as total,
                                              ('') as other,
                                              ('') as medicines,
                                              ('') as medical,     
                                              (SUM(((v.qty * u.price) - u.discount) - COALESCE(pgu.granted_amount, 0 ))) as laboratory,
                                              ('') as radiology,
                                              ('') as cardiology,
                                              ('') as supply,
                                              ('income') as type
                                          FROM laboratory_payment u
                                          LEFT JOIN laboratory_requests v ON u.laboratory_request_id = v.id
                                          LEFT JOIN laboratory_request_groups w ON v.laboratory_request_group_id = w.id
                                          LEFT JOIN patients x ON w.patient_id = x.id
                                          LEFT JOIN laboratory_sub_list y ON v.item_id = y.id
                                          LEFT JOIN 
                                            (SELECT payment_id, SUM(granted_amount) as granted_amount FROM payment_guarantor WHERE type = 1 GROUP BY payment_id) pgu 
                                          ON u.id = pgu.payment_id
                                          WHERE DATE(u.created_at) = ?
                                          AND u.user_id IN($cshier_id)
                                          GROUP BY u.or_no
                                          ORDER BY numbers ASC
                                                      ", [
                                                            $request->transdate, 
                                                            $request->transdate, 
                                                            $request->transdate
                                                          ]);
           
            }elseif ($request->mortype == 'MEDICINE') {
                  $data = DB::select("SELECT a.void,
                                                      DATE(a.created_at) as dates,
                                                      a.or_no as numbers, 
                                                  e.last_name, e.first_name, e.middle_name,
                                                  ('DRUGS AND MEDICINES') as particulars,
                                     (CASE 
                                          WHEN f.discount 
                                          THEN SUM((b.qty * a.price) - ((b.qty * a.price) * f.discount)) 
                                          ELSE SUM(b.qty * a.price)  
                                      END) as total,
                                                 (' ') as other,
                                   (CASE 
                                          WHEN f.discount 
                                          THEN SUM((b.qty * a.price) - ((b.qty * a.price) * f.discount)) 
                                          ELSE SUM(b.qty * a.price)  
                                    END) as medicines,
                                   (' ') as medical,
                                   (' ') as laboratory,
                                   (' ') as radiology,
                                   (' ') as cardiology,
                                   (' ') as supply,
                                   ('pharmacy') as type
                                          FROM sales a
                                          LEFT JOIN pharmanagerequest b ON a.pharmanagerequest_id = b.id 
                                          LEFT JOIN requisition c ON b.requisition_id = c.id
                                          LEFT JOIN ancillary_items d ON c.item_id = d.id
                                          LEFT JOIN patients e ON c.patients_id = e.id
                                          LEFT JOIN mss f ON a.mss_id = f.id
                                          LEFT JOIN users g ON a.users_id = g.id
                                          WHERE date(a.created_at) = ?
                                          -- AND a.mss_id NOT IN(9,10,11,12,13)
                                          -- AND a.price > 0
                                          AND a.users_id = ?
                            GROUP BY a.or_no",  
                            [$request->transdate, Auth::user()->id]);
                  }
            $evrmc_logo = './public/images/evrmc-logo.png';
            if ($request->mortype == 'INCOME') {   

            $style = array('width' => 0.1, 'color' => array(0, 0, 0));
            PDF::SetTitle('CASHIER DAILY REPORT');
            // PDF::IncludeJS("print();");
            PDF::SetAutoPageBreak(TRUE, 0);
            PDF::AddPage('L', 'LEGAL');
            PDF::Image($evrmc_logo,10,3,16,16);
            PDF::SetFont('','B',12);
            // PDF::text(140,10,'REPORT OF COLLECTIONS AND DEPOSITS');
            PDF::SetFont('helvetica',12);
            PDF::text(10,20,'Entitty Name:');
            PDF::text(10,25,'Fund:');
            PDF::text(180,15,'Report No.');
            PDF::SetXY(220,15);
            PDF::Cell(25,5,"".$request->mreportno."",0,0,'C');
            PDF::text(180,20,'Sheet No.');
            PDF::text(225,20,''.PDF::getAliasNumPage().' of '.PDF::getAliasNbPages().'');
            PDF::SetXY(220,20);
            PDF::Cell(28,5,"",0,0,'C');/*================pageno*/


            PDF::text(180,25,'Date:');
            PDF::Line(55, 30, 125, 30, $style);
            PDF::Line(55, 25, 125, 25, $style);

            PDF::Line(220, 20, 245, 20, $style);
            PDF::Line(220, 25, 245, 25, $style);
            PDF::text(220,25,Carbon::parse($request->transdate)->format('M. d, Y'));
            PDF::Line(220, 30, 245, 30, $style);

            PDF::SetFont('','B');
            PDF::text(30,6,'EASTERN VISAYAS MEDICAL CENTER');
            PDF::text(30,11,'Tacloban City, Leyte, Philippines 6500');
            PDF::text(10,30,'HOSPITAL INCOME (LBP)');

            /*==============================END OF HEADER==================================*/
       
            PDF::SetFont('Helvetica','B',10);
            PDF::SetXY(10,35);
            PDF::MultiCell(50,20,"\nOfficial Receipt/\nReport of Collections\nby Sub-Collector",1,'C',false);
            PDF::Cell(22,5,"DATE",1,0,'C');
            PDF::SetFont('helvetica','',10);
            PDF::SetXY(32,55);
            PDF::Cell(28,5,"NUMBER",1,0,'C');
            PDF::SetXY(60,35);
            PDF::SetFont('helvetica','',7);
            PDF::MultiCell(17,25,"\n\n\n\n\nResponsibilty\nCenter\nCode",1,'C',false);
            PDF::SetXY(77,35);
            PDF::SetFont('Helvetica','',11);
            PDF::MultiCell(50,25,"\n\n\n\nPayor",1,'C',false);
            PDF::SetXY(77+50,35);
            PDF::MultiCell(45,25,"\n\n\n\nParticulars",1,'C',false);
            PDF::SetXY(77+95,35);
            PDF::SetFont('Helvetica','',8);
            PDF::MultiCell(23,25,"\n\n\n\n\n\nMFO/PAP",1,'C',false);
            PDF::SetXY(77+95+23,35);
            PDF::SetFont('Helvetica','',11);
            PDF::Cell(150,5,"AMOUNT",1,0,'C');
            PDF::SetXY(77+95+23,40);
            PDF::SetFont('Helvetica','B',11);
            PDF::MultiCell(21.42,20,"TOTAL\nPER\nOR",1,'C',false);
            PDF::SetXY(77+95+23+21.42,40);
            PDF::SetFont('Helvetica','B',7.5);
            PDF::MultiCell(21.42,20,"\nOTHER\nFEES\n(4020217099)",1,'C',false);
            PDF::SetXY(77+95+23+42.84,40);
            PDF::SetFont('Helvetica','B',6.5);
            PDF::MultiCell(21.42,20,"MEDICAL FEES \n- PHYSICAL MEDICINE & REHABILITATION\n SERVICES\n(4020217009)",1,'C',false);
            PDF::SetXY(77+95+23+64.26,40);
            PDF::SetFont('Helvetica','B',7.5);
            PDF::MultiCell(21.42,20,"\nLABORATORY (4020217005)",1,'C',false);
            PDF::SetXY(77+95+23+85.68,40);
            PDF::MultiCell(21.42,20,"\nRADIOLOGY (4020217004)",1,'C',false);
            PDF::SetXY(77+95+23+107.1,40);
            PDF::MultiCell(21.42,20,"\nCARDIOLOGY (4020217007)",1,'C',false);
            PDF::SetXY(77+95+23+107.1+21.42,40);
            PDF::MultiCell(21.42,20,"\nMEDICAL SUPPLIES (40217002)",1,'C',false);

            /*============================END OF TABLE HEADER=================================*/
            $i = 0;
            $y = PDF::GetY();
            PDF::SetXY(10,$y);
            if (count($data) > 0) {
              PDF::Cell(22,5,Carbon::parse($data[0]->dates)->format('m/d/Y'),1,0,'C');/*==========date*/
            }else{
              PDF::Cell(22,5,"",1,0,'C');/*==========date*/
            }
                  
            $total = 0;
            $other = 0;
            $medical = 0;
            $laboratory = 0;
            $radiology = 0;
            $cardiology = 0;
            $supply = 0;
            // dd(count($data));
            PDF::SetFont('','',8);
            PDF::text(330,103+95,'CASH-RCD');
            PDF::text(322,106.5+95,'13-February-2019');
            PDF::text(335,110+95,'Rev. 00');
            foreach ($data as $list) {
                    for ($trim = 27;$trim<=2966;$trim+=31) {

                      if($i == $trim){
                        PDF::SetAutoPageBreak(TRUE, 0);
                        PDF::AddPage('L', 'LEGAL');

                        PDF::SetFont('Helvetica','B',10);
                        PDF::SetXY(10,15);
                        PDF::MultiCell(50,20,"\nOfficial Receipt/\nReport of Collections\nby Sub-Collector",1,'C',false);
                        PDF::Cell(22,5,"DATE",1,0,'C');
                        PDF::SetFont('helvetica','',10);
                        PDF::SetXY(32,35);
                        PDF::Cell(28,5,"NUMBER",1,0,'C');
                        PDF::SetXY(60,15);
                        PDF::SetFont('helvetica','',7);
                        PDF::MultiCell(17,25,"\n\n\n\n\nResponsibilty\nCenter\nCode",1,'C',false);
                        PDF::SetXY(77,15);
                        PDF::SetFont('Helvetica','',11);
                        PDF::MultiCell(50,25,"\n\n\n\nPayor",1,'C',false);
                        PDF::SetXY(77+50,15);
                        PDF::MultiCell(45,25,"\n\n\n\nParticulars",1,'C',false);
                        PDF::SetXY(77+95,15);
                        PDF::SetFont('Helvetica','',8);
                        PDF::MultiCell(23,25,"\n\n\n\n\n\nMFO/PAP",1,'C',false);
                        PDF::SetXY(77+95+23,15);
                        PDF::SetFont('Helvetica','',11);
                        PDF::Cell(150,5,"AMOUNT",1,0,'C');
                        PDF::SetXY(77+95+23,20);
                        PDF::SetFont('Helvetica','B',11);
                        PDF::MultiCell(21.42,20,"TOTAL\nPER\nOR",1,'C',false);
                        PDF::SetXY(77+95+23+21.42,20);
                        PDF::SetFont('Helvetica','B',7.5);
                        PDF::MultiCell(21.42,20,"\nOTHER\nFEES\n(4020217099)",1,'C',false);
                        PDF::SetXY(77+95+23+42.84,20);
                        PDF::SetFont('Helvetica','B',6.5);
                        PDF::MultiCell(21.42,20,"MEDICAL FEES \n- PHYSICAL MEDICINE & REHABILITATION\n SERVICES\n(4020217009)",1,'C',false);
                        PDF::SetXY(77+95+23+64.26,20);
                        PDF::SetFont('Helvetica','B',7.5);
                        PDF::MultiCell(21.42,20,"\nLABORATORY (4020217005)",1,'C',false);
                        PDF::SetXY(77+95+23+85.68,20);
                        PDF::MultiCell(21.42,20,"\nRADIOLOGY (4020217004)",1,'C',false);
                        PDF::SetXY(77+95+23+107.1,20);
                        PDF::MultiCell(21.42,20,"\nCARDIOLOGY (4020217007)",1,'C',false);
                        PDF::SetXY(77+95+23+107.1+21.42,20);
                        PDF::MultiCell(21.42,20,"\nMEDICAL SUPPLIES (40217002)",1,'C',false);

                        /*============================END OF TABLE HEADER=================================*/

                        
                          $y = 40;

                        PDF::SetFont('','',8);
                        PDF::text(330,103+95,'CASH-RCD');
                        PDF::text(322,106.5+95,'13-February-2019');
                        PDF::text(335,110+95,'Rev. 00');
                    }
                  }
                  
                  PDF::SetFont('Helvetica','',9.5);
                  PDF::SetXY(10,$y);
                  PDF::Cell(22,5,'',1,0,'C');/*==========date*/

                  PDF::SetXY(10+22,$y);
                  if ($list->numbers == "7880778" || $list->numbers == "7911130" || $list->numbers == "7918724") {
                  PDF::Cell(28,5,$list->numbers.' - Check',1,0,'C');/*===========number*/
                  }else{
                  PDF::Cell(28,5,$list->numbers,1,0,'C');/*===========number*/
                  }

                  PDF::SetXY(10+50,$y);
                  PDF::Cell(17,5,"",1,0,'C');/*============rcc*/

                  PDF::SetXY(10+50+17,$y);
                  PDF::Cell(50,5,"".$list->last_name.", ".$list->first_name." ".substr($list->middle_name,0,1).".",1,0,'');/*============payor*/

                  PDF::SetXY(10+100+17,$y);
                  if ($list->void == 1) {
                   PDF::Cell(45,5,'CANCELLED',1,0,'C');/*============particular*/     # code...
                  }else{
                   PDF::Cell(45,5,strtoupper($list->particulars),1,0,'');/*============particular*/     
                  }
                  

                  PDF::SetXY(10+145+17,$y);
                  PDF::Cell(23,5,"",1,0,'C');/*============mfo/pap*/

                  PDF::SetXY(10+145+40,$y);
                  if ($list->void == 1) {
                        PDF::Cell(21.42,5,"-",1,0,'R');/*============total*/  
                        PDF::SetXY(10+145+40+21.42,$y);
                        PDF::Cell(21.42,5,"",1,0,'R');/*============other*/
                        PDF::SetXY(10+145+40+42.84,$y);
                        PDF::Cell(21.42,5,"",1,0,'R');  
                        PDF::SetXY(10+145+40+64.26,$y); 
                        PDF::Cell(21.42,5,"",1,0,'R');
                        PDF::SetXY(10+145+40+85.68,$y);
                        PDF::Cell(21.42,5,"",1,0,'R');
                        PDF::SetXY(10+145+40+107.1,$y);
                        PDF::Cell(21.42,5,"",1,0,'R');
                        PDF::SetXY(10+145+40+107.1+21.42,$y);
                        PDF::Cell(21.42,5,"",1,0,'R');
                  }else{
                        PDF::Cell(21.42,5,"".number_format(($list->total), 2, '.', ',')."",1,0,'R');/*============total*/
                        $total += $list->total;
                        PDF::SetXY(10+145+40+21.42,$y);
                        if ($list->other  > 0) {

                        PDF::Cell(21.42,5,"".number_format($list->other, 2, '.', ',')."",1,0,'R');/*============other*/
                        $other += $list->other;
                        }
                        else{
                        PDF::Cell(21.42,5,"",1,0,'R');   
                        }
                        PDF::SetXY(10+145+40+42.84,$y);
                        if ($list->medical > 0) {
                        PDF::Cell(21.42,5,"".number_format($list->medical, 2, '.', ',')."",1,0,'R');/*============mp/mrs*/
                        $medical += $list->medical;
                        }
                        else{
                        PDF::Cell(21.42,5,"",1,0,'R');   
                        }
                        PDF::SetXY(10+145+40+64.26,$y);
                        if ($list->laboratory > 0) {
                        PDF::Cell(21.42,5,"".number_format($list->laboratory, 2, '.', ',')."",1,0,'R');/*============lab*/
                        $laboratory += $list->laboratory;
                        } else {
                        PDF::Cell(21.42,5,"",1,0,'R');
                        }
                        PDF::SetXY(10+145+40+85.68,$y);
                        if ($list->radiology > 0) {
                        PDF::Cell(21.42,5,"".number_format($list->radiology, 2, '.', ',')."",1,0,'R');/*============rad*/
                        $radiology += $list->radiology;
                        } else {
                        PDF::Cell(21.42,5,"",1,0,'R');
                        }
                        PDF::SetXY(10+145+40+107.1,$y);
                        if ($list->cardiology > 0) {

                        PDF::Cell(21.42,5,"".number_format($list->cardiology, 2, '.', ',')."",1,0,'R');/*============card*/
                        $cardiology += $list->cardiology;
                        } else {
                        PDF::Cell(21.42,5,"",1,0,'R');
                        }
                        PDF::SetXY(10+145+40+107.1+21.42,$y);
                        if ($list->supply > 0) {

                        PDF::Cell(21.42,5,"".number_format($list->supply, 2, '.', ',')."",1,0,'R');/*============card*/
                        $supply += $list->supply;
                        } else {
                        PDF::Cell(21.42,5,"",1,0,'R');
                        }

                  }     

                  
                  
                  $y+=5;
                  $i++;
            }
            /*==================END OF TRANSACTION BODY============================================*/
            PDF::SetFont('Helvetica','',11);
            PDF::SetXY(10,$y);
            PDF::Cell(22,5,"",1,0,'C');/*==========date*/

            PDF::SetXY(10+22,$y);
            PDF::Cell(28,5,"",1,0,'C');/*===========number*/

            PDF::SetXY(10+50,$y);
            PDF::Cell(17,5,"",1,0,'C');/*============rcc*/

            PDF::SetXY(10+50+17,$y);
            PDF::Cell(50,5,"",1,0,'C');/*============payor*/

            PDF::SetXY(10+100+17,$y);
            PDF::Cell(45,5,"",1,0,'C');/*============particular*/

            PDF::SetXY(10+145+17,$y);
            PDF::Cell(23,5,"",1,0,'C');/*============mfo/pap*/
            PDF::SetFont('Helvetica','B',11);
            PDF::SetXY(10+145+40,$y);
            PDF::Cell(21.42,5,"".number_format($total, 2, '.', ',')."",1,0,'R');/*============total*/

            PDF::SetXY(10+145+40+21.42,$y);
            PDF::Cell(21.42,5,"".number_format($other, 2, '.', ',')."",1,0,'R');/*============other*/

            PDF::SetXY(10+145+40+42.84,$y);
            PDF::Cell(21.42,5,"".number_format($medical, 2, '.', ',')."",1,0,'R');/*============mp/mrs*/

            PDF::SetXY(10+145+40+64.26,$y);
            PDF::Cell(21.42,5,"".number_format($laboratory, 2, '.', ',')."",1,0,'R');/*============lab*/

            PDF::SetXY(10+145+40+85.68,$y);
            PDF::Cell(21.42,5,"".number_format($radiology, 2, '.', ',')."",1,0,'R');/*============rad*/

            PDF::SetXY(10+145+40+107.10,$y);
            PDF::Cell(21.42,5,"".number_format($cardiology, 2, '.', ',')."",1,0,'R');/*============card*/
            PDF::SetXY(10+145+40+107.10+21.42,$y);
            PDF::Cell(21.42,5,"".number_format($supply, 2, '.', ',')."",1,0,'R');/*============supply*/
            PDF::SetFont('Helvetica','',12);
            

            /*====================END OF TRANSACTION TOTAL============================================*/
            
            if (PDF::getY() >= 150) {
              PDF::SetAutoPageBreak(TRUE, 0);
              PDF::AddPage('L', 'LEGAL');
              $y = -40;
            }
            
      
            $y = PDF::GetY()+5;
            PDF::SetFont('Helvetica','', 12);
            PDF::text(32,$y,'Summary');
            PDF::text(32,$y+5,'Undeposited Collections per last Report');
            PDF::SetFont('Helvetica','', 12);
            if (count($data) > 0) {
              PDF::text(32,$y+10,'Collections per OR Nos.              '.$data[0]->numbers.' - '.substr($list->numbers,4,3).'');
            }else{
              PDF::text(32,$y+10,'Collections per OR Nos.');
            }
            
            if (Auth::user()->id == 150 
                && Carbon::parse($request->transdate)->format('m/d/Y') >= Carbon::parse('01/15/2019')->format('m/d/Y') 
                && Carbon::parse($request->transdate)->format('m/d/Y') <= Carbon::parse('01/26/2019')->format('m/d/Y')) 
            {
            $sum = 50 + $request->undeposited;
            }else{
            $sum = 0 + $request->undeposited;
            }
            $subtotal = 0 + $total;
            $totals = $sum + $subtotal;
            PDF::SetXY(220,$y+5);
            if ($sum > 0) {
            PDF::Cell(25,5,"".number_format($sum, 2, '.', ',')."",0,0,'R');/*===========sum*/
            }else{
            PDF::Cell(25,5,"-",0,0,'R');/*===========sum*/  
            }

            PDF::SetXY(220,$y+10);
            PDF::Cell(25,5,"".number_format($subtotal, 2, '.', ',')."",0,0,'R');/*===========subtotal*/

            PDF::Line(220, $y+15, 245, $y+15, $style);
            PDF::SetFont('Helvetica','B', 12);
            PDF::text(87,$y+10,'');/*===========or scope*/
            PDF::SetFont('Helvetica','B', 12);

            PDF::SetXY(220,$y+15);
            PDF::Cell(25,5,"".number_format($totals, 2, '.', ',')."",0,0,'R');/*===========total*/

            PDF::SetFont('Helvetica','', 12);
            $today = Carbon::parse($request->transdate)->format('l');
                  if ($today == 'Saturday') {
                       PDF::text(60,$y+20,'Deposits');/*===========sum*/ 
                       PDF::text(60,$y+30,'Date:');
                  }else{
                       PDF::text(60,$y+20,'Deposits        '.$request->mgstart.'');/*===========sum*/ 
                       PDF::text(60,$y+30,'Date:             '.$request->mgdate.'');
                  }
            PDF::SetXY(220,$y+30);
            if ($sum > 0) {
                  if ($today == 'Saturday') {
                       PDF::Cell(25,5," ",0,0,'R');/*===========sum*/ 
                  }else{
                      if (Auth::user()->id == 150 
                          && Carbon::parse($request->transdate)->format('m/d/Y') >= Carbon::parse('01/15/2019')->format('m/d/Y') 
                          && Carbon::parse($request->transdate)->format('m/d/Y') <= Carbon::parse('01/26/2019')->format('m/d/Y')) 
                      {
                        $sum-=50;
                      }
                      PDF::Cell(25,5,"".number_format($sum, 2, '.', ',')."",0,0,'R');/*===========sum*/ 


                  }
            }else{
            PDF::Cell(25,5,"-",0,0,'R');/*===========sum*/
            }
            PDF::Line(220, $y+35, 245, $y+35, $style);
            PDF::Line(220, $y+35.7, 245, $y+35.7, $style);
            PDF::SetXY(220,$y+35.9);
            if ($today == 'Saturday') {
                if (Auth::user()->id == 150 
                  && Carbon::parse($request->transdate)->format('m/d/Y') >= Carbon::parse('01/15/2019')->format('m/d/Y') 
                  && Carbon::parse($request->transdate)->format('m/d/Y') <= Carbon::parse('01/26/2019')->format('m/d/Y')) 
                {
                  $totals+=50;
                }
                 PDF::Cell(25,5,"".number_format($totals, 2, '.', ',')."",0,0,'R');/*===========subtotal*/
            }else{
                if (Auth::user()->id == 150 
                  && Carbon::parse($request->transdate)->format('m/d/Y') >= Carbon::parse('01/15/2019')->format('m/d/Y') 
                  && Carbon::parse($request->transdate)->format('m/d/Y') <= Carbon::parse('01/26/2019')->format('m/d/Y')) 
                {
                  $subtotal+=50;
                }
                 PDF::Cell(25,5,"".number_format($subtotal, 2, '.', ',')."",0,0,'R');/*===========subtotal*/
            }
            
            PDF::text(32,$y+35,'Undeposited Collections, this Report');
            // dd($i);
            /*============================end of footer============================*/
            // for ($trim = 29;$trim<=$i+33;$trim+=33) {
            //   if($i>=($trim-30) && $i < ($trim-15)){/*-11*/
            //     PDF::SetAutoPageBreak(TRUE, 0);
            //     PDF::AddPage('L', 'LEGAL');
            //     $y = -40;
            //   }
            // }
            if (PDF::getY() >= 150) {
              PDF::SetAutoPageBreak(TRUE, 0);
              PDF::AddPage('L', 'LEGAL');
              $y = -40;
            }
            
            

            PDF::Line(10, $y+45.7, 345, $y+45.7, $style);
            PDF::SetFont('','', 12);
            PDF::text(160,$y+45.8,'CERTIFICATION');
            PDF::Line(10, $y+50.7, 345, $y+50.7, $style);


            PDF::SetFont('Helvetica','', 12);
            PDF::text(32,$y+55,'I hereby certify on my official oath that the above is a true statement of all collections and deposits had by me during the period stated above which  Official');
            PDF::text(10,$y+60,'Receipts Nos.');
            PDF::SetFont('Helvetica','B', 12);
            if (count($data) > 0) {
              PDF::text(45,$y+60,''.$data[0]->numbers.' - '.substr($list->numbers,4,3).'')/*===================or scope*/;
            }else{
              PDF::text(45,$y+60,'')/*===================or scope*/;
            }
            
            PDF::SetFont('Helvetica','', 12);
            PDF::text(75,$y+60,'inclusive were actually issued by me in the amounts shown thereon. I also certify that I have not received money from whatever ');
            PDF::text(10,$y+65,'source without  having issued the necessary Official Receipt in acknowledgement thereof. Collections received by sub-collectors are recorded above in lump-sum ');
            PDF::text(10,$y+70,'opposite their respective collector  report numbers. I certify further that the balance shown above agrees with the balance appearing in my Cash Receipts Record.');

            PDF::SetFont('Helvetica','', 12);
            PDF::text(32,$y+80,'Prepared by:');
            PDF::text(200,$y+80,'Reviewed by:');

            $y = PDF::GetY();
            PDF::SetXY(32,$y+5);
            PDF::SetFont('Helvetica','B', 12);
            PDF::Cell(100,5,"".strtoupper(Auth::user()->first_name." ".substr(Auth::user()->middle_name,0,1).". ".Auth::user()->last_name)."",0,0,'C');/*=============Name*/
            PDF::SetXY(32,$y+10);
            PDF::SetFont('Helvetica','', 12);
            PDF::Cell(100,5,'Name and Signature of the Collecting Officer',0,0,'C');
            PDF::SetXY(32,$y+15);
            PDF::SetFont('Helvetica','', 12);
            PDF::Cell(100,5,''.strtoupper($request->msdisignation).'',0,0,'C');/*=============ITEM*/
            PDF::SetXY(32,$y+20);
            PDF::Cell(100,5,'Official Designation',0,0,'C');

            PDF::SetXY(32,$y+25);
            PDF::SetFont('','', 12);
            PDF::Cell(100,5,'Date: '.Carbon::now()->format('M d, Y'),0,0,'C');
            
            PDF::SetXY(190,$y+10);
            PDF::SetFont('Helvetica','B', 12);
            PDF::Cell(100,5,'EDENIA S. EGUIA',0,0,'C');
            PDF::SetXY(190,$y+15);
            PDF::SetFont('Helvetica','', 12);
            PDF::Cell(100,5,'Supervising Administrative Officer',0,0,'C');
            PDF::SetXY(190,$y+20);
            PDF::Cell(100,5,'Cash Operation Section',0,0,'C');
            PDF::Line(10, $y+35, 345, $y+35, $style);

            PDF::SetFont('','',8);
            PDF::text(330,103+95,'CASH-RCD');
            PDF::text(322,106.5+95,'13-February-2019');
            PDF::text(335,110+95,'Rev. 00');

        PDF::Output();
            return;
            }elseif ($request->mortype == 'MEDICINE') {

                  $style = array('width' => 0.1, 'color' => array(0, 0, 0));
                  PDF::SetTitle('CASHIER DAILY REPORT');
                  // PDF::IncludeJS("print();");
                  PDF::SetAutoPageBreak(TRUE, 0);
                  PDF::AddPage('L', 'LEGAL');

                  PDF::SetFont('','B',11);
                  PDF::text(140,5,'REPORT OF COLLECTIONS AND DEPOSITS');
                  PDF::SetFont('helvetica',11);
                  PDF::text(10,15,'Entitty Name:');
                  PDF::text(10,25,'Fund:');
                  PDF::text(180,15,'Report No.');
                  PDF::SetXY(220,15);
                  PDF::Cell(28,5,"".$request->mreportno."",0,0,'C');
                  PDF::text(180,20,'Sheet No.');
                  PDF::SetXY(220,20);
                  PDF::Cell(28,5,"",0,0,'C');/*================pageno*/


                  PDF::text(180,25,'Date:');
                  PDF::Line(55, 20, 125, 20, $style);
                  PDF::Line(55, 25, 125, 25, $style);

                  PDF::Line(220, 20, 245, 20, $style);
                  PDF::Line(220, 25, 245, 25, $style);
                  PDF::text(220,25,Carbon::parse($request->transdate)->format('M. d, Y'));
                  PDF::Line(220, 30, 245, 30, $style);

                  PDF::SetFont('','B');
                  PDF::text(55,15,'EASTERN VISAYAS MEDICAL CENTER');
                  PDF::text(10,30,'REVOLVING FUND (DBP)-MEDICINE');

              /*==============================END OF HEADER==================================*/
             
                  PDF::SetFont('','B',10);
                  PDF::SetXY(10,35);
                  PDF::MultiCell(70,20,"\nOfficial Receipt/\nReport of Collections\nby Sub-Collector",1,'C',false);
                  PDF::Cell(35,5,"DATE",1,0,'C');
                  PDF::SetFont('helvetica','',10);
                  PDF::SetXY(45,55);
                  PDF::Cell(35,5,"NUMBER",1,0,'C');
                  PDF::SetXY(80,35);
                  PDF::SetFont('helvetica','',7);
                  PDF::MultiCell(20,25,"\n\n\n\n\nResponsibilty\nCenter\nCode",1,'C',false);
                  PDF::SetXY(100,35);
                  PDF::SetFont('','',11);
                  PDF::MultiCell(60,25,"\n\n\n\nPayor",1,'C',false);
                  PDF::SetXY(77+50+33,35);
                  PDF::MultiCell(55,25,"\n\n\n\nParticulars",1,'C',false);
                  PDF::SetXY(77+138,35);
                  PDF::SetFont('','',8);
                  PDF::MultiCell(30,25,"\n\n\n\n\n\nMFO/PAP",1,'C',false);
                  PDF::SetXY(77+95+73,35);
                  PDF::SetFont('','',11);
                  PDF::Cell(100,5,"AMOUNT",1,0,'C');
                  PDF::SetXY(77+95+73,40);
                  PDF::SetFont('Helvetica','B',11);
                  PDF::MultiCell(50,20,"TOTAL\nPER\nOR",1,'C',false);
                  PDF::SetXY(77+95+23+100,40);
                  PDF::SetFont('Helvetica','B',11);
                  PDF::MultiCell(50,20,"DRUGS AND\n MEDICINES\n(4020217001)",1,'C',false);
                  // PDF::SetXY(77+95+23+50,40);
                  
                  PDF::SetFont('Helvetica','',9);

                  /*============================END OF TABLE HEADER=================================*/
                  $i = 0;
                  $y = PDF::GetY();
                  PDF::SetXY(10,$y);
                  if (count($data) > 0) {
                     PDF::Cell(35,5,Carbon::parse($data[0]->dates)->format('m/d/Y'),1,0,'C');/*==========date*/
                  }else{
                     PDF::Cell(35,5,"",1,0,'C');/*==========date*/
                  }
                       
                  $total = 0;
                  $medicines = 0;
                  foreach ($data as $list) {
                        if ($i == 27 || $i == 66 || $i == 103 || $i == 140 || $i == 177 || $i == 214 || $i == 251 || $i == 288 || $i == 325) {
                              PDF::SetAutoPageBreak(TRUE, 0);
                              PDF::AddPage('L', 'LEGAL');
                              $y = 20;
                        }
                        PDF::SetXY(10,$y);
                        PDF::Cell(35,5,'',1,0,'C');/*==========date*/

                        PDF::SetXY(10+35,$y);
                        PDF::Cell(35,5,$list->numbers,1,0,'C');/*===========number*/

                        PDF::SetXY(10+70,$y);
                        PDF::Cell(20,5,"",1,0,'C');/*============rcc*/

                        PDF::SetXY(10+70+20,$y);
                        PDF::Cell(60,5,"".$list->last_name.", ".$list->first_name." ".substr($list->middle_name,0,1).".",1,0,'');/*============payor*/

                        PDF::SetXY(10+100+50,$y);
                        if ($list->void == 1) {
                        PDF::Cell(55,5,"CANCELLED",1,0,'C');/*============particular*/
                        }else{
                        PDF::Cell(55,5,$list->particulars,1,0,'C');/*============particular*/
                        }
                        

                        PDF::SetXY(10+100+105,$y);
                        PDF::Cell(30,5,"",1,0,'C');/*============mfo/pap*/

                        PDF::SetXY(10+100+135,$y);
                        if ($list->void == 1) {
                        PDF::Cell(50,5,"-",1,0,'R');/*============total*/
                        }else{
                        PDF::Cell(50,5,"".number_format($list->total, 2, '.', ',')."",1,0,'R');/*============total*/
                        $total += $list->total;      
                        }
                        

                        PDF::SetXY(10+150+135,$y);
                        if ($list->void == 1) {
                        PDF::Cell(50,5,"",1,0,'R');/*============other*/
                        }else{
                        if ($list->medicines  > 0) {
                        PDF::Cell(50,5,"".number_format($list->medicines, 2, '.', ',')."",1,0,'R');/*============other*/
                        $medicines += $list->medicines;
                        }
                        }
                        
                        $y+=5;
                        $i++;
                  }
                  /*==================END OF TRANSACTION BODY============================================*/
                  PDF::SetFont('Helvetica','B',11);
                  PDF::SetXY(10,$y);
                  PDF::Cell(35,5,'',1,0,'C');/*==========date*/

                  PDF::SetXY(10+35,$y);
                  PDF::Cell(35,5,"",1,0,'C');/*===========number*/

                  PDF::SetXY(10+70,$y);
                  PDF::Cell(20,5,"",1,0,'C');/*============rcc*/

                  PDF::SetXY(10+70+20,$y);
                  PDF::Cell(60,5,"",1,0,'');/*============payor*/

                  PDF::SetXY(10+100+50,$y);
                  PDF::Cell(55,5,"",1,0,'C');/*============particular*/

                  PDF::SetXY(10+100+105,$y);
                  PDF::Cell(30,5,"",1,0,'C');/*============mfo/pap*/

                  PDF::SetXY(10+100+135,$y);
                  PDF::Cell(50,5,"".number_format($total, 2, '.', ',')."",1,0,'R');/*============total*/

                  PDF::SetXY(10+150+135,$y);
                  PDF::Cell(50,5,"".number_format($medicines, 2, '.', ',')."",1,0,'R');/*============other*/
                  PDF::SetFont('Helvetica','',11);
             

                  /*====================END OF TRANSACTION TOTAL============================================*/

                         


                  
             

                  /*============================end of footer============================*/
             

                    // dd($i);
                        if ($i >= 16 && $i <= 29 ||
                          $i >= 52 && $i <= 66 ||
                          $i >= 89 && $i <= 103 ||
                          $i >= 126 && $i <= 140 ||
                          $i >= 163 && $i <= 177 ||
                          $i >= 200 && $i <= 214 ||
                          $i >= 237 && $i <= 251 ||
                          $i >= 274 && $i <= 288 ||
                          $i >= 311 && $i <= 325) {
                        
                       
                        PDF::SetAutoPageBreak(TRUE, 0);
                            PDF::AddPage('L', 'LEGAL');
                             $y = -40;  
                        //     $y = 20; 
                        }
            $y = PDF::GetY()+5;
                   
                  PDF::SetFont('Helvetica','', 11);
                  PDF::text(32,$y,'Summary');
                  PDF::text(32,$y+5,'Undeposited Collections per last Report');
                  PDF::SetFont('Helvetica','', 10);
                  if (count($data) > 0) {
                     PDF::text(32,$y+10,'Collections per OR Nos.              '.$data[0]->numbers.' - '.substr($list->numbers,4,3).'');
                  }else{
                     PDF::text(32,$y+10,'Collections per OR Nos.');
                  }
                  
                  $sum = 0 + $request->undeposited;
                  $subtotal = 0 + $total;
                  $totals = $sum + $subtotal;
                  PDF::SetXY(220,$y+5);
                  if ($sum > 0) {
                  PDF::Cell(25,5,"".number_format($sum, 2, '.', ',')."",0,0,'R');/*===========sum*/
                  }else{
                  PDF::Cell(25,5,"-",0,0,'R');/*===========sum*/  
                  }

                  PDF::SetXY(220,$y+10);
                  PDF::Cell(25,5,"".number_format($subtotal, 2, '.', ',')."",0,0,'R');/*===========subtotal*/

                  PDF::Line(220, $y+15, 245, $y+15, $style);
                  PDF::SetFont('Helvetica','B', 12);
                  PDF::text(87,$y+10,'');/*===========or scope*/
                  PDF::SetFont('Helvetica','B', 10);

                  PDF::SetXY(220,$y+15);
                  PDF::Cell(25,5,"".number_format($totals, 2, '.', ',')."",0,0,'R');/*===========total*/

                   $today = Carbon::parse($request->transdate)->format('l');
                        if ($today == 'Saturday') {
                             PDF::text(60,$y+20,'Deposits');/*===========sum*/ 
                             PDF::text(60,$y+30,'Date:');
                        }else{
                             PDF::text(60,$y+20,'Deposits        '.$request->mgstart.'');/*===========sum*/ 
                             PDF::text(60,$y+30,'Date:             '.$request->mgdate.'');
                        }
                  PDF::SetXY(220,$y+30);
                  if ($sum > 0) {
                       if ($today == 'Saturday') {
                            PDF::Cell(25,5," ",0,0,'R');/*===========sum*/ 
                       }else{
                            PDF::Cell(25,5,"".number_format($sum, 2, '.', ',')."",0,0,'R');/*===========sum*/ 
                       }
                  }else{
                  PDF::Cell(25,5,"-",0,0,'R');/*===========sum*/
                  }
                  PDF::Line(220, $y+35, 245, $y+35, $style);
                  PDF::Line(220, $y+35.7, 245, $y+35.7, $style);
                  PDF::SetXY(220,$y+35.9);
                  if ($today == 'Saturday') {
                                   PDF::Cell(25,5,"".number_format($totals, 2, '.', ',')."",0,0,'R');/*===========subtotal*/
                              }else{
                                   PDF::Cell(25,5,"".number_format($subtotal, 2, '.', ',')."",0,0,'R');/*===========subtotal*/
                              }
                  PDF::text(32,$y+35,'Undeposited Collections, this Report');
                 // dd($i);
                  if ($i >= 8 && $i <= 15 ||
                        $i >= 52 && $i <= 66 ||
                        $i >= 89 && $i <= 103 ||
                        $i >= 126 && $i <= 140 ||
                        $i >= 163 && $i <= 177 ||
                        $i >= 200 && $i <= 214 ||
                        $i >= 237 && $i <= 251 ||
                        $i >= 274 && $i <= 288 ||
                        $i >= 311 && $i <= 325) {
                        
                       
                        PDF::SetAutoPageBreak(TRUE, 0);
                            PDF::AddPage('L', 'LEGAL');
                             $y = -40;  
                        //     $y = 20; 
                  }
                  PDF::Line(10, $y+45.7, 345, $y+45.7, $style);
                  PDF::SetFont('','', 11);
                  PDF::text(160,$y+45.8,'CERTIFICATION');
                  PDF::Line(10, $y+50.7, 345, $y+50.7, $style);


                  PDF::SetFont('Helvetica','', 10);
                  PDF::text(32,$y+55,'I hereby certify on my official oath that the above is a true statement of all collections and deposits had by me during the period stated above which  Official');
                  PDF::text(10,$y+60,'Receipts Nos.');
                  PDF::SetFont('Helvetica','B', 10);
                  if (count($data) > 0) {
                     PDF::text(45,$y+60,''.$data[0]->numbers.' - '.substr($list->numbers,4,3).'')/*===================or scope*/;
                  }else{
                     PDF::text(45,$y+60,'')/*===================or scope*/;
                  }
                  
                  PDF::SetFont('Helvetica','', 12);
                  PDF::text(75,$y+60,'inclusive were actually issued by me in the amounts shown thereon. I also certify that I have not received money from whatever ');
                  PDF::text(10,$y+65,'source without  having issued the necessary Official Receipt in acknowledgement thereof. Collections received by sub-collectors are recorded above in lump-sum ');
                  PDF::text(10,$y+70,'opposite their respective collector  report numbers. I certify further that the balance shown above agrees with the balance appearing in my Cash Receipts Record.');

                  PDF::SetFont('Helvetica','', 12);
                  PDF::text(32,$y+80,'Prepared by:');
                  PDF::text(200,$y+80,'Reviewed by:');

                  $y = PDF::GetY();
                  PDF::SetXY(32,$y+5);
                  PDF::SetFont('Helvetica','B', 12);
                  PDF::Cell(100,5,"".strtoupper(Auth::user()->first_name." ".substr(Auth::user()->middle_name,0,1).". ".Auth::user()->last_name)."",0,0,'C');/*=============Name*/
                  PDF::SetXY(32,$y+10);
                  PDF::SetFont('Helvetica','', 12);
                  PDF::Cell(100,5,'Name and Signature of the Collecting Officer',0,0,'C');
                  PDF::SetXY(32,$y+15);
                  PDF::SetFont('Helvetica','', 12);
                  PDF::Cell(100,5,''.strtoupper($request->msdisignation).'',0,0,'C');/*=============ITEM*/
                  PDF::SetXY(32,$y+20);
                  PDF::Cell(100,5,'Official Designation',0,0,'C');
                  
                  PDF::SetXY(32,$y+30);
                  PDF::SetFont('','', 11);
                  PDF::Cell(100,5,'Date',0,0,'C');

                  PDF::SetXY(190,$y+10);
                  PDF::SetFont('Helvetica','B', 12);
                  PDF::Cell(100,5,'RUFINA G. AGNER',0,0,'C');
                  PDF::SetXY(190,$y+15);
                  PDF::SetFont('Helvetica','', 12);
                  PDF::Cell(100,5,'Supervising Administrative Officer',0,0,'C');
                  PDF::Line(10, $y+35, 345, $y+35, $style);

              PDF::Output();
                  return;
            }
      }
}