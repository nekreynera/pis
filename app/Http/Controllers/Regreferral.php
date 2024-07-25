<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Regreferral extends Model
{
    protected $table = "regreferral";

    protected $fillable = [
        'patient_id', 'facility', 'physician', 'reason', 'accompany', 'complaint', 'refclinic', 'area'
    ];

    public function getColumn(){
      return $this->fillable;
    }
}
