<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Session;

class Mss extends Model
{
	protected $table = "mss";

    protected $fillable = [
        'label', 'description', 'discount', 'type', 'status'
    ];

    public $timestamps = false;
    
    public static function checkClassification()
    {
        $pid = Session::get('pid');
        $mssClassification = Mssclassification::where('patients_id', '=', $pid)
                            ->leftJoin('mss', 'mss.id', '=', 'mssclassification.mss_id')
                            ->select('mss.label', 'mss.description', 'mss.discount')
                            ->first();
        return $mssClassification;
    }
}
