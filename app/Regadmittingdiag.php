<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Regadmittingdiag extends Model
{
    protected $table = "regadmittingdiag";

    protected $fillable = [
        'regreferral_id', 'regdiagnosis_id'
    ];
    public $timestamps = false;

    public function getColumn(){
      return $this->fillable;
    }
}
