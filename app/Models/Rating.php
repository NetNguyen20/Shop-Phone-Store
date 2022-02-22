<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    public $timestamps = false; //set time to false
    protected $fillable = [
    	'rating', 'product_id'
    ];
    protected $primaryKey = 'ratung_id';
 	protected $table = 'tbl_rating';
}
