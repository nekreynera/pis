<?php

namespace App;
use TCPDF;
use App\Patient;
use App\Refregion;
use Carbon;

class Pdf extends TCPDF
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
        $this->SetFont('times','',7);
        $this->Cell(48,1,'"PHIC Accredited Health Care Provider"',0,0,'C',false,'',2,false,'T');
        $this->SetXY(5,30);
        $this->Cell(15,0,'Patient Name:',0,0,'C',false,'',2,false,'T');
        $this->SetFont('times','B',8);
        $this->Text(21,29.7,$this->name);
        $this->Line(20, 33, 79, 33, $style);
        $this->SetFont('times','',7);
        $this->SetXY(79.5,30);
        $this->Cell(6,0,'Date:',0,0,'C',false,'',2,false,'T');
        $this->SetFont('times','B',8);
        $this->Text(86,29.7,Carbon::now()->format('m/d/Y'));
        $this->Line(86, 33, 99, 33, $style);
        $this->SetFont('times','',7);
        $this->SetXY(5,36.5);
        $this->Cell(10,0,'Address:',0,0,'C',false,'',2,false,'T');
        $this->SetFont('times','',7);
        $this->Text(16,33.5,$this->region.' '.$this->province);
        $this->Text(16,36.5,$this->city_mun.' '.$this->brgy);
        $this->Line(15, 39.5, 99, 39.5, $style);
        $this->SetXY(59,40.5);
        $this->Cell(6,0,'Age:',0,0,'C',false,'',2,false,'T');
        $this->SetFont('times','B',8);
        $this->Text(66,40,$this->age);
        $this->Line(65, 43.3, 85, 43.3, $style);
        $this->SetFont('times','',7);
        $this->SetXY(86,40.5);
        $this->Cell(6,0,'Sex:',0,0,'C',false,'',2,false,'T');
        $this->SetFont('times','B',8);
        $this->Text(94,40,$this->sex);
        $this->Line(92, 43.3, 99, 43.3, $style);
        $this->Image('./public/images/rx.png',6,43,8);
    }

    public function Footer()
    {
        $this->SetFont('times','',8);
        $this->SetXY(70,133);
        $this->Cell(28,0,'___________________,MD',0,0,'C',false,'',2,false,'T');
        $this->SetXY(70,137);
        $this->Cell(28,0,'Lic No._________________',0,0,'C',false,'',2,false,'T');
        $this->SetXY(70,140);
        $this->Cell(28,0,'PTR No._________________',0,0,'C',false,'',2,false,'T');
    }


}
