<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Malasakitfamily extends Model
{
    protected $table = "malasakitfamily";

    protected $fillable = [
        'mssfamily_id', 'birthday', 'sex'
    ];
     public $timestamps = false;

    public function getColumn(){
      return $this->fillable;
    }
}
