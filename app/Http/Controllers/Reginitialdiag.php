<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reginitialdiag extends Model
{
    protected $table = "reginitialdiag";

    protected $fillable = [
        'regreferral_id', 'regdiagonsis_id'
    ];
    public $timestamps = false;

    public function getColumn(){
      return $this->fillable;
    }
}
