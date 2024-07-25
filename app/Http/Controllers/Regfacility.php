<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Regfacility extends Model
{
    protected $table = "regfacility";

    protected $fillable = [
        'municipality', 'hospital', 'address', 'level', 'abc', 'contact_person', 'number', 'email', 'district'
    ];
    public $timestamps = false;

    public function getColumn(){
      return $this->fillable;
    }
}
