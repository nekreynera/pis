<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mssdiagnosis extends Model
{
	protected $table = "mssdiagnosis";

    protected $fillable = [
        'classification_id', 'medical', 'admitting', 'previus','present','final','health',
        'findings','interventions','admision','planning','counseling','date_admission',
        'companion','expinditures','insurance'
    ];
    public $timestamps = false;

    public function getColumn(){
      return $this->fillable;
    }
}
