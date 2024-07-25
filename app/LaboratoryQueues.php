<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use App\Patient;
use Carbon;
use DB;

class LaboratoryQueues extends Model
{
    protected $table = "laboratory_queues";

    protected $fillable = [
        'user_id', 'patient_id', 'status',
    ];
    static function patient($status){
    	$data = DB::table('laboratory_queues')
    				->leftJoin('patients', 'laboratory_queues.patient_id', '=', 'patients.id')
    				->whereDate('laboratory_queues.created_at', '=', Carbon::now()->format('Y-m-d'))
                    ->where('laboratory_queues.status', '=', $status)
    				->select(
    							'patients.id',
    							'patients.hospital_no',
    							'patients.last_name',
    							'patients.first_name',
    							'patients.middle_name',
    							'patients.birthday',
    							'patients.sex',
    							'laboratory_queues.created_at',
                                'laboratory_queues.status'
    						)
                    ->orderBy('laboratory_queues.created_at', 'ASC')
    				->get();
    	return $data;
    }
    static function patientstoday()
    {
        $data = DB::table('laboratory_queues')
                ->leftJoin('patients', 'laboratory_queues.patient_id', '=', 'patients.id')
                ->whereDate('laboratory_queues.created_at', '=', Carbon::now()->format('Y-m-d'))
                ->select(
                            'patients.id',
                            'patients.hospital_no',
                            'patients.walkin',
                            'patients.last_name',
                            'patients.first_name',
                            'patients.middle_name',
                            'patients.birthday',
                            'patients.sex',
                            'laboratory_queues.created_at',
                            'laboratory_queues.status'
                        )
                ->orderBy('laboratory_queues.created_at', 'ASC')
                ->get();
    return $data;
    }
    static function search($request)
    {
        $data = DB::select("SELECT b.id,
                                    b.hospital_no,
                                    b.last_name,
                                    b.first_name,
                                    b.middle_name,
                                    b.birthday,
                                    b.sex,
                                    a.created_at,
                                    a.status
                            FROM laboratory_queues a
                            LEFT JOIN patients b ON a.patient_id = b.id
                            WHERE DATE(a.created_at) = CURRENT_DATE()
                            AND
                                (CASE 
                                    WHEN ? != '' THEN b.last_name LIKE ?
                                    WHEN ? THEN b.hospital_no LIKE ?
                                    WHEN ? != '' THEN b.first_name LIKE ?
                                    WHEN ? != '' THEN CONCAT(b.hospital_no,' ',b.last_name,' ',b.first_name,' ',b.middle_name) LIKE ?
                                END)
                            ORDER BY a.created_at ASC
                            ",[
                                $request->lname, '%'.$request->lname.'%', 
                                $request->hospital_no, '%'.$request->hospital_no.'%', 
                                $request->fname, '%'.$request->fname.'%',
                                $request->patient, '%'.$request->patient.'%'
                            ]);
        return $data;
    }
    static function export(){
        $data = DB::table('laboratory_queues')
                    ->leftJoin('patients', 'laboratory_queues.patient_id', '=', 'patients.id')
                    // ->leftJoin('refbrgy', 'patients.brgy', '=', 'refbrgy.id')
                    // ->leftJoin('refcitymun', 'patients.city_municipality', '=', 'refcitymun')
                    // ->leftJoin('refprovince', '')
                    ->whereDate('laboratory_queues.created_at', '>=', Carbon::parse($_GET['from'])->format('Y-m-d'))
                    ->whereDate('laboratory_queues.created_at', '<=', Carbon::parse($_GET['to'])->format('Y-m-d'))
                    ->select(
                                'patients.hospital_no',
                                'patients.last_name',
                                'patients.first_name',
                                'patients.middle_name',
                                'patients.birthday',
                                'patients.sex',
                                'patients.civil_status',
                                'patients.created_at',
                                'laboratory_queues.created_at as datetime_queued'
                            )
                    ->orderBy('laboratory_queues.created_at', 'ASC')
                    ->get();
        return $data;
    }

}
