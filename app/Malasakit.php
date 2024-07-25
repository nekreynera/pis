<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Malasakit extends Model
{
    protected $table = "malasakit";

    protected $fillable = [
        'classification_id', 'users_id','mlkstinterviewed', 'mlkstrelpatient', 'mlkstaddress', 
        'mlkstcontact', 'mlkstnationality', 'mlkstsectorial', 'mlksttfincome', 'mlkstproblem', 'mlkstassesment'
    ];

    public function getColumn(){
      return $this->fillable;
    }
}
