<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Patient;
use App\Mss;
use App\Mssclassification;
use App\Mssdiagnosis;
use App\Mssexpenses;
use App\Msshouseexpenses;
use App\Mssfamily;
use App\User;
use PDF;
use DNS1D;
use DB;
use Carbon\Carbon;

/**
* 
*/
class ClassificationController extends Controller
{
	
	function mssform($id)
	{
        $view = DB::table('mssclassification')
            ->select('*', 'mssclassification.users_id as users_ids')
            ->leftJoin('patients', 'mssclassification.patients_id', '=', 'patients.id')
            ->leftJoin('mssdiagnosis', 'mssclassification.id', '=', 'mssdiagnosis.classification_id')
            ->leftJoin('mssexpenses', 'mssclassification.id', '=', 'mssexpenses.classification_id')
            ->leftJoin('msshouseexpenses', 'mssclassification.id', '=', 'msshouseexpenses.classification_id')
            ->leftJoin('mss', 'mssclassification.mss_id', '=', 'mss.id')
            ->where('mssclassification.id', '=', $id)
            ->get()
            ->first();

        $family = Mssfamily::where('patient_id', $view->patients_id)->get();
        // dd($view);
        $users = User::find($view->users_ids);
		PDF::SetTitle('MSS CLASSIFICATION FORM');
		PDF::AddPage('P',array(215.9,330.2));
		PDF::Image('./public/images/doh-logo.png',20,10,35);
		PDF::Image('./public/images/evrmc-logo.png',160,10.5,25);
		PDF::Cell(80);

		PDF::SetXY(98,5);
                PDF::SetFont('Times','',10);
                PDF::Cell(15,1,'Republic of the Philippines',0,0,'C');

                PDF::SetXY(98,5);
                PDF::Cell(17,15,'Department of Health',0,0,'C');

                PDF::SetXY(98,5);
                PDF::Cell(15,25,'Department of Health, Regional Office No.8',0,0,'C');

                PDF::SetXY(98,5);
                PDF::SetFont('Times','B',11);
                PDF::Cell(17,35,'EASTERN VISAYAS REGIONAL MEDICAL CENTER ',0,0,'C');

                PDF::SetXY(98,5);
                PDF::SetFont('Times','',11);
                PDF::Cell(17,45,'Tacloban City',0,0,'C');

                PDF::SetXY(98,5);
                PDF::Cell(17,55,'(053)832-0208;evrmcmccoffice@gmail.com',0,0,'C');

                PDF::SetXY(98,5);
                PDF::SetFont('Times','BI',11);
                PDF::Cell(17,65,'"PHIC Accredited Health Care Provider"',0,0,'C');

                PDF::SetXY(98,5);
                PDF::SetFont('Times','B',11);
                PDF::Cell(17,75,'MSWD Assessment Tool',0,0,'C');

                PDF::SetXY(15,6);
                PDF::SetFont('Times',11);
                PDF::Cell(25,88,'EVRMC-MSS-FORM 3',0,0,'C');


                PDF::SetFont('helvetica','',8);


                PDF::SetXY(9,52);
                PDF::MultiCell(30,10,"DATE INTERVIEW\n".Carbon::parse($view->created_at)->toFormattedDateString()."",1,'T',false);

                PDF::SetXY(39,52);
                PDF::MultiCell(77,10,"DATE OF ADMISSION/CONSULTATION\n".$view->date_admission."",1,'T',false);

                
                PDF::SetXY(116,52);
                PDF::Cell(30,5,'     WARD',1,1);
                PDF::Image('./public/images/checkbox.png',117,53,3);

                PDF::SetXY(116,57);
                PDF::Image('./public/images/checkbox-check.png',117,58,3);
                PDF::Cell(16,5,'     OPD',1,1);

                PDF::SetXY(132,57);
                PDF::Image('./public/images/checkbox.png',133.5,58,3);
                PDF::Cell(14,5,'     ER',1,1);

                PDF::SetXY(146,52);
                PDF::MultiCell(30,10,"HOSP NO. \n".$view->hospital_no."",1,'T',false);

                PDF::SetXY(176,52);
                PDF::MultiCell(30,10,"MSWD NO. \n".$view->mswd."",1,'T',false);

                PDF::SetXY(9,62);
                PDF::Cell(60,5,'SOURCE OF REFERRAL: '.$view->referral.'',1,1);
                PDF::SetXY(69,62);
                PDF::Cell(63,5,'ADDRESS: '.$view->referral_addrress.'',1,1);
                PDF::SetXY(132,62);
                PDF::Cell(74,5,'TEL. NO: '.$view->referral_telno.'',1,1);

		
                PDF::SetXY(9,67);
                PDF::Cell(47,5,'I. DEMOGRAPHIC DATA',1,1);
                PDF::SetXY(56,67);
                PDF::Cell(60,5,'RELIGION: '.$view->religion.'',1,1);
                PDF::SetXY(116,67);
                PDF::Cell(90,5,'COMPANION UPON ADMISSION: '.$view->companion.'',1,1);

                PDF::SetXY(9,72);
                PDF::Cell(60,5,"PATIENT'S NAME",1,0,'C');
                PDF::Cell(24,5,"AGE",1,0,'C');
                PDF::Cell(23,5,"SEX",1,0,'C');
                PDF::Cell(16,5,'GENDER',1,0,'C');
                PDF::Cell(74,5,"CIVIL STATUS",1,0,'C');

                PDF::SetXY(9,77);
                PDF::MultiCell(60,10,''.$view->last_name.', '.$view->first_name.' '.$view->middle_name.'',1,'T',false);
                PDF::SetXY(69,77);
                PDF::MultiCell(24,10,''.$view->age.'',1,'C',false);
                PDF::SetXY(93,77);
                if ($view->sex == 'F') {
                    PDF::Image('./public/images/checkbox-check.png',95,78,3);
                }
                else{
                    PDF::Image('./public/images/checkbox.png',95,78,3);
                }
                
                PDF::Cell(23,5,"          F",1,0);
                PDF::SetXY(93,82);
                if ($view->sex == 'M') {
                    PDF::Image('./public/images/checkbox-check.png',95,83,3);
                }
                else{
                    PDF::Image('./public/images/checkbox.png',95,83,3);
                }
                PDF::Cell(23,5,"          M",1,0);

                PDF::SetXY(93+23,77);
                if ($view->gender == "F"  ) {
                    PDF::Image('./public/images/checkbox-check.png',118,78,3);
                }
                else{
                    PDF::Image('./public/images/checkbox.png',118,78,3); 
                }
                PDF::Cell(16,5,"        F",1,0);

                PDF::SetXY(93+23,82);
                if ($view->gender == "M"  ) {
                    PDF::Image('./public/images/checkbox-check.png',118,83,3);
                }
                else{
                    PDF::Image('./public/images/checkbox.png',118,83,3); 
                }
                PDF::Cell(16,5,"        M",1,0);

                PDF::SetXY(93+23+16,77);
                PDF::SetFillColor(153, 153, 153);
                $cl = FALSE;$m = FALSE;$infact = FALSE;$legal = FALSE;$s = FALSE;$w = FALSE;$d = FALSE;
                if ($view->civil_statuss == 'Common-law') {
                    $cl = true;
                }
                elseif ($view->civil_statuss == 'Married') {
                    $m = true;
                } 
                elseif ($view->civil_statuss == 'Sep-fact') {
                    $infact = true;
                } 
                elseif ($view->civil_statuss == 'Sep-legal') {
                    $legal = true;
                } 
                elseif ($view->civil_statuss == 'Single') {
                    $s = true;
                } 
                elseif ($view->civil_statuss == 'Widow') {
                    $w = true;
                } 
                elseif ($view->civil_statuss == 'Divorce') {
                    $d = true;
                } 
                PDF::Cell(9,10,"CL",1,0,'C',$cl);
                PDF::Cell(9,10,"M",1,0,'C', $m);
                PDF::Cell(28,5,"Sep",1,2,'C');
                PDF::Cell(14,5,"In Fact",1,0,'C', $infact);
                PDF::Cell(14,5,"Legal",1,0,'C', $legal);
                PDF::SetXY(100+50+28,77);
                PDF::Cell(9,10,"S",1,0,'C', $s);
                PDF::Cell(9,10,"W",1,0,'C', $w);
                PDF::Cell(10,10,"D",1,1,'C', $d);

                PDF::SetXY(9,87);
                PDF::MultiCell(84,15,"PERMANENT ADDRESS:\n".$view->address."",1,'T',false);
                PDF::SetXY(93,87);
                PDF::MultiCell(57,15,"TEMPORARY ADDRESS:\n".$view->temp_address."",1,'T',false);
                PDF::SetXY(93+57,87);
                PDF::MultiCell(56,15,"DATE/PLACE OF BIRTH:\n".$view->birthday."\n".$view->pob."",1,'T',false);

                PDF::SetX(9,97);
                PDF::GetY();
                $o = '';$r = '';$s = ''; $i = ''; $h = '';
                if ($view->living_arrangement == "O") {
                     $o = '-check';
                }
                elseif ($view->living_arrangement == "R") {
                     $r = '-check';
                }
                elseif ($view->living_arrangement == "S") {
                     $s = '-check';# code...
                }
                elseif ($view->living_arrangement == "I") {
                     $i = '-check';# code...
                }
                elseif ($view->living_arrangement == "H") {
                     $h = '-check';# code...
                }
                PDF::Image('./public/images/checkbox'.$o.'.png',67.7,103,3);
                PDF::Image('./public/images/checkbox'.$r.'.png',94,103,3);
                PDF::Image('./public/images/checkbox'.$s.'.png',94+28.7,103,3);
                PDF::Image('./public/images/checkbox'.$i.'.png',94+55,103,3);
                PDF::Image('./public/images/checkbox'.$h.'.png',94+84.5,103,3);
                $word  = "KIND OF LIVING ARRANGEMENT :                    Owned";
                $word .= "                      RENTED";
                $word .= "                      Shared";
                $word .= "                      Institution";
                $word .= "                      Homeless";
                PDF::Cell(197,5,$word,1,1,'L');


                
                PDF::SetXY(9,97+10);
                PDF::Cell(71,5,"Educ'l Attainment: ".$view->education."",1,2,'L');
                PDF::Cell(71,5,'OCCUPATION : '.$view->occupation.'',1,0,'L');
                PDF::SetXY(80,97+10);
                PDF::MultiCell(50,10,"Employer: \n".$view->employer."",1,'T',false);
                PDF::SetXY(80+50,97+10);
                PDF::MultiCell(32,10,"Income:\n".$view->income."",1,'T',false);
                PDF::SetXY(80+50+32,97+10);
                PDF::MultiCell(44,10,"Per Capita Income:\n".$view->capita_income."",1,'T',false);

                PDF::SetXY(9,97+20);
                $m = ''; $d = '';
                if ($view->philhealth == "M") {
                    $m = '-check';
                }
                elseif ($view->philhealth == "D") {
                    $d = '-check';
                }
                PDF::Image('./public/images/checkbox'.$m.'.png',34.7,98+20.3,3);
                PDF::Image('./public/images/checkbox'.$d.'.png',34.7+25.7,98+20.3,3);
                PDF::Cell(71,5,'PHILHEALTH:             Member                   Dependent',1,0,'L');
                PDF::Cell(60,5,'CATEGORY',1,0,'C');
                PDF::Cell(13,5,"4P's",1,0,'C');
                PDF::Cell(53,5,"CLASSIFICATION",1,1,'C');

                PDF::SetFontSize(7);
                PDF::SetXY(9,97+25);
                $owwa = '';$ipp = ''; $npp = ''; $govt = ''; $employed = ''; $private = ''; $fourps = ''; $nhts = ''; $pos = ''; $others = '';
                if ($view->membership == 'OWWA') {
                    $owwa = '-check';
                }
                elseif ($view->membership == 'IPP') {
                    $ipp = '-check';
                }
                elseif ($view->membership == 'NPP') {
                    $npp = '-check';
                }
                elseif ($view->membership == 'GOVT') {
                    $govt = '-check';
                }
                elseif ($view->membership == 'EMPLOYED') {
                    $employed = '-check';
                }
                elseif ($view->membership == 'PRIVATE') {
                    $private = '-check';
                }
                elseif ($view->membership == '4Ps') {
                    $fourps = '-check';
                }
                elseif ($view->membership == 'NHTS') {
                    $nhts = '-check';
                }
                elseif ($view->membership == 'POS') {
                    $pos = '-check';
                }
                elseif (stristr($view->membership, 'OTHERS')) {
                    $others = '-check';
                }
                PDF::Image('./public/images/checkbox'.$owwa.'.png',10,98+27,3);
                PDF::Image('./public/images/checkbox'.$ipp.'.png',10,98+33.7,3);
                PDF::MultiCell(14,15,"\n".'     OWWA'."\n\n"."     IPP",1,'T',false);
                PDF::SetXY(9+14,97+25);
                PDF::Image('./public/images/checkbox'.$npp.'.png',24,98+27,3);
                PDF::Image('./public/images/checkbox'.$govt.'.png',24,98+33.7,3);
                PDF::MultiCell(12,15,"\n".'      NPP'."\n\n"."      Gov't",1,'T',false);
                PDF::SetXY(9+14+12,97+25);
                PDF::Image('./public/images/checkbox'.$employed.'.png',36,98+27,3);
                PDF::Image('./public/images/checkbox'.$private.'.png',36,98+33.7,3);
                PDF::MultiCell(17,15,"\n".'     Employed'."\n\n"."     Private",1,'T',false);
                PDF::SetXY(9+14+12+17,97+25);
                PDF::Image('./public/images/checkbox'.$fourps.'.png',53,98+27,3);
                PDF::Image('./public/images/checkbox'.$nhts.'.png',53,98+33.7,3);
                PDF::MultiCell(14,15,"\n"."      4P's"."\n\n"."      NHTS",1,'T',false);
                PDF::SetXY(9+14+12+17+14,97+25);
                PDF::Image('./public/images/checkbox'.$pos.'.png',67,98+27,3);
                PDF::Image('./public/images/checkbox'.$others.'.png',67,98+33.7,3);
                PDF::MultiCell(14,15,"\n"."     POS"."\n\n"."     Others",1,'T',false);

                PDF::SetXY(9+71,97+25);
                $o = ''; $n = ''; $c = '';
                if ($view->category = 'O') {
                    $o = '-check';
                }
                elseif ($view->category = 'N') {
                    $n = '-check';
                }
                elseif ($view->category = 'C') {
                    $c = '-check';
                }
                PDF::Image('./public/images/checkbox'.$o.'.png',86,98+27,3);
                PDF::MultiCell(15,15,"    "."\n\n\n"."  Old Pt. ",1,'T',false);
                PDF::SetXY(9+71+15,97+25);
                PDF::Image('./public/images/checkbox'.$n.'.png',86+15,98+27,3);
                PDF::MultiCell(15,15,"    "."\n\n\n"." New Pt. ",1,'T',false);
                PDF::SetXY(9+71+30,97+25);
                PDF::Image('./public/images/checkbox'.$c.'.png',86+30,98+27,3);
                PDF::MultiCell(15,15,"    "."\n\n"."      Case\n   Forward. ",1,'T',false);
                PDF::SetXY(9+71+45,97+25);
                PDF::Image('./public/images/checkbox.png',86+45,98+27,3);
                PDF::MultiCell(15,15,"    "."\n\n"."   Closed\n    Case. ",1,'T',false);

                PDF::SetXY(66+74,97+25);
                $y = ''; $n = '';
                if ($view->fourpis == 'Y') {
                    $y = '-check';
                }
                elseif ($view->fourpis == 'N') {
                    $n = '-check';
                }
                PDF::Image('./public/images/checkbox'.$y.'.png',67+74,98+27,3);
                PDF::Image('./public/images/checkbox'.$n.'.png',67+74,98+33.7,3);
                PDF::MultiCell(13,15,"\n"."      Yes"."\n\n"."      No",1,'T',false);

                PDF::SetFontSize(9);
                
                $a = '';$b = '';$c1 = '';$c2 = '';$c3 = '';$d = '';
                if ($view->mss_id == '1') {
                    $a = '-check';# code...
                }
                elseif ($view->mss_id == '3') {
                    $c1 = '-check';# code...
                }
                elseif ($view->mss_id == '4') {
                    $c2 = '-check';# code...
                }
                elseif ($view->mss_id >= '5' && $view->mss_id <= '8') {
                    $c3 = '-check';# code...
                }
                elseif ($view->mss_id == '9') {
                    $d = '-check';# code...
                }
                else{
                    PDF::SetXY(192,97+20);
                    PDF::Cell(20,5,"".$view->label."",0,1,'C',true);

                }
                PDF::SetXY(80+73,97+25);
                PDF::Image('./public/images/checkbox'.$a.'.png',86+70,98+27,3);
                PDF::MultiCell(9,15,"    "."\n\n"."   A",1,'T',false);

                PDF::SetXY(80+82,97+25);
                PDF::Image('./public/images/checkbox.png',86+79,98+27,3);
                PDF::MultiCell(9,15,"    "."\n\n"."   B",1,'T',false);

                PDF::SetXY(80+91,97+25);
                PDF::Image('./public/images/checkbox'.$c1.'.png',86+88,98+27,3);
                PDF::MultiCell(9,15,"    "."\n\n"."  C1",1,'T',false);

                PDF::SetXY(80+100,97+25);
                PDF::Image('./public/images/checkbox'.$c2.'.png',86+97,98+27,3);
                PDF::MultiCell(9,15,"    "."\n\n"."  C2",1,'T',false);

                PDF::SetXY(80+109,97+25);
                PDF::Image('./public/images/checkbox'.$c3.'.png',86+106,98+27,3);
                PDF::MultiCell(9,15,"    "."\n\n"."  C3",1,'T',false);

                PDF::SetXY(80+118,97+25);
                PDF::Image('./public/images/checkbox'.$d.'.png',86+114.5,98+27,3);
                PDF::MultiCell(8,15,"    "."\n\n"."  D",1,'T',false);

                PDF::SetFontSize(8);
                
                $s = '';$br = '';$pw = '';$bh = '';$in = '';$ve = '';$va = '';$el = '';$ot = '';
                if ($view->sectorial == 'SC') {
                    $s = '-check';
                }
                elseif ($view->sectorial == 'BRGY') {
                    $br = '-check';
                }
                elseif ($view->sectorial == 'PWD') {
                    $pw = '-check';
                }
                elseif ($view->sectorial == 'BHW') {
                    $bh = '-check';
                }
                elseif ($view->sectorial == 'INDIGENOUS PEOPLE') {
                    $in = '-check';
                }
                elseif ($view->sectorial == 'VETERANS') {
                    $ve = '-check';
                }
                elseif ($view->sectorial == 'VAWC/IN INSTITUTION') {
                    $va = '-check';
                }
                elseif ($view->sectorial == 'ELDERLY') {
                    $el = '-check';
                }
                elseif (stristr($view->sectorial, 'OTHERS')) {
                    $ot = '-check';
                    PDF::SetXY(188,97+40);
                    PDF::Cell(20,5,"".$view->sectorial."",0,1,'C');
                }
                PDF::SetXY(9,97+40);
                PDF::Image('./public/images/checkbox'.$s.'.png',47,98+40,3);
                PDF::Image('./public/images/checkbox'.$br.'.png',47+9,98+40,3);
                PDF::Image('./public/images/checkbox'.$pw.'.png',47+31,98+40,3);
                PDF::Image('./public/images/checkbox'.$bh.'.png',47+43,98+40,3);
                PDF::Image('./public/images/checkbox'.$in.'.png',47+55,98+40,3);
                PDF::Image('./public/images/checkbox'.$ve.'.png',47+74.7,98+40,3);
                PDF::Image('./public/images/checkbox'.$va.'.png',47+90.7,98+40,3);
                PDF::Image('./public/images/checkbox'.$el.'.png',47+121.7,98+40,3);
                PDF::Image('./public/images/checkbox'.$ot.'.png',47+136.7,98+40,3);
                $word  = "SECTORIAL MEMBERSHIP:     SC";
                $word .= "       Brgy. Official";
                $word .= "       PWD";
                $word .= "       BHW";
                $word .= "       Indigenous";
                $word .= "       Veterans";
                $word .= "       VAWC/In Institution ";
                $word .= "       Elderly ";
                $word .= "       Others:";
                PDF::Cell(197,5,$word,1,1,'L');
                PDF::SetXY(9,97+45);
                PDF::Cell(197,5,'FAMILY COMPOSITION',1,1,'C');
                PDF::SetX(9);
                $y = PDF::GetY();
                PDF::MultiCell(57,10,""."\nName",1,'C',false);
                PDF::SetXY(66, $y);
                PDF::MultiCell(15,10,""."\nAGE",1,'C',false);
                PDF::SetXY(66+15, $y);
                PDF::MultiCell(20,10,""."Civil \nStatus",1,'C',false);
                PDF::SetXY(66+15+20, $y);
                PDF::MultiCell(35,10,""."\nRelation to Patient",1,'C',false);
                PDF::SetXY(66+15+55, $y);
                PDF::MultiCell(23,10,""."Educ'l\nAttainment",1,'C',false);
                PDF::SetXY(66+15+78, $y);
                PDF::MultiCell(27,10,""."\nOccupation",1,'C',false);
                PDF::SetXY(66+15+105, $y);
                PDF::MultiCell(20,10,""."Monthly\nIncome",1,'C',false);

                $count = 1;
                foreach ($family as $key) {
                $y = PDF::GetY();
                PDF::SetX(9);
                PDF::Cell(57,5,''.$count.'. '.$key->name.'',1,1,'L');
                PDF::SetXY(66, $y);
                PDF::Cell(15,5,$key->age,1,1,'L');
                PDF::SetXY(66+15, $y);
                PDF::Cell(20,5,$key->status,1,1,'L');
                PDF::SetXY(66+15+20, $y);
                PDF::Cell(35,5,$key->relationship,1,1,'L');
                PDF::SetXY(66+15+55, $y);
                PDF::Cell(23,5,$key->feducation,1,1,'L');
                PDF::SetXY(66+15+78, $y);
                PDF::Cell(27,5,$key->foccupation,1,1,'L');
                PDF::SetXY(66+15+105, $y);
                PDF::Cell(20,5,$key->fincome,1,1,'L');
                $count++;
                }
                for ($i=$count; $i <= 8 ; $i++) { 
                $y = PDF::GetY();
                PDF::SetX(9);
                PDF::Cell(57,5,''.$i.'. ',1,1,'L');
                PDF::SetXY(66, $y);
                PDF::Cell(15,5,'',1,1,'L');
                PDF::SetXY(66+15, $y);
                PDF::Cell(20,5,'',1,1,'L');
                PDF::SetXY(66+15+20, $y);
                PDF::Cell(35,5,'',1,1,'L');
                PDF::SetXY(66+15+55, $y);
                PDF::Cell(23,5,'',1,1,'L');
                PDF::SetXY(66+15+78, $y);
                PDF::Cell(27,5,'',1,1,'L');
                PDF::SetXY(66+15+105, $y);
                PDF::Cell(20,5,'',1,1,'L');
                    
                }


                $y = PDF::GetY();
                PDF::SetX(9);
                PDF::Cell(110,5,'Other Sources of Income:'.$view->source_income.'',1,1,'L');
                PDF::SetXY(9+110, $y);
                PDF::Cell(87,5,'HOUSEHOLD SIZE:'.$view->household.'',1,1,'L');
                $y = PDF::GetY();
                PDF::SetX(9);
                PDF::Cell(110,5,'MONTHLY EXPENSES:'.$view->monthly_expenses.'',1,1,'L');
                PDF::SetXY(9+110, $y);
                PDF::Cell(87,5,'TOTAL MONTHLY EXPENDITURES:'.$view->monthly_expenditures.'',1,1,'L');

                $y = PDF::GetY();
                PDF::SetX(9);
                $house = explode('-',trim($view->houselot));
              
                $o = '';$r = '';$f = '';
                if ($house[0] == 'owned') {
                    $o = '-check';
                }
                elseif  ($house[0] == 'rented') {
                    $r = '-check';
                }
                elseif  ($house[0] == 'free') {
                    $f = '-check';
                }
                PDF::Image('./public/images/checkbox'.$o.'.png',31,103+104.5,3);
                PDF::Image('./public/images/checkbox'.$r.'.png',11,103+107.5,3);
                PDF::Image('./public/images/checkbox'.$f.'.png',11,103+111.5,3);
                if (isset($house[1])) {
                PDF::MultiCell(40,10,""."House and Lot:        Owned\n       Rented : Php ".$house[1]." \n       Free ",1,'L',false);    # code...
                }else{
                PDF::MultiCell(40,10,""."House and Lot:        Owned\n       Rented : Php______\n       Free ",1,'L',false);
                }
                PDF::SetXY(9+40, $y);
                $light = explode('-',trim($view->light));
                $c = '';$e = '';$k= '';
                if ($light[0] == 'candle') {
                    $c = '-check';
                }
                elseif  ($light[0] == 'electric') {
                    $e = '-check';
                }
                elseif  ($light[0] == 'kerosene') {
                    $k = '-check';
                }
                PDF::Image('./public/images/checkbox'.$c.'.png',51,103+107.5,3);
                PDF::Image('./public/images/checkbox'.$e.'.png',66,103+107.5,3);
                PDF::Image('./public/images/checkbox'.$k.'.png',51,103+111.5,3);
                if (isset($light[1])) {
                PDF::MultiCell(40,10,""."Light Source: Php ".$light[1]."\n       Candle       Electric\n       Kerosene ",1,'L',false);
                }else{
                PDF::MultiCell(40,10,""."Light Source: Php_______\n       Candle       Electric\n       Kerosene ",1,'L',false);
                }
                PDF::SetXY(9+80, $y);
                $water = explode('-',trim($view->water));
                $wd = '';$pu = '';$ow= '';$dw= '';$pub= '';
                if ($water[0] == 'water_distric') {
                    $wd = '-check';
                }
                elseif  ($water[0] == 'public') {
                    $pu = '-check';
                }
                elseif  ($water[0] == 'owned') {
                    $ow = '-check';
                }
                elseif  ($water[0] == 'deep_well') {
                    $dw = '-check';
                }
                elseif  ($water[0] == 'pump') {
                    $pub = '-check';
                }
                PDF::Image('./public/images/checkbox'.$wd.'.png',131,103+104.5,3);
                PDF::Image('./public/images/checkbox'.$pu.'.png',90,103+111.5,3);
                PDF::Image('./public/images/checkbox'.$ow.'.png',104,103+111.5,3);
                PDF::Image('./public/images/checkbox'.$dw.'.png',119,103+111.5,3);
                PDF::Image('./public/images/checkbox'.$pub.'.png',139,103+111.5,3);
                if (isset($water[1])) {
                PDF::MultiCell(68,10,"Water Source: Php ".$water[1]."                 Water District\n\n     Public        Owned        Deep Well         Pump ",1,'L',false);
                }
                else{
                PDF::MultiCell(68,10,""."Water Source: Php_______              Water District\n\n     Public        Owned        Deep Well         Pump ",1,'L',false);    
                }
                PDF::SetXY(9+80+68, $y);
                $fuel = explode('-',trim($view->fuel));
                $g = '';$c = '';$f = '';
                if ($fuel[0] == 'gas') {
                    $g = "-check";
                }
                elseif ($fuel[0] == 'charcoal') {
                    $c = "-check";
                }
                elseif ($fuel[0] == 'firewood') {
                    $f = "-check"; 
                }
                PDF::Image('./public/images/checkbox'.$g.'.png',195,103+104.5,3);
                PDF::Image('./public/images/checkbox'.$c.'.png',159,103+111.5,3);
                PDF::Image('./public/images/checkbox'.$f.'.png',185,103+111.5,3);
                if (isset($fuel[1])) {
                PDF::MultiCell(49,10,""."House and Lot: Php   ".$fuel[1]."         Gas\n\n       Charcoal                   Firewood ",1,'L',false);
                }
                else{
                PDF::MultiCell(49,10,""."House and Lot: Php_______      Gas\n\n       Charcoal                   Firewood ",1,'L',false);   
                }
                

                $y = PDF::GetY();
                PDF::SetX(9);
                if ($view->food != '') {
                    PDF::Cell(40,5,'Food: Php '.$view->food.'',1,1,'L');
                }
                else{
                    PDF::Cell(40,5,'Food: Php____________',1,1,'L');  
                }
                PDF::SetXY(9+40, $y);
                if ($view->educationphp != '') {
                    PDF::Cell(64,5,'Education: Php '.$view->educationphp.'',1,1,'L');
                }
                else{
                    PDF::Cell(64,5,'Education: Php____________',1,1,'L');
                }
                PDF::SetXY(9+104, $y);
                
                if ($view->clothing != '') {
                    PDF::Cell(52,5,'Clothing: Php '.$view->clothing.'',1,1,'L');
                }
                else{
                    PDF::Cell(52,5,'Clothing: Php____________',1,1,'L');
                }
                PDF::SetXY(9+104+52, $y);
                if ($view->transportation != '') {
                    PDF::Cell(41,5,'Transpo: Php '.$view->transportation.'',1,1,'L');
                }
                else{
                    PDF::Cell(41,5,'Transpo: Php____________',1,1,'L');
                }
                
                

                $y = PDF::GetY();
                PDF::SetX(9);
                if ($view->house_help != '') {
                    PDF::Cell(40,5,'House help: Php '.$view->house_help.'',1,1,'L');        # code...
                }
                else{
                    PDF::Cell(40,5,'House help: Php_________',1,1,'L');
                }
                PDF::SetXY(9+40, $y);
                if ($view->expinditures != '') {
                    PDF::Cell(64,5,'Medical Expenditures: Php '.$view->expinditures.'',1,1,'L');
                }
                else{
                    PDF::Cell(64,5,'Medical Expenditures: Php____________',1,1,'L');
                }
                PDF::SetXY(9+104, $y);
                if ($view->insurance != '') {
                    PDF::Cell(52,5,'Insurance Premium: Php '.$view->insurance.'',1,1,'L');
                }
                else{
                    PDF::Cell(52,5,'Insurance Premium: Php____________',1,1,'L');
                }
                PDF::SetXY(9+104+52, $y);
                if ($view->insurance != '') {
                    PDF::Cell(41,5,'Others: Php '.$view->other_expenses.'',1,1,'L');
                }
                else{
                    PDF::Cell(41,5,'Others: Php____________',1,1,'L');
                }

                $y = PDF::GetY();
                PDF::SetX(9);
                PDF::Cell(72,5,'Internet Connection: Php '.$view->internet.'',1,1,'L');
                PDF::SetXY(9+72, $y);
                PDF::Cell(125,5,'Cable: Php '.$view->cable.'',1,1,'L');

                $y = PDF::GetY();
                PDF::SetX(9);
                PDF::MultiCell(40,10,""."II. MEDICAL DATA:  ".$view->medical."",1,'L',false);
                PDF::SetXY(9+40, $y);
                PDF::MultiCell(75,10,""."ADMITTING DIAGNOSES:  ".$view->admitting."",1,'L',false);
                PDF::SetXY(9+115, $y);
                PDF::MultiCell(82,10,""."FINAL DIAGNOSIS: ".$view->final." ",1,'L',false);

                PDF::SetX(9);
                PDF::Cell(197,5,'DURATION OF PROBLEMS/SYMPTOMS:'.$view->duration.'',1,1,'L');
                PDF::SetX(9);
                PDF::Cell(197,5,'PREVIOUS TREATMENT DURATION:'.$view->previus.'',1,1,'L');
                PDF::SetX(9);
                PDF::Cell(197,5,'PRESENT TREATMENT PLAN:'.$view->present.'',1,1,'L');
                PDF::SetX(9);
                PDF::Cell(197,5,'HEALTH ACCESSIBILITY PROBLEM:'.$view->health.'',1,1,'L');
                PDF::SetX(9);
                $y = PDF::GetY();
                PDF::Cell(100,5,'HEALTH ACCESSIBILITY PROBLEM:'.$view->findings.'',1,1,'L');
                PDF::SetXY(109, $y);
                PDF::Cell(97,5,'RECOMMENDED INTERVENTIONS:'.$view->interventions.'',1,1,'L');
                PDF::SetX(9);
                $y = PDF::GetY();
                PDF::Cell(100,5,'Pre-admission Planning'.$view->admision.'',1,1,'L');
                PDF::SetXY(109, $y);
                PDF::Cell(97,5,'Discharge Planning:'.$view->planning.'',1,1,'L');
                PDF::SetX(9);
                PDF::Cell(197,5,'Counseling:'.$view->counseling.'',1,1,'L');

                PDF::SetFont('','B',9);
                PDF::SetXY(9, $y+25);
                PDF::MultiCell(100,10,""."_______________________________________________\nRelationship/Contact no._________________________",0,'L',false);
                PDF::SetXY(9+100, $y+25);
                PDF::MultiCell(100,10,""."_______________________________________________\nSocial Welfare Officer/Assistant",0,'C',false);
                PDF::SetXY(9+100, $y+23);
                PDF::SetFont('',9);
                PDF::MultiCell(100,10,"".$users->first_name.' '.$users->middle_name.' '.$users->last_name."",0,'C',false);



                
		        PDF::IncludeJS("print();");
                PDF::Output();

		return;
	}
}
