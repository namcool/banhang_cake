<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $table = "products";

    public function Type_products()
    {
    	return $this->belongsTo('App\Type_products','id_type','id');
    }

    public function Bill_detail()
    {
    	return $this->hasMany('Appp\Bill_detail','id_product','id');
    }
}
