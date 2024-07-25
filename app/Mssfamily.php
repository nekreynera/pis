<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mssfamily extends Model
{
	protected $table = "mssfamily";

    protected $fillable = [
        'patient_id', 'name', 'age', 'status','relationship','feducation','foccupation',
        'fincome'
    ];
    public $timestamps = false;

    public function getColumn(){
      return $this->fillable;
    }
}
