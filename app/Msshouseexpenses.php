<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Msshouseexpenses extends Model
{
	protected $table = "msshouseexpenses";

    protected $fillable = [
        'classification_id', 'monthly_expenses', 'monthly_expenditures', 'houselot','light','water','fuel'
    ];
    public $timestamps = false;

    public function getColumn(){
      return $this->fillable;
    }
}
