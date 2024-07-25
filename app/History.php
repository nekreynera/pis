<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class History extends Model
{
    public static function records($id)
    {
        $history = DB::select("SELECT pt.id, CONCAT(pt.last_name,', ',pt.first_name,' ',CASE WHEN pt.suffix IS NOT NULL THEN pt.suffix ELSE '' END,' ',CASE WHEN pt.middle_name IS NOT NULL THEN LEFT(pt.middle_name, 1) ELSE '' END) as name, C.consultations, R.refferals, F.followups, COUNT(RQ.requisitions) as requisitions, D.diagnosis FROM patients pt
                    LEFT JOIN (SELECT consultations.patients_id, COUNT(*) AS consultations FROM consultations GROUP BY consultations.patients_id) 
                    as C ON pt.id = C.patients_id
                    LEFT JOIN (SELECT refferals.patients_id, COUNT(*) AS refferals FROM refferals GROUP BY refferals.patients_id) 
                    as R ON pt.id = R.patients_id
                    LEFT JOIN (SELECT followup.patients_id, COUNT(*) AS followups FROM followup GROUP BY followup.patients_id) 
                    as F ON pt.id = F.patients_id
                    LEFT JOIN (SELECT requisition.patients_id, COUNT(*) AS requisitions FROM requisition GROUP BY requisition.patients_id, requisition.modifier, DATE(requisition.created_at)) 
                    as RQ ON pt.id = RQ.patients_id
                    LEFT JOIN (SELECT diagnosis.patients_id, COUNT(*) AS diagnosis FROM diagnosis GROUP BY diagnosis.patients_id) 
                    as D ON pt.id = D.patients_id
                    WHERE pt.id = $id");
        return $history;
    }
}
