<?php

namespace App;
use TCPDF;

class CashierHeader extends TCPDF
{

    public function Header()
    {

        $style = array('width' => 0.1, 'color' => array(0, 0, 0));

        $this->SetFont('Times','B',11);
        $this->text(140,5,'REPORT OF COLLECTIONS AND DEPOSITS');
        $this->SetFont('helvetica',11);
        $this->text(10,15,'Entitty Name:');
        $this->text(10,25,'Fund:');
        $this->text(180,15,'Report No.');
        $this->SetXY(220,15);
        //$this->Cell(28,5,"".$request->mreportno."",0,0,'C');
        $this->Cell(28,5,"MAEK JOSEPH",0,0,'C');
        $this->text(180,20,'Sheet No.');
        $this->SetXY(220,20);
        $this->Cell(28,5,"",0,0,'C');/*================pageno*/


        $this->text(180,25,'Date:');
        $this->Line(55, 20, 125, 20, $style);
        $this->Line(55, 25, 125, 25, $style);

        $this->Line(220, 20, 245, 20, $style);
        $this->Line(220, 25, 245, 25, $style);
//        $this->text(220,25,Carbon::parse($request->transdate)->format('M. d, Y'));
        $this->text(220,25,'2018-12-13');
        $this->Line(220, 30, 245, 30, $style);

        $this->SetFont('','B');
        $this->text(55,15,'EASTERN VISAYAS MEDICAL CENTER');
        $this->text(10,30,'HOSPITAL INCOME (LBP)');

    }




}
