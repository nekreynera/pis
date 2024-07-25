<?php

namespace App;
use TCPDF;
use App\Patient;
use App\Refregion;
use Carbon;

class Postcharge extends TCPDF
{
    public $pid;
    public $name;
    public $region;
    public $province;
    public $city_mun;
    public $brgy;
    public $age;
    public $sex;

    public function setPatientID($id)
    {
        $this->pid = $id;
        $patient = Patient::find($this->pid);
        $midleName = ($patient->middle_name)? $patient->middle_name[0].'.' : '';

        $this->name = strtoupper($patient->last_name.', '.$patient->first_name.' '.$midleName);
        $address = Refregion::getAddress($patient->id);
        $this->region = (isset($address->regDesc))? $address->regDesc : '';
        $this->province = (isset($address->provDesc))? $address->provDesc : '';
        $this->city_mun = (isset($address->citymunDesc))? $address->citymunDesc : '';
        $this->brgy = (isset($address->brgyDesc) && $address->brgyDesc != null && $address->brgyDesc != '')? $address->brgyDesc : '' ;
        $this->age = Patient::age($patient->birthday);
        $this->sex = ($patient->sex != null )? $patient->sex : '' ;
    }

    public function Header()
    {
        $style = array('width' => 0.1, 'color' => array(0, 0, 0));

        $this->SetFont('times','',7);
        $this->Image('./public/images/doh-logo.png',5,5,20);
        $this->Image('./public/images/evrmc-logo.png',83,5,14,14);
        $this->SetXY(40,5);
        $this->Cell(25,0,'Republic of the Philippines',0,0,'C',false,'',2,false,'T');
        $this->SetXY(42,8);
        $this->Cell(21,0,'Department of Health',0,0,'C',false,'',2,false,'T');
        $this->SetXY(30,11);
        $this->Cell(45,1,'Department of Health Regional Office No. 8',0,0,'C',false,'',2,false,'T');
        $this->SetXY(23,14);
        $this->Cell(59,1,'EASTERN VISAYAS REGIONAL MEDICAL CENTER',0,0,'C',false,'',2,false,'T');
        $this->SetXY(44,17);
        $this->Cell(17,0,'Tacloban City',0,0,'C',false,'',2,false,'T');
        $this->SetXY(27,20);
        $this->Cell(50,1,'(053)832-0308;evrmcmccoffice@gmail.com',0,0,'C',false,'',2,false,'T');
        $this->SetXY(28,23);
        $this->SetFont('times','',10);
        $this->Cell(48,1,'"PHIC Accredited Health Care Provider"',0,0,'C',false,'',2,false,'T');

        $this->SetFont('times','',7);
        $this->SetXY(79.5,25);
        $this->Cell(6,0,'Date:',0,0,'C',false,'',2,false,'T');
        $this->SetFont('times','B',8);
        $this->Text(86,25,Carbon::now()->format('m/d/Y'));
        $this->Line(86, 28, 99, 28, $style);

        $this->SetXY(5,35);
        $this->Cell(15,0,'Patient Name:',0,0,'C',false,'',2,false,'T');
        $this->SetFont('times','B',8);
        $this->Text(21,34.7,$this->name);
        $this->Line(20, 38, 65, 38, $style);

        $this->SetXY(67,35);
        $this->Cell(6,0,'Age:',0,0,'C',false,'',2,false,'T');
        $this->SetFont('times','B',8);
        $this->Text(77,34.7,$this->age);
        $this->Line(74, 38, 85, 38, $style);
        $this->SetFont('times','',7);
        $this->SetXY(86,35);
        $this->Cell(6,0,'Sex:',0,0,'C',false,'',2,false,'T');
        $this->SetFont('times','B',8);
        $this->Text(94,34.7,$this->sex);
        $this->Line(92, 38, 99, 38, $style);



        
        $this->SetFont('times','',7);
        $this->SetXY(5,41.5);
        $this->Cell(10,0,'Address:',0,0,'C',false,'',2,false,'T');
        $this->SetFont('times','',7);
        $this->Text(16,38.5,$this->region.' '.$this->province);
        $this->Text(16,41.5,$this->city_mun.' '.$this->brgy);
        $this->Line(15, 44.5, 99, 44.5, $style);
        
    }

    public function Footer()
    {
        $this->SetFont('times','',8);
        $this->SetXY(10,133);
        $this->Cell(50,0,'______________________________________________',0,0,'C',false,'',2,false,'T');
        $this->SetXY(10,137);
        $this->Cell(50,0,'Patient Signature',0,0,'C');
       
    }


}
