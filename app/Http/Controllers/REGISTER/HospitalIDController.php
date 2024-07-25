<?php

namespace App\Http\Controllers\REGISTER;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use PDF;
use DNS1D;
use Carbon;

class HospitalIDController extends Controller
{
    public function hospitalid($patient)
    {
    	$style = array('border'=>false, 'padding'=>2, 'vpadding'=>0, 'fgcolor'=>array(0,0,0), 'bgcolor'=>array(255,255,255),
    	    'position'=>'C');

    	$backgroundImage = './public/images/wave.png';
    	$doh_logo = './public/images/doh-logo.png';
    	$evrmc_logo = './public/images/evrmc-logo.png';
    	$doh_banner = './public/images/doh-banner.png';

    	PDF::SetTitle('HOSPITAL CARD');

    	foreach ($patient as $list) {
    		
    		if ($list->brgy){
    		    $address = DB::table('refbrgy')
    		        ->leftJoin('refcitymun', 'refbrgy.citymunCode', '=', 'refcitymun.citymunCode')
    		        ->leftJoin('refprovince', 'refcitymun.provCode', '=', 'refprovince.provCode')
    		        ->leftJoin('refregion', 'refprovince.regCode', '=', 'refregion.regCode')
    		        ->select('refbrgy.brgyDesc', 'refcitymun.citymunDesc', 'provDesc', 'refregion.regDesc')
    		        ->where('refbrgy.id', '=', $list->brgy)
    		        ->get()->first();
    		}elseif ($list->city_municipality){
    		    $address = DB::table('refcitymun')
    		        ->leftJoin('refprovince', 'refcitymun.provCode', '=', 'refprovince.provCode')
    		        ->leftJoin('refregion', 'refprovince.regCode', '=', 'refregion.regCode')
    		        ->select('refcitymun.citymunDesc', 'provDesc', 'refregion.regDesc')
    		        ->where('refcitymun.citymunCode', '=', $list->city_municipality)
    		        ->get()->first();
    		}
    		PDF::addPage('l',array(85.60,53.98));
    		PDF::SetAutoPageBreak(TRUE, 0);
    		PDF::Rect(0, 0, 90, 60,'F',array(),array(255,255,255));
    		PDF::Image($backgroundImage,0,0,85.60,43);
    		PDF::SetFontSize(8);
    		PDF::SetXY(30,2);
    		PDF::Cell(25,1,'Republic of the Philippines',0,0,'C',false,'',2,false,'T');
    		PDF::SetFontSize(10);
    		PDF::SetXY(23,5);
    		PDF::Cell(38,1,'Eastern Visayas Regional Medical Center',0,0,'C',false,'',2,false,'T');
    		PDF::SetFontSize(7);
    		PDF::SetXY(32,9);
    		PDF::Cell(20,1,'Tacloban City, Leyte',0,0,'C',false,'',2,false,'T');
    		PDF::Image($doh_logo,2,2,20,15);
    		PDF::Image($evrmc_logo,66,2,14.5,14.5);
    		PDF::Image($doh_banner,50,18,30,30);
    		PDF::SetFont('','B');
    		PDF::SetFontSize(9);
    		PDF::Text(4,21,$list->last_name);
    		PDF::Text(4,24,$list->first_name.' '.$list->suffix);
    		PDF::Text(4,27,$list->middle_name);
    		PDF::SetFontSize(8);
    		PDF::Text(4,33,Carbon::parse($list->birthday)->format('F d, Y'));
    		PDF::Text(4,38,$address->regDesc);
    		PDF::Text(4,41,"$address->provDesc");
    		PDF::Text(4,44,"$address->citymunDesc");
    		if ($list->brgy) {
    		PDF::Text(4,47,$address->brgyDesc);
    		}
    		PDF::SetFontSize(9);
    		PDF::Text(69,48,$list->hospital_no);

    		PDF::addPage('l',array(85.60,53.98));
    		PDF::rotate(180,43,26);
    		PDF::Rect(0, 0, 90, 60,'F',array(),array(255,255,255));
    		//PDF::Image($backgroundImage,0,0,85.60,43);
    		PDF::write2DBarcode($list->barcode, 'QRCODE', '', '5', '22', '22', $style, '', false);
    		PDF::Text(22,0,"PATIENT HOSPITAL CARD");
    		PDF::SetFont('','N');
    		PDF::SetFontSize(9);
    		PDF::Text(10,27,$list->barcode, false, false, true, 0, 0, 'C');
    		PDF::SetFontSize(7);
    		PDF::Text(8,34,"Always bring this card every time you come to EVRMC");
    		PDF::Text(13,37,"Please use this card to facilitate our services");
    		PDF::Text(11,40,"If found, please return to EVRMC Tacloban City");
    		PDF::Text(6,43,"EVRMC HOTLINES: Globe 09955215282, Sun 09338781851");
    		PDF::Text(29.5,46,"Smart 09983489054, T.M 09367360504");
    	}
    	
    	PDF::Output();
    	return;

    }
}
