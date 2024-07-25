<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TblPatients extends Model
{
    protected $table = "tbl_patient";

    protected $fillable = [
        'first_name', 'middle_name', 'last_name', 'sex', 'birthday', 'age', 'civil_status', 'address',
        'brgy', 'contact_no', 'hospital_no', 'barcode', 'printed'
    ];

    public $timestamps = false;

}
