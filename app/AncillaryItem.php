<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AncillaryItem extends Model
{
	protected $table = "ancillary_items";

    protected $fillable = [
        'clinic_code', 'item_id', 'brand', 'item_description', 'unitofmeasure', 'price', 'trash'
    ];

}
