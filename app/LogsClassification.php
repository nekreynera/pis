<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogsClassification extends Model
{
    protected $table = "logs_classification";
    protected $fillable = [
        'patientId',
        'userId',
        'previousClassificationId',
        'nextClassificationId'
    ];
}
