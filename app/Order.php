<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'voucherno','orderdate','status','note','total','user_id'
    ];

    public function items($value='')
    {
    	return $this->belongsToMany('App\Item','order_detail')//order_detail should be item_order but it addded our customized name
    				->withPivot('qty')
    				->withTimestamps();
    }
}
