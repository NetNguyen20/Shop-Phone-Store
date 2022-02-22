<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $timestamps = false; //set time to false
    protected $fillable = [
    	'product_name', 'product_slug','category_id','brand_id','product_desc','product_content','product_price', 'product_price_cost', 'product_image','product_status'
    ];
    protected $primaryKey = 'product_id';
 	protected $table = 'tbl_product';

     public function comment(){
        return $this->hasMany('App\Models\Comment');
    }

    public function category(){
        return  $this->belongsTo('App\Models\Category','category_id');
    }
}
