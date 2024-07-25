<?php

namespace App;
use TCPDF;

class PdfFile extends TCPDF
{

    public function Header()
    {
        return false;
    }


    public function Footer()
    {
        $style = array('width' => .1, 'cap' => 'square', 'color' => array(0, 0, 0));
        $this->SetFont('times','N',11);
        $this->SetXY(10,265);
        $this->Cell(190,1,'V. VILLERO, MD, FPCR / DR. MARY JOAN KRISTINE C. UY, MD, MHA / P. BUATIS, MD / JK. FLORES, MD / P.R, MORALES, MD / L. ESTANISLAO, MD',0,0,'C',false,'',2,false,'T');
        $this->Line(12, 270, 198, 270, $style);
        $this->Text(95,270,'RADIOLOGIST');
        $this->SetFont('times','i',10);
        $this->Text(5,275,'DISCLAIMER: This findings are based on radiologic studies. It must be correlated with clinical, laboratory and other ancillary');
        $this->Text(5,280,'procedures for comprehensive assessment of the patients condition. Thus, radiology reports are best explained by the attending');
        $this->Text(5,285,'physician to the patient.');
    }


}
