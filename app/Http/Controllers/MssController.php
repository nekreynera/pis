<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Patient;
use App\Mss;
use App\Mssclassification;
use App\Mssdiagnosis;
use App\Mssexpenses;
use App\Msshouseexpenses;
use App\Mssfamily;
use App\User;
use App\Mssbatch;
use App\Cashincome;
use App\LaboratoryPayment;
use App\MssLockTransaction;
use Validator;
use DB;
use Auth;
use Carbon\Carbon;
use Session;


class MssController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view('mss.scan');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $id = Mssclassification::create($request->all());
      $request->request->add(['classification_id' => $id->id]);

      $diagnosis = new Mssdiagnosis();
      $columns = $diagnosis->getColumn();
      $mssDiagnosis = false;
      foreach ($columns as $row) {

          if ($request->$row && $row != 'classification_id') {
                $mssDiagnosis = true;
          }
      }
      if ($mssDiagnosis) {
        $mssid =  Mssdiagnosis::create($request->all());
      }

      $expenses = new Mssexpenses();
      $expcolumns = $expenses->getColumn();
      $mssexpenses = false;
      foreach ($expcolumns as $row) {

          if ($request->$row && $row != 'classification_id') {
                $mssexpenses = true;
          }
      }
      if ($mssexpenses) {
         Mssexpenses::create($request->all());
      }

      if ($request->houselot != "" || $request->light != "" || $request->water != "" || $request->fuel != "") {
         $houseexp = new Msshouseexpenses();
         $houseexp->classification_id = $id->id;
         $houseexp->monthly_expenses = $request->monthly_expenses;
         $houseexp->monthly_expenditures = $request->monthly_expenditures;
         $houseexp->houselot = $request->houselot."-".$request->H_php;
         $houseexp->light = $request->light."-".$request->L_php;
         $houseexp->water = $request->water."-".$request->W_php;
         $houseexp->fuel = $request->fuel."-".$request->F_php;
         $houseexp->save();
      }
      foreach ($request->name as $key => $u) {
        $family = new Mssfamily();
          if ($request->name[$key] != "") {
          $family->patient_id = $request->patients_id;
          $family->name = $request->name[$key];
          $family->age = $request->age[$key];
          $family->status = $request->status[$key];
          $family->relationship = $request->relationship[$key];
          $family->feducation = $request->feducation[$key];
          $family->foccupation = $request->foccupation[$key];
          $family->fincome = $request->fincome[$key];
          $family->save();
          }
      }
      $request->session()->flash('toaster', array('success', 'Patient Classification Saved'));
      return view('mss.scan');
    }




    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $view = DB::table('patients')
            ->leftJoin('mssclassification', 'mssclassification.patients_id', '=', 'patients.id')
            ->leftJoin('mssdiagnosis', 'mssclassification.id', '=', 'mssdiagnosis.classification_id')
            ->leftJoin('mssexpenses', 'mssclassification.id', '=', 'mssexpenses.classification_id')
            ->leftJoin('msshouseexpenses', 'mssclassification.id', '=', 'msshouseexpenses.classification_id')
            ->leftJoin('mss', 'mssclassification.mss_id', '=', 'mss.id')
            ->where('mssclassification.id', '=', $id)
            ->get()
            ->first();
      $family = Mssfamily::where('patient_id', $view->patients_id)->get();
      $mss = DB::select("SELECT * FROM mss WHERE id NOT IN(10,11,12,13)");
      $ids = $id;

      return view('mss.edit', compact('view', 'family', 'mss', 'ids'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $old_mss = $mssclassification->mss_id;
      $request->request->add(['classification_id' => $id]);
      $mssclassification = Mssclassification::find($id);
      // dd(Carbon::now()->format('Y-m-d H:i:s'));
      if ($mssclassification->validity < Carbon::now()->format('Y-m-d')) {
        $batch = Mssbatch::where('patient_id', '=', $mssclassification->patients_id)->orderByDesc('created_at')->first();
        if (!$batch) {
          $batch = new Mssbatch();
        }
        $mssbatch = new Mssbatch();
        $mssbatch->patient_id = $mssclassification->patients_id;
        $mssbatch->users_id = $mssclassification->users_id;
        $mssbatch->mss_id = $mssclassification->mss_id;
        $mssbatch->referral = $mssclassification->referral;
        $mssbatch->sectorial = $mssclassification->sectorial;
        $mssbatch->fourpis = $mssclassification->fourpis;
        $mssbatch->batch_no = ($batch->batch_no + 1);
        $mssbatch->created_at = $mssclassification->created_at;
        $mssbatch->save();
        $date = Carbon::now();
        $request->request->add(['created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        $request->request->add(['validity' => Carbon::parse($date->addYear())->format('Y-m-d')]);
        $request->request->add(['users_id' => Auth::user()->id]);

      }
      
      $mssclassification->fill($request->all());
      $mssclassification->save();
      $mssDiagnosis = Mssdiagnosis::where('classification_id', $id)->get()->first();
      if ($mssDiagnosis) 
      {
        $mssDiagnosis->fill($request->all());
        $mssDiagnosis->save();
      }
      else
      {
        $diagnosis = new Mssdiagnosis();
        $columns = $diagnosis->getColumn();
        $mssDiagnos = false;
        foreach ($columns as $row) {
            if ($request->$row && $row != 'classification_id')
            {
                  $mssDiagnos = true;
            }
        }
        if ($mssDiagnos)
        {
          Mssdiagnosis::create($request->all());
        }
      }
      $Mssexpenses = Mssexpenses::where('classification_id', $id)->get()->first();
      if ($Mssexpenses) 
      {
        $Mssexpenses->fill($request->all());
        $Mssexpenses->save();
      }
      else
      {
        $expenses = new Mssexpenses();
        $excolumns = $expenses->getColumn();
        $mssExpense = false;
        foreach ($excolumns as $row) {
            if ($request->$row && $row != 'classification_id')
            {
                  $mssExpense = true;
            }
        }
        if ($mssExpense)
        {
          Mssexpenses::create($request->all());
        }
      }
      $Msshouseexpenses = Msshouseexpenses::where('classification_id', $id)->get()->first();
      if ($Msshouseexpenses) {
         $Msshouseexpenses->classification_id = $id;
         $Msshouseexpenses->monthly_expenses = $request->monthly_expenses;
         $Msshouseexpenses->monthly_expenditures = $request->monthly_expenditures;
         $Msshouseexpenses->houselot = $request->houselot."-".$request->H_php;
         $Msshouseexpenses->light = $request->light."-".$request->L_php;
         $Msshouseexpenses->water = $request->water."-".$request->W_php;
         $Msshouseexpenses->fuel = $request->fuel."-".$request->F_php;
         $Msshouseexpenses->save();
      }
      else
      {
        if ($request->houselot != "" || $request->light != "" || $request->water != "" || $request->fuel != "") {
         $houseexp = new Msshouseexpenses();
         $houseexp->classification_id = $id;
         $houseexp->monthly_expenses = $request->monthly_expenses;
         $houseexp->monthly_expenditures = $request->monthly_expenditures;
         $houseexp->houselot = $request->houselot."-".$request->H_php;
         $houseexp->light = $request->light."-".$request->L_php;
         $houseexp->water = $request->water."-".$request->W_php;
         $houseexp->fuel = $request->fuel."-".$request->F_php;
         $houseexp->save();
        }
      }
     
      foreach ($request->name as $key => $u) {

          if ($request->id[$key]) {
            //echo "sldjsl";
            $mssfamily = Mssfamily::find($request->id[$key]);
            $mssfamily->patient_id = $request->patients_id;
            $mssfamily->name = $request->name[$key];
            $mssfamily->age = $request->age[$key];
            $mssfamily->status = $request->status[$key];
            $mssfamily->relationship = $request->relationship[$key];
            $mssfamily->feducation = $request->feducation[$key];
            $mssfamily->foccupation = $request->foccupation[$key];
            $mssfamily->fincome = $request->fincome[$key];
            $mssfamily->save();
          }
          else{
            $family = new Mssfamily();
            if ($request->name[$key] != "") {
            $family->patient_id = $request->patients_id;
            $family->name = $request->name[$key];
            $family->age = $request->age[$key];
            $family->status = $request->status[$key];
            $family->relationship = $request->relationship[$key];
            $family->feducation = $request->feducation[$key];
            $family->foccupation = $request->foccupation[$key];
            $family->fincome = $request->fincome[$key];
            $family->save();
            }
          }
      }

       if($old_mss != $request->mss_id){
        $users  = Auth::user();
        $id =Auth::id();
        $sms = DB::table('logs_classification')->insert([
          'patientId' => $request->patients_id,
          'userId' => $id,
          'previousClassificationId' => $old_mss,
          'newClassificationId' => $request->mss_id
        ]);
      }
      $request->session()->flash('toaster', array('success', 'Patient Classification Updated'));
      return redirect('mss');
      

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      

    }

    public function classification(Request $request)
    {
      $patient = Patient::where('barcode', '=', $request->barcode)
                ->orWhere('hospital_no', '=', $request->barcode)->first();
      if ($patient) {
        $check = Mssclassification::where('patients_id', '=', $patient->id)->first();
        if ($check) {
          $view = DB::table('patients')
                ->leftJoin('mssclassification', 'mssclassification.patients_id', '=', 'patients.id')
                ->leftJoin('mssdiagnosis', 'mssclassification.id', '=', 'mssdiagnosis.classification_id')
                ->leftJoin('mssexpenses', 'mssclassification.id', '=', 'mssexpenses.classification_id')
                ->leftJoin('msshouseexpenses', 'mssclassification.id', '=', 'msshouseexpenses.classification_id')
                ->leftJoin('mss', 'mssclassification.mss_id', '=', 'mss.id')
                ->where('mssclassification.id', '=', $check->id)
                ->first();
          $family = Mssfamily::where('patient_id', $view->patients_id)->get();
          $mss = DB::select("SELECT * FROM mss WHERE id NOT IN(10,11,12,13) AND type = 0 AND status = 1");
          $ids = $check->id;
          
          return view('mss.edit', compact('view', 'family', 'mss', 'ids'));
        }else{
          $mss = DB::select("SELECT * FROM mss WHERE id NOT IN(10,11,12,13) AND type = 0 AND status = 1");
          return view('mss.classification', compact('patient', 'mss'));
        }
      }else{
        return redirect()->back()->with('toaster', array('error', 'Patient not found.'));
      }
    }

    public function classified(Request $request)
    {
        $tab = DB::select("SELECT COUNT(*) as counts, b.mss_id, c.* 
                            FROM patients a 
                            LEFT JOIN mssclassification b ON a.id = b.patients_id
                            LEFT JOIN mss c ON b.mss_id = c.id
                            WHERE
                            (CASE 
                                WHEN ? != '' THEN a.last_name LIKE ?
                                WHEN ? THEN a.hospital_no LIKE ?
                                WHEN ? != '' THEN a.first_name LIKE ?
                                WHEN ? != '' THEN DATE(b.created_at) = ?
                                WHEN ? != '' THEN CONCAT(a.hospital_no,' ',a.last_name,' ',a.first_name,' ',a.middle_name) LIKE ?
                                ELSE DATE(b.created_at) = CURRENT_DATE() 
                            END)
                            GROUP BY b.mss_id
                            ORDER BY b.id DESC"
                            ,[   
                                $request->lname, '%'.$request->lname.'%', 
                                $request->hospital_no, '%'.$request->hospital_no.'%', 
                                $request->fname, '%'.$request->fname.'%',
                                $request->datereg, $request->datereg,
                                $request->patient, '%'.$request->patient.'%',
                            ]);
        $classified = DB::select("SELECT 
                                b.mswd,
                                a.hospital_no,
                                b.created_at,
                                a.last_name,
                                a.first_name,
                                a.middle_name,
                                a.birthday,
                                a.sex as gender,
                                c.citymunDesc,
                                d.brgyDesc,
                                b.category,
                                CONCAT(e.label,'-',e.description) as mss, 
                                b.sectorial,
                                CONCAT(f.last_name, ' ',f.first_name) as users,
                                b.id,
                                b.referral,
                                b.philhealth,
                                b.membership,
                                b.validity,
                                a.id as patient_id
                            FROM patients a
                            LEFT JOIN mssclassification b ON a.id = b.patients_id
                            LEFT JOIN refcitymun c ON a.city_municipality = c.citymunCode
                            LEFT JOIN refbrgy d ON a.brgy = d.id
                            LEFT JOIN mss e ON b.mss_id = e.id
                            LEFT JOIN users f ON b.users_id = f.id
                            WHERE
                            (CASE 
                                WHEN ? != '' THEN a.last_name LIKE ?
                                WHEN ? THEN a.hospital_no LIKE ?
                                WHEN ? != '' THEN a.first_name LIKE ?
                                WHEN ? != '' THEN DATE(b.created_at) = ?
                                WHEN ? != '' THEN CONCAT(a.hospital_no,' ',a.last_name,' ',a.first_name,' ',a.middle_name) LIKE ?
                                ELSE DATE(b.created_at) = CURRENT_DATE() 
                            END)
                            AND
                            (CASE 
                              WHEN ? THEN b.mss_id = ? 
                              WHEN ? = 'UNCLASSIFIED' THEN b.mss_id is null 
                              ELSE a.id = a.id
                            END)
                            ORDER BY (CASE WHEN b.id THEN b.id ELSE a.id END)  DESC
                            LIMIT 500"
                            ,[   
                                $request->lname, '%'.$request->lname.'%', 
                                $request->hospital_no, '%'.$request->hospital_no.'%', 
                                $request->fname, '%'.$request->fname.'%',
                                $request->datereg, $request->datereg,
                                $request->patient, '%'.$request->patient.'%',
                                $request->id,  $request->id ,
                                $request->id 
                            ]);
        return view('mss.classified', compact('classified', 'request', 'tab'));
    }
    public function classifiedbyday(Request $request)
    {
      $date = $request->date;
      $classified = DB::select("SELECT b.hospital_no, CONCAT(b.last_name,' ',b.first_name, ' ',b.middle_name) as patient,
                    b.address, b.birthday, b.sex, CONCAT(d.label,'-',d.description) as mss, 
                    CONCAT(c.last_name, ' ',c.first_name, ' ',c.middle_name) as users,
                    a.id,
                    a.created_at,
                    a.referral
                    FROM mssclassification a 
                    LEFT JOIN patients b ON a.patients_id = b.id 
                    LEFT JOIN users c ON a.users_id = c.id
                    LEFT JOIN mss d ON a.mss_id = d.id
                    WHERE DATE(a.created_at) = ?
                    ", [$request->date]);

      if ($classified != '[]'){
        Session::flash('toaster', array('success', 'Matching Records Found.'));
        return view('mss.classified', compact('classified', 'date'));
      }else{
        Session::flash('toaster', array('error', 'No Matching Records Found.'));
        return view('mss.classified', compact('classified', 'date'));
      }
      
    }
    public function view($id)
    {
      $view = DB::table('mssclassification')
            ->leftJoin('patients', 'mssclassification.patients_id', '=', 'patients.id')
            ->leftJoin('mssdiagnosis', 'mssclassification.id', '=', 'mssdiagnosis.classification_id')
            ->leftJoin('mssexpenses', 'mssclassification.id', '=', 'mssexpenses.classification_id')
            ->leftJoin('msshouseexpenses', 'mssclassification.id', '=', 'msshouseexpenses.classification_id')
            ->leftJoin('mss', 'mssclassification.mss_id', '=', 'mss.id')
            ->where('mssclassification.id', '=', $id)
            ->get()
            ->first();

      $family = Mssfamily::where('patient_id', $view->patients_id)->get();
      
      return view('mss.view', compact('view', 'family'));
    }
    public function search(Request $request)
    {
        if($request->name){
            $patients = DB::table('patients')
                        ->select('*')
                        ->leftjoin('mssclassification', 'patients.id', '=', 'mssclassification.patients_id' )
                        ->leftjoin('mss', 'mssclassification.mss_id', '=', 'mss.id')
                        ->where(DB::raw("CONCAT(first_name,' ',middle_name,' ',last_name)"), 'like', '%'.$request->name.'%')
                        ->get();
        }elseif ($request->birthday) {
            $patients = Patient::where('birthday', 'like', $request->birthday.'%')
            ->leftjoin('mssclassification', 'patients.id', '=', 'mssclassification.patients_id' )
            ->leftjoin('mss', 'mssclassification.mss_id', '=', 'mss.id')
            ->get();
        }elseif ($request->barcode) {
            $patients = Patient::where('barcode', 'like', '%'.$request->barcode.'%')
            ->leftjoin('mssclassification', 'patients.id', '=', 'mssclassification.patients_id' )
            ->leftjoin('mss', 'mssclassification.mss_id', '=', 'mss.id')
            ->get();
        }elseif ($request->hospital_no) {
            $patients = Patient::where('hospital_no', 'like', '%'.$request->hospital_no.'%')
            ->leftjoin('mssclassification', 'patients.id', '=', 'mssclassification.patients_id' )
            ->leftjoin('mss', 'mssclassification.mss_id', '=', 'mss.id')
            ->get();
        }elseif ($request->created_at) {
            $patients = Patient::where('patients.created_at', 'like', $request->created_at.'%')
            ->leftjoin('mssclassification', 'patients.id', '=', 'mssclassification.patients_id' )
            ->leftjoin('mss', 'mssclassification.mss_id', '=', 'mss.id')
            ->get();
        }
        if (isset($patients) && count($patients) > 0) {
            Session::flash('toaster', array('success', 'Matching Records Found.'));
            return view('mss.searchpatient', compact('patients'));
        }
        Session::flash('toaster', array('error', 'No Matching Records Found.'));
        return view('mss.searchpatient');
        
    }
    public function report()
    {
      $employee = DB::select("SELECT * FROM `users` 
                                WHERE `role` = 2 
                                AND `activated` = 'Y'
                                AND id NOT IN(136)
                              ");
      return view('mss.report', compact('employee'));
    }
    public function genaratedreport(Request $request)
    {
      if ($request->type == 1) {
        $employee = User::find($request->users_id);
        return view('mss.generatedreport', ['controller' => $this], compact('request', 'employee'));
      }elseif ($request->type == 2) {
        $data = DB::select("SELECT 
                                b.mswd,
                                a.hospital_no,
                                b.created_at,
                                a.last_name,
                                a.first_name,
                                a.middle_name,
                                a.birthday,
                                a.sex as gender,
                                c.citymunDesc,
                                d.brgyDesc,
                                b.category,
                                CONCAT(e.label,'-',e.description) as mss, 
                                b.sectorial,
                                CONCAT(f.last_name, ' ',f.first_name) as users,
                                b.referral,
                                b.philhealth,
                                b.membership,
                                b.validity
                            FROM patients a
                            LEFT JOIN mssclassification b ON a.id = b.patients_id
                            LEFT JOIN refcitymun c ON a.city_municipality = c.citymunCode
                            LEFT JOIN refbrgy d ON a.brgy = d.id
                            LEFT JOIN mss e ON b.mss_id = e.id
                            LEFT JOIN users f ON b.users_id = f.id
                            WHERE b.id IS NOT NULL
                            AND b.users_id = (CASE WHEN ? = 'ALL' THEN b.users_id ELSE ? END)
                            AND DATE(b.created_at) BETWEEN ? AND ?
                            ORDER BY b.id ASC
                            "
                          ,[   
                            $request->users_id, 
                            $request->users_id, 
                            $request->from, 
                            $request->to,
                          ]);
        return view('mss.classifiedreport', compact('data'));
      }elseif ($request->type == 3) {
        $data = DB::select("SELECT 
                                CONCAT(b.label,' - ',b.description) as sponsor,
                                c.hospital_no,
                                c.last_name, c.first_name, c.middle_name,
                                c.sex,
                                c.birthday,
                                d.citymunDesc, e.brgyDesc,
                                g.category,
                                GROUP_CONCAT(f.sub_category) as sub_category,
                                SUM(a.qty * a.price) as amount,
                                SUM(a.discount) as discount,
                                a.created_at AS created_at,
                                h.last_name as user_lname, h.first_name as user_fname, h.middle_name as user_mname
                            FROM cashincome a
                            LEFT JOIN mss b ON a.mss_id = b.id
                            LEFT JOIN patients c ON a.patients_id = c.id
                            LEFT JOIN refcitymun d ON c.city_municipality = d.citymunCode
                            LEFT JOIN refbrgy e ON c.brgy = e.id
                            LEFT JOIN cashincomesubcategory f ON a.category_id = f.id 
                            LEFT JOIN cashincomecategory g ON f.cashincomecategory_id = g.id
                            LEFT JOIN users h ON a.users_id = h.id
                            WHERE b.type = 1
                            AND a.users_id = ?
                            AND DATE(a.created_at) BETWEEN ? AND ?
                            GROUP BY a.patients_id, a.mss_id, g.id, a.users_id, DATE(a.created_at)
                            UNION ALL
                            SELECT 
                              CONCAT(b.label,' - ',b.description) as sponsor,
                                e.hospital_no,
                                e.last_name, e.first_name, e.middle_name,
                                e.sex,
                                e.birthday,
                                f.citymunDesc, g.brgyDesc,
                                CONCAT('LAB-',i.name) as category,
                                GROUP_CONCAT(h.name) as sub_category,
                                SUM(c.qty * a.price) as amount,
                                SUM(a.discount) as discount,
                                a.created_at AS created_at,
                                j.last_name as user_lname, j.first_name as user_fname, j.middle_name as user_mname
                            FROM laboratory_payment a 
                            LEFT JOIN mss b ON a.mss_id = b.id
                            LEFT JOIN laboratory_requests c ON a.laboratory_request_id = c.id
                            LEFT JOIN laboratory_request_groups d ON c.laboratory_request_group_id = d.id
                            LEFT JOIN patients e ON d.patient_id = e.id
                            LEFT JOIN refcitymun f ON e.city_municipality = f.citymunCode
                            LEFT JOIN refbrgy g ON e.brgy = g.id
                            LEFT JOIN laboratory_sub_list h ON c.item_id = h.id
                            LEFT JOIN laboratory_sub i ON h.laboratory_sub_id = i.id
                            LEFT JOIN users j ON a.user_id = j.id
                            WHERE b.type = 1
                            AND a.user_id = ?
                            AND DATE(a.created_at) BETWEEN ? AND ?
                            GROUP BY d.patient_id, a.mss_id, i.id, a.user_id, DATE(a.created_at)
                            ORDER BY created_at ASC
                            ",
                            [
                              $request->users_id,
                              $request->from,
                              $request->to,
                              $request->users_id,
                              $request->from,
                              $request->to
                            ]);
        return view('mss.sponsoredreport', compact('data'));

      }
     
    }
    static function getreferringreport($exref, $users_id, $from, $to)
    {
        $data = DB::select("
              SELECT COUNT(referral) as result 
              FROM `mssclassification`
              WHERE  referral LIKE '$exref%'
              AND 
                (CASE
                  WHEN '$users_id' != 'ALL' THEN users_id = '$users_id' ELSE users_id = users_id 
                END)
              AND DATE(created_at) >= '$from'
              AND DATE(created_at) <= '$to'
              ");
        return $data;

    }
    static function getresultreferringperdistrict($excont, $users_id, $from, $to)
    {
      $data = DB::select("SELECT a.referral, a.mss_id
                                    FROM mssclassification a
                                    LEFT JOIN patients b ON a.patients_id = b.id
                                    LEFT JOIN refcitymun c ON b.city_municipality = c.citymunCode
                                    WHERE
                                    (CASE 
                                        WHEN '$excont' = 08
                                        THEN c.regDesc != 08
                                        ELSE c.id IN($excont)
                                    END) 
                                    AND DATE(a.created_at) 
                                    BETWEEN '$from' AND '$to'
                                    AND 
                                    (CASE 
                                        WHEN '$users_id' = 'ALL' 
                                        THEN a.users_id = a.users_id
                                        ELSE a.users_id = '$users_id'
                                    END)");
    // dd($data);
      return $data;
    }
   static function getplaceoforigin($explo, $users_id, $from, $to)
    {
      $data = DB::select("
              SELECT COUNT(*) as result
              FROM mssclassification a
              LEFT JOIN patients b ON a.patients_id = b.id
              LEFT JOIN refcitymun c ON b.city_municipality = c.citymunCode
              LEFT JOIN refprovince d ON c.provCode = d.provCode

              WHERE (CASE 
                      WHEN '$explo' = 'OUTSIDE R08'
                      THEN d.regCode != 08
                      ELSE  d.provDesc = '$explo'
                    END)
              AND 
                (CASE
                  WHEN '$users_id' != 'ALL' THEN a.users_id = '$users_id' ELSE a.users_id = a.users_id
                END)
              AND DATE(a.created_at) >= '$from' 
              AND DATE(a.created_at) <= '$to' 
              -- GROUP BY d.provDesc
              ");
      return $data;
    }
    static function getpatcategoryreport($excat, $users_id, $from, $to)
    {
      $data = DB::select("
              SELECT COUNT(category) as result 
              FROM `mssclassification` 
              WHERE category = '$excat' 
              AND 
                (CASE
                  WHEN '$users_id' != 'ALL' THEN users_id = '$users_id' ELSE users_id = users_id 
                END)
              AND DATE(created_at) >= '$from' 
              AND DATE(created_at) <= '$to'
              ");
      return $data;
    }
    static function getpatfuorpsreport($users_id, $from, $to)
    {
      $data = DB::select("
              SELECT fourpis, COUNT(fourpis) as result 
              FROM `mssclassification`
              WHERE
                (CASE
                  WHEN '$users_id' != 'ALL' THEN users_id = '$users_id' ELSE users_id = users_id 
                END) 
              AND DATE(created_at) >= '$from' 
              AND DATE(created_at) <= '$to' 
              GROUP BY(fourpis)");
      return $data;
    }
    static function getsectorialreport($exsect, $users_id, $from, $to)
    {
      $data = DB::select("
            SELECT COUNT(sectorial) as result 
            FROM `mssclassification`
            WHERE  
              (CASE 
                WHEN '$exsect' LIKE '%OTHERS%' THEN sectorial LIKE '%OTHERS%' ELSE sectorial = '$exsect'
              END) 
            AND 
              (CASE
                WHEN '$users_id' != 'ALL' THEN users_id = '$users_id' ELSE users_id = users_id 
              END)
            AND DATE(created_at) >= '$from'
            AND DATE(created_at) <= '$to'
            ");
      return $data;
    }
    static function getclassificationreport($users_id, $from, $to)
    {
      $data = DB::select("
            SELECT b.id, CONCAT(b.label, '-', b.description) as descs,
            (CASE WHEN COUNT(a.mss_id) <= 0 THEN '0' WHEN COUNT(a.mss_id) > 0 THEN COUNT(a.mss_id) END)  as classification_count
            FROM mss b
            LEFT JOIN mssclassification a ON a.mss_id = b.id
            AND 
              (CASE
                WHEN '$users_id' != 'ALL' THEN a.users_id = '$users_id' ELSE a.users_id = a.users_id 
              END) 
            AND DATE(a.created_at) >= '$from' 
            AND DATE(a.created_at) <= '$to'
            WHERE b.id NOT IN(14,15) 
            GROUP BY b.id, b.label, b.description
            ");
      return $data;
    }
    static function getresultperdistrict($excont, $users_id, $from, $to)
    {
      $data = DB::select("
            SELECT COUNT(*) as result
            FROM mssclassification a
            LEFT JOIN patients b ON a.patients_id = b.id
            LEFT JOIN refcitymun c ON b.city_municipality = c.citymunCode
            WHERE
              (CASE
                WHEN '$excont' = '08' THEN c.regDesc != '$excont' ELSE c.id IN($excont) 
              END) 
            AND 
              (CASE
              WHEN '$users_id' != 'ALL' THEN a.users_id = '$users_id' ELSE a.users_id = a.users_id 
            END)
            AND DATE(a.created_at) >= '$from' 
            AND DATE(a.created_at) <= '$to'
            AND a.mss_id IN(10,11,12,13)
            ");
      return $data;
    }
    
    public function migrate()
    {

     /*===============================================================================================================================*/
      $data = DB::select("SELECT * FROM mss.tbl_patient_classification WHERE patient_classification_id > 24062
              AND patient_classification_id NOT IN(24063) ORDER BY patient_classification_id  ASC
                ");
     

      foreach ($data as $list) {
        if ($list->patient_gender == 'FEMININE') {
          $patient_gender = 'F'; 
        }
        else{
          $patient_gender = 'M';  
        }
        if ($list->living_arrangement == 'owned') {
          $living_arrangement = 'O';
        }elseif ($list->living_arrangement == 'rented') {
          $living_arrangement = 'R';
        }elseif ($list->living_arrangement == 'shared') {
           $living_arrangement = 'S';
        
        }elseif ($list->living_arrangement == 'institution') {
           $living_arrangement = 'I';
        
        }elseif ($list->living_arrangement == 'homeless') {
           $living_arrangement = 'H';
        }
        elseif ($list->living_arrangement == ' ') {
           $living_arrangement = ' ';
        }
        if ($list->patient_category == 'old') {
            $patient_category = 'O';
        }elseif ($list->patient_category == 'new') {
            $patient_category = 'N';
        }
        elseif ($list->patient_category == 'close') {
            $patient_category = 'C';
        }
        if ($list->fourps == 'yes') {
          $fourps = 'Y';
        }
        else{
          $fourps = 'N';
        }
         $one = DB::insert("
          INSERT INTO opd.mssclassification (`id`,`patients_id`,`users_id`,`mss_id`,`mswd`, `referral`,`gender`, `civil_statuss`,`living_arrangement`,`education`,`occupation`,`category`,`fourpis`,`sectorial`,`household`,`duration`,`philhealth`,`membership`,`validity`,`created_at`,`updated_at`) VALUES 
          ('$list->patient_classification_id',
          '$list->patient_id',
          '$list->mss_id',
          '$list->classification_id',
          '$list->mswd_no',
          '".str_replace("'", '', $list->referral)."',
          '".str_replace("'", '', $patient_gender)."',
          '".str_replace("'", '', $list->civil_status)."',
          '".str_replace("'", '', $living_arrangement)."',
          '".str_replace("'", '', $list->educ_atmt)."',
          '".str_replace("'", '', $list->occupation)."',
          '$patient_category',
          '$fourps',
          '$list->sect_membership',
          '".str_replace("'", '', $list->household_size)."',
          '".str_replace("'", '', $list->duration_of_prob)."',
          '$list->philhealth',
          '$list->philhealth_category',
          '$list->classification_validity',
          '$list->date_of_interview',
          '$list->updated_at')");
        
        

         
          $two = DB::insert("
          INSERT INTO `mssdiagnosis`(`classification_id`, `medical`, `admitting`, `previus`, `present`, `final`, `health`, `findings`, `interventions`, `admision`, `planning`, `counseling`, `date_admission`, `companion`, `expinditures`, `insurance`) VALUES 
          ('$list->patient_classification_id',
          '".str_replace("'", '', $list->medical_data)."',
          '".str_replace("'", '', $list->admitting_diag)."',
          '".str_replace("'", '', $list->prev_treatment)."',
          '".str_replace("'", '', $list->pres_treatment)."',
          '".str_replace("'", '', $list->final_diag)."',
          '".str_replace("'", '', $list->health_access)."',
          '".str_replace("'", '', $list->assesment_findings)."',
          '".str_replace("'", '', $list->recommended_intventions)."',
          '".str_replace("'", '', $list->pre_addmission)."',
          '".str_replace("'", '', $list->discharge_planning)."',
          '".str_replace("'", '', $list->counseling)."',
          '".str_replace("'", '', $list->date_of_adm_cons)."',
          '".str_replace("'", '', $list->companion_adm)."',
          '".str_replace("'", '', $list->medical_expenditures)."',
          '".str_replace("'", '', $list->insurance_premium)."')
          ");

          $three = DB::insert("
          INSERT INTO `mssexpenses`(`classification_id`, `referral_addrress`, `referral_telno`, `religion`, `temp_address`, `pob`, `employer`, `income`, `capita_income`, `source_income`, `food`, `educationphp`, `clothing`, `transportation`, `house_help`, `internet`, `cable`, `other_expenses`) VALUES 
          ('$list->patient_classification_id',
          '".str_replace("'", '', $list->referral_address)."',
          '".str_replace("'", '', $list->referral_tel_no)."',
          '".str_replace("'", '', $list->religion)."',
          '".str_replace("'", '', $list->temp_address)."',
          '".str_replace("'", '', $list->place_of_Birth)."',
          '".str_replace("'", '', $list->employer)."',
          '".str_replace("'", '', $list->income)."',
          '".str_replace("'", '', $list->per_capita_income)."',
          '".str_replace("'", '', $list->sources_of_income)."',
          '".str_replace("'", '', $list->food)."',
          '".str_replace("'", '', $list->education)."',
          '".str_replace("'", '', $list->clothing)."',
          '".str_replace("'", '', $list->transportation)."',
          '".str_replace("'", '', $list->house_help)."',
          '".str_replace("'", '', $list->internet)."',
          '".str_replace("'", '', $list->cable)."',
          '".str_replace("'", '', $list->others_expinses)."')
          ");
          $four = DB::insert("
          INSERT INTO `msshouseexpenses`(`classification_id`, `monthly_expenses`, `monthly_expenditures`, `houselot`, `light`, `water`, `fuel`) VALUES 
          ('".str_replace("'", '', $list->patient_classification_id)."',
          '".str_replace("'", '', $list->monthly_expenses)."',
          '".str_replace("'", '', $list->monthly_expenditures)."',
          '".str_replace("'", '', $list->houseandlot)."',
          '".str_replace("'", '', $list->light_source)."',
          '".str_replace("'", '', $list->water_source)."',
          '".str_replace("'", '', $list->fuel_source)."')
          ");
       }
      /*===============================================================================================================================*/
       // $data = DB::select("SELECT * FROM mss.tbl_patient_family WHERE F_id >= 23596 ORDER BY F_id ASC
       //          ");
       // foreach ($data as $list) {
       //   $four = DB::insert("
       //             INSERT INTO `mssfamily`(`patient_id`, `name`, `age`, `status`, `relationship`, `feducation`, `foccupation`, `fincome`) VALUES 
       //             ('$list->patient_id',
       //             '".str_replace("'", '', $list->name)."',
       //             '".str_replace("'", '', $list->age)."',
       //             '$list->civil_status',
       //             '".str_replace("'", '', $list->relationship)."',
       //             '".str_replace("'", '', $list->educational_atmt)."',
       //             '".str_replace("'", '', $list->occupation)."',
       //             '".str_replace("'", '', $list->monthly_income)."')
       //             ");
       // }

        
    }
    public function getpatientdetailsandcharges($patient_id)
    {
        $patient = DB::select("SELECT 
                                b.id,
                                a.hospital_no,
                                a.last_name,
                                a.first_name,
                                a.middle_name,
                                a.birthday,
                                a.sex,
                                c.citymunDesc,
                                d.brgyDesc,
                                e.label,
                                e.description,
                                a.id as patient_id,
                                e.id as mss_id,
                                e.discount
                            FROM patients a
                            LEFT JOIN mssclassification b ON a.id = b.patients_id AND b.validity >= CURRENT_DATE()
                            LEFT JOIN refcitymun c ON a.city_municipality = c.citymunCode
                            LEFT JOIN refbrgy d ON a.brgy = d.id
                            LEFT JOIN mss e ON b.mss_id = e.id
                            WHERE a.id = ?
                            ", [$patient_id]);
        $request = DB::select("SELECT  
                                ('ancillary') as type,
                                a.id as request_id,
                                c.category,
                                b.sub_category,
                                a.created_at as daterequested,
                                (CASE WHEN d.id THEN d.price ELSE b.price END) as price,    
                                (CASE WHEN d.id THEN d.qty ELSE a.qty END) as qty,
                                mss.label,
                                mss.description,
                                mss.discount,
                                gtr.label as guarantor,
                                h.granted_amount,
                                h.created_at as dategranted,
                                d.id as payment_id,
                                d.updated_at as datepaid,
                                d.mss_charge
                            FROM ancillaryrequist a 
                            LEFT JOIN cashincomesubcategory b ON a.cashincomesubcategory_id = b.id
                            LEFT JOIN cashincomecategory c ON b.cashincomecategory_id = c.id
                            LEFT JOIN cashincome d ON a.id = d.ancillaryrequist_id 
                                        AND d.void = '0'
                                        -- AND (d.mss_charge IS NULL OR d.mss_charge = 2)
                            LEFT JOIN payment_guarantor h ON d.id = h.payment_id 
                                            AND h.type = 0
                            LEFT JOIN mss ON d.mss_id = mss.id
                            LEFT JOIN mss gtr ON h.guarantor_id = gtr.id
                            WHERE a.patients_id = ?
                            UNION ALL
                            SELECT 
                                ('laboratory') as type,
                                j.id as request_id,
                                ('LABORATORY') as category,
                                l.name as sub_category,
                                i.created_at as daterequested,
                                (CASE WHEN k.id THEN k.price ELSE l.price END) as price,
                                j.qty,
                                mss.label,
                                mss.description,
                                mss.discount,
                                gtrb.label as guarantor,
                                p.granted_amount,
                                p.created_at as dategranted,
                                k.id as payment_id,
                                k.created_at as datepaid,
                                k.mss_charge
                            FROM laboratory_request_groups i
                            LEFT JOIN laboratory_requests j ON i.id = j.laboratory_request_group_id
                            LEFT JOIN laboratory_payment k ON j.id = k.laboratory_request_id
                                            AND k.void = 0 
                                            AND k.dbnp IS NULL
                                            -- AND (k.mss_charge IS NULL OR k.mss_charge = 2)
                            LEFT JOIN laboratory_sub_list l ON j.item_id = l.id
                            LEFT JOIN payment_guarantor p ON k.id = p.payment_id
                                          AND p.type = 1
                            LEFT JOIN mss ON k.mss_id = mss.id
                            LEFT JOIN mss gtrb ON p.guarantor_id = gtrb.id
                            WHERE i.patient_id = ?
                            AND j.status != 'Removed'
                            ORDER BY daterequested ASC, request_id ASC
                              ", [$patient_id, $patient_id]);
        $sponsors = Mss::where('type', '=', 1)
                        ->get();
        $mss_sponsors_implode = [];
        foreach ($sponsors as $mss_sponsor) {
          $mss_sponsors_implode[] = $mss_sponsor->id;
        }
      echo json_encode(['patient' => $patient[0], 'request' => $request, 'sponsors' => $sponsors, 'mss_sponsors' => $mss_sponsors_implode]);
      return;
    }
    public function pushtopaid(Request $request)
    {
      $modifier = Str::random(20);
      if (count($request->mss_id) > 0) {
        foreach ($request->mss_id as $key => $value) {
            if ($request->type[$key] == 'ancillary') {
                if ($request->income_id[$key] != "null") {
                    $Cashincome = Cashincome::find($request->income_id[$key]);
                    
                }else{
                    $Cashincome = new Cashincome();
                    $Cashincome->users_id = Auth::user()->id;
                    $Cashincome->patients_id = $request->patient_id;
                    $Cashincome->ancillaryrequist_id = $request->request_id[$key]; 
                    $Cashincome->category_id =  
                    $Cashincome->price = $request->price[$key];
                    $Cashincome->qty = $request->qty[$key]; 
                    $Cashincome->discount = $request->price[$key] * $request->qty[$key]; 
                }
                if ($request->mss_id[$key] == "") {
                    $Cashincome->delete();
                }else{
                    $Cashincome->mss_id = $request->mss_id[$key];  
                    $Cashincome->or_no = $modifier;
                    $Cashincome->save();
                }
                
            }elseif ($request->type[$key] == "laboratory") {
                if ($request->income_id[$key] != "null") {
                    $LaboratoryPayment = LaboratoryPayment::find($request->income_id[$key]);
                    
                }else{
                    $LaboratoryPayment = new LaboratoryPayment();
                    $LaboratoryPayment->user_id =  Auth::user()->id;
                    $LaboratoryPayment->laboratory_request_id = $request->request_id[$key]; 
                    $LaboratoryPayment->price = $request->price[$key];
                    $LaboratoryPayment->discount = $request->price[$key] * $request->qty[$key]; 
                }
                if ($request->mss_id[$key] == "") {
                    $LaboratoryPayment->delete();
                }else{
                    $LaboratoryPayment->mss_id = $request->mss_id[$key];  
                    $LaboratoryPayment->or_no = $modifier;
                    $LaboratoryPayment->save();
                }
            }
        }
      }
      echo json_encode($modifier);
      return;
    }

    public function lockthistransaction($id, $type)
    {
      $MssLockTransaction = MssLockTransaction::where('transaction_type', '=', $type)
                                              ->where('transaction_id', '=', $id)
                                              ->first();
      if (!$MssLockTransaction) {
        $MssLockTransaction = new MssLockTransaction();
        $MssLockTransaction->transaction_type = $type;
        $MssLockTransaction->transaction_id = $id;
        $MssLockTransaction->save();
      }
      echo json_encode($MssLockTransaction);
      return;
    }
    public function sponsors()
    {
      $data = Mss::orderBy('id', 'ASC')->get();
      return view('mss.sponsors', compact('data'));
      # code...
    }
    public function getallcheckcharges(Request $request)
    {
      // $array_request = array_combine($request->id, $request->type);
      $laboratory = [];
      $ancillary = [];
      foreach ($request->type as $index => $value) {
        if ($request->type[$index] == 'laboratory') {
          array_push($laboratory, (int)$request->id[$index]);
        }
        if ($request->type[$index] == 'ancillary') {
          array_push($ancillary, (int)$request->id[$index]);
        }
      }
      if (count($ancillary) > 0) {
        $ancillary = implode(',', $ancillary);
      }else{
        $ancillary = 'null';
      }
      if (count($laboratory) > 0) {
        $laboratory = implode(',', $laboratory);
      }else{
        $laboratory = 'null';
      }

      $requests = DB::select("SELECT  
                              ('ancillary') as type,
                              a.id as request_id,
                              c.category,
                              b.sub_category,
                              (CASE WHEN d.id THEN d.price ELSE b.price END) as price,    
                              (CASE WHEN d.id THEN d.qty ELSE a.qty END) as qty,
                              a.created_at as daterequested,
                              b.id as item_id,
                              d.mss_id,
                              d.discount,
                              e.guarantor_id,
                              e.granted_amount,
                              e.id as payment_guarantor_id
                          FROM ancillaryrequist a 
                          LEFT JOIN cashincomesubcategory b ON a.cashincomesubcategory_id = b.id
                          LEFT JOIN cashincomecategory c ON b.cashincomecategory_id = c.id
                          LEFT JOIN cashincome d ON a.id = d.ancillaryrequist_id 
                                      AND d.void = '0'
                                      AND d.mss_charge = 1
                          LEFT JOIN payment_guarantor e ON d.id = e.payment_id AND e.type = 0
                          WHERE (CASE WHEN ? != 'null' THEN (a.id IN($ancillary)) ELSE (a.id IS NULL) END)
                          UNION
                          SELECT 
                              ('laboratory') as type,
                              j.id as request_id,
                              ('LABORATORY') as category,
                              l.name as sub_category,
                              (CASE WHEN k.id THEN k.price ELSE l.price END) as price,
                              j.qty,
                              i.created_at as daterequested,
                              l.id as item_id,
                              k.mss_id,
                              k.discount,
                              m.guarantor_id,
                              m.granted_amount,
                              m.id as payment_guarantor_id
                          FROM laboratory_request_groups i
                          LEFT JOIN laboratory_requests j ON i.id = j.laboratory_request_group_id
                          LEFT JOIN laboratory_payment k ON j.id = k.laboratory_request_id
                                          AND k.void = 0 
                                          AND k.mss_charge = 1
                          LEFT JOIN laboratory_sub_list l ON j.item_id = l.id
                          LEFT JOIN payment_guarantor m ON k.id = m.payment_id AND m.type = 1
                          WHERE (CASE WHEN ? != 'null' THEN (j.id IN($laboratory)) ELSE (i.id IS NULL) END)
                          ORDER BY daterequested ASC, request_id ASC
                            ", [$ancillary, $laboratory]);
      $classification = Mss::where('type', '=', 0)->get();
      $guarantor = Mss::where('type', '=', 1)->get();
      echo json_encode(['requests' => $requests, 'classification' => $classification, 'guarantor' => $guarantor]);
      return;
    }
}