<?php

namespace App\Http\Controllers\LABORATORY;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Patient;
use App\LaboratoryPrintedRequest;
use PDF;
use Carbon;
use Auth;
use DB;


class PDFController extends Controller
{
    public function getlaboratoryrequestfulldata($patient_id, $request_id)
    {
    	$id = explode(',', $request_id);
    	foreach ($id as $key => $value) {
    		$check = LaboratoryPrintedRequest::where('laboratory_request_id', '=', $id[$key])->first();
    		if ($check) {
    			$check->user_id = Auth::user()->id;
    			$check->updated_at = Carbon::now()->format('Y-m-d H:i:s');
    			$check->save();
    		}else{
    			$printed = new LaboratoryPrintedRequest();
    			$printed->user_id = Auth::user()->id;
    			$printed->laboratory_request_id = $id[$key];
    			$printed->save();
    		}
    	}

    	$patient = DB::select("SELECT 
    								(CASE WHEN a.hospital_no THEN a.hospital_no ELSE CONCAT('WALK-IN-',a.walkin) END) as hospital_no,
								    a.last_name, a.first_name, a.middle_name,
								    a.birthday,
								    a.sex,
								    d.brgyDesc, 
								    e.citymunDesc,
								    c.description,
								    b.updated_at,
								    g.label, g.description as mssdescription
								FROM patients a 
								LEFT JOIN consultations_icd b ON a.id = b.patients_id
								LEFT JOIN icd_codes c ON b.icd = c.id
								LEFT JOIN refbrgy d ON a.brgy = d.id
								LEFT JOIN refcitymun e ON a.city_municipality = e.citymunCode
								LEFT JOIN mssclassification f ON a.id = f.patients_id AND DATE(f.validity) >= CURRENT_DATE()
								LEFT JOIN mss g ON f.mss_id = g.id
								WHERE a.id = ?
								ORDER BY b.created_at DESC
								LIMIT 1
								", [$patient_id]);
    	$items = DB::select("SELECT a.qty,
									c.name as item,
							        d.id as groups, 
							        d.name as group_name,
								    e.last_name, e.first_name, e.middle_name
							FROM laboratory_requests a 
							LEFT JOIN laboratory_request_groups b ON a.laboratory_request_group_id = b.id
							LEFT JOIN laboratory_sub_list c ON a.item_id = c.id
							LEFT JOIN laboratory_sub d ON c.laboratory_sub_id = d.id
							LEFT JOIN users e ON b.user_id = e.id AND e.role = 7
							WHERE b.patient_id = ?
							AND a.id IN($request_id)
							ORDER BY b.id DESC
							", [$patient_id]);
    	$group = DB::select("SELECT a.qty,
									c.name as item,
							        d.id as groups, 
							        d.name as group_name
							FROM laboratory_requests a 
							LEFT JOIN laboratory_request_groups b ON a.laboratory_request_group_id = b.id
							LEFT JOIN laboratory_sub_list c ON a.item_id = c.id
							LEFT JOIN laboratory_sub d ON c.laboratory_sub_id = d.id
							WHERE b.patient_id = ?
							AND a.id IN($request_id)
							GROUP BY d.id
							", [$patient_id]);
    	$this->printrequestform($patient[0], $items, $group);


    	
    }
    public function printrequestform($patient, $items, $group)
    {
		$border = array('width' => 0.3, 'color' => array(0, 0, 0));
		$line = array('width' => 0.1, 'color' => array(0, 0, 0));
		PDF::SetTitle('LABORATORY REQUEST FORM');
		PDF::SetCreator('DARRYL JOSEPH A. BAGARES');
		PDF::SetSubject('EVRMC OPD');
		PDF::SetKeywords('EVRMC-OUT PATIENT DEPARTMENT');
		PDF::SetAuthor(Auth::user()->first_name.' '.substr(Auth::user()->middle_name, 0,1).'. '.Auth::user()->last_name);

		for ($i=0; $i < count($group); $i++) { 
			PDF::AddPage('P',array(109,165));
			PDF::SetAutoPageBreak(TRUE, 0);


		    $y = PDF::getY();
		    PDF::Line(3,  $y-5, 105.5,  $y-5, $border);
		    PDF::Line(3,  $y+150, 105.5,  $y+150, $border);
		    /*=====HORIZONTAL====*/
		    PDF::Line(3,  $y-5, 3,  $y+150, $border);
		    PDF::Line(105.5,  $y-5, 105.5,  $y+150, $border);
		    /*=====VERTICAL====*/
		    $evrmc_logo = './public/images/evrmc-logo.png';
		    PDF::Image($evrmc_logo,4,6,15.5,15.5);
		    /*======EVRMC LOGO======*/
			PDF::SetFont('helvetica','B',8);
		    PDF::text(19,8,'EASTERN VISAYAS REGIONAL MEDICAL CENTER');
		    PDF::SetFont('','');
		    PDF::text(19,13,'Tacloban City, Philippines 6500');
		    /*======EVRMC HEADER======*/
			PDF::SetFont('','B',9);
		    PDF::text(29,19,'LABORATORY REQUEST FORM');
		    /*======LABORATORY HEADER=====*/

			PDF::SetFont('','',8);
		    PDF::text(56.5,23,'Date:'); 
		    PDF::SetXY(65,$y+12);
		    PDF::Cell(38,5,Carbon::now()->format('m/d/Y'),0,0,'C');/*=====VALUE=====*/
		    PDF::Line(65,  $y+15.5, 103,  $y+15.5, $line);

		    PDF::SetFont('','',8);
		    PDF::text(56.5,27,'Mss Classification:'); 
		    PDF::SetXY(82,$y+16);
		    if ($patient->label) {
		    PDF::Cell(21,5,$patient->label.' - '.$patient->mssdescription,0,0,'C');/*=====VALUE=====*/
		    }else{
		    PDF::Cell(21,5,"N/A",0,0,'C');/*=====VALUE=====*/
		    }
		    PDF::Line(82,  $y+19.5, 103,  $y+19.5, $line);

		    PDF::text(56.5,31,'Hospital Number:'); 
		    PDF::SetXY(80,$y+20);
		    PDF::Cell(23,5,'OPD - '.$patient->hospital_no,0,0,'C');/*=====VALUE=====*/
		    PDF::Line(80,  $y+23.5, 103,  $y+23.5, $line);

		    PDF::text(4,35,'Patient Name:'); 
		    PDF::SetXY(23,$y+24);
		    PDF::Cell(51,5,$patient->last_name.', '.$patient->first_name.' '.$patient->middle_name,0,0,'');/*=====VALUE=====*/
		    PDF::Line(23,  $y+27.5, 73.5,  $y+27.5, $line);

		    PDF::text(73,35,'Age:'); 
		    PDF::SetXY(80,$y+24);
		    PDF::Cell(9.5,5,Patient::age($patient->birthday),0,0,'C');/*=====VALUE=====*/
		    PDF::Line(80,  $y+27.5, 89,  $y+27.5, $line);

		    PDF::text(88,35,'Sex:'); 
		    PDF::SetXY(95,$y+24);
		    PDF::Cell(9,5,$patient->sex,0,0,'C');/*=====VALUE=====*/
		    PDF::Line(95.5,  $y+27.5, 103,  $y+27.5, $line);

		    PDF::text(4,39,'Date of Birth:'); 
		    PDF::SetXY(22,$y+28);
		    PDF::Cell(21,5,Carbon::parse($patient->birthday)->format('m/d/Y'),0,0,'C');/*=====VALUE=====*/
		    PDF::Line(22,  $y+31.5, 43,  $y+31.5, $line);

		    PDF::text(42,39,'Address:'); 
		    PDF::SetXY(55,$y+28);
		    PDF::Cell(49,5,$patient->brgyDesc.', '.$patient->citymunDesc,0,0,'');/*=====VALUE=====*/
		    PDF::Line(54.5,  $y+31.5, 103,  $y+31.5, $line);

		    PDF::text(4,43,'Clinical Diagnosis:'); 
		    PDF::SetXY(28,$y+32);
		    PDF::Cell(30,5,$patient->description,0,0,'');/*=====VALUE=====*/
		    PDF::Line(28.5,  $y+35.5, 58,  $y+35.5, $line);

		    /*=====PATIENT INFO=====*/
		    PDF::SetFont('','B',8);
			PDF::text(4,PDF::getY()+15,strtoupper($group[$i]->group_name));
		    PDF::SetFont('','',8);

		    foreach ($items as $list) {
		    	if ($list->groups == $group[$i]->groups) {
					PDF::text(8,PDF::getY()+5,$list->item);
		    	}
		    }
			



		    /*=====PATIENT REQUEST LIST=====*/


		    PDF::SetFont('','B',8);

		    PDF::text(4,$y+115,'Requesting Physician:'); 
		    PDF::SetXY(35,$y+115);
		    if (count($items) > 0) {
		    	# code...
		    	if ($items[0]->last_name) {
		    		PDF::Cell(70,4,$items[0]->last_name.', '.$items[0]->first_name.' '.$items[0]->middle_name,0,0,'');
		    	}
		    }
		    PDF::Line(35,  $y+119, 103,  $y+119, $line);

		    PDF::Line(4,  $y+123, 103,  $y+123, $line);
		    PDF::SetXY(4,$y+123);
		    PDF::Cell(99,4,"To be filled-up by Laboratory personnel",0,0,'C');
		    PDF::Line(4,  $y+127, 103,  $y+127, $border);
		    	/*=====FOOTET TOP=====*/

		    $y = $y+127;
		   	PDF::text(4,$y+3,'Received by:'); 
		   	PDF::SetXY(23,$y+2);
		   	PDF::Cell(44,5,Auth::user()->first_name.' '.substr(Auth::user()->middle_name, 0,1).'. '.Auth::user()->last_name,0,0,'');/*=====VALUE=====*/
		   	PDF::Line(23,  $y+6, 67,  $y+6, $line);

		   	PDF::text(67,$y+3,'Time:'); 
		   	PDF::SetXY(76.5,$y+2);
		   	PDF::Cell(27.5,5,Carbon::now()->format('h:i A'),0,0,'C');/*=====VALUE=====*/
		   	PDF::Line(76,  $y+6, 103,  $y+6, $line);

		   	$y = $y+3;
		   	PDF::text(4,$y+3,'Extracted by:'); 
		   	PDF::SetXY(24,$y+2);
		   	PDF::Cell(49,5,"",0,0,'');/*=====VALUE=====*/
		   	PDF::Line(24,  $y+6, 67,  $y+6, $line);

		   	PDF::text(67,$y+3,'Time:'); 
		   	PDF::SetXY(73.5,$y+2);
		   	PDF::Cell(29.5,5,"",0,0,'C');/*=====VALUE=====*/
		   	PDF::Line(76,  $y+6, 103,  $y+6, $line);

		   	$y = $y+3;
		   	PDF::text(4,$y+3,'Encoded by:'); 
		   	PDF::SetXY(22,$y+2);
		   	PDF::Cell(49,5,"",0,0,'');/*=====VALUE=====*/
		   	PDF::Line(22,  $y+6, 67,  $y+6, $line);

		   	PDF::text(67,$y+3,'Time:'); 
		   	PDF::SetXY(73.5,$y+2);
		   	PDF::Cell(29.5,5,"",0,0,'C');/*=====VALUE=====*/
		   	PDF::Line(76,  $y+6, 103,  $y+6, $line);

		   	$y = $y+3;
		   	PDF::text(4,$y+3,'MedTech:'); 
		   	PDF::SetXY(22,$y+2);
		   	PDF::Cell(49,5,"",0,0,'');/*=====VALUE=====*/
		   	PDF::Line(19,  $y+6, 67,  $y+6, $line);

		   	$y = $y+3;
		   	PDF::text(4,$y+3,'Time and Date released:'); 
		   	PDF::SetXY(38,$y+2);
		   	PDF::Cell(38,5,"",0,0,'C');/*=====VALUE=====*/
		   	PDF::Line(38,  $y+6, 67,  $y+6, $line);
		   		/*=====LABORATORY STAFF=====*/

		    /*=====LABORATORY FOOTER=====*/
		    PDF::SetFont('','',6);
		    PDF::SetXY(80,$y+1);
		    PDF::Cell(24,5,"PATHO-LABORREQF",0,0,'R');/*=====VALUE=====*/
		    PDF::SetXY(80,$y+3);
		    PDF::Cell(24,5,"29-March-2019",0,0,'R');/*=====VALUE=====*/
		    PDF::SetXY(80,$y+5);
		    PDF::Cell(24,5,"Rev. 01",0,0,'R');/*=====VALUE=====*/
		    /*=====ISO REVISION*/

		}




		PDF::Output();
		return;
    }

    public function printopdlrlogs($request_id){
    	$groups = DB::select("SELECT 
    								d.id,
							        d.name as group_name
							FROM laboratory_requests a 
							LEFT JOIN laboratory_sub_list c ON a.item_id = c.id
							LEFT JOIN laboratory_sub d ON c.laboratory_sub_id = d.id
							WHERE a.id IN($request_id)
							GROUP BY d.id");
    	$this->opdlrlogslayout($request_id, $groups);
    }
    public function opdlrlogslayout($request_id, $groups)
    {
    	$border = array('width' => 0.3, 'color' => array(0, 0, 0));
    	$line = array('width' => 0.1, 'color' => array(0, 0, 0));
    	PDF::SetTitle('PATHO-OPDLRLOGS');
    	PDF::SetCreator('DARRYL JOSEPH A. BAGARES');
    	PDF::SetSubject('EVRMC OPD');
    	PDF::SetKeywords('EVRMC-OUT PATIENT DEPARTMENT');
    	PDF::SetAuthor(Auth::user()->first_name.' '.substr(Auth::user()->middle_name, 0,1).'. '.Auth::user()->last_name);

    	foreach ($groups as $group) {
	    	PDF::AddPage('L', '');
			PDF::SetAutoPageBreak(TRUE, 0);
		    $this->opdlrlogsheader($group, $line);
	   	 	/*======EVRMC HEADER======*/
		
    		$y = PDF::getY() + 7;
		    $this->opdlrlogstableheader($y);
		    /*TABLE HEADER*/

			$y = PDF::getY();
			$this->opdlrlogsfooter();   

			/*======EVRMC FOOTER======*/   
			$patients = DB::select("SELECT f.updated_at,
			                            c.last_name, c.first_name, c.middle_name,
			                            c.id,
			                            GROUP_CONCAT(d.name) as list,
			                            c.hospital_no
			                    FROM laboratory_requests a
			                    LEFT JOIN laboratory_request_groups b ON a.laboratory_request_group_id = b.id
			                    LEFT JOIN patients c  ON b.patient_id = c.id
			                    LEFT JOIN laboratory_sub_list d ON a.item_id = d.id
			                    LEFT JOIN laboratory_sub e ON d.laboratory_sub_id = e.id
			                    LEFT JOIN laboratory_printed_request f ON a.id = f.laboratory_request_id
			                    WHERE a.id IN($request_id)
			                    AND e.id = ?
			                    GROUP BY c.id
			                    ORDER BY f.created_at DESC",
			                	[$group->id]);
			/*======PATEINTS======*/ 
		    PDF::SetFont('','',10);
			$trim = 28;
			$i = 0;
			foreach ($patients as $patient) {
		    	if ($y > 185) {
		    		PDF::AddPage('L', '');
		    		$y = 20;
		    		$this->opdlrlogstableheader($y);	
		    		$trim+=32;
		    		$y = 44;
    				$this->opdlrlogsfooter();    
					/*======EVRMC FOOTER======*/    
		    	}
		    	$newy = $this->opdlrlogstablebody($y, $i, $patient, $request_id, $group->id);	
    			$y=$newy;
    			// $y = PDF::getY();
				$i++;
			}
    	}


		PDF::Output();
		return;
    }
    public function opdlrlogsheader($group, $line)
    {
	    $evrmc_logo = './public/images/evrmc-logo.png';
	    PDF::Image($evrmc_logo,10,10,25,25);
	    /*======EVRMC LOGO======*/
		PDF::SetFont('helvetica','B',11);
	    PDF::text(35,15,'EASTERN VISAYAS REGIONAL MEDICAL CENTER');
	    // PDF::text(35,15,'OPD RECEIVING / RELEASING LOGSHEET FOR');
	    /*=====*/PDF::SetXY(132,15);
	    // /*=====*/PDF::MultiCell(140,5,"OPD RECEIVING / RELEASING LOGSHEET FOR ".strtoupper($group->group_name),'',"R",false);/*=====VALUE=====*/
	    /*=====*/PDF::MultiCell(153,5,"OPD RECEIVING / RELEASING LOGSHEET",0,"R",false);/*=====VALUE=====*/
	    PDF::SetFont('','');
	    PDF::text(35,20,'Tacloban City, Philippines 6500');

	    $y = 38;
		PDF::SetFont('helvetica','B',11);
		PDF::SetXY(25,$y);
		PDF::MultiCell(100,5,strtoupper($group->group_name),0,"C",false);/*=====VALUE=====*/
	    PDF::text(8,$y,'SECTION: ');
	    PDF::text(132,$y,'IN-PATIENT ');
	    // PDF::text(132,180,'IN-PATIENT ');
	    PDF::text(182,$y,'OUT-PATIENT ');

	    PDF::SetXY(250,$y);
	    PDF::Cell(30,5,Carbon::now()->format('F/Y'),0,0,'C');

	    PDF::text(220,$y,'MONTH / YEAR: ');
	   
	    PDF::Rect(127, $y, 5, 5, 'D', array('all' => $line));
	    PDF::SetFont('zapfdingbats', '', 12);
	    PDF::text(177,$y,"4");
		PDF::SetFont('helvetica','',11);
	    PDF::Rect(177, $y, 5, 5, 'D', array('all' => $line));
	    $line_row = $y+5;
		PDF::Line(28,  $line_row, 115,  $line_row, $line);
		PDF::Line(250,  $line_row, 280,  $line_row, $line);

    }
    public function opdlrlogsfooter()
    {
		PDF::SetFont('','',8);
    	PDF::text(256,192,'PATHO-OPDLRLOGS');
    	PDF::text(266.5,195,'5-March-2019');
    	PDF::text(275.5,198,'Rev.01');
    }
    public function opdlrlogstableheader($y)
    {
		PDF::SetFont('helvetica','',8);
    	PDF::SetFillColor(217, 217, 217);
    	PDF::SetXY(3,$y);
    	PDF::MultiCell(8,22,"\n\nNo",1,'C',true);

    	$x = 3+8;
    	PDF::SetXY($x,$y);
    	PDF::MultiCell(40,5,"Received",1,'C',true);

    	$x = 3+8;
    	PDF::SetXY($x,$y+5);
		// PDF::SetFont('helvetica','',9);
    	PDF::MultiCell(30,17,"\n\nDate / Time",1,'C',true);

    	$x = 3+8+30;
    	PDF::SetXY($x,$y+5);
    	// PDF::SetFont('helvetica','',9);
    	PDF::MultiCell(10,17,"\n\nFrom",1,'C',true);
		// PDF::SetFont('helvetica','',11);
    	$x+=10;
    	PDF::SetXY($x,$y);
    	PDF::MultiCell(40,22,"\n\nPatient's Name",1,'C',true);

    	$x+=40;
    	PDF::SetXY($x,$y);
    	PDF::MultiCell(13,22,"\n\nHospital\nNumber",1,'C',true);

    	$x+=13;
    	PDF::SetXY($x,$y);
    	PDF::MultiCell(64,22,"\n\nLab Test Done\n.",1,'C',true);
    	$x+=64;
    	PDF::SetXY($x,$y);
    	PDF::MultiCell(110,5,"Result",1,'C',true);

    	PDF::SetXY($x,$y+5);
    	PDF::MultiCell(35,5,"Available",1,'C',true);

		// PDF::SetFont('helvetica','',9);
    	PDF::SetXY($x,$y+10);
    	PDF::MultiCell(17,12,"\nDate / Time",1,'C',true);

    	PDF::SetXY($x+17,$y+10);
    	PDF::MultiCell(18,12,"\nProcessing\nTime",1,'C',true);
		// PDF::SetFont('helvetica','',11);

		PDF::SetXY($x+35,$y+5);
    	PDF::MultiCell(73,5,"Released",1,'C',true);

		// PDF::SetFont('helvetica','',9);
		PDF::SetXY($x+35,$y+10);
    	PDF::MultiCell(17,12,"\nDate / Time",1,'C',true);

		// PDF::SetFont('helvetica','',7);
    	PDF::SetXY($x+35+17,$y+10);
    	PDF::MultiCell(20,12,"Received by\n",1,'C',true);
		PDF::SetFont('helvetica','',6);
		PDF::SetXY($x+35+17,$y+10);
    	PDF::MultiCell(20,5,"\n\n(Name & Signature)",0,'C',true);

    	$x+=35+17+20;
		PDF::SetFont('helvetica','',8);
		PDF::SetXY($x,$y+10);
    	PDF::MultiCell(12,12,"No of\nHours\nLapse",1,'C',true);

    	$x+=12;

    	PDF::SetXY($x,$y+10);
    	PDF::MultiCell(20,12,"\nReason",1,'C',true);

    	$x+=20;

    	PDF::SetXY($x,$y);
    	PDF::MultiCell(20,22,"\n\nRemarks",1,'C',true);

    	
    }

    public function opdlrlogstablebody($y, $i, $patient, $request_id, $group_id)
    {

		PDF::SetFont('helvetica','',8);
    	$cellY = PDF::getStringHeight(64, $patient->list);
    	$cellY+=0.590278;
		/*to adjust cell hieght*/

    	PDF::SetXY(3,$y);
    	PDF::Cell(8,$cellY,$i+1,1,0,'C');
    	$x = 3+8;
    	PDF::SetXY($x,$y);
    	PDF::Cell(30,$cellY,Carbon::parse($patient->updated_at)->format('m/d/y h:i A'),1,0,'C');

		// PDF::SetFont('helvetica','',11);

    	$x+=30;
		PDF::SetXY($x,$y);
		PDF::Cell(10,$cellY,"OPD",1,0,'C');

    	$x+=10;
    	PDF::SetXY($x,$y);
    	PDF::Cell(40,$cellY,$patient->last_name.', '.$patient->first_name.' '.substr($patient->middle_name, 0,1).'. ',1,0,'');
    	$x+=40;
    	PDF::SetXY($x,$y);
    	PDF::Cell(13,$cellY,$patient->hospital_no,1,0,'C');

    	$x+=13;
    	PDF::SetXY($x,$y);
    	PDF::MultiCell(64,$cellY,$patient->list,1,'C',false);
    	
    	$newy=PDF::getY();

    	$x+=64;
    	PDF::SetXY($x,$y);
    	PDF::Cell(17,$cellY,"",1,0,'C');

    	$x+=17;
    	PDF::SetXY($x,$y);
    	PDF::Cell(18,$cellY,"",1,0,'C');

    	$x+=18;
    	PDF::SetXY($x,$y);
    	PDF::Cell(17,$cellY,"",1,0,'C');	

    	$x+=17;
    	PDF::SetXY($x,$y);
    	PDF::Cell(20,$cellY,"",1,0,'C');	

    	$x+=20;
    	PDF::SetXY($x,$y);
    	PDF::Cell(12,$cellY,"",1,0,'C');

    	$x+=12;
    	PDF::SetXY($x,$y);
    	PDF::Cell(20,$cellY,"",1,0,'C');

    	$x+=20;
    	PDF::SetXY($x,$y);
    	PDF::Cell(20,$cellY,"",1,0,'C');	
    	return $newy;
    }

    public function printlaboatorychargeslip($patient_id, $request_id)
    {
    	$id = explode(',', $request_id);
    	$patient = DB::select("SELECT 
    								(CASE WHEN a.hospital_no THEN a.hospital_no ELSE CONCAT('WALK-IN-',a.walkin) END) as hospital_no,
								    a.last_name, a.first_name, a.middle_name,
								    a.birthday,
								    a.sex,
								    d.brgyDesc, 
								    e.citymunDesc,
								    c.description,
								    b.updated_at,
								    g.label, g.description as mssdescription
								FROM patients a 
								LEFT JOIN consultations_icd b ON a.id = b.patients_id
								LEFT JOIN icd_codes c ON b.icd = c.id
								LEFT JOIN refbrgy d ON a.brgy = d.id
								LEFT JOIN refcitymun e ON a.city_municipality = e.citymunCode
								LEFT JOIN mssclassification f ON a.id = f.patients_id AND DATE(f.validity) >= CURRENT_DATE()
								LEFT JOIN mss g ON f.mss_id = g.id
								WHERE a.id = ?
								ORDER BY b.created_at DESC
								LIMIT 1
								", [$patient_id]);
    	$items = DB::select("SELECT a.qty,
									c.name as item_name,
									c.price as item_price,
							        d.id as group_id, 
							        b.created_at,
							        f.discount,
							        g.granted_amount
							FROM laboratory_requests a 
							LEFT JOIN laboratory_request_groups b ON a.laboratory_request_group_id = b.id
							LEFT JOIN laboratory_sub_list c ON a.item_id = c.id
							LEFT JOIN laboratory_sub d ON c.laboratory_sub_id = d.id
							LEFT JOIN users e ON b.user_id = e.id AND e.role = 7
							LEFT JOIN laboratory_payment f ON a.id = f.laboratory_request_id AND f.void = 0 AND f.mss_charge = 1
							LEFT JOIN payment_guarantor g ON f.id = g.payment_id AND g.type = 1
							WHERE b.patient_id = ?
							AND a.id IN($request_id)
							ORDER BY b.id DESC
							", [$patient_id]);
    	$groups = DB::select("SELECT d.id as group_id, 
							        d.name as group_name
							FROM laboratory_requests a 
							LEFT JOIN laboratory_request_groups b ON a.laboratory_request_group_id = b.id
							LEFT JOIN laboratory_sub_list c ON a.item_id = c.id
							LEFT JOIN laboratory_sub d ON c.laboratory_sub_id = d.id
							WHERE b.patient_id = ?
							AND a.id IN($request_id)
							GROUP BY d.id
							", [$patient_id]);
    	// dd($patient[0], $items, $groups);
    	$this->printchargeslip($patient[0], $items, $groups);
    }
    public static function printchargeslip($patient, $items, $groups)
    {
		$border = array('width' => 0.3, 'color' => array(0, 0, 0));
		$line = array('width' => 0.1, 'color' => array(0, 0, 0));
		PDF::SetTitle('LABORATORY CHARGE SLIP');
		PDF::SetCreator('DARRYL JOSEPH A. BAGARES');
		PDF::SetSubject('EVRMC OPD');
		PDF::SetKeywords('EVRMC-OUT PATIENT DEPARTMENT');
		PDF::SetAuthor(Auth::user()->first_name.' '.substr(Auth::user()->middle_name, 0,1).'. '.Auth::user()->last_name);

			PDF::AddPage('P',array(109,165));
			PDF::SetAutoPageBreak(TRUE, 0);


		    $y = PDF::getY();
		    PDF::Line(3,  $y-5, 105.5,  $y-5, $border);
		    PDF::Line(3,  $y+150, 105.5,  $y+150, $border);
		    /*=====HORIZONTAL====*/
		    PDF::Line(3,  $y-5, 3,  $y+150, $border);
		    PDF::Line(105.5,  $y-5, 105.5,  $y+150, $border);
		    /*=====VERTICAL====*/
		    $evrmc_logo = './public/images/evrmc-logo.png';
		    PDF::Image($evrmc_logo,4,6,15.5,15.5);
		    /*======EVRMC LOGO======*/
			PDF::SetFont('helvetica','B',8);
		    PDF::text(19,8,'EASTERN VISAYAS REGIONAL MEDICAL CENTER');
		    PDF::SetFont('','');
		    PDF::text(19,13,'Tacloban City, Philippines 6500');
		    /*======EVRMC HEADER======*/
			PDF::SetFont('','B',9);
		    PDF::text(29,19,'LABORATORY CHARGE SLIP');
		    /*======LABORATORY HEADER=====*/

			PDF::SetFont('','',8);
		    PDF::text(56.5,23,'Datetime:'); 
		    PDF::SetXY(70,$y+12);
		    PDF::Cell(33,5,Carbon::now()->format('m/d/Y h:i a'),0,0,'C');/*=====VALUE=====*/
		    PDF::Line(70,  $y+15.5, 103,  $y+15.5, $line);

		    PDF::SetFont('','',8);
		    PDF::text(56.5,27,'Mss Classification:'); 
		    PDF::SetXY(82,$y+16);
		    if ($patient->label) {
		    PDF::Cell(21,5,$patient->label.' - '.$patient->mssdescription,0,0,'C');/*=====VALUE=====*/
		    }else{
		    PDF::Cell(21,5,"N/A",0,0,'C');/*=====VALUE=====*/
		    }
		    PDF::Line(82,  $y+19.5, 103,  $y+19.5, $line);

		    PDF::text(56.5,31,'Hospital Number:'); 
		    PDF::SetXY(80,$y+20);
		    PDF::Cell(23,5,'OPD - '.$patient->hospital_no,0,0,'C');/*=====VALUE=====*/
		    PDF::Line(80,  $y+23.5, 103,  $y+23.5, $line);

		    PDF::text(4,35,'Patient Name:'); 
		    PDF::SetXY(23,$y+24);
		    PDF::Cell(51,5,$patient->last_name.', '.$patient->first_name.' '.substr($patient->middle_name, 0,1).'.' ,0,0,'');/*=====VALUE=====*/
		    PDF::Line(23,  $y+27.5, 73.5,  $y+27.5, $line);

		    PDF::text(73,35,'Age:'); 
		    PDF::SetXY(80,$y+24);
		    PDF::Cell(9.5,5,Patient::age($patient->birthday),0,0,'C');/*=====VALUE=====*/
		    PDF::Line(80,  $y+27.5, 89,  $y+27.5, $line);

		    PDF::text(88,35,'Sex:'); 
		    PDF::SetXY(95,$y+24);
		    PDF::Cell(9,5,$patient->sex,0,0,'C');/*=====VALUE=====*/
		    PDF::Line(95.5,  $y+27.5, 103,  $y+27.5, $line);

		    PDF::text(4,39,'Date of Birth:'); 
		    PDF::SetXY(22,$y+28);
		    PDF::Cell(21,5,Carbon::parse($patient->birthday)->format('m/d/Y'),0,0,'C');/*=====VALUE=====*/
		    PDF::Line(22,  $y+31.5, 43,  $y+31.5, $line);

		    PDF::text(42,39,'Address:'); 
		    PDF::SetXY(55,$y+28);
	    	PDF::MultiCell(49,5,$patient->brgyDesc.', '.$patient->citymunDesc,0,"L",false);/*=====VALUE=====*/
		    // PDF::Cell(49,5,$patient->brgyDesc.', '.$patient->citymunDesc,0,0,'');/*=====VALUE=====*/
		    PDF::Line(54.5,  $y+31.5, 103,  $y+31.5, $line);
		    /*=====PATIENT INFO=====*/

		    $fill = PDF::SetFillColor(230, 230, 230);
		   	$y = PDF::getY()+5;
		    	PDF::SetFont('','B',8);
		    $x = 6;
		   	PDF::SetXY($x,$y);
			PDF::Cell(40,8,'REQUESTS',0,0,'C', $fill);/*=====VALUE=====*/
			PDF::SetXY(42,$y);
			PDF::Cell(15,8,'AMOUNT',0,0,'C', $fill);/*=====VALUE=====*/
			PDF::SetXY(57,$y);
			PDF::MultiCell(15,8,'DISCOUNT',0,'C', $fill);/*=====VALUE=====*/
			PDF::SetXY(72,$y);
			PDF::MultiCell(15,8,'GUARANTOR',0,'C', $fill);/*=====VALUE=====*/
			PDF::SetXY(87,$y);
			PDF::MultiCell(15,8,'NET AMOUNT',0,'C', $fill);/*=====VALUE=====*/
		   	$y = PDF::getY();
		    $fill = PDF::SetFillColor(242, 242, 242);
		    $total = 0;
		    PDF::SetFont('','',8);
		    PDF::text(3,160,'Disclaimer: This is a system-generated report.');
		    PDF::text(95,160,''.PDF::getAliasNumPage().' of '.PDF::getAliasNbPages().'');

		    foreach ($groups as $group) {

		    	PDF::SetFont('','B',8);

		   		// $y = PDF::getY()+5;
		   		PDF::SetXY($x,$y);
		    	PDF::Cell(96,5,strtoupper($group->group_name),0,0,'', $fill);/*=====VALUE=====*/
		    	// PDF::SetFont('','',9);
		   		foreach ($items as $item) {
			    	if ($item->group_id == $group->group_id) {
			    		// if ($group->group_id == 5) {
			    		// 	# code...
			    		// dd($item);
			    		// }
		   				$y = PDF::getY()+5;
		   				if ($y>=155) {
		   					PDF::AddPage('P',array(109,165));
							PDF::SetAutoPageBreak(TRUE, 0);
							$y = PDF::getY();
							PDF::Line(3,  $y-5, 105.5,  $y-5, $border);
						    PDF::Line(3,  $y+150, 105.5,  $y+150, $border);
						    /*=====HORIZONTAL====*/
						    PDF::Line(3,  $y-5, 3,  $y+150, $border);
						    PDF::Line(105.5,  $y-5, 105.5,  $y+150, $border);
		    				PDF::SetFont('','',8);
		    				PDF::text(3,160,'Disclaimer: This is a system-generated report.');
		    				PDF::text(95,160,''.PDF::getAliasNumPage().' of '.PDF::getAliasNbPages().'');
		   				}
		    			PDF::SetFont('','',9);
		    			PDF::SetXY($x,$y);
		    			PDF::MultiCell(38,5,$item->item_name.':',0,'R', false);/*=====VALUE=====*/
		    			$amount = $item->qty * $item->item_price;
		    			PDF::SetXY(42,$y);
		    			PDF::Cell(15,5,number_format($amount,2,".",","),0,0,'R');/*=====VALUE=====*/
		    			PDF::SetXY(57,$y);
		    			PDF::Cell(15,5,($item->discount)?number_format($item->discount,2,".",","):'',0,0,'R');/*=====VALUE=====*/
		    			PDF::SetXY(72,$y);
		    			PDF::Cell(15,5,($item->granted_amount)?number_format($item->granted_amount,2,".",","):'',0,0,'R');/*=====VALUE=====*/
		    			PDF::SetXY(87,$y);
		    			$net_amount = $amount - ($item->discount + $item->granted_amount);
		    			$total+=$net_amount;
		    			PDF::Cell(15,5,number_format($net_amount,2,".",","),0,0,'R');/*=====VALUE=====*/
		   				// $y = PDF::getY();
		    			// $y-=5;
		    			// PDF::getY()-5;
						// PDF::text(8,,$item->item_name);
		   				// $y = PDF::getY()+5;
			    	}
		   			$y = PDF::getY()+5;
		    	}
		    }
		    $y = PDF::getY()+5;
		    PDF::SetFont('','B',9);
		    PDF::SetXY(6,$y);
		    PDF::Cell(80,5,'TOTAL NET AMOUNT:',0,0,'R');/*=====VALUE=====*/
		    PDF::SetXY(87,$y);
		    PDF::Cell(15,5,number_format($total,2,".",","),0,0,'R');/*=====VALUE=====*/
			

		    
			



		    /*=====PATIENT REQUEST LIST=====*/







		PDF::Output();
		return;
    }
}
