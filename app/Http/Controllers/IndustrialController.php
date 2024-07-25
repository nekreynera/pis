<?php

namespace App\Http\Controllers;

use App\Consultation;
use App\IndustrialFinalResult;
use App\Patient;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Http\Request;
use App\IndustrialForm;
use App\IndustrialSystemReview;
use App\IndustrialHistory;
use App\IndustrialSurvey;
use App\IndustrialPhysicalExam;
use DB;
use PDF;
use Carbon;





class IndustrialController extends Controller
{






    public function store(Request $request)
    {

        /*for saving data*/

        $result = (new IndustrialForm())->store($request);

        $id = ($result)? $result->id : false ;

        $industrialSystemReview = (new IndustrialSystemReview())->store($request, $id);

        $industrialHistory = (new IndustrialHistory())->store($request, $id);

        $industrialSurvey = (new IndustrialSurvey())->store($request, $id);

        $industrialFinalResult = (new IndustrialFinalResult())->store($request, $id);

        $industrialPhysicalExam = (new IndustrialPhysicalExam())->store($request, $id);

        if($industrialSystemReview || $industrialHistory || $industrialSurvey
            || $industrialFinalResult || $industrialPhysicalExam || $request->result)
        {
            if($result){
                return $result->toJson();
            }else{
                echo json_encode('updated');
                return;
            }
        }else{
            IndustrialForm::find($result->id)->delete();
            echo json_encode('deleted');
            return;
        }

    }


    public function preview($id)
    {
        $industrialConsultations = IndustrialForm::with('system_reviews', 'industrial_history',
            'physical_exams', 'industrial_surveys', 'final_results')
            ->where([
                ['id', $id],
            ])
            ->first();
        $patient = Patient::find($industrialConsultations->patient_id);

        return view('doctors.industrial.preview', compact('industrialConsultations', 'patient'));
    }
    public function industrialPreviewreception($id)
    {
        $industrialConsultations = IndustrialForm::with('system_reviews', 'industrial_history',
            'physical_exams', 'industrial_surveys', 'final_results')
            ->where([
                ['id', $id],
            ])
            ->first();
        $patient = Patient::find($industrialConsultations->patient_id);

        return view('receptions.industrial_show', compact('industrialConsultations', 'patient'));
    }



    public function printing($id)
    {

        $industrialConsultations = IndustrialForm::with('system_reviews', 'industrial_history',
            'physical_exams', 'industrial_surveys', 'final_results')
            ->find($id);
        $patient = Patient::find($industrialConsultations->patient_id);

        PDF::SetTitle('Industrial Form');
        PDF::SetAutoPageBreak(true, 10, true);
        PDF::AddPage('P','A4');
        // PDF::SetFont('times','');
        // PDF::SetXY(83,5);
        // PDF::Cell(45,1,'Republic of the Philippines',0,0,'C',false,'',2,false,'T');
        // PDF::SetXY(86,10);
        // PDF::Cell(40,1,'Department of Health',0,0,'C',false,'',2,false,'T');
        // PDF::SetXY(68,15);
        // PDF::Cell(75,1,'Department of Health Regional Office No. 8',0,0,'C',false,'',2,false,'T');
        PDF::SetFont('','B', 14);
        PDF::SetXY(40,17);
        PDF::Cell(100,1,'EASTERN VISAYAS REGIONAL MEDICAL CENTER',0,0,'C',false,'',2,false,'T');
        PDF::SetFont('','', 12);
        PDF::SetXY(40,23);
        PDF::Cell(50,1,'Tacloban City, Philippine 6500',0,0,'C',false,'',2,false,'T');
        // PDF::SetXY(65,30);
        // PDF::Cell(80,1,'(053)832-0308;evrmcmccoffice@gmail.com',0,0,'C',false,'',2,false,'T');
        // PDF::SetXY(70,40);
        // PDF::SetFont('times','I');
        // PDF::Cell(78,1,'"PHIC Accredited Health Care Provider"',0,0,'C',false,'',2,false,'T');
        PDF::SetFont('','B',12);
        PDF::SetXY(70,50);
        PDF::Cell(80,1,'INDUSTRIAL CLINIC CONSULTATION',0,0,'C',false,'',2,false,'T');
        PDF::Image('./public/images/evrmc-logo.png',10,10,25);
        // PDF::Image('./public/images/evrmc-logo.png',160,10.5,25);

//        PDF::SetFont('times','',12);
//        PDF::SetXY(10,60);
//        PDF::Cell(10,1,'NAME:',0,0,'C',false,'',2,false,'T');

        PDF::SetFont('','',11);
        PDF::Text(10,65,'Name:');
        PDF::Text(25,65,$patient->last_name.', '.$patient->first_name.' '.$patient->suffix.' '.$patient->middle_name);
        PDF::Text(10,70,'Date of Consult:');
        PDF::Text(40,70,Carbon::parse($industrialConsultations->date_consulted)->toFormattedDateString());


        $table = \View::make('doctors.industrial.printing', compact('industrialConsultations'));
        PDF::SetXY(10,78);
        PDF::writeHTML($table, true, false, false, false, '');

        PDF::Text(10,121,'Review of Systems:');

        $table1 = \View::make('doctors.industrial.reviewofsystems', compact('industrialConsultations'));
        PDF::SetXY(10,130);
        PDF::writeHTML($table1, true, false, false, false, '');

        $table2 = \View::make('doctors.industrial.reviewofsystems2', compact('industrialConsultations'));
        PDF::SetXY(10,165);
        PDF::writeHTML($table2, true, false, false, false, '');

        $table3 = \View::make('doctors.industrial.reviewofsystems3', compact('industrialConsultations'));
        PDF::SetXY(10,200);
        PDF::writeHTML($table3, true, false, false, false, '');

        $table3 = \View::make('doctors.industrial.past_medical_history', compact('industrialConsultations'));
        PDF::SetXY(10,235);
        PDF::writeHTML($table3, true, false, false, false, '');

        $style = array('border'=>false, 'padding'=>2, 'vpadding'=>0, 'fgcolor'=>array(0,0,0), 'bgcolor'=>array(255,255,255),
            'position'=>'C');


        if($industrialConsultations && $industrialConsultations->physical_exams){
            $pe = true;
        }else{
            $pe = false;
        }

        PDF::SetFont('','',8);
        PDF::text(175,100+173,'INDUSTRIAL - ICC');
        PDF::text(185,103+173,'Page 1 of 2');
        PDF::text(182,106.5+173,'01-April-2019');
        PDF::text(189,110+173,'Rev. 00');

        PDF::AddPage('P','A4');
        PDF::text(175,100+173,'INDUSTRIAL - ICC');
        PDF::text(185,103+173,'Page 2 of 2');
        PDF::text(182,106.5+173,'01-April-2019');
        PDF::text(189,110+173,'Rev. 00');
        PDF::SetFont('','',11);


        PDF::Text(10,15,'Physical Examination:');

        $bp = ($pe)? $industrialConsultations->physical_exams->bp : '' ;
        PDF::Text(47,15,"BP $bp");
        PDF::Text(63,15," mmHg,");
        PDF::Line(53, 20, 65, 20, $style);

        $hr = ($pe)? $industrialConsultations->physical_exams->hr : '' ;
        PDF::Text(77,15,"HR $hr");
        PDF::Text(94,15," bpm,");
        PDF::Line(85, 20, 96, 20, $style);

        $rr = ($pe)? $industrialConsultations->physical_exams->rr : '' ;
        PDF::Text(104,15,"RR $rr");
        PDF::Text(120,15," cpm,");
        PDF::Line(111, 20, 122, 20, $style);

        $temp = ($pe)? $industrialConsultations->physical_exams->temp : '' ;
        PDF::Text(130,15,"Temp $temp,");
        PDF::Text(150,15," °C,");
        PDF::Line(141, 20, 152, 20, $style);

        $bmi = ($pe)? $industrialConsultations->physical_exams->bmi : '' ;
        PDF::Text(158,15,"BMI $bmi");
        PDF::Line(168, 20, 178, 20, $style);

        $wt = ($pe)? $industrialConsultations->physical_exams->wt : '' ;
        PDF::Text(179,15,"wt. $wt");
        PDF::Line(185, 20, 197, 20, $style);

        $ht = ($pe)? $industrialConsultations->physical_exams->ht : '' ;
        PDF::Text(179,22,"ht. $ht");
        PDF::Line(185, 27, 197, 27, $style);


        $table4 = \View::make('doctors.industrial.survey', compact('industrialConsultations'));
        PDF::SetXY(10,30);
        PDF::writeHTML($table4, true, false, false, false, '');

        PDF::Line(88, 45, 200, 45, $style);
        PDF::Line(88, 62, 200, 62, $style);
        PDF::Line(88, 79, 200, 79, $style);
        PDF::Line(88, 95, 200, 95, $style);
        PDF::Line(88, 112, 200, 112, $style);
        PDF::Line(88, 129, 200, 129, $style);
        PDF::Line(88, 146, 200, 146, $style);
        PDF::Line(88, 163, 200, 163, $style);


        $table5 = \View::make('doctors.industrial.final', compact('industrialConsultations'));
        PDF::SetXY(10,180);
        PDF::writeHTML($table5, true, false, false, false, '');
















//        $table = \View::make('doctors.industrial.print', compact('industrialConsultations', 'patient'));
//        PDF::SetXY(10,60);
//        PDF::writeHTML($table, true, false, false, false, '');
        PDF::Output();
    }





}
