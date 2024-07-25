<?php

namespace App\Providers;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use App\Patient;
use App\Consultation;
use App\Requisition;
use App\Refferal;
use App\Followup;
use App\VitalSigns;
use App\MedInterns;
use App\Approval;
use Carbon;
use App\User;
use DB;
use Auth;
use Session;

class RecordsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('doctors.dashboard', function($view)
        {
            $pid = session('pid', '0');
            $view->with('history', DB::select("SELECT pt.id, CONCAT(pt.last_name,', ',pt.first_name,' ',CASE WHEN pt.suffix IS NOT NULL THEN pt.suffix ELSE '' END,' ',CASE WHEN pt.middle_name IS NOT NULL THEN LEFT(pt.middle_name, 1) ELSE '' END) as name, C.consultations, R.refferals, F.followups, COUNT(RQ.requisitions) as requisitions, D.diagnosis FROM patients pt
                    LEFT JOIN (SELECT consultations.patients_id, COUNT(*) AS consultations FROM consultations GROUP BY consultations.patients_id)
                    as C ON pt.id = C.patients_id
                    LEFT JOIN (SELECT refferals.patients_id, COUNT(*) AS refferals FROM refferals GROUP BY refferals.patients_id)
                    as R ON pt.id = R.patients_id
                    LEFT JOIN (SELECT followup.patients_id, COUNT(*) AS followups FROM followup GROUP BY followup.patients_id)
                    as F ON pt.id = F.patients_id
                    LEFT JOIN (SELECT requisition.patients_id, COUNT(*) AS requisitions FROM requisition GROUP BY requisition.patients_id, DATE(requisition.created_at))
                    as RQ ON pt.id = RQ.patients_id
                    LEFT JOIN (SELECT diagnosis.patients_id, COUNT(*) AS diagnosis FROM diagnosis GROUP BY diagnosis.patients_id)
                    as D ON pt.id = D.patients_id
                    WHERE pt.id = $pid"));


                $view->with('refferals', Refferal::select('refferals.*', 'clinics.name', DB::raw("CONCAT(CASE WHEN us.last_name IS NOT NULL THEN us.last_name ELSE '' END,' ',LEFT(us.middle_name, 1),'.',' ',CASE WHEN us.first_name IS NOT NULL THEN us.first_name ELSE '' END) as doctorsname"))
                            ->where('patients_id', '=', $pid)
                            ->where('to_clinic', '=', Auth::user()->clinic)
                            ->where('status', '=', 'P')
                            ->leftJoin('users as us', 'us.id', '=', 'assignedTo')
                            ->leftJoin('clinics', function ($join){
                                $join->on('clinics.id', '=', 'refferals.to_clinic');
                            })->get());

                $view->with('followups', Followup::select('followup.*', 'clinics.name', DB::raw("CONCAT(CASE WHEN us.last_name IS NOT NULL THEN us.last_name ELSE '' END,' ',LEFT(us.middle_name, 1),'.',' ',CASE WHEN us.first_name IS NOT NULL THEN us.first_name ELSE '' END) as doctorsname"))
                            ->where('patients_id', '=', $pid)
                            ->where('status', '=', 'P')
                            ->where('clinic_code', '=', Auth::user()->clinic)
                            ->leftJoin('users as us', 'us.id', '=', 'assignedTo')
                            ->leftJoin('clinics', 'clinics.id', '=', 'followup.clinic_code')
                            ->get());

                $view->with('vital_signs', VitalSigns::where('patients_id', '=', $pid)->whereDate('created_at', Carbon::now()->format('Y-m-d'))->latest()->get());



        });

        view()->composer('doctors.patientlist', function($view)
        {
          $view->with('intern', MedInterns::checkIfIntern());
          if ($view->intern) {
            $view->with('allDoctors', DB::select("SELECT id, 
                                                      CONCAT(first_name,' ',CASE WHEN middle_name is not null THEN LEFT(middle_name, 1) ELSE '' END,'. ', last_name) as name 
                                                  FROM `users` 
                                                  WHERE `clinic` = ? 
                                                  AND role = 7
                                                  AND id NOT IN(139)
                                                  AND id NOT IN(SELECT interns_id FROM med_interns) 
                                                  ORDER BY `name` ASC", 
                                                  [Auth::user()->clinic]));
          }else{
              $view->with('allDoctors', null);
          }
        });


        view()->composer('doctors.navigation', function($view)
        {
          $view->with('checkIfSeniorDoctor', Approval::where('approved_by', '=', Auth::user()->id)
                                                      ->groupBy('patients_id')
                                                      ->whereDate('created_at', '=', Carbon::now()->toDateString())->get());
        });






    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
