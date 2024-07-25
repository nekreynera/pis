<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class LaboratorySubList extends Model
{
    protected $table = "laboratory_sub_list";

    protected $fillable = [
        'laboratory_sub_id',
        'name',
        'price',
        'status',
    ];
    static function search($list)
    {
    	return DB::table('laboratory_sub_list')
    		->where('name', 'like', '%'.$list.'%')
    		->orderBy('name')
    		->get();
    }

}
