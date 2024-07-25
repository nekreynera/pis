<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Regdiagnosis extends Model
{
    protected $table = "regdiagnosis";

    protected $fillable = [
        'diagnosis'
    ];
    public $timestamps = false;

    public function getColumn(){
      return $this->fillable;
    }
}
