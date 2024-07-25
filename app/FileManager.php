<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileManager extends Model
{
    protected $table = "files";

    protected $fillable = [
        'consultations_id', 'patients_id', 'filename', 'title', 'description'
    ];
}
