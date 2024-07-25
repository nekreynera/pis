<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cashincomesubcategory extends Model
{
	protected $table = "cashincomesubcategory";

    protected $fillable = [
        'cashincomecategory_id', 'sub_category', 'price', 'status', 'trash', 'type'
    ];
    public $timestamps = false;


}
?>