<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Triage extends Model
{
	protected $table = "triage";

    protected $fillable = [
        'patients_id', 'users_id', 'clinic_code', 'finished'
    ];

    public function getColumn(){
      return $this->fillable;
    }
    

}
