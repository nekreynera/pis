<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon;
use DB;

class Regdeletepatients extends Model
{
	protected $table = "regdeletepatients";

    protected $fillable = [
        'first_name', 'middle_name', 'last_name', 'suffix', 'sex', 'birthday', 'age', 'civil_status', 'address', 'city_municipality',
        'brgy', 'contact_no', 'hospital_no', 'barcode', 'printed','users_id'
    ];


}
