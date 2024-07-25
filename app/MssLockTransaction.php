<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MssLockTransaction extends Model
{
	protected $table = "mss_lock_transaction";

    protected $fillable = [
    	'transaction_type',
    	'transaction_id',
    	'created_at',
    ];
    public $timestamps = false;

    public function getColumn(){
      return $this->fillable;
    }
}
