<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Regforreferral extends Model
{
    protected $table = "regforreferral";

    protected $fillable = [
        'patients_id'
    ];

    public function getColumn(){
      return $this->fillable;
    }
}
