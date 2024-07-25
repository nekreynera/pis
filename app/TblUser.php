<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TblUser extends Model
{
    protected $table = "tbl_user";

    protected $fillable = [
        'username', 'password', 'code_clinic', 'first_name', 'last_name', 'middle_name', 'user_type', 'date_reg', 'status', 'status_time'
    ];

    public $timestamps = false;

}
