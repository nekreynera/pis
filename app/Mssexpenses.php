<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mssexpenses extends Model
{
	protected $table = "mssexpenses";

    protected $fillable = [
        'classification_id', 'referral_addrress', 'referral_telno', 'religion','temp_address','pob','employer',
        'income','capita_income','source_income','food','educationphp','clothing','transportation',
        'house_help','internet','cable','other_expenses'
    ];
    public $timestamps = false;

    public function getColumn(){
      return $this->fillable;
    }
}
